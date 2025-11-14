<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\PrincipleType;
use App\Http\Requests\PrincipleTypeRequest;
use App\DataTables\PrincipleTypeDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class PrincipleTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:principle_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:principle_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:principle_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:principle_type.delete', ['only' => 'destroy']);
        $this->title = trans('principle_type.principle_type');
        view()->share('title', $this->title);
    }

    public function index(PrincipleTypeDataTable $datatable)
    {
        return $datatable->render('principle_type.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('principle_type.create')->render()
        ]);
    }

    public function store(PrincipleTypeRequest $request)
    {
        $check_entry = PrincipleType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('principle_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = PrincipleType::create($input);

        return redirect()->route('principle_type.index')->with('success', __('principle_type.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('principle_type.edit', $id);
    }

    public function edit($id)
    {
        $principle_type = PrincipleType::find($id);
        $this->data['principle_type'] = $principle_type;
        return response()->json(['html' => view('principle_type.edit', $this->data)->render()]);
    }

    public function update($id, PrincipleTypeRequest $request)
    {
        $principle_type = PrincipleType::findOrFail($id);
        $input = $request->all();
        $principle_type->update($input);
        return redirect()->route('principle_type.index')->with('success', __('principle_type.update_success'));
    }

    public function destroy($id)
    {
        $principle_type = PrincipleType::findOrFail($id);
        if($principle_type)
        {
            $dependency = $principle_type->deleteValidate($id);
            if(!$dependency)
            {
                $principle_type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('principle_type.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
