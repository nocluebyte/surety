@extends($theme)
@section('title', __('proposals.proposals'))
@section('content')
    @php
        $navigation = [
            'page_title' => __('proposals.proposals'),
            'back_action' => route('proposals.index'),
            'text' => __('common.back'),
        ];
        if(!in_array($proposals->status, ['Confirm', 'Cancel', 'Pending'])){
            $navigation = array_Merge($navigation, [
                'pdf_id' => '',
                'pdf_link' => isset($proposals?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($proposals?->Endorsement?->dMS?->attachment)) : '',
            ]);
        }
    @endphp
    @component('partials._subheader.subheader-v6', $navigation)
    @endcomponent
    @php
        $proposal_id = $proposals->id;
        $proposals_status_url = route('proposals-status', encryptId($proposal_id));
        $status = $proposals->status;
        $superadmin = $current_user->hasAnyAccess(['users.superadmin']);
        $underwriter_user_id = '';        
        $agreed_nbi = $nbis->whereIn('status', ['Agreed'])->count();
    @endphp
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">

            @include('components.error')
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title font-weight-bolder text-dark">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="proposal-tab-3" data-toggle="tab" href="#proposal-3">
                                    <span class="nav-text">Proposals</span>
                                </a>
                            </li>
                            {{-- @if ($current_user->hasAnyAccess(['proposals.tender_evaluation_view', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link" id="tender-evaluation-tab" data-toggle="tab"
                                        href="#tender-evaluation" aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.tender_evaluation') }}</span>
                                    </a>
                                </li>
                            @endif --}}
                            @if ($current_user->hasAnyAccess(['proposals.nbi_list', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link" id="nbi-tab" data-toggle="tab" href="#nbi"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.nbi') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.bond_issue_checklist', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link" id="bond-policy-issue-checklist-tab" data-toggle="tab" href="#issue_bond_checklist"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.bond_checklist') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.issue_bond', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link" id="bond-policy-issue-tab" data-toggle="tab" href="#issue_bond"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.issue_bond') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.invocation_notification', 'users.superadmin']) && $proposals->status == 'Invoked' && $proposals->is_invocation_notification == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="invocation-notification-tab" data-toggle="tab" href="#invocation_notification"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.invocation_notification') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.invocation_claim', 'users.superadmin']) && $proposals->status == 'Approved' && $proposals->is_invocation_notification == 1 && $proposals->is_claim_converted == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="invocation-claim-tab" data-toggle="tab" href="#invocation_claim"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.invocation_claim') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.bond_fore_closure', 'users.superadmin']) && $proposals->status == 'Forclosed' && $proposals->is_bond_foreclosure == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="bond-foreclosure-tab" data-toggle="tab" href="#bond_foreclosure"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.bond_foreclosure') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.bond_cancellation', 'users.superadmin']) && $proposals->status == 'Cancelled' && $proposals->is_bond_cancellation == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="bond-cancellation-tab" data-toggle="tab" href="#bond_cancellation"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.bond_cancellation') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($current_user->hasAnyAccess(['proposals.bond_progress', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link" id="bond-progress-tab" data-toggle="tab" href="#bond_progress"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('common.bond_progress') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="nav-item mt-7">
                        {{-- @if (in_array($proposals->status, ['Approved', 'Rejected']))
                        <a href="{{asset($proposals?->Endorsement?->dMS?->attachment)}}"
                           target="_blanck"  class="btn btn-light-primary btn-sm font-weight-bold navi-link">
                            Endorsement
                        </a>
                        @endif --}}
                        {{-- @if ($current_user->hasAnyAccess(['proposals.confirm', 'users.superadmin']) && $status == 'Pending' && !isset($proposals->cases_id)) --}}
                        @if ($current_user->hasAnyAccess(['proposals.confirm', 'users.superadmin']) && $status == 'Pending' && $proposals->is_amendment == 0)
                            <a class="btn btn-light-primary btn-sm font-weight-bold navi-link jsApproveBtn"
                                data-current-status="{{ $status }}">
                                {{ __('proposals.confirm') }}
                            </a>
                        @endif
                        {{-- @if (in_array($proposals->status, ['Approved', 'Rejected']))
                            <div class="badge bg-light-primary p-3">
                                <span style="font-size:small;">
                                    {{ $proposals->status ?? '' }}
                                </span>
                            </div>
                        @endif --}}
                        {{-- @dd($nbis) --}}
                        @if (in_array($proposals->status, ['Approved', 'Rejected']) && $nbis->contains('status', 'Pending') && $proposals->is_amendment == 0 && $current_user->hasAnyAccess('users.superadmin', 'proposals.edit'))
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                href="{{ route('proposals.edit', [encryptId($proposals->id), 'is_amendment' => encryptId('yes')]) }}"
                                aria-controls="edit">
                                <i class="fas fa-pencil-alt fa-1x"></i>
                                Amendment
                            </a>
                        @endif
                        @if($current_user->hasAnyAccess(['proposals.bond_issue_checklist', 'users.superadmin']) && $proposals->is_checklist_approved == 0 && $proposals->is_nbi > 0 && $nbis->contains('status', 'Approved') && $proposals->is_amendment == 0)
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                href="{{ route('bondPoliciesIssueChecklist', [$proposals->id]) }}">
                                {{ __('proposals.issue_bond_checklist') }}
                            </a>
                        @endif
                       
                        @if($current_user->hasAnyAccess(['proposals.issue_bond', 'users.superadmin']) && $proposals->is_checklist_approved == 1 && $proposals->is_nbi > 0 && $nbis->contains('status', 'Approved') && $proposals->is_issue == 0)
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                            href="{{ route('bond_policies_issue.create', ['proposal_id' => $proposals->id]) }}">
                                {{ __('proposals.issue_bond') }}
                            </a>
                        @endif
                        @if($proposals->is_checklist_approved == 1 && $proposals->is_nbi > 0 && $nbis->contains('status', 'Approved') && $proposals->is_issue > 0 && $proposals->is_amendment == 0 && $proposals->is_invocation_notification == 0)
                            @if ($proposals->is_bond_foreclosure == 0 && $proposals->is_bond_cancellation == 0)
                                @if($current_user->hasAnyAccess('users.superadmin', 'proposals.edit'))
                                    <a class="btn btn-dark btn-sm font-weight-bold" id=""
                                        href="{{ route('proposals.edit', [encryptId($proposals->id), 'is_amendment' => encryptId('yes')]) }}" aria-controls="edit">
                                        {{ __('proposals.amendment') }}
                                    </a>
                                @endif

                                @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_fore_closure') || $current_user->hasAnyAccess('users.superadmin', 'proposals.bond_cancellation'))
                                    <span class="dropdown drop-down">
                                        <button class="btn btn-sm btn-light-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Bond Management
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_cancellation'))
                                                <a class="dropdown-item font-weight-bold jsBondCancellationBtn" data-redirect="{{route('createBondCancellation', ['back_action_id' => $proposals->id,'type' => 'proposals', 'proposal_id' => $proposals->id])}}" data-table="proposals" id="" href="javascript:void(0);">
                                                    {{ __('proposals.bond_cancellation') }}
                                                </a>
                                            @endif

                                            @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_fore_closure'))
                                                <a class="dropdown-item font-weight-bold jsForeClosureBtn" id="" data-redirect="{{route('createBondForeClosure', ['back_action_id' => $proposals->id,'type' => 'proposals', 'proposal_id' => $proposals->id])}}" data-table="proposals" href="javascript:void(0);">
                                                    {{ __('proposals.bond_foreclosure') }}
                                                </a>
                                            @endif
                                            {{-- {{ route('createBondForeClosure', ['proposal_id' => $proposals->id]) }} --}}

                                            {{-- @if($current_user->hasAnyAccess(['proposals.invocation_notification', 'users.superadmin']))
                                                <a class="dropdown-item font-weight-bold" id=""
                                                    href="{{ route('bondInvocationNotification', [$proposals->id]) }}">
                                                    {{ __('proposals.invocation_notification') }}
                                                </a>
                                            @endif --}}
                                        {{-- @else
                                            @if ($current_user->hasAnyAccess(['proposals.invocation_claims', 'users.superadmin']) && $proposals->is_claim_converted == 0 && $proposals->is_invocation_notification == 1)
                                                <a class="dropdown-item font-weight-bold" id=""
                                                    href="{{ route('invocation-claims.create', ['id' => $proposals->InvocationNotification->id]) }}">
                                                    {{ __('invocation_notification.convert_to_claim') }}
                                                </a>
                                            @endif    --}}                                                                       
                                        </div>
                                    </span>
                                @endif

                                @if ($current_user->hasAnyAccess(['proposals.bond_progress', 'users.superadmin']))
                                    <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                        href="{{ route('bond-progress.create', ['id' => $proposals->id, 'type' => 'proposals', 'back_action_id' => $proposals->id]) }}">
                                        {{ __('common.bond_progress') }}
                                    </a>
                                @endif
                            @endif
                        @endif
                        
                        @if ($current_user->hasAnyAccess(['proposals.terms_sheet', 'users.superadmin']) && $proposals->is_nbi == 0 && (in_array($status, ['Approved', 'Rejected']) && $proposals->is_amendment == 0 || $status == 'Rejected' && $proposals->is_amendment == 1) && $proposals->nbi->count() < 2)
                            <a href="{{ route('nbi.create', ['id' => $proposal_id]) }}"
                                class="btn btn-light-primary btn-sm font-weight-bold nbi_button" type="button"
                                title="">{{ __('proposals.terms_sheet') }}</a>
                        @endif
                        {{-- @if ($current_user->hasAnyAccess(['proposals.edit', 'users.superadmin']) && $status == 'Pending' && !isset($proposals->cases_id)) --}}
                        @if ($current_user->hasAnyAccess(['proposals.edit', 'users.superadmin']) && $status == 'Pending' && $proposals->is_amendment == 0)
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                href="{{ route('proposals.edit', [encryptId($proposals->id)]) }}" aria-controls="edit">
                                <i class="fas fa-pencil-alt fa-1x"></i>
                                Edit
                            </a>
                        @endif
                        {{-- @if (
                            $current_user->hasAnyAccess(['proposals.delete', 'users.superadmin']) &&
                                $status == 'Pending' &&
                                !isset($proposals->cases_id) && $proposals->is_amendment == 0)
                            <a class="btn btn-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                href="{{ route('proposals.destroy', [encryptId($proposals->id)]) }}" aria-controls="delete"
                                data-redirect="{{ route('proposals.index') }}">
                                <i class="fas fa-trash-alt fa-1x"></i>
                                Delete
                            </a>
                        @endif --}}
                        @if ($current_user->hasAnyAccess('users.intermediary', 'users.superadmin'))
                            @if (!in_array($proposals->status,['Pending','Confirm','Terminated']))
                                  <a class="btn btn-sm btn-primary" data-toggle="modal"     data-original-title="intermendiary"
                                  data-target="#intermendiary-modal">{{__('proposals.indemnity_letter')}}</a>  
                            @endif
                        @endif
                        <a class="btn btn-sm btn-secondary" href="">Verify FD</a>
                        @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                            <a href="" class="btn btn-success btn-sm font-weight-bold show-info" data-toggle="modal"
                                data-target="#AddModelInfo" data-table="{{ $table_name }}" data-id="{{ $proposals->id }}"
                                data-url="{{ route('get-info') }}">
                                <span class="navi-icon">
                                    <i class="fas fa-info-circle fa-1x"></i>
                                </span>
                                <span class="navi-text">Info</span>
                            </a>
                        @endif
                    </div>

                    {{-- <div class="nav-item mt-7">
                        @if ($current_user->hasAnyAccess(['proposals.confirm', 'users.superadmin']) && $status == 'Pending')
                            <a class="btn btn-light-primary btn-sm font-weight-bold navi-link jsConfirmBtn"
                                data-current-status="{{ $status }}">
                                {{ __('proposals.confirm') }}
                            </a>
                        @endif
                        @if ($current_user->hasAnyAccess(['proposals.confirm', 'users.superadmin']) && $status == 'Reject')
                            <a class="btn btn-light-primary btn-sm font-weight-bold navi-link jsConfirmBtn"
                                data-current-status="{{ $status }}">
                                {{ __('proposals.re_evaluation') }}
                            </a>
                        @endif
                        @if (($superadmin || ($current_user->hasAnyAccess(['proposals.approve_tender_evaluation']) && $current_user->id == $underwriter_user_id)) && $status == 'Confirm')
                            <a class="btn btn-light-primary btn-sm font-weight-bold navi-link jsApproveBtn"
                                data-current-status="{{ $status }}">
                                {{ __('proposals.approve') }}
                            </a>
                        @endif
                        @if ($current_user->hasAnyAccess(['proposals.terms_sheet', 'users.superadmin']) && in_array($status, ['Confirm', 'Approve']) && $agreed_nbi <= 0)
                            <a href="{{ route('nbi.create', ['id' => $proposal_id]) }}"
                                class="btn btn-light-primary btn-sm font-weight-bold nbi_button" type="button"
                                title="">{{ __('proposals.terms_sheet') }}</a>
                        @endif
                        @if ($current_user->hasAnyAccess(['proposals.edit', 'users.superadmin']) && $status == 'Pending')
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                href="{{ route('proposals.edit', [$proposals->id]) }}" aria-controls="edit">
                                <i class="fas fa-pencil-alt fa-1x"></i>
                                Edit
                            </a>
                        @endif
                        @if ($current_user->hasAnyAccess(['proposals.delete', 'users.superadmin']) && $status == 'Pending')
                            <a class="btn btn-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                href="{{ route('proposals.destroy', [$proposals->id]) }}" aria-controls="delete"
                                data-redirect="{{ route('proposals.index') }}">
                                <i class="fas fa-trash-alt fa-1x"></i>
                                Delete
                            </a>
                        @endif
                        <a href="" class="btn btn-success btn-sm font-weight-bold show-info" data-toggle="modal"
                            data-target="#AddModelInfo" data-table="{{ $table_name }}" data-id="{{ $proposals->id }}"
                            data-url="{{ route('get-info') }}">
                            <span class="navi-icon">
                                <i class="fas fa-info-circle fa-1x"></i>
                            </span>
                            <span class="navi-text">Info</span>
                        </a>
                    </div> --}}
                </div>
                <div class="card-body pt-1">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="proposal-3" role="tabpanel" aria-labelledby="proposal-tab-3">
                            <div class="card-title font-weight-bolder text-dark row">
                                <div class="col-10">
                                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary" id="overviewTab" role="tablist">
                                        @if ($is_amend)
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link active" id="proposal-current-tab-3" data-toggle="tab"
                                                    href="#proposal-current-3">
                                                    <span class="nav-text">Current</span>
                                                </a>
                                            </li>
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link" id="proposal-tab-1" data-toggle="tab" href="#proposal-past-1"
                                                    aria-controls="past">
                                                    <span class="nav-text">Past</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="text-right col-2 mt-5">
                                    <h5><strong>{{ isset($proposals) ? $proposals->code . '/V-' . $proposals->version : '' }}</strong></h5>
                                </div>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="proposal-current-3" role="tabpanel"
                                    aria-labelledby="proposal-current-tab-3">
                                    <div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle"
                                        id="accordionExample7">
        
                                        {{-- /////////////// Contractor Details ////////////// --}}
        
                                        <div class="card">
                                            <div class="card-header" id="headingOne7">
                                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne7"
                                                    aria-expanded="false">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                            viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.contractor_details') }}</div>
                                                </div>
                                            </div>
                                            <div id="collapseOne7" class="collapse show" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width:100%; border-collapse: collapse;">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.parent_group') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->parent_group ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.registration_no') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->registration_no ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.company_name') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_company_name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.register_address') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->register_address ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.website') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_website ?? '-' }}
                                                            </td>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.country') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->country->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.state') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->state->name ?? '-' }}
                                                            </td>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.city') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_city ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.pincode') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_pincode ?? '-' }}
                                                            </td>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.email') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_email ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        @if(isset($proposals->country->name) && strtolower($proposals->country->name) == 'india')
                                                            <tr>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.pan_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->contractor_pan_no ?? '-' }}
                                                                </td>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.gst_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->contractor_gst_no ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.date_of_incorporation') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->date_of_incorporation, 'd/m/Y') ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.principle_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->principleType->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.entity_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->typeOfEntity->name ?? '-' }}
                                                            </td>

                                                            {{-- <td class="width_15em text-light-grey">
                                                                {{ __('proposals.inception_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ isset($proposals->contractor_inception_date) ? custom_date_format($proposals->contractor_inception_date, 'd/m/Y') : '-' }}
                                                            </td> --}}
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.staff_strength') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_staff_strength ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.phone_no') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_mobile ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr style="border-bottom: 1px solid;"></tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong style="border-bottom: 1px solid;">Address for Bond</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.address') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_bond_address ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.country') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->additionalContractorCountry->name ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.state') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->additionalContractorState->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.city') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_bond_city ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.pincode') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->contractor_bond_pincode ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        @if(isset($proposals->additionalContractorCountry->name) && strtolower($proposals->additionalContractorCountry->name) == 'india')
                                                            <tr>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.gst_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->contractor_bond_gst_no ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        @endif
                                                        <tr style="border-bottom: 1px solid;">
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <div class="row mt-5">
                                                        <div class="col-3 text-light-grey">{{ __('proposals.contractor_type') }}</div>
                                                        <div class="col-3">{{ $proposals->contract_type ?? ''}}</div>
                                                    </div>
                                                    <div class="mt-5">
                                                        @if ($proposals->contract_type != 'Stand Alone')
                                                            <table class="table table-bordered table-responsive1" style="width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('common.no') }}</th>
                                                                        <th>
                                                                            {{ __('proposals.contractor_type') }}
                                                                        </th>
                                                                        <th>
                                                                            {{ __('proposals.contractor_id') }}
                                                                        </th>
                                                                        <th>
                                                                            {{ __('proposals.contractor') }}
                                                                        </th>
                                                                        <th>
                                                                            {{ __('common.pan_no') }}</th>
                                                                        {{-- <th class="p-2">
                                                                            {{ __('proposals.oc') }}</th>
                                                                        <th class="p-2">
                                                                            {{ __('proposals.spare_capacity') }}</th> --}}
                                                                        <th>
                                                                            {{ __('proposals.share_holding') }}</th>
                                                                        {{-- <th class="p-2">
                                                                            {{ $proposals->contract_type == 'JV' ? __('proposals.jv_exposure') : __('proposals.spv_exposure') }}
                                                                        </th>
                                                                        <th class="p-2">
                                                                            {{ __('proposals.assign_exposure') }}
                                                                        </th>
                                                                        <th class="p-2">
                                                                            {{ __('proposals.consumed') }}</th>
                                                                        <th class="p-2">
                                                                            {{ __('proposals.remaining_cap') }}
                                                                        </th> --}}
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($proposals->proposalContractors->count())
                                                                        @foreach ($proposals->proposalContractors as $key => $row)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $key + 1 ?? '' }}</td>
                                                                                <td>
                                                                                    {{ $row->contractor->venture_type ?? '' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $row->contractor->code ?? '' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $row->contractor->company_name ?? '' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $row->pan_no ?? '' }}</td>
                                                                                {{-- <td class="p-2">
                                                                                    {{ $row->overall_cap ?? '' }}</td>
                                                                                <td class="p-2">
                                                                                    {{ $row->spare_capacity ?? '' }}
                                                                                </td> --}}
                                                                                <td>
                                                                                    {{ $row->share_holding ?? '' }}
                                                                                </td>
                                                                                {{-- <td class="p-2">
                                                                                    {{ $row->jv_spv_exposure ?? '' }}
                                                                                </td>
                                                                                <td class="p-2">
                                                                                    {{ $row->assign_exposure ?? '' }}
                                                                                </td>
                                                                                <td class="p-2">
                                                                                    {{ $row->consumed ?? '' }}</td>
                                                                                <td class="p-2">
                                                                                    {{ $row->remaining_cap ?? '' }}
                                                                                </td> --}}
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td colspan="10">
                                                                                {{ __('common.no_records_found') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td class="width_15em text-light-grey">
                                                                        {{ __('proposals.contractor_type') }}
                                                                    </td>
                                                                    <td class="width_15em text-black">
                                                                        {{ $proposals->contract_type ?? '-' }}
                                                                    </td>
        
                                                                    <td class="width_15em text-light-grey">
                                                                        {{ __('proposals.full_name_contractor') }}
                                                                    </td>
                                                                    <td class="width_15em text-black">
                                                                        {{ $proposals->contractor->company_name ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="width_15em text-light-grey">
                                                                        {{ __('common.pan_no') }}
                                                                    </td>
                                                                    <td class="width_15em text-black">
                                                                        {{ $proposals->pan_no ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        @endif
                                                    </div>
                                                    <div class="my-5" style="border-bottom: 1px solid;"></div>

                                                    {{-- @if ($proposals->is_jv == 'Yes')
                                                        <div class="mt-5">
                                                            <table class="table table-bordered table-responsive1"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('common.no') }}</th>
                                                                        <th>{{ __('principle.cin_number') }}</th>
                                                                        <th>{{ __('principle.contractor_name') }}</th>
                                                                        <th>{{ __('principle.pan_no') }}</th>
                                                                        <th>{{ __('principle.share_holding') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (!empty($proposals->contractorItem) && $proposals->contractorItem->count() > 0)
                                                                        @foreach ($proposals->contractorItem as $key => $row)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $row->contractor->code ?? '-' }}</td>
                                                                                <td>{{ $row->contractor->company_name ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $row->pan_no ?? '-' }}</td>
                                                                                <td>{{ $row->share_holding ?? '-' }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td class="text-center" colspan="5">No data
                                                                                available
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif --}}

                                                    <div class="mt-5">
                                                        <table class="table table-bordered table-responsive1" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="p-2">{{ __('common.no') }}</th>
                                                                    <th class="p-2 w-40">
                                                                        {{ __('proposals.trade_sector') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.from') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.till') }}</th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.main') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($proposals->tradeSector->count())
                                                                    @foreach ($proposals->tradeSector as $key => $row)
                                                                        {{-- @dd($row) --}}
                                                                        <tr>
                                                                            <td class="p-2">
                                                                                {{ $key + 1 ?? '' }}</td>
                                                                            <td class="p-2">
                                                                                {{ $row->tradeSector->name ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ custom_date_format($row->from, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ custom_date_format($row->till, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ $row->is_main ?? '' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr class="text-center">
                                                                        <td colspan="10">
                                                                            {{ __('common.no_records_found') }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="my-5">
                                                        <table class="table table-bordered table-responsive1" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="p-2">{{ __('common.no') }}</th>
                                                                    <th class="p-2 w-40">
                                                                        {{ __('proposals.contact_person') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('common.email') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('common.phone_no') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($proposals->contactDetail->count())
                                                                    @foreach ($proposals->contactDetail as $key => $row)
                                                                        {{-- @dd($row) --}}
                                                                        <tr>
                                                                            <td class="p-2">
                                                                                {{ $key + 1 ?? '' }}</td>
                                                                            <td class="p-2">
                                                                                {{ $row->contact_person ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ $row->email ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ $row->phone_no ?? '-' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr class="text-center">
                                                                        <td colspan="10">
                                                                            {{ __('common.no_records_found') }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="my-5" style="border-bottom: 1px solid;"></div>

                                                    {{-- <div class="my-5">
                                                        <span class="width_15em text-light-grey">
                                                            {{ __('proposals.rating_date') }} : 
                                                        </span>
                                                        <span class="width_15em text-black">{{ isset($proposals->rating_date) ? custom_date_format($proposals->rating_date, 'd/m/Y') : '-' }}</span>
                                                    </div> --}}

                                                    <div class="mb-5">
                                                        <table class="table table-bordered table-responsive1" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ __('common.no') }}</th>
                                                                    <th>{{ __('principle.agency_name')}}</th>
                                                                    <th>{{ __('principle.rating')}}</th>
                                                                    <th>{{ __('principle.remarks')}}</th>
                                                                    <th>{{ __('proposals.rating_date')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (!empty($proposals->agencyRatingDetails) && $proposals->agencyRatingDetails->count() > 0)
                                                                    @foreach ($proposals->agencyRatingDetails as $key => $row)
                                                                    {{-- @dd($row) --}}
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>{{ $row->agencyName->agency_name ?? '' }}</td>
                                                                            <td>{{ $row->rating ?? ''  }}</td>
                                                                            <td style="width: 40%;">{{ $row->remarks ?? ''  }}</td>
                                                                            <td>{{ isset($row->rating_date) ? custom_date_format($row->rating_date, 'd/m/Y') : '-' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td class="text-center" colspan="5">No data available</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="my-5" style="border-bottom: 1px solid;"></div>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.company_details') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#company_details_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="company_details_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Company Details Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['company_details']) && count($dms_data['company_details']) > 0)
                                                                                        @foreach ($dms_data['company_details'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.company_technical_details') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#company_technical_details_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="company_technical_details_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Company Technical Details Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['company_technical_details']) && count($dms_data['company_technical_details']) > 0)
                                                                                        @foreach ($dms_data['company_technical_details'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.company_presentation') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#company_presentation_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="company_presentation_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Company Presentation Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['company_presentation']) && count($dms_data['company_presentation']) > 0)
                                                                                        @foreach ($dms_data['company_presentation'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.are_you_blacklisted') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->are_you_blacklisted ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.certificate_of_incorporation') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#certificate_of_incorporation_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="certificate_of_incorporation_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Certificate of Incorporation Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['certificate_of_incorporation']) && count($dms_data['certificate_of_incorporation']) > 0)
                                                                                        @foreach ($dms_data['certificate_of_incorporation'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.memorandum_and_articles') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#memorandum_and_articles_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="memorandum_and_articles_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Memorandum and Articles Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['memorandum_and_articles']) && count($dms_data['memorandum_and_articles']) > 0)
                                                                                        @foreach ($dms_data['memorandum_and_articles'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.gst_certificate') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#gst_certificate_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="gst_certificate_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">GST Certificate Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['gst_certificate']) && count($dms_data['gst_certificate']) > 0)
                                                                                        @foreach ($dms_data['gst_certificate'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.company_pan_no') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#company_pan_no_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="company_pan_no_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Company Pan No. Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['company_pan_no']) && count($dms_data['company_pan_no']) > 0)
                                                                                        @foreach ($dms_data['company_pan_no'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.last_three_years_itr') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#last_three_years_itr_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="last_three_years_itr_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Last Three Years Itr Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['last_three_years_itr']) && count($dms_data['last_three_years_itr']) > 0)
                                                                                        @foreach ($dms_data['last_three_years_itr'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- /////////////////// Banking limits ///////////////// --}}

                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingSix7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseSix7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.proposal_banking_limits') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseSix7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <div class="table-responsive">
                                                        <table class="table" style="width:100%;">
        
                                                            <div class="container">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.banking_category_label') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.facility_types_label') }}
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.sanctioned_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.bank_name') }}
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.latest_limit_utilized') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.unutilized_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.commission_on_pg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.commission_on_fg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey text-right">
                                                                            {{ __('proposals.margin_collateral') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.other_banking_details') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.proposal_banking_limits_attachment') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                @if(isset($proposals->bankingLimits) && $proposals->bankingLimits->count() > 0)
                                                                    @foreach ($proposals->bankingLimits->sortDesc() as $item)
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="width_10em text-black">
                                                                                    {{ $item->getBankingLimitCategoryName->name ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black">
                                                                                    {{ $item->getFacilityTypeName->name ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->sanctioned_amount, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black">
                                                                                    {{ $item->bank_name ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->latest_limit_utilized, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->unutilized_limit, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->commission_on_pg, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->commission_on_fg, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black text-right">
                                                                                    {{ numberFormatPrecision($item->margin_collateral, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_35em text-black">
                                                                                    {{ $item->other_banking_details ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em">
                                                                                    <!-- Button trigger modal-->
                                                                                    <a type="button" data-toggle="modal"
                                                                                        data-target="#bankingLimit_attachment_modal_{{ $loop->iteration }}">
                                                                                        <i class="fas fa-file"></i>
                                                                                    </a>
                                                                                    <!-- Modal-->
                                                                                    <div class="modal fade"
                                                                                        id="bankingLimit_attachment_modal_{{ $loop->iteration }}"
                                                                                        tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                                        aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                                                                    </h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                                                        aria-label="Close">
                                                                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div data-scroll="true" data-height="100">
                                                                                                        @foreach ($item->dMS as $document)
                                                                                                            <div class="row">
                                                                                                                <div class="col">
                                                                                                                    {{ $loop->iteration }}.
                                                                                                                    {{ $document->file_name }}
                                                                                                                </div>
                                                                                                                <div class="col-sm-2">
                                                                                                                    <a target="_blank"
                                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                        <div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                {{-- <td class="text-black">
                                                                                    @if (isset($item->dMS))
                                                                                        @foreach ($item->dMS as $file)
                                                                                            <ul>
                                                                                                <li>
                                                                                                    <a href="{{ isset($file->attachment) && !empty($file->attachment) ? asset($file->attachment) : asset('/default.jpg') }}"
                                                                                                        target="_blanck"
                                                                                                        title="{{ $file->file_name }}"
                                                                                                        download>
                                                                                                        <i
                                                                                                            class="fa fa-download text-black"></i>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img src="{{ asset('/default.jpg') }}" alt="default" height="35" width="25">
                                                                                    @endif
                                                                                </td> --}}
                                                                            </tr>
                                                                        </tbody>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ///////////////// Last 5 years track record /////////////// --}}
        
                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingEight7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseEight7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">
                                                        {{ __('proposals.project_track_records') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseEight7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_name') }}
                                                                    </th>
                                                                    <th class="text-light-grey text-right">
                                                                        {{ __('proposals.project_cost') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_description') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_tenor') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_start_date') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_end_date') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.actual_date_completion') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.bank_guarantees_details') }}
                                                                    </th>
                                                                    <th class="text-light-grey text-right">
                                                                        {{ __('proposals.bg_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('principle.project_track_records_attachment') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
        
                                                            <tbody>
                                                                @if(isset($proposals->projectTrackRecords) && $proposals->projectTrackRecords->count() > 0)
                                                                    @foreach ($proposals->projectTrackRecords->sortDesc() as $item)
                                                                        <tr>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->project_name ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black text-right">
                                                                                {{ numberFormatPrecision($item->project_cost, 0) ?? '-' }}
                                                                            </td>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->project_description ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ $item->project_tenor ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ custom_date_format($item->project_start_date, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ custom_date_format($item->project_end_date, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ custom_date_format($item->actual_date_completion, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->bank_guarantees_details ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black text-right">
                                                                                {{ numberFormatPrecision($item->bg_amount, 0) ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em">
                                                                                <!-- Button trigger modal-->
                                                                                <a type="button" data-toggle="modal"
                                                                                    data-target="#project_track_records_attachment_modal_{{ $loop->iteration }}">
                                                                                    <i class="fas fa-file"></i>
                                                                                </a>
                                                                                <!-- Modal-->
                                                                                <div class="modal fade"
                                                                                    id="project_track_records_attachment_modal_{{ $loop->iteration }}"
                                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                                                                </h5>
                                                                                                <button type="button" class="close"
                                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div data-scroll="true" data-height="100">
                                                                                                    @foreach ($item->dMS as $document)
                                                                                                        <div class="row">
                                                                                                            <div class="col">
                                                                                                                {{ $loop->iteration }}.
                                                                                                                {{ $document->file_name }}
                                                                                                            </div>
                                                                                                            <div class="col-sm-2">
                                                                                                                <a target="_blank"
                                                                                                                    href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                                        class="fa fa-download text-black"></i></a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- /////////////////// Order Book and Future Project ///////////////// --}}
        
                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingSeven7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseSeven7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">
                                                        {{ __('proposals.order_book_and_future_projects') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseSeven7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12 container">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_name') }}
                                                                    </th>
                                                                    <th class="text-light-grey text-right">
                                                                        {{ __('proposals.project_cost') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_description') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_start_date') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_end_date') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.project_tenor') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.bank_guarantees_details') }}
                                                                    </th>
                                                                    <th class="text-light-grey text-right">
                                                                        {{ __('proposals.project_share') }}
                                                                    </th>
                                                                    <th class="text-light-grey text-right">
                                                                        {{ __('proposals.guarantee_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('proposals.current_status') }}
                                                                    </th>
                                                                    <th class="text-light-grey">
                                                                        {{ __('principle.order_book_and_future_projects_attachment') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            @if(isset($proposals->orderBookAndFutureProjects) && $proposals->orderBookAndFutureProjects->count() > 0)
                                                                @foreach ($proposals->orderBookAndFutureProjects->sortDesc() as $item)
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->project_name ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black text-right">
                                                                                {{ $item->project_cost ?? '-' }}
                                                                            </td>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->project_description ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ custom_date_format($item->project_start_date, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ custom_date_format($item->project_end_date, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ $item->project_tenor ?? '-' }}
                                                                            </td>
                                                                            <td class="width_35em text-black">
                                                                                {{ $item->bank_guarantees_details ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black text-right">
                                                                                {{ numberFormatPrecision($item->project_share, 0) ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black text-right">
                                                                                {{ numberFormatPrecision($item->guarantee_amount, 0) ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ $item->current_status ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em">
                                                                                <!-- Button trigger modal-->
                                                                                <a type="button" data-toggle="modal"
                                                                                    data-target="#order_book_and_future_projects_attachment_modal_{{ $loop->iteration }}">
                                                                                    <i class="fas fa-file"></i>
                                                                                </a>
                                                                                <!-- Modal-->
                                                                                <div class="modal fade"
                                                                                    id="order_book_and_future_projects_attachment_modal_{{ $loop->iteration }}"
                                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                                                                </h5>
                                                                                                <button type="button" class="close"
                                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div data-scroll="true" data-height="100">
                                                                                                    @foreach ($item->dMS as $document)
                                                                                                        <div class="row">
                                                                                                            <div class="col">
                                                                                                                {{ $loop->iteration }}.
                                                                                                                {{ $document->file_name }}
                                                                                                            </div>
                                                                                                            <div class="col-sm-2">
                                                                                                                <a target="_blank"
                                                                                                                    href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                                        class="fa fa-download text-black"></i></a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                @endforeach
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        {{-- //////////////// Management Profile ////////////// --}}
        
                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingNine7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseNine7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">
                                                        {{ __('proposals.management_profiles') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseNine7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <div class="table-responsive">
                                                        <table class="table" style="width:100%;">
                                                            <div class="container">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.designation') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.name') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.qualifications') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.experience') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('principle.management_profiles_attachment') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                @if(isset($proposals->managementProfiles) && $proposals->managementProfiles->count() > 0)
                                                                    @foreach ($proposals->managementProfiles->sortDesc() as $item)
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-black">
                                                                                    {{ $item->getDesignationName->name ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black">
                                                                                    {{ $item->name ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black">
                                                                                    {{ $item->qualifications ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em text-black">
                                                                                    {{ numberFormatPrecision($item->experience, 0) ?? '-' }}
                                                                                </td>
                                                                                <td class="width_10em">
                                                                                    <!-- Button trigger modal-->
                                                                                    <a type="button" data-toggle="modal"
                                                                                        data-target="#management_profiles_attachment_modal_{{ $loop->iteration }}">
                                                                                        <i class="fas fa-file"></i>
                                                                                    </a>
                                                                                    <!-- Modal-->
                                                                                    <div class="modal fade"
                                                                                        id="management_profiles_attachment_modal_{{ $loop->iteration }}"
                                                                                        tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                                        aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                                                                    </h5>
                                                                                                    <button type="button" class="close"
                                                                                                        data-dismiss="modal" aria-label="Close">
                                                                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div data-scroll="true" data-height="100">
                                                                                                        @foreach ($item->dMS as $document)
                                                                                                            <div class="row">
                                                                                                                <div class="col">
                                                                                                                    {{ $loop->iteration }}.
                                                                                                                    {{ $document->file_name }}
                                                                                                                </div>
                                                                                                                <div class="col-sm-2">
                                                                                                                    <a target="_blank"
                                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                        <div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- //////////////// Additional Details for Assessment //////////////// --}}
        
                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingFive7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseFive7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">
                                                        {{ __('proposals.additional_details_for_assessment') }}</div>
                                                </div>
                                            </div>
                                            <div id="collapseFive7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width: 100%">
                                                        <tr>
                                                            @if ($proposals->is_bank_guarantee_provided == 'Yes')
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('proposals.circumstance_short_notes') }}
                                                                </td>
                                                                <td class="text-black">
                                                                    {{ $proposals->circumstance_short_notes ?? '-' }}
                                                                </td>
                                                            @else
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('proposals.is_bank_guarantee_provided') }}
                                                                </td>
                                                                <td class="text-black">
                                                                    {{ $proposals->is_bank_guarantee_provided ?? '-' }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            @if ($proposals->is_action_against_proposer == 'Yes')
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('proposals.action_details') }}
                                                                </td>
                                                                <td class="text-black">
                                                                    {{ $proposals->action_details ?? '-' }}
                                                                </td>
                                                            @else
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('proposals.is_action_against_proposer') }}
                                                                </td>
                                                                <td class="text-black">
                                                                    {{ $proposals->is_action_against_proposer ?? '-' }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.contractor_failed_project_details') }}
                                                            </td>
                                                            <td class="text-black">
                                                                {{ $proposals->contractor_failed_project_details ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.completed_rectification_details') }}
                                                            </td>
                                                            <td class="text-black">
                                                                {{ $proposals->completed_rectification_details ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.performance_security_details') }}
                                                            </td>
                                                            <td class="text-black">
                                                                {{ $proposals->performance_security_details ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.relevant_other_information') }}
                                                            </td>
                                                            <td class="text-black">
                                                                {{ $proposals->relevant_other_information ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- /////////// Beneficiary Details /////////////// --}}
        
                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingThree7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseThree7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.beneficiary_details') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseThree7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.registration_no') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_registration_no ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.beneficiary') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary->company_name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.company_name') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_company_name ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.email') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_email ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.phone_no') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_phone_no ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.address') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_address ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.website') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_website ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.country') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->benificiaryCountry->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.state') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->benificiaryState->name ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.city') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_city ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.pincode') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_pincode ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        @if(isset($proposals->benificiaryCountry->name) && strtolower($proposals->benificiaryCountry->name) == 'india')
                                                            <tr>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.gst_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->beneficiary_gst_no ?? '-' }}
                                                                </td>
            
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.pan_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->beneficiary_pan_no ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        @endif
                                                        <tr style="border-bottom: 1px solid;">
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong style="border-bottom: 1px solid;">Address for Bond</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.address') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_bond_address ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.country') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->additionalBeneficiaryCountry->name ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.state') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->additionalBeneficiaryState->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.city') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_bond_city ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('common.pincode') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_bond_pincode ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        @if(isset($proposals->additionalBeneficiaryCountry->name) && strtolower($proposals->additionalBeneficiaryCountry->name) == 'india')
                                                            <tr>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('common.gst_no') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->beneficiary_bond_gst_no ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        @endif
                                                        <tr style="border-bottom: 1px solid;">
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.beneficiary_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary_type ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.establishment_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->establishmentType->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        @if ($proposals->beneficiary_type == 'Government')
                                                            <tr>
                                                                <td class="width_15em text-light-grey">
                                                                    {{ __('proposals.ministry_type') }}
                                                                </td>
                                                                <td class="width_15em text-black">
                                                                    {{ $proposals->ministryType->name ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        @endif
                                                    </table>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.bond_wording') }}
                                                                </div>
                                                            </td>
                                                            <td class="width_15em text-black" width="75%">
                                                                {{ $proposals->beneficiary_bond_wording ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_10em text-light-grey">
                                                                {{ __('proposals.bond_attachment') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#bond_attachment_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="bond_attachment_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Bond Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['bond_attachment']) && count($dms_data['bond_attachment']) > 0)
                                                                                        @foreach ($dms_data['bond_attachment'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
        
                                                    <div class="mt-5">
                                                        <table class="table table-bordered table-responsive1" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="p-2">{{ __('common.no') }}</th>
                                                                    <th class="p-2 w-40">
                                                                        {{ __('proposals.trade_sector') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.from') }}
                                                                    </th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.till') }}</th>
                                                                    <th class="p-2 w-20">
                                                                        {{ __('proposals.main') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($proposals->proposalBeneficiaryTradeSector->count())
                                                                    @foreach ($proposals->proposalBeneficiaryTradeSector as $key => $row)
                                                                        {{-- @dd($row) --}}
                                                                        <tr>
                                                                            <td class="p-2">
                                                                                {{ $key + 1 ?? '' }}</td>
                                                                            <td class="p-2">
                                                                                {{ $row->tradeSector->name ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ custom_date_format($row->from, 'd/m/Y') ?? '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ isset($row->till) ? custom_date_format($row->till, 'd/m/Y') : '-' }}
                                                                            </td>
                                                                            <td class="p-2">
                                                                                {{ $row->is_main ?? '' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr class="text-center">
                                                                        <td colspan="10">
                                                                            {{ __('common.no_records_found') }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ///////////////// Project Details /////////////// --}}

                                        <div class="card">
                                            <div class="card-header" id="headingTen7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseTen7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.project_details') }}</div>
                                                </div>
                                            </div>
                                            <div id="collapseTen7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_details') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->projectDetails->code ?? '-' }} |
                                                                {{ $proposals->projectDetails->project_name ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.beneficiary') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->projectDetailsBeneficiary->company_name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_name') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->pd_project_name ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_value') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->pd_project_value ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_description') }}
                                                            </td>
                                                            <td class="width_15em text-black" colspan="3">
                                                                {{ $proposals->pd_project_description ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.type_of_project') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->projectDetailsProjectType->name ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_start_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->pd_project_start_date, 'd/m/Y') ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_end_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->pd_project_end_date, 'd/m/Y') ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.period_of_project') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->pd_period_of_project ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
        
                                        {{-- ///////////// Tender Details /////////////// --}}
                                        <div class="card">
                                            <div class="card-header" id="headingTwo7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseTwo7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.tender_details') }}</div>
                                                </div>
                                            </div>
                                            <div id="collapseTwo7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width:100%">
                                                        <tr>
                                                            {{-- @dd($proposals->tender) --}}
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.tender') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->tender->code ?? '' }} |
                                                                {{ $proposals->tender->tender_id ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.tender_id') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->tender_id ?? '-' }}
                                                            </td>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.tender_header') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->tender_header ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.tender_description') }}
                                                                </div>
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->tender_description ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('tender.location') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->location ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.type_of_project') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->projectType->name ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.beneficiary') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->beneficiary->company_name ?? '-' }}
                                                            </td>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.contract_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ numberFormatPrecision($proposals->tender_contract_value, 0) ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.period_of_contract') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->period_of_contract ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ numberFormatPrecision($proposals->tender_bond_value, 0) ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->getBondTypeName->name ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.type_of_contracting') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->type_of_contracting ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.rfp_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->rfp_date, 'd/m/Y') ?? '-' }}
                                                            </td>

                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.rfp_attachment') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#rfp_attachment_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="rfp_attachment_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">RFP Attachment
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['rfp_attachment']) && count($dms_data['rfp_attachment']) > 0)
                                                                                        @foreach ($dms_data['rfp_attachment'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width:100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.project_description') }}
                                                                </div>
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->project_description ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- //////////////// Additional Bonds ////////////// --}}

                                        {{-- <div class="card">
                                            <div class="card-header" id="headingNine7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseNine7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">
                                                        {{ __('proposals.additional_bonds') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapseNine7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <div class="table-responsive">
                                                        <table class="table" style="width:100%;">
                                                            <div class="container">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-light-grey">
                                                                            {{ __('common.no') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.additional_bond') }}
                                                                        </th>
                                                                        <th class="text-light-grey">
                                                                            {{ __('proposals.bond_value') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                @foreach ($proposals->additionalBonds as $item)
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-black">{{ $loop->index + 1 }}
                                                                            <td class="text-black">
                                                                                {{ $item->getAdditionalBondName->name ?? '-' }}
                                                                            </td>
                                                                            <td class="width_10em text-black">
                                                                                {{ numberFormatPrecision($item->bond_value, 0) ?? '-' }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                @endforeach
                                                            </div>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- //////////////// Bond Details //////////////// --}}

                                        <div class="card {{ $proposals->is_manual_entry == 'No' ? 'd-none' : '' }}">
                                            <div class="card-header" id="headingFour7">
                                                <div class="card-title collapsed" data-toggle="collapse"
                                                    data-target="#collapseFour7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path
                                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                    fill="#000000" fill-rule="nonzero"></path>
                                                                <path
                                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="card-label pl-4">{{ __('proposals.bond_details') }}</div>
                                                </div>
                                            </div>
                                            <div id="collapseFour7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_type') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->getBondType->name ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_start_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->bond_start_date, 'd/m/Y') ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_end_date') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ custom_date_format($proposals->bond_end_date, 'd/m/Y') ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_period') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->bond_period ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.project_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ numberFormatPrecision($proposals->project_value, 0) ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.contract_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ numberFormatPrecision($proposals->contract_value, 0) ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ numberFormatPrecision($proposals->bond_value, 0) ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
        
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_triggers') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->bond_triggers ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bid_requirement') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->bid_requirement ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.main_obligation') }}
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->main_obligation ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.relevant_conditions') }}
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->relevant_conditions ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_period_description_label') }}
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->bond_period_description ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.bond_required_label') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                {{ $proposals->bond_required ?? '-' }}
                                                            </td>
        
                                                            <td class="width_15em text-light-grey">
                                                                {{ __('proposals.attach_copy_label') }}
                                                            </td>
                                                            <td class="width_15em text-black">
                                                                <a type="button" data-toggle="modal"
                                                                    data-target="#bond_wording_file_modal">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <div class="modal fade"
                                                                    id="bond_wording_file_modal"
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Bond Wording File
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="100">
                                                                                    @if (isset($dms_data['bond_wording_file']) && count($dms_data['bond_wording_file']) > 0)
                                                                                        @foreach ($dms_data['bond_wording_file'] as $document)
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    {{ $loop->iteration }}.
                                                                                                    {{ $document->file_name }}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <a target="_blank"
                                                                                                        href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                                                            class="fa fa-download text-black"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.bond_wording') }}
                                                                </div>
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->bond_wording ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.collateral_label') }}
                                                                </div>
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->bond_collateral ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="width_15em text-light-grey position-absolute">
                                                                <div class="position-relative">
                                                                    {{ __('proposals.joint_venture_description') }}
                                                                </div>
                                                            </td>
                                                            <td class="text-black" width="75%">
                                                                {{ $proposals->distribution ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="tab-pane fade" id="proposal-past-1" role="tabpanel" aria-labelledby="proposal-past-tab-1">
                                    @include('proposals.proposal_past')
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="tender-evaluation" role="tabpanel"
                            aria-labelledby="tender-evaluation-tab">
                            @include('proposals.tab.tender-evaluation')
                        </div> --}}
                        <div class="tab-pane fade" id="nbi" role="tabpanel" aria-labelledby="nbi-tab">
                            @include('proposals.tab.nbi')
                        </div>

                        <div class="tab-pane fade" id="issue_bond_checklist" role="tabpanel" aria-labelledby="bond-policy-issue-checklist-tab">
                            @include('proposals.tab.bond_policy_issue_checklist')
                        </div>

                        <div class="tab-pane fade" id="issue_bond" role="tabpanel" aria-labelledby="bond-policy-issue-tab">
                            @include('proposals.tab.bond_policy_issue')
                        </div>

                        <div class="tab-pane fade" id="invocation_notification" role="tabpanel" aria-labelledby="invocation-notification-tab">
                            @include('proposals.tab.invocation_notification')
                        </div>

                        <div class="tab-pane fade" id="invocation_claim" role="tabpanel" aria-labelledby="invocation-claim-tab">
                            @include('proposals.tab.invocation_claim')
                        </div>

                        <div class="tab-pane fade" id="bond_foreclosure" role="tabpanel" aria-labelledby="bond-foreclosure-tab">
                            @include('proposals.tab.bond_foreclosure')
                        </div>

                        <div class="tab-pane fade" id="bond_cancellation" role="tabpanel" aria-labelledby="bond-cancellation-tab">
                            @include('proposals.tab.bond_cancellation')
                        </div>

                        <div class="tab-pane fade" id="bond_progress" role="tabpanel" aria-labelledby="bond-progress-tab">
                            @include('bond_progress.show')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal">
    </div>

    <div class="modal fade" tabindex="-1" id="rejectedReasonTenderEvaluation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('rejection_reason.rejection_reason') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="rejectionReason">
                        <h6>{!! __('rejection_reason.reason') !!}</h6>
                        <span class="reason">
                        </span>
                        <hr>
                        <h6>{!! __('rejection_reason.description') !!}</h6>
                        <span class="description">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="rejectedReasonProposal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('rejection_reason.rejection_reason') }}</h5>
                </div>

                <div class="modal-body">
                    @if (isset($rejectionReasonData))
                        <h6>{!! __('rejection_reason.reason') !!}</h6>
                        <span>
                            {{ $rejection_reason }}
                        </span>
                        <hr>
                        <h6>{!! __('rejection_reason.description') !!}</h6>
                        <span>
                            {{ $rejectionReasonData->remarks }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('info')
    @include('proposals.modal.intermediary')
@endsection
@section('scripts')
    {{-- @include('proposals.scripts.script') --}}
    @include('proposals.show-script')
    @include('proposals.tab.nbi-script')
    @include('proposals.tab.bond-management-script')
@endsection
