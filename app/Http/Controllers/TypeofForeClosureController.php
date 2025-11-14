<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\TypeofForeClosure;
use App\DataTables\TypeofForeClosureDataTable;
use App\Http\Requests\TypeofForeClosureRequest;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class TypeofForeClosureController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:type_of_foreclosure.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:type_of_foreclosure.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:type_of_foreclosure.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:type_of_foreclosure.delete', ['only' => ['destroy']]);
        $this->title = trans('type_of_foreclosure.type_of_foreclosure');
        view()->share('title', $this->title);
    }

    public function index(TypeofForeClosureDataTable $datatable)
    {
        return $datatable->render('type_of_foreclosure.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('type_of_foreclosure.create')->render()
        ]);
    }

    public function store(TypeofForeClosureRequest $request)
    {
        $check_entry = TypeofForeClosure::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('type-of-foreclosure.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = TypeofForeClosure::create($input);

        return redirect()->route('type-of-foreclosure.index')->with('success', __('type_of_foreclosure.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('type-of-foreclosure.edit', $id);
    }

    public function edit($id)
    {
        $this->data['type_of_foreclosure'] = TypeofForeClosure::find($id);
        return response()->json(['html' => view('type_of_foreclosure.edit', $this->data)->render()]);
    }

    public function update($id, TypeofForeClosureRequest $request)
    {
        $type_of_foreclosure = TypeofForeClosure::findOrFail($id);
        $input = $request->all();
        $type_of_foreclosure->update($input);
        return redirect()->route('type-of-foreclosure.index')->with('success', __('type_of_foreclosure.update_success'));
    }

    public function destroy($id)
    {
        $type_of_foreclosure = TypeofForeClosure::findOrFail($id);
        if($type_of_foreclosure)
        {
            $dependency = $type_of_foreclosure->deleteValidate($id);
            if(!$dependency)
            {
                $type_of_foreclosure->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('type_of_foreclosure.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
