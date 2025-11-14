<div class="pt-5 pr-15 pl-15">
    <table class="table table-separate table-head-custom table-checkable">
        <thead>
            <tr>
                <th>{{ __('common.no') }}</th>
                <th>{{ __('nbi.policy_no')}}</th>
                <th>{{ __('nbi.insured_name_principal_debtor') }}</th>
                <th>{{ __('nbi.beneficiary_name') }}</th>
                <th>{{ __('nbi.bond_type') }}</th>
                <th class="text-center">{{ __('nbi.date_time') }}</th>
                <th class="text-center">{{ __('nbi.status') }}</th>
                @if($bondData->status =='Pending')
                    <th class="text-center">{{ __('common.action') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($bond_nbi->count() > 0)
                @foreach($bond_nbi as $n => $nbi_row)
                    @php
                    $nbi_status = $nbi_row->status;
                    $nbi_id = $nbi_row->id;
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a href="{{ route('bond-nbi.show', $nbi_id) }}" target="_blank">{{ $nbi_row->policy_no }}</a>
                        </td>
                        <td>{{ $nbi_row->contractor->company_name ?? '' }}</td>
                        <td>{{ $nbi_row->beneficiary->company_name ?? '' }}</td>
                        <td>{{ $nbi_row->bondType->name ?? '' }}</td>
                        <td class="text-center">{{ custom_date_format($nbi_row->created_at,'d/m/Y | H:i') }}</td>
                        <td class="text-center">
                            @if($nbi_status == 'Approved')
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm"><span class="navi-text">{{$nbi_status}}</span></a>
                            @elseif($nbi_status == 'Agreed')
                                <span class="label label-lg label-light-success font-weight-bolder label-inline">{{$nbi_status}}</span>
                            @elseif($nbi_status == 'Pending')
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm jsNbiPendingBtn" data-id="{{$nbi_id}}" class="nbi-approve-btn" data-status="{{$nbi_status}}">
                                    <span class="navi-text">{{$nbi_status}}</span>
                                </a>
                            @elseif($nbi_status == 'Expired')
                                <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                            @elseif ($nbi_status == 'Cancelled')
                                <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                            @elseif ($nbi_status == 'Amended')
                                <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$nbi_status}}</span>
                            @endif
                        </td>
                        @if($bondData->status =='Pending')
                            <td align="center">
                                <a href="{{route('bond-nbi.edit',$nbi_id)}}"><i class="fas fa-edit cursor-pointer btn-sm" title="Edit Nbi" ></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
            <tr><td colspan="7" class="text-center">{{ __('common.no_records_found') }}</td></tr>
            @endif
        </tbody>
    </table>
    </div>