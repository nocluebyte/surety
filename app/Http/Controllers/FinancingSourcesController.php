<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\FinancingSources;
use App\Http\Requests\FinancingSourcesRequest;
use App\DataTables\FinancingSourcesDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class FinancingSourcesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:financing_sources.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:financing_sources.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:financing_sources.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:financing_sources.delete', ['only' => 'destroy']);
        $this->title = trans('financing_sources.financing_sources');
        view()->share('title', $this->title);
    }

    public function index(FinancingSourcesDataTable $datatable)
    {
        return $datatable->render('financing_sources.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('financing_sources.create')->render()
        ]);
    }

    public function store(FinancingSourcesRequest $request)
    {
        $check_entry = FinancingSources::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('financing_sources.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = FinancingSources::create($input);

        return redirect()->route('financing_sources.index')->with('success', __('financing_sources.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('financing_sources.edit', $id);
    }

    public function edit($id)
    {
        $financing_sources = FinancingSources::find($id);
        $this->data['financing_sources'] = $financing_sources;
        return response()->json(['html' => view('financing_sources.edit', $this->data)->render()]);
    }

    public function update($id, FinancingSourcesRequest $request)
    {
        $financing_sources = FinancingSources::findOrFail($id);
        $input = $request->all();
        $financing_sources->update($input);
        return redirect()->route('financing_sources.index')->with('success', __('financing_sources.update_success'));
    }

    public function destroy($id)
    {
        $financing_sources = FinancingSources::findOrFail($id);
        if($financing_sources)
        {
            $dependency = $financing_sources->deleteValidate($id);
            if(!$dependency)
            {
                $financing_sources->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('financing_sources.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
