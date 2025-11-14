@php    
$disabled = '';
 if($case->tender_evaluation == 'Yes'){
    $rating_score = $proposal->agencyRating->rating ?? null;
    $tender_id = $tenderEvaluation->tender_id;
    $project_description = $tenderEvaluation->project_description;
    $beneficiary = $tenderEvaluation->beneficiary->company_name;
    $project_value = $tenderEvaluation->project_value;
    $bond_value = $tenderEvaluation->bond_value;
    $overall_capacity = $tenderEvaluation->overall_capacity;;
    $individual_capacity = $tenderEvaluation->individual_capacity;;
    $product_allowed = $tenderEvaluation->productAllowed->pluck('project_type_id')->toArray();
    $disabled = '';
    $old_contract_running_contract = $tenderEvaluation->old_contract_running_contract;
    $replacement_bg_for_existing_contract = $tenderEvaluation->replacement_bg_for_existing_contract;
    $experience_of_similar_contract_size = $tenderEvaluation->experience_of_similar_contract_size;
    $complexity_of_project_allowed = $tenderEvaluation->complexity_of_project_allowed;
    $type_of_projects_allowed = $tenderEvaluation->type_of_projects_allowed;
    $work_type = $tenderEvaluation->work_type->pluck('work_type')->toArray();
    $type_of_bond_allowed = $tenderEvaluation->type_of_bond_allowed;
    $tenure_id = $tenderEvaluation->tenure_id;
    $strategic_nature_of_the_project = $tenderEvaluation->strategic_nature_of_the_project;
    $user_id = $tenderEvaluation->user_id;
    $underwriter_disabled = (!$allow_save) ? 'disabled' : '';
    $bond_start_date = $tenderEvaluation->bond_start_date;
    $bond_end_date = $tenderEvaluation->bond_end_date;
    $bond_period = $tenderEvaluation->bond_period;
    $readOnly='readOnly';
    $other_work_type = $tenderEvaluation->other_work_type;
    $other_work_type_show = (in_array('-1', $work_type)) ? '' : 'd-none';
    $location = $tenderEvaluation->location;
    $attachment = $tenderEvaluation->attachment;
    $remarks = $tenderEvaluation->remarks;
    $attachment = $tenderEvaluation->attachment;
}else{
    $proposal_code = $proposal->tender->code ?? '';
    $proposal_tender_id = $proposal->tender->tender_id ?? '';
    $tender_id = $proposal_code .' | '.$proposal_tender_id;
    $rating_score = $proposal->agencyRating->rating ?? null;
    $project_description = $proposal->project_description ?? null;
    $beneficiary = $proposal->beneficiary->company_name ?? null;
    $project_value = $proposal->contract_value ?? null;
    $bond_value = $proposal->bond_value ?? null;
    $overall_capacity = $total_overall_cap ?? null;
    $individual_capacity = $total_individual_cap ?? null;
    $product_allowed = null;
    $disabled = '';
    $old_contract_running_contract = '';
    $replacement_bg_for_existing_contract = '';
    $experience_of_similar_contract_size = '';
    $complexity_of_project_allowed = '';
    $type_of_projects_allowed = null;
    $work_type = [];
    $type_of_bond_allowed = '';
    $tenure_id = null;
    $strategic_nature_of_the_project = null;
    $user_id = null;
    $underwriter_disabled = '';
    $bond_start_date = $proposal->bond_start_date ?? null;
    $bond_end_date = $proposal->bond_end_date ?? null;
    $bond_period = $proposal->bond_period ?? null;
    $readOnly='';
    $other_work_type = null;
    $other_work_type_show = 'd-none';
    $location = collect();
    $attachment = '';
    $remarks = '';
    $attachment = '';
} 
@endphp

   
@include('components.error')
{!! Form::open(['route' => 'tender-evaluation-store','role' => 'form','enctype' => 'multipart/form-data','id' => 'tenderEvaluationForm',]) !!}    
    <div class="card-body">
        <div class="row">
            {!! Form::hidden('proposal_id', $proposal_id) !!}
            {!! Form::hidden('cases_id', $case->id) !!}
            {!! Form::hidden('contractor_id', $proposal->contractor_id) !!}
            {!! Form::hidden('beneficiary_id', $proposal->beneficiary_id) !!}
            {!! Form::hidden('id', $tenderEvaluation->id ?? '') !!}
            <div class="col-6 form-group">
                {!! Form::label('proposal_code', __('proposals.proposal_id')) !!}<i class="text-danger">*</i>
                {!! Form::text('proposal_code',$proposal->code ?? null, ['class' => 'form-control form-control-solid required jsReadOnly','readOnly']) !!}
            </div>

            <div class="col-6 form-group">
                {!! Form::label('contractor_code', __('proposals.contractor_id')) !!}<i class="text-danger">*</i>
                {!! Form::text('contractor_code',$proposal->contractor->code ?? null, ['class' => 'form-control form-control-solid required jsReadOnly','readOnly']) !!}
            </div>

            <div class="col-6 form-group">
                {!! Form::label('rating_score', __('proposals.rating_score')) !!}
                {!! Form::text('rating_score',$rating_score, ['class' => 'form-control form-control-solid jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('tender_id', __('proposals.tender_id')) !!}<i class="text-danger">*</i>
                {!! Form::text('tender_id',$tender_id, ['class' => 'form-control form-control-solid required jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('project_description', __('proposals.project_description')) !!}<i class="text-danger">*</i>
                {!! Form::text('project_description',$project_description, ['class' => 'form-control form-control-solid required jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('beneficiary', __('proposals.beneficiary')) !!}<i class="text-danger">*</i>
                {!! Form::text('beneficiary',$beneficiary, ['class' => 'form-control form-control-solid required jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('project_value', __('proposals.project_value')) !!}<i class="text-danger">*</i>
                {!! Form::text('project_value',$project_value, ['class' => 'form-control number required jsDisabled','data-rule-Numbers'=>true, $disabled]) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('bond_value', __('proposals.bond_value')) !!}<i class="text-danger">*</i>
                {!! Form::text('bond_value',$bond_value, ['class' => 'form-control required number jsDisabled','data-rule-Numbers'=>true, $disabled]) !!}
            </div>
            <div class="col-6 form-group">
                {{ Form::label('bond_start_date', __('proposals.bond_start_date')) }}<i
                    class="text-danger">*</i>
                {!! Form::date('bond_start_date', $bond_start_date, ['class' => 'jsBondStartDate form-control required jsDisabled','min' => '1000-01-01','max' => '9999-12-31','id' => 'bond_start_date','max'=>$bond_end_date,$disabled])
                !!}
            </div>
            <div class="col-6 form-group">
                {{ Form::label('bond_end_date', __('proposals.bond_end_date')) }}<i class="text-danger">*</i>
                {!! Form::date('bond_end_date', $bond_end_date, ['class' => 'jsBondEndDate form-control required jsDisabled', 'min' => '1000-01-01', 'max' => '9999-12-31','id' => 'bond_end_date','min'=>$bond_start_date,$disabled])
                !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label(__('proposals.bond_period'), __('proposals.bond_period')) !!}<i class="text-danger displayNone">*</i>
                {!! Form::text('bond_period', $bond_period, [
                    'class' => 'form-control required number period_of_bond jsPeriodOfBond form-control-solid',
                    'id' => 'bond_period','readonly'
                ]) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('overall_capacity', __('proposals.overall_capacity')) !!}
                {!! Form::text('overall_capacity',$overall_capacity, ['class' => 'form-control form-control-solid jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('individual_capacity', __('proposals.individual_capacity')) !!}
                {!! Form::text('individual_capacity',$individual_capacity, ['class' => 'form-control form-control-solid jsReadOnly', 'readOnly']) !!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('product_allowed', __('proposals.product_allowed')) !!}
                {!! Form::select('product_allowed[]',$bondTypes,$product_allowed,['class' => 'form-control form-control-solid jsSelect2ClearAllow jsDisabled', 'multiple', 'data-placeholder'=>'Select product allowed',$disabled])!!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('old_contract_running_contract', __('proposals.old_contract_running_contract')) !!}
                <div class="radio-inline pl-4">
                    <label class="radio">
                        {{ Form::radio('old_contract_running_contract', 'allowed', ($old_contract_running_contract == 'allowed') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'old_contract_running_contract_allowed',$disabled]) }}
                        <span></span>{{ __('proposals.allowed') }}
                    </label>
                    <label class="radio">
                        {{ Form::radio('old_contract_running_contract', 'disallowed', ($old_contract_running_contract == 'disallowed') ? true :'', ['class' => 'form-check-input jsDisabled', 'id' => 'old_contract_running_contract_disallowed',$disabled]) }}
                        <span></span>{{ __('proposals.disallowed') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
                {!! Form::label('replacement_bg_for_existing_contract', __('proposals.replacement_bg_for_existing_contract')) !!}
                <div class="radio-inline pl-4">
                    <label class="radio">
                        {{ Form::radio('replacement_bg_for_existing_contract', 'allowed', ($replacement_bg_for_existing_contract == 'allowed') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'replacement_bg_for_existing_contract_allowed', $disabled]) }}
                        <span></span>{{ __('proposals.allowed') }}
                    </label>
                    <label class="radio">
                        {{ Form::radio('replacement_bg_for_existing_contract', 'disallowed', ($replacement_bg_for_existing_contract == 'disallowed') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'replacement_bg_for_existing_contract_disallowed', $disabled]) }}
                        <span></span>{{ __('proposals.disallowed') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
                {!! Form::label('experience_of_similar_contract_size', __('proposals.experience_of_similar_contract_size')) !!}
                <div class="radio-inline">
                    <label class="radio col-4">
                        {{ Form::radio('experience_of_similar_contract_size', 'nil', ($experience_of_similar_contract_size == 'nil') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'experience_of_similar_contract_size_nil', $disabled]) }}
                        <span></span>{{ __('proposals.nil') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('experience_of_similar_contract_size', 'limited_1', ($experience_of_similar_contract_size == 'limited_1') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'experience_of_similar_contract_size_limited_1', $disabled]) }}
                        <span></span>{{ __('proposals.limited_1') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('experience_of_similar_contract_size', 'more_than_1', ($experience_of_similar_contract_size == 'more_than_1') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'experience_of_similar_contract_size_more_than_1', $disabled]) }}
                        <span></span>{{ __('proposals.more_than_1') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
                {!! Form::label('complexity_of_project_allowed', __('proposals.complexity_of_project_allowed')) !!}
                <div class="radio-inline">
                    <label class="radio col-4">
                        {{ Form::radio('complexity_of_project_allowed', 'all', ($complexity_of_project_allowed == 'all') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'complexity_of_project_allowed_all', $disabled]) }}
                        <span></span>{{ __('proposals.all') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('complexity_of_project_allowed', 'low_complexity', ($complexity_of_project_allowed == 'low_complexity') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'complexity_of_project_allowed_low_complexity', $disabled]) }}
                        <span></span>{{ __('proposals.low_complexity') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('complexity_of_project_allowed', 'medium_complexity', ($complexity_of_project_allowed == 'medium_complexity') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'complexity_of_project_allowed_medium_complexity', $disabled]) }}
                        <span></span>{{ __('proposals.medium_complexity') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('complexity_of_project_allowed', 'high_complexity', ($complexity_of_project_allowed == 'high_complexity') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'complexity_of_project_allowed_high_complexity', $disabled]) }}
                        <span></span>{{ __('proposals.high_complexity') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
                {!! Form::label('type_of_projects_allowed', __('proposals.type_of_projects_allowed')) !!}
                {!! Form::select('type_of_projects_allowed',[''=>'']+$projectTypes,$type_of_projects_allowed,['class' => 'form-control form-control-solid jsSelect2ClearAllow jsDisabled', 'data-placeholder'=>'Select type of projects allowed', $disabled])!!}
            </div>
            <div class="col-6 form-group">
                {!! Form::label('type_of_bond_allowed', __('proposals.type_of_bond_allowed')) !!}
                <div class="radio-inline">
                    <label class="radio col-4">
                        {{ Form::radio('type_of_bond_allowed', 'conditional', ($type_of_bond_allowed == 'conditional') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'type_of_bond_allowed_conditional', $disabled]) }}
                        <span></span>{{ __('proposals.conditional') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('type_of_bond_allowed', 'unconditional', ($type_of_bond_allowed == 'unconditional') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'type_of_bond_allowed_unconditional', $disabled]) }}
                        <span></span>{{ __('proposals.unconditional') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('type_of_bond_allowed', 'both',  ($type_of_bond_allowed == 'both') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'type_of_bond_allowed_both', $disabled]) }}
                        <span></span>{{ __('proposals.both') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
                {!! Form::label('work_type', __('proposals.work_type')) !!}
                {!! Form::select('work_type[]',$worktypes+['-1'=>'other'],$work_type,['class' => 'form-control jsSelect2ClearAllow jsWorkType', 'data-placeholder'=>'Select work type','multiple', $disabled])!!}
            </div>
            <div class="col-6 form-group">
                <div class="jsOtherWorkTypeDiv {{ $other_work_type_show }}">
                    {!! Form::label('other_work_type', __('proposals.other_work_type')) !!}<i class="text-danger">*</i>
                    {!! Form::text('other_work_type',$other_work_type, ['class' => 'form-control jsOtherWorkType required jsDisabled','data-rule-AlphabetsAndNumbersV4'=>true, $disabled]) !!}
                </div>
            </div>
            {{-- <div class="col-6 form-group">
                {!! Form::label('tenure', __('proposals.tenure')) !!}
                {!! Form::select('tenure',[''=>''] + $tenures,$tenure_id,['class' => 'form-control form-control-solid jsSelect2ClearAllow', 'data-placeholder'=>'Select tenure', $disabled])!!}
            </div> --}}
            <div class="col-6 form-group">
                {!! Form::label('strategic_nature_of_the_project', __('proposals.strategic_nature_of_the_project')) !!}
                <div class="radio-inline">
                    <label class="radio col-4">
                        {{ Form::radio('strategic_nature_of_the_project', 'high', ($strategic_nature_of_the_project == 'high') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'strategic_nature_of_the_project_high', $disabled]) }}
                        <span></span>{{ __('proposals.high') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('strategic_nature_of_the_project', 'medium', ($strategic_nature_of_the_project == 'medium') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'strategic_nature_of_the_project_medium', $disabled]) }}
                        <span></span>{{ __('proposals.medium') }}
                    </label>
                    <label class="radio col-4">
                        {{ Form::radio('strategic_nature_of_the_project', 'low', ($strategic_nature_of_the_project == 'low') ? true : '', ['class' => 'form-check-input jsDisabled', 'id' => 'strategic_nature_of_the_project_low', $disabled]) }}
                        <span></span>{{ __('proposals.low') }}
                    </label>
                </div>
            </div>
            <div class="col-6 form-group">
               <div class="col-10 float-left">
                {!! Form::label('attachment', __('proposals.attachment')) !!}<span class="text-danger">*</span>
                {!! Form::file('attachment', ['id' => 'attachment','class' => 'form-control jsDisabled', 'data-rule-extension'=>'xls|xlsx|doc|docx|pdf|jpg|jpeg|png', 'data-msg-extension'=>'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png','data-rule-filesize'=>'20971520', 'data-msg-filesize'=>'File size must be less than or equal to 20 MB','required'=>($attachment) ? false : true,$disabled]) !!}
                </div>
                <div class="col-2 float-left pt-11">
                @if($attachment)
                <a href="{{ asset($attachment) }}" target="__blank" download><i class="fa fa-download text-black"></i></a>
                @endif
                </div>  
            </div>
            <div class="col-12 form-group">
                {!! Form::label('remarks', __('proposals.remarks')) !!}<span class="text-danger">*</span>
                {!! Form::textArea('remarks', $remarks, ['class' => 'form-control'])!!}
                <label id="remarks-error" class="text-danger" for="remarks-error"></label>
            </div>
            <div class="col-12 form-group">
                <div class="row">
                    <div class="form-group col-12">
                        <div id="locationsRepeater">
                            <table class="table table-separate table-head-custom table-checkable tradeSector" id="locations" data-repeater-list="locations">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('proposals.state') }}<span class="text-danger">*</span></th>
                                        <th>{{ __('proposals.location') }}<span class="text-danger">*</span></th>
                                        <th width="20"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($location->count() > 0)
                                        @foreach($location as $l_key => $l_row)
                                            <tr data-repeater-item="" class="jslocationRow">
                                                <td class="jsListNo">{{ $loop->index+1 }}</td>
                                                <td>
                                                    {!! Form::select('state_id', ['' => ''] + $states, $l_row->state_id ?? null, ['class' => 'form-control required jsStateId jsDisabled','data-placeholder' => 'Select state', $disabled])
                                                    !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('location', $l_row->location ?? null, ['class' => 'form-control form-control-solid required jsReadOnly','data-rule-AlphabetsAndNumbersV1'=>true, 'readonly'])!!}
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr data-repeater-item="" class="jslocationRow">
                                        <td class="jsListNo">1</td>
                                        <td>
                                            {!! Form::select('state_id', ['' => ''] + $states, null, ['class' => 'form-control required jsStateId','data-placeholder' => 'Select state'])
                                            !!}
                                        </td>
                                        <td>
                                            {!! Form::text('location', null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV1'=>true])!!}
                                        </td>
                                        <td>
                                            <div class="jsLocationDelete">
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            @if($location->count() <= 0)
                            <div class="col-md-12 col-12">
                                <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm jsLocationAdd"><i class="fa fa-plus-circle"></i>{{ __('common.add') }}</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-6 form-group">
                {!! Form::label('user_id', __('proposals.underwriter')) !!}<i class="text-danger">*</i>
                {!! Form::select('user_id',[''=>'']+$users,$user_id,['class' => 'form-control form-control-solid jsSelect2ClearAllow required', 'data-placeholder'=>'Select underwriter',$underwriter_disabled])!!}
            </div> --}}
        </div>
        <div class="row card-footer pb-5 pt-5">
            <div class="col-12 text-right">
                <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                <button type="submit" class="btn btn-primary jsBtnLoader">{{ __('common.save_exit') }}</button>
            </div>
        </div>
    </div>
{!! Form::close() !!}



