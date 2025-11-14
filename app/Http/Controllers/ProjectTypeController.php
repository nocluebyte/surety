<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ProjectType;
use App\Http\Requests\ProjectTypeRequest;
use App\DataTables\ProjectTypeDataTable;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class ProjectTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:project_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:project_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:project_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project_type.delete', ['only' => ['destroy']]);
        $this->title = trans('project_type.project_type');
        view()->share('title', $this->title);
    }

    public function index(ProjectTypeDataTable $datatable)
    {
        return $datatable->render('project_type.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('project_type.create')->render()
        ]);
    }

    public function store(ProjectTypeRequest $request)
    {
        $check_entry = ProjectType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('project_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = ProjectType::create($input);

        return redirect()->route('project_type.index')->with('success', __('project_type.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('project_type.edit', $id);
    }

    public function edit($id)
    {
        $project_type = ProjectType::find($id);
        $this->data['project_type'] = $project_type;
        return response()->json(['html' => view('project_type.edit', $this->data)->render()]);
    }

    public function update($id, ProjectTypeRequest $request)
    {
        $project_type = ProjectType::findOrFail($id);
        $input = $request->all();
        $project_type->update($input);
        return redirect()->route('project_type.index')->with('success', __('project_type.update_success'));
    }

    public function destroy($id)
    {
        $project_type = ProjectType::findOrFail($id);
        if($project_type)
        {
            $dependency = $project_type->deleteValidate($id);
            if(!$dependency)
            {
                $project_type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('project_type.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
