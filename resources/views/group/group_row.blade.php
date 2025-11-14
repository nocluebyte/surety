@foreach ($contractor as $item)
    <tr class="groupRow">
        <td>{{ $item->company_name }}
        </td>
        <td>{{ $item->country->name }}</td>
        <td>
            {{ Form::select('contractorids[' . $item->id . '][type]', ['' => 'Select'] + $type, null, [
                'class' => 'form-control required type',
                'style' => 'width: 100%;',
                'data-placeholder' => 'Select',
            ]) }}
        </td>
        <td>-</td>
        <td>{{ Form::date('contractorids[' . $item->id . '][from_date]', null, ['class' => 'form-control required from_date']) }}
        </td>
        <td>{{ Form::date('contractorids[' . $item->id . '][till_date]', null, ['class' => 'form-control till_date minDate']) }}
        </td>
        <td>{{ Form::button('<i class="flaticon-delete"></i>', ['class' => 'btn btn-sm btn-icon btn-danger mr-2 jsDeleteGroup', 'data-contractorId' => $item->id]) }}</td>
    </tr>
@endforeach

@section('scripts')
    @include('group.script')
@endsection
