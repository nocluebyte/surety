<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @foreach (config('layout.resources.css') as $style)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
            type="text/css" />
    @endforeach
</head>

<body>
    <div class="row pb-5">
        <div class="col">
            @if (isset($print_logo))
                <img style="width:150px" src="{{ asset($print_logo) }}"/>
            @endif
        </div>
    </div>
    <div class="row pb-5">
        <div class="col">
            {{$proposal->contractor->code ?? ''}} <br>
            {{$proposal->contractor_company_name}} <br>
            {{ $proposal->address ?? '' }}
            {{ $proposal->contractor_city ?? '' }} -{{ $proposal->contractor_pincode ?? '' }} <br>
            {{ $proposal->state->name ?? '' }},
            {{ $proposal->country->name ?? '' }}
        </div>
    </div>
    <br>
    <br>
    <div class="row pb-5">
        <div class="col">
            {{$proposal->beneficiary->code ?? ''}} <br>
            {{$proposal->beneficiary_company_name}} <br>
            {{ $proposal->beneficiary_address ?? '' }} -{{ $proposal->beneficiary_pincode ?? '' }} <br>
            {{ $proposal->benificiaryState->name ?? '' }},
            {{ $proposal->benificiaryCountry->name ?? '' }}
        </div>
    </div>
    <table class="table table-bordered table-dark-border">
        <thead>
            <tr scope="row">
                <th scope="col">Field Name</th>
                <th scope="col">Field Value</th>
            </tr>
        </thead>
        <tbody>
            <tr scope="row">
                <td scope="col">Proposal Number</td>
                <td>{{"{$proposal->code}/V{$proposal->version}"}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Endorsement Number</td>
                <td>{{$endorsement->endorsement_number ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Tender ID</td>
                <td>{{$proposal->tender->tender_id ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Tender Header</td>
                <td>{{$proposal->tender->tender_header ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Project ID</td>
                <td>{{$proposal->projectDetails->code ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Project Name</td>
                <td>{{$proposal->pd_project_name ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Project Description</td>
                <td>{{$proposal->pd_project_description ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Type of Product (Bond)</td>
                <td>{{$proposal->getBondType->name ?? ''}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Type of Endorsement - NEW/AMENDMENT</td>
                <td>{{ $proposal->version > 1 ? 'AMENDMENT' : 'NEW' }}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Bond Start Date</td>
                <td>{{custom_date_format($proposal->bond_start_date, 'd/m/Y')}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Bond End Date</td>
                <td>{{custom_date_format($proposal->bond_end_date, 'd/m/Y')}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Application Amount<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                <td>{{numberFormatPrecision($cases->bond_value,0)}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Decision Amount<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></td>
                <td>{{numberFormatPrecision($cases->casesDecision->bond_value,0)}}</td>
            </tr>
            <tr scope="row">
                <td scope="col">Days</td>
                <td>{{ $proposal->bond_period ?? '' }}</td>
            </tr>
        </tbody>
    </table>
    <div class="row pt-5">
        <div class="col">
            <h3>Remarks</h3>
            <div>{{$cases->casesDecision->remark ?? ''}}</div>
        </div>
    </div>
</body>

</html>