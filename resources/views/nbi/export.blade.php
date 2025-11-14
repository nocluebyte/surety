<table class="table">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center !important;"><H2>{{ __('nbi.title') }}</H2></th>
        </tr>
        <tr>
            <th></th>
            <th><b>{{$nbi->policy_no}}</b></th>
        </tr>
    </thead>
    <tbody>
        @if($nbi)
            @php
                $currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
            @endphp
            <tr>
                <td>{{ trans("nbi.insured_name_principal_debtor") }}</td>
                <td>{{$nbi->contractor->company_name ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.insured_address") }}</td>
                <td>{{$nbi->insured_address ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.project_details") }}</td>
                <td>{{$nbi->project_details ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.beneficiary") }}</td>
                <td>{{$nbi->beneficiary->company_name ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.beneficiary_address") }}</td>
                <td>{{$nbi->beneficiary_address ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.beneficiary_contact_person_name") }}</td>
                <td>{{$nbi->beneficiary_contact_person_name ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.beneficiary_contact_person_phone_no") }}</td>
                <td>{{$nbi->beneficiary_contact_person_phone_no ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_type") }}</td>
                <td>{{$nbi->bondType->name ?? ''}}</td>
            </tr>
            {{-- <tr>
                <td>{{ trans("nbi.bond_number") }}</td>
                <td>{{$nbi->bidbond->bond_number ?? $nbi->performanceBond->bond_number ?? ''}}</td>
            </tr> --}}
            <tr>
                <td>{{ trans("nbi.bond_conditionality") }}</td>
                <td>{{$nbi->bond_conditionality ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.contract_value") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->contract_value ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.contract_currency") }}</td>
                <td>{{$nbi->currency->short_name ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_value") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->bond_value ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.cash_margin_if_applicable") }}</td>
                <td>{{$nbi->cash_margin_if_applicable ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.cash_margin_amount") }} {{ $currencySymbol }}</td>
                <td>{{ $nbi->cash_margin_amount ?? 0 }}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.tender_id_loa_ref_no") }}</td>
                <td>{{$nbi->tender_id_loa_ref_no ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_period_start_date") }}</td>
                <td>{{ custom_date_format($nbi->bond_period_start_date,'d/m/Y') }}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_period_end_date") }}</td>
                <td>{{ custom_date_format($nbi->bond_period_end_date,'d/m/Y') }}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_period_days") }}</td>
                <td>{{$nbi->bond_period_days ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.rate") }}</td>
                <td>{{$nbi->rate ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.net_premium") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->net_premium ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.gst") }}</td>
                <td>{{$nbi->gst ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.gst_amount") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->gst_amount ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.gross_premium") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->gross_premium ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.stamp_duty_charges") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->stamp_duty_charges ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.total_premium_including_stamp_duty") }} {{ $currencySymbol }}</td>
                <td>{{$nbi->total_premium_including_stamp_duty ?? 0}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.intermediary_name") }}</td>
                <td>{{$nbi->intermediary_name}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.intermediary_code_and_contact_details") }}</td>
                <td>{{$nbi->intermediary_code_and_contact_details}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.re_insurance_grouping") }}</td>
                <td>{{$nbi->reInsuranceGrouping->name ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ trans("nbi.bond_wording") }}</td>
                <td>{!! $nbi->bond_wording ?? '' !!}</td>
            </tr>
        @endif
    </tbody>
</table>