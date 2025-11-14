<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\EstablishmentType;
use App\Http\Requests\EstablishmentTypeRequest;
use App\DataTables\EstablishmentTypeDataTable;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class EstablishmentTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:establishment_types.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:establishment_types.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:establishment_types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:establishment_types.delete', ['only' => ['destroy']]);
        $this->title = trans('establishment_types.establishment_types');
        view()->share('title', $this->title);
    }

    public function index(EstablishmentTypeDataTable $dataTable)
    {
        return $dataTable->render('establishment_types.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('establishment_types.create')->render()
        ]);
    }

    public function store(EstablishmentTypeRequest $request)
    {
        $check_entry = EstablishmentType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('establishment_types.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = EstablishmentType::create($input);

        return redirect()->route('establishment_types.index')->with('success', __('establishment_types.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('establishment_types.edit', $id);
    }

    public function edit($id)
    {
        $this->data['establishment_types'] = EstablishmentType::find($id);
        return response()->json(['html' => view('establishment_types.edit', $this->data)->render()]);
    }

    public function update($id, EstablishmentTypeRequest $request)
    {
        $establishment_types = EstablishmentType::findOrFail($id);
        $input = $request->all();
        $establishment_types->update($input);
        return redirect()->route('establishment_types.index')->with('success', __('establishment_types.update_success'));
    }

    public function destroy($id)
    {
        $establishment_types = EstablishmentType::findOrFail($id);
        if($establishment_types)
        {
            $dependency = $establishment_types->deleteValidate($id);
            if(!$dependency)
            {
                $establishment_types->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('establishment_types.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
