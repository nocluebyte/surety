<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BondTypes;
use App\Http\Requests\BondTypesRequest;
use App\DataTables\BondTypesDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class BondTypesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:bond_types.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:bond_types.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:bond_types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bond_types.delete', ['only' => 'destroy']);
        $this->title = trans('bond_types.bond_types');
        view()->share('title', $this->title);
    }

    public function index(BondTypesDataTable $datatable)
    {
        return $datatable->render('bond_types.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('bond_types.create')->render()
        ]);
    }

    public function store(BondTypesRequest $request)
    {
        $check_entry = BondTypes::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('bond_types.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = BondTypes::create($input);

        return redirect()->route('bond_types.index')->with('success', __('bond_types.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('bond_types.edit', $id);
    }

    public function edit($id)
    {
        $bond_types = BondTypes::find($id);
        $this->data['bond_types'] = $bond_types;

        return response()->json(['html' => view('bond_types.edit', $this->data)->render()]);
    }

    public function update($id, BondTypesRequest $request)
    {
        $bond_types = BondTypes::findOrFail($id);
        $input = $request->all();
        $bond_types->update($input);

        return redirect()->route('bond_types.index')->with('success', __('bond_types.update_success'));
    }

    public function destroy($id)
    {
        $bond_types = BondTypes::findOrFail($id);
        if($bond_types)
        {
            $dependency = $bond_types->deleteValidate($id);
            if(!$dependency)
            {
                $bond_types->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('bond_types.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
