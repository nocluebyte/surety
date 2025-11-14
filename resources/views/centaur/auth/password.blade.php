@include('partials._loginheader.login-header')
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled sidebar-enabled page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-4 d-flex flex-row-fluid login-signin-on" id="kt_login">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
                style="background-image: url('{{ asset('media/bg/bg-3.jpg') }}')">
                <!--begin: Aside Container-->
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <!--begin::Logo-->
                    <div class="d-flex flex-center">
                        <a href="#" class="text-center pt-2">
                            <img src="{{ asset($logo) }}" class="w-235px" alt="" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Aside body-->
                    <div class="d-flex flex-column-fluid flex-column flex-center">
                        <!--begin::Signin-->
                        <div class="login-form login-signin py-11">
                            <!--begin::Form-->

                            {!! Form::open([
                                'route' => ['auth.password.reset.attempt', $code],
                                'role' => 'form',
                                'id' => 'reset_password_form',
                                'class' => 'form',
                            ]) !!}
                            <div class="text-center pb-10">
                                <h3>{{ $project_title ?? '' }}</h3>

                            </div>

                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h4 font-size-h4-lg">Reset Your
                                    Password</h2>

                            </div>
                            @if ($message = Session::get('error'))
                                <div role="alert" class="alert alert-danger">
                                    <div class="alert-text">{{ Session::get('error') }}</div>
                                </div>
                            @endif

                            @if ($message = Session::get('success'))
                                <div role="alert" class="alert alert-success">
                                    <div class="alert-text">{{ Session::get('success') }}</div>
                                </div>
                            @endif
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group mb-5 fv-plugins-icon-container text-left">
                                {!! Form::label('password', 'Password', ['class' => 'pt-5']) !!}<i class="text-danger">*</i>
                                <div class="input-group">
                                    {!! Form::password('password', [
                                        'class' => 'form-control form-control-solid h-auto py-4 px-8 required js-show-password-input pr-password validate_password',
                                        'autocomplete' => 'off',
                                        'minlength' => 8,
                                        'id' => 'password',
                                    ]) !!}
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                        {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                    <div class="input-group-append cursor-pointer"><span class="input-group-text js-show-password"><i class="fas fa-light fa-eye js-show-password-icon"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group mb-5 fv-plugins-icon-container text-left">
                                <div class="justify-content-between mt-n5">
                                    {!! Form::label('password_confirmation', 'Confirm Password', [
                                        'class' => 'pt-5',
                                    ]) !!}<i class="text-danger">*</i>
                                </div>
                                <div class="input-group">
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control validate_password form-control-solid h-auto py-4 px-8 required js-show-password-input',
                                        'autocomplete' => 'off',
                                        'equalto' => '#password',
                                        'data-msg-equalTo' => 'Please enter password and confirm password same.',
                                        'minlength' => 8,
                                        'data-rule-equalTo' => ".pr-password",
                                    ]) !!}
                                    <div class="input-group-append cursor-pointer"><span class="input-group-text js-show-password"><i class="fas fa-light fa-eye js-show-password-icon"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="text-center pt-2">
                                {!! Form::submit('Save', [
                                    'name' => 'btnsave',
                                    'class' => 'btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3',
                                ]) !!}

                            </div>
                            <!--end::Action-->
                            {!! Form::close() !!}
                            <!--end::Form-->
                        </div>
                        <!--end::Signin-->


                    </div>
                    <!--end::Aside body-->

                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
{{-- @section('scripts') --}}
    <script>
        var KTAppSettings = '';
    </script>
    <script src="{{ asset('js/jquery-validation/jquery.passwordRequirements.js') }}"></script>
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
    {{-- <script src="{{ asset('/js/pages/custom/login/reset.js') }}"></script> --}}
    <script src="{{asset('js/custome/input-password-show.js')}}"></script>
    <script src="{{asset('js/jquery-validation/jquery.passwordRequirements.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        var initValidation = function() {
            $("#reset_password_form").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password_confirmation: {
                        equalTo: "Please enter password and confirm password same."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                }
            });
        }
        
        $(".validate_password").passwordRequirements({
            numCharacters: 8,
            useLowercase:true,
            useUppercase:true,
            useNumbers:true,
            useSpecial:true
        });
    </script>
{{-- @endsection --}}
</body>
<!--end::Body-->

</html>
