@extends($theme)
@section('title', $title)
@section('content')
@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
    'back_action'=> route('proposals.show',[encryptId($nbi->proposal_id)]),
    'text' => __('common.back'),
    'pdf_id' => '',
    'pdf_link' => route('nbi-pdf', [encryptId($nbi->id)]),
    'excel_id' => '',
    'excel_link' => route('nbi-export', [encryptId($nbi->id)]),
])
@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 mb-3">
                            <div class="col-lg-12 text-right">
                                <H2>{{$nbi->policy_no}}<H2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
                        @endphp
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <table class="w-100 nbi-table table-layout-fixed">
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('insured_name_principal_debtor',trans("nbi.insured_name_principal_debtor"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->contractor->company_name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('insured_address',trans("nbi.insured_address"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->insured_address ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('project_details',trans("nbi.project_details"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->project_details ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary',trans("nbi.beneficiary"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->beneficiary->company_name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary_address',trans("nbi.beneficiary_address"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->beneficiary_address ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary_contact_person_name',trans("nbi.beneficiary_contact_person_name"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->beneficiary_contact_person_name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary_contact_person_phone_no',trans("nbi.beneficiary_contact_person_phone_no"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->beneficiary_contact_person_phone_no ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_type',trans("nbi.bond_type"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->bondType->name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_number',trans("nbi.bond_number"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->bond_number ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_conditionality',trans("nbi.bond_conditionality"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->bond_conditionality ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('contract_value',trans("nbi.contract_value"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->contract_value, 0) ?? 0}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('contract_value',trans("nbi.contract_currency"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->currency->short_name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_value',trans("nbi.bond_value"))!!}  {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->bond_value, 0) ?? 0}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('cash_margin_if_applicable',trans("nbi.cash_margin_if_applicable"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->cash_margin_if_applicable ?? 0}} %
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('cash_margin_amount',trans("nbi.cash_margin_amount"))!!}{{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{ numberFormatPrecision($nbi->cash_margin_amount, 0) ?? 0 }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('tender_id_loa_ref_no',trans("nbi.tender_id_loa_ref_no"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->tender_id_loa_ref_no ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_period_start_date',trans("nbi.bond_period_start_date"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{ custom_date_format($nbi->bond_period_start_date,'d/m/Y') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_period_end_date',trans("nbi.bond_period_end_date"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{ custom_date_format($nbi->bond_period_end_date,'d/m/Y') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_period_days',trans("nbi.bond_period_days"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->bond_period_days, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('rate',trans("nbi.rate"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{ $nbi->rate ?? 0}} %
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('net_premium',trans("nbi.net_premium"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->net_premium, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('hsn_code_id',trans("nbi.gst"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->hsn_code->gst ?? 0}} %
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('gst_amount',trans("nbi.gst_amount"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->gst_amount, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('gross_premium',trans("nbi.gross_premium"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->gross_premium, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('stamp_duty_charges',trans("nbi.stamp_duty_charges"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->stamp_duty_charges, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('total_premium_including_stamp_duty',trans("nbi.total_premium_including_stamp_duty"))!!} {{ $currencySymbol }}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{numberFormatPrecision($nbi->total_premium_including_stamp_duty, 0)}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('intermediary_name',trans("nbi.intermediary_name"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->intermediary_name}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('intermediary_code_and_contact_details',trans("nbi.intermediary_code_and_contact_details"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->intermediary_code_and_contact_details}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('trade_sector_id',trans("nbi.sector"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->tradeSector->name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('re_insurance_grouping_id',trans("nbi.re_insurance_grouping"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {{$nbi->reInsuranceGrouping->name ?? ''}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('bond_wording',trans("nbi.terms_conditions"))!!}
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <div class="row">
                                            <div class="col-lg-12 font-weight-bold text-black">
                                                {!!$nbi->bond_wording ?? ''!!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection