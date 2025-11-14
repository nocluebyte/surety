<div id="casesFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                    {!! Form::label('filter_underwriter', __('cases.underwriter')) !!}
                    {!! Form::select('filter_underwriter', ['' => ''] + $underwriter ?? '', null, [
                        'class' => 'form-control filter_underwriter jsUnderwriter jsSelect2ClearAllow',
                        'id' => 'filter_underwriter',
                        'data-placeholder' => 'Select Underwriter',
                    ]) !!}
                </div>

                {{-- <div class="form-group">
                    {!! Form::label('filter_contractor', __('cases.company_name')) !!}
                    {!! Form::select('filter_contractor', ['' => ''] + $contractors ?? '', null, [
                        'class' => 'form-control filter_contractor jsFilterContractor jsSelect2ClearAllow',
                        'id' => 'filter_contractor',
                        'data-placeholder' => 'Select Contractor',
                    ]) !!}
                </div> --}}

                <div class="form-group">
                    {!! Form::label('filter_case_type', __('cases.case_type')) !!}
                    {!! Form::select('filter_case_type', ['' => ''] + $case_type ?? '', null, [
                        'class' => 'form-control filter_case_type jsFilterCaseType jsSelect2ClearAllow',
                        'id' => 'filter_case_type',
                        'data-placeholder' => 'Select Case Type',
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('filter_generated_from', __('cases.generated_from')) !!}
                    {!! Form::select('filter_generated_from', ['' => ''] + $generated_from ?? '', null, [
                        'class' => 'form-control filter_generated_from jsFilterGeneratedFrom jsSelect2ClearAllow',
                        'id' => 'filter_generated_from',
                        'data-placeholder' => 'Select Generated From',
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
