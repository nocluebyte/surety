<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\WorkType;
use App\Http\Requests\WorkTypeRequest;
use App\DataTables\WorkTypeDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class WorkTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:work_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:work_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:work_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:work_type.delete', ['only' => 'destroy']);
        $this->title = trans('work_type.work_type');
        view()->share('title', $this->title);
    }

    public function index(WorkTypeDataTable $datatable)
    {
        return $datatable->render('work_type.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('work_type.create')->render()
        ]);
    }

    public function store(WorkTypeRequest $request)
    {
        $check_entry = WorkType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('work_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = WorkType::create($input);

        return redirect()->route('work-type.index')->with('success', __('work_type.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('work-type.edit', $id);
    }

    public function edit($id)
    {
        $work_type = WorkType::find($id);
        $this->data['work_type'] = $work_type;
        return response()->json(['html' => view('work_type.edit', $this->data)->render()]);
    }

    public function update($id, WorkTypeRequest $request)
    {
        $work_type = WorkType::findOrFail($id);
        $input = $request->validated();
        $work_type->update($input);
        return redirect()->route('work-type.index')->with('success', __('work_type.update_success'));
    }

    public function destroy($id)
    {
        $work_type = WorkType::findOrFail($id);
        if($work_type)
        {
            $dependency = $work_type->deleteValidate($id);
            if(!$dependency)
            {
                $work_type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('work_type.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
