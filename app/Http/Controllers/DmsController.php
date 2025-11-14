<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DataTables\DmsDataTable;
use App\Http\Requests\{DmsRequest};
use App\Models\{
    DMS,
    Principle,
    Proposal,
    Cases,
    InvocationNotification,
};
use Sentinel;
use DB;


class DmsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:dms.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:dms.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:dms.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.superadmin', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = trans("dms.dms");
        view()->share('title', $this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DmsDataTable $dataTable)
    {
        return $dataTable->render('dms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles->first();
        // $this->data['contractor'] = Principle::where('is_active', 'Yes')->where('id', $request->contractor_id)->select('id',DB::raw('(CASE WHEN code is not null THEN CONCAT(company_name," (",code,")") ELSE company_name END) AS code'))->pluck('code', 'id')->toArray();
        $this->data['contractor'] = $this->common->getContractor();
        $this->data['contractor_id'] = $request->contractor_id;
        $this->data['document_type'] = $this->common->getDocumentTypeOpction();
        $this->data['file_source'] = $this->common->getFileSourceOpction();
        return response()->json([
            'html' =>  view('dms.contractor.create', $this->data)->render()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DmsRequest $request)
    {
        $dmsFormData = session('show_data');
        DB::beginTransaction();

       try {
            $dmsamend_id = $request->dmsamend_id;
            $document_type_id = $request->document_type_id;
            $file_source_id = $request->file_source_id;
            $file_source = $request->file_source;
            $img_path = 'uploads/contractor/'.$dmsamend_id;
            $principle = Principle::findOrFail($dmsamend_id);
            // $dmsable_type = $request->type == 'documents' ? 'Other' : $dataFromShow['dmsable_type'];
            // $dmsamend_type = $dataFromShow['dmsamend_type'];

            // $request->request->add(['dmsable_type' => $dataFromShow->dmsable_type,'dmsable_id' => $dataFromShow->dmsable_id,'dmsamend_type' => $dataFromShow->dmsamend_type,'dmsamend_id' => $dataFromShow->dmsamend_id]);

            // $request->request->add(['dmsable_type' => 'Principle','dmsable_id' => $dmsamend_id,'dmsamend_type' => 'Principle','dmsamend_id' => $dmsamend_id]);

            // $this->common->storeMultipleFiles($request,$request->file('attachment'),'attachment',$principle,$principle->id,'contractor');
            foreach($request->file('attachment') as $item){
                if ($item instanceof \Illuminate\Http\UploadedFile) {
                    $fileName = $item->getClientOriginalName();
                    $filePath = $item->move('uploads/principle/other/' . $dmsFormData['dmsamend_id'], $fileName);

                    DMS::create([
                        'file_name' => $fileName ?? null,
                        'attachment' => $filePath ?? null,
                        'attachment_type' => 'attachment',
                        'dmsable_type' => $dmsFormData['dmsable_type'],
                        'dmsable_id' => $dmsFormData['dmsable_id'],
                        'file_source_id'=>$request->file_source_id ?? null,
                        'document_type_id'=>$request->document_type_id ??  null,
                        'final_submission'=>$request->final_submission ??  'No',
                        'dmsamend_type'=>$dmsFormData['dmsamend_type'] ??  null,
                        'dmsamend_id'=>$dmsFormData['dmsamend_id'] ??  null,
                        'document_specific_type' => $dmsFormData['document_specific_type'] ?? null,
                    ]);
                }
            }
            DB::commit();
            session()->forget('show_data');
            return redirect()->back()->with('success', __('common.create_success'));
        } catch (\Throwable $th) {
            // dD($th);
            DB::rollBack();
            return back()->withErrors(__('common.something_went_wrong_please_try_again'));
        }
    }



    public function uploadImage($request, $unlink = null, $img_path = null)
    {
        if ($request->hasFile('attachment')) {
            $filenameArr = [];
            foreach ($request->file('attachment') as $file) {
                $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
                $fileName = str_replace('', '_', $fileName);
                $destinationPath = public_path($img_path);
                $file->move($destinationPath, $fileName);
                $filenameArr[] = $fileName; 
            }
            return $filenameArr;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // dd($request->all(), $id);
        $user = Sentinel::getUser();
        $role = $user->roles->first();
        $type = $request->get('type', false);
        $document_type = $request->get('document_type_id', false);
        $file_source = $request->get('file_source_id', false);
        $file_name = $request->get('file_name', false);
        $from_date = $request->get('from_date', false);
        $till_date = $request->get('till_date', false);
        $sort_by = $request->get('sort_by','desc');
        $proposal_id = $request->get('proposal_id', false);
        $invocation_notification_id = $request->get('invocation_notification_id', false);
        $review_type = $request->get('review_type', false);
        $contractor_id = $request->get('contractor_id', false);
        $contractorTab = $request->get('contractorTab', false);
        // dd($contractorTab);
        $isfilter = false;
        if ($document_type || $file_source || $file_name || $from_date || $till_date || $type || $proposal_id) {
            $isfilter = true;
        }
        $principle = [];
        $principle = Principle::findOrFail($id);
        $flatDms = [];
        $dms = collect();
        $dmsData = collect();
        $hasFilter = false;
        if($isfilter && ($contractor_id || $proposal_id || $invocation_notification_id || $review_type)){
            // $dms = DMS::with(['documentType', 'fileSource','dmsamend'])
            //     ->when($file_name !='',function($q)use ($file_name){
            //         $q->where('dms.file_name','like','%'.$file_name.'%');
            //     })
            //     ->when($type,function($q)use ($id,$type){
            //         if($type == 'documents'){
            //             $q->where('dms.dmsable_id','<=', 0)->where('dms.dmsamend_id', $id);
            //         }else{
            //             $q->whereNotNull('dms.dmsable_id')->where('dms.dmsamend_id', $id);
            //         }
            //     })
            //
            //     ->when($document_type, function ($qd) use ($document_type) {
            //         $qd->where('document_type_id', $document_type);
            //     })->when($file_source, function ($q) use ($file_source) {
            //         $q->where('file_source_id', $file_source);
            //     })->when($from_date, function ($q) use ($from_date) {
            //         $q->where(DB::raw('Date(created_at)'), '>=', $from_date);
            //     })->when($till_date, function ($q) use ($till_date) {
            //         $q->where(DB::raw('Date(created_at)'), '<=', $till_date);
            //     })
            //     // ->when($proposal_id, function ($q) use ($proposal_id) {
            //     //     // $q->where('cases.proposal_id', $proposal_id);
            //     //     $q->leftJoin('cases', 'cases.proposal_id', '=', $proposal_id)
            //     //     ->where('cases.proposal_id', $proposal_id);
            //     // })
            //     // ->when($proposal_id, function ($q) use ($proposal_id) {
            //     //     // dd('222');
            //     //     $q->leftJoin('cases', function($join) {
            //     //         $join->on('dms.dmsable_id', '=', 'cases.id');
            //     //     });
            //     //     // ->leftJoin('proposals', function($join) use ($proposal_id) {
            //     //     //     $join->on('cases.proposal_id', '=', 'proposals.id');
            //     //     // });
            //     // })
            //     ->leftJoin('cases', function($join) {
            //         $join->on('dms.dmsable_id', '=', 'cases.id');
            //     })
            //     ->when($proposal_id, function ($q) use ($proposal_id) {
            //         $q->where('cases.proposal_id', $proposal_id);
            //     })->select('dms.*')

            //     ->orderBy('dms.created_at',$sort_by)
            //     ->where('dms.dmsable_type', 'Cases')
            //     ->get();
            // dd($dms);

            $dmsData = DMS::with(['documentType', 'fileSource'])
                ->when($contractor_id && $type === 'documents' && $contractorTab, function ($q) use ($contractor_id, $contractorTab, &$hasFilter) {
                    $hasFilter = true;
                    $bankingLimitsIds = DB::table('banking_limits')
                        ->where('bankinglimitsable_type', 'Principle')
                        ->where('bankinglimitsable_id', $contractor_id)
                        ->pluck('id');

                    $orderBookIds = DB::table('order_book_and_future_projects')
                        ->where('orderbookandfutureprojectsable_type', 'Principle')
                        ->where('orderbookandfutureprojectsable_id', $contractor_id)
                        ->pluck('id');

                    $trackRecordIds = DB::table('project_track_records')
                        ->where('projecttrackrecordsable_type', 'Principle')
                        ->where('projecttrackrecordsable_id', $contractor_id)
                        ->pluck('id');

                    $managementProfileIds = DB::table('management_profiles')
                        ->where('managementprofilesable_type', 'Principle')
                        ->where('managementprofilesable_id', $contractor_id)
                        ->pluck('id');

                    // $q->where(function ($query) use (
                    //     $contractor_id, $bankingLimitsIds, $orderBookIds, $trackRecordIds, $managementProfileIds,
                    // ) {
                    //     $query->where(function ($sub) use ($contractor_id) {
                    //         $sub->where('dmsable_type', 'Principle')
                    //             // ->where('dmsamend_type', null)
                    //             ->where('dmsable_id', $contractor_id);
                    //     })->orWhere(function ($sub) use ($bankingLimitsIds) {
                    //         $sub->where('dmsable_type', 'BankingLimits')
                    //             ->whereIn('dmsable_id', $bankingLimitsIds);
                    //     })->orWhere(function ($sub) use ($orderBookIds) {
                    //         $sub->where('dmsable_type', 'OrderBookAndFutureProjects')
                    //             ->whereIn('dmsable_id', $orderBookIds);
                    //     })->orWhere(function ($sub) use ($trackRecordIds) {
                    //         $sub->where('dmsable_type', 'ProjectTrackRecords')
                    //             ->whereIn('dmsable_id', $trackRecordIds);
                    //     })->orWhere(function ($sub) use ($managementProfileIds) {
                    //         $sub->where('dmsable_type', 'ManagementProfiles')
                    //             ->whereIn('dmsable_id', $managementProfileIds);
                    //     });
                    // });

                    $q->where(function ($query) use (
                        $contractor_id, $bankingLimitsIds, $orderBookIds, $trackRecordIds, $managementProfileIds, $contractorTab, &$hasFilter,
                    ) {
                        // dd($contractorTab);
                        $query
                        ->when($contractorTab == 'Principle', function ($sub) use ($contractor_id, &$hasFilter) {
                            $hasFilter = true;
                            $sub->where('dmsable_type', 'Principle')
                                ->where('dmsamend_type', null)
                                ->where('dmsable_id', $contractor_id);
                        })
                        ->when($contractorTab == 'BankingLimits', function ($sub) use ($bankingLimitsIds, &$hasFilter) {
                            $hasFilter = true;
                            $sub->where('dmsable_type', 'BankingLimits')
                                ->whereIn('dmsable_id', $bankingLimitsIds);
                        })
                        ->when($contractorTab == 'OrderBookAndFutureProjects', function ($sub) use ($orderBookIds, &$hasFilter) {
                            $hasFilter = true;
                            $sub->where('dmsable_type', 'OrderBookAndFutureProjects')
                                ->whereIn('dmsable_id', $orderBookIds);
                        })
                        ->when($contractorTab == 'ProjectTrackRecords', function ($sub) use ($trackRecordIds, &$hasFilter) {
                            $hasFilter = true;
                            $sub->where('dmsable_type', 'ProjectTrackRecords')
                                ->whereIn('dmsable_id', $trackRecordIds);
                        })
                        ->when($contractorTab == 'ManagementProfiles', function ($sub) use ($managementProfileIds, &$hasFilter) {
                            $hasFilter = true;
                            $sub->where('dmsable_type', 'ManagementProfiles')
                                ->whereIn('dmsable_id', $managementProfileIds);
                        });
                        // ->when($contractorTab == 'Other', function ($sub) use ($contractor_id, $contractorTab) {
                        //     $sub->where('dmsable_type', $contractorTab)
                        //     ->where('dmsamend_type', 'Principle')
                        //     ->where('dmsable_id', $contractor_id);
                        // });
                    });
                })
                ->leftJoin('cases', function ($join) {
                    $join->on('dms.dmsable_id', '=', 'cases.id');
                })
                ->leftJoin('proposals', function ($join) {
                    $join->on('dms.dmsamend_id', '=', 'proposals.id');
                })
                ->when($type !='indemnity_letter_document_view' && $proposal_id, function ($q) use ($proposal_id, &$hasFilter) {
                    $hasFilter = true;
                    $q->where('cases.proposal_id', $proposal_id)
                        ->where('dms.dmsable_type', 'Cases')
                        ->where('dms.dmsamend_type', 'Proposal');
                })
                ->when($contractor_id && $type === 'review' && $review_type, function ($q) use ($contractor_id, $review_type, &$hasFilter) {
                    $hasFilter = true;
                    $q->where('cases.contractor_id', $contractor_id)
                        ->where('dms.dmsable_type', 'Cases')
                        ->when($review_type === 'contractor_review_docs', function ($cdocs) {
                            $cdocs->where('dms.dmsamend_type', 'Principle');
                        })
                        ->when($review_type === 'invocation_review_docs', function ($idocs) {
                            $idocs->where('dms.dmsamend_type', 'InvocationNotification');
                        });
                        // ->whereIn('dms.dmsamend_type', ['Principle', 'InvocationNotification']);
                })
                ->when($contractor_id && $type === 'other', function ($q) use ($contractor_id, &$hasFilter) {
                    $hasFilter = true;
                    $q->where('dmsable_id', $contractor_id)
                        ->where('dms.dmsable_type', 'Other')
                        ->where('dms.dmsamend_type', 'Principle');
                })
                ->when($invocation_notification_id && $type === 'invocation_notification_view', function ($q) use ($invocation_notification_id, &$hasFilter) {
                    $hasFilter = true;
                    $q->where('dms.dmsable_id', $invocation_notification_id)
                        ->where('dms.dmsable_type', 'InvocationNotification');
                        // ->groupBy('dms.attachment_type');
                })
                ->when($type == 'indemnity_letter_document_view', function ($sub) use ($proposal_id, &$hasFilter) {
                            $hasFilter = true;

                            $sub->where('dmsable_id',$proposal_id)
                            ->where('dmsable_type', 'Proposal')
                            ->where('attachment_type','indemnity_letter_document');
                })
                ->when($this->user->hasAnyAccess('users.superadmin'),function($q){
                    $q->withTrashed();
                });
                // ->select('dms.*', 'proposals.code as proposalCode', 'proposals.version as proposalVersion', 'cases.id as case_id')
                // ->orderBy('dms.created_at', $sort_by)
                // ->get();

            if (!$hasFilter) {
                $dmsData->whereRaw('0 = 1'); // Always false
            }

            $results = $dmsData->select('dms.*', 'proposals.code as proposalCode', 'proposals.version as proposalVersion', 'cases.id as case_id')
                ->orderBy('dms.created_at', $sort_by)
                ->get();

            // $dms = $dmsData->groupBy('dmsable_type');
            $dms = $results;
        }
        if(in_array($type, ['documents', 'review', 'application', 'other', 'invocation_notification'])){
            $route = 'dms.contractor.' . $type . '.show';
        } else {
            $route = 'dms.show';
        }

        switch ($type) {
            case 'application_view':
                $route = 'dms.contractor.application.documents';
                break;
            case 'invocation_notification_view':
                $route = 'dms.contractor.invocation_notification.documents';
                break;
            case 'indemnity_letter_document':
                $route = 'dms.contractor.indemnity_letter.indemnity_letter_document';
                break;
            case 'indemnity_letter_document_view':
                $route = 'dms.contractor.indemnity_letter.indemnity_letter_document_view';
                break;
            default:
                // $route = 'dms.show';
                break;
        } 
        // dd($route);
        // $dmsable_id = $dmsData->first()->dmsable_id ?? $request->case_id ?? null;

        // if ($type == 'invocation_notification_view') {
        //     $dmsable_id = $request->invocation_notification_id;
        //     $dmsamend_id = null;
        //     $dmsable_type = 'InvocationNotification';
        //     $dmsamend_type = null;
        // } else {
        //     $dmsable_id = $request->case_id ?? $request->review_case_id ?? $request->invocation_review_case_id ?? $contractor_id ?? null;
        //     $dmsable_type = ($request->dmsable_type === 'Cases') ? 'Cases' : 'Other';

        //     if ($request->dmsable_type === 'Cases' && $proposal_id) {
        //         $dmsamend_type = 'Proposal';
        //         $dmsamend_id = $proposal_id;
        //     } else {
        //         $dmsamend_type = 'Principle';
        //         $dmsamend_id = $contractor_id;
        //     }
        // }

        // if ($type === 'invocation_notification_view') {
        //     $dmsable_id   = $request->invocation_notification_id;
        //     $dmsamend_id  = null;
        //     $dmsable_type = 'InvocationNotification';
        //     $dmsamend_type = null;
        // } else {
        //     $dmsable_id = $request->case_id ?? $request->review_case_id ?? $contractor_id ?? null;
        //     $dmsable_type = ($request->dmsable_type === 'Cases') ? 'Cases' : 'Other';
        //     $isCaseWithProposal = $request->dmsable_type === 'Cases' && $proposal_id;
        //     $dmsamend_type = $isCaseWithProposal ? 'Proposal' : 'Principle';
        //     $dmsamend_id   = $isCaseWithProposal ? $proposal_id : $contractor_id;
        // }

        switch ($type) {
            case 'invocation_notification_view':
                $dmsable_id    = $request->invocation_notification_id;
                $dmsamend_id   = null;
                $dmsable_type  = 'InvocationNotification';
                $dmsamend_type = null;
                break;

            case 'application_view':
                $dmsable_id    = $request->case_id;
                $dmsamend_id   = $proposal_id;
                $dmsable_type  = 'Cases';
                $dmsamend_type = 'Proposal';
                $document_specific_type = 'Project';
                break;
            
            case 'review':
                $dmsable_type  = 'Cases';
                $document_specific_type = 'Contractor';
                if(isset($review_type) && $review_type === 'contractor_review_docs'){
                    $dmsable_id    = $request->review_case_id;
                    $dmsamend_id   = $contractor_id;
                    $dmsamend_type = 'Principle';
                } else if(isset($review_type) && $review_type === 'invocation_review_docs'){
                    $dmsable_id    = $request->invocation_review_case_id;
                    $dmsamend_id   = $request->invocation_notification_id;
                    $dmsamend_type = 'InvocationNotification';
                }
                break;
            
            case 'other':
                $dmsamend_id = $dmsable_id = $contractor_id;
                $dmsable_type  = 'Other';
                $dmsamend_type = 'Principle';
                $document_specific_type = 'Contractor';
                break;

            default:
                break;
        }




        // $dmsable_type = $dmsData->first()->dmsable_type ?? null;
        // $dmsable_id = $dmsData->first()->dmsable_id ?? null;
        // $dmsamend_type = $dmsData->first()->dmsamend_type ?? null;
        // $dmsamend_id = $dmsData->first()->dmsamend_id ?? null;

        // dd($dmsData);
        $formData = ['dmsable_type' => $dmsable_type ?? null, 'dmsable_id' => $dmsable_id ?? null, 'dmsamend_type' => $dmsamend_type ?? null, 'dmsamend_id' => $dmsamend_id ?? null, 'document_specific_type' => $document_specific_type ?? null];
        $this->data['formData'] = $formData;
        // dd($formData);
        session(['show_data' => $this->data['formData']]);
        
        if ($principle) {
            $this->data['page_title'] = 'Document' . ' - ' . $principle->code . ' | ' . $principle->company_name;
        }
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['documentType'] = $this->common->getDocumentTypeOpction();
        $this->data['fileSource'] = $this->common->getFileSourceOpction();
        $this->data['principle'] = $principle;
        $this->data['dms'] = $dms;
        $this->data['isfilter'] = $isfilter;
        $this->data['sort_by'] = $sort_by;
        $this->data['document_type'] = $document_type;
        $this->data['file_name'] = $file_name;
        $this->data['file_source'] = $file_source;
        $this->data['from_date'] = $from_date;
        $this->data['till_date'] = $till_date;
        $this->data['type'] = $type;
        $this->data['proposals'] = Proposal::where('contractor_id', $request->contractor_id)->whereNotNull('cases_id')->select('code', 'id', 'version')->get();
        // $reviewedCases = Cases::where('casesable_type', 'Principle')->where('casesable_id', $contractor_id)->where('contractor_id', $contractor_id);
        $reviewedContractorCases = Cases::where('casesable_type', 'Principle')->whereIn('contractor_id', [$contractor_id, $id]);
        $reviewedInvocationCases = Cases::where('casesable_type', 'InvocationNotification')->whereIn('contractor_id', [$contractor_id, $id]);
        $this->data['isReview'] = $reviewedContractorCases->exists();
        $invocationNotificationExists = InvocationNotification::whereIn('contractor_id', [$contractor_id, $id]);
        $isInvocationNotificationReview = $invocationNotificationExists->exists();
        $this->data['isInvocationNotificationReview'] = $isInvocationNotificationReview;
        $this->data['invocationNotifications'] = $isInvocationNotificationReview ? $invocationNotificationExists->select('code', 'id')->get() : [];
        // dd($this->data['invocationNotifications']);
        $this->data['invocation_docs'] = $request->get('invocation_docs', false);
        $this->data['contractor_id'] = $request->contractor_id;
        $this->data['proposal_id'] = $request->proposal_id;
        $this->data['invocation_notification_id'] = $request->invocation_notification_id;
        $this->data['review_case_id'] = $reviewedContractorCases->max('id') ?? '';
        $this->data['invocation_review_case_id'] = $reviewedInvocationCases->max('id') ?? '';
        $this->data['case_id'] = $request->case_id ?? '';
        return view($route, $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles->first();
        $dms = DMS::with('dmsamend')->find($id);
        $this->data['dms'] = $dms;
        $this->data['contractor_id'] = $request->contractor_id ?? null;
        $this->data['type'] = $request->type;
        $this->data['contractor'] = Principle::where('is_active', 'Yes')->select('id',DB::raw('(CASE WHEN code is not null THEN CONCAT(company_name," (",code,")") ELSE company_name END) AS code'))->pluck('code', 'id')->toArray();
        $this->data['document_type'] = $this->common->getDocumentTypeOpction();
        $this->data['file_source'] = $this->common->getFileSourceOpction();
        return response()->json([
            'html' =>  view('dms.contractor.edit', $this->data)->render()
        ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, DmsRequest $request)
    {
        $dmsamend_id = $request->dmsamend_id;
        $document_type_id = $request->document_type_id ?? Null;
        $file_name = $request->file_name ?? Null;
        $dms = DMS::findOrFail($id);
        $update_data = [
            'final_submission'=>$request->final_submission ??  'No',
            // 'dmsamend_id'=>$dmsamend_id,
            // 'dmsamend_type'=>($dmsamend_id > 0) ? 'Principle':  Null,
            'document_type_id'=>$document_type_id,
            'file_source_id'=>$request->file_source_id ??  Null,
            'file_name'=>$request->file_name ??  Null,
        ];
        DMS::where('id', $id)->update($update_data);
        return redirect()->back()->with('success', __('common.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dms = Dms::findOrFail($id);
        $dms->delete();
        // if ($dms) {
        //     $dependency = $dms->deleteValidate($id);
        //     if (!$dependency) {
        //         $dms->delete();
        //     } else {
        //         return response()->json([
        //             'success' => false,
        //             'message' => __('dms.dependency_error', ['dependency' => $dependency]),
        //         ], 200);
        //     }
        // }
        return response()->json([
            'page_refresh'=>true,
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function dmsCommentView(Request $request, $id)
    {
        $id = $id;
        $this->data['dmsview'] = DmsComment::with('createdBy')->where('dms_id', $id)->get();
        return response()->json(['html' => view('cases.dmsCommentview', $this->data)->render()]);
    }

    public function dmsOverdue(Request $request, $id)
    {
        $this->data['overdue'] = Dms::with(['dmsAttachment'=>function($q){
            $q->where('attachment_type','overdue');
        },'overdue'])->where('overdue_id', $id)->where('overdue_id',$id)->whereNull('overdue_item_id')->get();
        $this->data['overdueItem'] = Dms::with(['dmsAttachment'=>function($q){
            $q->where('attachment_type','overdue_items');
        },'overdueItem'])->where('overdue_id', $id)->whereNotNull(columns: 'overdue_item_id')->get();
        $this->data['overdue_id'] = $id;
        return view('dms.overdueItemShow', $this->data);
    }



    public function dmsshowOverdue($id)
    {
        $buyer = Buyer::findOrFail($id);
        if ($buyer) {
            $this->data['page_title'] = 'Document' . ' - ' . $buyer->bin . ' | ' . $buyer->name;
        }

        $this->data['overdue'] = Overdue::with(['overdueItem','nbi'])->where('buyer_id', $id)->get();
        // dd($this->data['overdue']);
        return view('dms.overdueShow', $this->data);

    }

    public function dmsClaim(Request $request, $id)
    {
        $claimDocument = Claim::with(['dmsClaimsdocument','claimDocumentation','claimDocumentationIrda'])->where('id', $id)->first();
        $this->data['page_title'] = 'Document'.' | '.$claimDocument->code;
        $this->data['claimDocument'] = $claimDocument;
        $this->data['claim_id'] = $id;
        return view('dms.claimDocumentShow', $this->data);

    }
    public function dmsApplication($buyer_id){

         $this->data['attachment'] = Dms::with(['createdBy', 'documentType', 'fileSource','dmsAttachment'])->where('buyer_id', $buyer_id)
         ->whereNotNull('cases_tray_id')->orderBy('id', 'DESC')->get();
        
         return view('dms.applicationShow',$this->data);
    }

    public function dmsOverdueSynopsis($id){
        $this->data['overdueSynopsis'] = Dms::with(['dmsAttachment'=>function($q){
            $q->where('attachment_type','overdue_synopsis');
        }])->where('overdue_id', $id)->whereNotNull(columns: 'overdue_synopsis_id')->get();

        return view('dms.overdueSynopsisShow',$this->data);
    }
    public function dmsClaimSynopsis($id){
        $this->data['claimSynopsis'] = Dms::with(['dmsAttachment'=>function($q){
            $q->where('attachment_type','claim_synopsis');
        }])->where('claim_id', $id)->whereNotNull(columns: 'claim_synopsis_id')->get();

        return view('dms.claimSynopsisShow',$this->data);
    }
    public function dmsRenameFileNameForm($id){

        $this->data['dms'] = Dms::find($id);

        return response()->json(['html' => view('dms.common.rename_filename', $this->data)->render()]);
    }
}
