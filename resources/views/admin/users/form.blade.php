@section('styles')
    <style type="text/css">
        .select2-container .select2-search--inline .select2-search__field {
            margin-bottom: 4px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/custom/kendotree/kendo.common.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/custom/kendotree/kendo.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/custom/kendotree/kendo.default.mobile.min.css') }}" />
@endsection

<div class="row">
    <div class="form-group col-lg-4">
        {{-- {!! Form::label('emp_type', trans('users.form.user_type')) !!}<i class="text-danger">*</i> --}}
        <div class="radio-inline pt-4">
            {{-- <label class="radio radio-rounded">
                {{ Form::radio('emp_type', 'employee', (isset($users)) ? 'null':'true', ['class'=>'form-check-input emp_type required', 'id' => 'employee']) }}
                <span></span>{{__("users.form.employee")}}                           
            </label> --}}

            {{-- <label class="radio radio-rounded">
                {{ Form::radio('emp_type', 'non-employee', null, ['class' => 'form-check-input emp_type required', 'id' => 'non-employee']) }}
                <span></span>{{ __('users.form.non-employee') }}
            </label> --}}
        </div>
    </div>
    {{-- <div class="form-group col-lg-8 employeeData" style="display:{{(isset($users) && $users->emp_type == 'non-employee') ? 'none':'block'}}">
        {!! Form::label('emp_id',trans("users.form.employee_name"))!!}<i class="text-danger">*</i>
        {{Form::select('emp_id', [''=>"select"]+$employees, null, ['class'=>'form-control','id' => 'emp_id','data-placeholder'=>'Select Employee']) }} 
    </div> --}}
</div>
<div class="row">
    @if(in_array($user_type->slug ?? null,['beneficiary','contractor']))
        <div class="form-group col-lg-4">
            {!! Form::label('first_name', trans('users.form.first_name')) !!}<span class="text-danger">*</span>
            {!! Form::text('first_name', null, ['class' => "form-control required {$control_solid}", 'id' => 'first_name', $readonly, 'data-rule-AlphabetsAndNumbersV8' => true,]) !!}
        </div>
    @else
        <div class="form-group col-lg-4">
            {!! Form::label('first_name', trans('users.form.first_name')) !!}<span class="text-danger">*</span>
            {!! Form::text('first_name', null, ['class' => "form-control required {$control_solid}", 'id' => 'first_name', $readonly, 'data-rule-AlphabetsV1' => true,]) !!}
        </div>
        <div class="form-group col-lg-4">
            {!! Form::label('middle_name', trans('users.form.middle_name')) !!}
            {!! Form::text('middle_name', null, ['class' => "form-control {$control_solid}", 'id' => 'middle_name', $readonly, 'data-rule-AlphabetsV1' => true,]) !!}
        </div>
        <div class="form-group col-lg-4">
            {!! Form::label('last_name', trans('users.form.last_name')) !!}<span class="text-danger">*</span>
            {!! Form::text('last_name', null, ['class' => "form-control {$control_solid} required", 'id' => 'last_name', $readonly, 'data-rule-AlphabetsV1' => true,]) !!}
        </div>
    @endif
</div>
<div class="row">
    <div class="form-group col-lg-4">
        {!! Form::label('email', trans('users.form.email')) !!}<span class="text-danger">*</span>
        {!! Form::email('email', null, [
            'class' => "form-control {$control_solid} required email", 
            'id' => 'email', 
             'data-rule-remote' => route('common.checkUniqueEmail', [
                        'id' => $users['id'] ?? '',
             ]),
            'data-msg-remote' => 'The email has already been taken.',
            $readonly]) 
        !!}
    </div>
    <div class="form-group col-lg-4">
       {!! Form::label('password', trans('users.form.password')) !!}<span class="text-danger">*</span>
        <div class="input-group">
            {!! Form::password('password', [
                'class' => !isset($users) ? 'form-control pr-password validate_password required js-show-password-input' : 'form-control js-show-password-input validate_password pr-password',
                'autocomplete' => 'off',
                'id' => 'password',
                'minlength' => 8,
                'pattern' => "(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$",
            ]) !!}
            @if ($errors->has('password'))
                <span class="text-danger">
                {{ $errors->first('password') }}
                </span>
            @endif
            <div class="input-group-append cursor-pointer">
                <span class="input-group-text js-show-password"><i class="fas fa-light fa-eye js-show-password-icon"></i></span>
            </div>
            <small>{{ __('users.form.password_note') }}</small>
        </div>
    </div>
    <div class="form-group col-lg-4">
        {!! Form::label('password_confirmation', trans('users.form.confirm_password')) !!}<span class="text-danger">*</span>
        <div class="input-group">
        {!! Form::password('password_confirmation', [
            'class' => !isset($users) ? 'form-control validate_password required js-show-password-input' : 'form-control js-show-password-input validate_password',
            'autocomplete' => 'off',
            'equalto' => '#password',
            'minlength' => 8,
            'data-rule-equalTo' => ".pr-password"
        ]) !!}
          <div class="input-group-append cursor-pointer"><span class="input-group-text js-show-password"><i class="fas fa-light fa-eye js-show-password-icon"></i></span></div>
        </div>
    </div>
</div>

<div class="row">
    {{-- <div class="form-group col-lg-4">
        {!! Form::label('gender',trans("users.form.gender"))!!}<i class="text-danger">*</i>
        <div class="radio-inline pt-4">
            <label class="radio radio-rounded">
                {{ Form::radio('gender', 'Male', true, ['class'=>'form-check-input required', 'id' => 'male']) }}
                <span></span>{{__("users.form.male")}}                           
            </label>
            <label class="radio radio-rounded">
                {{ Form::radio('gender', 'Female', '', ['class'=>'form-check-input required', 'id' => 'female']) }}
                <span></span>{{__('users.form.female')}}
            </label>
        </div>
    </div> --}}
    <div class="form-group col-lg-4">
        @if(in_array($user_type->slug ?? null,['beneficiary']))
            {!! Form::label('mobile', trans('users.form.mobile')) !!}
            {!! Form::number('mobile', null, [
                'class' => "form-control number",
                'id' => 'mobile',
                'data-rule-MobileNo' => true,
            ]) !!}
        @else
            {!! Form::label('mobile', trans('users.form.mobile')) !!}<span class="text-danger">*</span>
            {!! Form::number('mobile', null, [
                'class' => "form-control {$control_solid}  number",
                'id' => 'mobile',
                'data-rule-MobileNo' => true,
                $readonly,
            ]) !!}
        @endif
    </div>
    <div class="form-group col-lg-4">
        {!! Form::label('roles_id', trans('users.form.roles')) !!}<i class="text-danger">*</i>
        {{ Form::select('roles_id', ['' => 'select'] + $roles, null, ['class' => 'form-control required cls-role', 'data-placeholder' => 'Select Roles',$disabled]) }}
    </div>

</div>

@if ($show_cap_limit_input)
    <div class="row">
    <div class="col-4 form-group">
        {!! Form::label('max_approved_limit', __('users.form.max_approved_limit')) !!}<i
            class="text-danger">*</i>
        {!! Form::number('max_approved_limit', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('individual_cap', __('users.form.individual_cap')) !!}<i
            class="text-danger">*</i>
        {!! Form::number('individual_cap', null, [
            'class' => 'form-control required',
            'id' => 'individual_cap',
            'data-rule-Numbers' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('overall_cap', __('users.form.overall_cap')) !!}<i
            class="text-danger">*</i>
        {!! Form::number('overall_cap', null, [
            'class' => 'form-control required',
            'id' => 'overall_cap',
            'data-rule-Numbers' => true,
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('group_cap', __('users.form.group_cap')) !!}<i
            class="text-danger">*</i>
        {!! Form::number('group_cap', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) !!}
    </div>
</div>

<hr>

<div class="row">
    <div class="col-4 form-group">
        <h6><strong>{{ __('users.form.claim_examiners_max_approved_limit') }}</strong></h6>
        {!! Form::label('claim_examiner_max_approved_limit', __('users.form.max_approved_limit')) !!}<i class="text-danger">*</i>
        {!! Form::number('claim_examiner_max_approved_limit', null, ['class' => 'form-control required', 'data-rule-Numbers' => true,]) !!}
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="form-group col-lg-6">
                <div class="checkbox-inline pt-1">
                    <label class="checkbox checkbox-square">
                        {!! Form::checkbox('is_ip_base', '1', null, ['id' => 'is_ip_base', 'class' => 'is_ip_base']) !!}
                        <span></span>{!! Form::label('is_ip_base', trans('users.form.is_ip_base'), ['class' => 'mt-2']) !!}</label>
                </div>
            </div>
            @if ($current_user->hasAnyAccess(['users.superadmin']))
                <div class="form-group col-lg-6">
                    <div class="checkbox-inline pt-1">
                        <label class="checkbox checkbox-square">
                            {!! Form::checkbox('make_super_admin', '1', null, ['id' => 'make_super_admin', 'class' => 'make_super_admin']) !!}
                            <span></span>{!! Form::label('make_super_admin', trans('users.form.create_superadmin'), ['class' => 'mt-2']) !!}</label>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <div class="checkbox-inline pt-1">
                </div>
            </div>
            @if ($current_user->hasAnyAccess(['users.superadmin']))
                <div class="form-group col-lg-6">
                    <div class="checkbox-inline pt-1">
                        <label class="checkbox checkbox-square">
                            {!! Form::checkbox('allow_multi_login', '1', null, [
                                'id' => 'allow_multi_login',
                                'class' => 'allow_multi_login',
                            ]) !!}
                            <span></span>{!! Form::label('allow_multi_login', trans('Allow Multi Login'), ['class' => 'mt-2']) !!}</label>
                    </div>
                </div>
            @endif
        </div>
        <div class="row ipRepeaterData"
            style="display:{{ isset($users) && $users->is_ip_base == 1 ? 'block' : 'none' }}">
            <div class="form-group col-lg-6">
                <div id="ip_repeater">
                    <table class="table table-separate table-head-custom table-checkable" data-repeater-list="loginips">
                        <thead>
                            <tr>
                                <th>{{ __('common.no') }}</th>
                                <th>{{ __('users.form.ip_address') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($users) && count($users->userIps) > 0)
                                @foreach ($users->userIps as $key => $item)
                                    <tr data-repeater-item="">
                                        <td class="list-no">{{ ++$key }} . </td>
                                        <input type="hidden" name="ip_id" value="{{ $item->id }}">
                                        <td>{!! Form::text('login_ip', $item->login_ip, ['class' => 'form-control loginip', 'id' => 'login_ip' . $key]) !!}</td>
                                        <td>
                                            <a href="javascript:;" data-repeater-delete=""
                                                class="btn btn-sm btn-icon btn-danger mr-2">
                                                <i class="flaticon-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr data-repeater-item="">
                                    <td class="list-no">1 . </td>
                                    <td>{!! Form::text('login_ip', null, ['class' => 'form-control loginip', 'id' => 'login_ip1']) !!}</td>
                                    <td>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="javascript:;" data-repeater-create=""
                                class="btn btn-sm font-weight-bolder btn-light-primary">
                                <i class="flaticon2-plus"></i>{{ __('common.add') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group col-lg-12">
            <div>
                <h6>Permissions</h6>
                <div id="treeview" class="cls-treeview"></div>
            </div>
            {!! Form::hidden('user_permission', '', ['id' => 'user_permission']) !!}
        </div>
    </div>
</div>

<div class="card-footer">
    <div class="row">
        <div class="col-12 text-right">
            {!! link_to(URL::full(), __('common.cancel'), ['class' => 'mr-3']) !!}
            {!! Form::submit(__('common.save'), ['name' => 'save', 'class' => 'btn btn-primary']) !!}
            {{-- <a href="#" class="btn btn-primary font-weight-bold mr-2">{{__('common.save')}}</a> --}}
        </div>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('plugins/custom/kendotree/kendo.all.min.js') }}"></script>
    <script src="{{asset('js/custome/input-password-show.js')}}"></script>
    <script type="text/javascript">
        function favicon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photo").change(function() {
            favicon(this);
        });
    </script>
    @include('admin.users.script')
@endsection
