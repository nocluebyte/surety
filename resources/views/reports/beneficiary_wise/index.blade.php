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
            <form action="{{route('report.beneficiary-wise.show')}}" method="POST" id="beneficiaryWiseReportForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            {!! Form::label('selected_beneficiary', __('reports.beneficiary'))!!}
                            {!! Form::select('selected_beneficiary', ['' => ''] + $beneficiary, null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Beneficiary']) !!}
                        </div>

                        <div class="form-group col-3">
                            {!! Form::label('selected_status', __('reports.status')) !!}
                            {!! Form::select('selected_status[]', $status, null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Status', 'multiple']) !!}
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
                    <button type="button" class="btn btn-danger btn_reset">{{ __('common.cancel') }}</button>
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
