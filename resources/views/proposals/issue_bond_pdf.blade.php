<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>POLICY SCHEDULE CUM CERTIFICATE OF INSURANCE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-border {
            border: 1px solid black;
            padding: 2px;
            vertical-align: top;
        }

        .separator {
            width: 4%;
            text-align: center;
        }

        .label {
            width: 20%;
        }

        .half {
            width: 50%;
        }

        .full {
            width: 100%;
        }

        .spacer {
            height: 15px;
        }

        .spacer-100 {
            height: 100px;
        }

        .no-border {
            border: none !important;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .blue {
            color: blue;
        }

        .invoice-note {
            font-size: 13px;
        }

        .font-size-18 {
            font-size: 18px;
        }

        .page-break {
            /* page-break-before: always;
            break-before: page; */

            page-break-after: always;

            /* page-break-before: always; */
        }

        /* .bottom {
            position: fixed;
            bottom: 0;
        }

        .footer {
            position: fixed;
            text-align: center;
            bottom: 0px;
            width: 100%;
        } 
        footer {
            position: fixed;
            height: 240px;
            bottom: 30px;
        }*/

    </style>
</head>

<body>
    <div id="page-container">
        <div class="content-wrapper">
            <div class="col-md-12">
                <table>
                    <tr>
                        <td colspan="3" class="left blue font-size-18"><strong>{{ $company_name }} (Government of India
                                Undertaking)</strong></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center"><strong>POLICY SCHEDULE CUM CERTIFICATE OF INSURANCE</strong></td>
                    </tr>
                    <tr class="">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center"><strong>Surety {{ $nbi->bondType->name }} Insurance</strong></td>
                    </tr>
                    <tr class="">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center"><strong>UIN Number - </strong></td>
                    </tr>
                    <tr class="">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr>
                        <th class="label table-border">Insured's Name</th>
                        <td class="separator table-border">:</td>
                        <td colspan="4" class="table-border">{{ $bondIssue->insured_name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th colspan="3" class="half table-border">Insured's Details</th>
                        <th colspan="3" class="half table-border">Issuing Office Details</th>
                    </tr>

                    <tr>
                        <th class="label table-border">Customer ID</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                        <th class="label table-border">Office Code</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $issuingOfficeBranch->branch_code ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th class="label table-border">Address</th>
                        <td class="separator table-border">:</td>
                        <td style="height: 100px;" class="table-border">{{ $bondIssue->insured_address ?? '-' }}</td>
                        <th class="label table-border">Address</th>
                        <td class="separator table-border">:</td>
                        <td style="height: 100px;" class="table-border">{{ $issuingOfficeBranch->address ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th class="label table-border">Phone No</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $bondIssue->beneficiary_phone_no ?? '-' }}</td>
                        <th class="label table-border">Phone No</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">E-mail/Fax</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $proposal->beneficiary_email ?? '-' }}</td>
                        <th class="label table-border">E-mail/Fax</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">Insured Pan Number</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $proposal->beneficiary_pan_no ?? '-' }}</td>
                        <th class="label table-border">S.Tax Regn. No</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">GSTIN/UIN</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $proposal->beneficiary_gst_no ?? '-' }}</td>
                        <th class="label table-border">GSTIN</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $issuingOfficeBranch->gst_no ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th class="label table-border"></th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                        <th class="label table-border">SAC</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border">{{ $nbi->hsn_code->hsn_code ?? '-' }}</td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <th colspan="6" class="table-border"><strong>Policy Details</strong></th>
                    </tr>

                    <tr>
                        <th class="label table-border">Policy Number</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                        <th class="label table-border">Business Source/CPSC User</th>
                        <td class="separator table-border">:</td>
                        <td class="table-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">Period Of Cover</th>
                        <td class="separator table-border">:</td>
                        <td colspan="4" class="table-border">{{ custom_date_format($proposal->bond_start_date, 'd/m/Y') }} 12:00:01 AM to {{ custom_date_format($proposal->bond_end_date, 'd/m/Y') }} 11:59:59 PM</td>
                    </tr>

                    <tr>
                        <th class="label table-border">Receipt No. & Date</th>
                        <td class="separator table-border">:</td>
                        <td colspan="4" class="table-border">{{ $bondIssueChecklist->utr_neft_details }} -
                            {{ isset($bondIssueChecklist->date_of_receipt) ? custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') : '-' }}
                        </td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <th class="table-border">Premium</th>
                        <th class="table-border">GST</th>
                        <th class="table-border">Total(RS)</th>
                        <th class="table-border" colspan="2">Total Rupees (In Words)</th>
                        <th class="table-border">Receipt No. & Date</th>
                    </tr>
                    <tr>
                        <td class="table-border right">{{ numberFormatPrecision($nbi->net_premium, 0) }}</td>
                        <td class="table-border right">{{ numberFormatPrecision($nbi->gst_amount, 0) }}</td>
                        <td class="table-border right">{{ numberFormatPrecision($nbi->gross_premium, 0) }}</td>
                        <td class="table-border" colspan="2">{{ convertToIndianCurrency($nbi->gross_premium) }}</td>
                        <td class="table-border">{{ $bondIssueChecklist->utr_neft_details }} -
                            {{ isset($bondIssueChecklist->date_of_receipt) ? custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') : '-' }}
                        </td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">Bidding Document</th>
                        <td colspan="5" class="table-border"></td>
                    </tr>
                    <tr>
                        <th class="label table-border">Contract</th>
                        <td colspan="5" class="table-border"></td>
                    </tr>
                    <tr>
                        <th class="label table-border">Contract Currency</th>
                        <td colspan="5" class="table-border">{{ $nbi->currency->short_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="label table-border">Contract Value</th>
                        <td colspan="5" class="table-border">{{ numberFormatPrecision($nbi->contract_value, 0) }}</td>
                    </tr>
                    <tr>
                        <th class="label table-border">Bond Value</th>
                        <td colspan="5" class="table-border">{{ numberFormatPrecision($nbi->bond_value, 0) }}</td>
                    </tr>
                    <tr>
                        <th class="label table-border">Beneficiary</th>
                        <td colspan="5" class="table-border">{{ $nbi->beneficiary->company_name }} - Name :
                            {{ $nbi->beneficiary_contact_person_name }} ;O/o : {{ $nbi->beneficiary_address }}</td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <th class="label table-border">Special Conditions</th>
                        <td colspan="5" class="table-border">{{ $bondIssue->special_condition ?? '-' }}</td>
                    </tr>

                    {{-- <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr> --}}

                    <tr>
                        <th colspan="6" class="left">Premium and GST Details</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th class="left">Rate of Tax</th>
                        <th colspan="2" class="left">Amount in INR</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="left">Premium</th>
                        <td></td>
                        <td colspan="2">{{ numberFormatPrecision($nbi->net_premium, 0) }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="left">SGST</th>
                        <td>{{ $nbi->sgst }}</td>
                        <td colspan="2">{{ numberFormatPrecision($nbi->sgst_amount, 0) }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="left">CGST</th>
                        <td>{{ $nbi->cgst }}</td>
                        <td colspan="2">{{ numberFormatPrecision($nbi->cgst_amount, 0) }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="left">IGST</th>
                        <td>{{ $nbi->igst }}</td>
                        <td colspan="2">{{ numberFormatPrecision($nbi->gst_amount, 0) }}</td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            {!! $issue_bond_note ?? '-' !!}{{ custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') }}
                        </td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <td colspan="5"></td>
                        <td>For and on behalf of {{ $company_name ?? '-' }}</td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    <tr>
                        <td colspan="6" class="center blue invoice-note"><strong>Policy No. : Document generated by 40763 at
                                {{ custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') }} 14:38:57 Hours.</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center blue invoice-note"><strong>Regd. & Head Office:
                                {{ $company_address ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center blue invoice-note"><strong>{!! $issue_bond_footer ?? '-' !!}</strong></td>
                    </tr>
                    <tr class="">
                        <td colspan="6" class="center blue invoice-note"><strong>http://newindia.co.in</strong></td>
                    </tr>

                    <tr class="spacer">
                        <td colspan="6" class="no-border"></td>
                    </tr>

                    {{-- <tr>
                        <td>
                            <div class="page-break"></div>
                        </td>
                    </tr> --}}

                    
                </table>
            </div>
            <div class="page-break"></div>
            <table width="100%" style="margin:0!important; padding:0!important; margin-bottom: 800px !important;">
                <tr>
                        <td colspan="3" class="left blue font-size-18"><strong>{{ $company_name }} (Government of India
                                    Undertaking)</strong></td>
                        <td colspan="3"></td>
                </tr>
                <tr class="spacer-100">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr>
                    <td colspan="6">Date of Issue :
                        {{ isset($bondIssueChecklist->date_of_receipt) ? custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="right">{{ $company_name ?? '-' }}</td>
                </tr>
                <tr class="spacer">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr class="spacer">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr class="spacer">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr>
                    <td colspan="6" class="right">Authorized Signatory</td>
                </tr>
                <tr class="spacer-100">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr>
                    <td colspan="6" class="center font-size-18">{!! $issue_bond_declaration ?? '-' !!}</td>
                </tr>
                <tr class="spacer">
                    <td colspan="6" class="no-border"></td>
                </tr>
                <tr>
                    <td colspan="6" class="center" style="font-size: 15px;">Tax Invoice No : </td>
                </tr>
                <tr class="spacer">
                    <td colspan="6" class="no-border"></td>
                </tr>

                <tr>
                    <td colspan="6" class="center font-size-18"><strong>IRDA Registration Number:</strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="center font-size-18"><strong>NIA PAN NUMBER :
                            {{ $company_gst_no ?? '-' }}</strong></td>
                </tr>	
            </table>
        </div>
       </div>

        <footer>
            <table width="100%" style="position: fixed !important; bottom: 0px !important;">
                <tr>
                    <td colspan="6" class="center blue invoice-note"><strong>Policy No. : Document generated by 40763 at
                            {{ custom_date_format($bondIssueChecklist->date_of_receipt, 'd/m/Y') }} 14:38:57 Hours.</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="center blue invoice-note"><strong>Regd. & Head Office: {{ $company_address ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="center blue invoice-note"><strong>{!! $issue_bond_footer ?? '-' !!}</strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="center blue invoice-note"><strong>http://newindia.co.in</strong></td>
                </tr>
            </table>
        </footer>
 </body>
</html>
