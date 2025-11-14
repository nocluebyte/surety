{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', __('group.group'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('group.group'),
    'action' => route('group.create'),
    'text' => __('common.add'),
    'permission' => $current_user->hasAnyAccess(['group.add', 'users.superadmin']),
    'column_visibility' => true,
])
@endcomponent
@php
    $actionclass = '';
    if (!$current_user->hasAnyAccess(['group.edit', 'group.delete', 'users.superadmin'])) {
        $actionclass = 'd-none';
    }
@endphp


<div class="container-fluid">
    <div class="row">
        @include('components.error')
        <div class="col-sm-12">
            <div class="card" id="default">
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th class="{{ $actionclass }}"></th>
                                <th>
                                    <div class="datatable-form-filter no-padding">{!! Form::text('code', null, ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">{!! Form::text('filter_name', null, ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 7px;" class="{{ $actionclass }} text-center">
                                    {{ __('common.action') }}</th>
                                <th>{{ __('common.code') }}</th>
                                <th>{{ __('group.name') }}</th>
                                <th>{{ __('group.company_labels') }}</th>
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
<div id="load-modal"></div>
@include('info')
@endsection

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script type="text/javascript">
    var code = "{{ __('common.code') }}";
    var company_name = "{{ __('group.name') }}";
    var group_contractor_count = "{{ __('group.company_labels') }}";
    var action = "{{ __('common.action') }}";
    var is_active = "{{ __('common.status') }}";

    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function(d) {
                    d.lang = jQuery(".datatable-form-filter select[name='filter_lang']").val();
                    d.code = jQuery(".datatable-form-filter input[name='code']").val();
                    d.name = jQuery(".datatable-form-filter input[name='filter_name']").val();
                    d.no = jQuery(".datatable-form-filter input[name='filter_no']").val();
                }
            },
            "columns": [{
                "name": "action",
                "data": "action",
                "title": action,
                "render": null,
                "orderable": false,
                "searchable": false,
                class: '{{ $actionclass }}',
            },
            {
                "name": "code",
                "data": "code",
                "title": code,
                "orderable": true,
                "searchable": false
            }, {
                "name": "company_name",
                "data": "company_name",
                "title": company_name,
                "orderable": true,
                "searchable": false
            }, {
                "name": "group_contractor_count",
                "data": "group_contractor_count",
                "title": group_contractor_count,
                "orderable": true,
                "searchable": false
            }, ],
            "searching": false,
            // "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            dom: "<'row'<'col-sm-12'B>>" + "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            "oLanguage": {
                "sLengthMenu": "Display &nbsp;_MENU_",
            },
            "stateSave": true,
            responsive: false,
            colReorder: true,
            scroll: true,
            "buttons": [],
            "order": [
                [1, "desc"]
            ],
            "pageLength": page_show_entriess,
            // dom: `Bfrt<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6 dataTables_pager'lp>>`,
            buttons: [
                {
                    extend: 'colvis',
                    columns: [0,1,2,3],
                    text: colVisIcon,
                }
            ],
        });
        const table = window.LaravelDataTables["dataTableBuilder"];
        table.buttons().container().appendTo('#custom-column-visibility-container');
    })(window, jQuery);
    $('#dataTableBuilder').on('column-visibility.dt', function(e, settings, column, state) {
        var table = $(this).DataTable();
        table.columns.adjust();
    });
</script>
@include('comman.datatable_filter')
@endsection
