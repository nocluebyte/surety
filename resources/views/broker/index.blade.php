@extends($theme)
@section('title', __('broker.broker'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('broker.broker'),
        'action' => route('broker.create'),
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['broker.add', 'users.superadmin']),
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
                                <th></th>
                                <th class="d-none"></th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('phone_no', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('city', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('common.company_name') }}</th>
                                <th>{{ __('common.full_name') }}</th>
                                <th>{{ __('common.email') }}</th>
                                <th>{{ __('common.phone_no') }}</th>
                                <th>{{ __('common.city') }}</th>
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
@endsection

@section('scripts')
    <script type="text/javascript">
        let company_name = "{{ __('common.company_name') }}"
        let full_name = "{{ __('common.full_name') }}";
        let email = "{{ __('common.email') }}";
        let phone_no = "{{ __('common.phone_no') }}";
        let city = "{{ __('common.city') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.company_name = jQuery(".datatable-form-filter input[name='company_name']").val();
                        d.full_name = jQuery(".datatable-form-filter input[name='full_name']").val();
                        d.email = jQuery(".datatable-form-filter input[name='email']").val();
                        d.phone_no = jQuery(".datatable-form-filter input[name='phone_no']").val();
                        d.city = jQuery(".datatable-form-filter input[name='city']").val();
                    }
                },

                "columns": [{
                        "name": "action",
                        "data": "action",
                        "title": action,
                        "render": null,
                        "searchable": false,
                        "orderable": false,
                        "width": "80px",
                    },
                    {
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "class": "d-none",
                    },
                    {
                        "name": "company_name",
                        "data": "company_name",
                        "title": company_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "full_name",
                        "data": "full_name",
                        "title": full_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    {
                        "name": "email",
                        "data": "email",
                        "title": email,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "phone_no",
                        "data": "phone_no",
                        "title": phone_no,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    {
                        "name": "city",
                        "data": "city",
                        "title": city,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
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
                "buttons": [
                    {
                        extend: 'colvis',
                        columns: [0,2,3,4,5,6,7],
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
    </script>
    @include('comman.datatable_filter')
    @include('info')
@endsection
