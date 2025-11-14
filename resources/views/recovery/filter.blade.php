<div id="recoveryFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('filter_contractor_name', __('recovery.contractor')) !!}
                    {!! Form::select('filter_contractor_name', ['' => ''] + $contractors ?? '', null, [
                        'class' => 'form-control contractor_name jsFilterContractorName jsSelect2ClearAllow',
                        'id' => 'contractor_name',
                        'data-placeholder' => 'Select Contractor',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_beneficiary_name', __('recovery.beneficiary')) !!}
                    {!! Form::select('filter_beneficiary_name', ['' => ''] + $beneficiaries ?? '', null, [
                        'class' => 'form-control beneficiary_name jsFilterBeneficiaryName jsSelect2ClearAllow',
                        'id' => 'beneficiary_name',
                        'data-placeholder' => 'Select Beneficiary',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_invocation_no', __('recovery.invocation_number')) !!}
                    {!! Form::select('filter_invocation_no', ['' => ''] + $invocation_number ?? '', null, [
                        'class' => 'form-control invocation_no jsFilterInvocationNo jsSelect2ClearAllow',
                        'id' => 'invocation_no',
                        'data-placeholder' => 'Select Invocation No',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_bond_number', __('recovery.bond_number')) !!}
                    {!! Form::select('filter_bond_number', ['' => ''] + $bond_number ?? '', null, [
                        'class' => 'form-control bond_number jsFilterBondNumber jsSelect2ClearAllow',
                        'id' => 'bond_number',
                        'data-placeholder' => 'Select Bond Number',
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
