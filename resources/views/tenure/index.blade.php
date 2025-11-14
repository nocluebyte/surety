{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('title', $title)

@section('content')

    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'add_modal' => collect([
            'action' => route('tenure.create'),
            'target' => '#commonModalID',
            'text' => __('common.add'),
        ]),
        'back_text' => __('common.back'),
        'model_back_action' => route('masterPages'),
        'permission' => $current_user->hasAnyAccess(['tenure.add', 'users.superadmin']),
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
                                    <div class="datatable-form-filter no-padding">{!! Form::text('filter_name', null, ['class' => 'form-control']) !!}</div>
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>{{ __('common.action') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('tenure.name') }}</th>
                                <th>{{ __('common.status') }}</th>
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
@endsection

@section('scripts')

    <script type="text/javascript">
        var name = "{{ __('tenure.name') }}";
        var status = "{{ __('common.status') }}";

        var action = "{{ __('common.action') }}";

        (function(window, $) {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.filter_name = jQuery(".datatable-form-filter input[name='filter_name']").val();
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
                    "title": name,
                    "orderable": true,
                    "searchable": false
                },{
                    "name": "is_active",
                    "data": "is_active",
                    "title": status,
                    "orderable": false,
                    "searchable": false,

                }, ],
                "searching": false,
                //"dom": "<\"wrapper\">rtilfp",
                "dom": `<'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                "oLanguage": {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                "stateSave": true,
                responsive: true,
                colReorder: true,
                scroll: true,
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
