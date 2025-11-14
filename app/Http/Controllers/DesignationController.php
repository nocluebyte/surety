<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Designation;
use App\Http\Requests\DesignationRequest;
use App\DataTables\DesignationDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class DesignationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:designation.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:designation.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:designation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:designation.delete', ['only' => 'destroy']);
        $this->title = trans('designation.designation');
        view()->share('title', $this->title);
    }

    public function index(DesignationDataTable $datatable)
    {
        return $datatable->render('designation.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('designation.create')->render()
        ]);
    }

    public function store(DesignationRequest $request)
    {
        $check_entry = Designation::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('designation.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = Designation::create($input);

        return redirect()->route('designation.index')->with('success', __('designation.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('designation.edit', $id);
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        $this->data['designation'] = $designation;
        return response()->json(['html' => view('designation.edit', $this->data)->render()]);
    }

    public function update($id, DesignationRequest $request)
    {
        $designation = Designation::findOrFail($id);
        $input = $request->all();
        $designation->update($input);
        return redirect()->route('designation.index')->with('success', __('designation.update_success'));
    }

    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        if($designation)
        {
            $dependency = $designation->deleteValidate($id);
            if(!$dependency)
            {
                $designation->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('designation.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
