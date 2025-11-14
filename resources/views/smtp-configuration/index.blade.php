{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('title', __('smtp_configuration.smtp_configuration'))
@section('content')

@component('partials._subheader.subheader-v6', [
    'page_title' => __('smtp_configuration.smtp_configuration'),
    'add_modal' => collect([
        'action' => route('smtp-configuration.create'),
        'target' => '#commonModalID',
        'text' => __('common.add'),
    ]),
    'back_text' => __('common.back'),
    'model_back_action' => route('masterPages'),
    'permission' => $current_user->hasAnyAccess(['smtp_configuration.add', 'users.superadmin']),
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
                            <th></th>
                            <th class="d-none"></th>                            
                            <th>
                                
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_from_name',Request::get('filter_from_name',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_host_name',Request::get('filter_host_name',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_username',Request::get('filter_username',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_port',Request::get('filter_port',null),array('class' => 'form-control')) !!}</div>
                            </th>
                        </tr>
                        <tr>
                            <th>{{__('common.action')}}</th>
                            <th class="d-none"></th>
                            <th>{{__('smtp_configuration.from_name')}}</th>
                            <th>{{__('smtp_configuration.outgoing_server')}}</th>
                            <th>{{__('smtp_configuration.from_email')}}</th>
                            <th>{{__('smtp_configuration.port')}}</th>
                            <th>{{__('common.status')}}</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>
@endsection

@section('scripts')

<script type="text/javascript">
    var moduleName = "{{__('smtp_configuration.module_name')}}";
    var fromName = "{{__('smtp_configuration.from_name')}}";
    var hostName = "{{__('smtp_configuration.outgoing_server')}}";
    var username = "{{__('smtp_configuration.from_email')}}";
    var port = "{{__('smtp_configuration.port')}}";
    var status = "{{__('common.status')}}";
    var action = "{{__('common.action')}}";

    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function(d) {
                    d.filter_from_name = jQuery(".datatable-form-filter input[name='filter_from_name']").val();
                    d.filter_host_name = jQuery(".datatable-form-filter input[name='filter_host_name']").val();
                    d.filter_username = jQuery(".datatable-form-filter input[name='filter_username']").val();
                    d.filter_port = jQuery(".datatable-form-filter input[name='filter_port']").val();
                }
            },
            "columns": [{
                "name": "action",
                "data": "action",
                "title": action,
                "render": null,
                "orderable": false,
                "searchable": false,
                "width": "80px"
            }, {
                "name": "id",
                "data": "id",
                "title": "id",
                "orderable": true,
                "class": "d-none",
            },{
                "name": "from_name",
                "data": "from_name",
                "title": fromName,
                "orderable": true,
                "searchable": false
            }, {
                "name": "host_name",
                "data": "host_name",
                "title": hostName,
                "orderable": true,
                "searchable": false,
                // "class": 'text-right'

            }, {
                "name": "username",
                "data": "username",
                "title": username,
                "orderable": true,
                "searchable": false,
                // "class": "text-uppercase"
            },{
                "name": "port",
                "data": "port",
                "title": port,
                "orderable": true,
                "searchable": false,
                // "class": "text-uppercase"
            }, {
                "name": "is_active",
                "data": "is_active",
                "title": status,
                "orderable": false,
                "searchable": false,

            }, ],
            "searching": false,
            //"dom": "<\"wrapper\">rtilfp",
            // "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            dom: "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            "oLanguage": {
                "sLengthMenu": "Display &nbsp;_MENU_",
            },
            // "stateSave": true,
            responsive: true,
            colReorder: true,
            "buttons": [],
            "order": [
                [1, "desc"]
            ],
            "pageLength": page_show_entriess,
        });
    })(window, jQuery);
</script>
@include('comman.datatable_filter')
@include('info')
@endsection