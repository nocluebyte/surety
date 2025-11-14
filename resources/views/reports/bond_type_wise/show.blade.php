@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
'page_title' => $title,
'permission' => true,
'back_text' => __('common.back'),
'model_back_action' => route('report.bond-type-wise.index'),
'filter_modal_id' => '#bond_type_wise_filter',
'excel_id'=> '',
'excel_link' => route('report.bond-type-wise-report-excel', ['checked_fields' => $checked_fields, 'selected_bond_type' => $selected_bond_type]),
'report_modal' =>'#report_modal'
])
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card" id="default">
                <div class="card-body">
                  
                    <div class="table-responsive table-report" id="scrollableDiv">
                        <table class="table table-bordered" id="buyerWiseReport" style="width: 100% !important" data-module="sticky-table1">
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
    'action'=>'report.bond-type-wise.show',
    'script'=>'reports.common.script',
    'fields'=>$chunk_fields,
    'checked_fields'=>$checked_fields,
    'filters'=>[
        'selected_bond_type' => $selected_bond_type,
        'selected_bond_status'=>$selected_bond_status
    ],
])
@endcomponent
@include('reports.bond_type_wise.filter')
@endsection

@section('scripts')
<script src="{{ asset('js/custome/load-more.js') }}"></script>
<script type="text/javascript">

    let page = 1;
    let url_parameter = @json(request()->all());
    let url = {{Js::from(route('report.bond-type-wise.datalist'))}};

    loadMoreInit(page,url,url_parameter);

</script>
@endsection
