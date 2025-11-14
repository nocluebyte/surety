@if (isset($agencyData))
    @foreach ($agencyData as $index => $item)
        <div class="col-3 form-group">
            {!! Form::hidden('agency[][ard_id]', null) !!}
            {!! Form::hidden("agency[{$index}][rating_id]", $item->id ?? '') !!}
            {!! Form::hidden("agency[{$index}][autoFetch]", 'autoFetch') !!}
            {!! Form::label('agency_rating', __('principle.agency_rating')) !!}
            {!! Form::text("agency[$index][agency_rating]", $item->rating ?? null, ['class' => 'form-control agency_rating form-control-solid', 'readonly',]) !!}
        </div>

        <div class="col-9 form-group">
            {!! Form::label('rating_remarks', __('principle.remarks')) !!}
            {!! Form::textarea("agency[$index][rating_remarks]", $item->remarks ?? null, [
                'class' => 'form-control rating_remarks form-control-solid',
                'data-rule-Remarks' => true,
                'rows' => 2,
                'cols' => 2,
                'readonly',
            ]) !!}
        </div>
    @endforeach
@endif
