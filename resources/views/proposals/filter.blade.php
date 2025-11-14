<div id="proposalFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('filter_status', __('common.status')) !!}
                    {!! Form::select('filter_status', ['' => ''] + $status ?? [], null, [
                        'class' => 'form-control jsStatus jsSelect2ClearAllow',
                        'id' => 'status',
                        'data-placeholder' => 'Select Status',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_bond_type', __('proposals.type_of_bond')) !!}
                    {!! Form::select('filter_bond_type', ['' => ''] + $type_of_bond ?? '', null, [
                        'class' => 'form-control bond_type jsBondType jsSelect2ClearAllow',
                        'id' => 'bond_type',
                        'data-placeholder' => 'Select Bond Type',
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
