<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\RelevantApproval;
use App\Http\Requests\RelevantApprovalRequest;
use App\DataTables\RelevantApprovalDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class RelevantApprovalController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:relevant_approval.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:relevant_approval.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:relevant_approval.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:relevant_approval.delete', ['only' => 'destroy']);
        $this->title = trans('relevant_approval.relevant_approval');
        view()->share('title', $this->title);
    }

    public function index(RelevantApprovalDataTable $datatable)
    {
        return $datatable->render('relevant_approval.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('relevant_approval.create')->render()
        ]);
    }

    public function store(RelevantApprovalRequest $request)
    {
        $check_entry = RelevantApproval::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('relevant_approval.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = RelevantApproval::create($input);

        return redirect()->route('relevant_approval.index')->with('success', __('relevant_approval.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('relevant_approval.edit', $id);
    }

    public function edit($id)
    {
        $relevant_approval = RelevantApproval::find($id);
        $this->data['relevant_approval'] = $relevant_approval;
        return response()->json(['html' => view('relevant_approval.edit', $this->data)->render()]);
    }

    public function update($id, RelevantApprovalRequest $request)
    {
        $relevant_approval = RelevantApproval::findOrFail($id);
        $input = $request->all();
        $relevant_approval->update($input);
        return redirect()->route('relevant_approval.index')->with('success', __('relevant_approval.update_success'));
    }

    public function destroy($id)
    {
        $relevant_approval = RelevantApproval::findOrFail($id);
        if($relevant_approval)
        {
            $dependency = $relevant_approval->deleteValidate($id);
            if(!$dependency)
            {
                $relevant_approval->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('relevant_approval.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
