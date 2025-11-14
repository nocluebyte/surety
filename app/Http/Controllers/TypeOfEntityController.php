<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\TypeOfEntity;
use App\DataTables\TypeOfEntityDataTable;
use App\Http\Requests\TypeOfEntityRequest;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class TypeOfEntityController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:type_of_entities.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:type_of_entities.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:type_of_entities.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:type_of_entities.delete', ['only' => ['destroy']]);
        $this->title = trans('type_of_entities.type_of_entities');
        view()->share('title', $this->title);
    }

    public function index(TypeOfEntityDataTable $datatable)
    {
        return $datatable->render('type_of_entities.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('type_of_entities.create')->render()
        ]);
    }

    public function store(TypeOfEntityRequest $request)
    {
        $check_entry = TypeOfEntity::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('type_of_entities.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = TypeOfEntity::create($input);

        return redirect()->route('type_of_entities.index')->with('success', __('type_of_entities.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('type_of_entities.edit', $id);
    }

    public function edit($id)
    {
        $this->data['type_of_entities'] = TypeOfEntity::find($id);
        return response()->json(['html' => view('type_of_entities.edit', $this->data)->render()]);
    }

    public function update($id, TypeOfEntityRequest $request)
    {
        $type_of_entities = TypeOfEntity::findOrFail($id);
        $input = $request->all();
        $type_of_entities->update($input);
        return redirect()->route('type_of_entities.index')->with('success', __('type_of_entities.update_success'));
    }

    public function destroy($id)
    {
        $type_of_entities = TypeOfEntity::findOrFail($id);
        if($type_of_entities)
        {
            $dependency = $type_of_entities->deleteValidate($id);
            if(!$dependency)
            {
                $type_of_entities->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('type_of_entities.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
