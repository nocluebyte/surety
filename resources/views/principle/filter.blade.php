<div id="principleFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('filter_principle_types', __('principle.principle_type')) !!}
                    {!! Form::select('filter_principle_types', ['' => ''] + $principle_types ?? '', null, [
                        'class' => 'form-control principle_types jsFilterPrincipleType jsSelect2ClearAllow',
                        'id' => 'principle_types',
                        'data-placeholder' => 'Select Principle Type',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_venture_type', __('principle.venture_type')) !!}
                    {!! Form::select('filter_venture_type', ['' => ''] + ['JV' => 'JV', 'SPV' => 'SPV', 'Stand Alone' => 'Stand Alone'], null, [
                        'class' => 'form-control venture_type jsIsJv jsSelect2ClearAllow',
                        'width' => 100,
                        'data-placeholder' => 'Select Venture Type',
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
