@extends($theme)
@section('title', __('proposals.proposals'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('proposals.proposals'),
        'action' => route('proposals.create'),
        'text' => __('common.add'),
        'filter_modal_id' => '#proposalFilter',
        'permission' => $current_user->hasAnyAccess(['proposals.add', 'users.superadmin']),
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
                                        {!! Form::text('contractor_company_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('beneficiary_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('tender_header', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('bond_type', ['' => ''] + $type_of_bond ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Bond Type']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('bond_value', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('sys_gen_bond_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('insurer_bond_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('created_at', null, [
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </th> --}}
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('status', ['' => ''] + $status ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Status']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('nbi_status', ['' => ''] + $nbi_status ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Nbi Status']) !!}
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('common.code') }}</th>
                                <th>{{ __('proposals.contractor_name') }}</th>
                                <th>{{ __('proposals.beneficiary_name') }}</th>
                                <th>{{ __('proposals.project_name') }}</th>
                                <th>{{ __('proposals.tender_header') }}</th>
                                <th>{{ __('proposals.bond_type') }}</th>
                                <th class="text-right">{{ __('proposals.bond_value') }}</th>
                                <th>{{ __('proposals.sys_gen_bond_number') }}</th>
                                <th>{{ __('proposals.insurer_bond_number') }}</th>
                                {{-- <th>{{ __('common.created_at') }}</th> --}}
                                <th>{{ __('common.status') }}</th>
                                <th>{{ __('proposals.nbi_status') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('proposals.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let code = "{{ __('common.code') }}";
        let contractor_company_name = "{{ __('proposals.contractor_name') }}";
        let beneficiary_name = "{{ __('proposals.beneficiary_name') }}";
        let project_name = "{{ __('proposals.project_name') }}";
        let tender_header = "{{ __('proposals.tender_header') }}";
        let bond_type = "{{ __('proposals.bond_type') }}";
        let bond_value = "{{ __('proposals.bond_value') }}";
        let sys_gen_bond_number = "{{ __('proposals.sys_gen_bond_number') }}";
        let insurer_bond_number = "{{ __('proposals.insurer_bond_number') }}";
        // let created_at = "{{ __('common.created_at') }}";
        let status = "{{ __('common.status') }}";
        let nbi_status = "{{ __('proposals.nbi_status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.contractor_company_name = jQuery(".datatable-form-filter input[name='contractor_company_name']").val();
                        d.beneficiary_name = jQuery(".datatable-form-filter input[name='beneficiary_name']").val();
                        d.project_name = jQuery(".datatable-form-filter input[name='project_name']").val();
                        d.tender_header = jQuery(".datatable-form-filter input[name='tender_header']").val();
                        // d.created_at = jQuery(
                        //     ".datatable-form-filter input[name='created_at']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.sys_gen_bond_number = jQuery(".datatable-form-filter input[name='sys_gen_bond_number']").val();
                        d.insurer_bond_number = jQuery(".datatable-form-filter input[name='insurer_bond_number']").val();
                        d.bond_type = jQuery(".datatable-form-filter select[name='bond_type']").val();
                        d.status = jQuery(".datatable-form-filter select[name='status']").val();
                        d.nbi_status = jQuery(".datatable-form-filter select[name='nbi_status']").val();

                        d.filter_status = jQuery("select[name='filter_status']").val();
                        d.filter_bond_type = jQuery("select[name='filter_bond_type']").val();
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
                        "name": "contractor_company_name",
                        "data": "contractor_company_name",
                        "title": contractor_company_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "beneficiary_name",
                        "data": "beneficiary_name",
                        "title": beneficiary_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "project_name",
                        "data": "project_name",
                        "title": project_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "tender_header",
                        "data": "tender_header",
                        "title": tender_header,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "bond_type",
                        "data": "bond_type",
                        "title": bond_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    {
                        "name": "bond_value",
                        "data": "bond_value",
                        "class": "text-right min-width-200",
                        "title": bond_value,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "sys_gen_bond_number",
                        "data": "sys_gen_bond_number",
                        "class": "min-width-200",
                        "title": sys_gen_bond_number,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "insurer_bond_number",
                        "data": "insurer_bond_number",
                        "class": "min-width-200",
                        "title": insurer_bond_number,
                        "orderable": true,
                        "searchable": false
                    },
                    // {
                    //     "name": "created_at",
                    //     "data": "created_at",
                    //     "title": created_at,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "status",
                        "data": "status",
                        "title": status,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "nbi_status",
                        "data": "nbi_status",
                        "title": nbi_status,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
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
                        columns: [1,2,3,4,5,6,7,8,9,10,11],
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
                'jsStatus',
                'jsBondType',
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
