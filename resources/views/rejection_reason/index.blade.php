@extends($theme)
@section('title', $title)

@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'add_modal' => collect([
            'action' => route('rejection-reason.create'),
            'target' => '#commonModalID',
            'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['rejection_reason.add', 'users.superadmin']),
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
                                        {!! Form::text('reason', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('rejection_reason.reason') }}</th>
                                <th>{{ __('rejection_reason.description') }}</th>
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
        let reason = "{{ __('rejection_reason.reason') }}";
        let description = "{{ __('rejection_reason.description') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.reason = jQuery(".datatable-form-filter input[name='reason']").val();
                        d.description = jQuery(".datatable-form-filter input[name='description']").val();
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
                        "name": "reason",
                        "data": "reason",
                        "title": reason,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "description",
                        "data": "description",
                        "title": description,
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
