{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('section.section'),
        'add_modal' => collect([
        'action' => route('section.create'),
        'target' => '#commonModalID',
        'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['section.add', 'users.superadmin']),
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
                                <div class="col-sm-8 datatable-form-filter no-padding">{!! Form::text('filter_name',Request::get('filter_name',null),array('class' => 'form-control')) !!}</div>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>{{__('common.action')}}</th>
                            <th class="d-none"></th>
                            <th>{{__('section.name')}}</th>
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
@endsection

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script type="text/javascript">

    var name="{{__('section.name')}}";
    var action="{{__('common.action')}}";
    var is_active="{{__('common.status')}}";

    (function (window, $) {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                data: function (d) {
                    d.lang = jQuery(".datatable-form-filter select[name='filter_lang']").val();
                    d.name = jQuery(".datatable-form-filter input[name='filter_name']").val();
                }
            },
            "columns": [ {
                    "name": "action",
                    "data": "action",
                    "title": action,
                    "render": null,
                    "orderable": false,
                    "searchable": false,
                    // "width": "80px"
                }, {
                    "name": "id",
                    "data": "id",
                    "title": "id",
                    "orderable": true,
                    "class": "d-none",
                },{
                    "name": "name",
                    "data": "name",
                    "title": name,
                    "orderable": true,
                    "searchable": false
                },{
                    "name": "is_active",
                    "data": "is_active",
                    "title": is_active,
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
            responsive: true,
            colReorder: true,
            scrollY: false,
            scrollX: true,
            "buttons": [],
            "order": [[ 1, "desc" ]],
            "pageLength":page_show_entriess,
        });
    })(window, jQuery);
</script>
@include('comman.datatable_filter')
@endsection