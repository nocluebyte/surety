<div class="table-responsive">
    <table class="table" style="width:100%;">
        <div class="container">
            <thead>
                <tr>
                    <th>
                        {{__('common.no')}}
                    </th>
                    <th>
                        {{ __('principle.banking_category_label') }}
                    </th>
                    <th>
                        {{ __('principle.facility_types_label') }}
                    </th>
                    <th class="text-right">
                        {{ __('principle.sanctioned_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th>
                        {{ __('principle.bank_name') }}
                    </th>
                    <th class="text-right">
                        {{ __('principle.latest_limit_utilized') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th class="text-right">
                        {{ __('principle.unutilized_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th class="text-right">
                        {{ __('principle.commission_on_pg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th class="text-right">
                        {{ __('principle.commission_on_fg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th class="text-right">
                        {{ __('principle.margin_collateral') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th>
                        {{ __('principle.other_banking_details') }}
                    </th>
                    <th>
                        {{ __('principle.banking_limits_attachment') }}
                    </th>
                </tr>
            </thead>
            @if (isset($case->contractor->bankingLimits) && $case->contractor->bankingLimits->count() > 0)
                @foreach($case->contractor->bankingLimits->sortDesc() as $item)
                    <tbody>
                        <tr>
                            <td>{{$loop->iteration}}</td>
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
                            <td>
                                <!-- Button trigger modal-->
                                <a type="button" data-toggle="modal"
                                    data-target="#bankingLimit_attachment_modal_{{ $loop->iteration }}">
                                    <i class="fas fa-file"></i>
                                </a>
                                <!-- Modal-->
                                <div class="modal fade" id="bankingLimit_attachment_modal_{{ $loop->iteration }}" tabindex="-1"
                                    role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}"
                                                                    download><i class="fa fa-download text-black"></i></a>
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
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>No data available in table</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </div>
    </table>
</div>