{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', $title )

@component('partials._subheader.subheader-v6',
[
'page_title' => $title,
// 'add_modal' => collect([
// 'action'=> route('dms.create'),
// 'target' => '#commonModalID',
// 'text' => __('common.add'),
// ]),
'permission' => $current_user->hasAnyAccess(['dms.add', 'users.superadmin']),
])
@endcomponent

@php
$actionclass = '';
if (!$current_user->hasAnyAccess(['dms.edit', 'dms.delete', 'users.superadmin'])) {
    $actionclass = 'd-none';
}
@endphp

<div class="d-flex">
    <div class="container-fluid">
        <div class="card-toolbar pb-4">
            <a href="{{route('dms.index')}}" type="reset" class="btn {{ (request()->is('dms')) ? 'btn-success' : 'btn-outline-secondary' }} mr-2">{{__('dms.contractor')}}</a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            @include('components.error')
            <div class="card" id="default">
                <div class="card-body">
                    <div class="table">
                        <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline" id="dataTableBuilder">
                            <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('cin',null,array('class' => 'form-control jsCin')) !!}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('company_name',null,array('class' => 'form-control jsCompanyName')) !!}
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>{{__('dms.cin')}}</th>
                                    <th>{{__('dms.company_name')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>
@endsection
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@push('scripts')

<script type="text/javascript">
    var cin = "{{__('dms.cin')}}";
    var company_name = "{{__('dms.company_name')}}";

    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function(d) {
                    d.cin = $(".jsCin").val();
                    d.company_name = $(".jsCompanyName").val();
                }
            },
            "columns": [ {
                "name": "id",
                "data": "id",
                "title": "id",
                "orderable": true,
                "class": "d-none",
            }, {
                "name": "code",
                "data": "code",
                "title": cin,
                "orderable": true,
                "searchable": false,
                "class": "min-width-500",
            }, {
                "name": "company_name",
                "data": "company_name",
                "title": company_name,
                "orderable": true,
                "searchable": false,
                "class": "min-width-500",
            } ],
            "searching": false,
            //"dom": "<\"wrapper\">rtilfp",
            // "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            dom: "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            "oLanguage": {
                "sLengthMenu": "Display &nbsp;_MENU_",
            },
            "stateSave": true,
            responsive: true,
            colReorder: true,
            // scrollY: false,
            // scrollX: true,
            "buttons": [],
            "order": [
                [1, "desc"]
            ],
            "pageLength": page_show_entriess,
        });
    })(window, jQuery);
</script>
<script>
    @if($message = session('dms_error'))
        message.fire({
            title: 'Error',
            text: "{{$message}}",
            type: 'error',
            cancelButtonText: 'No, cancel!'
        });
    @endif
</script>
@include('comman.datatable_filter')
@endpush