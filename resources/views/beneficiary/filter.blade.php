<div id="beneficiaryFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-aside" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.filter') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- <div class="form-group">
                    {!! Form::label('filter_beneficiary_entity', __('beneficiary.type_of_beneficiary_entity')) !!}
                    {!! Form::select('filter_beneficiary_entity', ['' => ''] + $type_of_beneficiary_entity ?? '', null, [
                        'class' => 'form-control type_of_beneficiary_entity jsBeneficiaryEntity jsSelect2ClearAllow',
                        'id' => 'type_of_beneficiary_entity',
                        'data-placeholder' => 'Select Beneficiary Entity',
                    ]) !!}
                </div> --}}

                <div class="form-group">
                    {!! Form::label('filter_establishment_type', __('beneficiary.establishment_type')) !!}
                    {!! Form::select('filter_establishment_type', ['' => ''] + $establishment_type_id ?? '', null, [
                        'class' => 'form-control establishment_type_id jsEstablishmentType jsSelect2ClearAllow',
                        'id' => 'establishment_type_id',
                        'data-placeholder' => 'Select Establishment Type',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_beneficiary_type', __('beneficiary.beneficiary_type')) !!}
                    {!! Form::select('filter_beneficiary_type', ['' => '', 'Government' => 'Government', 'Non-Government' => 'Non-Government'], null, [
                        'class' => 'form-control beneficiary_type jsBeneficiaryType jsSelect2ClearAllow',
                        'id' => 'beneficiary_type',
                        'data-placeholder' => 'Select Beneficiary Type',
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
