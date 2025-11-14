@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('bond_policies_issue.issued_bonds'),
        'back_action' => route('bond_policies_issue.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">

            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title font-weight-bolder text-dark">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            @if ($current_user->hasAnyAccess(['proposals.issue_bond', 'users.superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link active" id="bond-policy-issue-tab" data-toggle="tab" href="#issue_bond"
                                        aria-controls="profile">
                                        <span class="nav-text">{{ __('proposals.issue_bond') }}</span>
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
                        @if (
                                $proposals->is_checklist_approved == 1 &&
                                $proposals->is_nbi > 0 &&
                                $nbis->status == 'Approved' &&
                                $proposals->is_issue > 0 &&
                                $proposals->is_amendment == 0 &&
                                $proposals->is_invocation_notification == 0)
                            @if ($proposals->is_bond_foreclosure == 0 && $proposals->is_bond_cancellation == 0)
                                @if($current_user->hasAnyAccess('users.superadmin', 'proposals.edit'))
                                    <a class="btn btn-dark btn-sm font-weight-bold" id=""
                                        href="{{ route('proposals.edit', [encryptId($proposals->id), 'is_amendment' => encryptId('yes')]) }}"
                                        aria-controls="edit">
                                        {{ __('proposals.amendment') }}
                                    </a>
                                @endif

                                @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_fore_closure') || $current_user->hasAnyAccess('users.superadmin', 'proposals.bond_cancellation'))
                                    <span class="dropdown drop-down">
                                        <button class="btn btn-sm btn-light-dark dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Bond Management
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_cancellation'))
                                                <a class="dropdown-item font-weight-bold jsBondCancellationBtn" id="" data-redirect="{{route('createBondCancellation', ['back_action_id' => $bond_policy_issue->id,'type' => 'bond_policies_issue', 'proposal_id' => $bond_policy_issue->proposal_id])}}" data-table="bond_policies_issue" href="javascript:void(0);">
                                                    {{ __('proposals.bond_cancellation') }}
                                                </a>
                                            @endif

                                            @if($current_user->hasAnyAccess('users.superadmin', 'proposals.bond_fore_closure'))
                                                <a class="dropdown-item font-weight-bold jsForeClosureBtn" id="" data-redirect="{{route('createBondForeClosure', ['back_action_id' => $bond_policy_issue->id,'type' => 'bond_policies_issue', 'proposal_id' => $bond_policy_issue->proposal_id])}}" data-table="bond_policies_issue" href="javascript:void(0);">
                                                    {{ __('proposals.bond_foreclosure') }}
                                                </a>
                                            @endif
                                        </div>
                                    </span>
                                @endif

                                @if ($current_user->hasAnyAccess(['proposals.bond_progress', 'users.superadmin']))
                                    <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                        href="{{ route('bond-progress.create', ['id' => $proposals->id, 'type' => 'bond_policies_issue', 'back_action_id' => $bond_policy_issue->id]) }}">
                                        {{ __('common.bond_progress') }}
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body pl-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="issue_bond" role="tabpanel" aria-labelledby="bond-policy-issue-tab">
                            @if (isset($bond_policy_issue))
                                <div class="text-right">
                                    <a href="{{ route('issue-bond-pdf', encryptId($proposals->id)) }}" target="_blank" class="btn btn-bg-blue btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
                                        <i class="flaticon2-print icon-md"></i>
                                    </a>
                                    <span class="h4">{{ $bond_policy_issue->reference_no ?? '' }}</span>
                                </div>
                                <table style="width:100%">
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.insured_name') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->insured_name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.insured_address') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->insured_address ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_number') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->bond_number ?? '-' }}
                                            @if (
                                                $current_user->hasAnyAccess(['users.superadmin', 'bond_policies_issue.edit_bond_number']) &&
                                                    $proposals->is_bond_foreclosure == 0 &&
                                                    $proposals->is_bond_cancellation == 0 &&
                                                    $proposals->is_invocation_notification == 0)
                                                <i class="fas fa-edit cursor-pointer edit_bond_number" data-toggle="modal"
                                                    data-target="#bondNumberModal" data-table="bond_policies_issue"
                                                    title="Edit Bond Number & Stamp Paper"></i>
                                            @endif
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_stamp_paper') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            <a type="button" data-toggle="modal" data-target="#view_bond_stamp_paper_modal">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <div class="modal fade" id="view_bond_stamp_paper_modal" tabindex="-1" role="dialog"
                                                aria-labelledby="staticBackdrop" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Bond Stamp Paper
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div data-scroll="true" data-height="100">
                                                                @if (isset($bond_policy_issue_dms) &&
                                                                        isset($bond_policy_issue_dms['bond_stamp_paper']) &&
                                                                        count($bond_policy_issue_dms['bond_stamp_paper']) > 0)
                                                                    @foreach ($bond_policy_issue_dms['bond_stamp_paper'] as $document)
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                {{ $loop->iteration }}.
                                                                                {{ $document->file_name }}
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <a target="_blank"
                                                                                    href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}"
                                                                                    download><i
                                                                                        class="fa fa-download text-black"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img height="35px;" width="25px;"
                                                                        src="{{ asset('/default.jpg') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.project_details') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->project_details ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.beneficiary') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->beneficiary->company_name ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_type') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->bondType->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.beneficiary_address') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->beneficiary_address ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.beneficiary_phone_no') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->beneficiary_phone_no ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_conditionality') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->bond_conditionality ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.contract_value') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->contract_value, 0) ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.contract_currency') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->currency->short_name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr class="tr">
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_value') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->bond_value, 0) ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.cash_margin') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->cash_margin ?? '-' }} %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.tender_id') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->tender_id ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_period_start_date') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ custom_date_format($bond_policy_issue->bond_period_start_date, 'd/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_period_end_date') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ custom_date_format($bond_policy_issue->bond_period_end_date, 'd/m/Y') ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.bond_period') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->bond_period ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.rate') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->rate ?? '-' }} %
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.net_premium') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->net_premium, 0) ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.gst') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->gst ?? '-' }} %
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.gst_amount') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->gst_amount, 0) ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.gross_premium') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->gross_premium, 0) ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.stamp_duty_charges') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->stamp_duty_charges, 0) ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.total_premium') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->total_premium, 0) ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.intermediary_name') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->intermediary_name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.intermediary_code') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ $bond_policy_issue->intermediary_code ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.premium_date') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ custom_date_format($bond_policy_issue->premium_date, 'd/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.premium_amount') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->premium_amount, 0) ?? '-' }}
                                        </td>
        
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.additional_premium') }} {{ $currencySymbol }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black">
                                            {{ numberFormatPrecision($bond_policy_issue->additional_premium, 0) ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
        
                                    <tr>
                                        <td class="width_15em text-light-grey">
                                            {{ __('bond_policies_issue.special_condition') }}
                                        </td>
                                        <td>:</td>
                                        <td class="width_15em text-black" colspan="3">
                                            {{ $bond_policy_issue->special_condition ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            @else
                                <div class="text-center mt-5">
                                    <strong>{{ __('common.no_records_found') }}</strong>
                                </div>
                            @endif
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
    @include('info')
    @include('proposals.editBondNumber')

    @section('scripts')
        @include('proposals.tab.bond-management-script')
    @endsection
    <div id="load-modal"></div>
@endsection
