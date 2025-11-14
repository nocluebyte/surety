<table class="table table-responsive">
   <thead>
    <tr>
        <td class="min-width-100">Code</td>
        <td class="min-width-300">Contractor Name</td>
        <td class="min-width-300">Beneficiary Name</td>
        <td class="min-width-300">Project Name</td>
        <td class="min-width-300">Tender Name</td>
        <td class="min-width-200">Type of Bond</td>
        <td class="text-right min-width-200">Bond Amount{{ $currencySymbol }}</span></td>
        <td class="min-width-150">Bond Start Date</td>
        <td class="min-width-150">Bond End Date</td>
        <td class="min-width-150">Bond - Conditional or Unconditional</td>
        <td class="min-width-150">Invocation Date</td>
        <td class="min-width-300">Reason for Invocation</td>
    </tr>
   </thead>
   <tbody>
    @if (isset($invocationData->invocationNotificationHistory) && $invocationData->invocationNotificationHistory->count() > 0)
      @foreach ($invocationData->invocationNotificationHistory as $log)
        <tr>
            <td>{{ $log->code ?? '' }}</td>
            <td>{{$log->proposal->contractor_company_name ?? ''}}</td>
            <td>{{$log->proposal->beneficiary_company_name ?? ''}}</td>
            <td>{{$log->proposal->pd_project_name ?? ''}}</td>
            <td>{{$log->proposal->tender_header ?? ''}}</td>
            <td>{{$log->bondType->bond_type ?? ''}}</td>
            <td class="text-right">{{numberFormatPrecision($log->invocation_amount,0)}}</td>
            <td>{{ isset($log->bond_start_date) ? custom_date_format($log->bond_start_date,'d/m/Y') : ''}}</td>
            <td>{{ isset($log->bond_start_date) ? custom_date_format($log->bond_end_date,'d/m/Y') : ''}}</td>
            <td>{{$log->bond_conditionality ?? ''}}</td>
            <td>{{ isset($log->invocation_date) ? custom_date_format($log->invocation_date,'d/m/Y') : ''}}</td>
            <td>{{$log->reason_for_invocation ?? ''}}</td>
        </tr>
      @endforeach
    @else
        <tr>
            <td class="text-center" colspan="11">{{__('common.no_records_found')}}</td>
        </tr>
    @endif
   </tbody>
</table>