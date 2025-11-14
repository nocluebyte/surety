<form action="{{route('report.project-details-wise.show')}}" method="POST">
    @csrf
    <div id="project_details_wise_filter" class="modal fixed-left fade pr-0" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('common.filter')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {{Form::hidden('selected_project_details',$selected_project_details)}}
                    @foreach ($checked_fields as $checked_field)
                        {{Form::hidden('multicheckbox[]',$checked_field)}}
                    @endforeach
                          
                    <div class="form-group">
                        {!! Form::label('selected_project_details',__('reports.project_details'))!!}
                        {!! Form::select('selected_project_details', ['' => ''] + $project_details,$selected_project_details ?? null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Project Details']) !!}
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2">{{__('common.search')}}</button>
                    <button type="reset" class="btn btn-danger mr-2" >{{__('common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>