@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'action' => route('underwriter.create'),
        'text' => __('common.add'),
        'filter_modal_id' => '#underwriterFilter',
        'permission' => $current_user->hasAnyAccess(['underwriter.add', 'users.superadmin']),
        'column_visibility' => true,
    ])
    @endcomponent
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
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
                                        {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('type', Request::get('type', null), ['class' => 'form-control']) !!}
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
                                <th></th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('common.full_name') }}</th>
                                <th>{{ __('common.type') }}</th>
                                <th>{{ __('common.email') }}</th>
                                <th>{{ __('common.phone_no') }}</th>
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
    @include('underwriter.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let full_name = "{{ __('common.full_name') }}";
        let type = "{{ __('common.type') }}";
        let email = "{{ __('common.email') }}";
        let phone_no = "{{ __('common.phone_no') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.full_name = jQuery(".datatable-form-filter input[name='full_name']").val();
                        d.type = jQuery(".datatable-form-filter input[name='type']").val();
                        d.email = jQuery(".datatable-form-filter input[name='email']").val();
                        d.phone_no = jQuery(".datatable-form-filter input[name='phone_no']").val();

                        d.underwriter_type = jQuery("select[name='underwriter_type']").val();
                        d.status = jQuery("select[name='is_active']").val();
                    }
                },

                "columns": [
                    {
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "class": "d-none",
                    },
                    {
                        "name": "full_name",
                        "data": "full_name",
                        "title": full_name,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "type",
                        "data": "type",
                        "title": type,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "email",
                        "data": "email",
                        "title": email,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "phone_no",
                        "data": "phone_no",
                        "title": phone_no,
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
                responsive: true,
                colReorder: true,
                "buttons": [
                    {
                        extend: 'colvis',
                        columns: [1,2,3,4,5],
                        text: colVisIcon,
                    }
                ],
                "order": [
                    [0, "desc"]
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
                'jsUnderwriterType',
                'jsIsActive',
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
