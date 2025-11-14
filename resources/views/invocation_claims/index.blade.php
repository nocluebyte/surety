@extends($theme)
@section('title', __('invocation_claims.invocation_claims'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('invocation_claims.invocation_claims'),
        //'text' => __('common.add'),
        //'action' => route('invocation-notification.create'),
        //'filter_modal_id' => '#bidBondFilter',
        'permission' => $current_user->hasAnyAccess(['invocation_claims.list', 'users.superadmin']),
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
                        @if ($current_user->hasAnyAccess(['bid_bond.list', 'users.superadmin']))
                            <div class="tab-pane fade active show" id="bid-bond-3" role="tabpanel"
                                aria-labelledby="bid-bond-tab-3">
                                <table class="table table-separate table-head-custom table-checkable" id="InvocationNotificationDataTable">
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
                                                    {!! Form::text('proposal', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('contractor', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('bond_type', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('bond_value', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('invocation_claim_date', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('claimed_amount', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>                                            
                                            <th>
                                                <div class="datatable-form-filter no-padding">
                                                    {!! Form::text('total_claim_approved', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </th>                                            
                                        </tr>

                                        <tr>
                                            <th class="d-none"></th>
                                            <th>{{ __('invocation_claims.code') }}</th>
                                            <th>{{ __('invocation_claims.proposal') }}</th>
                                            <th>{{ __('invocation_claims.contractor') }}</th>
                                            <th>{{ __('invocation_claims.bond_type') }}</th>
                                            <th>{{ __('invocation_claims.bond_value') }}</th>
                                            <th>{{ __('invocation_claims.invocation_claim_date') }}</th>                                            
                                            <th>{{ __('invocation_claims.claimed_amount') }}</th>
                                            <th>{{ __('invocation_claims.total_claim_approved') }}</th>                                            
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
        let code = "{{ __('invocation_claims.code') }}";
        let proposal = "{{ __('invocation_claims.proposal') }}";
        let contractor = "{{ __('invocation_claims.contractor') }}";
        let bond_type = "{{ __('invocation_claims.bond_type') }}";
        let bond_value = "{{ __('invocation_claims.bond_value') }}";
        let invocation_claim_date = "{{ __('invocation_claims.invocation_claim_date') }}";
        let claimed_amount = "{{ __('invocation_claims.claimed_amount') }}";
        let total_claim_approved = "{{ __('invocation_claims.total_claim_approved') }}";       
       

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#InvocationNotificationDataTable').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    url: "{{ route('invocation-claims.index') }}",
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.proposal = jQuery(".datatable-form-filter input[name='proposal']").val();
                        d.contractor = jQuery(".datatable-form-filter input[name='contractor']").val();
                        d.bond_type = jQuery(".datatable-form-filter input[name='bond_type']").val();
                        d.bond_value = jQuery(".datatable-form-filter input[name='bond_value']").val();
                        d.invocation_claim_date = jQuery(".datatable-form-filter input[name='invocation_claim_date']")
                            .val();
                        d.claimed_amount = jQuery(".datatable-form-filter input[name='claimed_amount']")
                            .val();
                        d.total_claim_approved = jQuery(".datatable-form-filter input[name='total_claim_approved']")
                        .val();                        
                        
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
                        "searchable": false
                    },
                    {
                        "name": "proposal",
                        "data": "proposal",
                        "title": proposal,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "contractor",
                        "data": "contractor",
                        "title": contractor,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "bond_type",
                        "data": "bond_type",
                        "title": bond_type,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "bond_value",
                        "data": "bond_value",
                        "title": bond_value,
                        "class": "text-right",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "invocation_claim_date",
                        "data": "invocation_claim_date",                       
                        "title": invocation_claim_date,
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "name": "claimed_amount",
                        "data": "claimed_amount",
                        "title": claimed_amount,
                        "orderable": false,
                        "class": "text-right",
                        "searchable": false
                    },
                    {
                        "name": "total_claim_approved",
                        "data": "total_claim_approved",
                        "title": total_claim_approved,
                        "orderable": false,
                        "searchable": false
                    }
                ],

                "searching": false,
                "dom": `<'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                responsive: true,
                colReorder: true,
                "buttons": [],
                "order": [
                    [0, "desc"]
                ],
                "pageLength": page_show_entriess,
            });
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
