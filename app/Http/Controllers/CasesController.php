<?php

namespace App\Http\Controllers;

use App\Models\CasesBondLimitStrategy;
use App\Models\DMS;
use App\Models\DmsComment;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use App\Http\Requests\{
    TenderEvaluationRequest,
    CasesDecisionRequest,
    SynopsisRequest,
    CasesParameterRequest,
    CasesActionPlanRequest,
    CasesActionPlanFinancialsRequest,
    casesProjectDetailsRequest,
    CasesDmsAttachmentRequest,
};
use App\Models\{
    Cases,
    User,
    UnderwriterAssignCaseLog,
    CasesActionPlan,
    Analysis,
    ProfitLoss,
    BalanceSheet,
    Ratio,
    GroupContractor,
    CasesLimitStrategy,
    Group,
    UnderwriterCasesLog,
    Principle,
    Beneficiary,
    ProposalBeneficiaryTradeSector,
    PerformanceBond,
    TradeSectorItem,
    BidBond,
    AdvancePaymentBond,
    RetentionBond,
    MaintenanceBond,
    Proposal,
    TenderEvaluation,
    TenderEvaluationWorkType,
    TenderEvaluationProductAllowed,
    TenderEvaluationLocation,
    Tender,
    CasesDecision,
    UtilizedLimitStrategys,
    UwViewRating,
    SectorRating,
    CountryRating,
    OtherContractorInformation,
};
use DB;
use App\DataTables\CasesDataTable;
use Carbon\Carbon;
use Sentinel;
use PDF;
use App\Rules\Remarks;

