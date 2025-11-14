@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'action' => route('project-details.create'),
        'text' => __('common.add'),
        'filter_modal_id' => '#projectDetailsFilter',
        'permission' => $current_user->hasAnyAccess(['project-details.add', 'users.superadmin']),
        'column_visibility' => true,
    ])
    @endcomponent
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-body table">
                    <table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <div class="jsFilterData"></div>
                                </th>
                            </tr>
                            <tr>
                                <th class="d-none"></th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('beneficiary', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_value', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_start_date', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_end_date', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('common.code') }}</th>
                                <th>{{ __('project_details.project_name') }}</th>
                                <th>{{ __('project_details.beneficiary') }}</th>
                                <th class="text-right">{{ __('project_details.project_value') }}</th>
                                <th>{{ __('project_details.project_start_date') }}</th>
                                <th>{{ __('project_details.project_end_date') }}</th>
                                <th>{{ __('common.status') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('project_details.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let code = "{{ __('common.code') }}";
        let project_name = "{{ __('project_details.project_name') }}";
        let beneficiary = "{{ __('project_details.beneficiary') }}";
        let project_value = "{{ __('project_details.project_value') }}";
        let project_start_date = "{{ __('project_details.project_start_date') }}";
        let project_end_date = "{{ __('project_details.project_end_date') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.project_name = jQuery(".datatable-form-filter input[name='project_name']").val();
                        d.beneficiary = jQuery(".datatable-form-filter input[name='beneficiary']")
                            .val();
                        d.project_value = jQuery(
                            ".datatable-form-filter input[name='project_value']").val();
                        d.project_start_date = jQuery(".datatable-form-filter input[name='project_start_date']").val();
                        d.project_end_date = jQuery(".datatable-form-filter input[name='project_end_date']").val();
                        d.filter_project_date = $('.jsProjectDate').val();
                    }
                },

                "columns": [{
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "class": "d-none",
                    },
                    {
                        "name": "code",
                        "data": "code",
                        "title": code,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "project_name",
                        "data": "project_name",
                        "title": project_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-500",
                    },
                    {
                        "name": "beneficiary",
                        "data": "beneficiary",
                        "title": beneficiary,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-500",
                    },
                    {
                        "name": "project_value",
                        "data": "project_value",
                        "title": project_value,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "project_start_date",
                        "data": "project_start_date",
                        "title": project_start_date,
                        "class": "min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "project_end_date",
                        "data": "project_end_date",
                        "title": project_end_date,
                        "class": "min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "is_active",
                        "data": "is_active",
                        "title": status,
                        "orderable": false,
                        "searchable": false,
                    },
                ],

                "searching": false,
            //     "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                dom: "<'row'<'col-sm-12'B>>" + "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                "stateSave": true,
                responsive: false,
                colReorder: true,
                buttons: [
                    {
                        extend: 'colvis',
                        columns: [1,2,3,4,5,6,7],
                        text: colVisIcon,
                    }
                ],
                "order": [
                    [1, "desc"]
                ],
                "pageLength": page_show_entriess,
            });
            const table = window.LaravelDataTables["dataTableBuilder"];
            table.buttons().container().appendTo('#custom-column-visibility-container');
        })(window, jQuery);

        jQuery('.btn_search').on('click', function(e) {
            window.LaravelDataTables["dataTableBuilder"].draw();
            $('.close').trigger('click');
            var fieldList = [
                'jsProjectDate',
            ];
            setFilterData(fieldList);
            e.preventDefault();
        });

        jQuery(".btn_reset").on('click', function(e) {
            jQuery(".datatable-form-filter input").val("");
            jQuery(".datatable-form-filter select").val("");
            window.LaravelDataTables["dataTableBuilder"].state.clear();
            window.location.reload();
        });
    </script>
    @include('comman.datatable_filter')
    @include('info')
@endsection
