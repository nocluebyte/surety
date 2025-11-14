@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        //'text' => __('common.add'),
        //'action' => route('premium.create'),
        'filter_modal_id' => '#premiumFilter',
        'permission' => $current_user->hasAnyAccess(['premium.list', 'users.superadmin']),
        'column_visibility' => true,
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @if ($current_user->hasAnyAccess(['premium.list', 'users.superadmin']))
                            <div class="tab-pane fade active show" id="premium-3" role="tabpanel"
                                aria-labelledby="premium-tab-3">
                                <table class="table table-responsive table-separate table-head-custom table-checkable" id="BidBondDataTableBuilder">
                                    <thead>
                                        <tr>
                                            <th colspan="7">
                                                <div class="jsFilterData"></div>
                                            </th>
                                        </tr>
                                        <tr>
                                            {{-- <th></th> --}}
                                            <th class="d-none"></th>
                                            {{-- <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th> --}}
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('proposal_code', null, ['class' => 'form-control']) !!}
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
                                                    {!! Form::text('payment_received_date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('net_premium', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('gst_amount', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('stamp_duty_charges', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('total_premium_including_stamp_duty', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('payment_received', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                        </tr>

                                        <tr>
                                            {{-- <th>{{ __('common.action') }}</th> --}}
                                            <th class="d-none"></th>
                                            {{-- <th>{{ __('premium.code') }}</th> --}}
                                            <th>{{ __('premium.proposal_code') }}</th>
                                            <th>{{ __('premium.bond_type') }}</th>
                                            <th class="text-right">{{ __('premium.bond_value') }}</th>
                                            <th>{{ __('premium.payment_received_date') }}</th>
                                            <th class="text-right">{{ __('nbi.net_premium') }}</th>
                                            <th class="text-right">{{ __('nbi.gst_amount') }}</th>
                                            <th class="text-right">{{ __('nbi.stamp_duty_charges') }}</th>
                                            <th class="text-right">{{ __('nbi.total_premium_including_stamp_duty') }}</th>
                                            <th class="text-right">{{ __('premium.payment_received') }}</th>
                                            <th>{{ __('common.status') }}</th>
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
    @include('premium.filter')
@endsection


@push('scripts')
    <script type="text/javascript">
        let bond_type = "{{ __('premium.bond_type') }}";
        //let code = "{{ __('premium.code') }}";
        let proposal_code = "{{ __('premium.proposal_code') }}";
        let bond_value = "{{ __('premium.bond_value') }}";
        let net_premium = "{{ __('nbi.net_premium') }}";
        let gst_amount = "{{ __('nbi.gst_amount') }}";
        let stamp_duty_charges = "{{ __('nbi.stamp_duty_charges') }}";
        let total_premium_including_stamp_duty = "{{ __('nbi.total_premium_including_stamp_duty') }}";
        let payment_received = "{{ __('premium.payment_received') }}";
        let status = "{{ __('common.status') }}";
        let payment_received_date = "{{ __('premium.payment_received_date') }}";
        let action = "{{ __('common.action') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#BidBondDataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    url: "{{ route('premium.index') }}",
                    data: function(d) {
                        d.proposal_code = jQuery(".datatable-form-filter input[name='proposal_code']").val();
                        d.bond_type = jQuery(".datatable-form-filter select[name='bond_type']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.payment_received = jQuery(".datatable-form-filter input[name='payment_received']").val();
                        d.net_premium = jQuery(".datatable-form-filter input[name='net_premium']").val();
                        d.gst_amount = jQuery(".datatable-form-filter input[name='gst_amount']").val();
                        d.stamp_duty_charges = jQuery(".datatable-form-filter input[name='stamp_duty_charges']").val();
                        d.total_premium_including_stamp_duty = jQuery(".datatable-form-filter input[name='total_premium_including_stamp_duty']").val();
                        d.payment_received_date = jQuery(".datatable-form-filter input[name='payment_received_date']").val();
                        d.status = jQuery(".datatable-form-filter input[name='status']").val();
                        d.filter_bond_type = jQuery("select[name='filter_bond_type']").val();
                    }
                },

                "columns": [
                    /*{
                        "name": "action",
                        "data": "action",
                        "title": action,
                        "render": null,
                        "searchable": false,
                        "orderable": false,
                    },*/
                    {
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "class": "d-none",
                    }/*,{
                        "name": "code",
                        "data": "code",
                        "title": code,
                        "orderable": true,
                        "searchable": false
                    }*/,
                    {
                        "name": "proposal_code",
                        "data": "proposal_code",
                        "title": proposal_code,
                        "class": "min-width-100",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "bond_type",
                        "data": "bond_type",
                        "title": bond_type,
                        "class": "min-width-200",
                        "orderable": true,
                        "searchable": false
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
                        "name": "payment_received_date",
                        "data": "payment_received_date",
                        "title": payment_received_date,    
                        "class": "min-width-150",                  
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "net_premium",
                        "data": "net_premium",
                        "title": net_premium,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "gst_amount",
                        "data": "gst_amount",
                        "title": gst_amount,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "stamp_duty_charges",
                        "data": "stamp_duty_charges",
                        "title": stamp_duty_charges,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "total_premium_including_stamp_duty",
                        "data": "total_premium_including_stamp_duty",
                        "title": total_premium_including_stamp_duty,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "payment_received",
                        "data": "payment_received",
                        "title": payment_received,
                        "class": "text-right min-width-200",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "status",
                        "data": "status",
                        "title": status,
                        "class": "min-width-150",
                        "orderable": true,
                        "searchable": false
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
@endpush
