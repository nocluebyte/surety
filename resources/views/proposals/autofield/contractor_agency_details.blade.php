<div class="row jsAgencyDetails">
    <div class="form-group col-12">
        <div id="ratingDetailRepeater" style="width: 100%">
            <table class="table table-separate table-head-custom table-checkable ratingDetails" id="machine"
                data-repeater-list="ratingDetail">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th style="width: 5%">{{ __('common.no') }}</th>
                        <th style="width: 20%">{{ __('principle.agency_name') }}</th>
                        <th style="width: 15%">{{ __('principle.rating') }}</th>
                        <th style="width: 40%">{{ __('principle.remarks') }}</th>
                        <th style="width: 15%">{{ __('proposals.rating_date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($agencyData) && count($agencyData) > 0)
                        @foreach ($agencyData as $key => $item)
                            <tr data-repeater-item="" class="rating_detail_row">
                                <td class="rating-list-no">{{ ++$key }} . </td>
                                {!! Form::hidden("ratingDetail[{$key}][rating_item_id]", '') !!}
                                {!! Form::hidden("ratingDetail[{$key}][autoFetch]", 'autoFetch') !!}
                                <td>
                                    {!! Form::hidden("ratingDetail[{$key}][item_agency_id]", $item->agency_id ?? '', [
                                        'class' => 'form-control item_agency_id',
                                    ]) !!}
                                    {!! Form::hidden("ratingDetail[{$key}][item_rating_id]", $item->rating_id ?? '', [
                                        'class' => 'form-control item_rating_id',
                                    ]) !!}
                                    {!! Form::text("ratingDetail[{$key}][agency_name]", $item->agencyName->agency_name ?? '', [
                                        'class' => 'form-control agency_name form-control-solid',
                                        'readonly',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::text("ratingDetail[{$key}][rating]", $item->rating ?? '', [
                                        'class' => 'form-control rating form-control-solid',
                                        'readonly',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::textarea("ratingDetail[{$key}][rating_remarks]", $item->remarks ?? '', [
                                        'class' => 'form-control rating_remarks form-control-solid',
                                        'data-rule-Remarks' => true,
                                        'rows' => 2,
                                        'cols' => 2,
                                        'readonly',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date("ratingDetail[{$key}][rating_date]", $item->rating_date ?? '', ['class' => 'form-control rating_date form-control-solid', 'readonly']) !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>