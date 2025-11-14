<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            @if (isset($page_title))
                <h4 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $page_title }}</h4>
            @endif
        </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center flex-wrap">
            <!-- Filter -->
            @if (isset($excel_id))
                <a href="{{ $excel_link ?? '#' }}"
                    class="btn btn-bg-white btn-icon-success btn-hover-success btn-icon mr-3 my-2 my-lg-0 excelButton">
                    <i class="far fa-file-excel icon-md"></i>
                </a>
            @endif

            @if (isset($pdf_id))
                <a href="{{ $pdf_link ?? '#' }}"
                    class="btn btn-bg-white btn-icon-danger btn-hover-danger btn-icon mr-3 my-2 my-lg-0 pdfButton"
                    target="_blank">
                    <i class="far fa-file-pdf icon-md"></i>
                </a>
            @endif

            @if (isset($multiple_excel_id))
                <div class="btn-group px-2">
                    <a href="#"
                        class="btn btn-bg-white btn-icon-success btn-hover-success btn-icon mr-3 my-2 my-lg-0 excelButton dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-file-excel icon-md"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if (!empty($excel_link1) && !empty($text1))
                            <a class="dropdown-item" href="{{ $excel_link1 }}">{{ $text1 }}</a>
                        @endif
                        @if (!empty($excel_link2) && !empty($text2))
                            <a class="dropdown-item" href="{{ $excel_link2 }}">{{ $text2 }}</a>
                        @endif
                    </div>
                </div>
            @endif

            @if (isset($report_modal))
               <button type="button" class="btn btn-bg-white btn-icon-dark btn-hover-dark btn-icon mr-5" data-toggle="modal" data-target="{{$report_modal}}">
                        <i class="fab la-microsoft"></i>
                </button>
            @endif

            {{-- @if (isset($print_id))
                <a href="javascript:void(0)"
                    class="btn btn-bg-white btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0 jsPrint">
                    <i class="flaticon2-print icon-md"></i>
                </a>
            @endif --}}

            @if (isset($commercial_print_id) && $commercial_print_type == 'Export')
                <a href="{{ $commercial_print_link ?? '#' }}" target="_blank"
                    class="btn btn-bg-white btn-icon-info btn-hover-primary mr-3 my-2 my-lg-0 printBtn">
                    <i class="flaticon2-print icon-md"></i>&nbsp;Commercial
                </a>
            @endif

            @if (isset($print_id) && isset($permission) && $permission == true)
                <a href="{{ $print_link ?? '#' }}" target="_blank"
                    class="btn btn-bg-white btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0 printBtn">
                    <i class="flaticon2-print icon-md"></i>
                </a>
            @endif

            @if (isset($dropdown_print) && isset($permission) && $permission == true)
                <div class="btn-group px-2">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon2-print icon-md"></i> {{ $dropdown_print }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if (!empty($dropdown_action1) && !empty($text1))
                            <a class="dropdown-item" href="{{ $dropdown_action1 }}"
                                target="_blank">{{ $text1 }}</a>
                        @endif
                        @if (!empty($dropdown_action2) && !empty($text2))
                            <a class="dropdown-item" href="{{ $dropdown_action2 }}"
                                target="_blank">{{ $text2 }}</a>
                        @endif
                    </div>
                </div>
            @endif


            @if (isset($get_pass_print_id))
                <a href="{{ $get_pass_print_link ?? '#' }}" target="_blank"
                    class="btn btn-bg-white btn-icon-info btn-hover-primary mr-3 my-2 my-lg-0 printBtn">
                    <i class="flaticon2-print icon-md"></i>&nbsp;Get Pass
                </a>
            @endif

            @if (isset($add_mail))
                <a href="{{ $add_mail->get('action', 'javaqscrip:void(0)') }}" data-toggle="modal"
                    data-target-modal="{{ $add_mail->get('target') }}"
                    data-url="{{ $add_mail->get('action', 'javaqscrip:void(0)') }}"
                    class="btn call-modal btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2 sendMailBtn disabled">
                    <i class="fa fa-envelope"></i> &nbsp; {{ $add_mail->get('text', 'javaqscrip:void(0)') }}
                </a>
            @endif

            @if (isset($add_salary_mail) && $permissionsalarymail == true)
                <a href="{{ $add_salary_mail->get('action', 'javaqscrip:void(0)') }}" data-toggle="modal"
                    data-target-modal="{{ $add_salary_mail->get('target') }}"
                    data-url="{{ $add_salary_mail->get('action', 'javaqscrip:void(0)') }}"
                    class="btn call-modal btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2 sendMailBtn disabled">
                    <i class="fa fa-envelope"></i> &nbsp; {{ $add_salary_mail->get('text', 'javaqscrip:void(0)') }}
                </a>
            @endif

            @if (isset($column_visibility) && $column_visibility == true)
                <div id="custom-column-visibility-container" class=" mr-5"></div>
            @endif

            @if (isset($filter_modal_id))
                <a href="javascript:;" data-toggle="modal" data-target="{{ $filter_modal_id }}"
                    class="btn btn-bg-white btn-icon-warning btn-hover-warning btn-icon mr-5"><i
                        class="fas fa-filter"></i></a>
            @endif

            @if (isset($generate_modal_id))
                <a href="javascript:;" data-toggle="modal" data-target="{{ $generate_modal_id }}"
                    class="btn btn-bg-warning btn-hover-warning mr-5 text-white">Generate</a>
            @endif

            @if (isset($employeegraph) && $permissiongraph == true)
                <a href="{{ $employeegraph }}" class="btn btn-bg-white btn-icon-dark btn-hover-dark btn-icon mr-5"><i
                        class="flaticon2-graphic text-dark"></i></a>
            @endif

            @if (isset($model_back_action))
                <a href="{{ $model_back_action }}"
                    class="btn btn-outline-dark btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2"><i
                        class="flaticon2-left-arrow-1"></i> &nbsp; {{ $back_text }}
                </a>
            @endif

            @if (isset($import) && isset($permission) && $permission==true)
            <a href="{{ $import }}" class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#FFFFFF" fill-rule="nonzero" opacity="0.3"/>
                    <rect fill="#FFFFFF" opacity="0.3" x="11" y="2" width="2" height="14" rx="1"/>
                    <path d="M12.0362375,3.37797611 L7.70710678,7.70710678 C7.31658249,8.09763107 6.68341751,8.09763107 6.29289322,7.70710678 C5.90236893,7.31658249 5.90236893,6.68341751 6.29289322,6.29289322 L11.2928932,1.29289322 C11.6689749,0.916811528 12.2736364,0.900910387 12.6689647,1.25670585 L17.6689647,5.75670585 C18.0794748,6.12616487 18.1127532,6.75845471 17.7432941,7.16896473 C17.3738351,7.57947475 16.7415453,7.61275317 16.3310353,7.24329415 L12.0362375,3.37797611 Z" fill="#FFFFFF" fill-rule="nonzero"/>
                </g>
            </svg> &nbsp; {{ $text_import }}
            </a>
            @endif

            @if (isset($view_action) && isset($view_permission) && $view_permission == true)
                <a href="{{ $view_action }}"
                    class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2"><i
                        class="flaticon-visible"></i> &nbsp; {{ $view_text }}
                </a>
            @endif

            @if (isset($action) && isset($permission) && $permission == true)
                <a href="{{ $action }}"
                    class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2 addSrt"><i
                        class="flaticon2-plus"></i> &nbsp; {{ $text }}
                </a>
            @endif

            @if (isset($back_action))
                <a href="{{ $back_action }}"
                    class="btn btn-outline-dark btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2 backSrt"><i
                        class="flaticon2-left-arrow-1"></i> &nbsp; {{ $text }}
                </a>
            @endif

            <!-- Modal Action -->
            @if (isset($modal_id))
                <a href="javascript:;" data-toggle="modal" data-target="{{ $modal_id }}"
                    class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <i class="flaticon2-plus"></i> &nbsp; {{ $text }}
                </a>
            @endif

            <!-- Open Model  -->
            @if (isset($add_modal) && isset($permission) && $permission == true)
                <a href="{{ $add_modal->get('action', 'javaqscrip:void(0)') }}" data-toggle="modal"
                    data-target-modal="{{ $add_modal->get('target') }}"
                    data-url="{{ $add_modal->get('action', 'javaqscrip:void(0)') }}"
                    class="btn call-modal btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <i class="flaticon2-plus"></i> &nbsp; {{ $add_modal->get('text', 'javaqscrip:void(0)') }}
                </a>
            @endif
            <!-- End Open Modal -->

            @if (isset($gst_audit))
                @if ($dis_audit == 1)
                    <span
                        class="label h6 p-4 label-pill label-inline btn btn-light-success btn-sm font-weight-bold">Audited</span>
                @else
                    <a href="{{ $gst_audit }}" data-redirect="{{ route('gst-audit') }}"
                        class="btn btn-light-primary btn-sm font-weight-bold audit-confrim">
                        {{ $gst_audit_text }}
                    </a>
                @endif
            @endif



            <!-- Dropdown Add button -->
            @if (isset($dropdown_text) && isset($permission) && $permission == true)
                <div class="btn-group px-2">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon2-plus"></i> {{ $dropdown_text }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if (!empty($dropdown_action1) && !empty($text1))
                            <a class="dropdown-item" href="{{ $dropdown_action1 }}">{{ $text1 }}</a>
                        @endif
                        @if (!empty($dropdown_action2) && !empty($text2))
                            <a class="dropdown-item" href="{{ $dropdown_action2 }}">{{ $text2 }}</a>
                        @endif
                        @if (!empty($dropdown_action3) && !empty($text3))
                            <a class="dropdown-item" href="{{ $dropdown_action3 }}">{{ $text3 }}</a>
                        @endif

                        @if (!empty($dropdown_action4) && !empty($text4))
                            <a class="dropdown-item" href="{{ $dropdown_action4 }}">{{ $text4 }}</a>
                        @endif

                        @if (!empty($dropdown_action5) && !empty($text5))
                            <a class="dropdown-item" href="{{ $dropdown_action5 }}">{{ $text5 }}</a>
                        @endif

                        @if (!empty($dropdown_action6) && !empty($text6))
                            <a class="dropdown-item" href="{{ $dropdown_action6 }}">{{ $text6 }}</a>
                        @endif

                        @if (!empty($dropdown_action7) && !empty($text7))
                            <a class="dropdown-item" href="{{ $dropdown_action7 }}">{{ $text7 }}</a>
                        @endif

                    </div>
                </div>
            @endif

            <!--end::Actions-->

            <!--Only purchase_indent module-->

            @if (isset($dropdown_text_pi) && $permission == true)
                <div class="btn-group px-2">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon2-plus"></i> {{ $dropdown_text_pi }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if (!empty($dropdown_action1) && !empty($text1) && $permission1 == true)
                            <a class="dropdown-item" href="{{ $dropdown_action1 }}">{{ $text1 }}</a>
                        @endif
                        @if (!empty($dropdown_action2) && !empty($text2) && $permission2 == true)
                            <a class="dropdown-item" href="{{ $dropdown_action2 }}">{{ $text2 }}</a>
                        @endif
                        @if (!empty($dropdown_action3) && !empty($text3) && $permission3 == true)
                            <a class="dropdown-item" href="{{ $dropdown_action3 }}">{{ $text3 }}</a>
                        @endif
                    </div>
                </div>
            @endif

            <!--begin::Dropdown-->
            <!-- <div class="dropdown dropdown-inline my-2 my-lg-0" data-toggle="tooltip" title="Quick actions" data-placement="left">
     <a href="#" class="btn btn-primary btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="svg-icon svg-icon-md">

       <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
         <rect x="0" y="0" width="24" height="24" />
         <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000" />
        </g>
       </svg>

      </span>
     </a>
     <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">

      <ul class="navi navi-hover">
       <li class="navi-header font-weight-bold py-4">
        <span class="font-size-lg">Choose Label:</span>
        <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
       </li>
       <li class="navi-separator mb-3 opacity-70"></li>
       <li class="navi-item">
        <a href="#" class="navi-link">
         <span class="navi-text">
          <span class="label label-xl label-inline label-light-success">Customer</span>
         </span>
        </a>
       </li>
       <li class="navi-item">
        <a href="#" class="navi-link">
         <span class="navi-text">
          <span class="label label-xl label-inline label-light-danger">Partner</span>
         </span>
        </a>
       </li>
       <li class="navi-item">
        <a href="#" class="navi-link">
         <span class="navi-text">
          <span class="label label-xl label-inline label-light-warning">Suplier</span>
         </span>
        </a>
       </li>
       <li class="navi-item">
        <a href="#" class="navi-link">
         <span class="navi-text">
          <span class="label label-xl label-inline label-light-primary">Member</span>
         </span>
        </a>
       </li>
       <li class="navi-item">
        <a href="#" class="navi-link">
         <span class="navi-text">
          <span class="label label-xl label-inline label-light-dark">Staff</span>
         </span>
        </a>
       </li>
       <li class="navi-separator mt-3 opacity-70"></li>
       <li class="navi-footer py-4">
        <a class="btn btn-clean font-weight-bold btn-sm" href="#">
         <i class="ki ki-plus icon-sm"></i>Add new</a>
       </li>
      </ul>

     </div>
    </div> -->
            @if (isset($sync_attendance_biomax) && env('ATT_DEVICE_TYPE') == 'BioMax' && $sync_permission)
                <a href="{{ route($sync_attendance_biomax) }}" class="btn btn-success">
                    <i class="flaticon2-refresh"></i>
                </a>
            @endif

        </div>

    </div>
</div>

<!--end::Subheader-->
