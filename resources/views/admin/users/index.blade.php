{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', __('users.title'))
@component('partials._subheader.subheader-v6', [
    'page_title' => __('users.title'),
    'action' => route('users.create'),
    'text' => __('common.add'),
    'permission' => true,
    'column_visibility' => true,
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom gutter-b">

            <div class="card-body table">
                <table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="d-none"></th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_name', Request::get('filter_name', null), ['class' => 'form-control']) !!}
                                </div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_email', Request::get('filter_email', null), ['class' => 'form-control']) !!}
                                </div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_role', Request::get('filter_role', null), ['class' => 'form-control']) !!}
                                </div>
                            </th>
                            {{-- <th></th> --}}
                            <th></th>
                        </tr>
                        <tr>
                            <th class="noVis" width="10%">{{ __('common.no') }}</th>
                            <th class="d-none noVis"></th>
                            <th class="noVis" width="20%">{{ __('users.form.name') }}</th>
                            <th width="20%">{{ __('common.email') }}</th>
                            <th width="20%">{{ __('users.form.roles') }}</th>
                            {{-- <th width="20%">{{ __('users.form.user_type') }}</th> --}}
                            <th width="10%">{{ __('common.status') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.name = jQuery(".datatable-form-filter input[name='filter_name']").val();
                        d.email = jQuery(".datatable-form-filter input[name='filter_email']").val();
                        d.role = jQuery(".datatable-form-filter input[name='filter_role']").val();
                    }
                },
                "columns": [{
                        "name": "id",
                        "data": "id",
                        "title": "Sr. No",
                        "render": null,
                        "orderable": false,
                        "searchable": false,
                    }, {
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "class": "d-none",
                    }, {
                        "name": "name",
                        "data": "name",
                        "title": "Name",
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    }, {
                        "name": "email",
                        "data": "email",
                        "title": "Email",
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    }, {
                        "name": "role",
                        "data": "role",
                        "title": "Role",
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    // {
                    //     "name": "emp_type",
                    //     "data": "emp_type",
                    //     "title": "User Type",
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "is_active",
                        "data": "is_active",
                        "title": "Status",
                        "render": null,
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "searching": false,
                // "dom": `<'row'<'col-sm-12'tr>>
                // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                // dom: "<'table-responsive't>" +
                //     "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                dom: "<'row'<'col-sm-12'B>>" + "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                "stateSave": true,
                responsive: false,
                colReorder: true,
                // scrollY: false,
                // scrollX: true,
                "buttons": [],
                "order": [
                    [1, "desc"]
                ],
                "pageLength": page_show_entriess,
                // dom: 'Bfrtip', //visibility
                buttons: [ //visibility
                    {
                        extend: 'colvis',
                        columns: [0,2,3,4,5],
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
        }); //visibility
    </script>
    @include('comman.datatable_filter')
@endsection
@stop
