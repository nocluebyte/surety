<table class="table">
    <thead>
        <tr>
            <th>{{__('common.sr_no')}}</th>
            <th>{{__('common.date')}}</th>
            <th>{{__('invocation_notification.claim_examiner')}}</th>
            <th>{{__('common.created_by')}}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($invocationData->claimExaminerLog) && $invocationData->claimExaminerLog->count() > 0)
            @foreach ($invocationData->claimExaminerLog as $log)
                 <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{custom_date_format($log->created_at,'d/m/Y | H:i')}}</td>
                    <td>{{$log->claimExaminerUserName ?? ''}}</td>
                    <td>{{$log->createdBy->full_name ?? ''}}</td>
                 </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="4">{{__('common.no_records_found')}}</td>
            </tr>
        @endif
    </tbody>
</table>