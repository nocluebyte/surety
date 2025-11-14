<ul class="nav nav-tabs nav-light-info nav-bold  ">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#approve_bond_current">
            <span class="nav-icon"><i class="flaticon2-hourglass-1"></i></span>
            <span class="nav-text">{{ __('cases.current') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#approve_bond_past">
            <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
            <span class="nav-text">{{ __('cases.past') }}</span>
        </a>
    </li>
     <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#approve_bond_reject">
            <span class="nav-icon"><i class="flaticon2-help"></i></span>
            <span class="nav-text">{{ __('cases.reject') }}</span>
        </a>
    </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#approve_bond_cancellation">
            <span class="nav-icon"><i class="flaticon2-pie-chart-2"></i></span>
            <span class="nav-text">{{ __('principle.bond_cancellation') }}</span>
        </a>
    </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#approve_bond_foreclosure">
            <span class="nav-icon"><i class="flaticon2-cube"></i></span>
            <span class="nav-text">{{ __('principle.bond_foreclosure') }}</span>
        </a>
    </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#approved_bond_invoked">
            <span class="nav-icon"><i class="flaticon2-pie-chart-3"></i></span>
            <span class="nav-text">{{ __('principle.bond_invoked') }}</span>
        </a>
    </li>
</ul>

<div class="tab-content mt-5">
    <div class="tab-pane fade show active" id="approve_bond_current">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_current as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{$decision->proposal->code . '/V-' . $decision->proposal->version ?? '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade show" id="approve_bond_past" role="tabpanel">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_past as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{ isset($decision->proposal) ? $decision->proposal->code . '/V-' . $decision->proposal->version : '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     <div class="tab-pane fade show" id="approve_bond_reject" role="tabpanel">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_reject as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{ isset($decision->proposal) ? $decision->proposal->code . '/V-' . $decision->proposal->version : '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
       <div class="tab-pane fade show" id="approve_bond_cancellation" role="tabpanel">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_cancellation as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{$decision->proposal->code . '/V-' . $decision->proposal->version ?? '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
        <div class="tab-pane fade show" id="approve_bond_foreclosure" role="tabpanel">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_foreclosure as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{$decision->proposal->code . '/V-' . $decision->proposal->version ?? '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


        <div class="tab-pane fade show" id="approved_bond_invoked" role="tabpanel">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="min-width-300">Tender ID</td>
                        <td class="min-width-100">Proposal ID</td>
                        <td class="min-width-300">Beneficiary</td>
                        <td class="min-width-150">Bond Type</td>
                        <td class="min-width-200 text-right">Bond Value<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                        <td class="min-width-150">Bond Start Date</td>
                        <td class="min-width-150">Bond End Date</td>
                        <td class="min-width-150">Decision Draft Taken Date</td>
                        <td class="min-width-150">Decision Taken Date</td>
                        <td class="min-width-100">Decision Status</td>
                        <td class="min-width-100">Status</td>
                        <td class="min-width-100">Nbi Status</td>
                        <td class="min-width-100">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approved_bond_invoked as $decision)
                        <tr>
                            <td>{{$decision->tender->tender_id}}</td>
                            <td>{{$decision->proposal->code . '/V-' . $decision->proposal->version ?? '-' }}</td>
                            <td>{{$decision->beneficiary->company_name}}</td>
                            <td>{{$decision->bondType->name ?? ''}}</td>
                            <td class="text-right">{{numberFormatPrecision($decision->bond_value,0)}}</td>
                            <td>{{custom_date_format($decision->bond_start_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->bond_end_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_draft_taken_date,'d/m/Y')}}</td>
                            <td>{{custom_date_format($decision->decision_taken_date,'d/m/Y')}}</td>
                            <td>{{$decision->decision_status ?? ''}}</td>
                            <td>{{$decision->status}}</td>
                            <td>{{$decision->nbi_status ?? ''}}</td>
                            <td class="text-center">
                                @if(isset($decision->status) && $decision->status == 'Completed')
                                    <a href="{{ isset($decision->proposal?->Endorsement?->dMS?->attachment) ? route('secure-file', encryptId($decision->proposal?->Endorsement?->dMS?->attachment)) : '' }}" target="_blank"><i class="fa fa-eye"></i> </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>