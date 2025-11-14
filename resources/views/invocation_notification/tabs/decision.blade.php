@if ($invocationData->status === 'Pending')
    <div class="card-toolbar ml-40 pl-40 text-right">
        @if ($current_user->id === $invocationData->claimExaminerUserId)
            <button type="button" class="btn btn-success btn-sm font-weight-bold" data-toggle="modal" data-target="#payoutModal"
                {{blank($invocationData->claim_examiner_id) ? 'disabled' : ''  }}>
                {{ __('invocation_notification.payout') }}
            </button>
        @endif
        @if ($current_user->id === $invocationData->claimExaminerUserId)
            <button class="btn btn-danger btn-sm font-weight-bold" data-toggle="modal" data-target="#cancellelationModal"
                {{blank($invocationData->claim_examiner_id) ? 'disabled' : ''  }}>
                {{ __('invocation_notification.invocation_cancellation') }}
            </button>
        @endif

    </div>
<hr>
@else
    <table style="width:100%">
        <tr>
            <td class="width_15em text-light-grey">{{__('invocation_claims.bond_value')}}</td>
            <td class=" width_15em text-black">{{numberExcelFormatPrecision($invocationData->invocation_amount, 0)}}</td>
            <td class="width_15em text-light-grey">{{__('invocation_claims.claimed_amount')}}</td>
            <td class=" width_15em text-black">{{numberExcelFormatPrecision($invocationData->claimed_amount, 0)}}</td>
        </tr>
        <tr>
            <td class="width_15em text-light-grey">{{__('invocation_notification.disallowed_amount')}}</td>
            <td class=" width_15em text-black">
                {{numberExcelFormatPrecision($invocationData->disallowed_amount, 0)}}
            </td>
            <td class="width_15em text-light-grey">{{__('invocation_notification.total_approved_bond_value')}}</td>
            <td class=" width_15em text-black">
                {{numberExcelFormatPrecision($invocationData->total_approved_bond_value, 0)}}
            </td>
        </tr>
        @if ($invocationData->status === 'Cancel')
            <tr>
                <td class="width_15em text-light-grey">{{__('invocation_notification.cancellelation_reason')}}</td>
                <td class=" width_15em text-black">
                    {{$invocationData->cancellelationReason->reason ?? ''}}
                </td>
            </tr>
        @elseif ($invocationData->status === 'Paid')
            <tr>
                <td class="width_15em text-light-grey">{{__('invocation_notification.payout_remark')}}</td>
                <td class=" width_15em text-black">
                    {{$invocationData->payout_remark ?? ''}}
                </td>
            </tr>
        @endif
    </table>
@endif