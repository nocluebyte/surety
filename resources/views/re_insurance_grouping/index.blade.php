{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', __('re_insurance_grouping.re_insurance_grouping') )

@component('partials._subheader.subheader-v6',
[
'page_title' => __('re_insurance_grouping.re_insurance_grouping'),

'add_modal' => collect([
'action'=> route('re-insurance-grouping.create'),
'target' => '#commonModalID',
'text' => __('common.add'),
]),
'back_text' => __('common.back'),
'model_back_action' => route('masterPages'),
'permission' => $current_user->hasAnyAccess(['re_insurance_grouping.add', 'users.superadmin']),
])
@endcomponent


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        @include('components.error')

            <div class="card" id="default">
                <div class="card-body">
                    <div class="table">
                        <table  class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline" id="dataTableBuilder">
                            <thead>
                            <tr>

                                    <th></th>
                                    <th>
                                        <div class="datatable-form-filter no-padding">{!! Form::text('name',Request::get('name',null),array('class' => 'form-control')) !!}</div>
                                    </th>
                                </tr>
                                <tr>
                            
                                    <th>{{__('common.action')}}</th>
                                    <th>{{__('re_insurance_grouping.name')}}</th>
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
    </div>
</div>
<div id="load-modal"></div>
@include('info')

@endsection

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script type="text/javascript">
    var name = "{{__('re_insurance_grouping.name')}}";
    var action = "{{__('common.action')}}";
    var is_active = "{{__('common.status')}}";

    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function(d) {
                    d.name = jQuery(".datatable-form-filter input[name='name']").val();
                }
            },
            "columns": [{
                "name": "action",
                "data": "action",
                "title": action,
                "render": null,
                "orderable": false,
                "searchable": false,
                // "width": "80px"
            }, {
                "name": "name",
                "data": "name",
                "title": name,
                "orderable": true,
                "searchable": false,

            },{
                "name": "is_active",
                "data": "is_active",
                "title": is_active,
                "width": "100px",
                "orderable": false,
                "searchable": false
            }],
            "searching": false,
            //"dom": "<\"wrapper\">rtilfp",
            // "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            dom: "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            "oLanguage": {
                "sLengthMenu": "Display &nbsp;_MENU_",
            },
            "stateSave": true,
            responsive: true,
            colReorder: true,
            // scrollY: false,
            // scrollX: true,
            "buttons": [],
            "order": [
                [1, "desc"]
            ],
            "pageLength": page_show_entriess,
        });
    })(window, jQuery);
</script>
@include('comman.datatable_filter')
@endsection