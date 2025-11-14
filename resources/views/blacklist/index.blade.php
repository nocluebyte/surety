@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'action' => route('blacklist.create'),
        'text' => __('common.add'),
        'filter_modal_id' => '#blacklistFilter',
        'permission' => $current_user->hasAnyAccess(['blacklist.add', 'users.superadmin']),
        'column_visibility' => true,
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
                                {{-- <th></th> --}}
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
                                        {!! Form::text('source', null, ['class' => 'form-control']) !!}
                                    </div>
                                </th>
                                <th>
                                    {{-- <div class="datatable-form-filter no-padding">
                                        {!! Form::text('blacklist_date', null, ['class' => 'form-control']) !!}
                                    </div> --}}
                                </th>
                                <th></th>
                            </tr>

                            <tr>
                                {{-- <th>{{ __('common.action') }}</th> --}}
                                <th class="d-none"></th>
                                <th>{{ __('blacklist.code') }}</th>
                                <th>{{ __('blacklist.company_name') }}</th>
                                <th>{{ __('blacklist.source') }}</th>
                                <th>{{ __('common.date') }}</th>
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
    @include('blacklist.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let code = "{{ __('blacklist.code') }}";
        let company_name = "{{ __('blacklist.company_name') }}";
        let source = "{{ __('blacklist.source') }}";
        let blacklist_date = "{{ __('common.date') }}";
        let action = "{{ __('common.action') }}";
        let status = "{{ __('common.status') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.code = jQuery(".datatable-form-filter input[name='code']").val();
                        d.company_name = jQuery(".datatable-form-filter input[name='company_name']").val();
                        d.source = jQuery(".datatable-form-filter input[name='source']").val();
                        d.blacklist_date = jQuery(".datatable-form-filter input[name='blacklist_date']").val();
                        d.filter_status = jQuery("select[name='filter_status']").val();
                        d.filter_created_date = $('.jsCreatedDate').val();
                    }
                },

                "columns": [
                    // {
                    //     "name": "action",
                    //     "data": "action",
                    //     "title": action,
                    //     "render": null,
                    //     "searchable": false,
                    //     "orderable": false,
                    //     "width": "80px",
                    // },
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
                        "searchable": false
                    },
                    {
                        "name": "company_name",
                        "data": "company_name",
                        "title": company_name,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "source",
                        "data": "source",
                        "title": source,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "blacklist_date",
                        "data": "blacklist_date",
                        "title": blacklist_date,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
                    },
                    {
                        "name": "is_active",
                        "data": "is_active",
                        "title": status,
                        "orderable": false,
                        "searchable": false,
                        "class": "jsIsActive",
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
                responsive: true,
                colReorder: true,
                "buttons": [
                    {
                        extend: 'colvis',
                        columns: [1,2,3,4,5],
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
                'jsCreatedDate',
                'jsStatus',
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

        $(document).on('click', '.jsIsActive', function() {
            let info = $(this).find('.change-inactive-status').val();
            
            if($(this).find('.change-inactive-status').attr('checked') !== undefined) {
                message.fire({
                    title: "Reason",
                    input: "textarea",
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary shadow-sm',
                        cancelButton: 'btn btn-light-primary shadow-sm',
                    },
                    confirmButtonText: "Save",
					allowOutsideClick: false,
					allowEscapeKey: false,
                    keydownListenerCapture: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return "This field is required!";
                        }
                    },
                    // onOpen: function () {
                    //     $('.swal2-select').select2({
                    //         dropdownParent: $('.swal2-container'),
                    //         placeholder:'Select Rejection Reasons',
                    //         allowClear:true
                    //     });
                    // },
                    }).then((result) => {
						if(result.dismiss && result.dismiss == 'cancel') {
                            $.ajax({
                                type:'POST',
                                url:"{{ route('common.change-inactive-status', '__id__') }}".replace('__id__', info),
                                // 'cache': false,
                                data:{
                                    'id': info,
                                    'status': 'true',
                                    'table': 'blacklists'
                                },
                            }).done(function(res){
                                location.reload();
                            })
						} else {
                            $.ajax({
                                type:'GET',
                                url:"{{ route('blacklistInactiveReason', '__id__') }}".replace('__id__', info),
                                // 'cache': false,
                                data:{
                                    'id':info,
                                    'reason':result.value,
                                },
                            }).done(function(res){
                                location.reload();
                            }).fail(function(respons){
                                var res = respons.responseJSON;
                                var msg = 'something went wrong please try again !';
                                if (res.errormessage) {
                                    toastr.warning(res.errormessage, "Warning");
                                }
                                toastr.error(msg, "Error");
                            });
						}
                });
            }
        });
    </script>
    @include('comman.datatable_filter')
    @include('info')
@endsection
