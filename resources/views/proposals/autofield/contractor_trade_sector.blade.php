<div class="row">
    <div class="form-group col-12">
        <div id="tradeSectorRepeater">
            <table class="table table-separate table-head-custom table-checkable tradeSector" id="machine"
                data-repeater-list="tradeSector">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.trade_sector') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.from') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.till') }}</th>
                        <th>{{ __('principle.main') }}<span class="text-danger">*</span></th>
                        {{-- <th width="20"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (isset($trade_sector) && count($trade_sector) > 0)
                        <span class="text-danger item-dul-error d-none">Duplicate trade sector
                            found.</span>
                        @foreach ($trade_sector as $index => $item)
                            <tr data-repeater-item="" class="contractor_trade_sector_row">
                                <td class="trade-list-no">{{ ++$index }} . </td>
                                <td>
                                    {!! Form::hidden("tradeSector[{$index}][contractor_trade_item_id]", $item->id ?? '', ['class' => 'contractorTradeSectorId']) !!}
                                    {!! Form::hidden("tradeSector[{$index}][pct_item_id]", $item->id ?? '') !!}
                                    {!! Form::hidden("tradeSector[{$index}][autoFetch]", 'autoFetch') !!}
                                    {!! Form::select("tradeSector[{$index}][contractor_trade_sector]", ['' => ''] + $trade_sector_id, $item->trade_sector_id, [
                                        'class' => 'form-control jsClearContractorType required contractor_trade_sector jsTradeSector',
                                        'data-placeholder' => 'Select Trade Sector',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date("tradeSector[{$index}][contractor_from]", $item->from, ['class' => 'form-control jsClearContractorType from required', 'max' => now()->toDateString()]) !!}
                                </td>
                                <td>
                                    {!! Form::date("tradeSector[{$index}][contractor_till]", $item->till, ['class' => 'form-control jsClearContractorType till minDate', 'max' => '9999-12-31']) !!}
                                </td>
                                <td class="pl-5 pt-6">
                                    <div class="radio-inline">
                                        <label class="radio">
                                            {{ Form::radio("tradeSector[{$index}][contractor_is_main]", 'Yes', $item->is_main == 'Yes' ? true : false, ['class' => 'form-check-input contractor_is_main']) }}
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