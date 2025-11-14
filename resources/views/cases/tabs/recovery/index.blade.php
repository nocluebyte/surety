<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="accordionRecoveries">
    <table class="table table-separate table-head-custom table-checkable">
        <tbody>
            @if ($case->contractor->recovery->count() > 0)
                @foreach ($case->contractor->recovery as $key => $item)
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
                                    data-parent="#accordionRecoveries">
                                    <div class="card-body pl-12">
                                        <table class="table recoveriesAccordion">
                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.recovery_code')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{-- {{ $item->code ?? '-' }} --}}
                                                        @if($current_user->hasAnyAccess(['recovery.list', 'users.superadmin']))
                                                            <a href="{{ route('recovery.show', encryptId($item->id)) }}" target="_blank">{{ $item->code ?? '-' }}</a>
                                                        @else
                                                            {{ $item->code ?? '-' }}
                                                        @endif
                                                    </div>
                                                </td>

                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.invocation_number')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->invocationNotification->code }}
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
                                                        {{ $item->invocationNotification->bondPoliciesIssue->reference_no ?? '-' }}
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
                                                        {{ $item->invocationNotification->bond_number ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.date_of_recovery')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ isset($item->recover_date) ? custom_date_format($item->recover_date, 'd/m/Y') : '-' }}
                                                    </div>
                                                </td>
                                                
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.beneficiary_name')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->invocationNotification->beneficiary->company_name ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.tender_name')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ $item->invocationNotification->tender->tender_id ?? '-' }}
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
                                                        {{ numberFormatPrecision($item->bond_value, 0) ?? '-' }}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.total_recovered_amount')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ numberFormatPrecision($item->recover_amount, 0) ?? '-' }}
                                                    </div>
                                                </td>

                                                <td style="width: 20%">
                                                    <div class="font-weight-bold davy-grey-color">
                                                        {{ Form::label(__('principle.total_outstanding_amount')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td style="width: 30%">
                                                    <div class="font-weight-bold text-black">
                                                        {{ numberFormatPrecision($item->outstanding_amount, 0) ?? '-' }}
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
                                                        @if($item->recover_amount == 0)
                                                            Pending
                                                        @elseif($item->outstanding_amount == 0)
                                                            Completely Recovered
                                                        @else
                                                            Partially Recovered
                                                        @endif
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