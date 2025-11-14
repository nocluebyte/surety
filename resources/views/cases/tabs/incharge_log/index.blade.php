<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>{{ __('cases.underwriter') }}</th>
            <th>{{ __('cases.allocated_by') }}</th>
            <th>{{ __('common.date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($getUnderwriterLog as $key => $data)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $data->underwriter_user_name ?? '' }}</td>
                <td>{{ $data->create_by->full_name ?? '' }}</td>
                <td>{{ date('d/m/Y | H:i', strtotime($data->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
