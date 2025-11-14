<div id="bidBondFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-aside" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.filter') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('filter_source', __('bid_bond.source')) !!}
                    {!! Form::select('filter_source', ['' => ''] + $source ?? '', null, [
                        'class' => 'form-control source jsSource jsSelect2ClearAllow',
                        'id' => 'source',
                        'data-placeholder' => 'Select Source',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_beneficiary_type', __('bid_bond.beneficiary_type')) !!}
                    {!! Form::select('filter_beneficiary_type', ['' => ''] + $beneficiary_type ?? '', null, [
                        'class' => 'form-control bond_type_id jsFilterBeneficiaryType jsSelect2ClearAllow',
                        'id' => 'bond_type_id',
                        'data-placeholder' => 'Select Beneficiary Type',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_contractor_type', __('bid_bond.contractor_type')) !!}
                    {!! Form::select('filter_contractor_type', ['' => ''] + $contractor_type ?? '', null, [
                        'class' => 'form-control contractor_type jsFilterContractorType jsSelect2ClearAllow',
                        'id' => 'contractor_type',
                        'data-placeholder' => 'Select Contractor Type',
                    ]) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit"
                    class="btn btn-success mr-2 btn_search jsBtnSearch">{{ __('common.search') }}</button>
                <button type="button" class="btn btn-danger btn_reset">{{ __('common.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
