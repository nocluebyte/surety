@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('cases.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
                <div class="card card-custom">
                    <div class="card-header" id="faqHeading1">
                        <div class="col-lg-10 p-5">
                            <table style="width:100%">
                                <tr>
                                    <th width="25%">
                                        <div class="font-weight-bold my-2" style=" color : #9d9595;">{{ ($case->casesable_type == 'Principle' || $case->casesable_type == 'Proposal') ? __('cases.contractor_name') : __('cases.beneficiary_name') }}</div>
                                    </th>
                                    <th width="20%">
                                        <div class="font-weight-bold my-2" style=" color : #9d9595;">{{ __('cases.cin_number') }}</div>
                                    </th>
                                    <th width="20%">
                                        <div class="font-weight-bold my-2" style=" color : #9d9595;">{{ __('common.country') }}</div>
                                    </th>
                                    <th width="20%">
                                        <div class="font-weight-bold my-2" style=" color : #9d9595;">{{ __('common.currency') }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <h6>
                                            <div class="form-group font-weight-bold mt-n2" style=" color : #000000;">
                                                {{ $companyProfile->company_name ?? '' }}
                                            </div>
                                        </h6>
                                    </th>
                                    <th>
                                        <h6>
                                            <div class="form-group font-weight-bold mt-n2" style=" color : #000000;">
                                                {{ $companyProfile->code ?? '' }}
                                            </div>
                                        </h6>
                                    </th>

                                    <th>
                                        <h6>
                                            <div class="form-group font-weight-bold mt-n2" style=" color : #000000;">
                                                {{ $companyProfile->country->name ?? '' }}

                                                @if (isset($companyProfile->country))
                                                    <input type="hidden" class="jscountry"
                                                        data-midlevel='{{ $companyProfile->country->mid_level }}'>
                                                @endif
                                            </div>
                                        </h6>
                                    </th>
                                    <th>
                                        <h6>
                                            <div class="form-group font-weight-bold mt-n2" style=" color : #000000;">
                                                {{ $companyProfile->country->currency->short_name ?? '' }}
                                            </div>
                                        </h6>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="card card-custom gutter-b">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom">
                            <div class="card-header pr-0">
                                <div class="card-title font-weight-bolder text-dark">
                                    <ul class="nav nav-light-success nav-boldest nav-pills">
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.synopsis']))
                                            <li class="nav-item">
                                                <a class="nav-link  active" data-toggle="tab" href="#synopsis">
                                                    <span class="nav-text">Synopsis</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.decision']))
                                            @if($case->case_type == 'Application')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#decision">
                                                        <span class="nav-text">Decision</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.parameter']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#parameter">
                                                    <span class="nav-text">Parameter</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.action_plan']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#action_plan">
                                                    <span class="nav-text">Action Plan</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.contractor']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#contractor">
                                                    <span class="nav-text">Contractor</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.beneficiary']))
                                            @if($case->case_type == 'Application')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#beneficiary">
                                                        <span class="nav-text">Beneficiary</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.tender']))
                                            @if($case->case_type == 'Application')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tender">
                                                        <span class="nav-text">Tender</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#company_profile">
                                                <span class="nav-text">Company Profile</span>
                                            </a>
                                        </li> --}}
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.banking_details']))
                                            @if($case->case_type == 'Application')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#banking_details">
                                                        <span class="nav-text">Banking Details</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.project_details']))
                                            @if($case->case_type == 'Application')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#project_details">
                                                        <span class="nav-text">Project Details</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.approved_limits']))
                                            {{-- @if($case->casesable_type == 'Proposal' && $case->case_type == 'Application') --}}
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#approved_limits">
                                                        <span class="nav-text">Approved Limits</span>
                                                    </a>
                                                </li>                                       
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#proposal_details">
                                                        <span class="nav-text">Proposal Details</span>
                                                    </a>
                                                </li> --}}
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tender_evaluation">
                                                        <span class="nav-text">Tender Evaluation</span>
                                                    </a>
                                                </li> --}}
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#pricing">
                                                        <span class="nav-text">Pricing</span>
                                                    </a>
                                                </li> --}}
                                            {{-- @endif --}}
                                         @endif
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#beneficiary_evaluation">
                                                <span class="nav-text">Beneficiary Evaluation</span>
                                            </a>
                                        </li> --}}
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.dms']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#dms">
                                                    <span class="nav-text">{{__('cases.dms')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.group_approved_limit']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#group_approved_limit">
                                                    <span class="nav-text">Group Approved Limit</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.incharge_log']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#incharge_log">
                                                    <span class="nav-text">Incharge Log</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.invocation_details']))
                                            @if ($case->casesable_type == 'InvocationNotification')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#invocation_details">
                                                        <span class="nav-text">Invocation Details</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.invocation_notification']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#invocation_notification">
                                                    <span class="nav-text">Invocation Notification</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.recovery']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#recovery">
                                                    <span class="nav-text">Recovery</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.last_5_year_track_record']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#last_5_year_track_record">
                                                    <span class="nav-text">Last 5 Year Track Record</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($current_user->hasAnyAccess(['users.superadmin','cases.order_book_and_future_projects']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#order_book_and_future_projects">
                                                    <span class="nav-text">Order Book and Future Projects</span>
                                                </a>
                                            </li>
                                        @endif
                                         @if ($current_user->hasAnyAccess(['users.superadmin','cases.adverse_information']))
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#adverse_information">
                                                    <span class="nav-text">Adverse Information</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="tab-content">
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.synopsis']))
                                        <div class="tab-pane fade active show pt-5" id="synopsis" role="tabpanel" aria-labelledby="synopsis">
                                            @include('cases.tabs.synopsis.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.decision']))
                                        @if($case->case_type == 'Application')
                                            <div class="tab-pane fade  pt-5" id="decision" role="tabpanel" aria-labelledby="decision">
                                                @include('cases.tabs.decision.create')
                                            </div>
                                        @endif
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.parameter']))
                                        <div class="tab-pane fade  pt-5" id="parameter" role="tabpanel" aria-labelledby="parameter">
                                            @include('cases.tabs.parameter.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.action_plan']))
                                        <div class="tab-pane fade  pt-5" id="action_plan" role="tabpanel" aria-labelledby="action_plan">
                                            @include('cases.tabs.action-plan.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.contractor']))
                                        <div class="tab-pane fade  pt-5" id="contractor" role="tabpanel" aria-labelledby="contractor">
                                            @include('cases.tabs.contractor.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.beneficiary']))
                                        @if($case->case_type == 'Application')
                                            <div class="tab-pane fade  pt-5" id="beneficiary" role="tabpanel" aria-labelledby="contractor">
                                                @include('cases.tabs.beneficiary.index')
                                            </div>
                                        @endif
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.tender']))
                                        @if($case->case_type == 'Application')
                                            <div class="tab-pane fade  pt-5" id="tender" role="tabpanel" aria-labelledby="tender">
                                                @include('cases.tabs.tender.index')
                                            </div>
                                        @endif
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.banking_details']))
                                        @if($case->case_type == 'Application')
                                            <div class="tab-pane fade  pt-5" id="banking_details" role="tabpanel" aria-labelledby="banking_details">
                                                @include('cases.tabs.banking_details.index')
                                            </div>
                                        @endif
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.project_details']))
                                        @if($case->case_type == 'Application')
                                            <div class="tab-pane fade  pt-5" id="project_details" role="tabpanel" aria-labelledby="project_details">
                                                @include('cases.tabs.project_details.index')
                                            </div>
                                        @endif
                                    @endif
                                    {{-- <div class="tab-pane fade  pt-5" id="company_profile" role="tabpanel" aria-labelledby="company_profile">
                                        @include('cases.tabs.company-profile.index')
                                    </div> --}}
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.approved_limits']))
                                        {{-- @if($case->casesable_type == 'Proposal' && $case->case_type == 'Application') --}}
                                            <div class="tab-pane fade  pt-5" id="approved_limits" role="tabpanel" aria-labelledby="approved_limits">
                                                @include('cases.tabs.approved_limits.index')  
                                            </div>                                    
                                            {{-- <div class="tab-pane fade  pt-5" id="proposal_details" role="tabpanel" aria-labelledby="proposal_details">
                                                proposal_details
                                            </div> --}}
                                        
                                            {{-- <div class="tab-pane fade  pt-5" id="tender_evaluation" role="tabpanel" aria-labelledby="proposal_details">
                                                @include('cases.tabs.tender-evaluation.create')
                                            </div>                                    --}}
                                            {{-- <div class="tab-pane fade  pt-5" id="pricing" role="tabpanel" aria-labelledby="pricing">
                                                pricing
                                            </div> --}}
                                        {{-- @endif --}}
                                    @endif
                                    {{-- <div class="tab-pane fade  pt-5" id="beneficiary_evaluation" role="tabpanel" aria-labelledby="beneficiary_evaluation">
                                        beneficiary_evaluationparent
                                    </div> --}}
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.dms']))
                                        <div class="tab-pane fade  pt-5" id="dms" role="tabpanel" aria-labelledby="dms">
                                            @include('cases.tabs.dms.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.group_approved_limit']))
                                        <div class="tab-pane fade  pt-5" id="group_approved_limit" role="group_approved_limit" aria-labelledby="group_approved_limit">
                                            @include('cases.tabs.group_approved_limit.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.incharge_log']))
                                        <div class="tab-pane fade  pt-5" id="incharge_log" role="tabpanel" aria-labelledby="incharge_log">
                                            @include('cases.tabs.incharge_log.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.invocation_details']))
                                        @if ($case->casesable_type == 'InvocationNotification')
                                            <div class="tab-pane fade  pt-5" id="invocation_details" role="tabpanel" aria-labelledby="invocation_details">
                                                @include('cases.tabs.invocation_details.index')
                                            </div>
                                        @endif
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.invocation_notification']))
                                        <div class="tab-pane fade  pt-5" id="invocation_notification" role="tabpanel" aria-labelledby="invocation_notification">
                                            @include('cases.tabs.invocation_notification.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.recovery']))
                                        <div class="tab-pane fade  pt-5" id="recovery" role="tabpanel" aria-labelledby="recovery">
                                            @include('cases.tabs.recovery.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.last_5_year_track_record']))
                                        <div class="tab-pane fade  pt-5" id="last_5_year_track_record" role="tabpanel" aria-labelledby="last_5_year_track_record">
                                            @include('cases.tabs.last_5_year_track_record.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.order_book_and_future_projects']))
                                        <div class="tab-pane fade  pt-5" id="order_book_and_future_projects" role="tabpanel" aria-labelledby="order_book_and_future_projects">
                                            @include('cases.tabs.order_book_and_future_projects.index')
                                        </div>
                                    @endif
                                    @if ($current_user->hasAnyAccess(['users.superadmin','cases.adverse_information']))
                                        <div class="tab-pane fade  pt-5" id="adverse_information" role="tabpanel" aria-labelledby="adverse_information">
                                            @include('cases.tabs.adverse_information.index')
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('info')
@endsection
@section('scripts')
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.custom.js') }}"></script>
<script>
    var datesArrList = @json($datesArr) ?? [];
</script>
@include('cases.tabs.dms.script')
@include('cases.tabs.script')
@endsection
