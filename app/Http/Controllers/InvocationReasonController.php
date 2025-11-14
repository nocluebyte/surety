<?php

namespace App\Http\Controllers;

use App\Models\InvocationReason;
use Illuminate\Http\Request;
use App\Http\Requests\InvocationReasonRequest;
use App\DataTables\InvocationReasonDataTable;

class InvocationReasonController extends Controller
{
    public function __construct(){

        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:invocation_reason.list')->only(['index','show']);
        $this->middleware('permission:invocation_reason.add')->only(['create','store']);
        $this->middleware('permission:invocation_reason.edit')->only(['edit','update']);
        $this->middleware('permission:invocation_reason.delete')->only('delete');
        view()->share('title', __('invocation_reason_master.invocation_reason'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InvocationReasonDataTable $dataTable)
    {
        return $dataTable->render('invocation_reason.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'html'=>view('invocation_reason.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvocationReasonRequest $request)
    {
        $input = $request->validated();

        InvocationReason::create($input);

        return back()->withSuccess(__('common.create_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invocation_reason = InvocationReason::findOrFail($id);

        $this->data['invocation_reason'] = $invocation_reason;

        return response()->json([
            'html'=>view('invocation_reason.edit',$this->data)->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvocationReasonRequest $request, string $id)
    {
        $input = $request->validated();
        // dd($input);

        $invocation_reason = InvocationReason::findOrFail($id);
        $invocation_reason->update($input);

        return back()->withSuccess(__('common.update_success'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invocation_reason = InvocationReason::findOrFail($id);
        if($invocation_reason)
        {
            $dependency = $invocation_reason->deleteValidate($id);
            if(!$dependency)
            {
                $invocation_reason->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('invocation_reason_master.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
