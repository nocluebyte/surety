<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\DocumentType;
use App\Http\Requests\DocumentTypeRequest;
use App\DataTables\DocumentTypeDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:document_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:document_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:document_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:document_type.delete', ['only' => 'destroy']);
        $this->title = trans('document_type.document_type');
        view()->share('title', $this->title);
    }

    public function index(DocumentTypeDataTable $datatable)
    {
        return $datatable->render('document_type.index');
    }

    public function create()
    {
        $this->data['type'] = Config('srtpl.document_type');
        return response()->json([
            'html' =>  view('document_type.create', $this->data)->render()
        ]);
    }

    public function store(DocumentTypeRequest $request)
    {
        $check_entry = DocumentType::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->type == $request['type'])) {
            return redirect()->route('document_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = DocumentType::create($input);

        return redirect()->route('document_type.index')->with('success', __('document_type.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('document_type.edit', $id);
    }

    public function edit($id)
    {
        $document_type = DocumentType::find($id);
        $this->data['document_type'] = $document_type;
        $this->data['type'] = Config('srtpl.document_type');
        return response()->json(['html' => view('document_type.edit', $this->data)->render()]);
    }

    public function update($id, DocumentTypeRequest $request)
    {
        $document_type = DocumentType::findOrFail($id);
        $input = $request->all();
        $document_type->update($input);
        return redirect()->route('document_type.index')->with('success', __('document_type.update_success'));
    }

    public function destroy($id)
    {
        $document_type = DocumentType::findOrFail($id);
        if($document_type)
        {
            $dependency = $document_type->deleteValidate($id);
            if(!$dependency)
            {
                $document_type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('document_type.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
