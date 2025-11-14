<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\HsnCode;
use App\Http\Requests\HsnCodeRequest;
use App\DataTables\HsnCodeDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class HsnCodeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:hsn-code.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:hsn-code.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:hsn-code.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:hsn-code.delete', ['only' => 'destroy']);
        $this->title = trans('hsn_code.hsn-code');
        view()->share('title', $this->title);
    }

    public function index(HsnCodeDataTable $datatable)
    {
        return $datatable->render('hsn-code.index');
    }

    public function create()
    {
        $this->data['gst_slab'] = Config('srtpl.gst_tax_slab');
        return response()->json([
            'html' => view('hsn-code.create', $this->data)->render()
        ]);
    }

    public function store(HsnCodeRequest $request)
    {
        $check_entry = HsnCode::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->hsn_code == $request['hsn_code'])) {
            return redirect()->route('hsn-code.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = HsnCode::create($input);

        return redirect()->route('hsn-code.index')->with('success', __('hsn_code.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('hsn-code.edit', $id);
    }

    public function edit($id)
    {
        $hsnCode = HsnCode::find($id);
        $this->data['hsnCode'] = $hsnCode;
        $this->data['gst_slab'] = Config('srtpl.gst_tax_slab');
        return response()->json(['html' => view('hsn-code.edit', $this->data)->render()]);
    }

    public function update($id, HsnCodeRequest $request)
    {
        $hsnCode = HsnCode::findOrFail($id);
        $input = $request->validated();
        $hsnCode->update($input);
        return redirect()->route('hsn-code.index')->with('success', __('hsn_code.update_success'));
    }

    public function destroy($id)
    {
        $hsnCode = HsnCode::findOrFail($id);
        if($hsnCode)
        {
            $dependency = $hsnCode->deleteValidate($id);
            if(!$dependency)
            {
                $hsnCode->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('hsn_code.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
