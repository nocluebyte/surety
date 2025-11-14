<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\IssuingOfficeBranch;
use App\Http\Requests\IssuingOfficeBranchRequest;
use App\DataTables\IssuingOfficeBranchDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;
use App\Imports\IssuingOfficeBranchImport;
use App\Exports\IssuingOfficeBranchImportErrorExport;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class IssuingOfficeBranchController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['create', 'store', 'show', 'update', 'destroy', 'edit']]);
        $this->middleware('permission:issuing_office_branch.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:issuing_office_branch.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:issuing_office_branch.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:issuing_office_branch.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('issuing_office_branch.issuing_office_branch');
        view()->share('title', $this->title);
    }

    public function index(IssuingOfficeBranchDataTable $datatable)
    {
        $this->data['mode'] = Config('srtpl.filters.issuing_office_branch_filter.mode') ?? [];
        return $datatable->render('issuing_office_branch.index', $this->data);
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['mode'] = Config('srtpl.filters.issuing_office_branch_filter.mode') ?? [];
        $this->data['isCountryIndia'] = true;

        return view('issuing_office_branch.create', $this->data);
    }

    public function store(IssuingOfficeBranchRequest $request)
    {
        $check_entry = IssuingOfficeBranch::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->branch_name == $request['branch_name'])) {
            return redirect()->route('issuing-office-branch.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = [
            'branch_name' => $request['branch_name'],
            'branch_code' => $request['branch_code'],
            'address' => $request['address'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'city' => $request['city'],
            // 'cin_no' => $request['cin_no'],
            'gst_no' => $request['gst_no'],
            // 'sac_code' => $request['sac_code'],
            'oo_cbo_bo_kbo' => $request['oo_cbo_bo_kbo'],
            'bank' => $request['bank'],
            'bank_branch' => $request['bank_branch'],
            'account_no' => $request['account_no'],
            'ifsc' => $request['ifsc'],
            'micr' => $request['micr'],
            'mode' => $request['mode'],
        ];

        $model = IssuingOfficeBranch::create($input);

        if ($request->save_type == "save") {
            return redirect()->route('issuing-office-branch.create')->with('success', __('issuing_office_branch.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('issuing-office-branch.index')->with('success', __('issuing_office_branch.create_success'));
        } else {
            return redirect()->route('issuing-office-branch.index')->with('success', __('issuing_office_branch.create_success'));
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $issuingOfficeBranch = IssuingOfficeBranch::find($id);
        $this->data['countries'] =  $this->common->getCountries($issuingOfficeBranch->country_id);
        $this->data['states'] =  $this->common->getStates($issuingOfficeBranch->country_id);
        $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;
        $this->data['mode'] = Config('srtpl.filters.issuing_office_branch_filter.mode') ?? [];
        $this->data['issuingOfficeBranch'] = $issuingOfficeBranch;
        return view('issuing_office_branch.edit', $this->data);
    }

    public function update($id, IssuingOfficeBranchRequest $request)
    {
        $issuingOfficeBranch = IssuingOfficeBranch::findOrFail($id);
        $issuing_office_branch_id = $issuingOfficeBranch->id;
        $input = [
            'branch_name' => $request['branch_name'],
            'branch_code' => $request['branch_code'],
            'address' => $request['address'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'city' => $request['city'],
            // 'cin_no' => $request['cin_no'],
            'gst_no' => $request['gst_no'],
            // 'sac_code' => $request['sac_code'],
            'oo_cbo_bo_kbo' => $request['oo_cbo_bo_kbo'],
            'bank' => $request['bank'],
            'bank_branch' => $request['bank_branch'],
            'account_no' => $request['account_no'],
            'ifsc' => $request['ifsc'],
            'micr' => $request['micr'],
            'mode' => $request['mode'],
        ];

        $issuingOfficeBranch->update($input);

        if ($request->save_type == "save") {
            return redirect()->route('issuing-office-branch.edit',[encryptId($issuing_office_branch_id)])->with('success', __('issuing_office_branch.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('issuing-office-branch.index')->with('success', __('issuing_office_branch.update_success'));
        } else {
            return redirect()->route('issuing-office-branch.index')->with('success', __('issuing_office_branch.update_success'));
        }
    }

    public function destroy($id)
    {
        $issuingOfficeBranch = IssuingOfficeBranch::findOrFail($id);
        if($issuingOfficeBranch)
        {
            $dependency = $issuingOfficeBranch->deleteValidate($id);
            if(!$dependency)
            {
                $issuingOfficeBranch->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('issuing_office_branch.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function import()
    {
        return view('issuing_office_branch.import.import');
    }

    public function IssuingOfficeBranchImportFiles(Request $request)
    {
        // dd($request->all());
        ini_set('max_execution_time', 900);
        ini_set('memory_limit',-1);
        DB::beginTransaction();
        try {
            $import = new IssuingOfficeBranchImport();
            $import->import($request->file('file'));
            $failures = $import->failures();
            $errors = [];
            foreach ($failures as $key => $value) {
                // dd($value);
                $index = $value->row();
                $attribute = $value->attribute();
                $values =$value->values();
                $error = $value->errors()[0];
                $errors[$index]['attribute'][] = $attribute;
                $errors[$index]['values'] = $values;
                $errors[$index]['error'][$attribute] = $error;
            }
            $this->data['excel_error'] = $errors;
            // dd($errors);
            session()->flash('excel_error',$errors);
            DB::commit();

            if (count($errors) == 0) {
                return redirect()->route('issuing_office_branch_import')->withSuccess('file imported successfully');
            }
            else
            {
                return redirect()->route('issuing_office_branch_import')->withErrors('in file has some invalid data please check and try again.');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            return back()->withErrors('Something went wrong, please try again.');
        }
    }

    public function issuingOfficeBranchImportErrorExport(Request $request){
        try {
            $exportdata = json_decode($request->error,true);
            return Excel::download(new IssuingOfficeBranchImportErrorExport($exportdata),'error.xlsx');
        } catch (\Throwable $th) {
            return "Something went wrong, please try again.";
        }
    }
}
