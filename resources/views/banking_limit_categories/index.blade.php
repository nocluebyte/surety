@extends($theme)
@section('title', __('banking_limit_categories.banking_limit_categories'))

@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('banking_limit_categories.banking_limit_categories'),
        'add_modal' => collect([
            'action' => route('banking_limit_categories.create'),
            'target' => '#commonModalID',
            'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['banking_limit_categories.add', 'users.superadmin']),
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
                                <th></th>
                                <th class="d-none"></th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('name', Request::get('name', null), ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('type', Request::get('type', null), ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('banking_limit_categories.name') }}</th>
                                <th>{{ __('banking_limit_categories.type') }}</th>
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
        let name = "{{ __('banking_limit_categories.name') }}";
        let type = "{{ __('banking_limit_categories.type') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.name = jQuery(".datatable-form-filter input[name='name']").val();
                        d.type = jQuery(".datatable-form-filter input[name='type']").val();
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
                        "name": "name",
                        "data": "name",
                        "title": name,
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
                dom: "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                responsive: true,
                colReorder: true,
                "buttons": [],
                "order": [
                    [1, "desc"]
                ],
                "pageLength": page_show_entriess,
            });
        })(window, jQuery);
    </script>
    @include('comman.datatable_filter')
    @include('info')
@endsection
