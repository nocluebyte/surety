{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', $title)


    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('recovery.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <table class="w-100">
                                <tr>
                                    <th width="10%">
                                        <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('invocation_number',__('recovery.invocation_number')) !!}</div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold  text-black">
                                            :{{$recovery->invocationNotification->code ?? ''}}
                                        </div>
                                    </th>
                                    <th width="12%">
                                        <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('invocation_date',__('recovery.invocation_date')) !!} </div>
                                    </th>
                                    <th width="25%">
                                        <div class="font-weight-bold text-black">: 
                                            {{isset($recovery->invocationNotification->invocation_date) ? custom_date_format($recovery->invocationNotification->invocation_date,'d/m/Y') : '' }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="12%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary',__('recovery.beneficiary')) !!}</div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold  text-black"> :
                                            {{ $recovery->invocationNotification->beneficiary->name ?? '' }}
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label(__('recovery.contractor')) !!}</div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold text-black">: 
                                        {{ $recovery->invocationNotification->beneficiary->name ?? '' }}
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="12%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary',__('recovery.tender')) !!}</div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold  text-black"> :
                                            {{ $recovery->invocationNotification->tender->name ?? '' }}
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label(__('recovery.claimed_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold text-black">: 
                                            {{numberFormatPrecision($recovery->invocationNotification->claimed_amount,0)}}
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="12%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {!! Form::label('beneficiary',__('recovery.total_outstanding_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                    </th>
                                    <th width="25%">
                                        <div class=" font-weight-bold  text-black"> :
                                            {{numberFormatPrecision($recovery->invocationNotification->total_outstanding_amount,0)}}
                                        </div>
                                    </th>
                                  
                                </tr>
                            </table>

                            <hr>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Recovery Number</th>
                                        <th>Recovery date</th>
                                        <th>Recovered Amount<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                        <th>Remarks</th>
                                        <th class="text-right">Total Recoverd Amount<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">Total Outstanding Amount<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                    <td>{{$recovery->code ?? ''}}</td>
                                    <td>{{isset($recovery->recover_date) ? custom_date_format($recovery->recover_date,'d/m/Y') : ''}}</td>
                                    <td>{{numberFormatPrecision($recovery->recover_amount, 0) ?? ''}}</td>
                                    <td>{{$recovery->remark ?? ''}}</td>
                                    <td class="text-right">{{numberFormatPrecision($recovery->invocationNotification->total_recoverd_amount,0)}}</td>
                                    <td class="text-right">{{numberFormatPrecision($recovery->invocationNotification->total_outstanding_amount,0)}}</td>
                                   </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>


    @include('info')
@endsection