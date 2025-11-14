{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('title', __('country.country'))
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => __('country.country'),
        'add_modal' => collect([
            'action' => route('country.create'),
            'target' => '#commonModalID',
            'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['country.add', 'users.superadmin']),
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
                                    <div class="datatable-form-filter no-padding">{!! Form::text('filter_country', Request::get('filter_country', null), ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                    {{--
                                <div class="datatable-form-filter no-padding">{!! Form::text('filter_state',Request::get('filter_state',null),array('class' => 'form-control')) !!}</div>
                                --}}
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">{!! Form::text('filter_phone_code', Request::get('filter_phone_code', null), ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">{!! Form::text('filter_code', Request::get('filter_code', null), ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                    <div class="datatable-form-filter no-padding">{!! Form::text('mid_level', null, ['class' => 'form-control']) !!}</div>
                                </th>
                                <th>
                                </th>
                            </tr>
                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('country.country') }}</th>
                                <th>{{ __('country.no_of_state') }}</th>
                                <th>{{ __('country.phone_code') }}</th>
                                <th>{{ __('country.code') }}</th>
                                <th>{{ __('country.mid_level') }}</th>
                                <th>{{ __('common.status') }}</th>

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
        var country = "{{ __('country.country') }}";
        var state = "{{ __('country.no_of_state') }}";
        var phone_code = "{{ __('country.phone_code') }}";
        var code = "{{ __('country.code') }}";
        var mid_level = "{{ __('country.mid_level') }}";
        var status = "{{ __('common.status') }}";

        var action = "{{ __('common.action') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.name = jQuery(".datatable-form-filter input[name='filter_country']").val();
                        d.phone_code = jQuery(".datatable-form-filter input[name='filter_phone_code']")
                            .val();
                        d.code = jQuery(".datatable-form-filter input[name='filter_code']").val();
                        d.mid_level = jQuery(".datatable-form-filter input[name='mid_level']").val();
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
                }, {
                    "name": "name",
                    "data": "name",
                    "title": country,
                    "orderable": true,
                    "searchable": false,
                    "class": "min-width-100",
                }, {
                    "name": "states_count",
                    "data": "states_count",
                    "title": state,
                    "orderable": true,
                    "searchable": false,
                    "class": "min-width-100",
                }, {
                    "name": "phone_code",
                    "data": "phone_code",
                    "title": phone_code,
                    "orderable": true,
                    "searchable": false,
                    "class": "min-width-100",

                }, {
                    "name": "code",
                    "data": "code",
                    "title": code,
                    "orderable": true,
                    "searchable": false,
                    "class": "min-width-100",
                }, {
                    "name": "mid_level",
                    "data": "mid_level",
                    "title": mid_level,
                    "orderable": true,
                    "searchable": false,
                    "class": "min-width-150",
                }, {
                    "name": "is_active",
                    "data": "is_active",
                    "title": status,
                    "orderable": false,
                    "searchable": false,
                    "class": "min-width-100",

                }, ],
                "searching": false,
                //"dom": "<\"wrapper\">rtilfp",
            //     "dom": `<'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                dom: "<'table-responsive't>" +
                    "<'row page_entries'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                // "stateSave": true,
                responsive: false,
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
