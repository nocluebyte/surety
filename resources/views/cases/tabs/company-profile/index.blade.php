<table style="width:100%">
    <tr>
        {{-- <td width="15%">
            <div class="font-weight-bold p-1 davy-grey-color"> {{ __('principle.type_of_entity') }}</div>
        </td>
        <td width="12%">
            <div class=" font-weight-bold  text-black">: 
                @php
                    if($case->casesable_type == 'Principle'){
                       $entity_name = $companyProfile->typeOfEntity->name ?? '';
                    }else if($case->casesable_type == 'Principle'){
                       $entity_name = $companyProfile->typeOfBeneficiaryEntity->name;
                    }else if($case->casesable_type == 'Principle'){
                       $entity_name = $companyProfile->typeOfEntity->name;
                    }
                @endphp
               {{$entity_name ?? '' }}</div>
        </td> --}}
        <td width="15%">
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.gst_vat_no.') }}</div>
        </td>
        <td width="12%">
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->gst_no ?? '' }}</div>
        </td>
        <td width="15%"></td>
        <td width="12%"></td>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.status') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->is_active == "Yes" ? 'Active' : 'In-Active' }}</div>
        </td>
        <td>
            <div class="font-weight-bold p-1  davy-grey-color">{{ __('cases.co_registration_no') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->registration_no ?? '' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.address') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->address ?? '' }}</div>
        </td>

        
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.phone_no') }}</div>
        </td>
        <td> 
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->user->mobile ?? '' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.pincode') }}</div>
        </td>
        <td> 
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->pincode ?? '' }}</div>
        </td>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.email') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->user->email ?? '' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{  __('common.city') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $companyProfile->city ?? '' }}</div>
        </td>
        <td>
            <div class="font-weight-bold p-1" style="color:#575656;">{{ __('principle.website') }}</div>
        </td>
        <td> 
            @php
                $website = $companyProfile->website ?? '';
            @endphp
            <div class=" font-weight-bold " style=" color : #000000;"><a href="{{ $website ?? '' }}" target="_black" rel="noopener">: {{ $companyProfile->website ?? '' }}</a></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.in_charge') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $case->underwriter_user_name ?? '' }}</div>
        </td>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.in_charge_since') }}</div>
        </td>
        <td>
            <div class=" font-weight-bold  text-black">: {{ $case->underwriter_assigned_date ? custom_date_format($case->underwriter_assigned_date, 'd-m-Y') : '' }}</div>
        </td>
    </tr>
    <tr>
        
    </tr>

</table>

@if($case->casesable_type == 'Principle' && $companyProfile->contractorItem->count() > 0)
<hr style="border-top: 1px dotted black;">
<h5 class="text-center">{{ __('cases.spv_data') }}</h5>
<table class="table">
    <thead>
        <tr>
            <th>{{ __('common.no') }}</th>
            <th>{{ __('principle.cin_number')}}</th>
            <th>{{ __('principle.contractor_name')}}</th>
            <th>{{ __('principle.pan_no') }}</th>
            <th>{{ __('principle.share_holding') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($companyProfile->contractorItem) && $companyProfile->contractorItem->count() > 0)
        @foreach ($companyProfile->contractorItem as $key => $row)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $row->contractor->code ?? ''  }}</td>
            <td>{{ $row->contractor->company_name ?? ''  }}</td>
            <td>{{ $row->pan_no ?? '' }}</td>
            <td>{{ $row->share_holding ?? '' }}</td>
        </tr>
        @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">No data available</td>
            </tr>
        @endif
    </tbody>
</table>
@endif

<hr style="border-top: 1px dotted black;">
<h5 class="text-center">{{ __('cases.trade_sector_data') }}</h5>
<table class="table">
    <thead>
        <tr>
            <th>{{ __('common.no') }}</th>
            <th>{{ __('principle.trade_sector')}}</th>
            <th>{{ __('principle.from') }}</th>
            <th>{{ __('principle.till') }}</th>
            <th>{{ __('principle.main') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($companyProfile->tradeSector) && $companyProfile->tradeSector->count() > 0)
            @foreach ($companyProfile->tradeSector as $key => $row)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $row->tradeSector->name ?? ''  }}</td>
                <td>{{ custom_date_format($row->from ?? '', 'd-m-Y') }}</td>
                <td>{{ $row->till ? custom_date_format($row->till, 'd-m-Y') : '' }}</td>
                <td>{{ $row->is_main ?? '' }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">No data available</td>
            </tr>
        @endif
    </tbody>
</table>