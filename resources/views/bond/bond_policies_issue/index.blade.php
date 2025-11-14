@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('bond_policies_issue.issued_bonds'),
        'permission' => $current_user->hasAnyAccess(['bond_policies_issue.list', 'users.superadmin']),
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
                                        {!! Form::text('bondNumber', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('contractor_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('beneficiary_name', null, ['class' => 'form-control']) !!}
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
                                        {!! Form::select('bond_conditionality', ['' => ''] + $bond_conditionality ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Bond Conditionality']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('premium_amount', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('status', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('bond_policies_issue.bond_number') }}</th>
                                <th>{{ __('bond_policies_issue.contractor') }}</th>
                                <th>{{ __('bond_policies_issue.beneficiary') }}</th>
                                <th>{{ __('proposals.bond_type') }}</th>
                                <th class="text-right">{{ __('bond_policies_issue.bond_value') }}</th>
                                <th>{{ __('bond_policies_issue.bond_conditionality') }}</th>
                                <th class="text-right">{{ __('bond_policies_issue.premium_amount') }}</th>
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
        let bondNumber = "{{ __('bond_policies_issue.bond_number') }}";
        let contractor_name = "{{ __('bond_policies_issue.contractor') }}";
        let beneficiary_name = "{{ __('bond_policies_issue.beneficiary') }}";
        let bond_value = "{{ __('bond_policies_issue.bond_value') }}";
        let bond_conditionality = "{{ __('bond_policies_issue.bond_conditionality') }}";
        let premium_amount = "{{ __('bond_policies_issue.premium_amount') }}";
        let status = "{{ __('common.status') }}";
        let bond_type = "{{ __('proposals.bond_type') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.bondNumber = jQuery(".datatable-form-filter input[name='bondNumber']").val();
                        d.contractor_name = jQuery(".datatable-form-filter input[name='contractor_name']").val();
                        d.beneficiary_name = jQuery(".datatable-form-filter input[name='beneficiary_name']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.bond_conditionality = jQuery(".datatable-form-filter select[name='bond_conditionality']").val();
                        d.premium_amount = jQuery(".datatable-form-filter input[name='premium_amount']").val();
                        d.status = jQuery(".datatable-form-filter input[name='status']").val();
                        d.bond_type = jQuery(".datatable-form-filter select[name='bond_type']").val();
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
                        "name": "bondNumber",
                        "data": "bondNumber",
                        "title": bondNumber,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "contractor_name",
                        "data": "contractor_name",
                        "title": contractor_name,
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
                        "name": "bond_type",
                        "data": "bond_type",
                        "title": bond_type,
                        "class": "min-width-150",
                        "orderable": true,
                        "searchable": false,
                    },
                    {
                        "name": "bond_value",
                        "data": "bond_value",
                        "title": bond_value,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "bond_conditionality",
                        "data": "bond_conditionality",
                        "title": bond_conditionality,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "premium_amount",
                        "data": "premium_amount",
                        "title": premium_amount,
                        "class": "text-right min-width-150",
                        "orderable": true,
                        "searchable": false,
                    },
                    {
                        "name": "status",
                        "data": "status",
                        "title": status,
                        "class": "min-width-150",
                        "orderable": true,
                        "searchable": false,
                    },
                ],

                "searching": false,
        //         "dom": `<'row'<'col-sm-12'tr>>
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
                        columns: [1,2,3,4,5,6,7,8],
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
