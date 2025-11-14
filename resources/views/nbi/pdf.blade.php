<!doctype html>
<html lang="en">
<head>
    <title>{{ __('nbi.title') }} | pdf</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="{{ isset($favicon) && !empty($favicon) ? asset($favicon) : asset('default.jpg') }}" />
</head>
@foreach (config('layout.resources.css') as $style)
<link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}"
    rel="stylesheet" type="text/css" />
@endforeach
<style media="all">
    body {
        font-size: 14px;
        font-family: Poppins, Helvetica, sans-serif;
        line-height: 1.5;
        /*display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;*/
        background: #fff;


        /*font-size: 17px;*/
    }

    .row {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .text-right {
        text-align: right !important;
    }

    .text-left {
        text-align: left !important;
    }

    .qtable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0px;
        /* cellspacing */
    }

    .qtable h1 {
        font-size: 32px;
    }

    .date {
        font-size: 17px;
    }

    .w-50 {
        width: 50%;
    }

    .space_div {
        padding: 10px;
    }

    .table_box_left {
        color: #000;
        text-align: left;
    }

    .table_box_left h5 {
        font-weight: 600;
        font-size: 15px;
        color: #1F4E9E !important;
        margin-top: 0;
        margin-bottom: 4px;
    }

    .qtable>thead>tr.head-row>th {
        padding: 10px;
        background: rgba(0, 0, 0, .1);
        border: 0px;
    }

    .text_p_right {
        text-align: right;
        padding: 0 10px 0 0;
    }

    .va_top {
        vertical-align: top !important;
        /*font-size: 17px;*/
    }

    table.ptb-10>tbody>tr>td {
        padding: 10px;
    }

    .text_p_product {
        font-size: 17px;
    }

    .text_sp {
        padding-bottom: 10px;
    }

    .text_sp1 {
        padding: 0 5px 5px 0;
    }

    table .text_grand {
        color: #1f4E9E !important;
    }

    .text_note {
        font-size: 14px;
        padding: 0 0 0 10px;
    }

    .text_note h4 {
        font-size: 18px;
        font-weight: 600;
    }

    .m-t {
        margin-top: 20px !important;
    }

    .p-t {
        padding: 10px 0;
    }

    .sign_box {
        border-top: 1px solid rgba(0, 0, 0, .2);
        border-bottom: 1px solid rgba(0, 0, 0, .2);
        border-left: 0px;
        border-right: 0px;
        height: 70px;
    }

    .sign_box_name {
        text-align: right;
        font-size: 14px;
        padding: 0 10px 0 0;
    }

    .italic {
        font-style: italic;
    }

    .page-break {
        page-break-after: always;
    }

    .avoid-inside {
        page-break-inside: avoid;
    }
