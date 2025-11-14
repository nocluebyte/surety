<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UwView;
use App\Http\Requests\UwViewRequest;
use App\DataTables\UwViewDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class UwViewController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:uw-view.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:uw-view.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:uw-view.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:uw-view.delete', ['only' => 'destroy']);
        $this->title = trans('uw-view.uw-view');
        view()->share('title', $this->title);
    }

    public function index(UwViewDataTable $datatable)
    {
        return $datatable->render('uw-view.index');
    }

    public function create()
    {
        return response()->json([
            'html' => view('uw-view.create')->render()
        ]);
    }

    public function store(UwViewRequest $request)
    {
        $check_entry = UwView::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('uw-view.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = UwView::create($input);

        return redirect()->route('uw-view.index')->with('success', __('uw-view.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('uw-view.edit', $id);
    }

    public function edit($id)
    {
        $uwView = UwView::find($id);
        $this->data['uwView'] = $uwView;
        return response()->json(['html' => view('uw-view.edit', $this->data)->render()]);
    }

    public function update($id, UwViewRequest $request)
    {
        $uwView = UwView::findOrFail($id);
        $input = $request->validated();
        $uwView->update($input);
        return redirect()->route('uw-view.index')->with('success', __('uw-view.update_success'));
    }

    public function destroy($id)
    {
        $uwView = UwView::findOrFail($id);
        if($uwView)
        {
            $dependency = $uwView->deleteValidate($id);
            if(!$dependency)
            {
                $uwView->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('uw-view.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
