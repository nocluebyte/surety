<div class="card card-custom gutter-b">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-6">
                {!! Form::label('type', __('common.type')) !!}<i class="text-danger">*</i>
                <div class="radio-inline pt-4">
                    <label class="radio">
                        {!! Form::radio('type', 'agent', null, ['class' => 'form-check-input type', 'disabled']) !!}
                        <span></span>Agent
                    </label>
                    <label class="radio">
                        {!! Form::radio('type', 'broker', null, ['disabled', 'class' => 'form-check-input type']) !!}
                        <span></span>Broker
                    </label>
                    <label class="radio">
                        {!! Form::radio('type', 'beneficiary', true, ['disabled', 'class' => 'form-check-input type']) !!}
                        <span></span>Beneficiary
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            {!! Form::hidden('user_id', $relationship_manager->user_id ?? null) !!}
            <div class="col-4 form-group">
                {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
                {!! Form::text('first_name',$relationship_manager->user->first_name ?? null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
                {!! Form::text('middle_name', $relationship_manager->user->middle_name ?? null, ['class' => 'form-control', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
                {!! Form::text('last_name',$relationship_manager->user->last_name ?? null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

                {{ Form::text('email',$relationship_manager->user->email ?? null, [
                    'class' => 'form-control email',
                    'required',
                    'data-rule-remote' => route('common.checkUniqueEmail', [
                        'id' => $relationship_manager['user_id'] ?? '',
                    ]),
                    'data-msg-remote' => 'The email has already been taken.',
                ]) }}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.mobile'), __('common.mobile')) !!}<i class="text-danger">*</i>
                {{ Form::text('mobile',$relationship_manager->user->mobile ?? null, ['class' => 'form-control number required', 'data-rule-MobileNo' => true, 'data-rule-remote' => route('common.checkUniqueField', [
                    'field' => 'mobile',
                    'model' => 'users',
                    'id' => $relationship_manager->user_id ?? '',
                ]),
                'data-msg-remote' => 'The Phone No. has already been taken.',]) }}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.post_code'), __('common.post_code')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
                {!! Form::text('post_code', null, ['class' => 'form-control jsPinCode post_code']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-12 form-group">
                {!! Form::label(__('common.address'), __('common.address')) !!}<i class="text-danger">*</i>
                {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
                {!! Form::select('country_id', ['' => ''] + $countries, null, [
                    'class' => 'form-control required',
                    'style' => 'width: 100%;',
                    'id' => 'country',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
                {!! Form::select('state_id', ['' => ''] + $states, null, [
                    'class' => 'form-control required',
                    'style' => 'width: 100%;',
                    'id' => 'state',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
                {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) }}
            </div>
        </div>

        <div class="rm_users">
            <div class="row">
                <div class="form-group col-12">
                    <div id="rmUsersRepeater">
                        <div class="row">
                            <div class="col-4">
                                {{ Form::label('user',__('common.user')) }}
                                {{ Form::select('user', [''=>''] + $users, null, ['class' =>'form-control jsUser jsSelect2ClearAllow','data-placeholder' => 'Select User'], $rmUsersOptions) }}
                            </div>
                            <div class="col-4">
                                <label>&nbsp;</label><br>
                                <button class="btn btn-primary" type="button" data-repeater-create>Add</button>
                            </div>
                        </div>
                        <table class="table table-separate table-head-custom table-checkable rmUsers" id="machine"
                            data-repeater-list="rmUsers">
                            <p class="text-danger d-none"></p>
                            <thead>
                                <tr>
                                    <th>{{__('common.no')}}</th>
                                    <th>{{__('common.name')}}</th>
                                    <th>{{__('common.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($rmUsers) && $rmUsers->count() > 0)
                                    @foreach ($rmUsers as $key => $item)
                                        <tr data-repeater-item="" class="rm_user_row">
                                            <td class="rm-list-no">{{ ++$key }} . </td>
                                            <input type="hidden" name="rm_user_item_id" value="{{ $item->id }}">
                                            <td>
                                                <input type="hidden" name="rm_user_id" class="rm_user_id" value="{{ $item->user_id }}">
                                                {!! Form::text('user_name', $item->user->first_name ?? '' . $item->user->middle_name ?? '' . $item->user->last_name ?? '', [
                                                    'class' => 'form-control user_name form-control-solid', 'readonly',
                                                ]) !!}
                                            </td>
                                            <td>
                                                <div class="rm_user_delete">
                                                    <a href="javascript:;" data-repeater-delete="{{ $item->id }}" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr data-repeater-item="" class="rm_user_row">
                                        <td class="rm-list-no">1</td>
                                        <td>
                                            <input type="hidden" name="rm_user_item_id" value="" class="">
                                            {!! Form::hidden('rm_user_id', null, ['class' => 'form-control contractCls rm_user_id']) !!}
                                            {!! Form::text('user_name', null, [
                                                'class' => 'form-control user_name form-control-solid', 'readonly',
                                            ]) !!}
                                        </td>
                                        <td>
                                            <div class="rm_user_delete">
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
    </div>
</div>

@section('scripts')
    @include('relationship_manager.script')
@endsection
