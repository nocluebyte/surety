<div class="card-body">
    <table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
        <thead>
            <tr>
                <th class="d-none"></th>
                <th class="min-width-100">{{ __('common.code') }}</th>
                <th class="min-width-300">{{ __('tender.contractor_name') }}</th>
                <th class="min-width-200 text-right">{{ __('tender.bond_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                <th class="min-width-200">{{  __('tender.bond_start_date') }}</th>
                <th class="min-width-200">{{  __('tender.bond_end_date') }}</th>
                <th class="min-width-200">{{ __('tender.bond_number') }}</th>
                <th class="min-width-200">{{ __('tender.allotment') }}</th>
                <th class="min-width-100">{{ __('common.status') }}</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tender->bondPoliciesIssue as $item)
                <tr>
                    <td class="d-none"></td>
                    <td><a href="{{ route('proposals.show', [encryptId($item->proposal->id)]) }}" class="navi-link" target="_blank"><span
                                class="navi-text rm-text">{{ $item->proposal->code . '/V' . $item->proposal->version }}</span></a></td>
                    <td>{{ $item->proposal->contractor_company_name ?? '-' }}</td>
                    <td class="text-right">{{ numberFormatPrecision($item->bond_value, 0) ?? '-' }}</td>
                    <td>{{ isset($item->bond_period_start_date) ? custom_date_format($item->bond_period_start_date, 'd/m/Y') : '-' }}</td>
                    <td>{{ isset($item->bond_period_end_date) ? custom_date_format($item->bond_period_end_date, 'd/m/Y') : '-' }}</td>
                    <td>{{ $item->reference_no . ' | ' . $item->bond_number ?? '' }}</td>
                    <td>{{ $item->bond_number ? 'Yes' : 'No' }}</td>
                    <td>{{ $item->proposal->status ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No data available in table</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
