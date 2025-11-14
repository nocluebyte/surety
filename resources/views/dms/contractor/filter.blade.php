<form action="{{route('dms.show',encryptId($principle->id))}}" method="get">
    <div id="dmsFilter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
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
                        <div class="row">
                            <div class="col-6">
                                {{Form::label('from_date', __('dms.from_date'))}}
                                {!! Form::date('from_date', $from_date, ['class' => 'form-control']) !!}
                                {!! Form::hidden('type', $type) !!}
                            </div>
                            <div class="col-6">
                                {{Form::label('till_date', __('dms.till_date'))}}
                                {!! Form::date('till_date', $till_date, ['class' => 'form-control ']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('document_type_id', __('dms.document_type'))}}
                        {{Form::select('document_type_id', [''=>'Select'] + $documentType, $document_type ?? null, ['class' =>'form-select jsDocumentType','data-placeholder' => 'Select Document Type']);}}
                    </div>

                    <div class="form-group">
                        {{Form::label('file_source_id', __('dms.file_source'))}}
                        {{Form::select('file_source_id', [''=>'Select'] + $fileSource, $file_source ?? null, ['class' =>'form-select jsFileSource','data-placeholder' => 'Select File Source']);}}
                    </div>

                    <div class="form-group">
                        {{Form::label('file_name', __('dms.file_name'))}}
                        {{Form::text('file_name',$file_name, ['class' =>'form-control']);}}
                    </div>

                    <div class="form-group">
                        {{Form::label('sort_by', __('dms.sort_by'))}}
                        {{Form::select('sort_by', [''=>'Select','asc'=>'Ascending','desc'=>'Descending'],$sort_by, ['class' =>'form-select sort_by','data-placeholder' => 'Select']);}}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success mr-2 btn_search">{{ __('common.search') }}</button>
                    <a href="{{route('dms.show',encryptId($principle->id))}}" class="btn btn-danger">{{ __('common.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script type="text/javascript">
    $('.document_type,.file_source').select2({
        allowClear: true
    });
    $('.sort_by').select2({
        allowClear: true
    });
</script>
@endpush