class CasesController extends Controller
{ 
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:cases.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:cases.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:cases.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cases.delete', ['only' => 'caseCancel']);
        $this->title = __('cases.cases');
        $this->common = new CommonController();
        view()->share('title', $this->title);
    }

    public function index(CasesDataTable $dataTable){
        $this->data['underwriter'] = $this->common->getUnderWriterOpction();
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['case_type'] = Config('srtpl.filters.cases_filter.case_type');
        $this->data['generated_from'] = Config('srtpl.filters.cases_filter.generated_from');
        // $this->data['project_status'] = Config('srtpl.project_status');
        return $dataTable->render('cases.index',$this->data);
    }

    public function show($id){
        $request = Request();
        $case = Cases::with('dMS','dMS.fileSource:id,name','dMS.documentType:id,name','dMS.createdBy','underwriter','contractor.tradeSectorMain','beneficiary','tender','casesDecision','proposal.rejectionReason:id,reason,description','casesable', 'contractor.invocationNotification', 'contractor.recovery','contractor.contractorAdverseInformation')->findOrFail($id);
        
        $this->common->markAsRead($case);

        $this->data['approved_bond_current'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$case->contractor_id)
        ->where(function($q){
            $q->where('decision_status','Approved')
                ->orWhereNULL('decision_status');
        })
        ->where(function($query){
            $query->where('is_amendment',0)
                    ->orWhere('is_current',0);
        })
        ->where(function($q){
            $q->where('nbi_status','Approved')
                ->orWhereNULL('nbi_status');
        })                          
        ->whereDate('bond_end_date','>',now())
        ->whereIn('status',['Completed','Pending'])
        ->where('is_bond_managment_action_taken',0)
        ->get();

        $this->data['approved_bond_past'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$case->contractor_id)
        // ->whereDate('bond_end_date','<',now())
        // ->where(function($query) {
        //     $query->whereDate('bond_end_date','<',now())
        //     // ->orWhereIn('decision_status',['Rejected'])
        //     // ->orWhereNULL('decision_status')
        //     ->orWhere('is_amendment','!=',0);
        // })
        // ->where('is_amendment',1)
        ->where(function($q){
            $q->where('decision_status','Approved')
                ->orWhereNULL('decision_status');
        })
        ->where(function($q){
            $q->whereDate('bond_end_date','<',now())
                ->orWhere('is_amendment',1)
                ->orWhereNot('nbi_status','Approved');
        })
        // ->whereNull('is_current')   
        ->whereIn('status',['Completed','Pending'])
        ->where('is_bond_managment_action_taken',0)
        ->get();

        $this->data['approved_bond_reject'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$case->contractor_id)
        ->where('decision_status','Rejected')
        ->where('is_bond_managment_action_taken',0)
        ->get();

        $this->data['approved_bond_cancellation'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$case->contractor_id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',1)
        ->where('bond_managment_action_type','bond_cancellation')
        ->get();

        $this->data['approved_bond_foreclosure'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$case->contractor_id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',1)
        ->where('bond_managment_action_type','bond_foreclosure')
        ->get();

        $this->data['approved_bond_invoked'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',1);
        })
        ->where('contractor_id',$case->contractor_id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',0)
        ->get();


        $casesable_id = $case->casesable_id;
        $casesable_type = $case->casesable_type;
        $contractor_id = $case->contractor_id;
        $currentDate = Carbon::now()->format('Y-m-d');
        $this->data['currentDate']  = $currentDate;
        $this->data['case'] = $case;
        $this->data['table_name'] = $case->getTable();
        $this->data['document_type'] = $this->common->getDocumentTypeOpction();
        $this->data['file_source'] = $this->common->getFileSourceOpction();
        $parent = Group::where('contractor_id', $contractor_id)
        ->orWhereHas('groupContractor', function($sql) use($contractor_id){
            $sql->where('contractor_id', $contractor_id);
        })
        ->first();
        $this->data['parent'] = $parent;
        //tabs (1) DMS
        $dms_attachments = $case->dMS;
        // $this->data['dms_attachments'] = $case->dMS;
        $this->data['dms_attachments'] = $dms_attachments->merge(DMS::where('dmsable_id', $case->contractor_id)->where('dmsable_type', 'Other')->get())->sortDesc();
        /*Case Action plan start*/
        $case_action_plan = CasesActionPlan::with(['cases','profitLoss','casesLimitStrategy','casesLimitStrategySaveData','casesBondLimitStrategy',
        'utilizedCasesLimitStrategy','utilizedCasesBondLimitStrategy'])
        ->withSum('utilizedCasesLimitStrategy','value')
        ->withSum('utilizedCasesBondLimitStrategy','value')
        ->whereHas('cases', function ($qry) use ($contractor_id) {
            $qry->whereNotNull('contractor_id')->where(['contractor_id' =>  $contractor_id]);
        })->orderBy('id', 'DESC')->first();
        
        $this->data['case_action_plan'] = $case_action_plan;
        $this->data['currencys'] = $this->common->getCurrency();
        /*Case Action plan end*/
        $this->data['tab'] = $request->get('tab','');
        $this->data['profit_loss'] = Config('project.profit_loss');
        $this->data['ratios'] = Config('project.ratios');
        $this->data['balance_sheet_a'] = Config('project.balance_sheet_a');
        $this->data['balance_sheet_b'] = Config('project.balance_sheet_b');
        $this->data['underwriter'] = $this->common->getUnderWriterOpction();
        $datesArr = [];
        $analysis = collect();
        if (!is_null($case_action_plan)) {
            $cases_action_plan_id = $case_action_plan->id;
            $this->data['cases_action_plan_id'] = $cases_action_plan_id;
            $lossData = [];
            $ratiosData = [];
            $balanceSheetData = [];
            $profitLoss = ProfitLoss::where('cases_action_plan_id', $cases_action_plan_id)->first();
            if ($profitLoss) {
                $profitLoss = $profitLoss->toArray();
                if (count($profitLoss) > 0) {
                    foreach ($profitLoss as $loskey => $losval) {
                        $lossData[$loskey] = json_decode($losval, true);
                    }
                }
            }
            $this->data['loss'] = $lossData;
            if(empty($datesArr)){
                $datesArr = array_keys($lossData['sales'] ?? []);
            }
            $balanceSheet = BalanceSheet::where('cases_action_plan_id', $cases_action_plan_id)->first();
            if ($balanceSheet) {
                $balanceSheet = $balanceSheet->toArray();
                if (count($balanceSheet) > 0) {
                    foreach ($balanceSheet as $bkey => $bval) {
                        $balanceSheetData[$bkey] = json_decode($bval, true);
                    }
                }
            }
            $this->data['balanceSheet'] = $balanceSheetData;
            if(empty($datesArr)){
                $datesArr = array_keys($balanceSheetData['cash'] ?? []);
            }
            $ratios = Ratio::where('cases_action_plan_id', $cases_action_plan_id)->first();
            if ($ratios) {
                $ratios = $ratios->toArray();
                if (isset($ratios) && count($ratios) > 0) {
                    foreach ($ratios as $ratioskey => $ratiosval) {
                        $ratiosData[$ratioskey] = json_decode($ratiosval, true);
                    }
                }
            }
            $this->data['ratiosdata'] = $ratiosData;
            if(empty($datesArr)){
                $datesArr = array_keys($ratiosData['gp'] ?? []);
            }
            $analysis = Analysis::with(['createdBy'])->where('case_action_plan_id', $cases_action_plan_id)->orderBy('id', 'DESC')->get();
           
            if ($case_action_plan->casesLimitStrategySaveData) {
                $latestData = $case_action_plan->casesLimitStrategySaveData;
                // $latestLogData = array_filter($case_action_plan->casesLimitStrategy->toArray());
                $this->data['casesLimitStrategylog'] = $case_action_plan->casesLimitStrategy;                             
                if ($latestData) {
                    $this->data['casesLimitStrategy'] = $latestData;
                }
            }

            if ($case_action_plan->casesBondLimitStrategySaveData) {
                $latestData = $case_action_plan->casesBondLimitStrategySaveData;
                
                // $latestLogData = array_filter($case_action_plan->casesLimitStrategy->toArray());
                    $this->data['casesBondLimitStrategylog'] = $case_action_plan
                    ->casesBondLimitStrategy->groupBy(function($row) {
                        return $row->bondType->name;
                    });
                    if ($latestData) {
                        $this->data['casesBondLimitStrategy'] = $case_action_plan->casesBondLimitStrategySaveData;
                    }
            }
            if ($case_action_plan->casesLimitStrategySaveData) {
                $this->data['actionPlantransferLog'] = $case_action_plan->casesLimitStrategyTransferData->where('status', 'Transfer')->first();
            } else {
                $this->data['actionPlantransferLog'] = [];
            }
        }
        
        $this->data['datesArr'] = $datesArr;
        $this->data['analysis'] = $analysis;
        $group_cap = $parent->group->group_cap ?? 0;
        $proposed_group_cap = $case_action_plan->casesLimitStrategySaveData->proposed_group_cap ?? 0;
        $proposed_individual_cap = $case_action_plan->casesLimitStrategySaveData->proposed_individual_cap ?? 0;
        $proposed_overall_cap = $case_action_plan->casesLimitStrategySaveData->proposed_overall_cap ?? 0;
        // $proposed_spare_capecity = $case_action_plan->utilized_cases_bond_limit_strategy_sum_value ?? 0;
        // $spare_capecity = $proposed_overall_cap - $proposed_spare_capecity;
        $total_approved_limit = Cases::Completed($contractor_id)->sum('bond_value');
        $spare_capecity = $proposed_overall_cap - $total_approved_limit;
        $this->data['total_group_cap'] = ($group_cap > 0) ? $group_cap : $proposed_group_cap;
        $this->data['casesable'] = $case->casesable;
        $this->data['total_individual_cap'] = $proposed_individual_cap ?? 0;
        $this->data['total_overall_cap'] = $proposed_overall_cap ?? 0;
        $this->data['spare_capecity'] = $spare_capecity ?? 0;
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['total_pending_limit'] = Cases::Pending($contractor_id)->sum('bond_value');
        $this->data['total_approved_limit'] = $total_approved_limit;


        //group approved limit tab
        $pendingApplicationSubQuery = DB::table('cases')
        ->select('contractor_id', DB::raw('SUM(bond_value) as pending_application_limit'))
        ->where('status', 'Pending')
        ->groupBy('contractor_id');

        $approvedLimitSubQuery = DB::table('cases')
        ->join('cases_decisions', 'cases.id', '=', 'cases_decisions.cases_id')
        ->select('cases.contractor_id', DB::raw('SUM(cases_decisions.bond_value) as total_approved_limit'))
        ->where('cases.status', 'Completed')
        ->where('cases.is_amendment', 0)
        ->groupBy('cases.contractor_id');

        $group = Group::select([
            'principles.code', 
            'principles.company_name',
            DB::raw("NULL as type"),
            'countries.name as country',
            // DB::raw("SUM(pending_application.bond_value) as pending_application_limit"),
            // DB::raw("SUM(cases_decisions.bond_value) as total_approved_limit"),
            DB::raw('COALESCE(pending_apps.pending_application_limit, 0) as pending_application_limit'),
            DB::raw('COALESCE(approved_limits.total_approved_limit, 0) as total_approved_limit'),
            'cases_limit_strategys.proposed_individual_cap',
            'cases_limit_strategys.proposed_overall_cap',
            'cases_limit_strategys.proposed_valid_till as reguler_review_date',
            DB::raw("NULL as from_date"),
            DB::raw("NULL as till_date")
        ])
        ->leftJoin('principles',function($join){
            $join->on('groups.contractor_id','=','principles.id');
        })
        ->leftJoin('countries',function($join){
            $join->on('principles.country_id','=','countries.id');
        })
        ->leftJoin('cases_limit_strategys',function($join){
            $join->on('principles.id','=','cases_limit_strategys.contractor_id')
            ->where('is_current','0');
        })
        ->leftJoinSub($pendingApplicationSubQuery, 'pending_apps', function ($join) {
            $join->on('principles.id', '=', 'pending_apps.contractor_id');
        })
        ->leftJoinSub($approvedLimitSubQuery, 'approved_limits', function ($join) {
            $join->on('principles.id', '=', 'approved_limits.contractor_id');
        })
        ->where('groups.id',$parent?->id)
        ->groupBy([
            'principles.id',
            // 'principles.code',
            // 'principles.company_name',
            // 'countries.name',
            // 'cases_limit_strategys.proposed_individual_cap',
            // 'cases_limit_strategys.proposed_overall_cap',
            // 'cases_limit_strategys.proposed_valid_till',
        ]);

        $groupMember = GroupContractor::select([
            'principles.code', 
            'principles.company_name',
            DB::raw("group_contractors.type"),
            'countries.name as country',
            // DB::raw("SUM(pending_application.bond_value) as pending_application_limit"),
            // DB::raw("SUM(cases_decisions.bond_value) as total_approved_limit"),
            DB::raw('COALESCE(pending_apps.pending_application_limit, 0) as pending_application_limit'),
            DB::raw('COALESCE(approved_limits.total_approved_limit, 0) as total_approved_limit'),
            'cases_limit_strategys.proposed_individual_cap',
            'cases_limit_strategys.proposed_overall_cap',
            'cases_limit_strategys.proposed_valid_till as reguler_review_date',
            DB::raw("group_contractors.from_date"),
            DB::raw("group_contractors.till_date")
        ])
        ->leftJoin('principles',function($join){
            $join->on('group_contractors.contractor_id','=','principles.id');
        })
        ->leftJoin('groups',function($join){
            $join->on('group_contractors.group_id','=','groups.id');
        })
        ->leftJoin('countries',function($join){
            $join->on('principles.country_id','=','countries.id');
        })
        ->leftJoin('cases_limit_strategys',function($join){
            $join->on('principles.id','=','cases_limit_strategys.contractor_id')
            ->where('is_current','0');
        })
        ->leftJoinSub($pendingApplicationSubQuery, 'pending_apps', function ($join) {
            $join->on('principles.id', '=', 'pending_apps.contractor_id');
        })
        ->leftJoinSub($approvedLimitSubQuery, 'approved_limits', function ($join) {
            $join->on('principles.id', '=', 'approved_limits.contractor_id');
        })
        ->where('group_contractors.group_id',$parent?->id)
        ->groupBy([
            'principles.id',
            // 'principles.code',
            // 'principles.company_name',
            // 'countries.name',
            // 'cases_limit_strategys.proposed_individual_cap',
            // 'cases_limit_strategys.proposed_overall_cap',
            // 'cases_limit_strategys.proposed_valid_till',
        ]);

        $group_approved_limit = $group->unionAll($groupMember)
        ->get();
        $this->data['group_approved_limit'] = $group_approved_limit;

        // Company Profile && Synopsis
        if($case->casesable_type == 'Principle') {
            $companyProfile = Principle::with(['user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $case->casesable_id)->first();
            // $tradeSectorData = TradeSectorItem::with(['tradeSector'])
            //     ->where('tradesectoritemsable_id',$companyProfile->id)
            //     ->where('tradesectoritemsable_type', 'Principle')
            //     ->where('is_main', 'Yes')->first();

            // $parentData = GroupContractor::
            //     leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
            //     ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
            //     ->select(['principles.code', 'principles.company_name'])
            //     ->where('group_contractors.contractor_id', $case->casesable_id)->first();

        } elseif($case->casesable_type == 'InvocationNotification') {
            $companyProfile = Principle::with(['user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $case->contractor_id)->first();
            // $tradeSectorData = TradeSectorItem::with(['tradeSector'])
            //     ->where('tradesectoritemsable_id',$companyProfile->id)
            //     ->where('tradesectoritemsable_type', 'Principle')
            //     ->where('is_main', 'Yes')->first();

            $this->data['invocation_details_dms_data'] = $case->casesable->dMS->groupBy('attachment_type');    
        } 
        elseif($case->casesable_type == 'Beneficiary') {
            $companyProfile = Beneficiary::with(['user', 'establishmentTypeId', 'country'])->where('id', $case->casesable_id)->first();
            // $tradeSectorData = ProposalBeneficiaryTradeSector::with(['tradeSector'])
            //     ->where('proposalbeneficiarytradesectorsable_id',$companyProfile->id)
            //     ->where('is_main', 'Yes')->first();
            $parentData = '';
        } elseif($case->casesable_type == 'Proposal') {
            $proposalData = Proposal::with('beneficiary','contractor')->where('id', $case->casesable_id)->first();
            $companyProfile = $proposalData->contractor;
            //dd($companyProfile);
            // $tradeSectorData = TradeSectorItem::with(['tradeSector'])
            //     ->where('tradesectoritemsable_id',$companyProfile->id)
            //     ->where('tradesectoritemsable_type', 'Proposal')
            //     ->where('is_main', 'Yes')->first();

            // $parentData = GroupContractor::
            //     leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
            //     ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
            //     ->select(['principles.code', 'principles.company_name'])
            //     ->where('group_contractors.contractor_id', $case->casesable_id)->first();

                
            // $case_action_plan = CasesActionPlan::with(['cases','casesLimitStrategySaveData'])
            //     ->whereHas('cases', function ($qry) use ($id,$case) {
            //         $qry->whereNotNull('casesable_id')->where(['casesable_id' =>  $id])->where(['contractor_id' =>  $case->contractor_id]);
            //     })->orderBy('id', 'DESC')->first();

            // $proposed_individual_cap = $case_action_plan->casesLimitStrategySaveData->proposed_individual_cap ?? 0;
            // $proposed_overall_cap = $case_action_plan->casesLimitStrategySaveData->proposed_overall_cap ?? 0;
            // $this->data['total_individual_cap'] = $proposed_individual_cap ?? 0;
            // $this->data['total_overall_cap'] = $proposed_overall_cap ?? 0;

            $this->tenderEvaluation($request,$casesable_id);

            if($case->tender_evaluation == 'Yes'){
                $tenderEvaluation =  TenderEvaluation::with(['contractor','beneficiary','productAllowed','work_type','location'])->where('cases_id',$id)->where('proposal_id',$casesable_id)->orderBy('id','DESC')->first();
                $this->data['tenderEvaluation'] = $tenderEvaluation;
            }

        } /*elseif($case->casesable_type == 'PerformanceBond') {
            $performanceData = PerformanceBond::where('id',$case->casesable_id)->first();
            $companyProfile = Principle::with(['typeOfEntity','user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $performanceData->contractor_id)->first();
            
            $tradeSectorData = TradeSectorItem::with(['tradeSector'])
                ->where('tradesectoritemsable_id',$companyProfile->id)
                ->where('is_main', 'Yes')->first();

            $parentData = GroupContractor::
                leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
                ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
                ->select(['principles.code', 'principles.company_name'])
                ->where('group_contractors.contractor_id', $case->casesable_id)->first();

        }elseif($case->casesable_type == 'BidBond') {
            $performanceData = BidBond::where('id',$case->casesable_id)->first();
            $companyProfile = Principle::with(['typeOfEntity','user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $performanceData->contractor_id)->first();
            
            $tradeSectorData = TradeSectorItem::with(['tradeSector'])
                ->where('tradesectoritemsable_id',$companyProfile->id)
                ->where('tradesectoritemsable_type', 'Principle')
                ->where('is_main', 'Yes')->first();

            $parentData = GroupContractor::
                leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
                ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
                ->select(['principles.code', 'principles.company_name'])
                ->where('group_contractors.contractor_id', $case->casesable_id)->first();
        } elseif($case->casesable_type == 'AdvancePaymentBond') {
            $performanceData = AdvancePaymentBond::where('id',$case->casesable_id)->first();
            $companyProfile = Principle::with(['typeOfEntity','user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $performanceData->contractor_id)->first();

            $tradeSectorData = TradeSectorItem::with(['tradeSector'])
                ->where('tradesectoritemsable_id',$companyProfile->id)
                ->where('tradesectoritemsable_type', 'Principle')
                ->where('is_main', 'Yes')->first();

            $parentData = GroupContractor::
                leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
                ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
                ->select(['principles.code', 'principles.company_name'])
                ->where('group_contractors.contractor_id', $case->casesable_id)->first();
        } elseif($case->casesable_type == 'RetentionBond') {
            $performanceData = RetentionBond::where('id',$case->casesable_id)->first();
            $companyProfile = Principle::with(['typeOfEntity','user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $performanceData->contractor_id)->first();

            $tradeSectorData = TradeSectorItem::with(['tradeSector'])
                ->where('tradesectoritemsable_id',$companyProfile->id)
                ->where('tradesectoritemsable_type', 'Principle')
                ->where('is_main', 'Yes')->first();

            $parentData = GroupContractor::
                leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
                ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
                ->select(['principles.code', 'principles.company_name'])
                ->where('group_contractors.contractor_id', $case->casesable_id)->first();
        } elseif($case->casesable_type == 'MaintenanceBond') {
            $performanceData = MaintenanceBond::where('id',$case->casesable_id)->first();
            $companyProfile = Principle::with(['typeOfEntity','user', 'principleType', 'country', 'tradeSector', 'contractorItem'])->where('id', $performanceData->contractor_id)->first();

            $tradeSectorData = TradeSectorItem::with(['tradeSector'])
                ->where('tradesectoritemsable_id',$companyProfile->id)
                ->where('tradesectoritemsable_type', 'Principle')
                ->where('is_main', 'Yes')->first();

            $parentData = GroupContractor::
                leftJoin('groups', 'groups.id' , '=','group_contractors.group_id')
                ->leftJoin('principles', 'principles.id' , '=','groups.contractor_id')
                ->select(['principles.code', 'principles.company_name'])
                ->where('group_contractors.contractor_id', $case->casesable_id)->first();
        } */

        // $this->data['tradeSector'] = $tradeSectorData->tradeSector ?? '';
        // $this->data['parentData'] = $parentData ?? '';
        $this->data['companyProfile'] = $companyProfile ?? '';

        $this->data['getUnderwriterLog'] = UnderwriterCasesLog::with('underwriter', 'create_by')->where('cases_id', $id)->get();
        $this->data['bondTypes'] = $this->common->getBondTypes();
        // $this->data['uw_view'] = UwViewRating::where('slug', '!=', 'uwview-weightage')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $uwViewData = UwViewRating::where('slug', '!=', 'uwview-weightage')->get();
        $midOptAttr = [];
        $midArr = [];
        if (isset($uwViewData) && $uwViewData->count() > 0) {
            foreach ($uwViewData as $mkey => $mval) {
                $midOptAttr[$mval->id] = ['data-financial' => $mval->financial, 'data-non-financial' => $mval->non_financial];
                $midArr[$mval->id] =  $mval->name;
            }
        }
        $this->data['uw_view'] = $midArr;
        $this->data['mwOptAttr'] = $midOptAttr;

        $cases_actions_id = isset($case_action_plan) ? $case_action_plan->id : '';
        $this->data['cases_actions_id'] = $cases_actions_id;

        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($case->contractor->country_id);

        $this->data['contractor_kyc_documents'] = $case->contractor->dMS->groupBy('attachment_type') ?? [];
        // Tender Details

        // $this->data['tenderData'] = Tender::with('dMS')->where('id', $case->tender_id)->first() ?? [];        

        return view('cases.show',$this->data);
    }

    public function tenderEvaluation(Request $request, $proposal_id){
        $id = $request->get('id', false);       
        $proposal =  Proposal::with(['createdBy', 'beneficiary', 'contractor','tender','tenderEvaluation'])->findOrFail($proposal_id); 
            
        $proposal_evaluation =$proposal->tenderEvaluation->sortByDesc('id')->first();
        $evaluation_last_id =$proposal_evaluation->id ?? '';
        $last_id =$proposal->tenderEvaluation->sortByDesc('id');
        //$tenderEvaluation =  TenderEvaluation::with(['contractor','beneficiary','productAllowed','work_type','location'])->find($id);
        $this->data['proposal'] = $proposal;
       // $this->data['tenderEvaluation'] = $tenderEvaluation;
        $this->data['proposal_id'] = $proposal_id;
        $this->data['bondTypes'] = $this->common->getBondTypes();
        $this->data['projectTypes'] = $this->common->getProjectType();
        // $this->data['tenures'] = $this->common->getTenure();
        $this->data['id'] = $id;
        $allow_save = true;
        if($id > 0){
            $allow_save = ($evaluation_last_id == $id && in_array($proposal->status, ['Confirm'])) ? true : false;
        }
        $this->data['allow_save'] = $allow_save;
        $users = User::get();
        $user_data = [];
        if($users->count() > 0){
            foreach ($users as $key => $user) {
                $user_id = $user->id;
                $check_user = Sentinel::findById($user_id);
                if($check_user->hasAnyAccess(['proposals.approve_tender_evaluation'])){
                    $full_name = $user->first_name . " " . $user->last_name;
                    $user_data[$user_id] = $full_name;
                }
            }
        }
        $this->data['users'] = $user_data;
        $this->data['worktypes'] = $this->common->getWorkType();
        $this->data['states'] = $this->common->getStates();
        //return $this->data; 
    }

    public function tenderEvaluationStore(TenderEvaluationRequest $request){
        DB::beginTransaction();
        try{        
            $id = $request->id ?? '';
            $proposal_id = $request->proposal_id;
            if($id > 0){
                $product_allowed = $request->product_allowed ?? [];
                $work_type = $request->work_type ?? [];
                $locations = $request->locations ?? [];
                $tender_evaluation_data=[
                    'proposal_id'=>$proposal_id,
                    'cases_id'=>$request->cases_id,
                    'contractor_id'=>$request->contractor_id,
                    'rating_score'=>$request->rating_score ?? null,
                    'tender_id'=>$request->tender_id ?? null,
                    'project_description'=>$request->project_description ?? null,
                    'beneficiary_id'=>$request->beneficiary_id ?? null,
                    'project_value'=>$request->project_value ?? null,
                    'bond_value'=>$request->bond_value ?? null,
                    'overall_capacity'=>$request->overall_capacity ?? null,
                    'individual_capacity'=>$request->individual_capacity ?? null,
                    'old_contract_running_contract'=>$request->old_contract_running_contract ?? null,
                    'replacement_bg_for_existing_contract'=>$request->replacement_bg_for_existing_contract ?? null,
                    'experience_of_similar_contract_size'=>$request->experience_of_similar_contract_size ?? null,
                    'complexity_of_project_allowed'=>$request->complexity_of_project_allowed ?? null,
                    'type_of_projects_allowed'=>$request->type_of_projects_allowed ?? null,
                    'type_of_bond_allowed'=>$request->type_of_bond_allowed ?? null,
                    // 'tenure_id'=>$request->tenure ?? null,
                    'strategic_nature_of_the_project'=>$request->strategic_nature_of_the_project ?? null,
                    //'user_id'=>$request->user_id ?? null,
                    'bond_start_date'=>custom_date_format($request->bond_start_date,'Y-m-d'),
                    'bond_end_date'=>custom_date_format($request->bond_end_date,'Y-m-d'),
                    'bond_period'=>$request->bond_period,
                    'other_work_type'=>$request->other_work_type ?? null,
                    'remarks'=>$request->remarks ?? null,
                ];

                if($request->hasFile('attachment')){
                    $attachmentPath = uploadFile($request, 'proposal/' . $proposal_id, 'attachment');    
                    $tender_evaluation_data['attachment'] = $attachmentPath;
                }
                TenderEvaluation::where('id', $id)->update($tender_evaluation_data);

                if(!empty($product_allowed) && count($product_allowed) > 0){
                    TenderEvaluationProductAllowed::where('tender_evaluation_id',$id)->delete();
                    foreach ($product_allowed as $pa_key => $pa_value) {
                        $product_allowed_data = [
                            'tender_evaluation_id'=>$id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'project_type_id'=>$pa_value,
                        ];
                        TenderEvaluationProductAllowed::create($product_allowed_data);
                    }
                }
                if(!empty($work_type) && count($work_type) > 0){
                    TenderEvaluationWorkType::where('tender_evaluation_id',$id)->delete();
                    foreach ($work_type as $wt_key => $wt_value) {
                        $work_type_data = [
                            'tender_evaluation_id'=>$id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'work_type'=>$wt_value,
                        ];
                        TenderEvaluationWorkType::create($work_type_data);
                    }
                }
                if(!empty($locations) && count($locations) > 0){
                    TenderEvaluationLocation::where('tender_evaluation_id',$id)->delete();
                    foreach ($locations as $l_key => $l_row) {
                        $location_data = [
                            'tender_evaluation_id'=>$id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'state_id'=>$l_row['state_id'] ?? null,
                            'location'=>$l_row['location'] ?? null,
                        ];
                        TenderEvaluationLocation::create($location_data);
                    }
                }
                DB::commit();
                $message = 'This tender evaluation has been updated succesfully.';
                return redirect()->route('cases.show',[encryptId($request->cases_id)])->with('success',$message);
            }else{
                $check_entry = TenderEvaluation::latest()->first();
                $finishTime = Carbon::now();
                $totalDuration = 10;
                if (!empty($check_entry)) {
                    $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
                }
                if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
                    return redirect()->route('cases.show',[encryptId($request->cases_id)])->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
                }
                $product_allowed = $request->product_allowed ?? [];
                $work_type = $request->work_type ?? [];
                $locations = $request->locations ?? [];
                $attachmentPath = uploadFile($request, 'proposal/' . $proposal_id, 'attachment');
                $tender_evaluation_data=[
                    'proposal_id'=>$proposal_id,
                    'cases_id'=>$request->cases_id,
                    'contractor_id'=>$request->contractor_id,
                    'rating_score'=>$request->rating_score ?? null,
                    'tender_id'=>$request->tender_id ?? null,
                    'project_description'=>$request->project_description ?? null,
                    'beneficiary_id'=>$request->beneficiary_id ?? null,
                    'project_value'=>$request->project_value ?? null,
                    'bond_value'=>$request->bond_value ?? null,
                    'overall_capacity'=>$request->overall_capacity ?? null,
                    'individual_capacity'=>$request->individual_capacity ?? null,
                    'old_contract_running_contract'=>$request->old_contract_running_contract ?? null,
                    'replacement_bg_for_existing_contract'=>$request->replacement_bg_for_existing_contract ?? null,
                    'experience_of_similar_contract_size'=>$request->experience_of_similar_contract_size ?? null,
                    'complexity_of_project_allowed'=>$request->complexity_of_project_allowed ?? null,
                    'type_of_projects_allowed'=>$request->type_of_projects_allowed ?? null,
                    'type_of_bond_allowed'=>$request->type_of_bond_allowed ?? null,
                    // 'tenure_id'=>$request->tenure ?? null,
                    'strategic_nature_of_the_project'=>$request->strategic_nature_of_the_project ?? null,
                    //'user_id'=>$request->user_id ?? null,
                    'bond_start_date'=>custom_date_format($request->bond_start_date,'Y-m-d'),
                    'bond_end_date'=>custom_date_format($request->bond_end_date,'Y-m-d'),
                    'bond_period'=>$request->bond_period,
                    'other_work_type'=>$request->other_work_type ?? null,
                    'attachment'=>$attachmentPath,
                    'remarks'=>$request->remarks ?? null,
                ];
                $model = TenderEvaluation::create($tender_evaluation_data);
                $tender_evaluation_id = $model->id;
                if(!empty($product_allowed) && count($product_allowed) > 0){
                    foreach ($product_allowed as $pa_key => $pa_value) {
                        $product_allowed_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'project_type_id'=>$pa_value,
                        ];
                        TenderEvaluationProductAllowed::create($product_allowed_data);
                    }
                }
                if(!empty($work_type) && count($work_type) > 0){
                    foreach ($work_type as $wt_key => $wt_value) {
                        $work_type_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'work_type'=>$wt_value,
                        ];
                        TenderEvaluationWorkType::create($work_type_data);
                    }
                }
                if(!empty($locations) && count($locations) > 0){
                    foreach ($locations as $l_key => $l_row) {
                        $location_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'cases_id'=>$request->cases_id,
                            'state_id'=>$l_row['state_id'] ?? null,
                            'location'=>$l_row['location'] ?? null,
                        ];
                        TenderEvaluationLocation::create($location_data);
                    }
                }
                DB::table('proposals')->where('id',$proposal_id)->update(['tender_evaluation'=>'Yes']);
                DB::table('cases')->where('id',$request->cases_id)->update(['tender_evaluation'=>'Yes']);
                DB::commit();
                $message = 'This Tender evaluation has been added succesfully.';
                return redirect()->route('cases.show',[encryptId($request->cases_id)])->with('success',$message);
            }
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('cases.show',[encryptId($request->cases_id)])->with('error', __('common.something_went_wrong_please_try_again'));
        }
    }

    public function synopsisStore(SynopsisRequest $request){

       DB::beginTransaction();

       try {
        
            $cases = Cases::with('proposal')->findOrFail($request->cases_id);

            $cases->proposal()->update([
                'status'=>$cases->decision_status ?? null
            ]);
            
            $cases->update([
                'status'=>'Completed',
                'decision_taken_date'=>$this->now->format('Y-m-d'),
                'contractor_rating' => $request->contractor_rating ?? null,
                'uw_view_id' => $request->uw_view_id ?? null,
                'contractor_rating_date' => $this->now->format('Y-m-d')
            ]);

            $cases->contractor->update([
                'contractor_rating' => $request->contractor_rating ?? null,
                'uw_view_id' => $request->uw_view_id ?? null,
                'contractor_rating_date' => $this->now->format('Y-m-d'),
                'last_review_date'=>$this->now->format('Y-m-d')
            ]);

            //------------------------------------------------//

            //date:june-23-2025
            //now it's top most Approved or Issued
            if($cases->decision_status == 'Rejected'){
                // $rejectProposalID = Proposal::where('code', $cases->proposal_code)->whereIn('status', ['Approved', 'Issued'])->max('id');
                // if($rejectProposalID){
                //     Proposal::where('id', $rejectProposalID)->update(['is_amendment' => 0]);
                // }

                Proposal::where('id', $cases->proposal->proposal_parent_id)->update(['is_amendment' => 0]);
            }

            //------------------------------------------------//
           DB::commit(); 
           return redirect()->route('cases.index');   

       } catch (\Throwable $th) {
           DB::rollBack();
           return back()->with('error',__('common.something_went_wrong_please_try_again'));
       }

    }

    public function decisionStore(CasesDecisionRequest $request){

        $bond_value = $request->bond_value;
        $virtual_bond_value = $request->virtual_bond_value;
        DB::beginTransaction();
        try {
          
            $cases =  Cases::with('proposal')->findOrFail($request->cases_id);

            $cases->update([
                'decision_status'=>$request->decision_status ?? null,
                // 'bond_value'=>$request->bond_value ?? null,
                'decision_draft_taken_date'=>$this->now->format('Y-m-d')
            ]);

            $cases->proposal()->update([
                'is_amendment' => $request->decision_status == 'Rejected' ? 1 : 0,
            ]);
          
            $case_deciion = CasesDecision::updateOrCreate(['id'=>$request->cases_decision_id ?? null],[
                "proposal_id" => $request->proposal_id ?? null,
                "cases_id" => $request->cases_id ?? null,
                "contractor_id" => $request->contractor_id ?? null,
                "project_acceptable" => $request->project_acceptable ?? null,
                "project_acceptable_remark" => $request->project_acceptable_remark ?? null,
                "bond_type_id" => $request->bond_type_id ?? null,
                "bond_value" => $virtual_bond_value ?? null,
                "bond_start_date" => $request->bond_start_date ?? null,
                "bond_end_date" => $request->bond_end_date ?? null,
                "decision_status" => $request->decision_status ?? null,
                "remark"=>$request->remark ?? null,
                "is_amendment"=>$cases->is_amendment ?? null
            ]);         
            
            $bond_limit_strategy =  CasesBondLimitStrategy::firstWhere([
                'cases_action_plan_id'=>$request->case_action_plan_id,
                'bond_type_id'=>$request->bond_type_id,
                'is_current'=>0
           ]);

           $bond_limit_strategy_all =  CasesBondLimitStrategy::where([
                'cases_action_plan_id'=>$request->case_action_plan_id,
                'bond_type_id'=>$request->bond_type_id,
           ])->get();
           

           $case_limit_strategy =  CasesLimitStrategy::firstWhere([
                'cases_action_plan_id'=>$request->case_action_plan_id,
                'is_current'=>0
           ]);

            /************************************************************************************/

            //date:june-24-2025
            //now it's top most Completed is_current 0 for approved limit tab inside cases

            // if($request->decision_status == 'Rejected'){
                $max_of_proposal_completed_case_id = Cases::where('proposal_code', $cases->proposal_code)
                ->where('decision_status','Approved')
                ->max('id');

                Cases::where('proposal_code', $cases->proposal_code)
                ->where('decision_status','Approved')
                ->update([
                    'is_current'=>NULL
                ]);
                
                Cases::where('id',$max_of_proposal_completed_case_id)->update([
                    'is_current'=>0
                ]);
            // }

            /************************************************************************************/
           

          if (isset($bond_limit_strategy) && isset($case_limit_strategy)  && $cases->proposal->version > 1) {

              //cases is_amendment flag change
                // dd($proposals->id);
                $previous_cases = Cases::firstWhere(['status'=>'Completed','proposal_id'=>$cases->proposal_parent_id]);
    
                $previous_cases->update([
                    'is_amendment'=>1
                ]);
                $previous_cases->casesDecision()->update([
                    'is_amendment'=>1
                ]);

                $bond_limit_strategy->utilizedlimit()->where([
                    'proposal_code'=>$previous_cases->proposal->code
                ])->update([
                    'is_amendment'=>1,
                    'is_current'=>1
                ]);

                $case_limit_strategy->utilizedlimit()->where([
                    'proposal_code'=>$previous_cases->proposal->code
                ])->update([
                    'is_amendment'=>1,
                    'is_current'=>1
                ]);
          }

          if(isset($bond_limit_strategy) && isset($case_limit_strategy)){
            
            $bond_limit_strategy->utilizedlimit()->create([
                'contractor_id'=>$request->contractor_id ?? null,
                'proposal_id'=>$cases->proposal->id ?? null,
                'proposal_code'=>$cases->proposal->code ?? null,
                'cases_action_plan_id'=>$request->case_action_plan_id ?? null,
                'cases_id'=>$cases->id ?? null,
                'bond_type_id'=>$cases->bond_type_id,
                'cases_decisions_id'=>$case_deciion->id,
                'value'=>$virtual_bond_value,
                'decision_status'=>$request->decision_status,
                'bond_end_date'=>$cases->bond_end_date,
                'is_amendment'=>0,
                'is_current'=>0
           ]);

           $case_limit_strategy->utilizedlimit()->create([
                'contractor_id'=>$request->contractor_id ?? null,
                'proposal_id'=>$cases->proposal->id ?? null,
                'proposal_code'=>$cases->proposal->code ?? null,
                'cases_action_plan_id'=>$request->case_action_plan_id ?? null,
                'cases_id'=>$cases->id ?? null,
                'bond_type_id'=>$cases->bond_type_id,
                'cases_decisions_id'=>$case_deciion->id,
                'value'=>$virtual_bond_value,
                'decision_status'=>$request->decision_status,
                'bond_end_date'=>$cases->bond_end_date,
                'is_amendment'=>0,
                'is_current'=>0
            ]);

            $max_of_utilized_approved = UtilizedLimitStrategys::select(DB::raw('MAX(id) as id'))->where('proposal_code', $cases->proposal_code)
            // ->whereMorphedTo('strategyable',$bond_limit_strategy)
            ->where('strategyable_type','CasesBondLimitStrategy')
            ->where('decision_status','Approved')
            ->max('id');
            

            // $bond_limit_strategy->utilizedlimit()->where('proposal_code', $cases->proposal_code)
            // ->update([
            //     'is_last_of_approved'=>NULL
            // ]);

            // $case_limit_strategy->utilizedlimit()->where('proposal_code', $cases->proposal_code)
            // ->update([
            //     'is_last_of_approved'=>NULL
            // ]);

            $bond_limit_strategy_all->each(function($item)use($cases){
                $item->utilizedlimit()->where('proposal_code', $cases->proposal_code)
                ->update([
                    'is_last_of_approved'=>NULL
                ]);
            });
                
            UtilizedLimitStrategys::where('id',$max_of_utilized_approved)->update([
                'is_last_of_approved'=>0
            ]);

            $bond_current_cap = $bond_limit_strategy->bond_current_cap;
            $bond_contractor_bond_wise_utilized_cap = $bond_limit_strategy->utilizedlimitTopOfApproved($cases->bond_type_id)->sum('value');
            $bond_utilized_cap = $bond_contractor_bond_wise_utilized_cap;
            $bond_utilized_cap_persontage = safe_divide($bond_utilized_cap * 100, $bond_current_cap);
            $bond_remaining_cap = $bond_current_cap - $bond_utilized_cap;
            $bond_remaining_cap_persontage = safe_divide($bond_remaining_cap * 100, $bond_current_cap);

           $bond_limit_strategy->update([
                'bond_utilized_cap'=>$bond_utilized_cap,
                'bond_utilized_cap_persontage'=>$bond_utilized_cap_persontage,
                'bond_remaining_cap'=>$bond_remaining_cap,
                'bond_remaining_cap_persontage'=>$bond_remaining_cap_persontage
           ]);

          }

            // $bond_limit_strategy->increment('bond_utilized_cap',(int)$request->bond_value);
            // $bond_limit_strategy->decrement('bond_remaining_cap',(int)$request->bond_value);

            $this->genrateEndorsement($request->proposal_id,$request->cases_id);

            DB::commit();
            return back()->withSuccess(__('common.create_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',__('common.something_went_wrong_please_try_again'));
        }
    }

    public function storeCasesParameter(CasesParameterRequest $request ,$id){

        $bond = $request->bond ?? [];
        $user = Sentinel::getUser();
        $case = Cases::findOrFail($id);
        $casesActionPlan = CasesActionPlan::where('contractor_id',$request->contractor_id)->first();
        $casesable_id = $case->casesable_id;
        DB::beginTransaction();
        $cases_action_plan_id  = $casesActionPlan->id;

        try {
            
            if (count($bond) > 0) {
                foreach ($bond as $key => $bond) {
                    if ($bond['proposed_cap'] != '' || $bond['valid_till'] != '') {

                        CasesBondLimitStrategy::where('bond_type_id',$bond['bond_type_id'])
                        ->where('contractor_id',$request->contractor_id)
                        ->update(['is_current'=>1]);


                        $bondArr =[
                            'contractor_id'=>$request->contractor_id ?? null,
                            'cases_id' => $id,
                            'casesable_type' => $case->casesable_type,
                            'casesable_id' => $casesable_id,
                            'cases_action_plan_id' => $cases_action_plan_id,
                            'bond_type_id'=>$bond['bond_type_id'],
                            'bond_current_cap' => $bond['proposed_cap'],
                            'bond_utilized_cap' => $bond['utilized_cap'],
                            'bond_remaining_cap' => ($bond['proposed_cap'] - $bond['utilized_cap']),
                            'bond_proposed_cap' => $bond['proposed_cap'],
                            'bond_valid_till' => $bond['valid_till'],
                            'is_current'=>0,
                            'status' => 'Save',
                            'created_by' => $user->id
                        ];

                        $bond_utilized_cap_percentage = safe_divide($bondArr['bond_utilized_cap'] * 100, $bondArr['bond_current_cap']);
                        $bond_remaining_cap_percentage = safe_divide($bondArr['bond_remaining_cap'] * 100, $bondArr['bond_current_cap']);
                    
                        $bondArr['bond_utilized_cap_persontage'] = $bond_utilized_cap_percentage;
                        $bondArr['bond_remaining_cap_persontage'] =$bond_remaining_cap_percentage;

                        CasesBondLimitStrategy::create($bondArr);
                    }
                }
            }
            DB::commit();
            return back()->withSuccess(__('common.create_success'));

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error',__('common.something_went_wrong_please_try_again'));
        }
    }

    public function caseDmsMail($id){
        
        $this->data['user'] = User::findOrFail($id);
        $smtp_details = get_smtp_details('open_query');
        $this->data['message_body'] = $smtp_details->message_body ?? '';
        $this->data['subject'] = $smtp_details->subject ?? '';
        // dd($this->data['buyer']);
        return response()->json(['html' => view('cases.modal.dms.dms_mail.dms_mail', $this->data)->render()]);
    }

    public function sendcaseDmsMail(Request $request){
        
       $validated =  $request->validate([
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required'
        ]);

        try {
            $this->common->sendCustomMail('open_query',$validated);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }

        return redirect()->back()->withSuccess(__('common.mail_send_success'));

    }

    public function caseCancel(Request $request){

        $validated = $request->validate([
            'checked'=>'required|array'
        ]);



        DB::beginTransaction();
        try {

            $cases = Cases::whereIntegerInRaw('id',$validated['checked']);
            $cases->each(function($iteration){
                $dms = $iteration->dMS()->pluck('attachment');
                $iteration->dMS()->delete();
                unlink_file($dms,true);
            });
            $cases->update([
                'status'=>'Cancel'
            ]);
            $proposal_ids = $cases->pluck('proposal_id')->filter()->unique();
            
            Proposal::whereIntegerInRaw('id',$proposal_ids)
            ->update(['status'=>'Pending']);

        
            DB::commit();
            return response()->json(['success'=>__('common.update_success')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error'=>__('common.something_went_wrong_please_try_again')]);
        }
    }

    public function  caasesAssignUnderwriter(Request $request){
       $validated =  $request->validate([
            'underwriter_id'=>'required',
            'checked'=>'required|array'
        ]);

         list($underwriter_type,$underwriter_id) = parseGroupedOptionValue($validated['underwriter_id']);

        DB::beginTransaction();
        try {
            Cases::whereIntegerInRaw('id',$validated['checked'])->update(
                [    
                    'underwriter_id'=> $underwriter_id,
                    'underwriter_type'=>$underwriter_type,
                    'underwriter_assigned_date' => $this->now
                ]
            );

            foreach($validated['checked'] as $item){
                UnderwriterCasesLog::create([
                    'casesable_type'=>'Cases',
                    'casesable_id'=>$item,
                    'cases_id' => $item,
                    'underwriter_id'=> $underwriter_id,
                    'underwriter_type'=>$underwriter_type
                ]);
            }

            DB::commit();
            return response()->json(['success'=>__('common.update_success')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error'=>__('common.something_went_wrong_please_try_again')]);
        }
    }

    public function dmsattachment(CasesDmsAttachmentRequest $request){
        

        // $validated = $request->validate([
        //     'final_submission'=>'required',
        //     'document_type_id'=>'required',
        //     'file_source_id'=>'required',
        //     'attachment.*'=>'mimes:doc,png,jpg,jpeg,webp,pdf,docx,xlsx,txt,xml|max:2048',
        //     'id'=>'required'
        // ]);

       DB::beginTransaction();

       try {
        
            $case = Cases::findOrFail($request['id']);
            // dd($case);
            if($request->document_specific_type == 'Contractor'){
                foreach ($request['attachment'] as $item) {
                    if ($item instanceof \Illuminate\Http\UploadedFile) {
                        $filePath = $this->common->uploadFile($request, 'cases/other/' . $case->contractor_id, 'attachment', $item);
                        $fileName = basename($filePath);

                        DMS::create([
                            'dmsable_type' => 'Other',
                            'dmsable_id' => $case->contractor_id ?? null,
                            'file_name' => $fileName,
                            'attachment' => $filePath,
                            'attachment_type' => 'attachment',
                            'file_source_id'=>$request->file_source_id ?? null,
                            'document_type_id'=>$request->document_type_id ??  null,
                            'final_submission'=>$request->final_submission ??  'No',
                            'dmsamend_type' => 'Principle',
                            'dmsamend_id' => $case->contractor_id ?? null,
                            'document_specific_type' => 'Contractor',
                        ]);
                    }
                }
            } else {
                $request->request->add(['dmsamend_type' => $case->casesable_type,'dmsamend_id' => $case->casesable_id, 'document_specific_type' => 'Project']);
                $this->common->storeMultipleFiles($request,$request['attachment'],'attachment',$case,$case->id,'cases');
            }

            DB::commit();

            return back()->withSuccess(__('common.create_success'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(__('common.something_went_wrong_please_try_again'));
        }

    }

    public function dmsattachmentdownload($id){
        $dms_attachments = DMS::AttachmentInsideDmsTab('Cases',$id)->get();

        $this->data['dms_attachments'] = $dms_attachments;

        return response()->json(['html'=> view('cases.modal.dms.dms_download_attachment.index',$this->data)->render()]);
    
    }

    public function dmsAttachmentComment($id){
        
        $dms_attachment = DMS::AttachmentInsideDmsTab('Cases',$id)->first();
        $this->data['dms_attachment'] = $dms_attachment;

        return response()->json(['html'=>view('cases.modal.dms.dms_comment.index',$this->data)->render()]);
    }

    public function dmsAttachmentStoreComment(Request $request){

       $validated =  $request->validate([
            'comment'=>['required', new Remarks],
            'dms_id'=>'required'
        ]);

        $dms = DmsComment::create($validated);

        if ($dms) {
            return back()->withSuccess(__('common.create_success'));
        }
        return back()->withErrors(__('common.something_went_wrong_please_try_again'));
    }

    public function dmsAttachmentCommentLog($id){

        $comments = DmsComment::with('createdBy')->where('dms_id',$id)->get();
        $this->data['comments'] = $comments;

        return response()->json(['html'=> view('cases.modal.dms.dms_comment_log.index',$this->data)->render()]);
      
    }
    public function storeCasesActionPlan(CasesActionPlanRequest $request, $id)
    {
        $adverse_notification = $request->adverse_notification ?? '';
        $is_reload = $request->is_reload ?? '0';
        $losses = $request->losses ?? [];
        $balancea = $request->balancea ?? [];
        $balanceb = $request->balanceb ?? [];
        $ratios = $request->ratios ?? [];
        $proposed = $request->proposed ?? [];
        // $bond = $request->bond ?? [];
        /*$validated = $request->validate([
            'reason_for_submission'=>'required',
            'adverse_notification'=>'required',
            'adverse_notification_remark'=>($adverse_notification == 'Yes') ? 'required' : '',
        ]);*/        
       DB::beginTransaction();
       try {
            $case = Cases::findOrFail($id);
            $casesActionPlan = CasesActionPlan::where('contractor_id', $request->contractor_id)->first();
            $casesable_id = $case->casesable_id;
            $casesActionPlanInput = [
                'cases_id'=>$id,
                'contractor_id'=>$request->contractor_id ?? null,
            ];
            if ($casesActionPlan) {
                $casesActionPlan->update($casesActionPlanInput);
            } else {
                $casesActionPlan = CasesActionPlan::create($casesActionPlanInput);
            }
            $casesInput = [
                'cases_action_reason_for_submission'=>$request->cases_action_reason_for_submission ?? null,
                'cases_action_amendment_type'=> $request->cases_action_reason_for_submission == "Amendment" ? $request->cases_action_amendment_type : null,
                'cases_action_adverse_notification'=>$request->cases_action_adverse_notification ?? null,
                'cases_action_adverse_notification_remark'=>$request->cases_action_adverse_notification_remark ?? null,
                'cases_action_beneficiary_acceptable'=>$request->cases_action_beneficiary_acceptable ?? null,
                'cases_action_beneficiary_acceptable_remark'=>$request->cases_action_beneficiary_acceptable_remark ?? null,
                'cases_action_bond_invocation'=>$request->cases_action_bond_invocation ?? null,
                'cases_action_bond_invocation_remark'=>$request->cases_action_bond_invocation_remark ?? null,
                'cases_action_blacklisted_contractor'=>$request->cases_action_blacklisted_contractor ?? null,
                'cases_action_blacklisted_contractor_remark'=>$request->cases_action_blacklisted_contractor_remark ?? null,
                'cases_action_audited'=>$request->cases_action_audited ?? null,
                'cases_action_consolidated'=>$request->cases_action_consolidated ?? null,
                'cases_action_currency_id'=>$request->cases_action_currency_id ?? null
            ];
            $case->update($casesInput);
            $cases_action_plan_id  = $casesActionPlan->id;
            // $balance = [];
            // if (count($balancea) > 0 && count($balanceb) > 0) {
            //     $balance = array_merge($balancea, $balanceb);
            // }
            // if (isset($losses) &&  count($losses) > 0) {
            //     // ProfitLoss::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
            //     $lossesArr = [];
            //     foreach ($losses as $lkey => $lrow) {
            //         if (!empty($lrow)) {
            //             $lossesArr[$lkey] = json_encode($lrow);
            //         }
            //     }
            //     $lossesArr['cases_action_plan_id'] =  $cases_action_plan_id;
            //     $lossesArr['casesable_type'] =  $case->casesable_type;
            //     $lossesArr['casesable_id'] =  $casesable_id;
            //     $lossesArr['cases_id'] =  $id;
            //     $lossesArr['contractor_id'] = $case->contractor_id;
            //     ProfitLoss::updateOrCreate(['contractor_id'=>$case->contractor_id],$lossesArr);
            // }
            // if (count($balance)  > 0) {
            //     // BalanceSheet::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
            //     $balanceArr = [];
            //     $year_id = 0;
            //     $last_bs_date = '';
            //     foreach ($balance as $bkey => $brow) {
            //         $keysArr = array_keys($brow);
            //         arsort($keysArr);
            //         $dateArr = explode('_', current($keysArr));
            //         $last_bs_date = $dateArr[1];
            //         $year_id = $keysArr[0];
            //         if (!empty($brow)) {
            //             $balanceArr[$bkey] = json_encode($brow);
            //         }
            //     }
            //     $case->update(['last_bs_date' => $last_bs_date]);
            //     $balanceArr['cases_action_plan_id'] =  $cases_action_plan_id;
            //     $balanceArr['casesable_type'] =  $case->casesable_type;
            //     $balanceArr['casesable_id'] =  $casesable_id;
            //     $balanceArr['cases_id'] =  $id;
            //     $lossesArr['contractor_id'] = $case->contractor_id;
            //     BalanceSheet::updateOrCreate(['contractor_id'=>$case->contractor_id],$balanceArr);
            // }
            // if (count($ratios) > 0) {
            //     // Ratio::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
            //     $ratiosArr = [];
            //     foreach ($ratios as $rkey => $rrow) {
            //         if (!empty($rrow)) {
            //             $ratiosArr[$rkey] = json_encode($rrow);
            //         }
            //     }
            //     $ratiosArr['cases_action_plan_id'] =  $cases_action_plan_id;
            //     $ratiosArr['casesable_type'] =  $case->casesable_type;
            //     $ratiosArr['casesable_id'] =  $casesable_id;
            //     $ratiosArr['cases_id'] =  $id;
            //     $lossesArr['contractor_id'] = $case->contractor_id;
            //     Ratio::updateOrCreate(['contractor_id'=>$case->contractor_id],$ratiosArr);
            // }
            $user = Sentinel::getUser();
            if (count($proposed) > 0) {
                if ($proposed['proposed_individual_cap'] != '' && $proposed['proposed_overall_cap'] != '' &&  $proposed['proposed_valid_till'] != '') {
                    CasesLimitStrategy::where('contractor_id',$request['contractor_id'])
                    ->update(['is_current'=>1]);

                    $proposedArr =[
                        'contractor_id'=>$request->contractor_id ?? null,
                        'cases_id' => $id,
                        'casesable_type' => $case->casesable_type,
                        'casesable_id' => $casesable_id,
                        'cases_action_plan_id' => $cases_action_plan_id,
                        'proposed_individual_cap' => $proposed['proposed_individual_cap'],
                        'proposed_overall_cap' => $proposed['proposed_overall_cap'],
                        'proposed_valid_till' => $proposed['proposed_valid_till'],
                        'proposed_group_cap' => $proposed['proposed_group_cap'],
                        'is_current'=>0,
                        'status' => 'Save',
                        'created_by' => $user->id
                    ];
                    CasesLimitStrategy::create($proposedArr);
                    $groupData = Group::with('groupContractor')->where('contractor_id',$casesable_id)->orWhereHas('groupContractor',function($qry) use($casesable_id){$qry->where('contractor_id',$casesable_id);})->first();
                    if(!is_null($groupData)){
                        $groupData->group_cap = $proposedArr['proposed_group_cap'];
                        $groupData->save();
                    }
                }
            }

            // if (count($bond) > 0) {
            //     foreach ($bond as $key => $bond) {
            //         if ($bond['bond_type_id'] != '' || $bond['current_cap'] != '' ||  $bond['utilized_cap'] != '' || $bond['remaining_cap'] != '' ||  $bond['proposed_cap'] != '' || $bond['valid_till'] != '') {

            //             CasesBondLimitStrategy::where('bond_type_id',$bond['bond_type_id'])
            //             ->update(['is_amend'=>1]);

            //             $bondArr =[
            //                 'contractor_id'=>$request->contractor_id ?? null,
            //                 'cases_id' => $id,
            //                 'casesable_type' => $case->casesable_type,
            //                 'casesable_id' => $casesable_id,
            //                 'cases_action_plan_id' => $cases_action_plan_id,
            //                 'bond_type_id'=>$bond['bond_type_id'],
            //                 'bond_current_cap' => $bond['proposed_cap'],
            //                 'bond_utilized_cap' => $bond['utilized_cap'],
            //                 'bond_remaining_cap' => ($bond['proposed_cap'] - $bond['utilized_cap']),
            //                 'bond_proposed_cap' => $bond['proposed_cap'],
            //                 'bond_valid_till' => $bond['valid_till'],
            //                 'is_amend'=>0,
            //                 'status' => 'Save',
            //                 'created_by' => $user->id
            //             ];
            //             CasesBondLimitStrategy::upsert($bondArr, ['cases_action_plan_id','bond_type_id', 'bond_current_cap', 'bond_utilized_cap', 'bond_remaining_cap', 'bond_proposed_cap']);
            //         }
            //     }
            // }
            DB::commit();
            if($is_reload == '1'){
                return response()->json([
                    'success' => true,
                    'message' => __('cases.action_plan_has_been_updated_successfully')
                ], 200);
            }else{
                return back()->withSuccess(__('cases.action_plan_has_been_updated_successfully'));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if($is_reload == '1'){
                return response()->json([
                    'success' => false,
                    'message' => __('common.something_went_wrong_please_try_again')
                ], 200);
            }else{
                return back()->withErrors(__('common.something_went_wrong_please_try_again'));
            }
        }
    }

    public function projectDetailsStore(casesProjectDetailsRequest $request){

        $input = $request->only([
            'project_details_current_status_of_the_project',
            'project_details_any_updates'
        ]);
        
        DB::beginTransaction();

        try {

            $cases_id = $request->cases_id ?? null;
            Cases::where('id',$cases_id)->update($input);
            DB::commit();
            return back()->withSuccess(__('common.update_success'));
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',__('common.something_went_wrong_please_try_again'));
        }
    }

    public function storeCasesActionPlanFinancials(CasesActionPlanFinancialsRequest $request,$id){
     
        $losses = $request->losses ?? [];
        $balancea = $request->balancea ?? [];
        $balanceb = $request->balanceb ?? [];
        $ratios = $request->ratios ?? [];
        $proposed = $request->proposed ?? [];
        $balance = [];

        DB::beginTransaction();
      
        try {

            $case = Cases::findOrFail($id);
            $casesActionPlan = CasesActionPlan::where('contractor_id', $request->contractor_id)->first();
            $casesable_id = $case->casesable_id;
            $casesActionPlanInput = [
                'cases_id'=>$id,
                'contractor_id'=>$case->contractor_id ?? null,
            ];
            if ($casesActionPlan) {
                $casesActionPlan->update($casesActionPlanInput);
            } else {
                $casesActionPlan = CasesActionPlan::create($casesActionPlanInput);
            }
            $cases_action_plan_id  = $casesActionPlan->id;
            if (count($balancea) > 0 && count($balanceb) > 0) {
                $balance = array_merge($balancea, $balanceb);
            }
            if (isset($losses) &&  count($losses) > 0) {
                // ProfitLoss::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
                $lossesArr = [];
                foreach ($losses as $lkey => $lrow) {
                    if (!empty($lrow)) {
                        $lossesArr[$lkey] = json_encode($lrow);
                    }
                }
                $lossesArr['cases_action_plan_id'] =  $cases_action_plan_id;
                $lossesArr['casesable_type'] =  $case->casesable_type;
                $lossesArr['casesable_id'] =  $casesable_id;
                $lossesArr['cases_id'] =  $id;
                $lossesArr['contractor_id'] = $case->contractor_id;
                ProfitLoss::updateOrCreate(['contractor_id'=>$case->contractor_id],$lossesArr);
            }
            if (count($balance)  > 0) {
                // BalanceSheet::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
                $balanceArr = [];
                $year_id = 0;
                $last_bs_date = '';
                foreach ($balance as $bkey => $brow) {
                    $keysArr = array_keys($brow);
                    arsort($keysArr);
                    $dateArr = explode('_', current($keysArr));
                    $last_bs_date = $dateArr[1];
                    $year_id = $keysArr[0];
                    if (!empty($brow)) {
                        $balanceArr[$bkey] = json_encode($brow);
                    }
                }
                $case->update(['last_bs_date' => $last_bs_date]);
                $balanceArr['cases_action_plan_id'] =  $cases_action_plan_id;
                $balanceArr['casesable_type'] =  $case->casesable_type;
                $balanceArr['casesable_id'] =  $casesable_id;
                $balanceArr['cases_id'] =  $id;
                $lossesArr['contractor_id'] = $case->contractor_id;
                BalanceSheet::updateOrCreate(['contractor_id'=>$case->contractor_id],$balanceArr);
            }
            if (count($ratios) > 0) {
                // Ratio::where('cases_action_plan_id', $cases_action_plan_id)->forceDelete();
                $ratiosArr = [];
                foreach ($ratios as $rkey => $rrow) {
                    if (!empty($rrow)) {
                        $ratiosArr[$rkey] = json_encode($rrow);
                    }
                }
                $ratiosArr['cases_action_plan_id'] =  $cases_action_plan_id;
                $ratiosArr['casesable_type'] =  $case->casesable_type;
                $ratiosArr['casesable_id'] =  $casesable_id;
                $ratiosArr['cases_id'] =  $id;
                $lossesArr['contractor_id'] = $case->contractor_id;
                Ratio::updateOrCreate(['contractor_id'=>$case->contractor_id],$ratiosArr);
            }
            Principle::where('id',$case->contractor_id)->update(['last_balance_sheet_date'=>$this->now]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('cases.action_plan_has_been_updated_successfully')
            ], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('common.something_went_wrong_please_try_again')
            ], 200);
        }


       
    }

    public function saveAnaysis(Request $request){
        $contractor_id = $request->contractor_id ?? null;
        $case_id = $request->case_id ?? null;
        $description = $request->description ?? null;
        if ($contractor_id > 0) {
            $casesActionPlan = CasesActionPlan::where('contractor_id', $contractor_id)->first();
            if (is_null($casesActionPlan)) {
                $casesActionPlan = CasesActionPlan::create([
                    'contractor_id'=>$contractor_id,
                    'cases_id'=>$case_id
                ]);
            }
            $case_action_plan_id = $casesActionPlan->id ?? null;
            $insertData = [
                'case_id' => $case_id,
                'contractor_id'=>$contractor_id,
                'case_action_plan_id' => $case_action_plan_id,
                'description' => $description
            ];
            Analysis::create($insertData);
            Principle::where('id',$contractor_id)->update(['last_analysis_date'=>$this->now]);

            $this->data['analysis'] = Analysis::with(['createdBy'])->where('case_action_plan_id', $case_action_plan_id)->orderBy('id', 'DESC')->get();
            
            return response()->json([
                'success' => true,
                'analysis'=>view('cases.tabs.action-plan.analysistimeline_log',$this->data)->render(),
                'message' => __('cases.analysis_comment_added_successfully')
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => __('common.something_went_wrong_please_try_again')
            ], 200);
        }
    }
    public function actionPlanData(Request $request){
        $datesArr = $request->datesArr;
        $case_id = $request->case_id;
        $case_action_plan_id = $request->case_action_plan_id ?? 0;
        $this->data['datesArr'] = $datesArr;
        $lossData = [];
        $balanceSheetData = [];
        $ratiosData = [];
        if ($case_id > 0) {
            $this->data['case_id'] = $case_id;
            $cases = Cases::where('id', $case_id)->first();
            $casesActionPlan = CasesActionPlan::with(['profitLoss','balanceSheet'])->where('id', $case_action_plan_id)->first();
            if (isset($casesActionPlan->profitLoss) && $casesActionPlan->profitLoss->count() > 0) {
                $profitLoss = $casesActionPlan->profitLoss->toArray();
                if (isset($profitLoss) && count($profitLoss) > 0) {
                    foreach ($profitLoss as $loskey => $losval) {
                        $lossData[$loskey] = json_decode($losval, true);
                    }
                }
            }
            if (isset($casesActionPlan->balanceSheet) && $casesActionPlan->balanceSheet->count() > 0) {
                $balanceSheet = $casesActionPlan->balanceSheet->toArray();
                if (isset($balanceSheet) && count($balanceSheet) > 0) {
                    foreach ($balanceSheet as $bkey => $bval) {
                        $balanceSheetData[$bkey] = json_decode($bval, true);
                    }
                }
            }
            if (isset($casesActionPlan->ratios) && $casesActionPlan->ratios->count() > 0) {
                $ratios = $casesActionPlan->ratios->toArray();
                if (isset($ratios) && count($ratios) > 0) {
                    foreach ($ratios as $rkey => $rval) {
                        $ratiosData[$rkey] = json_decode($rval, true);
                    }
                }
            }
        }
        $this->data['lossData'] = $lossData;
        $this->data['balanceSheetData'] = $balanceSheetData;
        $this->data['ratiosData'] = $ratiosData;
        $dateList = '';
        $dateArrDesc = [];
        if(!empty($datesArr)){
            foreach ($datesArr as $dkey => $dval) {
                $datelistArr = explode("_", $dval);
                $fromDate = Carbon::parse($datelistArr[0])->format('d/m/Y');
                $toDate = Carbon::parse($datelistArr[1])->format('d/m/Y');
                array_push($dateArrDesc, $fromDate);
                $dateList .= '<span class="btn btn-light-dark font-weight-bold mr-2 mt-5 p-2 jsRemoveDate remove-filter filter_' . $dval . '" data-date-name="filter_' . $dval . '"> <i class="ki ki-bold-close icon-sm"></i>' . $fromDate . ' To ' . $toDate . '</span>';
            }
        }
        $this->data['profit_loss'] = Config('project.profit_loss');
        $this->data['ratios'] = Config('project.ratios');
        $this->data['balance_sheet_a'] = Config('project.balance_sheet_a');
        $this->data['balance_sheet_b'] = Config('project.balance_sheet_b');
        return response()->json([
            'profit_loss' =>  view('cases.tabs.action-plan.profit-loss', $this->data)->render(),
            'ratios' =>  view('cases.tabs.action-plan.ratios', $this->data)->render(),
            'balance_sheet' =>  view('cases.tabs.action-plan.balance-sheet', $this->data)->render(),
            'dateList' =>  $dateList
        ]);
    }
    public function transferUnderwriter(Request $request)
    {
        DB::beginTransaction();
       try {
            $validated =  $request->validate([
                'transfernote'=>'required',
                'transfer'=>'required',
            ]);

            $cases_id = $request->cases_id;
            $notes = $request->transfernote;
            $cases_action_plan_id = $request->cases_action_plan_id;
            $transfer_date = $request->transfer_date;

            list($underwriter_type,$underwriter_id) = parseGroupedOptionValue($request->transfer);

            $cases = Cases::findOrFail($cases_id);

            $cases->underwriter_log()->create([
                "cases_action_plan_id" => $cases_action_plan_id, 
                "cases_id" => $cases_id, 
                "underwriter_id" => $underwriter_id,
                "underwriter_type"=>$underwriter_type, 
                "notes" => $notes
            ]);
            
            $cases->update([
                "underwriter_id" => $underwriter_id,
                "underwriter_type"=>$underwriter_type,
                "transfer_decision_notes" => $notes,
                "transfer_date" => $transfer_date
            ]);
            DB::commit();
            return redirect()->route('cases.index')->with('success', __('common.update_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('cases.index')->with('success', __('common.something_went_wrong_please_try_again'));
        }
    }
    public function dmsUpdate(Request $request,$id){

        $validated = $request->validate([
            'final_submission'=>'required',
            'document_type_id'=>'required',
            'file_source_id'=>'required',
            'cases_id'=>'required'
        ]);
       DB::beginTransaction();

       try {
            /*$dmsamend_id = $request->dmsamend_id ?? null;*/
            $case = Cases::findOrFail($validated['cases_id']);
            $update_data = [
                'final_submission'=>$request->final_submission ??  'No',
                /*'dmsamend_id'=>$dmsamend_id,
                'dmsamend_type'=>($dmsamend_id > 0) ? 'Principle':  Null,*/
                'document_type_id'=>$request->document_type_id ??  Null,
                'file_source_id'=>$request->file_source_id ??  Null,
            ];
            DMS::where('id', $id)->update($update_data);
            DB::commit();
            return back()->withSuccess(__('dms.amendment_hase_been_successfully'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(__('common.something_went_wrong_please_try_again'));
        }
    }

    private function genrateEndorsement($proposal_id,$cases_id){
        $proposal = Proposal::findOrFail($proposal_id);
        $cases = Cases::findOrFail($cases_id);

        $endorsement_prefix = $this->common->EndorsementIDGenerator(
            $proposal->getBondType->prefix,
            5
           );

        $endorsement =  Endorsement::create([
            'endorsement_number'=>$endorsement_prefix,
            'proposal_id'=>$proposal_id ?? null,
            'cases_id'=>$cases_id ?? null
        ]);

        $endorsement->dMS()->create([
            'file_name' => $endorsement_prefix,
            'attachment' => "uploads/endorsement/{$endorsement_prefix}.pdf",
            'attachment_type' => 'endorsement',
        ]);

        $this->data['proposal'] = $proposal;
        $this->data['endorsement'] = $endorsement;
        $this->data['cases'] = $cases;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($cases->contractor->country_id);


        $pdf = PDF::loadView('proposals.endorsment_print',$this->data);
        $pdf->setOrientation('portrait');
        $pdf->setOptions(['footer-right' => '[page] / [topage]']);
        $pdf->setOption('margin-right', 9);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 8);
        $pdf->setOption('title', 'Endorsement | PDF');


       $pdf->save("uploads/endorsement/{$endorsement_prefix}.pdf");

       
    }

    public function calculateRating(Request $request)
    {
        // dd($request->all());
        $staffstrength = $request->staffstrength;
        $date_of_incorporation = $request->date_of_incorporation;
        $uw_view = $request->uw_view;
        $countryMidlevel = $request->countryMidlevel;
        $sectormidlevel = $request->sectormidlevel;
        $casesActionsId = $request->cases_actions_id;

        if ($casesActionsId > 0) {
            $data['contractorRatingName'] = 'Financial';
            $uwRatingFinancial = $request->uwRatingFinancial ?? null;
            $data['uwRate'] = $request->uwRatingFinancial ?? null;
        } else {
            $data['contractorRatingName'] = 'Non Financial';
            $uwRatingFinancial = $request->uwRatingNonFinancial ?? null;
            $data['uwRate'] = $request->uwRatingNonFinancial ?? null;
        }

        $contractorRating = 0;
        if ($uw_view) {
            $contractorRating += $uwRatingFinancial;
        }
        if ($countryMidlevel) {
            $countryRateData = CountryRating::find($countryMidlevel);
            if ($casesActionsId > 0) {
                $contractorRating += $countryRateData->financial ?? null;
                $data['countryRate'] = $countryRateData->financial ?? null;

            } else {
                $contractorRating += $countryRateData->non_financial ?? null;
                $data['countryRate'] = $countryRateData->non_financial ?? null;

            }
        }
        if ($sectormidlevel) {
            $sectorRateData = SectorRating::find($sectormidlevel);
            if ($casesActionsId > 0) {
                $contractorRating += $sectorRateData->financial ?? null;
                $data['sectorsRate'] = $sectorRateData->financial ?? null;

            } else {
                $contractorRating += $sectorRateData->non_financial ?? null;
                $data['sectorsRate'] = $sectorRateData->non_financial ?? null;

            }
        }

        $staffData = OtherContractorInformation::where('slug', 'employee')
            ->where(function ($qry) use ($staffstrength) {
                $qry->where('from', '<=', $staffstrength)->where('to', '>=', $staffstrength);
            })->first();
        if ($casesActionsId > 0) {
            if (isset($staffData) && $staffData->count() > 0) {
                $contractorRating += $staffData->financial ?? null;
                $data['employeeRate'] = $staffData->financial ?? null;

            }
        } else {
            if (isset($staffData) && $staffData->count() > 0) {
                $contractorRating += $staffData->non_financial ?? null;
                $data['employeeRate'] = $staffData->non_financial ?? null;
            }
        }

        if ($date_of_incorporation) {
            $start_date = date("Y-m-d", strtotime($date_of_incorporation));

            $end_date = date('Y-m-d');

            $diff = abs(strtotime($end_date) - strtotime($start_date));

            $years = $diff / (365 * 60 * 60 * 24);

            $incepData = OtherContractorInformation::where('slug', 'date_of_est')
                ->where(function ($qry) use ($years) {
                    $qry->where('from', '<=', $years)->where('to', '>=', $years);
                })->first();

            if ($casesActionsId > 0) {
                if (isset($incepData) && $incepData->count() > 0) {
                    $contractorRating += $incepData->financial ?? null;
                    $data['estRate'] = $incepData->financial ?? null;
                }
            } else {
                if (isset($incepData) && $incepData->count() > 0) {
                    $contractorRating += $incepData->non_financial ?? null;
                    $data['estRate'] = $incepData->non_financial ?? null;
                }
            }
        }

        $data['contractorRating'] = $contractorRating;
        return $data;
    }
}
