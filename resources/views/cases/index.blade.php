@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'action' => route('beneficiary.create'),
        'text' => __('common.add'),
        // 'back_text' => __('common.back'),
        // 'model_back_action' => route('masterPages'),
        'filter_modal_id' => '#casesFilter',
        'column_visibility' => true,
    ])
    @endcomponent
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6">
                            <div class="card-toolbar">
                                <span class="svg-icon ml-5" style="float:right;">
                                    {{ Form::button('Transfer', ['class' => 'form-control btn btn-primary assign_underwriter', 'data-table'=>'dataTableBuilder','data-url'=>route('cases.assignUnderwriter'),'disabled' => true]) }}
                                </span>
                                <span class="svg-icon" style="float:right;">
                                    {{ Form::select('underwriter_id', ['' => 'Select'] + $underwriter, null, ['class' => 'form-control underwriter', 'data-placeholder' => 'Select underwriter']) }}
                                    <span class="underwriter_id-error text-danger d-none">This field is required</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
                            <thead>
                                <tr>
                                    <th colspan="7">
                                        <div class="jsFilterData"></div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        @if($current_user->hasAnyAccess('users.superadmin', 'cases.delete'))
                                            <button type="button" data-url="{{ route('cases.caseCancel') }}"
                                                data-table="dataTableBuilder" name="cancelCases" class="btn btn-danger cancelCases"
                                                disabled>Cancel</button>
                                        @endif
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('beneficiary_name', Request::get('beneficiary_name', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>
                                    <th></th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('type', Request::get('type', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>
                                    {{-- <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('status', Request::get('status', null), [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </th> --}}
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('category', Request::get('category', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('company_name', Request::get('company_name', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('underwriter', Request::get('underwriter', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('underwriter_assigned_date', Request::get('underwriter_assigned_date', null), [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">
                                            {!! Form::text('date', Request::get('date', null), ['class' => 'form-control']) !!}
                                        </div>
                                    </th>

                                </tr>

                                <tr>
                                    <th>{{ __('common.action') }}</th>
                                    <th>{{ __('cases.beneficiary_name') }}</th>
                                    <th>{{ __('cases.dms') }}</th>
                                    <th>{{ __('cases.generated_from') }}</th>
                                    {{-- <th>{{ __('cases.status') }}</th> --}}
                                    <th>{{ __('cases.case_type') }}</th>
                                    <th>{{ __('cases.contractor_name') }}</th>
                                    <th>{{__('cases.underwriter')}}</th>
                                    <th>{{ __('cases.underwriter_assigned_date') }}</th>
                                    <th>{{ __('common.date') }}</th>
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
    @include('cases.filter')
@endsection

@section('scripts')
    <script type="text/javascript">
        let action = "{{ __('common.action') }}";
        let beneficiary_name = "{{ __('cases.beneficiary_name') }}";
        let contractor_name = "{{ __('cases.contractor_name') }}";
        // let status = "{{ __('cases.status') }}";
        let case_type = "{{ __('cases.case_type') }}";
        let underwriter = "{{__('cases.underwriter')}}";
        let underwriter_assigned_date = "{{ __('cases.underwriter_assigned_date') }}";
        let generated_from = "{{ __('cases.generated_from') }}";
        let date = "{{ __('common.date') }}";
        let dms = "{{ __('cases.dms') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables['dataTableBuilder'] = $('#dataTableBuilder').DataTable({
                "serverSide": true,
                "processing": true,

                "ajax": {
                    data: function(d) {
                        d.company_name = jQuery(".datatable-form-filter input[name='company_name']").val();
                        d.beneficiary_name = jQuery(".datatable-form-filter input[name='beneficiary_name']").val();
                        d.type = jQuery(".datatable-form-filter input[name='type']").val();
                        // d.status = jQuery(".datatable-form-filter input[name='status']")
                        //     .val();
                        d.category = jQuery(".datatable-form-filter input[name='category']").val();
                        d.underwriter = jQuery(
                            ".datatable-form-filter input[name='underwriter']").val();
                        d.underwriter_assigned_date = jQuery(
                            ".datatable-form-filter input[name='underwriter_assigned_date']").val();
                        d.date = jQuery(".datatable-form-filter input[name='date']").val();

                        d.filter_underwriter = jQuery("select[name='filter_underwriter']").val();
                        // d.filter_contractor = jQuery("select[name='filter_contractor']").val();
                        d.filter_case_type = jQuery("select[name='filter_case_type']").val();
                        d.filter_generated_from = jQuery("select[name='filter_generated_from']").val();
                    }
                },

                "columns": [{
                        "name": "action",
                        "data": "action",
                        "title": action,
                        "render": null,
                        "searchable": false,
                        "orderable": false,
                        "width": "80px",
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
                        "name": "dms",
                        "data": "dms",
                        "title": dms,
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "name": "generated_from",
                        "data": "generated_from",
                        "title": generated_from,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-200",
                    },
                    // {
                    //     "name": "status",
                    //     "data": "status",
                    //     "title": status,
                    //     "orderable": true,
                    //     "searchable": false
                    // },
                    {
                        "name": "case_type",
                        "data": "case_type",
                        "title": case_type,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-150",
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
                        "name": "underwriter",
                        "data": "underwriter",
                        "title": underwriter,
                        "orderable": true,
                        "searchable": false,
                        "class": "min-width-300",
                    },
                    {
                        "name": "underwriter_assigned_date",
                        "data": "underwriter_assigned_date",
                        "title": underwriter_assigned_date,
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
                        columns: [1,2,3,4,5,6,7,8],
                        text: colVisIcon,
                    }
                ],
                "order": [
                    [8, "desc"]
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
                'jsUnderwriter',
                // 'jsFilterContractor',
                'jsFilterCaseType',
                'jsFilterGeneratedFrom',
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


        $('.underwriter').select2({
            allowClear: true
        });

        $(document).on('click', '.cancelCases', function(e) {
            e.preventDefault();

            let el = $(this);
            let url = el.data('url');
            let refresh = '#' + el.data().table;

            let checkedArray = [];


            $('.checkRow:checked').each(function() {
                const val = $(this).val();
                checkedArray.push(val);
            });


            message.fire({
                title: 'Are you sure',
                text: "You want to delete this ?",
                type: 'warning',
                customClass: {
                    confirmButton: 'btn btn-success shadow-sm mr-2',
                    cancelButton: 'btn btn-danger shadow-sm'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        cache: false,
                        data: {
                            checked: checkedArray,
                        },
                        success: function({
                            success
                        }) {

                            toastr.success(success, "Success");
                        },
                        error: function({
                            error
                        }) {
                            toastr.error(error, "Error");
                        }
                    }).always(function(){
                        toggleAttribute();
                    })
                    $(refresh).DataTable().ajax.reload();
                }
            });
        });


        $(document).on('click', '.assign_underwriter', function(e) {
            e.preventDefault();

            let el = $(this);
            let url = el.data('url');
            let refresh = '#' + el.data().table;
            let underwriter = $('.underwriter').val();
            let underwriter_error_message = $('.underwriter_id-error');

            let checkedArray = [];


            $('.checkRow:checked').each(function() {
                const val = $(this).val();
                checkedArray.push(val);
            });
            


            if (underwriter) {
                
                underwriter_error_message.addClass('d-none');

                message.fire({
                    title: 'Are you sure',
                    text: "Are You Sure You Want to Transfer this case?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes Transefer it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        
                        $.ajax({
                            type: "POST",
                            url: url,
                            cache: false,
                            data: {
                                checked:checkedArray,
                                underwriter_id:underwriter
                            },
                            success:function({success}){

                                toastr.success(success, "Success");
                            },
                            error:function({error}){
                                toastr.error(error, "Error");
                            }
                        }).always(function(){
                            toggleAttribute();
                        })
                        $(refresh).DataTable().ajax.reload();
                    }
                });
            } else {
                underwriter_error_message.removeClass('d-none');
            }
        });

        $(document).on('change', '.checkRow', function() {
            toggleAttribute();
        })

        //helping custome method

        let toggleAttribute = () => {
            let rows = $('.checkRow:checked');
            let cancelButton = $('.cancelCases');
            let assignUnderwriterButton = $('.assign_underwriter');

            // Enable or disable button depending on the length of checked rows
            if (rows.length > 0) {
                cancelButton.prop('disabled', false);
                assignUnderwriterButton.prop('disabled', false);
            } else {
                cancelButton.prop('disabled', true);
                assignUnderwriterButton.prop('disabled', true);
            }
        };
        


    </script>
    @include('comman.datatable_filter')
    @include('info')
@endsection
<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
