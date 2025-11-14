<?php

namespace App\Http\Controllers;

use App\Models\ReInsuranceGrouping;
use Illuminate\Http\Request;
use App\DataTables\ReInsuranceGroupingDataTable;
use App\Http\Requests\ReInsuranceGroupingRequest;

class ReInsuranceGroupingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:re_insurance_grouping.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:re_insurance_grouping.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:re_insurance_grouping.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:re_insurance_grouping.delete', ['only' => 'destroy']);
        $this->title = trans('re_insurance_grouping.re_insurance_grouping');
        view()->share('title', $this->title);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ReInsuranceGroupingDataTable $dataTable)
    {
        return $dataTable->render('re_insurance_grouping.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('re_insurance_grouping.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReInsuranceGroupingRequest $request)
    {
        $input = $request->all();
        $model = ReInsuranceGrouping::create($input);
        return redirect()->back()->with('success' , __('common.create_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ReInsuranceGrouping $reInsuranceGrouping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reInsuranceGrouping = ReInsuranceGrouping::find($id);
        $this->data['re_insurance_grouping'] = $reInsuranceGrouping;
        return response()->json(['html' => view('re_insurance_grouping.edit',$this->data)->render()]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ReInsuranceGroupingRequest $request, $id)
    {
        $reInsuranceGrouping = ReInsuranceGrouping::findOrFail($id);
        $input = $request->all();
        $model = $reInsuranceGrouping->update($input);
        return redirect()->route('re-insurance-grouping.index')->with('success' , __('common.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
