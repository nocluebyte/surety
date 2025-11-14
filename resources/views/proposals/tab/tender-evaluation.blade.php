<div class="pt-5 pr-15 pl-15">
    <table class="table table-separate table-head-custom table-checkable">
        <thead>
            <tr>
                <th>{{ __('common.no') }}</th>
            <th>{{ __('proposals.contractor_name')}}</th>
                <th>{{ __('proposals.tender_id') }}</th>
                <th>{{ __('proposals.beneficiary') }}</th>
            <th class="text-right">{{ __('proposals.project_value')}}</th>
            <th class="text-right">{{ __('proposals.bond_value')}}</th>
            <th class="text-center">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
    	@if($tenderEvaluations->count() > 0)
    		@foreach($tenderEvaluations as $k => $tenderEvaluation)
                    @php
                        $tender_code = $tenderEvaluation->tender->code ?? '';
                        $tender_id = $tenderEvaluation->tender->tender_id ?? '';
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $tenderEvaluation->contractor->company_name ?? '' }}</td>
                        <td>{{ $tenderEvaluation->tender_id }}</td>
                        <td>{{ $tenderEvaluation->beneficiary->company_name ?? '' }}</td>
    				<td class="text-right">{{ numberFormatPrecision($tenderEvaluation->project_value,0) }}</td>
    				<td class="text-right">{{ numberFormatPrecision($tenderEvaluation->bond_value,0) }}</td>
                        <td class="text-center">
                            @if (
                                $superadmin ||
                                    ($current_user->hasAnyAccess(['proposals.approve_tender_evaluation']) &&
                                        $current_user->id == $underwriter_user_id))
                                <a class="font-weight-bold pr-3"
                                    href="{{ route('tender-evaluation', ['proposal_id' => $proposals->id, 'id' => $tenderEvaluation->id]) }}"
                                    aria-controls="view" target="__blank">
                                    <i class="fas fa-eye fa-1x text-primary"></i>
                                </a>
                            @endif
							{{-- @dd($rejectionReasonData) --}}
                            {{-- @if (
                                ($superadmin ||
                                    ($current_user->hasAnyAccess(['proposals.approve_tender_evaluation']) &&
                                        $current_user->id == $underwriter_user_id)) &&
                                    $status == 'Confirm' &&
                                    $loop->first)
                                <a class="btn btn-light-primary btn-sm font-weight-bold navi-link jsTenderEvaluationBtn"
                                    data-current-status="{{ $status }}">
                                    {{ __('proposals.approve') }}
                                </a>
                            @endif
                            @if ($current_user->hasAnyAccess(['proposals.confirm', 'users.superadmin']) && $tenderEvaluation->status == 'Reject')
                                <a class="btn btn-light-danger btn-sm font-weight-bold navi-link"
                                    data-current-status="{{ $status }}" data-toggle="modal"
                                    data-target="#rejectedReasonTenderEvaluation" data-id="{{ $tenderEvaluation->id }}"
                                    class="call-modal navi-link">
                                    {{ __('proposals.rejected') }}
                                </a>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            @else
    	<tr><td colspan="7" class="text-center">{{ __('common.no_records_found') }}</td></tr>
            @endif
        </tbody>
    </table>
</div>