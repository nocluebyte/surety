@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', 
    $current_user->hasAnyAccess(['tender.import','users.superadmin']) ? array_merge([
        'page_title' => $title,
        'action'=> route('tender.create'),
        'filter_modal_id' => '#tenderFilter',
        'text' => __('common.add'),
        'column_visibility' => true,
        'permission' => $current_user->hasAnyAccess(['tender.add', 'users.superadmin']),
        ],[
            'import'=> route('tender_import'),
            'text_import' => __('common.import'),
        ]) : [
        'page_title' => $title,
        'action'=> route('tender.create'),
        'filter_modal_id' => '#tenderFilter',
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['tender.add', 'users.superadmin']),
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
                                        {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('tender_id', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('tender_header', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('beneficiary_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('tenders_email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th> --}}
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('contract_value', null, [
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('project_type', null, [
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('bond_type', Request::get('bond_type', null), [
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </th> --}}
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('type_of_contracting', ['' => ''] + $type_of_contracting ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Type of Contracting']) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('period_of_contract', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('tenders_phone_no', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th> --}}
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('rfp_date', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('tender.tender_no') }}</th>
                                <th>{{ __('tender.tender_id') }}</th>
                                <th>{{ __('tender.tender_header') }}</th>
                                <th>{{ __('tender.project_name') }}</th>
                                <th>{{ __('tender.beneficiary_name') }}</th>
                                {{-- <th>{{ __('common.full_name') }}</th>
                                <th>{{ __('common.email') }}</th> --}}
                                <th class="text-right">{{ __('tender.contract_value') }}</th>
                                <th>{{ __('tender.project_type') }}</th>
                                {{-- <th>{{ __('tender.bond_type') }}</th> --}}
                                <th>{{ __('tender.type_of_contracting') }}</th>
                                {{-- <th>{{ __('tender.period_of_contract') }}</th>
                                <th>{{ __('common.phone_no') }}</th> --}}
                                <th>{{ __('tender.rfp_date') }}</th>
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
    @include('tender.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let tender_no = "{{ __('tender.tender_no') }}";
        let tender_header = "{{ __('tender.tender_header') }}";
       // let full_name = "{{ __('common.full_name') }}";
        //let email = "{{ __('common.email') }}";
        let contract_value = "{{ __('tender.contract_value') }}";
        // let bond_type = "{{ __('tender.bond_type') }}";
        let type_of_contracting = "{{ __('tender.type_of_contracting') }}";
        // let period_of_contract = "{{ __('tender.period_of_contract') }}";
        // let phone_no = "{{ __('common.phone_no') }}";
        let rfp_date = "{{ __('tender.rfp_date') }}";
        let status = "{{ __('common.status') }}";
        let tender_id = "{{ __('tender.tender_id') }}";
        let project_name = "{{ __('tender.project_name') }}";
        let beneficiary_name = "{{ __('tender.beneficiary_name') }}";
        let project_type = "{{ __('tender.project_type') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.tender_header = jQuery(".datatable-form-filter input[name='tender_header']").val();
                        //d.full_name = jQuery(".datatable-form-filter input[name='full_name']").val();
                        //d.email = jQuery(".datatable-form-filter input[name='tenders_email']").val();
                        d.contract_value = jQuery(".datatable-form-filter input[name='contract_value']")
                            .val();
                        // d.bond_type = jQuery(".datatable-form-filter input[name='bond_type']")
                        //     .val();
                        d.type_of_contracting = jQuery(
                                ".datatable-form-filter select[name='type_of_contracting']")
                            .val();
                        // d.period_of_contract = jQuery(".datatable-form-filter input[name='period_of_contract']").val();
                        // d.phone_no = jQuery(".datatable-form-filter input[name='tenders_phone_no']").val();
                        d.rfp_date = jQuery(".datatable-form-filter input[name='rfp_date']").val();
                        d.bond_type_id = jQuery("select[name='bond_type_id']").val();
                        d.filter_beneficiary_id = jQuery("select[name='filter_beneficiary_id']").val();
                        d.filter_project_type = jQuery("select[name='filter_project_type']").val();
                        d.filter_type_of_contracting = jQuery("select[name='filter_type_of_contracting']").val();
                        d.tender_id = jQuery(".datatable-form-filter input[name='tender_id']").val();
                        d.project_name = jQuery(".datatable-form-filter input[name='project_name']").val();
                        d.beneficiary_name = jQuery(".datatable-form-filter input[name='beneficiary_name']").val();
                        d.project_type = jQuery(".datatable-form-filter input[name='project_type']").val();
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
                        "title": tender_no,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "tender_id",
                        "data": "tender_id",
                        "title": tender_id,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    {
                        "name": "tender_header",
                        "data": "tender_header",
                        "title": tender_header,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-500",
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
                        "name": "beneficiary_name",
                        "data": "beneficiary_name",
                        "title": beneficiary_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    /*{
                        "name": "full_name",
                        "data": "full_name",
                        "title": full_name,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "tenders_email",
                        "data": "tenders_email",
                        "title": email,
                        "orderable": true,
                        "searchable": false
                    },*/
                    {
                        "name": "contract_value",
                        "data": "contract_value",
                        "class": "text-right min-width-200",
                        "title": contract_value,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "project_type",
                        "data": "project_type",
                        "class": "min-width-200",
                        "title": project_type,
                        "orderable": true,
                        "searchable": false
                    },
                    // {
                    //     "name": "bond_type_id",
                    //     "data": "bond_type",
                    //     "title": bond_type,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "type_of_contracting",
                        "data": "type_of_contracting",
                        "title": type_of_contracting,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    // {
                    //     "name": "period_of_contract",
                    //     "data": "period_of_contract",
                    //     "title": period_of_contract,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    // {
                    //     "name": "tenders_phone_no",
                    //     "data": "tenders_phone_no",
                    //     "title": phone_no,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "rfp_date",
                        "data": "rfp_date",
                        "title": rfp_date,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "is_active",
                        "data": "is_active",
                        "title": status,
                        "orderable": false,
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
                        columns: [1,2,3,4,5,6,7,8,9,10],
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
                'jsTypeOfContracting',
                'jsBeneficiary',
                'jsProjectType',
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
