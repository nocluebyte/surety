<div class="card card-custom gutter-b">
    <div class="card-body">
        <form class="form">
            <div class="row">
                {!! Form::hidden('user_id', $agent->user_id ?? null) !!}
                <div class="col-4 form-group">
                    {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('first_name', $agent->user->first_name ?? null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
                    {!! Form::text('middle_name', $agent->user->middle_name ?? null, [
                        'class' => 'form-control',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('last_name', $agent->user->last_name ?? null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

                    {{ Form::email('email', $agent->user->email ?? null, [
                        'class' => 'form-control email',
                        'required',
                        'data-rule-remote' => route('common.checkUniqueEmail', [
                            'id' => $agent->user_id ?? '',
                        ]),
                        'data-msg-remote' => 'The email has already been taken.',
                    ]) }}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('common.phone_no'), __('common.phone_no')) !!}<i class="text-danger">*</i>
                    {{ Form::text('mobile', $agent->user->mobile ?? null, [
                        'class' => 'form-control number required',
                        'data-rule-MobileNo' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'mobile',
                            'model' => 'users',
                            'id' => $agent->user_id ?? '',
                        ]),
                        'data-msg-remote' => 'The Phone No. has already been taken.',
                    ]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
                    {!! Form::select('country_id', ['' => ''] + $countries, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'country',
                        'data-placeholder' => 'Select country',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
                    {!! Form::select('state_id', ['' => ''] + $states, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'state',
                        'data-placeholder' => 'Select state',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
                    {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label(__('common.address'), __('common.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>

                <div class="col-6 form-group JsPanNo {{ $isCountryIndia ? '' : 'd-none' }}">
                    {!! Form::label(__('common.pan_no'), __('common.pan_no')) !!}<i class="text-danger">*</i>

                    {{ Form::text('pan_no', null, [
                        'class' => 'form-control pan_no required',
                        'data-rule-remote' => route('common.checkUniquePanNumber', [
                            'field' => 'agents',
                            'id' => $agent->id ?? '',
                        ]),
                        'data-msg-remote' => 'PAN No. has already been taken.',
                        'data-rule-PanNo' => true,
                    ]) }}
                </div>
            </div>

            <hr>

            <h5><strong>{{ __('agent.intermediary_details') }}</strong></h5>

            <div class="row">
                <div class="form-group col-12">
                    <div id="intermediaryRepeater">
                        <table class="table table-separate table-head-custom table-checkable intermediaryDetail" id="machine"
                            data-repeater-list="intermediaryDetails">
                            <p class="text-danger d-none"></p>
                            <thead>
                                <tr>
                                    <th width="5">{{ __('common.no') }}</th>
                                    <th>{{ __('common.code') }}<i class="text-danger">*</i></th>
                                    <th>{{ __('common.name') }}<i class="text-danger">*</i></th>
                                    <th>{{ __('common.phone_no') }}<i class="text-danger">*</i></th>
                                    <th>{{ __('common.email') }}</th>
                                    <th>{{ __('common.address') }}<i class="text-danger">*</i></th>
                                    <th width="20"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($agent) && count($agent->intermediaryDetails) > 0)
                                    @foreach ($agent->intermediaryDetails as $key => $item)
                                        <tr data-repeater-item="" class="intermediary_detail_row">
                                            <td class="intermediary-list-no">{{ ++$key }} . </td>
                                            <input type="hidden" name="intermediary_item_id" value="{{ $item->id }}">
                                            <td>
                                                {!! Form::text('code', $item->code ?? null, ['class' => 'form-control required']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('name', $item->name ?? null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('mobile', $item->mobile ?? null, ['class' => 'form-control number required', 'data-rule-MobileNo' => true]) !!}
                                            </td>
                                            <td>
                                                {!! Form::email('email', $item->email ?? null, ['class' => 'form-control']) !!}
                                            </td>
                                            <td>
                                                {{ Form::textarea('address', $item->address ?? null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                                            </td>
                                            <td>
                                                <a href="javascript:;" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-danger mr-2 intermediary_detail_delete">
                                                    <i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr data-repeater-item="" class="intermediary_detail_row">
                                        <td class="intermediary-list-no">1</td>
                                        <td>
                                            {!! Form::text('code','', ['class' => 'form-control required']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('name','', ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('mobile','', ['class' => 'form-control number required', 'data-rule-MobileNo' => true]) !!}
                                        </td>
                                        <td>
                                            {!! Form::email('email','', ['class' => 'form-control']) !!}
                                        </td>
                                        <td>
                                            {{ Form::textarea('address','', ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                                        </td>
                                        <td>
                                            <a href="javascript:;" data-repeater-delete=""
                                                class="btn btn-sm btn-icon btn-danger mr-2 intermediary_detail_delete">
                                                <i class="flaticon-delete"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="col-md-12 col-12">
                            <button type="button" data-repeater-create=""
                                class="btn btn-outline-primary btn-sm intermediary_detail_create"><i class="fa fa-plus-circle"></i>
                                Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row card-footer pb-5 pt-5">
                <div class="col-12 text-right">
                    <input class="jsSaveType" name="save_type" type="hidden">
                    <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                    <button type="submit" id="btn_loader_save" class="btn btn-primary jsBtnLoader"
                        name="saveBtn">{{ __('common.save') }}</button>
                    <button type="submit" id="btn_loader" class="btn btn-primary jsBtnLoader"
                        name="saveExitBtn">{{ __('common.save_exit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
    @include('agent.script')
@endsection
