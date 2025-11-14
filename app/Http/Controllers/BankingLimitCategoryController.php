<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\BankingLimitCategory;
use App\Http\Requests\BankingLimitCategoryRequest;
use App\DataTables\BankingLimitCategoryDataTable;
use App\Http\Controllers\Controller;
use Sentinel;
use Carbon\Carbon;

class BankingLimitCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:banking_limit_categories.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:banking_limit_categories.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:banking_limit_categories.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banking_limit_categories.delete', ['only' => ['destroy']]);
        $this->title = trans('banking_limit_categories.banking_limit_categories');
        view()->share('title', $this->title);
    }

    public function index(BankingLimitCategoryDataTable $datatable)
    {
        return $datatable->render('banking_limit_categories.index');
    }

    public function create()
    {
        $this->data['type'] = Config('srtpl.banking_limit_categories');
        return response()->json([
            'html' => view('banking_limit_categories.create', $this->data)->render()
        ]);
    }

    public function store(BankingLimitCategoryRequest $request)
    {
        $check_entry = BankingLimitCategory::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if(!empty($check_entry)){
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if(!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])){
            return redirect()->route('banking_limit_categories.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = BankingLimitCategory::create($input);

        return redirect()->route('banking_limit_categories.index')->with('success', __('banking_limit_categories.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('banking_limit_categories.edit', $id);
    }

    public function edit($id)
    {
        $banking_limit_categories = BankingLimitCategory::find($id);
        $this->data['banking_limit_categories'] = $banking_limit_categories;
        $this->data['type'] = Config('srtpl.banking_limit_categories');
        return response()->json(['html' => view('banking_limit_categories.edit', $this->data)->render()]);
    }

    public function update($id, BankingLimitCategoryRequest $request)
    {
        $banking_limit_categories = BankingLimitCategory::findOrFail($id);
        $input = $request->all();
        $banking_limit_categories->update($input);
        return redirect()->route('banking_limit_categories.index')->with('success', __('banking_limit_categories.update_success'));
    }

    public function destroy($id)
    {
        $banking_limit_categories = BankingLimitCategory::findOrFail($id);
        if($banking_limit_categories)
        {
            $dependency = $banking_limit_categories->deleteValidate($id);
            if(!$dependency)
            {
                $banking_limit_categories->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('banking_limit_categories.dependency_error', ['dependency' => $dependency]),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
