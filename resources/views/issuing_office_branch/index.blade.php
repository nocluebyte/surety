@extends($theme)
@section('title', $title)

@section('content')
    @component('partials._subheader.subheader-v6', 
        $current_user->hasAnyAccess(['issuing_office_branch.import','users.superadmin']) ? array_merge([
        'page_title' => $title,
        'action'=> route('issuing-office-branch.create'),
        'filter_modal_id' => '#issuingOfficeBranchFilter',
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['issuing_office_branch.add', 'users.superadmin']),
        ],[
            'import'=> route('issuing_office_branch_import'),
            'text_import' => __('common.import'),
        ]) : [
        'page_title' => $title,
        'action'=> route('issuing-office-branch.create'),
        'filter_modal_id' => '#issuingOfficeBranchFilter',
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['issuing_office_branch.add', 'users.superadmin']),
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
                                <th></th>
                                <th class="d-none"></th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('branch_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('branch_code', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('bank', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('mode', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('issuing_office_branch.branch_name') }}</th>
                                <th>{{ __('issuing_office_branch.branch_code') }}</th>
                                <th>{{ __('issuing_office_branch.bank') }}</th>
                                <th>{{ __('issuing_office_branch.mode') }}</th>
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
    @include('issuing_office_branch.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let branch_name = "{{ __('issuing_office_branch.branch_name') }}";
        let branch_code = "{{ __('issuing_office_branch.branch_code') }}";
        let bank = "{{ __('issuing_office_branch.bank') }}";
        let mode = "{{ __('issuing_office_branch.mode') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.branch_name = jQuery(".datatable-form-filter input[name='branch_name']").val();
                        d.branch_code = jQuery(".datatable-form-filter input[name='branch_code']").val();
                        d.bank = jQuery(".datatable-form-filter input[name='bank']").val();
                        d.mode = jQuery(".datatable-form-filter input[name='mode']").val();
                        d.filter_mode = jQuery("select[name='filter_mode']").val();
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
                        "name": "branch_name",
                        "data": "branch_name",
                        "title": branch_name,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "branch_code",
                        "data": "branch_code",
                        "title": branch_code,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "bank",
                        "data": "bank",
                        "title": bank,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "mode",
                        "data": "mode",
                        "title": mode,
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

        jQuery('.btn_search').on('click', function(e) {
            window.LaravelDataTables["dataTableBuilder"].draw();
            $('.close').trigger('click');
            var fieldList = [
                'jsMode',
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
