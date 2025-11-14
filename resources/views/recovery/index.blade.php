@extends($theme)
@section('title', __('recovery.recovery'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('recovery.recovery'),
        'text' => __('common.add'),
        'action' => route('recovery.create'),
        'filter_modal_id' => '#recoveryFilter',
        'permission' => $current_user->hasAnyAccess(['recovery.list', 'users.superadmin']),
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
                        @if ($current_user->hasAnyAccess(['recovery.list', 'users.superadmin']))
                            <div class="tab-pane table fade active show" id="bid-bond-3" role="tabpanel"
                                aria-labelledby="bid-bond-tab-3">
                                <table class="table table-responsive table-separate table-head-custom table-checkable" id="RecoveryDataTable">
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
                                                    {!! Form::text('invocation_number', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('bond_number', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('beneficiary', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('contractor', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('tender', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            {{-- <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('total_recoverd_amount', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('total_outstanding_amount', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>                --}}
                                        </tr>

                                        <tr>
                                            <th class="d-none"></th>
                                            <th>{{ __('recovery.code') }}</th>
                                            <th>{{ __('recovery.invocation_number') }}</th>
                                            <th>{{ __('recovery.bond_number') }}</th>
                                            <th>{{ __('recovery.date') }}</th>
                                            <th>{{ __('recovery.beneficiary') }}</th>
                                            <th>{{ __('recovery.contractor') }}</th>
                                            <th>{{ __('recovery.tender') }}</th>
                                            <th class="text-right">{{ __('recovery.bond_value') }}</th>
                                            <th class="text-right">{{ __('recovery.total_recoverd_amount') }}</th>                                            
                                            <th class="text-right">{{ __('recovery.total_outstanding_amount') }}</th>                      
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
    @include('recovery.filter')
@endsection


@push('scripts')
    <script type="text/javascript">
        let code = "{{ __('recovery.code') }}";
        let date = "{{__('recovery.date')}}";
        let beneficiary = "{{__('recovery.beneficiary')}}";
        let contractor = "{{ __('recovery.contractor') }}";
        let tender = "{{ __('recovery.tender') }}";      
        let recover_amount = "{{ __('recovery.recover_amount') }}";
        let outstanding_amount = "{{ __('recovery.outstanding_amount') }}";
        let invocation_number = "{{__('recovery.invocation_number')}}";
        let bond_value = "{{__('recovery.bond_value')}}";
        let bond_number = "{{__('recovery.bond_number')}}";
        
       

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#RecoveryDataTable').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.invocation_number = jQuery(".datatable-form-filter input[name='invocation_number']").val();
                        d.date = jQuery(".datatable-form-filter input[name='date']").val();
                        d.beneficiary = jQuery(".datatable-form-filter input[name='beneficiary']").val();
                        d.contractor = jQuery(".datatable-form-filter input[name='contractor']").val();
                        d.tender = jQuery(".datatable-form-filter input[name='tender']").val();
                        d.bond_number = jQuery(".datatable-form-filter input[name='bond_number']").val();
                        d.bond_type = jQuery(".datatable-form-filter input[name='bond_type']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.invocation_claim_date = jQuery(".datatable-form-filter input[name='invocation_claim_date']")
                            .val();
                        d.claimed_amount = jQuery(".datatable-form-filter input[name='claimed_amount']")
                            .val();
                        d.total_claim_approved = jQuery(".datatable-form-filter input[name='total_claim_approved']")
                        .val();            
                        
                        d.filter_contractor_name = jQuery("select[name='filter_contractor_name']").val();
                        d.filter_invocation_no = jQuery("select[name='filter_invocation_no']").val();
                        d.filter_beneficiary_name = jQuery("select[name='filter_beneficiary_name']").val();
                        d.filter_bond_number = jQuery("select[name='filter_bond_number']").val();
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
                        "name": "invocation_number",
                        "data": "invocation_number",
                        "title": invocation_number,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "bond_number",
                        "data": "bond_number",
                        "title": bond_number,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    {
                        "name": "date",
                        "data": "date",
                        "title": date,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "beneficiary",
                        "data": "beneficiary",
                        "title": beneficiary,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
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
                        "name": "tender",
                        "data": "tender",
                        "title": tender,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "bond_value",
                        "data": "bond_value",                       
                        "title": bond_value,
                        "class":"text-right min-width-200",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "name": "recover_amount",
                        "data": "recover_amount",                       
                        "title": recover_amount,
                        "class":"text-right min-width-200",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "name": "outstanding_amount",
                        "data": "outstanding_amount",
                        "title": outstanding_amount,
                        "class": "text-right min-width-200",
                        "orderable": false,
                        "searchable": false
                    }
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
                'jsFilterContractorName',
                'jsFilterBeneficiaryName',
                'jsFilterInvocationNo',
                'jsFilterBondNumber',
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
