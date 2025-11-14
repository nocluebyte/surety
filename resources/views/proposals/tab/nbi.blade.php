<div class="pt-5 pr-15 pl-15">
<table class="table table-responsive table-separate table-head-custom table-checkable">
	<thead>
        <tr>
            <th>{{ __('common.no') }}</th>
            <th class="min-width-100">{{ __('nbi.policy_no')}}</th>
            <th class="min-width-300">{{ __('nbi.insured_name_principal_debtor') }}</th>
            <th class="min-width-300">{{ __('nbi.beneficiary_name') }}</th>
            <th class="min-width-150">{{ __('nbi.bond_type') }}</th>
            <th class="min-width-100">{{ __('nbi.rate') }}</th>
            <th class="text-center min-width-200">{{ __('nbi.date_time') }}</th>
            <th class="text-center min-width-200">{{ __('nbi.status') }}</th>
        </tr>
    </thead>
    <tbody>
    	@if($nbis->count() > 0)
    		@foreach($nbis as $n => $nbi_row)
                @php
                $nbi_status = $nbi_row->status;
                $nbi_id = $nbi_row->id;
                @endphp
    			<tr>
    				<td>{{ $loop->index + 1 }}</td>
    				<td>
                        @if($current_user->hasAnyAccess('users.superadmin', 'nbi.view'))
                            <a href="{{ route('nbi.show', encryptId($nbi_id)) }}" target="_blank">{{ $nbi_row->policy_no ?? '-' }}</a>
                        @else
                            {{ $nbi_row->policy_no ?? '-' }}
                        @endif
                    </td>
                    <td>{{ $nbi_row->contractor->company_name ?? '' }}</td>
                    <td>{{ $nbi_row->beneficiary->company_name ?? '' }}</td>
                    <td>{{ $nbi_row->bondType->name ?? '' }}</td>
                    <td>{{ $nbi_row->rate ?? '' }}</td>
    				<td class="text-center">{{ custom_date_format($nbi_row->created_at,'d/m/Y | H:i') }}</td>
    				<td class="text-center">
    					@if($nbi_status == 'Approved')
                            {{-- <a href="{{route('nbi.edit',$nbi_id)}}" class="btn btn-primary btn-sm"><span class="navi-text">{{$nbi_status}}</span></a> --}}
                            <span class="label label-lg label-light-success font-weight-bolder label-inline">{{$nbi_status}}</span>
                            @if($proposals->is_checklist_approved == 0)
                                <span class="ml-3">
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm jsTerminateProposal" data-id="{{$nbi_id}}">
                                        <span class="navi-text">Cancel</span>
                                    </a>
                                </span>
                            @endif
                        @elseif($nbi_status == 'Agreed')
                            <span class="label label-lg label-light-success font-weight-bolder label-inline">{{$nbi_status}}</span>
                        @elseif($nbi_status == 'Pending' && $proposals->status == 'Approved')
                            @if ($proposals->is_amendment == 0 && $current_user->hasAnyAccess('users.superadmin', 'nbi.status'))
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm jsProposalNbiPendingBtn" data-id="{{$nbi_id}}" class="nbi-approve-btn" data-status="{{$nbi_status}}">
                                    <span class="navi-text">{{$nbi_status}}</span>
                                </a>
                            @else
                                {{-- <a href="#" class="btn btn-warning btn-sm" data-id="{{$nbi_id}}" class="nbi-approve-btn" data-status="{{$nbi_status}}"> --}}
                                    <span class="navi-text">{{$nbi_status}}</span>
                                {{-- </a> --}}
                            @endif
                        @elseif($proposals->status == 'Rejected' && $nbi_status == 'Pending' && $current_user->hasAnyAccess('users.superadmin', 'nbi.status'))
                            {{-- <a href="{{route('nbi-status-change', ['new_status' => 'Rejected', 'id' => $nbi_id])}}" class="btn btn-danger btn-sm jsNbiRejectBtn" data-id="{{$nbi_id}}" class="nbi-approve-btn" data-status="{{$nbi_status}}">
                                <span class="navi-text">{{$proposals->status}}</span>
                            </a> --}}
                            {{-- @if ($proposals->is_amendment == 0) --}}
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm jsNbiRejectedBtn" data-id="{{$nbi_id}}" class="nbi-approve-btn" data-status="{{$nbi_status}}">
                                    <span class="navi-text">{{$nbi_status}}</span>
                                </a>
                            {{-- @else
                                <span class="navi-text">{{$nbi_status}}</span>
                            @endif --}}

                        @elseif($nbi_status == 'Expired')
                            <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                        @elseif ($nbi_status == 'Cancelled')
                            <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                        @elseif ($nbi_status == 'Rejected')
                            <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                        @endif
                    </td>
    			</tr>
    		@endforeach
    	@else
    	<tr><td colspan="7" class="text-center">{{ __('common.no_records_found') }}</td></tr>
    	@endif
    </tbody>
</table>
</div>