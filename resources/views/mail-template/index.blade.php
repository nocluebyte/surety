{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('title', __('mail_template.mail_template'))
@section('content')

@component('partials._subheader.subheader-v6', [
    'page_title' => __('mail_template.mail_template'),
    'add_modal' => collect([
        'action' => route('mail-template.create'),
        'target' => '#commonModalID',
        'text' => __('common.add'),
    ]),
    'back_text' => __('common.back'),
    'model_back_action' => route('masterPages'),
    'permission' => $current_user->hasAnyAccess(['mail_template.add', 'users.superadmin']),
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
                                <div class="datatable-form-filter no-padding">{!! Form::text('module_name',Request::get('module_name',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            {{-- <th>
                                <div class="datatable-form-filter no-padding">{!! Form::text('send_time',Request::get('send_time',null),array('class' => 'form-control')) !!}</div>
                            </th> --}}
                            <th>

                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_smtp',Request::get('filter_smtp',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_subject',Request::get('filter_subject',null),array('class' => 'form-control')) !!}</div>
                            </th>
                        </tr>
                        <tr>
                            <th>{{__('common.action')}}</th>
                            <th class="d-none"></th>
                            <th>{{__('mail_template.module_name')}}</th>
                            {{-- <th>{{__('mail_template.time')}}</th> --}}
                            <th>{{__('mail_template.email')}}</th>
                            <th>{{__('mail_template.subject')}}</th>
                            <th>{{__('common.status')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
    var moduleName = "{{__('mail_template.module_name')}}";
    // var sendTime = "{{__('mail_template.time')}}";
    var smtp = "{{__('mail_template.email')}}";
    var subject = "{{__('mail_template.subject')}}";
    var message_body = "{{__('mail_template.message_body')}}";
    var status = "{{__('common.status')}}";
    var action = "{{__('common.action')}}";

    (function(window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function(d) {
                    d.module_name = jQuery(".datatable-form-filter input[name='module_name']").val();
                    // d.send_time = jQuery(".datatable-form-filter input[name='send_time']").val();
                    d.filter_smtp = jQuery(".datatable-form-filter input[name='filter_smtp']").val();
                    d.filter_subject = jQuery(".datatable-form-filter input[name='filter_subject']").val();
                }
            },
            "columns": [
                {
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
                    "name": "module_name",
                    "data": "module_name",
                    "title": moduleName,
                    "orderable": true,
                    "searchable": false,
                    "class": 'text-capitalize'
                },
                // {
                //     "name": "send_time",
                //     "data": "send_time",
                //     "title": sendTime,
                //     "orderable": true,
                //     "searchable": false,
                // },
                {
                    "name": "username",
                    "data": "username",
                    "title": smtp,
                    "orderable": true,
                    "searchable": false
                }, {
                    "name": "subject",
                    "data": "subject",
                    "title": subject,
                    "orderable": true,
                    "searchable": false,
                    // "class": 'text-right'

                },{
                    "name": "is_active",
                    "data": "is_active",
                    "title": status,
                    "orderable": false,
                    "searchable": false,

                }
            ],
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
<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
