<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Reason;
use App\Http\Requests\ReasonRequest;
use App\DataTables\ReasonDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class ReasonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:reason.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:reason.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:reason.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:reason.delete', ['only' => 'destroy']);
        $this->title = trans('reason.reason');
        view()->share('title', $this->title);
    }

    public function index(ReasonDataTable $datatable)
    {
        return $datatable->render('reason.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('reason.create')->render()
        ]);
    }

    public function store(ReasonRequest $request)
    {
        $check_entry = Reason::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->reason == $request['reason'])) {
            return redirect()->route('reason.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = Reason::create($input);

        return redirect()->route('reason.index')->with('success', __('reason.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('reason.edit', $id);
    }

    public function edit($id)
    {
        $reason = Reason::find($id);
        $this->data['reason'] = $reason;
        return response()->json(['html' => view('reason.edit', $this->data)->render()]);
    }

    public function update($id, ReasonRequest $request)
    {
        $reason = Reason::findOrFail($id);
        $input = $request->validated();
        $reason->update($input);
        return redirect()->route('reason.index')->with('success', __('reason.update_success'));
    }

    public function destroy($id)
    {
        $reason = Reason::findOrFail($id);
        if($reason)
        {
            $dependency = $reason->deleteValidate($id);
            if(!$dependency)
            {
                $reason->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('reason.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
