@extends($theme)
@section('title', __('insurance_companies.insurance_companies'))

@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('insurance_companies.insurance_companies'),
        'action' => route('insurance_companies.create'),
        'text' => __('common.add'),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['insurance_companies.add', 'users.superadmin']),
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
                                        {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
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
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('insurance_companies.company_name') }}</th>
                                <th>{{ __('insurance_companies.email') }}</th>
                                <th>{{ __('insurance_companies.phone_no') }}</th>
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
        let company_name = "{{ __('insurance_companies.company_name') }}";
        let email = "{{ __('insurance_companies.email') }}";
        let phone_no = "{{ __('insurance_companies.phone_no') }}";
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
                        d.email = jQuery(".datatable-form-filter input[name='email']").val();
                        d.phone_no = jQuery(".datatable-form-filter input[name='phone_no']").val();
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
