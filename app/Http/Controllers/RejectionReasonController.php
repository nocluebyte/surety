<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\RejectionReason;
use App\Http\Requests\RejectionReasonRequest;
use App\DataTables\RejectionReasonDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class RejectionReasonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:rejection_reason.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:rejection_reason.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:rejection_reason.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rejection_reason.delete', ['only' => 'destroy']);
        $this->title = trans('rejection_reason.rejection_reason');
        view()->share('title', $this->title);
    }

    public function index(RejectionReasonDataTable $datatable)
    {
        return $datatable->render('rejection_reason.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('rejection_reason.create')->render()
        ]);
    }

    public function store(RejectionReasonRequest $request)
    {
        $check_entry = RejectionReason::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->reason == $request['reason'])) {
            return redirect()->route('rejection-reason.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = RejectionReason::create($input);

        return redirect()->route('rejection-reason.index')->with('success', __('rejection_reason.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('rejection-reason.edit', $id);
    }

    public function edit($id)
    {
        $rejection_reason = RejectionReason::find($id);
        $this->data['rejection_reason'] = $rejection_reason;
        return response()->json(['html' => view('rejection_reason.edit', $this->data)->render()]);
    }

    public function update($id, RejectionReasonRequest $request)
    {
        $rejection_reason = RejectionReason::findOrFail($id);
        $input = $request->validated();
        $rejection_reason->update($input);
        return redirect()->route('rejection-reason.index')->with('success', __('rejection_reason.update_success'));
    }

    public function destroy($id)
    {
        $rejection_reason = RejectionReason::findOrFail($id);
        if($rejection_reason)
        {
            $dependency = $rejection_reason->deleteValidate($id);
            if(!$dependency)
            {
                $rejection_reason->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('rejection_reason.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
