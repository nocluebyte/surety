<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\FileSource;
use App\Http\Requests\FileSourceRequest;
use App\DataTables\FileSourceDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class FileSourceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:file_source.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:file_source.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:file_source.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:file_source.delete', ['only' => 'destroy']);
        $this->title = trans('file_source.file_source');
        view()->share('title', $this->title);
    }

    public function index(FileSourceDataTable $datatable)
    {
        return $datatable->render('file_source.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('file_source.create')->render()
        ]);
    }

    public function store(FileSourceRequest $request)
    {
        $check_entry = FileSource::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('file_source.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = FileSource::create($input);

        return redirect()->route('file_source.index')->with('success', __('file_source.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('file_source.edit', $id);
    }

    public function edit($id)
    {
        $file_source = FileSource::find($id);
        $this->data['file_source'] = $file_source;
        return response()->json(['html' => view('file_source.edit', $this->data)->render()]);
    }

    public function update($id, FileSourceRequest $request)
    {
        $file_source = FileSource::findOrFail($id);
        $input = $request->all();
        $file_source->update($input);
        return redirect()->route('file_source.index')->with('success', __('file_source.update_success'));
    }

    public function destroy($id)
    {
        $file_source = FileSource::findOrFail($id);
        if($file_source)
        {
            $dependency = $file_source->deleteValidate($id);
            if(!$dependency)
            {
                $file_source->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('file_source.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
