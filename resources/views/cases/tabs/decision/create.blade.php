<form action="{{ route('decision-store') }}" method="POST" id="casesDecisionForm">
    @csrf
    <input type="hidden" name="proposal_id" value="{{ $case->proposal_id ?? '' }}">      
    <input type="hidden" name="cases_id" value="{{ $case->id ?? '' }}">
    <input type="hidden" name="contractor_id" value="{{ $case->contractor_id ?? '' }}">
    <input type="hidden" class="JsUnderwriter" name="underwriter_id" value="{{$case->underwriter_id ?? ''}}">
    <input type="hidden" name="case_action_plan_id" value="{{$case_action_plan->id ?? ''}}">
    <input type="hidden" name="cases_decision_id" value="{{$case->casesDecision->id ?? ''}}">
    {{-- <input type="hidden" name="total_bond_utilized_cap" value="{{$case_action_plan->utilized_cases_bond_limit_strategy_sum_value ?? 0}}">
    <input type="hidden" name="bond_utilized_cap" value="{{$case->cases_decision_sum_bond_value ?? 0}}"> --}}
    <input type="hidden" class="jsPreviousBondValue" name="previous_bond_value" value="{{$case->previous_bond_value ?? 0}}">
    <input type="hidden" class="jsIsCaseAmend" name="is_case_amend" value="{{$case->isCaseAmend ?? 0}}">
    
    <table style="width:100%">
        <tr>
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Proposal ID</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->proposal->code . '/V' . $case->proposal->version ?? ''}}
            </th>   
        </tr>
        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Contractor ID:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->contractor->code ?? ''}}
            </th>         
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Contractor Name</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->contractor->company_name ?? ''}}
            </th>     
        </tr>            
        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Beneficiary ID</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->beneficiary->code ?? ''}}
            </th>       
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Beneficiary Name :</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->beneficiary->company_name ?? ''}}
            </th>    
        </tr>
        <tr>
             <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Tender ID:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                 {{$case->tender->code ?? ''}}
            </th>        
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Tender Name :</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->tender->tender_id ?? ''}}
            </th>           
        </tr>

        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Project ID:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{ $case->proposal->projectDetails->code ?? '' }}
                </div>
            </th> 
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Project Name :</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{ $case->proposal->pd_project_name ?? '' }}
                </div>
            </th>            
        </tr>

        <tr>
             <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Product Name:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                 {{$case->bondType->name ?? ''}}
            </th>
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Product Amount :</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{ isset($case->bond_value) ? numberFormatPrecision($case->bond_value, 0) : '-' }}
                </div>
            </th>         
        </tr>

        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Application Date:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{ isset($case->created_at) ? custom_date_format($case->created_at, 'd/m/Y') : '' }}
                </div>
            </th>   
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Currency :</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{ isset($case->contractor->country->currency) ? $case->contractor->country->currency->short_name : '' }}
                </div>
            </th>        
        </tr>

        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Existing Product Name:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                
            </th>    
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Existing Product Amount:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">

            </th>         
        </tr>
        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 " style="color:#575656;">Existing Product Days:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                
            </th>   
            <th width="10%">
                <div class="font-weight-bold  p-1 " style=" color : #575656;">Rejection Reason:</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold " style=" color : #000000;">
                    {{$case->proposal->rejectionReason->reason ?? ''}}
                </div>
            </th>
        </tr>          
    </table>
    <hr>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label class="col-form-label">{{ __('cases.project_acceptable') }}<i class="text-danger">*</i></label>
                <div class="radio-inline ">
                    <label class="radio">
                        {{ Form::radio('project_acceptable', 'Yes',  true, ['class' => 'form-check-input jsProjectAcceptable', 'id' => 'yes']) }}
                        <span></span>{{ __('cases.yes') }}
                    </label>

                    <label class="radio">
                        {{ Form::radio('project_acceptable', 'No',  false, ['class' => 'form-check-input jsProjectAcceptable', 'id' => 'no']) }}
                        <span></span>{{ __('cases.no') }}
                    </label>
                </div>
            </div>
        </div>

        @php
            $projectAcceptableRemark = $case->casesDecision->project_acceptable_remark ?? '';
        @endphp
        @if($projectAcceptableRemark)
            <div class="col-lg-5">
                <label class="col-form-label">Remark</label>
                <div class="text-black">
                    {!! Form::textarea('project_acceptable_remark', $projectAcceptableRemark ?? '', [
                        'class' => 'form-control form-control-solid',
                        'rows' => '2',
                        'data-rule-Remarks'=>true,
                        'readonly',
                    ]) !!}
                </div>
            </div>
        @else
            <div class="col-lg-5 jsProjectAcceptableDiv d-none">
                <label class="col-form-label">Remark</label>
                <div class="text-black jsProjectAcceptable">
                    {!! Form::textarea('project_acceptable_remark', '', [
                        'class' => 'form-control jsProjectAcceptableRemark',
                        'rows' => '2',
                        'data-rule-Remarks'=>true
                    ]) !!}
                </div>
            </div>
        @endif

    </div>
    <hr style="border-top: 1px dotted black;">
    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{__('cases.bond_type')}}</th>
                        <th>{{__('cases.bond_value')}}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                        <th>{{__('cases.bond_start_date')}}</th>
                        <th>{{__('cases.bond_end_date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {!! Form::select('bond_type_id',$bondTypes,$case->bond_type_id ?? '', [ 'class' => 'form-control form-control-solid jsSelect2',
                            'disabled'])
                            !!}
                            {!!Form::hidden('bond_type_id',$case->bond_type_id ??'')!!}
                        </td>
                        <td>
                            {!! Form::number('bond_value',$case->bond_value ?? '', [ 'class' => 'form-control form-control-solid jsBondValue text-right',
                            'readonly',])
                            !!}
                            
                        </td>
                        <td>
                            {!! Form::date('bond_start_date',$case->bond_start_date ?? '', [ 'class' => 'form-control form-control-solid',
                            'readonly',])
                            !!}
                        </td>
                        <td>
                            {!! Form::date('bond_end_date',$case->bond_end_date ?? '', [ 'class' => 'form-control form-control-solid',
                            'readonly',])
                            !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        @php
            $caseRemark = $case->casesDecision->remark ?? '';
        @endphp
         <div class="col-lg-6">
            <div class="form-group">
                {!!Form::label(__('common.remarks'),__('common.remarks'))!!}<i class="text-danger">*</i> 
                @if($caseRemark)
                    {!!Form::textarea('remark', $caseRemark ?? null,['class'=>'form-control form-control-solid ' ,'rows'=>2, 'data-rule-Remarks'=>true, 'readonly' ])!!}
                @else
                    {!!Form::textarea('remark', null,['class'=>'form-control required ' ,'rows'=>2, 'data-rule-Remarks'=>true, ])!!}
                @endif
            </div>
        </div>
    </div>
    <br>
    <table class="row">
        <tr>
            <span class="p-1 text-danger decision-error-0 d-none">
                Please assign underwriter to take any action.
            </span>
          </tr>
        <tr>
            <span class="p-1 text-danger decision-error-1 d-none">
                Overall cap validity expired.
            </span>
        </tr>
        <tr>
            <span class="p-1 text-danger decision-error-2 d-none">
                Bond type wise overall cap validity expired
            </span>
        </tr>
        <tr>
            <span class="p-1 text-danger decision-error-3 d-none">
                Bond value should not be greater than overall cap.
            </span>
        </tr>
        <tr>
            <span class="p-1 text-danger decision-error-4 d-none">
                Bond value should not be greater than bond type wise remaining cap.
            </span>
        </tr>
        <tr>
            <span class="p-1 text-danger decision-error-5 d-none">
                Proposed overall cap should be greater than sum of total utilized amount and bond value.
            </span>
        </tr>
        <tr>
            <span class="p-1 text-danger decision-error-6 d-none">
                Proposed bond type wise remaining cap should be greater than sum of bond type wise utilized cap and bond value.
            </span>
        </tr>
    </table>
    <br>
    <div class="card-footer pt-3 pb-1 ">
        <div class="row">
            <div class="col-12 text-right ">
               @if ($case->proposal->status === 'Confirm' && $case->decision_status === NULL && $current_user->id === $case->underwriterUserId)
                    <input class="btn btn-success" name="decision_status" value="Approved"  type="submit" title="Approved"/>
                    <input class="btn btn-danger"  name="decision_status" value="Rejected" type="submit" title="Rejected"/>
               @elseif ($case->proposal->status === 'Cancel' && $case->decision_status === NULL && $current_user->id === $case->underwriterUserId)
                    <input class="btn btn-danger"  name="decision_status" value="Rejected" type="submit" title="Rejected"/>
               @endif
                {{-- @if (empty($casesprofileApprovalshow) ||
                        (isset($casesprofileApprovalshow['cases_tray']) &&
                            $casesprofileApprovalshow['cases_tray']['status'] != 'Completed'))
                    <button class="btn btn-primary save_button"
                        type="submit" name="submit_type" value="save">Save</button>
                @endif
                <button class="btn btn-primary save_button" name="submit_type" value="save_and_exit"
                type="submit">Save & Exit</button> --}}
            </div>
        </div>
    </div>
</form>