</style>
<body>
    <main>
        @php
            $currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
        @endphp
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:30px">
            <tbody>
                <tr>
                    <td align="left" rowspan="5">
                        <img style="height: 150px" src="{{ url($print_logo) }}"alt="" />
                    </td>
                    <td align="right"><h2 style="margin-top: 0px;margin-bottom: 0px;">{{ $company_name }}</h2></td>
                </tr>
                <tr>
                    <td align="right"><span>({{ $subtitle }})</span></td>
                </tr>
                <tr>
                    <td align="right"><h3 style="margin-top: 0px;margin-bottom: 0px;">{{ $print_company_address_title }}</h3></td>
                </tr>
                <tr>
                    <td align="right"><span>{{ $print_company_address }}</span></td>
                </tr>
                <tr>
                    <td align="right"><a href="{{ $print_email_id }}" style="color: #0088c4;">{{ $print_email_id }}</a></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div style="padding-top:30px"><h1 align="center">{{ $print_title }}</h1></div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:10px padding-bottom:10px">
            <tbody>
                {{-- <tr>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;"><span>INVOICE TO :</span></td>
                    <td align="right" rowspan="2"><h1 style="margin-top: 0px; color: #0088c4;">{{ $nbi->bond_number ?? '' }}</h1></td>
                </tr> --}}
                <tr>
                    <td   align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;">
                        INVOICE TO :
                    </td>
                </tr>
                <tr>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;"><h3 style="margin-top: 0px;">{{ $nbi->contractor->company_name ?? '' }}</h3></td>
                    <td align="right" style="color: #0088c4; "><h3>PODDA007</h3></td>
                </tr>
                <tr>
                    <td style="border-left: 3px solid #0088c4; padding-left: 10px;">
                        <span>GSTIN : {{ $nbi->contractor->gst_no ?? '' }}</span>
                    </td>
                    <td style="padding-right: 10px;" align="right"><span>दिनांक / Date of Invoice: {{ custom_date_format($nbi->created_at,'M. d, Y') }}</span></td>
                </tr>
                <tr>
                    <td style="border-left: 3px solid #0088c4; padding-left: 10px;"><span>{{ $nbi->contractor->address ?? '' }}</span></td>
                    <td style="padding-right: 10px;" align="right"><span>नियत तारीख / Due Date of Invoice:Immediate</span></td>
                </tr>
                <tr>
                    <td style="border-left: 3px solid #0088c4; padding-left: 10px;"><span>INTERMEDIARY : </span><a href="#" style="color: #0088c4;">{{ $nbi->intermediary_name ?? '' }}</a></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered my-5">
            <tr>
                <td>{!! $print_disclosure !!}</td>
            </tr>
        </table>
        <table class="table table-bordered"  cellpadding="0" cellspacing="0" width="100%">
            <tr scope="row">
                <td align="center" colspan="2" scope="col">Project 1</td>
            </tr>
            <tr>
                <th>Project:</th>
                <td>{{ $nbi->project_details }}</td>
            </tr>
            <tr>
                <th>Beneficiary:</th>
                <td>{{ $nbi->beneficiary->company_name ?? '' }}</td>
            </tr>
            <tr>
                <th>Bond Type:</th>
                <td>{{ $nbi->bondType->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Contract Value {{ $currencySymbol }}:</th>
                <td>Estimated Cost in Cr. - {{ format_amount($nbi->contract_value,0) }}</td>
            </tr>
            <tr>
                <th>Bond Value {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->bond_value,0) }}</td>
            </tr>
            <tr>
                <th>Cash Margin %:</th>
                <td>{{ $nbi->cash_margin_if_applicable }} %</td>
            </tr>
            <tr>
                <th>Cash margin - Amount {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->cash_margin_amount, 0) }}</td>
            </tr>
            <tr>
                <th>Tender ID/LOA Ref no:</th>
                <td>{{ $nbi->tender_id_loa_ref_no }}</td>
            </tr>
            <tr>
                <th>Start Date:</th>
                <td>
                    {{ custom_date_format($nbi->bond_period_start_date,'M. d, Y') }}
                </td>
            </tr>
            <tr>
                <th>End Date:</th>
                <td>
                    {{ custom_date_format($nbi->bond_period_end_date,'M. d, Y') }}
                </td>
            </tr>
            <tr>
                <th>Bond Tenor(Days):</th>
                <td>
                    {{ format_amount($nbi->bond_period_days,0) }}
                </td>
            </tr>
            <tr>
                <th>Rate:</th>
                <td>
                    {{ $nbi->rate }}% p.a
                </td>
            </tr>
            <tr>
                <th>Indemnitor to NIA:</th>
                <td></td>
            </tr>
            <tr>
                <th>Net Premium {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->net_premium,0) }}</td>
            </tr>
            <tr>
                <th>SGST(%):</th>
                <td>{{ format_amount($nbi->sgst ?? 0,2) }} %</td>
            </tr>
            <tr>
                <th>SGST Amount {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->sgst_amount ?? 0,2) }}</td>
            </tr>
            <tr>
                <th>CGST(%):</th>
                <td>{{ format_amount($nbi->cgst ?? 0,2) }} %</td>
            </tr>
            <tr>
                <th>CGST Amount {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->cgst_amount,0) }}</td>
            </tr>
            <tr>
                <th>IGST(%):</th>
                <td>{{ format_amount($nbi->igst,2) }} %</td>
            </tr>
            <tr>
                <th>IGST Amount {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->gst_amount,0) }}</td>
            </tr>
            <tr>
                <th>Gross Premium {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->gross_premium,0) }}</td>
            </tr>
            <tr>
                <th>Stamp Duty {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->stamp_duty_charges,0) }}</td>
            </tr>
            <tr>
                <th>Total Premium Including Stamp Duty {{ $currencySymbol }}:</th>
                <td>{{ format_amount($nbi->total_premium_including_stamp_duty,0) }}</td>
            </tr>
        </table>

        <table class="table table-bordered"  cellpadding="0" cellspacing="0" width="100%">
            <tr scope="row">
                <td align="right">
                    <strong>
                        <span>
                            Grand Total {{ $currencySymbol }}: {{ format_amount($nbi->total_premium_including_stamp_duty,0) }}
                        </span>
                    </strong>
                    <br>
                    <span>
                        {{ convertToIndianCurrency($nbi->total_premium_including_stamp_duty) }}
                    </span>
                </td>
            </tr>
        </table>
        <table class="table table-bordered">
             <tr>
                <td>{!! $terms_conditions ?? '' !!}</td>
             </tr>
        </table>
        @if(isset($print_description) && count($print_description) > 0)
            @foreach($print_description as $desc)
                <strong style="color: #0088c4; font-size: 15px;">{{ $desc->print_title ?? '' }}</strong>
                <table class="table table-bordered">
                    <tr>
                        <td>{!! $desc->print_description ?? '' !!}</td>
                    </tr>
                </table>
            @endforeach
        @endif
       <div class="py-5">
        <table  cellpadding="0" cellspacing="0" width="100%" style="padding-top:10px padding-bottom:10px">
            <tbody>
                <tr>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 60%; font-size: 15px;">
                        <span>CIN NO. : {{ $nbi->issuingOfficeBranch->cin_no ?? '' }}</span>
                    </td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;"><strong>Bank Account Details</strong></td>
                </tr>
                <tr>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 60%; font-size: 15px;">
                        <span>GSTIN : {{ $nbi->issuingOfficeBranch->gst_no ?? '' }}</span>
                    </td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;"><strong>{{ $nbi->issuingOfficeBranch->branch_name ?? '' }}</strong></td>
                </tr>
                <tr>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 60%; font-size: 15px;">
                        <span>SAC code : {{ $nbi->issuingOfficeBranch->sac_code ?? '' }}</span>
                    </td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>OO/CBO/BO/KBO:</span> <strong>{{ $nbi->issuingOfficeBranch->oo_cbo_bo_kbo ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="width: 60%"></td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>Bank:</span> <strong>{{ $nbi->issuingOfficeBranch->bank ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="width: 60%"></td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>Bank Branch:</span> <strong>{{ $nbi->issuingOfficeBranch->bank_branch ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding-left: 10px;width: 60%; font-size: 15px;">
                        <span>This is a computer generated invoice no signature required</span>
                    </td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>A/C No:</span> <strong>{{ $nbi->issuingOfficeBranch->account_no ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding-left: 10px;width: 60%; font-size: 15px;">
                        <span>Thank you!</span>
                    </td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>IFSC:</span> <strong>{{ $nbi->issuingOfficeBranch->ifsc ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="width: 60%"></td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>MICR:</span> <strong>{{ $nbi->issuingOfficeBranch->micr ?? '' }}</strong>
                    </td>
                </tr>
                <tr>
                   <td align="left" style="width: 60%"></td>
                    <td align="left" style="border-left: 3px solid #0088c4; padding-left: 10px;width: 40%; font-size: 15px;">
                        <span>Mode:</span> <strong>{{ $nbi->issuingOfficeBranch->mode ?? '' }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
       </div>
    </main>
</body>
</html>
