<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AdditionalBond;
use App\Http\Requests\AdditionalBondRequest;
use App\DataTables\AdditionalBondDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class AdditionalBondController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:additional_bond.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:additional_bond.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:additional_bond.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:additional_bond.delete', ['only' => 'destroy']);
        $this->title = trans('additional_bond.additional_bond');
        view()->share('title', $this->title);
    }

    public function index(AdditionalBondDataTable $datatable)
    {
        return $datatable->render('additional_bond.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('additional_bond.create')->render()
        ]);
    }

    public function store(AdditionalBondRequest $request)
    {
        $check_entry = AdditionalBond::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('additional_bond.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = AdditionalBond::create($input);

        return redirect()->route('additional-bond.index')->with('success', __('additional_bond.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('additional-bond.edit', $id);
    }

    public function edit($id)
    {
        $additional_bond = AdditionalBond::find($id);
        $this->data['additional_bond'] = $additional_bond;
        return response()->json(['html' => view('additional_bond.edit', $this->data)->render()]);
    }

    public function update($id, AdditionalBondRequest $request)
    {
        $additional_bond = AdditionalBond::findOrFail($id);
        $input = $request->validated();
        $additional_bond->update($input);
        return redirect()->route('additional-bond.index')->with('success', __('additional_bond.update_success'));
    }

    public function destroy($id)
    {
        $additional_bond = AdditionalBond::findOrFail($id);
        if($additional_bond)
        {
            $dependency = $additional_bond->deleteValidate($id);
            if(!$dependency)
            {
                $additional_bond->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('additional_bond.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
