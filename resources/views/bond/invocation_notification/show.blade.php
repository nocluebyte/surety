@if (isset($invocationData))
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">

            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title font-weight-bolder text-dark"></div>
                    <div class="nav-item mt-7">
                        @if ($current_user->hasAnyAccess([$bond_permission, 'users.superadmin']) && $invocationData->is_claim_converted == 0)
                            <a class="btn btn-primary btn-sm font-weight-bold" id=""
                                href="{{ route('invocation-claims.create', ['id' => $invocationData->id]) }}">
                                {{ __('invocation_notification.convert_to_claim') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="card1">
                        <table style="width:100%">
                            <tr>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.bond_type') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->bondType->name ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.bond_no') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $bondData->code ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.invocation_date') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ custom_date_format($invocationData->invocation_date, 'd/m/Y') ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.amount') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ numberFormatPrecision($invocationData->invocation_amount, 0) ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.invocation_ext') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->invocation_ext ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h6><br /><strong>{{ __('invocation_notification.officer_invoking') }}</strong>:
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.name') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->officer_name ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.designation') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->officer_designation ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.email') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->officer_email ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.mobile') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->officer_mobile ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.land_line') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->officer_land_line ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h6><br /><strong>{{ __('invocation_notification.official_incharge') }}</strong>
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.name') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->incharge_name ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.designation') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->incharge_designation ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.email') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->incharge_email ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.mobile') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->incharge_mobile ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.land_line') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->incharge_land_line ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h6><br /><strong>{{ __('invocation_notification.office_details') }}</strong></h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.branch') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->office_branch ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.attachment') }}
                                </td>
                                <td class="width_15em text-black">
                                    @if (isset($invocationDmsData['invocation_notification_attachment']))
                                        @foreach ($invocationDmsData['invocation_notification_attachment'] as $item)
                                            <a href="{{ isset($item->attachment) && !empty($item->attachment) ? asset($item->attachment) : asset('/default.jpg') }}"
                                                target="_blanck" title="{{ $item->file_name }}" download>
                                                <i class="fa fa-download text-black"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.address') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->office_address ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey">
                                    {{ __('invocation_notification.reason') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->reason ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h6><br /><strong>{{ __('invocation_notification.notice_details') }}</strong></h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.remark') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->remark ?? '-' }}
                                </td>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.attachment') }}
                                </td>
                                <td class="width_15em text-black">
                                    @if (isset($invocationDmsData['notice_attachment']))
                                        @foreach ($invocationDmsData['notice_attachment'] as $item)
                                            <a href="{{ isset($item->attachment) && !empty($item->attachment) ? asset($item->attachment) : asset('/default.jpg') }}"
                                                target="_blanck" title="{{ $item->file_name }}" download>
                                                <i class="fa fa-download text-black"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h6><br /><strong>{{ __('invocation_notification.invocation_closed') }}</strong>
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_15em text-light-grey pl-8">
                                    {{ __('invocation_notification.reason') }}
                                </td>
                                <td class="width_15em text-black">
                                    {{ $invocationData->closed_reason ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
@endif
