<div class="modal fade" tabindex="-1" id="dms_attachment_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="font-size: 30px;">&times;</i>
                </button>
            </div>

            <div class="modal-body">
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
            </div>
        </div>
    </div>
</div>