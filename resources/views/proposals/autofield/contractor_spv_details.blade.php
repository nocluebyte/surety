<div class="row">
    <div class="form-group col-lg-12">
        <div id="kt_repeater_contractor">
            <table class="table table-separate table-head-custom table-checkable contractorDetails" id="machine"
                data-repeater-list="contractorDetails">
                <p class="duplicateError text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.principle') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.pan_no') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.share_holding') }}<span class="text-danger">*</span></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd(isset($jv_details) && count($jv_details) > 0, $jv_details) --}}
                    @if (isset($jv_details) && count($jv_details) > 0)
                        @foreach ($jv_details as $index => $item)
                            {{-- @dd($item) --}}
                            <tr data-repeater-item="" class="contractor_data_rows">
                                <td class="list-no">{{ ++$index }} . </td>
                                {{-- {!! Form::hidden("contractorDetails[{$index}][item_id]", $item->id) !!} --}}
                                <td>
                                    {!! Form::hidden("contractorDetails[{$index}][contractor_item_id]", '', ['class' => 'contractorItemId']) !!}
                                    {!! Form::select("contractorDetails[{$index}][contractor_id]", ['' => 'select'] + $proposal_contractor, $item->contractor_id, [
                                        'class' => 'form-control jsClearContractorType form-control-solid repDuplicate1 JvSpvContractorId',
                                        'style' => 'width: 100%;',
                                        'data-placeholder' => 'Select Contractor',
                                        'data-ajaxurl' => route('getContractorDetail'),
                                        'disabled',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::text("contractorDetails[{$index}][contractor_pan_no]", $item->pan_no, [
                                        'class' => 'form-control jsClearContractorType contractor_pan_no form-control-solid',
                                        'readonly',
                                        'data-rule-PanNo' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number("contractorDetails[{$index}][share_holding]", $item->share_holding, [
                                        'class' => 'form-control jsClearContractorType form-control-solid share_holding number ',
                                        'min' => '0.1',
                                        'max' => '100',
                                        'step' => '0.01',
                                        'data-rule-maxShareHolding' => true,
                                        'readonly'
                                    ]) !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('proposals.scripts.contractor_script')