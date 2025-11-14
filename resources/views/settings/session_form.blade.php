{!! Form::open(['route' => 'settings.store', 'id' => 'session_form']) !!}
{{ Form::hidden('group', 'session') }}

{{-- @if ($current_user->hasAnyAccess(['users.superadmin'])) --}}
    <div class="row">
        <div class="form-group col-lg-4">
            {{ Form::label(__('settings.session_expire_time'), __('settings.session_expire_time')) }}<i
                class="text-danger">*</i>
            {{ Form::number('session_expire_time', $settings['session_expire_time'] ?? null, [
                'class' => 'form-control',
                'required',
                'min' => '0',
                'max' => '999',
            ]) }}
        </div>

        <div class="form-group col-lg-4 mt-9">
            <a href="{{ route('session-delete', ['type' => 'Web']) }}" data-redirect="{{ route('settings.index') }}"
                data-message="Do you want to clear All Web Session ?"
                class="btn btn-facebook font-weight-bold delete-session form-control">
                <i class="fa-1x fa-globe fas"></i>{{ __('settings.web_session_exp') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label(__('settings.token_expire_time'), __('settings.token_expire_time')) }}<i
                class="text-danger">*</i>
            {{ Form::number('token_expire_time', $settings['token_expire_time'] ?? null, [
                'class' => 'form-control',
                'required',
                'min' => '0',
                'max' => '30',
            ]) }}
        </div>
    </div>

    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('proposal_auto_save_duration', __('settings.proposal_auto_save_duration')) }}<i
                class="text-danger">*</i>
            {{ Form::number('proposal_auto_save_duration', $settings['proposal_auto_save_duration'] ?? null, [
                'class' => 'form-control',
                'required',
                'min' => '2',
                'max' => '60',
                'data-rule-Numbers' => true,
            ]) }}
        </div>

        <div class="col-4 form-group">
            {{-- @dd($settings['is_proposal_auto_save']) --}}
            {!! Form::label('is_proposal_auto_save', __('settings.is_proposal_auto_save')) !!}

            <div class="checkbox-inline pt-1">
                <label class="checkbox checkbox-square">
                    {!! Form::checkbox('is_proposal_auto_save', $settings['is_proposal_auto_save'] ?? 'No',($settings['is_proposal_auto_save'] ?? 'No') == 'Yes' ? true : false, [
                        'class' => 'is_proposal_auto_save',
                    ]) !!}
                    <span></span>
                    {!! Form::label('proposal_auto_save', null, ['class' => 'mt-2 is_proposal_auto_save']) !!}
                </label>
            </div>
        </div>
    </div>
{{-- @endif --}}

<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
    </div>
</div>

{!! Form::close() !!}

@section('scripts')
    <script type="text/javascript">
        $(document).on('click', '.delete-session', function(e) {
            e.preventDefault();

            var el = $(this);
            var url = el.attr('href');
            var redirect = el.attr('data-redirect');
            var type = el.data('type');
            var id = el.data('id');
            var refresh = '#' + el.data().table;
            var dataMessage = el.attr('data-message');
            var confirmMessage = "Do you want to delete All Session ?";
            if (dataMessage && dataMessage != '') {
                confirmMessage = dataMessage;
            }

            message.fire({
                title: 'Are you sure',
                text: confirmMessage,
                type: 'warning',
                customClass: {
                    confirmButton: 'btn btn-success shadow-sm mr-2',
                    cancelButton: 'btn btn-danger shadow-sm'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.value) {
                    //showLoader();
                    $.ajax({
                        type: "POST",
                        url: url,
                        cache: false,
                        data: {
                            id: id,
                            _method: 'DELETE'
                        }
                    }).always(function(respons) {
                        //stopLoader();
                        if (redirect) {
                            if (respons.success) {
                                window.location = redirect;
                            }
                        } else {
                            if (respons.page_refresh) {
                                location.reload();
                            } else {
                                // window.location.href = redirect;
                                $(refresh).DataTable().ajax.reload();
                            }
                        }

                    }).done(function(respons) {
                        if (respons.success) {
                            toastr.success(respons.message, "Success");
                        } else {
                            toastr.error(respons.message, "Error");
                        }
                    }).fail(function(respons) {
                        var res = respons.responseJSON;
                        var msg = 'something went wrong please try again !';

                        if (res.errormessage) {
                            toastr.warning(res.errormessage, "Warning");
                        }
                        toastr.error(msg, "Error");
                    });
                }
            });

        });
    </script>
@endsection
