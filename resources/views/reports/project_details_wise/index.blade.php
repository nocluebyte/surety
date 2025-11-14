@extends($theme)
@section('content')
@section('title',$title)

@component('partials._subheader.subheader-v6', [
'page_title' => $title,
'permission' => true,
'back_text' => __('common.back'),
'model_back_action' => route('reports'),
])
@endcomponent

<div class="container-fluid">

    <div class="row">
    <div class="col-sm-12">
        <div class="card" id="default">
            <form action="{{route('report.project-details-wise.show')}}" method="POST" id="projectDetailsWiseReportForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            {!! Form::label('selected_project_details', __('reports.project_details'))!!}
                            {!! Form::select('selected_project_details', ['' => ''] + $project_details, null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Project Details']) !!}
                        </div>
                    </div>
                    @include('reports.common.fieldlist',[
                        'fields'=>$fields,
                        'checked_fields'=>[]
                    ])
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submit" disabled='disabled'
                        id="btn_loader">{{ __('common.generate') }}</button>
                    <button type="reset" class="btn btn-danger mr-2">{{ __('common.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

@endsection

@section('scripts')
    @include('reports.common.script')
@endsection
