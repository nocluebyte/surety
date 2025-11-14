{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('advance.advance'),
        'add_modal' => collect([
        'action' => route('advance.create'),
        'target' => '#commonModalID',
        'text' => __('common.add'),
        ]),
        'filter_modal_id' => '#advanceFilter',
        'permission' => $current_user->hasAnyAccess(['advance.add', 'users.superadmin']),
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
                            <th colspan="10"> 
                                <div class="jsFilterData"></div>
                            </th>
                        </tr>
                        <tr>
                            <!-- <th></th> -->
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_code', Request::get('filter_code',null), array('class' => 'form-control')) !!}
                                </div>
                            </th>
                            <th>
                                <div class="row col-sm-8 datatable-form-filter no-padding">{!! Form::text('filter_date',Request::get('filter_date',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="row col-sm-8 datatable-form-filter no-padding">{!! Form::text('filter_employee',Request::get('filter_employee',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="row col-sm-8 datatable-form-filter no-padding">{!! Form::text('filter_amount',Request::get('filter_amount',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            {{-- <th class="noVis">{{__('common.action')}}</th> --}}
                            <th class="noVis">{{__('loan.code')}}</th>
                            <th class="noVis">{{__('common.date')}}</th>
                            <th class="noVis">{{__('advance.employee')}}</th>
                            <th>{{__('common.amount')}}</th>
                            <th>{{__('common.status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="load-modal"></div>

@include('info')
@include('advance.filter')
@endsection

@section('scripts')
<script type="text/javascript">

    var employee_id="{{__('advance.employee')}}";
    var code = "{{__('loan.code')}}";
    var action="{{__('common.action')}}";
    var date="{{__('common.date')}}";
    var amount="{{__('common.amount')}}";
    var status="{{__('common.status')}}";

    (function (window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function (d) {
                    d.lang = jQuery(".datatable-form-filter select[name='filter_lang']").val();
                    d.code = $(".datatable-form-filter input[name='filter_code']").val();
                    d.date = jQuery(".datatable-form-filter input[name='filter_date']").val();
                    d.employee_id = jQuery(".datatable-form-filter input[name='filter_employee']").val();
                    d.amount = jQuery(".datatable-form-filter input[name='filter_amount']").val();
                    d.employeeFilter = jQuery("select[name='employeeFilter']").val();
                }
            },
            "columns": [ 
                // {
                //     "name": "action",
                //     "data": "action",
                //     "title": action,
                //     "render": null,
                //     "orderable": false,
                //     "searchable": false,                   
                //     // "width": "80px"
                // },
                {
                    "name": "code",
                    "data": "code",
                    "title": code,
                    "orderable": true,
                    "searchable": true,
                },
                {
                    "name": "advances.date",
                    "data": "date",
                    "title": date,
                    "render": null,
                    "orderable": true,
                    "searchable": false
                },{
                    "name": "employee_id",
                    "data": "employee_id",
                    "title": employee_id,
                    "orderable": true,
                    "searchable": false
                },{
                    "name": "advances.amount",
                    "data": "amount",
                    "title": amount,
                    "render": null,
                    "orderable": true,
                    "searchable": false
                },{
                    "name": "status",
                    "data": "status",
                    "title": status,
                    "render": null,
                    "orderable": false,
                    "searchable": false
                }],
            "searching": false,
            //"dom": "<\"wrapper\">rtilfp",
            "dom":`<'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            "oLanguage": {
              "sLengthMenu": "Display &nbsp;_MENU_",
            },
            "stateSave": true,
            stateSaveParams: function( settings, data ) { 
                data.employeeFilter = $('#employeeFilter').val();
            }, 
            stateLoadParams: function( settings, data ) { 
                $('#employeeFilter').val(data.employeeFilter); 
            },
            "initComplete": function(settings, json) {
                $('.jsBtnSearch').click();
            },
            responsive: true,
            colReorder: true,
            scrollY: false,
            scrollX: true,
            "buttons": [],
            "order": [[ 1, "Desc" ]],
            "pageLength":page_show_entriess,
            //dom: 'Bfrtip',//visibility
            dom: `Bfrt<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6 dataTables_pager'lp>>`,//visibility
            buttons: [//visibility
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)',
                    text: 'Column visibility',
                }
            ],
        });
    })(window, jQuery);

    $('#dataTableBuilder').on( 'column-visibility.dt', function ( e, settings, column, state ) {
        var table = $(this).DataTable();
        table.columns.adjust();
    } );//visibility

    jQuery('.btn_search').on('click', function (e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        $('.close').trigger('click');
        var fieldList = [
            'jsemployeeFilter',
        ];        
        setFilterData(fieldList);
        e.preventDefault();
    });

    jQuery(".btn_reset").on('click', function (e) {
        jQuery(".datatable-form-filter input").val("");
        jQuery(".datatable-form-filter select").val("");
        window.LaravelDataTables["dataTableBuilder"].state.clear();
        window.location.reload();
    });

    $('.employeeFilter').select2({allowClear:true});
</script>
@include('comman.datatable_filter')
@endsection