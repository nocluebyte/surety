<table class="table table-responsive mx-5 table-separate table-head-custom table-checkable" id="dataTableBuilder">
    <thead>

        <tr>
            <th class="d-none"></th>
            <th class="min-width-100">{{ __('common.code') }}</th>
            <th class="min-width-300">{{ __('proposals.contractor_name') }}</th>
            <th class="min-width-300">{{ __('proposals.beneficiary_name') }}</th>
            <th class="min-width-300">{{ __('proposals.project_name') }}</th>
            <th class="min-width-300">{{ __('proposals.tender_header') }}</th>
            <th class="min-width-200">{{ __('proposals.bond_type') }}</th>
            <th class="min-width-200">{{ __('proposals.bond_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
            <th class="min-width-200">{{ __('proposals.sys_gen_bond_number') }}</th>
            <th class="min-width-200">{{ __('proposals.insurer_bond_number') }}</th>
            <th class="min-width-200">{{ __('common.status') }}</th>
            <th class="min-width-200">{{ __('proposals.nbi_status') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($proposal_past as $item)
            <tr>
                <td class="d-none"></td>
                <td><a href="{{ route('proposals.show', [encryptId($item->id)]) }}" class="navi-link" target="_blank"><span
                            class="navi-text rm-text">{{ $item->code . '/V' . $item->version }}</span></a></td>
                <td>{{ $item->contractor_company_name ?? '-' }}</td>
                <td>{{ $item->beneficiary_company_name ?? '-' }}</td>
                <td>{{ $item->pd_project_name ?? '-' }}</td>
                <td>{{ $item->tender_header ?? '-' }}</td>
                <td>{{ $item->getBondType->name ?? '-' }}</td>
                <td>{{ numberFormatPrecision($item->bond_value, 0) ?? '-' }}</td>
                <td>{{ $item->proposalIssue->reference_no ?? '-' }}</td>
                <td>{{ $item->proposalIssue->bond_number ?? '-' }}</td>
                <td>{{ $item->status ?? '-' }}</td>
                <td>{{ $item->nbi_status ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
