<div id="tenderFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('filter_beneficiary_id', __('tender.beneficiary')) !!}
                    {!! Form::select('filter_beneficiary_id', ['' => ''] + $beneficiary_id ?? '', null, [
                        'class' => 'form-control beneficiary_id jsBeneficiary jsSelect2ClearAllow',
                        'id' => 'beneficiary_id',
                        'data-placeholder' => 'Select Beneficiary',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_project_type', __('tender.project_type')) !!}
                    {!! Form::select('filter_project_type', ['' => ''] + $project_type ?? '', null, [
                        'class' => 'form-control project_type jsProjectType jsSelect2ClearAllow',
                        'id' => 'project_type',
                        'data-placeholder' => 'Select Project Type',
                    ]) !!}
                </div>

                {{-- <div class="form-group">
                    {!! Form::label('bond_type_id', __('tender.bond_type')) !!}
                    {!! Form::select('bond_type_id', ['' => ''] + $bond_type_id ?? '', null, [
                        'class' => 'form-control bond_type_id jsBondType jsSelect2ClearAllow',
                        'id' => 'bond_type_id',
                        'data-placeholder' => 'Select Bond Type',
                    ]) !!}
                </div> --}}

                <div class="form-group">
                    {!! Form::label('filter_type_of_contracting', __('tender.type_of_contracting')) !!}
                    {!! Form::select('filter_type_of_contracting', ['' => ''] + $type_of_contracting ?? '', null, [
                        'class' => 'form-control type_of_contracting jsTypeOfContracting jsSelect2ClearAllow',
                        'id' => 'type_of_contracting',
                        'data-placeholder' => 'Select Type of Contracting',
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
