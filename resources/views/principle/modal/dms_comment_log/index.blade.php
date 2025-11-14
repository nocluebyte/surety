@extends('app-modal')
@section('modal-title', __('cases.comment'))
@section('modal-size', 'modal-lg')
@section('modal-content')

    <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline">
        <thead>
            <tr>
                <th width="5%">{{ __('common.no') }}</th>
                <th class="text-left">{{ __('cases.comment') }}</th>
                <th class="text-left">{{ __('cases.by') }}</th>
                <th class="text-left">{{ __('common.date') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comments as $comment)
                <tr>
                    <th width="5%">{{ $loop->iteration }}</th>
                    <th>{{ $comment->comment ?? '' }}</th>
                    <th>{{ $comment->createdBy->full_name ?? '' }}</th>
                    <th>{{ custom_date_format($comment->created_at, 'd/m/Y | H:i') }}</th>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No data available in table</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @section('modal-btn', __('common.save'))
@endsection
