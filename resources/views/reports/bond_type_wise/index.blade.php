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
            <form action="{{route('report.bond-type-wise.show')}}" method="POST" id="bondTypeWiseReportForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            {!! Form::label('selected_bond_type', __('reports.bond_type'))!!}
                            {!! Form::select('selected_bond_type', ['' => ''] + $bond_types, null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Bond Type']) !!}
                        </div>
                        <div class="form-group col-6">
                            {!! Form::label('selected_bond_status',__('reports.status'))!!}
                            {!! Form::select('selected_bond_status', ['' => ''] + $status,$selected_bond_status ?? null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Status']) !!}
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
