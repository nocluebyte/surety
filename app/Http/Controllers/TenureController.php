<?php

namespace App\Http\Controllers;

use App\DataTables\TenureDataTable;
use App\Http\Requests\TenureRequest;
use App\Models\Tenure;
use Carbon\Carbon;
use DB;
use Sentinel;

class TenureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:tenure.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:tenure.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:tenure.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tenure.delete', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = trans("tenure.tenure");
        view()->share('title', $this->title);
    }
    public function index(TenureDataTable $dataTable)
    {
        return $dataTable->render('tenure.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['html' =>  view('tenure.create')->render()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenureRequest $request)
    {
        DB::beginTransaction();
        try {

            $check_entry = Tenure::latest()->first();
            $finishTime = Carbon::now();
            $totalDuration = 10;
            if (!empty($check_entry)) {
                $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
            }
            if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
                return redirect()->route('tenure.index')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
            }
            $input = $request->all();
            Tenure::create($input); 
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tenure.index')->with('error', __('common.something_went_wrong_please_try_again'));
        }
        
        return redirect()->route('tenure.index')->with('success' , __('common.create_success'));

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tenure = Tenure::find($id);
        $this->data['tenure'] = $tenure;
        return response()->json(['html' => view('tenure.edit',$this->data)->render()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenureRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $tenure = Tenure::findOrFail($id);
            $input = $request->all();
            $tenure->update($input); 
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tenure.index')->with('error', __('common.something_went_wrong_please_try_again'));
        }
        return redirect()->route('tenure.index')->with('success' , __('common.create_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tenure = Tenure::findOrFail($id);
        if ($tenure) {
            $dependency = $tenure->deleteValidate($id);
            if (!$dependency) {
                $tenure->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('tenure.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
