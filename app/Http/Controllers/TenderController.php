<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
    Tender,
    DMS,
    ProjectDetail,
};
use App\Http\Requests\TenderRequest;
use App\DataTables\TenderDataTable;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Imports\TenderImport;
use App\Exports\TenderImportErrorExport;
use Maatwebsite\Excel\Facades\Excel;

class TenderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['create', 'store', 'show', 'update', 'destroy', 'edit']]);
        $this->middleware('permission:tender.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:tender.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:tender.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tender.delete', ['only' => 'destroy']);
        $this->middleware('permission:tender.import', ['only' => ['import', 'TenderImportFiles']]);

        $this->common = new CommonController();
        $this->title = trans('tender.tender');
        view()->share('title', $this->title);
    }

    public function index(TenderDataTable $datatable)
    {
        $this->data['type_of_contracting'] = Config('srtpl.type_of_contracting');
        $this->data['beneficiary_id'] = $this->common->getBeneficiary();
        $this->data['project_type'] = $this->common->getProjectType();
        // $this->data['bond_type_id'] = $this->common->getBondTypes();
        return $datatable->render('tender.index', $this->data);
    }

    public function create()
    {
        // $this->data['countries'] = $this->common->getCountries();
        // $this->data['states'] = [];
        // if (old('country_id')) {
        //     $this->data['states'] = $this->common->getStates(old('country_id'));
        // }
        $this->data['type_of_contracting'] = Config('srtpl.type_of_contracting');
        $this->data['beneficiary_id'] = $this->common->getBeneficiary();
        $this->data['bond_type_id'] = $this->common->getBondTypes();
        $this->data['project_type'] = $this->common->getProjectType();
        $this->data['seriesNumber'] = codeGenerator('tenders', 5, 'TIN');
        $this->data['isCountryIndia'] = true;
        $this->data['project_details'] = $this->common->getProjectDetails();
        $this->data['type_of_project'] = $this->common->getProjectType();

        return view('tender.create', $this->data);
    }

    public function store(TenderRequest $request)
    {
        $check_entry = Tender::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('tender.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $tender_input = [
                'code' => codeGenerator('tenders', 5, 'TIN'),
                'tender_id' => $request['tender_id'],
                // 'tender_reference_no' => $request['tender_reference_no'],
                'beneficiary_id' => $request['beneficiary_id'],
                // 'phone_no' => $request['phone_no'],
                //'pan_no' => $request['pan_no'],
                // 'first_name' => $request['first_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                // 'email' => $request['email'],
               // 'address' => $request['address'],
                // 'country_id' => $request['country_id'],
                // 'state_id' => $request['state_id'],
                // 'city' => $request['city'],
                "tender_header" => $request['tender_header'],
                "location" => $request['location'],
                "project_type" => $request['project_type'],
                'contract_value' => $request['contract_value'],
                'period_of_contract' => $request['period_of_contract'],
                'bond_value' => $request['bond_value'],
                'bond_type_id' => $request['bond_type_id'],
                'tender_description' => $request['tender_description'],
                'rfp_date' => $request['rfp_date'],
                'bond_start_date' => $request['bond_start_date'] ?? null,
                'bond_end_date' => $request['bond_end_date'] ?? null,
                'period_of_bond' => $request['period_of_bond'] ?? null,
                'project_description' => $request['project_description'],
                'type_of_contracting' => $request['type_of_contracting'],

                "project_details" => $request['project_details_id'],
                "pd_beneficiary" => $request['pd_beneficiary'],
                "pd_project_name" => $request['pd_project_name'],
                "pd_project_description" => $request['pd_project_description'],
                "pd_project_value" => $request['pd_project_value'],
                "pd_type_of_project" => $request['pd_type_of_project'],
                "pd_project_start_date" => $request['pd_project_start_date'],
                "pd_project_end_date" => $request['pd_project_end_date'],
                "pd_period_of_project" => $request['pd_period_of_project'],
            ];

            $tender = Tender::create($tender_input);

            $tender_id = $tender->id;

            $relatedModel = Tender::findOrFail($tender_id);

            $this->common->storeMultipleFiles($request, $request['rfp_attachment'], 'rfp_attachment', $tender, $tender_id, 'tender');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating Tender: ' . $e->getMessage());
            throw $e;
        }

        return redirect()->route('tender.index')->with('success', __('tender.create_success'));
    }

    public function show($id)
    {
        $tender = Tender::with('bondPoliciesIssue')->findOrFail($id);
        $this->data['tender_document'] = $tender->dMS;
        // dd($this->data['tender_document']);
        $table_name =  $tender->getTable();
        $this->data['tender'] = $tender;
        $this->data['table_name'] = $table_name;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($tender->beneficiary->country_id);
        return view('tender.show',$this->data);
    }

    public function edit($id)
    {
        $tender = Tender::with('dMS')->findOrFail($id);
        //$this->data['countries'] = $this->common->getCountries();
        //$this->data['states'] =  $this->common->getStates($tender->country_id);
        $this->data['type_of_contracting'] = Config('srtpl.type_of_contracting');
        $this->data['beneficiary_id'] = $this->common->getBeneficiary($tender->beneficiary_id);

        $this->data['bond_type_id'] = $this->common->getBondTypes($tender->bond_type_id);
        $this->data['project_type'] = $this->common->getProjectType($tender->project_type);
        $this->data['project_details'] = $this->common->getProjectDetails($tender->project_details);
        $this->data['type_of_project'] = $this->common->getProjectType($tender->pd_type_of_project);

        $this->data['dms_data'] = $tender->dMS;

        // $selected_country = $tender->country->name;
        // $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;

        $this->data['tender'] = $tender;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($tender->beneficiary->country_id);


        return view('tender.edit', $this->data);
    }

    public function update($id, TenderRequest $request)
    {
        DB::beginTransaction();
        try {
            $tender = Tender::findOrFail($id);

            $tender_id = $tender->id;

            $tender_update_input = [
                'tender_id' => $request['tender_id'],
                // 'tender_reference_no' => $request['tender_reference_no'],
                'beneficiary_id' => $request['beneficiary_id'],
                // 'phone_no' => $request['phone_no'],
                //'pan_no' => $request['pan_no'],
                // 'first_name' => $request['first_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                // 'email' => $request['email'],
                // 'address' => $request['address'],
                // 'country_id' => $request['country_id'],
                // 'state_id' => $request['state_id'],
                // 'city' => $request['city'],
                "tender_header" => $request['tender_header'],
                "location" => $request['location'],
                "project_type" => $request['project_type'],
                'contract_value' => $request['contract_value'],
                'period_of_contract' => $request['period_of_contract'],
                'bond_value' => $request['bond_value'],
                'bond_type_id' => $request['bond_type_id'],
                'tender_description' => $request['tender_description'],
                'rfp_date' => $request['rfp_date'],
                'bond_start_date' => $request['bond_start_date'] ?? null,
                'bond_end_date' => $request['bond_end_date'] ?? null,
                'period_of_bond' => $request['period_of_bond'] ?? null,
                'project_description' => $request['project_description'],
                'type_of_contracting' => $request['type_of_contracting'],
                "project_details" => $request['project_details_id'],
                "pd_beneficiary" => $request['pd_beneficiary'],
                "pd_project_name" => $request['pd_project_name'],
                "pd_project_description" => $request['pd_project_description'],
                "pd_project_value" => $request['pd_project_value'],
                "pd_type_of_project" => $request['pd_type_of_project'],
                "pd_project_start_date" => $request['pd_project_start_date'],
                "pd_project_end_date" => $request['pd_project_end_date'],
                "pd_period_of_project" => $request['pd_period_of_project'],
            ];

            $tender->update($tender_update_input);

            if($request['rfp_attachment']){
                $this->common->updateMultipleFiles($request, $request['rfp_attachment'], 'rfp_attachment', $tender, $tender_id, 'tender');
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            Log::error('Error updating Tender : ' . $e->getMessage());
            throw $e;
        }

        return redirect()->route('tender.index')->with('success', __('tender.update_success'));
    }

    public function destroy($id)
    {
        $tender = Tender::with('dMS')->findOrFail($id);

        $dms_data = DMS::where('dmsable_id', $id);

        if($tender)
        {
            $dependency = $tender->deleteValidate($id);
            if(!$dependency)
            {
                foreach($dms_data->pluck('attachment') as $dms_item)
                {
                    File::delete($dms_item);
                }

                $tender->dMS()->delete();
                $tender->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('tender.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function getProjectDetailsData(Request $request)
    {
        $project_details_id = $request->project_details_id;
        $field = [
            'project_details.id',
            'project_details.project_name as pd_project_name',
            'project_details.project_description as pd_project_description',
            'project_details.project_value as pd_project_value',
            'project_details.project_start_date as pd_project_start_date',
            'project_details.project_end_date as pd_project_end_date',
            'project_details.period_of_project as pd_period_of_project',
            'project_details.beneficiary_id as pd_beneficiary',
            'project_details.type_of_project as pd_type_of_project',
            'currencys.symbol as currency_symbol',
        ];
        if($project_details_id){
            $projectDetailsData = ProjectDetail::select($field)
            ->join('beneficiaries', function($join){
                $join->on('project_details.beneficiary_id', '=', 'beneficiaries.id');
            })
            ->join('countries', function($join){
                $join->on('beneficiaries.country_id', '=', 'countries.id');
            })
            ->join('currencys', function($join){
                $join->on('countries.id', '=', 'currencys.country_id');
            })
            ->where('project_details.id',$project_details_id)->first();
            return $projectDetailsData;
        }
    }

    public function import()
    {
        return view('tender.import.import');
    }

    public function TenderImportFiles(Request $request)
    {
        // dd($request->all());
        ini_set('max_execution_time', 900);
        ini_set('memory_limit',-1);
        DB::beginTransaction();
        try {
            $import = new TenderImport();
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
                return redirect()->route('tender_import')->withSuccess('file imported successfully');
            }
            else
            {
                return redirect()->route('tender_import')->withErrors('in file has some invalid data please check and try again.');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            return back()->withErrors('Something went wrong, please try again.');
        }
    }

    public function tenderImportErrorExport(Request $request){
        try {
            $exportdata = json_decode($request->error,true);
            return Excel::download(new TenderImportErrorExport($exportdata),'error.xlsx');
        } catch (\Throwable $th) {
            return "Something went wrong, please try again.";
        }
    }
}
