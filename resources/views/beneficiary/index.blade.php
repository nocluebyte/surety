@extends($theme)
@section('title', __('beneficiary.beneficiary'))
@section('content')
    @component('partials._subheader.subheader-v6', 
    $current_user->hasAnyAccess(['beneficiary.import','users.superadmin']) ? array_merge([
        'page_title' => $title,
        'action'=> route('beneficiary.create'),
        'filter_modal_id' => '#beneficiaryFilter',
        'text' => __('common.add'),
        'column_visibility' => true,
        'permission' => $current_user->hasAnyAccess(['beneficiary.add', 'users.superadmin']),
        ],[
            'import'=> route('beneficiary_import'),
            'text_import' => __('common.import'),
        ]) : [
        'page_title' => $title,
        'action'=> route('beneficiary.create'),
        'filter_modal_id' => '#beneficiaryFilter',
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['beneficiary.add', 'users.superadmin']),
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
                                        {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('beneficiary_type', ['' => ''] + $beneficiary_type ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Beneficiary Type']) !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('establishment_type', ['' => ''] + $establishment_type_id ?? [], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Establishment Type']) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('type_of_entity', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th> --}}
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
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('common.code') }}</th>
                                <th>{{ __('common.company_name') }}</th>
                                <th>{{ __('beneficiary.beneficiary_type') }}</th>
                                <th>{{ __('beneficiary.establishment_type') }}</th>
                                {{-- <th>{{ __('beneficiary.type_of_beneficiary_entity') }}</th> --}}
                                <th>{{ __('common.email') }}</th>
                                <th>{{ __('common.phone_no') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('beneficiary.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let code = "{{ __('common.code') }}";
        let company_name = "{{ __('common.company_name') }}";
        let beneficiary_type = "{{ __('beneficiary.beneficiary_type') }}";
        let establishment_type = "{{ __('beneficiary.establishment_type') }}";
        // let type_of_entity = "{{ __('beneficiary.type_of_beneficiary_entity') }}";
        let email = "{{ __('common.email') }}";
        let phone_no = "{{ __('common.phone_no') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.company_name = jQuery(".datatable-form-filter input[name='company_name']").val();
                        d.beneficiary_type = jQuery(".datatable-form-filter select[name='beneficiary_type']")
                            .val();
                        d.establishment_type = jQuery(
                            ".datatable-form-filter select[name='establishment_type']").val();
                        // d.type_of_entity = jQuery(".datatable-form-filter input[name='type_of_entity']")
                        //     .val();
                        d.email = jQuery(".datatable-form-filter input[name='email']").val();
                        d.phone_no = jQuery(".datatable-form-filter input[name='phone_no']").val();

                        d.filter_establishment_type = jQuery("select[name='filter_establishment_type']").val();
                        // d.filter_beneficiary_entity = jQuery("select[name='filter_beneficiary_entity']")
                        //     .val();
                        d.filter_beneficiary_type = jQuery("select[name='filter_beneficiary_type']")
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
                        "searchable": false,
                        "class": "min-width-100",
                    },
                    {
                        "name": "company_name",
                        "data": "company_name",
                        "title": company_name,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "beneficiary_type",
                        "data": "beneficiary_type",
                        "title": beneficiary_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "establishment_type",
                        "data": "establishment_type",
                        "title": establishment_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    // {
                    //     "name": "type_of_entity",
                    //     "data": "type_of_entity",
                    //     "title": type_of_entity,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "email",
                        "data": "email",
                        "title": email,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "phone_no",
                        "data": "phone_no",
                        "title": phone_no,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
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
                        columns: [1,2,3,4,5,6],
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
                // 'jsBeneficiaryEntity',
                'jsEstablishmentType',
                'jsBeneficiaryType',
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
