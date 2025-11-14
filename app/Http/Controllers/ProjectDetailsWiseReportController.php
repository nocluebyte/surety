<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    ProjectDetailsWiseExport,
};

class ProjectDetailsWiseReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission::project_details_wise.list');
        $this->title = __('reports.project_details_wise');
        $this->common = new CommonController();
        view()->share('title', $this->title);
        $this->fields = collect(config('report.project_details_wise'));
    }

    public function index(){
        $project_details = $this->common->getProjectDetails();
        $this->data['project_details'] = $project_details;
        $this->data['fields'] = $this->fields->chunk(4);
        return view('reports.project_details_wise.index',$this->data);
    }

    public function show(Request $request)
    {
        $selected_project_details = $request->selected_project_details;
        $checked_fields = $request->multicheckbox;
        $project_details = $this->common->getProjectDetails();
        $this->data['project_details'] = $project_details;
        $this->data['fields'] = $this->fields;
        $this->data['chunk_fields'] = $this->fields->chunk(4);
        $this->data['selected_project_details'] = $selected_project_details;
        $this->data['checked_fields'] = $checked_fields;

        return view('reports.project_details_wise.show',$this->data);
    }

    public function datalist(Request $request)
    {
        $selected_project_details = $request->selected_project_details;
        $checked_fields = $request->multicheckbox;

        $project_details_wise_data_query = DB::table('project_details')
        ->select([
            'project_details.code as project_id',
            'project_details.project_name',
            'beneficiaries.company_name as beneficiary_name',
            'beneficiaries.pan_no as beneficiary_pan_no',
            'project_details.project_value',
            'project_types.name as type_of_project',
            'project_details.project_start_date',
            'project_details.project_end_date',
            'project_details.period_of_project',
            'tenders.type_of_contracting',
            'tenders.rfp_date',
            DB::raw('GROUP_CONCAT(" ", tenders.code," | ",tenders.tender_header) tender_under_project'),
        ])
        ->leftJoin('beneficiaries', 'project_details.beneficiary_id', 'beneficiaries.id')
        ->leftJoin('tenders', 'project_details.id', 'tenders.project_details')
        ->leftJoin('project_types', 'project_details.type_of_project', 'project_types.id')
        ->when($selected_project_details, function($q) use ($selected_project_details) {
            $q->where('project_details.id', $selected_project_details)->whereNull('project_details.deleted_at');
        })
        ->whereNull('project_details.deleted_at')
        ->groupBy('project_details.id');

        if($request->wantsJson()){
            $project_details_wise_data = $project_details_wise_data_query->paginate(500);
            // dd($project_details_wise_data);
            $this->data['project_details_wise_data'] = $project_details_wise_data;
            $this->data['checked_fields'] = $checked_fields;

            return response()->json([
                'html' => view('reports.project_details_wise.list', $this->data)->render(),
            ]);
        } else {
            $project_details_wise_data = $project_details_wise_data_query->get();
            return $project_details_wise_data;
        }
    }

    public function excel(Request $request){
        $this->data['checkedFields'] = $request->checked_fields;
        $this->data['project_details_wise_data'] = $this->datalist(Request());
        return Excel::download(new ProjectDetailsWiseExport($this->data),'project_details_wise.xlsx');
    }
}
