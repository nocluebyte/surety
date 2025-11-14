@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
'page_title' => $title,
'permission' => true,
'back_text' => __('common.back'),
'model_back_action' => route('report.tender-wise.index'),
'filter_modal_id' => '#tender_wise_filter',
'excel_id'=> '',
'excel_link' => route('report.tender-wise-report-excel', ['checked_fields' => $checked_fields, 'selected_tender' => $selected_tender]),
'report_modal' =>'#report_modal'
])
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card" id="default">
                <div class="card-body">
                  
                    <div class="table-responsive table-report" id="scrollableDiv">
                        <table class="table table-bordered" id="tenderWiseReport" style="width: 100% !important" data-module="sticky-table1">
                            <thead class="thead-light thead table-report-head">
                                <tr>
                                    <th class="min-width-180">No.</th>
                                    @foreach ($fields as $key => $value)
                                            @if (in_array($value,$checked_fields))
                                                <th class="min-width-180">{{$key}}</th>
                                            @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="data-row">
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>

@component('components.report-modal', [
    'action'=>'report.tender-wise.show',
    'script'=>'reports.common.script',
    'fields'=>$chunk_fields,
    'checked_fields'=>$checked_fields,
    'filters'=>[
        'selected_tender' => $selected_tender,
    ],
])
@endcomponent
@include('reports.tender_wise.filter')
@endsection

@section('scripts')
<script src="{{ asset('js/custome/load-more.js') }}"></script>
<script type="text/javascript">

    let page = 1;
    let url_parameter = @json(request()->all());
    let url = {{Js::from(route('report.tender-wise.datalist'))}};

    loadMoreInit(page,url,url_parameter);

</script>
@endsection
