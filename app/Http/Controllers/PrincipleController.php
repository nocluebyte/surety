<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Principle;
use App\Models\{Country,State, User, Role, RoleUser, PrincipleType,Beneficiary,ContractorItem, GroupContractor, Cases, ContactDetail, TradeSectorItem, CasesActionPlan, AdverseInformation,BankingLimit,OrderBookAndFutureProjects,ProjectTrackRecords,ManagementProfiles,DMS,LetterOfAward, AgencyRating,ProfitLoss,BalanceSheet,Ratio,Group,DmsComment,Analysis,CasesDecision};
use App\Http\Requests\PrincipleRequest;
use App\DataTables\PrincipleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use App\Exceptions\MailTemplateException;
use File;
use App\Imports\PrincipleImport;
use App\Exports\PrincipleImportErrorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\Remarks;

class PrincipleController extends Controller
{
    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['create', 'store', 'show', 'update', 'destroy', 'edit']]);
        $this->middleware('permission:principle.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:principle.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:principle.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:principle.delete', ['only' => 'destroy']);
        $this->middleware('permission:cases.initiate_review', ['only' => 'initiateReview']);
        $this->middleware('permission:principle.import', ['only' => ['import', 'PrincipleImportFiles']]);
        $this->common = new CommonController();
        $this->title = trans('principle.principle');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(PrincipleDataTable $datatable)
    {
        $this->data['principle_types'] = $this->common->getPrincipleTypes();
        return $datatable->render('principle.index', $this->data);
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['principle_types'] = PrincipleType::where('is_active', 1)->get();
        $this->data['entity_types'] = $this->common->getEntityType();
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['seriesNumber'] = codeGenerator('principles', 7, 'CIN');
        $this->data['trade_sector'] = $this->common->getTradeSector();
        $this->data['isCountryIndia'] = true;
        $this->data['jsVentureTypeRequired'] = true;
        $this->data['banking_limit_category'] = $this->common->getBankingLimitCategory();
        $this->data['facility_types'] = $this->common->getFacilityType();
        $this->data['project_type'] = $this->common->getProjectType();
        $this->data['current_status'] = Config('srtpl.current_status');
        $this->data['designation'] = $this->common->getDesignation();
        $this->data['agencies'] = $this->common->getAgency();
        $this->data['agency_rating'] = [];
        if (old('agency_id')) {
            $this->data['agency_rating'] = $this->common->getRating(old('agency_id'));
        }
        $this->data['agencyOptions'] = [];
        return view('principle.create', $this->data);
    }

    public function store(PrincipleRequest $request)
    {
        // dd($request->all());
        $check_entry = Principle::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('principle.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'contractor')->value('id');
            if(!isset($roleId)){
                return redirect()->route('principle.create')->with('error', 'Role Not Found, Please Check the Role List');
            }

            $loginUser = Sentinel::getUser();
            $user_id = $loginUser ? $loginUser->id : 0;

            $role_details = Role::findOrFail($roleId);
            $role_permissions = $role_details->permissions;

            $user_input = [
                'email' => $request['email'],
                'password' => Hash::make($generateOtp),
                'first_name' => $request['company_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
                'roles_id' => $roleId,
                'is_ip_base' => $request->get('is_ip_base', 'No'),
                'ip' => request()->ip(),
                'created_by' => $user_id,
                'is_active' => 'Yes',
                'permissions' => $role_permissions,
            ];

            $activate = (bool)$request->get('activate', true);

            $result = $this->authManager->register($user_input, $activate);

            $user_id = $result->user->id;

            $user = User::findOrFail($user_id);
            $user->update($user_input);

            $result->user->roles()->sync($roleId);
            $user_id = $user->id;

            $input = [
                'code' => codeGenerator('principles', 7, 'CIN'),
                'principle_type_id' => $request['principle_type_id'],
                'registration_no' => $request['registration_no'],
                'company_name' => $request['company_name'],
                'date_of_incorporation' => $request['date_of_incorporation'],
                'entity_type_id' => $request['entity_type_id'],
                'staff_strength' => $request['staff_strength'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'gst_no' => $request['gst_no'],
                'pincode' => $request['pincode'],
                // 'inception_date' => $request['inception_date'],
                'website' => $request['website'],
                'venture_type' => $request['venture_type'],
                'user_id' => $user_id,
                'agency_id' => $request['agency_id'],
                'agency_rating_id' => $request['agency_rating_id'],
                'rating_remarks' => $request['rating_remarks'],
                'are_you_blacklisted' => $request['are_you_blacklisted'],
                'is_bank_guarantee_provided' => $request['is_bank_guarantee_provided'],
                'circumstance_short_notes' => $request['circumstance_short_notes'],
                'is_action_against_proposer' => $request['is_action_against_proposer'],
                'action_details' => $request['action_details'],
                'contractor_failed_project_details' => $request['contractor_failed_project_details'],
                'completed_rectification_details' => $request['completed_rectification_details'],
                'performance_security_details' => $request['performance_security_details'],
                'relevant_other_information' => $request['relevant_other_information'],
                // 'rating_date' => $request['rating_date'],
            ];

            $principleData = Principle::create($input);
            $principle_id = $principleData->id;

            foreach (['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr'] as $documentType) {
                if($request->hasFile($documentType)){
                    $this->common->storeMultipleFiles($request, $request[$documentType], $documentType, $principleData, $principle_id, 'principle');

                    // foreach($request->file($documentType) as $item){
                    //     $uploadFolder = public_path('uploads/principle');
                    //     if (!file_exists($uploadFolder)) {
                    //         mkdir($uploadFolder, 0775, true);
                    //     }

                    //     $fileName = $item->getClientOriginalName();
                    //     $filePath = $item->storeAs('uploads/principle/' . $principle_id . '/' . $fileName);
                    //     // dd($filePath);
                    //     // return 'uploads/' . $folder . '/' . $fileName;

                    //     $model->dMS()->create([
                    //         'file_name' => $fileName,
                    //         'attachment' => $filePath,
                    //         'attachment_type' => $documentType,
                    //         'file_source_id'=>$request->file_source_id ?? null,
                    //         'document_type_id'=>$request->document_type_id ??  null,
                    //         'final_submission'=>$request->final_submission ??  'No',
                    //         'dmsamend_type'=>$request->dmsamend_type ??  null,
                    //         'dmsamend_id'=>$request->dmsamend_id ??  null,
                    //     ]);
                    // }
                }
            }

            if(in_array($request['venture_type'], ['JV', 'SPV'])){
                $contractorDetails = $request->contractorDetails;
                if (!empty($contractorDetails) && count($contractorDetails) > 0) {
                    foreach ($contractorDetails as $row) {
                        $contractorDetailArr = [
                            // 'principle_id' => $principle_id,                        
                            'contractor_id' => $row['contractor_id'] ?? NULL,
                            'pan_no'=> $row['contractor_pan_no'] ?? NULL,
                            'share_holding'=> $row['share_holding'] ?? NULL,                        
                        ];
                        $principleData->contractorItem()->create($contractorDetailArr); 
                    }
                }
            }
            $tradeSector = $request->tradeSector;
            if (!empty($tradeSector) && count($tradeSector) > 0) {
                foreach ($tradeSector as $row) {
                    $tradeSectorArr = [
                        // 'principle_id' => $principle_id,                        
                        'trade_sector_id' => $row['trade_sector'] ?? NULL,
                        'from'=> $row['from'] ?? NULL,
                        'till'=> $row['till'] ?? NULL,                        
                        'is_main'=> $row['is_main'] ?? 'No',                        
                    ];
                    $principleData->tradeSector()->create($tradeSectorArr); 
                }
            }

            $contactDetail = $request->contactDetail;
            if (!empty($contactDetail) && count($contactDetail) > 0) {
                foreach ($contactDetail as $row) {
                    $contactDetailArr = [
                        'contact_person' => $row['contact_person'] ?? NULL,
                        'email'=> $row['email'] ?? NULL,
                        'phone_no'=> $row['phone_no'] ?? NULL,                        
                    ];
                    $contactDetailIsNull = empty(array_filter($contactDetailArr, function($value) {
                        return !is_null($value);
                    }));
                    // $contactDetailArr['principle_id'] = $principle_id;
                    if(!$contactDetailIsNull){
                        $principleData->contactDetail()->create($contactDetailArr); 
                    }
                }
            }

            // Rating

            $ratingDetail = $request->ratingDetail;
            if(isset($ratingDetail) && count($ratingDetail)>0){
                foreach ($ratingDetail as $row) {
                    $ratingDetailsArr = [
                        'agency_id' => $row['item_agency_id'] ?? null,
                        'rating_id' => $row['item_rating_id'] ?? null,
                        'rating' => $row['rating'] ?? null,
                        'remarks' => $row['rating_remarks'] ?? null,
                        'rating_date' => $row['rating_date'] ?? null,
                    ];
                    $ratingDetailsRepeater = $principleData->agencyRatingDetails()->create($ratingDetailsArr);
                }
            }

              // Proposal Banking Limits Repeater

              $bankingLimits = $request->pbl_items;

              foreach ($bankingLimits as $row) {
                  $bankingLimitsArr = [
                      'banking_category_id' => $row['banking_category_id'] ?? null,
                      'facility_type_id' => $row['facility_type_id'] ?? null,
                      'sanctioned_amount' => $row['sanctioned_amount'] ?? null,
                      'bank_name' => $row['bank_name'],
                      'latest_limit_utilized' => $row['latest_limit_utilized'] ?? null,
                      'unutilized_limit' => $row['unutilized_limit'] ?? null,
                      'commission_on_pg' => $row['commission_on_pg'] ?? null,
                      'commission_on_fg' => $row['commission_on_fg'] ?? null,
                      'margin_collateral' => $row['margin_collateral'] ?? null,
                      'other_banking_details' => $row['other_banking_details'] ?? null,
                  ];
  
                  $bankingLimitsRepeater = $principleData->bankingLimits()->create($bankingLimitsArr);
  
                  $dms_bankingLimits = BankingLimit::findOrFail($bankingLimitsRepeater->id);
  
                  if (!empty($row['banking_limits_attachment'])) {
                      $this->common->storeMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_bankingLimits, $principle_id, 'principle_contractor');
                  }
              }
  
              // Order Book and Future Projects Repeater
  
              $orderBookAndFutureProjects = $request->obfp_items;
              foreach($orderBookAndFutureProjects as $row){
                  $orderBookAndFutureProjectsArr = [
                    //   'project_scope' => $row['project_scope'],
                    //   'principal_name' => $row['principal_name'],
                    //   'project_location' => $row['project_location'],
                    //   'type_of_project' => $row['type_of_project'] ?? null,
                    //   'contract_value' => $row['contract_value'] ?? null,
                    //   'anticipated_date' => $row['anticipated_date'] ?? null,
                    //   'tenure' => $row['tenure'] ?? null,
                      'project_share' => $row['project_share'] ?? null,
                      'guarantee_amount' => $row['guarantee_amount'] ?? null,
                      'current_status' => $row['current_status'] ?? null,
                       'project_name' => $row['project_name'] ?? null,
                       'project_cost' => $row['project_cost'] ?? null,
                       'project_description' =>$row['project_description'] ?? null,
                       'project_start_date' => $row['project_start_date'] ?? null,
                       'project_end_date' => $row['project_end_date'] ?? null,
                       'project_tenor' => $row['project_tenor'] ?? null,
                       'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                  ];
  
                  $orderBookAndFutureProjectsRepeater = $principleData->orderBookAndFutureProjects()->create($orderBookAndFutureProjectsArr);
  
                  $dms_orderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($orderBookAndFutureProjectsRepeater->id);
  
                  if (!empty($row['order_book_and_future_projects_attachment'])) {
                      $this->common->storeMultipleFiles($request, $row['order_book_and_future_projects_attachment'], 'order_book_and_future_projects_attachment', $dms_orderBookAndFutureProjects, $principle_id, 'principle_contractor');
                  }
              }
  
              // Project Track Records Repeater
  
              $projectTrackRecords = $request->ptr_items;
              // dd($projectTrackRecords);
              foreach($projectTrackRecords as $row){
                  $projectTrackRecordsArr = [
                      'project_name' => $row['project_name'],
                    //   'description' => $row['description'],
                      'project_cost' => $row['project_cost'] ?? null,
                      'project_tenor' => $row['project_tenor'] ?? null,
                      'project_start_date' => $row['project_start_date'] ?? null,
                    //   'principal_name' => $row['principal_name'],
                    //   'estimated_date_of_completion' => $row['estimated_date_of_completion'] ?? null,
                    //   'type_of_project_track' => $row['type_of_project_track'] ?? null,
                    //   'project_share_track' => $row['project_share_track'] ?? null,
                      'actual_date_completion' => $row['actual_date_completion'] ?? null,
                    //   'amount_margin' => $row['amount_margin'] ?? null,
                    //   'completion_status' => $row['completion_status'],
                      'bg_amount' => $row['bg_amount'] ?? null,
                      'project_description' => $row['project_description'] ?? null,
                      'project_end_date' => $row['project_end_date'] ?? null,
                      'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                  ];
                  $projectTrackRecordsRepeater = $principleData->projectTrackRecords()->create($projectTrackRecordsArr);
  
                  $dms_projectTrackRecords = ProjectTrackRecords::findOrFail($projectTrackRecordsRepeater->id);
  
                  if (!empty($row['project_track_records_attachment'])) {
                      $this->common->storeMultipleFiles($request, $row['project_track_records_attachment'], 'project_track_records_attachment', $dms_projectTrackRecords, $principle_id, 'principle_contractor');
                  }
              }
  
              // Management Profiles Repeater
  
              $managementProfiles = $request->mp_items;
              foreach($managementProfiles as $row){
                  $managementProfilesArr = [
                      'designation' => $row['designation'] ?? null,
                      'name' => $row['name'],
                      'qualifications' => $row['qualifications'],
                      'experience' => $row['experience'],
                  ];
                  $managementProfilesRepeater = $principleData->managementProfiles()->create($managementProfilesArr);
  
                  $dms_managementProfiles = ManagementProfiles::findOrFail($managementProfilesRepeater->id);
  
                  if (!empty($row['management_profiles_attachment'])) {
                      $this->common->storeMultipleFiles($request, $row['management_profiles_attachment'], 'management_profiles_attachment', $dms_managementProfiles, $principle_id, 'principle_contractor');
                  }
              }


            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch(MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('principle.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('principle.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('principle.create')->with('success', __('principle.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('principle.index')->with('success', __('principle.create_success'));
        } else {
            return redirect()->route('principle.index')->with('success', __('principle.create_success'));
        }
    }

    public function show($id)
    {
        $principle = Principle::with(['state', 'country', 'user', 'principleType','bankingLimits','orderBookAndFutureProjects','projectTrackRecords','managementProfiles', 'agencyRatingDetails','contractorLatestCase','analysis','invocationNotification', 'recovery', 'letterOfAward'])->withCount('Pending')->findOrFail($id);

        $this->common->markAsRead($principle);

        $tradeSector = TradeSectorItem::
            leftJoin('trade_sectors','trade_sectors.id','=','trade_sector_items.trade_sector_id')
            ->select(['trade_sectors.name', 'trade_sector_items.from', 'trade_sector_items.till', 'trade_sector_items.is_main'])
            ->where('tradesectoritemsable_id', $principle->id)->where('tradesectoritemsable_type', 'Principle')->get();

        $contactDetail = ContactDetail::where('contactdetailsable_id', $principle->id)->where('contactdetailsable_type', 'Principle')->get();
        $contractorItem = ContractorItem::
            leftJoin('principles','principles.id','=','contractor_items.contractor_id')
            ->select(['contractor_items.pan_no', 'contractor_items.share_holding', 'principles.code', 'principles.company_name'])
            ->where('contractoritemsable_id', $principle->id)->where('contractoritemsable_type', 'Principle')->get();
        $this->data['tradeSector'] = $tradeSector;
        $this->data['contactDetail'] = $contactDetail;
        $this->data['contractorItem'] = $contractorItem;

        $case_pending_count = $principle->pending_count;
        $underwriter = $this->common->getUnderWriterOpction();
        $table_name =  $principle->getTable();
        $this->data['underwriter'] = $underwriter;
        $this->data['table_name'] = $table_name;
        $this->data['principle'] = $principle;
        $this->data['show_initiate_review'] = $case_pending_count == 0;
        
        //cases action plan 
        $case_action_plan = CasesActionPlan::with(['cases','profitLoss','casesLimitStrategy','casesLimitStrategySaveData','casesBondLimitStrategy',
        'utilizedCasesLimitStrategy','utilizedCasesBondLimitStrategy'])
        ->withSum('utilizedCasesLimitStrategy','value')
        ->withSum('utilizedCasesBondLimitStrategy','value')
        ->whereHas('cases', function ($qry) use ($id) {
            $qry->whereNotNull('contractor_id')->where(['contractor_id' =>  $id]);
        })->orderBy('id', 'DESC')->first();

        //financial section inside action plan start
        $datesArr = [];
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
            $this->data['lossData'] = $lossData;
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
            $this->data['balanceSheetData'] = $balanceSheetData;
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
            $this->data['ratiosData'] = $ratiosData;
        }
        
        $this->data['datesArr'] = $datesArr;
        $this->data['profit_loss'] = Config('project.profit_loss');
        $this->data['ratios'] = Config('project.ratios');
        $this->data['balance_sheet_a'] = Config('project.balance_sheet_a');
        $this->data['balance_sheet_b'] = Config('project.balance_sheet_b');
        //financial section inside action plan end

        if (isset($case_action_plan->casesLimitStrategySaveData)) {
            $latestData = $case_action_plan->casesLimitStrategySaveData;
            // $latestLogData = array_filter($case_action_plan->casesLimitStrategy->toArray());
            $this->data['casesLimitStrategylog'] = $case_action_plan->casesLimitStrategy;                             
            if ($latestData) {
                $this->data['casesLimitStrategy'] = $latestData;
            }
        }

        if (isset($case_action_plan->casesBondLimitStrategySaveData)) {
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
        $this->data['case_action_plan'] = $case_action_plan;

        //approved limit 
       $this->data['approved_bond_current'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$id)
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
        ->where('contractor_id',$id)
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
        ->where('contractor_id',$id)
        ->where('decision_status','Rejected')
        ->where('is_bond_managment_action_taken',0)
        ->get();

         $this->data['approved_bond_cancellation'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',1)
        ->where('bond_managment_action_type','bond_cancellation')
        ->get();

        $this->data['approved_bond_foreclosure'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',0);
        })
        ->where('contractor_id',$id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',1)
        ->where('bond_managment_action_type','bond_foreclosure')
        ->get();

        $this->data['approved_bond_invoked'] = Cases::with('contractor:id,code,company_name','tender:id,code,tender_id','casesDecisionContractor','proposal:id,code,version','bondType:id,name')
        ->whereHas('proposal',function($query){
            $query->where('is_invocation_notification',1);
        })
        ->where('contractor_id',$id)
        ->where('is_amendment',0)
        ->where('is_bond_managment_action_taken',0)
        ->get();

        $parent = Group::with('contractor')->where('contractor_id', $id)
        ->orWhereHas('groupContractor', function($sql) use($id){
            $sql->where('contractor_id', $id);
        })
        ->first();
        
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
           ->leftJoin('group_contractors',function($join)use($id){
                $join->on('group_contractors.group_id','=','groups.id')
                ->where('group_contractors.contractor_id',$id);
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
               'principles.id'
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
           ->leftJoin('groups',function($join) use($id){
               $join->on('group_contractors.group_id','=','groups.id')
               ->where('groups.contractor_id',$id);
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
               'principles.id'
           ]);

           $group_approved_limit = $group->unionAll($groupMember)
           ->get();

           $this->data['group_approved_limit'] = $group_approved_limit;
        

        $group_cap = $parent->group_cap ?? 0;
        $proposed_group_cap = $case_action_plan->casesLimitStrategySaveData->proposed_group_cap ?? 0;
        $proposed_individual_cap = $case_action_plan->casesLimitStrategySaveData->proposed_individual_cap ?? 0;
        $proposed_overall_cap = $case_action_plan->casesLimitStrategySaveData->proposed_overall_cap ?? 0;
        // $proposed_spare_capecity = $case_action_plan->utilized_cases_bond_limit_strategy_sum_value ?? 0;
        // $spare_capecity = $proposed_overall_cap - $proposed_spare_capecity;
        $total_approved_limit = Cases::Completed($id)->sum('bond_value');
        $spare_capecity = $proposed_overall_cap - $total_approved_limit;
        $this->data['parent'] = $parent;
        $this->data['total_group_cap'] = ($group_cap > 0) ? $group_cap : $proposed_group_cap;
        $this->data['total_individual_cap'] = $proposed_individual_cap ?? 0;
        $this->data['total_overall_cap'] = $proposed_overall_cap ?? 0;
        $this->data['spare_capecity'] = $spare_capecity ?? 0;
        $this->data['total_pending_limit'] = Cases::Pending($id)->sum('bond_value');
        $this->data['total_approved_limit'] = $total_approved_limit;

        $this->data['adverse_information'] = AdverseInformation::where('contractor_id', $id)->where('is_active', 'Yes')->get() ?? null;

        $loa_data = LetterOfAward::pluck('contractor_id')->toArray();

        $this->data['loa_contractors'] = collect($this->common->getContractor())->except($loa_data)->toArray();
        $this->data['editLoaContractors'] = $this->common->getContractor();
        $this->data['letterOfAward'] = $principle->letterOfAward;
        $this->data['beneficiaries'] = $this->common->getBeneficiary();
        $this->data['project_details'] = $this->common->getProjectDetails();
        $this->data['tenders'] = $this->common->getTender();

        $this->data['dms_data'] = $principle->dMS->groupBy('attachment_type');
        // dd($this->data['dms_data']);

        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($principle->country_id);

        $this->data['applicationDocs'] = DMS::leftJoin('cases', function ($join) {
                    $join->on('dms.dmsable_id', '=', 'cases.id');
                })->leftJoin('proposals', function ($join) {
                    $join->on('dms.dmsamend_id', '=', 'proposals.id');
                })
                ->when($id, function ($q) use ($id) {
                    $q->where('cases.contractor_id', $id)
                        ->where('dms.dmsable_type', 'Cases')
                        ->where('dms.dmsamend_type', 'Proposal');
                })->select('dms.*',DB::raw("CONCAT(proposals.code,'/V',proposals.version) as proposalCode"), 'cases.id as caseId')
                ->orderBy('dms.created_at')
                ->get()->groupBy('proposalCode');

        $this->data['reviewDocs'] = DMS::leftJoin('cases', function ($join) {
                    $join->on('dms.dmsable_id', '=', 'cases.id');
                })
                ->where('cases.contractor_id', $id)
                ->where('dms.dmsable_type', 'Cases')
                ->where('dms.dmsamend_type', 'Principle')
                ->select('dms.*', 'cases.id as caseId')
                ->orderBy('dms.created_at')
                ->get();
        // dd($this->data['applicationDocs'], $this->data['reviewDocs']);
        $this->data['document_type'] = $this->common->getDocumentTypeOpction();
        $this->data['file_source'] = $this->common->getFileSourceOpction();

        $this->data['otherDocs'] = DMS::where('dmsable_id', $id)->where('dmsable_type', 'Other')->orderBy('created_at')->get();

        return view('principle.show',$this->data);
    }

    public function edit($id)
    {
        $principle = Principle::with(['user','contractorItem', 'country', 'tradeSector', 'contactDetail','bankingLimits.dMS','orderBookAndFutureProjects.dMS','projectTrackRecords.dMS','managementProfiles.dMS', 'agencyRatingDetails'])->findOrFail($id);
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($principle->country_id);
        $this->data['principle_types'] = PrincipleType::where('is_active', 1)->get();
        $this->data['entity_types'] = $this->common->getEntityType($principle->entity_type_id);
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['trade_sector'] = $this->common->getTradeSector($principle->trade_sector);
        unset($this->data['contractors'][$id]);
        $this->data['principle'] = $principle;
        $selected_country = $principle->country->name;
        $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;
        $this->data['jsVentureTypeRequired'] = isset($principle) && isset($principle->venture_type) && $principle->venture_type == "Stand Alone" ? true : false;
        $this->data['proposal_banking_limits'] = $principle->bankingLimits;
        $this->data['order_book_and_future_projects'] = $principle->orderBookAndFutureProjects;
        $this->data['project_track_records'] = $principle->projectTrackRecords;
        $this->data['management_profiles'] = $principle->managementProfiles;
        $this->data['banking_limit_category'] = $this->common->getBankingLimitCategory();
        $this->data['facility_types'] = $this->common->getFacilityType();
        $this->data['project_type'] = $this->common->getProjectType();
        $this->data['current_status'] = Config('srtpl.current_status');
        $this->data['designation'] = $this->common->getDesignation();
        // $this->data['agencies'] = $this->common->getAgency($principle->agency_id);
        $this->data['agency_rating'] = $this->common->getRating();
        $this->data['dms_data'] = $principle->dMS->groupBy('attachment_type')->whereNull('deleted_at');
        $this->data['ratingDetails'] = $principle->agencyRatingDetails;

        $agencyArr = $principle->agencyRatingDetails->pluck('agency_id')->toArray() ?? [];
        $this->data['agencies'] = $this->common->getAgency() ?? [];

        $agencyOptions = [];
        if (!empty($this->data['agencies'])) {
            foreach ($this->data['agencies'] as $key => $value) {
                if(in_array($key,$agencyArr)){
                    $agencyOptions[$key] = ['disabled' => 'disabled'];
                    // if($key == $blacklist->contractor_id){
                    //     $agencyOptions[$key] = ['' => ''];
                    // }
                }
            }
        }
        $this->data['agencyOptions'] = $agencyOptions;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($principle->country_id);
        // dd($this->data['currency_symbol']);
        return view('principle.edit', $this->data);
    }

    public function update($id, PrincipleRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $principle = Principle::findOrFail($id);
            $principle_id = $principle->id;

            $input = [
                'principle_type_id' => $request['principle_type_id'],
                'registration_no' => $request['registration_no'],
                'company_name' => $request['company_name'],
                'date_of_incorporation' => $request['date_of_incorporation'],
                'entity_type_id' => $request['entity_type_id'],
                'staff_strength' => $request['staff_strength'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no']  ,
                'gst_no' => $request['gst_no'],
                'pincode' => $request['pincode'],
                // 'inception_date' => $request['inception_date'],
                'website' => $request['website'],
                'venture_type' => $request['venture_type'],
                'agency_id' => $request['agency_id'],
                'agency_rating_id' => $request['agency_rating_id'],
                'rating_remarks' => $request['rating_remarks'],
                'are_you_blacklisted' => $request['are_you_blacklisted'],
                'is_bank_guarantee_provided' => $request['is_bank_guarantee_provided'],
                'circumstance_short_notes' => $request['circumstance_short_notes'],
                'is_action_against_proposer' => $request['is_action_against_proposer'],
                'action_details' => $request['action_details'],
                'contractor_failed_project_details' => $request['contractor_failed_project_details'],
                'completed_rectification_details' => $request['completed_rectification_details'],
                'performance_security_details' => $request['performance_security_details'],
                'relevant_other_information' => $request['relevant_other_information'],
                // 'rating_date' => $request['rating_date'],
            ];

            $principle->update($input);

            foreach (['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr'] as $documentType) {
                if($request->hasFile($documentType)){
                    $this->common->updateMultipleFiles($request, $request[$documentType], $documentType, $principle, $principle->id, 'principle');
                }
            }

            if(in_array($request['venture_type'], ['JV', 'SPV'])){
                $contractorDetails = $request->contractorDetails;
                
                if (!empty($contractorDetails) && count($contractorDetails) > 0) {
                    $currentIds = array_diff(array_column($contractorDetails, 'item_id'), ['']);                  
                    if(!empty($currentIds)){
                        ContractorItem::where('contractoritemsable_id', $principle_id)->where('contractoritemsable_type', 'Principle')->whereNotIn('id', $currentIds)->delete();
                    }   
                    foreach ($contractorDetails as $row) {
                        $item_id = $row['item_id'] ?? 0;
                        $contractorDetailArr = [
                            // 'principle_id' => $principle_id,                        
                            'contractor_id' => $row['contractor_id'] ?? NULL,
                            'pan_no'=> $row['contractor_pan_no'] ?? NULL,
                            'share_holding'=> $row['share_holding'] ?? NULL,                        
                        ];
                        if ($item_id > 0) {
                            $principle->contractorItem()->updateOrCreate(['id' => $item_id ?? null], $contractorDetailArr);
                        } else {
                            $principle->contractorItem()->create($contractorDetailArr);
                        }                    } 
                }
            } else {
                ContractorItem::where('contractoritemsable_id', $principle_id)->where('contractoritemsable_type', 'Principle')->delete();   
            }

            $tradeSector = $request->tradeSector;
            if (!empty($tradeSector) && count($tradeSector) > 0) {
                $tradeCurrentIds = array_column($tradeSector, 'trade_item_id');
                  
                if(!empty($tradeCurrentIds)){
                    TradeSectorItem::where('tradesectoritemsable_id', $principle_id)->where('tradesectoritemsable_type', 'Principle')->whereNotIn('id', $tradeCurrentIds)->delete();
                }
                
                foreach ($tradeSector as $row) {
                    $principle->tradeSector()->updateOrCreate(
            ['id'=> $row['trade_item_id'] ?? NULL],
                [
                            'trade_sector_id' => $row['trade_sector'] ?? NULL,
                            'from'=> $row['from'] ?? NULL,
                            'till'=> $row['till'] ?? NULL,                        
                            'is_main'=> $row['is_main'] ?? 'No',  
                        ]
                    );
                }
            }

            $contactDetail = $request->contactDetail;
            if (!empty($contactDetail) && count($contactDetail) > 0) {

                $contactCurrentIds = array_column($contactDetail, 'contact_item_id');
                if(!empty($contactCurrentIds)){
                    ContactDetail::where('contactdetailsable_id', $principle_id)->where('contactdetailsable_type', 'Principle')->whereNotIn('id', $contactCurrentIds)->delete();
                }  

                foreach ($contactDetail as $row) {
                    $item_id = $row['contact_item_id'] ?? 0;
                    $contactDetailArr = [
                        'contact_person' => $row['contact_person'] ?? NULL,
                        'email'=> $row['email'] ?? NULL,
                        'phone_no'=> $row['phone_no'] ?? NULL,                        
                    ];
                    $contactDetailIsNull = empty(array_filter($contactDetailArr, function($value) {
                        return !is_null($value);
                    }));
                    $contactDetailArr['contactdetailsable_id'] = $principle_id;

                    if ($item_id > 0) {
                        $principle->contactDetail()->updateOrCreate(['id' => $item_id ?? null], $contactDetailArr);
                    } else {
                        if(!$contactDetailIsNull){
                            $principle->contactDetail()->create($contactDetailArr);
                        }
                    }
                }
            }

            if(isset($request->remove_dms)){
                $deleteFiles = DMS::whereIn('id', $request->remove_dms);
                foreach ($deleteFiles->pluck('attachment') as $deleteAttachment) {
                    File::delete($deleteAttachment);
                };
                $deleteFiles->delete();
            }

            // Rating

            $ratingDetail_id = collect($request->ratingDetail)->pluck('rating_item_id')->toArray();
            $existing_ratingDetail = $principle->agencyRatingDetails()->pluck('id')->toArray();
            $diff_ratingDetail = array_diff($existing_ratingDetail, $ratingDetail_id);

            $principle->agencyRatingDetails()->whereIn('id', $diff_ratingDetail)->get()->each(function ($ardItem) {
                $ardItem->delete();
            });

            $ratingDetail = $request->ratingDetail;

            if(isset($ratingDetail) && count($ratingDetail)>0){
                foreach ($ratingDetail as $row) {
                    // dd($row);
                    $contractorRatingDetailRepeater = $principle->agencyRatingDetails()->updateOrCreate([
                        'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['rating_item_id'],
                    ],[
                        'agency_id' => $row['item_agency_id'] ?? null,
                        'rating_id' => $row['item_rating_id'] ?? null,
                        'rating' => $row['rating'] ?? null,
                        'remarks' => $row['rating_remarks'] ?? null, 
                        'rating_date' => $row['rating_date'] ?? null,
                    ]);
                }
            }

               // Proposal Banking Limits Repeater

               $proposalBankingLimits_id = collect($request->pbl_items)->pluck('pbl_id')->toArray();
               $existing_proposalBankingLimits = $principle->bankingLimits()->pluck('id')->toArray();
               $diff_proposalBankingLimits = array_diff($existing_proposalBankingLimits, $proposalBankingLimits_id);
   
               $principle->bankingLimits()->whereIn('id', $diff_proposalBankingLimits)->get()->each(function ($pblItem) {
                   foreach ($pblItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                       File::delete($deleteItem);
                   };
                   $pblItem->dMS()->delete();
                   $pblItem->delete();
               });
   
               $proposalBankingLimits = $request->pbl_items;
   
               foreach ($proposalBankingLimits as $row) {
                   $proposalBankingLimitsRepeater = $principle->bankingLimits()->updateOrCreate([
                       'id'=>$row['pbl_id'] ?? null
                   ],[
                       'banking_category_id' => $row['banking_category_id'] ?? null,
                       'facility_type_id' => $row['facility_type_id'] ?? null,
                       'sanctioned_amount' => $row['sanctioned_amount'] ?? null,
                       'bank_name' => $row['bank_name'],
                       'latest_limit_utilized' => $row['latest_limit_utilized'] ?? null,
                       'unutilized_limit' => $row['unutilized_limit'] ?? null,
                       'commission_on_pg' => $row['commission_on_pg'] ?? null,
                       'commission_on_fg' => $row['commission_on_fg'] ?? null,
                       'margin_collateral' => $row['margin_collateral'] ?? null,
                       'other_banking_details' => $row['other_banking_details'] ?? null,
                   ]);
   
                   $dms_proposalBankingLimits = BankingLimit::with('dMS')->findOrFail($proposalBankingLimitsRepeater->id);
   
                   // if(isset($request->remove_dms)) {
                   //     $dms_proposalBankingLimits->dMS()->whereIn('id', $request->remove_dms)->delete();
                   // }
   
                   if (!empty($row['banking_limits_attachment'])) {
                       $this->common->updateMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_proposalBankingLimits, $principle_id, 'principle_contractor');
                   }
               }
   
               // Order Book and Future Projects Repeater
   
               $orderBookAndFutureProjects_id = collect($request->obfp_items)->pluck('obfp_id')->toArray();
               $existing_orderBookAndFutureProjects = $principle->orderBookAndFutureProjects()->pluck('id')->toArray();
               $diff_orderBookAndFutureProjects = array_diff($existing_orderBookAndFutureProjects, $orderBookAndFutureProjects_id);
   
               $principle->orderBookAndFutureProjects()->whereIn('id', $diff_orderBookAndFutureProjects)->get()->each(function ($obfpItem) {
                   foreach ($obfpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                       File::delete($deleteItem);
                   };
                   $obfpItem->dMS()->delete();
                   $obfpItem->delete();
               });
   
               $orderBookAndFutureProjects = $request->obfp_items;
   
               foreach ($orderBookAndFutureProjects as $row) {
                   $orderBookAndFutureProjectsRepeater = $principle->orderBookAndFutureProjects()->updateOrCreate([
                       'id'=>$row['obfp_id'] ?? null
                   ],[
                    //    'project_scope' => $row['project_scope'],
                    //    'principal_name' => $row['principal_name'],
                    //    'project_location' => $row['project_location'],
                    //    'type_of_project' => $row['type_of_project'] ?? null,
                    //    'contract_value' => $row['contract_value'] ?? null,
                    //    'anticipated_date' => $row['anticipated_date'] ?? null,
                    //    'tenure' => $row['tenure'] ?? null,
                       'project_share' => $row['project_share'] ?? null,
                       'guarantee_amount' => $row['guarantee_amount'] ?? null,
                       'current_status' => $row['current_status'] ?? null,
                       'project_name' => $row['project_name'] ?? null,
                       'project_cost' => $row['project_cost'] ?? null,
                       'project_description' =>$row['project_description'] ?? null,
                       'project_start_date' => $row['project_start_date'] ?? null,
                       'project_end_date' => $row['project_end_date'] ?? null,
                       'project_tenor' => $row['project_tenor'] ?? null,
                       'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                   ]);
   
                   $dms_orderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($orderBookAndFutureProjectsRepeater->id);
   
                   if (!empty($row['order_book_and_future_projects_attachment'])) {
                       $this->common->updateMultipleFiles($request, $row['order_book_and_future_projects_attachment'], 'order_book_and_future_projects_attachment', $dms_orderBookAndFutureProjects, $principle_id, 'principle_contractor');
                   }
               }
   
               // Project Track Records Repeater
   
               $projectTrackRecords_id = collect($request->ptr_items)->pluck('ptr_id')->toArray();
               $existing_projectTrackRecords = $principle->projectTrackRecords()->pluck('id')->toArray();
               $diff_projectTrackRecords = array_diff($existing_projectTrackRecords, $projectTrackRecords_id);
   
               $principle->projectTrackRecords()->whereIn('id', $diff_projectTrackRecords)->get()->each(function ($ptrItem) {
                   foreach ($ptrItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                       File::delete($deleteItem);
                   };
                   $ptrItem->dMS()->delete();
                   $ptrItem->delete();
               });
   
               $projectTrackRecords = $request->ptr_items;
   
               foreach ($projectTrackRecords as $row) {
                   $projectTrackRecordsRepeater = $principle->projectTrackRecords()->updateOrCreate([
                       'id'=>$row['ptr_id'] ?? null
                   ],[
                       'project_name' => $row['project_name'],
                    //    'description' => $row['description'],
                       'project_cost' => $row['project_cost'] ?? null,
                       'project_tenor' => $row['project_tenor'] ?? null,
                       'project_start_date' => $row['project_start_date'] ?? null,
                    //    'principal_name' => $row['principal_name'],
                    //    'estimated_date_of_completion' => $row['estimated_date_of_completion'] ?? null,
                    //    'type_of_project_track' => $row['type_of_project_track'] ?? null,
                    //    'project_share_track' => $row['project_share_track'] ?? null,
                       'actual_date_completion' => $row['actual_date_completion'] ?? null,
                    //    'amount_margin' => $row['amount_margin'] ?? null,
                    //    'completion_status' => $row['completion_status'],
                       'bg_amount' => $row['bg_amount'] ?? null,
                       'project_description' => $row['project_description'] ?? null,
                       'project_end_date' => $row['project_end_date'] ?? null,
                       'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                   ]);
   
                   $dms_projectTrackRecords = ProjectTrackRecords::findOrFail($projectTrackRecordsRepeater->id);
   
                   if (!empty($row['project_track_records_attachment'])) {
                       $this->common->updateMultipleFiles($request, $row['project_track_records_attachment'], 'project_track_records_attachment', $dms_projectTrackRecords, $principle_id, 'principle_contractor');
                   }
               }
   
               // Management Profiles Repeater
   
               $managementProfiles_id = collect($request->mp_items)->pluck('mp_id')->toArray();
               $existing_managementProfiles = $principle->managementProfiles()->pluck('id')->toArray();
               $diff_managementProfiles = array_diff($existing_managementProfiles, $managementProfiles_id);
   
               $principle->managementProfiles()->whereIn('id', $diff_managementProfiles)->get()->each(function ($mpItem) {
                   foreach ($mpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                       File::delete($deleteItem);
                   };
                   $mpItem->dMS()->delete();
                   $mpItem->delete();
               });
   
               $managementProfiles = $request->mp_items;
            //    dd($managementProfiles);
   
               foreach ($managementProfiles as $row) {
                   $managementProfilesRepeater = $principle->managementProfiles()->updateOrCreate([
                       'id'=>$row['mp_id'] ?? null
                   ],[
                       'designation' => $row['designation'] ?? null,
                       'name' => $row['name'],
                       'qualifications' => $row['qualifications'],
                       'experience' => $row['experience'],
                   ]);
   
                   $dms_managementProfiles = ManagementProfiles::findOrFail($managementProfilesRepeater->id);
   
                   if (!empty($row['management_profiles_attachment'])) {
                       $this->common->updateMultipleFiles($request, $row['management_profiles_attachment'], 'management_profiles_attachment', $dms_managementProfiles, $principle_id, 'principle_contractor');
                   }
               }

            $user = User::findOrFail($principle->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['company_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('principle.edit',[encryptId($principle_id)])->with('success', __('principle.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('principle.index')->with('success', __('principle.update_success'));
        } else {
            return redirect()->route('principle.index')->with('success', __('principle.update_success'));
        }
    }

    public function destroy($id)
    {
        $principle = Principle::findOrFail($id);
        if($principle)
        {
            $dependency = $principle->deleteValidate($id);
            if(!$dependency)
            {
                PrincipleContractorItem::where('principle_id', $id)->delete();
                PrincipleContactDetail::where('principle_id', $id)->delete();
                PrincipleTradeSector::where('principle_id', $id)->delete();
                $principle->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('principle.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function getContractorDetail(Request $request){
        $contractor_id = $request->contractor_id;
        if($contractor_id){
            $contractorData = Principle::where('id',$contractor_id)->first();
            return $contractorData;
        }    
    }

    // public function getContractorDetailById(Request $request){
    //     $contractor_id = $request->contractor_id;
    //     if($contractor_id){
    //          $contractorData = Principle::where('id',$contractor_id)->first();
    //          return $contractorData;
    //     }    
    //  }

    public function initiateReview(Request $request){

        $principle =  Principle::findOrFail($request->principle_id);

        list($underwriter_type,$underwriter_id) = parseGroupedOptionValue($request->underwriter_id);

        $cases = $principle->cases()->create([
            'case_type'=>'Review',
            'underwriter_id'=> $underwriter_id ?? null,
            'underwriter_type'=> $underwriter_type ?? null,
            'contractor_id' => $request->principle_id,
            'underwriter_assigned_date'=> $request->underwriter_id ? $this->now : null,
        ]);

        if(isset($request->underwriter_id)){
            $principle->underwriterCasesLog()->create([
                'cases_id' => $cases->id,
                // 'casesable_type'=>$cases->casesable_type ?? null,
                // 'casesable_id'=>$cases->casesable_id ?? null,
                'underwriter_id'=> $underwriter_id ?? null,
                'underwriter_type'=> $underwriter_type ?? null,
            ]);
        }
 
        return back()->with('success', __('principle.review_generate'));
     }

    // public function getCountryName(Request $request)
    // {
    //     $country_id = $request->country;
    //     if($country_id) {
    //         $country_name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
    //         return $country_name;
    //     }
    // }

    public function storeMultipleFiles($request, $repeaterFiles, $fileItem, $model, $model_id, $folder)
    {
        foreach ($repeaterFiles as $item) {
            if ($item instanceof \Illuminate\Http\UploadedFile) {
                $filePath = $this->uploadFile($request, $folder . '/' . $model_id, $fileItem, $item);
                $fileName = basename($filePath);

                $model->dMS()->create([
                    'file_name' => $fileName,
                    'attachment' => $filePath,
                    'attachment_type' => $fileItem,
                    'file_source_id'=>$request->file_source_id ?? null,
                    'document_type_id'=>$request->document_type_id ??  null,
                    'final_submission'=>$request->final_submission ??  'No',
                    'dmsamend_type'=>$request->dmsamend_type ??  null,
                    'dmsamend_id'=>$request->dmsamend_id ??  null,
                ]);
            }
        }
    }

    public function getRatingDetails(Request $request)
    {
        $agency_id = $request->agency_id;
        if($agency_id){
            $agencyData = AgencyRating::where('agency_id',$agency_id)->pluck('rating', 'id')->toArray();
            // dd($agencyData->toArray());

            // $response = [
            //   'html' => view('principle.autofetch.contractor_agency_details',  $this->agencyData)->render(),
            // ];
            return $agencyData;
        }
    }

    public function getRatingRemarks(Request $request)
    {
        // dd($request->all());
        $select = [
            'agency_ratings.agency_id',
            'agency_ratings.rating',
            'agency_ratings.remarks',
            'agencies.agency_name',
            'agency_ratings.id as rating_id',
        ];
        $rating_id = $request->rating_id;
        if($rating_id){
            $ratingDetails = AgencyRating::where('agency_ratings.id', $rating_id)->select($select)
            ->leftJoin('agencies', function($join){
                $join->on('agency_ratings.agency_id', '=', 'agencies.id');
            })
            ->first();
            // dd($ratingDetails);
            $result = [
                'ratingDetails' => $ratingDetails,
            ];
            return $result;
        }
    }

    public function import()
    {
        return view('principle.import.import');
    }

    public function PrincipleImportFiles(Request $request)
    {
        // dd($request->all());
        ini_set('max_execution_time', 900);
        ini_set('memory_limit',-1);
        DB::beginTransaction();
        try {
            $import = new PrincipleImport($this->authManager);
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
                return redirect()->route('principle_import')->withSuccess('file imported successfully');
            }
            else
            {
                return redirect()->route('principle_import')->withErrors('in file has some invalid data please check and try again.');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            return back()->withErrors('Something went wrong, please try again.');
        }
    }

    public function principleImportErrorExport(Request $request){
        try {
            $exportdata = json_decode($request->error,true);
            return Excel::download(new PrincipleImportErrorExport($exportdata),'error.xlsx');
        } catch (\Throwable $th) {
            return "Something went wrong, please try again.";
        }
    }

    public function principleDmsattachmentdownload($id){
        $dms_attachments = DMS::AttachmentInsideDmsTab('Cases',$id)->get();

        $this->data['dms_attachments'] = $dms_attachments;

        return response()->json(['html'=> view('principle.modal.dms.principle_dms_download_attachment',$this->data)->render()]);
    }

    public function principleDmsAttachmentComment($id){
        
        $dms_attachment = DMS::AttachmentInsideDmsTab('Cases',$id)->first();
        $this->data['dms_attachment'] = $dms_attachment;

        return response()->json(['html'=>view('principle.modal.dms_comment.index',$this->data)->render()]);
    }

    public function principleDmsAttachmentStoreComment(Request $request){

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

    public function principleDmsAttachmentCommentLog($id){
        $comments = DmsComment::with('createdBy')->where('dms_id',$id)->get();
        $this->data['comments'] = $comments;

        return response()->json(['html'=> view('principle.modal.dms_comment_log.index',$this->data)->render()]);
      
    }

    public function principleDmsUpdate(Request $request,$id){

        $validated = $request->validate([
            'final_submission'=>'required',
            'document_type_id'=>'required',
            'file_source_id'=>'required',
            // 'cases_id'=>'required'
        ]);
       DB::beginTransaction();

       try {
            /*$dmsamend_id = $request->dmsamend_id ?? null;*/
            // $case = Cases::findOrFail($validated['cases_id']);
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
}
