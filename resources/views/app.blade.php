<!DOCTYPE html>
<html lang="en">

<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ !empty($setting) && $setting != '' ? $setting['value'] : '' }}</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- <link rel="canonical" href="https://keenthemes.com/metronic" /> --}}
    <!--begin::Fonts-->
    {{-- {{ Metronic::getGoogleFontsInclude() }} --}}
    <!--end::Fonts-->
    <style type="text/css">
        .display-filter {
            display: none;
        }

        /* custom font color for table tr & th tags */
        .custom-tr-th-color thead th,
        .custom-tr-th-color thead tr {
            color: #3f4254 !important;
        }

        /* custom font color for table tr & th tags */
        /* .dataTables_scrollBody{
            overflow-y: unset !important;
        } */
        @media screen and (max-width: 1200px) {
            .repeater-scrolling-wrapper {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;

                .card {
                    display: inline-block;
                }
            }
        }

        .upperCase {
            text-transform: uppercase;
        }

        .min-width-100 {
            min-width: 100px!important;
        }
        .min-width-150 {
            min-width: 150px!important;
        }
        .min-width-200 {
            min-width: 200px!important;
        }
        .min-width-300 {
            min-width: 300px!important;
        }
        .min-width-500 {
            min-width: 500px!important;
        }
        .uw_view_dwidth span.select2-container {
            width: 97% !important;
        }
        .invocationNotificationAccordion td, .recoveriesAccordion td {
            border: 0px !important;
        }
        .ck-editor {
            z-index: 0;
        }

        /*    background-color: #eee5ff;*/
    </style>
    <!--end::Page Vendors Styles-->

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach (config('layout.resources.css') as $style)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}"
            rel="stylesheet" type="text/css" />
    @endforeach
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">
    <!--end::Layout Themes-->
    <!-- calender -->
    <link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.bundle.css') }}" type="text/css">
    <link rel="shortcut icon"
        href="{{ isset($favicon) && !empty($favicon) ? asset($favicon) : asset('default.jpg') }}" />
    {{-- Includable CSS --}}
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('css/jquery.passwordRequirements.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/report.css')}}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.1.0/ckeditor5.css">
    @yield('styles')
</head>

