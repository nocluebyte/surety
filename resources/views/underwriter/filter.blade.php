<div id="underwriterFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('underwriter_type', __('underwriter.type')) !!}
                    {!! Form::select('underwriter_type', ['' => ''] + $underwriter_type ?? '', null, [
                        'class' => 'form-control underwriter_type jsUnderwriterType jsSelect2ClearAllow',
                        'id' => 'underwriter_type',
                        'data-placeholder' => 'Select Underwriter Type',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('is_active', __('common.status')) !!}
                    {!! Form::select('is_active', ['' => ''] + $underwriter_status, null, [
                        'class' => 'form-control is_active jsIsActive jsSelect2ClearAllow',
                        'width' => 100,
                        'data-placeholder' => 'Select Status',
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
