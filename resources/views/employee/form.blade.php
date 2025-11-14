<div class="card card-custom gutter-b">
    <div class="card-body">
        <form class="form">
            <div class="row">
                {!! Form::hidden('user_id', $employee->user_id ?? null) !!}
                <div class="col-4 form-group">
                    {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('first_name', $user_data->first_name ?? null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
                    {!! Form::text('middle_name', $user_data->middle_name ?? null, ['class' => 'form-control', 'data-rule-AlphabetsV1' => true,]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('last_name', $user_data->last_name ?? null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label(__('employee.designation_id'), __('employee.designation')) !!}<i class="text-danger">*</i>
                    {!! Form::select('designation_id', ['' => ''] + $designation_id, null, [
                        'class' => 'form-control required',
                        'style' => 'width:100%;',
                        'id' => 'designation_id',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

                    {{ Form::text('email', $user_data->email ?? null, [
                        'class' => 'form-control email',
                        'required',
                        'data-rule-remote' => route('common.checkUniqueEmail', [
                            'id' => $employee['user_id'] ?? '',
                        ]),
                        'data-msg-remote' => 'The email has already been taken.',
                    ]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('common.mobile'), __('common.mobile')) !!}<i class="text-danger">*</i>
                    {{ Form::text('mobile', $user_data->mobile ?? null, ['class' => 'form-control number', 'required', 'data-rule-MobileNo' => true, 'data-rule-remote' => route('common.checkUniqueField', [
                        'field' => 'mobile',
                        'model' => 'users',
                        'id' => $employee->user_id ?? '',
                    ]),
                    'data-msg-remote' => 'The Phone No. has already been taken.',]) }}
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

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label(__('common.address'), __('common.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) }}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('common.post_code'), __('common.post_code')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
                    {!! Form::text('post_code', null, ['class' => 'form-control jsPinCode post_code',]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    <div class="d-block">
                        {!! Form::label(__('employee.photo'), __('employee.photo')) !!}<i class="text-danger">*</i>
                    </div>
                    <div class="d-block jsDivClass">
                        {!! Form::file('photo[]', [
                            'id' => 'photo',
                            'class' => 'photo jsDocument',
                            empty($dms_data) ? 'required' : '',
                            'multiple',
                            'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}

                        @php
                            $data_employee_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_employee_attachment == 0 ? 'disabled' : '';
                        @endphp
                        {{-- <a href="{{ route('dMSDocument', $employee->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $employee->id ?? '', 'attachment_type' => 'photo', 'dmsable_type' => 'Employee']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}"
                            data-prefix="employee_attachment" data-delete="jsEmployeeAttachmentDeleted">
                            <span class="navi-icon"><span class="length_employee_attachment"
                                    data-employee_attachment ='{{ $data_employee_attachment }}'>{{ $data_employee_attachment }}</span>&nbsp;Document</span>
                        </a> --}}

                        <a href="#" data-toggle="modal" data-target="#photo_modal"
                        class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsEmployeeAttachmentDeleted" data-prefix="photo"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                            <span class = "count_photo" data-count_photo = "{{ $data_employee_attachment }}">{{ $data_employee_attachment }}&nbsp;document</span>
                        </a>

                        <div class="modal fade" tabindex="-1" id="photo_modal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Employee Photo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <a class="jsFileRemove"></a>
                                        @if (isset($employee) && isset($dms_data) && count($dms_data) > 0)
                                            @foreach ($dms_data as $index => $documents)
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="dms_photo">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="photo" data-url="{{ route('removeDmsAttachment') }}"
                                                                    data-id="{{ $documents->id }}"></i></a>
                                                                <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                                </a>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @else
                                            {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
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
    <div id="load-modal"></div>
</div>

@section('scripts')
    @include('employee.script')
@endsection
