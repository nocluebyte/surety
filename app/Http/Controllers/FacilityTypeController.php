<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\FacilityType;
use App\Http\Requests\FacilityTypeRequest;
use App\DataTables\FacilityTypeDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class FacilityTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:facility_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:facility_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:facility_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:facility_type.delete', ['only' => 'destroy']);
        $this->title = trans('facility_type.facility_type');
        view()->share('title', $this->title);
    }

    public function index(FacilityTypeDataTable $datatable)
    {
        return $datatable->render('facility_type.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('facility_type.create')->render()
        ]);
    }

    public function store(FacilityTypeRequest $request)
    {
        $check_entry = FacilityType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('facility_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = FacilityType::create($input);

        return redirect()->route('facility_type.index')->with('success', __('facility_type.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('facility_type.edit', $id);
    }

    public function edit($id)
    {
        $facility_type = FacilityType::find($id);
        $this->data['facility_type'] = $facility_type;
        return response()->json(['html' => view('facility_type.edit', $this->data)->render()]);
    }

    public function update($id, FacilityTypeRequest $request)
    {
        $facility_type = FacilityType::findOrFail($id);
        $input = $request->all();
        $facility_type->update($input);
        return redirect()->route('facility_type.index')->with('success', __('facility_type.update_success'));
    }

    public function destroy($id)
    {
        $facility_type = FacilityType::findOrFail($id);
        if($facility_type)
        {
            $dependency = $facility_type->deleteValidate($id);
            if(!$dependency)
            {
                $facility_type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('facility_type.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
