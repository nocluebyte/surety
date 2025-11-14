@extends($theme)
@section('title', __('invocation_notification.invocation_notification'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('invocation_notification.invocation_notification'),
        'text' => __('common.add'),
        'action' => route('invocation-notification.create'),
        //'filter_modal_id' => '#bidBondFilter',
        'permission' => $current_user->hasAnyAccess(['invocation_notification.add', 'users.superadmin']),
        'column_visibility' => true,
    ])
    @endcomponent
    {{-- @if (session()->has('tab'))
        @dd(session()->get('tab'))
    @endif --}}
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')            
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @if ($current_user->hasAnyAccess(['invocation_notification.list', 'users.superadmin']))
                            <div class="tab-pane table fade active show" id="bid-bond-3" role="tabpanel"
                                aria-labelledby="bid-bond-tab-3">
                                <table class="table table-responsive table-separate table-head-custom table-checkable" id="InvocationNotificationDataTable">
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
                                            {{-- <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('proposal_code', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th> --}}
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('invocation_notification_date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('beneficiary_name', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('contractor', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('tender_header', null, ['class' => 'form-control']) !!}
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
                                            <th></th>
                                            {{-- <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('bond_start_date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('bond_end_date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('closed_reason', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>                                             --}}
                                        </tr>

                                        <tr>
                                            <th class="d-none"></th>
                                            <th>{{ __('invocation_notification.code') }}</th>
                                            {{-- <th>{{ __('invocation_notification.proposal_code') }}</th> --}}
                                            <th>{{ __('invocation_notification.invocation_notification_date') }}</th>
                                            <th>{{ __('invocation_notification.beneficiary') }}</th>
                                            <th>{{ __('invocation_notification.contractor') }}</th>
                                            <th>{{ __('invocation_notification.tender_header') }}</th>
                                            <th>{{ __('proposals.sys_gen_bond_number') }}</th>
                                            <th>{{ __('proposals.insurer_bond_number') }}</th>
                                            <th>{{ __('invocation_notification.bond_type') }}</th>
                                            <th class="text-right">{{ __('invocation_notification.bond_value') }}</th>
                                            <th>{{__('invocation_notification.status')}}</th>
                                            {{-- <th>{{ __('invocation_notification.bond_start_date') }}</th>
                                            <th>{{ __('invocation_notification.bond_end_date') }}</th>
                                            <th>{{ __('invocation_notification.reason') }}</th>                                             --}}
                                        </tr>
                                    </thead>

                                    <tbody></tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    {{-- @include('bond.bid_bond.filter') --}}
@endsection


@push('scripts')
    <script type="text/javascript">
        let code = "{{ __('invocation_notification.code') }}";
        // let proposal_code = "{{ __('invocation_notification.proposal_code') }}";
        let invocation_notification_date = "{{ __('invocation_notification.invocation_notification_date') }}";
        let beneficiary_name = "{{ __('invocation_notification.beneficiary') }}";
        let contractor = "{{ __('invocation_notification.contractor') }}";
        let tender_header = "{{ __('invocation_notification.tender_header') }}";
        let sys_gen_bond_number = "{{ __('proposals.sys_gen_bond_number') }}";
        let insurer_bond_number = "{{ __('proposals.insurer_bond_number') }}";
        let bond_type = "{{ __('invocation_notification.bond_type') }}";
        let bond_value = "{{ __('invocation_notification.bond_value') }}";
        let status = "{{ __('common.status') }}";
        // let bond_start_date = "{{ __('invocation_notification.bond_start_date') }}";
        // let bond_end_date = "{{ __('invocation_notification.bond_end_date') }}";
        // let reason = "{{ __('invocation_notification.reason') }}";
        

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#InvocationNotificationDataTable').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    url: "{{ route('invocation-notification.index') }}",
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.proposal_code = jQuery(".datatable-form-filter input[name='proposal_code']").val();
                        d.contractor = jQuery(".datatable-form-filter input[name='contractor']").val();
                        d.bond_type = jQuery(".datatable-form-filter select[name='bond_type']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.bond_start_date = jQuery(".datatable-form-filter input[name='bond_start_date']")
                            .val();
                        d.bond_end_date = jQuery(".datatable-form-filter input[name='bond_end_date']")
                            .val();
                        d.invocation_notification_date = jQuery(".datatable-form-filter input[name='invocation_notification_date']")
                        .val();
                        d.status = jQuery(".datatable-form-filter input[name='closed_reason']")
                        .val();                        
                        d.beneficiary_name = jQuery(".datatable-form-filter input[name='beneficiary_name']").val();
                        d.tender_header = jQuery(".datatable-form-filter input[name='tender_header']").val();
                        d.sys_gen_bond_number = jQuery(".datatable-form-filter input[name='sys_gen_bond_number']").val();
                        d.insurer_bond_number = jQuery(".datatable-form-filter input[name='insurer_bond_number']").val();
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
                    // {
                    //     "name": "proposal_code",
                    //     "data": "proposal_code",
                    //     "title": proposal_code,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "invocation_date",
                        "data": "invocation_date",
                        "title": invocation_notification_date,
                        "orderable": false,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "beneficiary_name",
                        "data": "beneficiary_name",
                        "title": beneficiary_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-500",
                    },
                    {
                        "name": "contractor",
                        "data": "contractor",
                        "title": contractor,
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
                        "name": "sys_gen_bond_number",
                        "data": "sys_gen_bond_number",
                        "title": sys_gen_bond_number,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "insurer_bond_number",
                        "data": "insurer_bond_number",
                        "title": insurer_bond_number,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "bond_type",
                        "data": "bond_type",
                        "title": bond_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "bond_value",
                        "data": "bond_value",
                        "title": bond_value,
                        "class": "text-right min-width-150",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "status",
                        "data": "status",
                        "title": status,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    // {
                    //     "name": "bond_start_date",
                    //     "data": "bond_start_date",                       
                    //     "title": bond_start_date,
                    //     "orderable": false,
                    //     "searchable": false
                    // },
                    // {
                    //     "name": "bond_end_date",
                    //     "data": "bond_end_date",
                    //     "title": bond_end_date,
                    //     "orderable": false,
                    //     "searchable": false
                    // },
                    // {
                    //     "name": "closed_reason",
                    //     "data": "closed_reason",
                    //     "title": reason,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
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
                'jsSource',
                'jsFilterBeneficiaryType',
                'jsFilterContractorType',
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

        $('.bid_bond_status').select2({
            placeholder: "Select Status",
            allowClear: true,
        });
    </script>
    @include('comman.datatable_filter')
    @include('info')
@endpush
