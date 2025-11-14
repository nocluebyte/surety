<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Agency;
use App\Http\Requests\AgencyRequest;
use App\DataTables\AgencyDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class AgencyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:agency.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:agency.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:agency.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:agency.delete', ['only' => 'destroy']);
        $this->title = trans('agency.agency');
        view()->share('title', $this->title);
    }

    public function index(AgencyDataTable $datatable)
    {
        return $datatable->render('agency.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('agency.create')->render()
        ]);
    }

    public function store(AgencyRequest $request)
    {
        $check_entry = Agency::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->agency_name == $request['agency_name'])) {
            return redirect()->route('agency.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = Agency::create($input);

        return redirect()->route('agency.index')->with('success', __('agency.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('agency.edit', $id);
    }

    public function edit($id)
    {
        $agency = Agency::find($id);
        $this->data['agency'] = $agency;
        return response()->json(['html' => view('agency.edit', $this->data)->render()]);
    }

    public function update($id, AgencyRequest $request)
    {
        $agency = Agency::findOrFail($id);
        $input = $request->validated();
        $agency->update($input);
        return redirect()->route('agency.index')->with('success', __('agency.update_success'));
    }

    public function destroy($id)
    {
        $agency = Agency::findOrFail($id);
        if($agency)
        {
            $dependency = $agency->deleteValidate($id);
            if(!$dependency)
            {
                $agency->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('agency.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