<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
    @php
        $defultYear = getDefaultYear();
        $formDate = $toDate = '';
        if ($defultYear) {
            $formDate = $defultYear->from_date;
            $toDate = $defultYear->to_date;
        }
    @endphp
    @include('layout')
    <!--[html-partial:include:{"file":"layout.html"}]/-->
    @include('partials._extras.offcanvas.quick-notifications')
    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-notifications.html"}]/-->
    @include('partials._extras.offcanvas.quick-actions')
    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-master.html"}]/-->
    @include('partials._extras.offcanvas.quick-master')
    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-actions.html"}]/-->
    @include('partials._extras.offcanvas.quick-user')
    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->
    @include('partials._extras.offcanvas.quick-panel')
    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-panel.html"}]/-->
    @include('partials._extras.scrolltop')
    <!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
    <script>
        var HOST_URL = "";
    </script>

    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#8950FC",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->

    <!--end::Global Config-->

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach (config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <!-- Sweetalert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <!-- Validation -->
    <script src="{{ asset('js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('js/fancybox.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/jquery.passwordRequirements.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/jquery.passwordRequirements.min.js') }}"></script>
    <script src="{{ asset('js/custom-validation/custom-validation.js') }}"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script> --}}
    <script defer src="{{asset('js/custome/prevent_inspect.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>


    <!--end::Page Scripts-->
    {{-- Includable JS --}}
    <script type="text/javascript">
        var page_show_entriess = parseInt("{{ config('srtpl.settings.page_show_entries', 25) }}");
        var colVisIcon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M1.5,5 L4.5,5 C5.32842712,5 6,5.67157288 6,6.5 L6,17.5 C6,18.3284271 5.32842712,19 4.5,19 L1.5,19 C0.671572875,19 1.01453063e-16,18.3284271 0,17.5 L0,6.5 C-1.01453063e-16,5.67157288 0.671572875,5 1.5,5 Z M18.5,5 L22.5,5 C23.3284271,5 24,5.67157288 24,6.5 L24,17.5 C24,18.3284271 23.3284271,19 22.5,19 L18.5,19 C17.6715729,19 17,18.3284271 17,17.5 L17,6.5 C17,5.67157288 17.6715729,5 18.5,5 Z" fill="#000000"/><rect fill="#000000" opacity="0.3" x="8" y="5" width="7" height="14" rx="1.5"/></g></svg>';

        /*
        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000
        });
        */

        $('.select2').select2();


        const toast = toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        const message = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success shadow-sm mr-2',
                cancelButton: 'btn btn-danger shadow-sm'
            },
            buttonsStyling: false,
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if (Session::has('error'))
            toastr.error("{!! session('error') !!}", "Error");
            @php
                session()->forget('error');
            @endphp
        @endif

        @if (Session::has('success'))
            toastr.success("{!! session('success') !!}", "Success");
            @php
                session()->forget('success');
            @endphp
        @endif

        /** Indian standard currency format in js */
        function indianCurrencyFormat(x) {
            return x.toString().split('.')[0].length > 3 ? x.toString().substring(0, x.toString().split('.')[0].length - 3)
                .replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length -
                    3) : x.toString();
        }
        /** Indian standard currency format in js */

        // Convert number value to specified precision without round off
        function numberFormatPrecision(value, precision = 0) {
            if (!isNaN(value) && !isNaN(precision)) {
                const v = (typeof value === 'string' ? value : value.toString()).split('.');
                if (precision <= 0) return v[0];
                let f = v[1] || '';
                if (f.length > precision) return `${v[0]}.${f.substr(0,precision)}`;
                while (f.length < precision) f += '0';
                return `${v[0]}.${f}`;
            }
            return '';
        }

        // Numbers with round off
        function numberWithRound(value) {
            return Math.round(value);
        }

        function digitFormat(currency) {
            return number = Number(currency.replace(/[^0-9.-]+/g, ""));
        }

        function strpad(str, max) {
            str = str.toString();
            return str.length < max ? strpad("0" + str, max) : str;
        }

        $.each($('.jsDecimalPointDegit'), function() {
            var price = $(this).html();
            $(this).html(price.replace(/(\D*)(\d*\.)(\d*)/,
                '<span>$1</span><span>$2</span><span style="font-size:10px;">$3</span>'));
        });

        //Allow Only Number 
        $(document).on('keypress', '.number', function(event) {

            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && ((event.which < 48 || event.which >
                    57) && (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();

            if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 3) && (event.which != 0 &&
                    event.which != 8) && ($(this)[0].selectionStart >= text.length - 3)) {
                event.preventDefault();
            }
        });

        function addDays(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        function getFormattedDate(date) {
            let year = date.getFullYear();
            let month = (1 + date.getMonth()).toString().padStart(2, '0');
            let day = date.getDate().toString().padStart(2, '0');
            return day + '-' + month + '-' + year;
        }

        $('.defult-date').attr('min', '{{ $formDate }}');
        $('.defult-date').attr('max', '{{ $toDate }}');

        $('.account-date').attr('min', '{{ $formDate }}');
        $('.account-date').attr('max', '{{ date('Y-m-d') }}');

        var defaultFromDate = "{{ $formDate }}";
        var defaultToDate = "{{ $toDate }}";

        function numberWithoutRound(n, max = 2) {
            if (max == 2) {
                var formattedNumber = Number(n.toString().match(/^\d+(?:\.\d{0,2})?/));
            } else if (max == 3) {
                var formattedNumber = Number(n.toString().match(/^\d+(?:\.\d{0,3})?/));
            } else {
                var formattedNumber = Number(n.toString().match(/^\d+(?:\.\d{0,2})?/));
            }
            return formattedNumber;
        }

        function showFullPageLoader() {
            $('.full-page-loader').show();
        }

        function hideFullPageLoader() {
            $('.full-page-loader').hide();
        }

        // Allow Only Integer 
        $(document).on("keypress", '.jsOnlyNumber', function(event) {
            if (event.which < 48 || event.which > 58) {
                return false;
            }
        });
        // Allow Only One Decimal Number 
        $(document).on("keypress", '.jsOneDecimal', function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && ((event.which < 48 || event.which >
                    57) && (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();
            if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 1) && (event.which != 0 &&
                    event.which != 8) && ($(this)[0].selectionStart >= text.length - 1)) {
                event.preventDefault();
            }
        });
        // Allow Only Two Decimal Number
        $(document).on("keypress", '.jsTwoDecimal', function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && ((event.which < 48 || event.which >
                    57) && (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();
            if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 2) && (event.which != 0 &&
                    event.which != 8) && ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });

        function precise_round(num, decimals) {
            var t = Math.pow(10, decimals);
            return (Math.round((num * t) + (decimals > 0 ? 1 : 0) * (Math.sign(num) * (10 / Math.pow(100, decimals)))) / t)
                .toFixed(decimals);
        }

        // $(document).on('change','.country', function(){
        //     getstates();
        // });

        function getstates(country, state) {
            var state_id = "";
            var countryId= $('.' + country).val();
            $("." + state + " option").remove();
            if(countryId > 0){
                $.ajax({
                    url: '{{route("get-states")}}',
                    type: 'POST',
                    data: {
                        'country_id': countryId
                    },
                    success: function(res) {
                        if (res) {
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(res, function(id,name) {

                                if (state_id > 0 && id == state_id) {
                                    var selected = true;
                                } else {
                                    var selected = false;
                                }

                                var obj = {
                                    'id': id,
                                    'text': name,
                                    'html': name,
                                    "selected": selected
                                };
                                data.push(obj);
                            });
                            $("." + state).select2({
                                data: data,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (state_id > 0) {
                                $("." + state).val(state_id).trigger("change");
                            }
                        }
                    }
                });
            }
        }
        function selectTemplate(data) {
            return data.html;
        }
    </script>
    @stack('scripts')
    @yield('scripts')
    <script src="{{ asset('js/action.js') }}"></script>
</body>

<!--end::Body-->

</html>
