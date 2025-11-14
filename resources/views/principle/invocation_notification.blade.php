<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="accordionInvocationNotification">
    <table class="table table-separate table-head-custom table-checkable">
        <tbody>
            @if ($principle->invocationNotification->count() > 0)
                @foreach ($principle->invocationNotification as $key => $item)
                    <tr>
                        <td class="border-0">
                            <div class="card">
                                <div class="card-header" id="headingOne7-{{ $loop->index + 1 }}">
                                    <div class="card-title collapsed" data-toggle="collapse"
                                        data-target="#collapseOne7-{{ $loop->index + 1 }}" aria-expanded="false">
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
                                            {{ $item->code }}</div>
                                    </div>
                                </div>
                                <div id="collapseOne7-{{ $loop->index + 1 }}" class="collapse"
                                    data-parent="#accordionInvocationNotification">
                                    <div class="card-body pl-12">
                                        <table class="table invocationNotificationAccordion">
                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.invocation_number')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{-- {{ $item->code ?? '-' }} --}}
                                                        @if($current_user->hasAnyAccess(['invocation_notification.list', 'users.superadmin']))
                                                            <a href="{{ route('invocation-notification.show', encryptId($item->id)) }}" target="_blank">{{ $item->code ?? '-' }}</a>
                                                        @else
                                                            {{ $item->code ?? '-' }}
                                                        @endif
                                                    </div>
                                                </td>

                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.invocation_notification_date')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ isset($item->invocation_date) ? custom_date_format($item->invocation_date, 'd/m/Y') : '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.beneficiary_name')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->beneficiary->company_name ?? '-' }}
                                                    </div>
                                                </td>

                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.tender_header')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->tender->tender_header ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.system_generated_bond_number')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->bondPoliciesIssue->reference_no ?? '-' }}
                                                    </div>
                                                </td>
                                                
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.insurer_mapped_bond_number')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->bond_number ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.bond_type')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->bondType->name ?? '-' }}
                                                    </div>
                                                </td>
                                                
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.bond_value')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ numberFormatPrecision($item->total_outstanding_amount, 0) ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.status')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->status ?? '-' }}
                                                    </div>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">{{ __('common.no_records_found') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>