<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    TenderWiseExport,
};

class TenderWiseReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission::tender_wise.list');
        $this->title = __('reports.tender_wise');
        $this->common = new CommonController();
        view()->share('title', $this->title);
        $this->fields = collect(config('report.tender_wise'));
    }

    public function index(){
        $tender = $this->common->getTender();
        $this->data['tender'] = $tender;
        $this->data['fields'] = $this->fields->chunk(4);
        return view('reports.tender_wise.index',$this->data);
    }

    public function show(Request $request)
    {
        $selected_tender = $request->selected_tender;
        $checked_fields = $request->multicheckbox;
        $tender = $this->common->getTender();
        $this->data['tender'] = $tender;
        $this->data['fields'] = $this->fields;
        $this->data['chunk_fields'] = $this->fields->chunk(4);
        $this->data['selected_tender'] = $selected_tender;
        $this->data['checked_fields'] = $checked_fields;

        return view('reports.tender_wise.show',$this->data);
    }

    public function datalist(Request $request)
    {
        $selected_tender = $request->selected_tender;
        $checked_fields = $request->multicheckbox;

        $tender_wise_data_query = DB::table('tenders')
        ->select([
            'tenders.code as tender_id',
            'tenders.tender_header',
            'beneficiaries.code as beneficiary_id',
            'beneficiaries.pan_no as beneficiary_pan_no',
            'project_details.code as project_id',
            'project_details.project_name',
            'tenders.location',
            'project_types.name as tender_project_type',
            'tenders.contract_value as tender_contract_value',
            'bond_types.name as application_bond_type',
            'tenders.bond_value as application_bond_value',
            DB::raw('GROUP_CONCAT(DISTINCT " ", principles.code," | ",principles.company_name) list_of_contractors_applied'),
            'tenders.bond_value as bond_total_risk_exposure',
        ])
        ->leftJoin('project_details', 'tenders.project_details', 'project_details.id')
        ->leftJoin('project_types', 'project_details.type_of_project', 'project_types.id')
        ->leftJoin('bond_types', 'tenders.bond_type_id', 'bond_types.id')
        ->leftJoin('beneficiaries', 'tenders.beneficiary_id', 'beneficiaries.id')
        ->leftJoin('proposals', 'beneficiaries.id', 'proposals.beneficiary_id')
        ->leftJoin('principles', 'proposals.contractor_id', 'principles.id')
        ->when($selected_tender, function($q) use ($selected_tender) {
            $q->where('tenders.id', $selected_tender)->whereNull('tenders.deleted_at');
        })
        ->whereNull('tenders.deleted_at')
        ->groupBy('tenders.id');

        if($request->wantsJson()){
            $tender_wise_data = $tender_wise_data_query->paginate(500);
            $this->data['tender_wise_data'] = $tender_wise_data;
            $this->data['checked_fields'] = $checked_fields;

            return response()->json([
                'html' => view('reports.tender_wise.list', $this->data)->render(),
            ]);
        } else {
            $tender_wise_data = $tender_wise_data_query->get();
            return $tender_wise_data;
        }
    }

    public function excel(Request $request){
        $this->data['checkedFields'] = $request->checked_fields;
        $this->data['tender_wise_data'] = $this->datalist(Request());
        return Excel::download(new TenderWiseExport($this->data),'tender_wise.xlsx');
    }
}
