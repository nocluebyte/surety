{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('title', $title)
@section('content')
@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
    'add_modal' => collect([
        'action' => route('currency.create'),
        'target' => '#commonModalID',
        'text' => __('common.add'),
    ]),
    'back_text' => __('common.back'),
    'model_back_action' => route('masterPages'),
    'permission' => $current_user->hasAnyAccess(['currency.add', 'users.superadmin']),
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
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_name', null, ['class' => 'form-control jsFilterName']) !!}
                                </div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_short_name', null, ['class' => 'form-control jsFilterShortName']) !!}
                                </div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::text('filter_symbol', null, ['class' => 'form-control jsFilterSymbol']) !!}
                                </div>
                            </th>
                            <th>
                                <div class="datatable-form-filter no-padding">
                                    {!! Form::select('filter_status',[''=>'','Yes'=>'Yes','No'=>'No'], null, ['class' => 'form-control jsFilterStatus','data-placeholder' => 'Select Status']) !!}
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>{{ __('common.action') }}</th>
                            <th>{{ __('currency.name') }}</th>
                            <th>{{ __('currency.short_name') }}</th>
                            <th>{{ __('currency.symbol') }}</th>
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
        var action = "{{ __('common.action') }}";
        var name = "{{ __('currency.name') }}";
        var shortName = "{{ __('currency.short_name') }}";
        var symbol = "{{ __('currency.symbol') }}";
        var status = "{{ __('common.status') }}";

        (function(window, $) {
            $('.jsFilterStatus').select2({allowClear:true});
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    data: function(d) {
                        d.name = $('.jsFilterName').val();
                        d.short_name = $('.jsFilterShortName').val();
                        d.symbol = $('.jsFilterSymbol').val();
                        d.status = $('.jsFilterStatus').val();
                    }
                },
                "columns": [{
                    "name": "action",
                    "data": "action",
                    "title": action,
                    "render": null,
                    "orderable": false,
                    "searchable": false,
                }, {
                    "name": "name",
                    "data": "name",
                    "title": name,
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "short_name",
                    "data": "short_name",
                    "title": shortName,
                    "orderable": true,
                    "searchable": true,
                }, {
                    "name": "symbol",
                    "data": "symbol",
                    "title": symbol,
                    "orderable": true,
                    "searchable": true,

                }, {
                    "name": "is_active",
                    "data": "is_active",
                    "title": status,
                    "orderable": false,
                    "searchable": false,

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
