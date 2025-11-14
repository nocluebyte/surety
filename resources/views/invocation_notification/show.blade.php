@extends($theme)
@section('title', __('invocation_notification.invocation_notification'))
@section('content')
@component('partials._subheader.subheader-v6', [
    'page_title' => __('invocation_notification.invocation_notification'),
    'back_action' => route('invocation-notification.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <h3><span class="float-left">{{$invocationData->code}}</span></h3>
                        </div>
                        <div class="col-8">
                            <div class="card-toolbar ml-40 pl-40 text-right">
                                @if ($current_user->hasAnyAccess(['invocation_notification.claim_examiner', 'users.superadmin']) && $invocationData->status == 'Pending')
                                    <button class="btn btn-success btn-sm font-weight-bold" data-toggle="modal" data-target="#ClaimExaminerModal">
                                        {{ __('invocation_notification.claim_examiner') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   <div class="row p-2">
                        <div class="col-2 text-light-grey">{{__('invocation_notification.contractor') }}</div>
                        <div class="col-2">{{$invocationData->proposal->contractor_company_name ?? ''}}</div>
                        <div class="col-2 text-light-grey">{{__('invocation_notification.beneficiary')}}</div>
                        <div class="col-2">{{$invocationData->proposal->beneficiary_company_name ?? ''}}</div>
                        <div class="col-2 text-light-grey">{{__('invocation_notification.project_name')}}</div>
                        <div class="col-2">{{$invocationData->proposal->pd_project_name ?? ''}}</div>
                   </div>
                   <div class="row p-2">
                        <div class="col-2 text-light-grey">{{__('invocation_notification.tender')}}</div>
                        <div class="col-2">{{$invocationData->proposal->tender_header ?? ''}}</div>
                        <div class="col-2 text-light-grey">{{__('invocation_notification.bond_type')}}</div>
                        <div class="col-2">{{$invocationData->bondType->name ?? ''}}</div>
                        <div class="col-2 text-light-grey">{{__('invocation_notification.bond_value')}} {{ $currencySymbol }}</div>
                        <div class="col-2">{{numberFormatPrecision($invocationData->invocation_amount,0)}}</div>
                    </div>
                    <div class="row p-2">
                        <div class="col-2 text-light-grey">{{__('invocation_notification.bond_start_date')}}</div>
                        <div class="col-2">{{isset($invocationData->bond_start_date) ? custom_date_format($invocationData->bond_start_date,'d/m/Y') : ''}}</div>
                        <div class="col-2 text-light-grey">{{__('invocation_notification.bond_end_date')}}</div>
                        <div class="col-2">{{isset($invocationData->bond_end_date) ? custom_date_format($invocationData->bond_end_date,'d/m/Y') : '' }}</div>
                        <div class="col-2 text-light-grey">{{__(key: 'invocation_notification.bond_conditionality')}}</div>
                        <div class="col-2">{{$invocationData->bond_conditionality ?? ''}}</div>
                    </div>
                </div>
            </div>
        <br>
        @include('components.error')
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title font-weight-bolder text-dark">
                    <ul class="nav nav-light-success nav-boldest nav-pills">
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.intimation_invocation_details'))
                            <li class="nav-item">
                                <a class="nav-link active p-4" data-toggle="tab" href="#intimation_invocation_details">
                                    <span class="nav-text">Intimation Invocation Details</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.contractor'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#contractor">
                                    <span class="nav-text">Contractor</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.analysis'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#action_plan">
                                    <span class="nav-text">Analysis</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.decision'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#decision">
                                    <span class="nav-text">Decision</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.dms'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#dms">
                                    <span class="nav-text">DMS</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.previous_invocation'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#previous_invocation">
                                    <span class="nav-text">Previous Invocation</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.recovery'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#recovery">
                                    <span class="nav-text">Recovery</span>
                                </a>
                            </li>
                        @endif
                        @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.incharge_log'))
                            <li class="nav-item">
                                <a class="nav-link p-4" data-toggle="tab" href="#incharge_log">
                                    <span class="nav-text">Incharge Log</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="tab-content">
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.intimation_invocation_details'))
                        <div class="tab-pane fade active show pt-5" id="intimation_invocation_details" role="intimation_invocation_details" aria-labelledby="intimation_invocation_details">
                            @include('invocation_notification.tabs.intimation_invocation_details')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.contractor'))
                        <div class="tab-pane fade pt-5" id="contractor" role="contractor" aria-labelledby="contractor">
                            @include('invocation_notification.tabs.contractor')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.analysis'))
                        <div class="tab-pane fade pt-5" id="action_plan" role="action_plan" aria-labelledby="action_plan">
                            @include('invocation_notification.tabs.action_plan')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.decision'))
                        <div class="tab-pane fade pt-5" id="decision" role="decision" aria-labelledby="decision">
                                @include('invocation_notification.tabs.decision')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.dms'))
                        <div class="tab-pane fade  pt-5" id="dms" role="tabpanel" aria-labelledby="dms">
                            @include('invocation_notification.tabs.dms')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.previous_invocation'))
                        <div class="tab-pane fade pt-5" id="previous_invocation" role="previous_invocation" aria-labelledby="previous_invocation">
                            @include('invocation_notification.tabs.previous_invocation')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.recovery'))
                        <div class="tab-pane fade pt-5" id="recovery" role="recovery" aria-labelledby="recovery">
                            @include('invocation_notification.tabs.recovery')
                        </div>
                    @endif
                    @if($current_user->hasAnyAccess('users.superadmin', 'invocation_notification.incharge_log'))
                        <div class="tab-pane fade  pt-5" id="incharge_log" role="tabpanel" aria-labelledby="incharge_log">
                            @include('invocation_notification.tabs.incharge_log')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('info')
<div id="load-modal"></div>
@include('invocation_notification.modal.payout')
@include('invocation_notification.modal.claim-examiner')
@include('invocation_notification.modal.cancellelation')
@include('invocation_notification.modal.analysis')
@endsection
@section('scripts')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor/ckeditor.custom.js') }}"></script>
    @include('invocation_notification.script')
@endsection
