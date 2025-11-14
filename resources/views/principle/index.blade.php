@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', 
        $current_user->hasAnyAccess(['principle.import','users.superadmin']) ? array_merge([
        'page_title' => $title,
        'action'=> route('principle.create'),
        'filter_modal_id' => '#principleFilter',
        'text' => __('common.add'),
        'column_visibility' => true,
        'permission' => $current_user->hasAnyAccess(['principle.add', 'users.superadmin']),
        ],[
            'import'=> route('principle_import'),
            'text_import' => __('common.import'),
        ]) : [
        'page_title' => $title,
        'action'=> route('principle.create'),
        'filter_modal_id' => '#principleFilter',
        'text' => __('common.add'),
        'permission' => $current_user->hasAnyAccess(['principle.add', 'users.superadmin']),
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
                                        {!! Form::text('name', Request::get('name', null), ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                {{-- <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
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
                                <th>
                                    <div class="datatable-form-filter no-padding">
                                        {!! Form::select('venture_type', ['' => '', 'JV' => 'JV', 'SPV' => 'SPV', 'Stand Alone' => 'Stand Alone'], null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select Venture Type']) !!}
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th class="d-none"></th>
                                <th>{{ __('common.code') }}</th>
                                <th>{{ __('common.company_name') }}</th>
                                <th>{{ __('principle.principle_type') }}</th>
                                {{-- <th>{{ __('common.full_name') }}</th> --}}
                                <th>{{ __('common.email') }}</th>
                                <th>{{ __('common.phone_no') }}</th>
                                <th>{{ __('principle.venture_type') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('principle.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let code = "{{ __('common.code') }}";
        let company_name = "{{ __('common.company_name') }}";
        let principle_type = "{{ __('principle.principle_type') }}";
        // let full_name = "{{ __('common.full_name') }}";
        let email = "{{ __('common.email') }}";
        let phone_no = "{{ __('common.phone_no') }}";
        let venture_type = "{{ __('principle.venture_type') }}";
        let action = "{{ __('common.action') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.name = jQuery(
                            ".datatable-form-filter input[name='name']").val();
                        d.company_name = jQuery(".datatable-form-filter input[name='company_name']").val();
                        // d.full_name = jQuery(".datatable-form-filter input[name='full_name']").val();
                        d.email = jQuery(".datatable-form-filter input[name='email']").val();
                        d.phone_no = jQuery(".datatable-form-filter input[name='phone_no']").val();
                        d.venture_type = jQuery(".datatable-form-filter select[name='venture_type']").val();

                        d.filter_principle_types = jQuery("select[name='filter_principle_types']").val();
                        d.filter_venture_type = jQuery("select[name='filter_venture_type']").val();
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
                        "name": "principle_types.name",
                        "data": "name",
                        "title": principle_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    // {
                    //     "name": "full_name",
                    //     "data": "full_name",
                    //     "title": full_name,
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
                    {
                        "name": "venture_type",
                        "data": "venture_type",
                        "title": venture_type,
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
                'jsFilterPrincipleType',
                'jsIsJv',
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
