<div class="row">
    <div class="form-group col-12">
        <div id="beneficiaryTradeSectorRepeater">
            <table class="table table-separate table-head-custom table-checkable beneficiary_trade_sector_repeater" id="machine"
                data-repeater-list="beneficiaryTradeSector">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('beneficiary.trade_sector') }}<span class="text-danger">*</span></th>
                        <th>{{ __('beneficiary.from') }}<span class="text-danger">*</span></th>
                        <th>{{ __('beneficiary.till') }}</th>
                        <th>{{ __('beneficiary.main') }}<span class="text-danger">*</span></th>
                        {{-- <th width="20"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    <span class="text-danger item-dul-error d-none">Duplicate trade sector is select.</span>
                    @if (isset($beneficiary_trade_sector) && $beneficiary_trade_sector->count() > 0)
                        @foreach ($beneficiary_trade_sector as $index => $item)
                            <tr data-repeater-item="" class="trade_sector_row beneficiary_trade_sector_row">
                                <td class="trade-list-no">{{ ++$index }} . </td>
                                {{-- {!! Form::hidden("beneficiaryTradeSector[{$index}][trade_item_id]", $item->id ?? '') !!} --}}
                                <td>
                                    {!! Form::hidden("beneficiaryTradeSector[{$index}][beneficiary_trade_item_id]", $item->id ?? '', ['class' => 'beneficiaryTradeSectorId']) !!}
                                    {!! Form::hidden("beneficiaryTradeSector[{$index}][pbt_item_id]", $item->id ?? '') !!}
                                    {!! Form::hidden("beneficiaryTradeSector[{$index}][autoFetch]", 'autoFetch') !!}
                                    {!! Form::select("beneficiaryTradeSector[{$index}][beneficiary_trade_sector_id]", ['' => ''] + $trade_sector_id, $item->trade_sector_id, [
                                        'class' => 'form-control jsClearContractorType required trade_sector jsTradeSector trade_sector_id beneficiary_trade_sector_id',
                                        'data-placeholder' => 'Select Trade Sector',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date("beneficiaryTradeSector[{$index}][beneficiary_from]", $item->from, ['class' => 'form-control jsClearContractorType required beneficiary_from from', 'max' => now()->toDateString()]) !!}
                                </td>
                                <td>
                                    {!! Form::date("beneficiaryTradeSector[{$index}][beneficiary_till]", $item->till, ['class' => 'form-control jsClearContractorType till minDate beneficiary_till beneficiaryMinDate']) !!}
                                </td>
                                <td class="pl-5 pt-6">
                                    <div class="radio-inline">
                                        <label class="radio">
                                            {{ Form::radio("beneficiaryTradeSector[{$index}][beneficiary_is_main]", 'Yes', $item->is_main == 'Yes' ? true : false, ['class' => 'form-check-input beneficiary_is_main']) }}
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                {{-- <td>
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2 trade_sector_delete">
                                        <i class="flaticon-delete"></i></a>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>