<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\Requests;
use App\Models\MinistryType;
use App\Http\Requests\MinistryTypeRequest;
use App\DataTables\MinistryTypeDataTable;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class MinistryTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:ministry_types.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:ministry_types.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:ministry_types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ministry_types.delete', ['only' => ['destroy']]);
        $this->title = trans('ministry_types.ministry_types');
        view()->share('title', $this->title);
    }

    public function index(MinistryTypeDataTable $datatable)
    {
        return $datatable->render('ministry_types.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('ministry_types.create')->render()
        ]);
    }

    public function store(MinistryTypeRequest $request)
    {
        $check_entry = MinistryType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('ministry_types.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = MinistryType::create($input);

        return redirect()->route('ministry_types.index')->with('success', __('ministry_types.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('ministry_types.edit', $id);
    }

    public function edit($id)
    {
        $this->data['ministry_types'] = MinistryType::find($id);
        return response()->json(['html' => view('ministry_types.edit', $this->data)->render()]);
    }

    public function update($id, MinistryTypeRequest $request)
    {
        $ministry_types = MinistryType::findOrFail($id);
        $input = $request->all();
        $ministry_types->update($input);
        return redirect()->route('ministry_types.index')->with('success', __('ministry_types.update_success'));
    }

    public function destroy($id)
    {
        $ministry_types = MinistryType::findOrFail($id);
        if($ministry_types)
        {
            $dependency = $ministry_types->deleteValidate($id);
            if(!$dependency)
            {
                $ministry_types->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('ministry_types.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
