@extends($theme)
@section('title', $title)

@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'add_modal' => collect([
            'action' => route('hsn-code.create'),
            'target' => '#commonModalID',
            'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['hsn-code.add', 'users.superadmin']),
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
                                        {!! Form::text('hsn_code', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('gst', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('is_service', null, ['class' => 'form-control']) !!}
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
                                <th>{{ __('hsn_code.hsn_code') }}</th>
                                <th>{{ __('hsn_code.gst') }}</th>
                                <th>{{ __('hsn_code.type') }}</th>
                                <th>{{ __('hsn_code.description') }}</th>
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
        let hsn_code = "{{ __('hsn_code.hsn_code') }}";
        let description = "{{ __('hsn_code.description') }}";
        let gst = "{{ __('hsn_code.gst') }}";
        let type = "{{ __('hsn_code.type') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.hsn_code = jQuery(".datatable-form-filter input[name='hsn_code']").val();
                        d.description = jQuery(".datatable-form-filter input[name='description']").val();
                        d.gst = jQuery(".datatable-form-filter input[name='gst']").val();
                        d.is_service = jQuery(".datatable-form-filter input[name='is_service']").val();
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
                        "name": "hsn_code",
                        "data": "hsn_code",
                        "title": hsn_code,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "gst",
                        "data": "gst",
                        "title": gst,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "is_service",
                        "data": "is_service",
                        "title": type,
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
                responsive: false,
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
