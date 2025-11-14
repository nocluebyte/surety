@extends('app-modal')
@section('modal-title', __('cases.attachment'))
@section('modal-size', 'modal-lg')
@section('modal-content')
    <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline">
        <thead>
            <tr>
                <th width="5%">{{ __('common.no') }}</th>
                <th class="text-left">{{ __('cases.attachment') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dms_attachments as $dms_attachment)
                <tr>
                    <th width="5%">{{ $loop->iteration }}</th>
                    <th class="text-left">
                        <a href="{{ isset($dms_attachment->attachment) ? route('secure-file', encryptId($dms_attachment->attachment)) : '' }}"
                            download>{{ $dms_attachment->file_name ?? '' }}</a>
                    </th>
                </tr>
            @empty
                <tr>
                    <td  colspan="3" class="text-center">No data available in table</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @section('modal-btn', __('common.save'))
@endsection
