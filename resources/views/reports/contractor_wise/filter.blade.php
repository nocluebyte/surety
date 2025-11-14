{{-- {{ Form::open(array('role'=>"form")) }} --}}
<form action="{{route('report.contractor-wise.show')}}" method="POST">
    @csrf
    <div id="contractor_wise_filter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('common.filter')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- {{Form::hidden('contractor',$contractor_filter)}} --}}
                    @foreach ($checked_fields as $checked_field)
                        {{Form::hidden('multicheckbox[]',$checked_field)}}
                    @endforeach
                          
                    <div class="form-group">
                        {!! Form::label('contractor',__('reports.contractor'))!!}
                        {!! Form::select('contractor', ['' => 'Select'] + $contractor,$contractor_filter ?? null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Contractor']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('selected_status', __('reports.status')) !!}
                        {!! Form::select('selected_status[]', $status, explode(',', $selected_status) ?? null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Status', 'multiple']) !!}
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2">{{__('common.search')}}</button>
                    <button type="reset" class="btn btn-danger btn_reset mr-2" >{{__('common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- {{ Form::close() }} --}}
