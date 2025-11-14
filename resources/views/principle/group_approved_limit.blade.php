<table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
    <thead>
        <tr>
            <th class="min-width-100">{{ __('principle.cin_number') }}</th>
            <th class="min-width-300">{{ __('principle.contractor_name') }}</th>
            <th class="min-width-150">{{ __('principle.type') }}</th>
            <th class="min-width-150">{{ __('principle.country') }} </th>
            <th class="text-right min-width-200">{{ __('principle.pending_application_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
            <th class="text-right min-width-200">{{ __('principle.total_approved_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
            <th class="text-right min-width-200">{{ __('principle.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
            <th class="text-right min-width-200">{{ __('principle.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
            <th class="text-center min-width-150">{{ __('principle.regular_review_date') }}</th>
            <th class="text-center min-width-150">{{ __('principle.from') }}</th>
            <th class="text-center min-width-150">{{ __('principle.till') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($group_approved_limit as $item)
            <tr>
                <td>{{$item->code ?? ''}}</td>
                <td>{{$item->company_name ?? ''}}</td>
                <td>{{$item->type ?? ''}}</td>
                <td>{{$item->country ?? ''}}</td>
                <td class="text-right">{{numberFormatPrecision($item->pending_application_limit,0)}}</td>
                <td class="text-right">{{numberFormatPrecision($item->total_approved_limit,0)}}</td>
                <td class="text-right">{{numberFormatPrecision($item->proposed_individual_cap,0)}}</td>
                <td class="text-right">{{numberFormatPrecision($item->proposed_overall_cap,0)}}</td>
                <td class="text-center">{{custom_date_format($item->reguler_review_date,'d/m/Y')}}</td>
                <td class="text-center">{{custom_date_format($item->from_date,'d/m/Y')}}</td>
                <td class="text-center">{{custom_date_format($item->till_date,'d/m/Y')}}</td>
            </tr>
       @empty
            <tr>
                <td class="text-center" colspan="11">{{__('common.no_records_found')}}</td>
            </tr>
       @endforelse
    </tbody>
</table>