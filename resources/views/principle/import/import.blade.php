@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('principle.add_principle'),
    'back_action' => route('principle.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        <div class="card card-custom gutter-b">
            @if (session()->has('excel_error') && count(session()->get('excel_error')) > 0)
                <div class="card-body">
                    <div class="row float-right">
                        <div class="col"></div>
                        <div class="col mb-5">
                            {!! Form::open(['route' => 'principleImportErrorExport', 'method' => 'POST']) !!}
                            {!! Form::hidden('error', json_encode(session()->get('excel_error'))) !!}
                            {!! Form::submit('Export File of Error or Unformatted Record', ['class' => 'btn btn-light-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @include('principle.export.principle_import_error_export', [
                        'excel_error' => session()->get('excel_error'),
                    ])
                </div>
            @else
                <div class="card-body">
                    {!! Form::open([
                        'route' => 'principle_data_import',
                        'enctype' => 'multipart/form-data',
                        'method' => 'POST',
                        'id' => 'principle_import_form',
                    ]) !!}
                    @csrf
                    <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                        <div class="form-group col-lg-12 px-0 mb-0">
                            <div class="row">
                                <div class="form-group col-lg-12 text-right">
                                    <a href="{{ url('/excel/contractor_bulk_upload.xls') }}" class="btn btn-success btn-sm mr-3">
                                        <i class="flaticon-download-1"></i>{{ __('principle.demo_file') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>{{ __('principle.upload_file') }}<span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="file" name="file" id="file"
                                            class="form-control border-0 files pl-0 required" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                            <button type="submit" class="btn btn-primary" name="saveBtn"
                                id='btn_loader'>{{ __('common.import') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>

@endsection

@include('principle.import.script')