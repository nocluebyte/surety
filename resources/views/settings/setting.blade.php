{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', __('settings.general_settings'))

@component('partials._subheader.subheader-v6',
[
'page_title' => __('settings.general_settings'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom gutter-b">
        @include('components.error') 

            <div class="card-body">

                <div class="example">
                    <div class="example-preview">
                        <div class="row">
                            <div class="col-lg-3">
                                <!--begin::Navigation-->
                                <ul class="navi navi-link-rounded navi-accent navi-hover navi-active nav flex-column mb-8 mb-lg-0" role="tablist">
                                    <!--begin::Nav Item-->
                                    <li class="navi-item mb-2">
                                        <a class="navi-link active" id="company-tab-1" data-toggle="tab" href="#company_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.company')}}</span>
                                        </a>
                                    </li>
                                    <!--end::Nav Item-->
                                    
                                    {{-- <li class="navi-item mb-2">
                                        <a class="navi-link" id="profile-tab-5" data-toggle="tab" href="#profile-5" aria-controls="profile">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{ __('settings.bank_details') }}</span>
                                        </a>
                                    </li>

                                    <li class="navi-item mb-2">
                                        <a class="navi-link" id="quotation-tab" data-toggle="tab" href="#quotation_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.quotation')}}</span>
                                        </a>
                                    </li>
                                    <li class="navi-item mb-2">
                                        <a class="navi-link" id="invoice-tab" data-toggle="tab" href="#invoice_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.invoice')}}</span>
                                        </a>
                                    </li> --}}
                                    {{-- @if ($user->hasAnyAccess(['users.superadmin'])) --}}
                                        <li class="navi-item mb-2">
                                            <a class="navi-link" id="tax-tab-6" data-toggle="tab" href="#session_tab"
                                                aria-controls="contact">
                                                <span class="nav-icon mr-3">
                                                    <i class="flaticon2-rocket-1"></i>
                                                </span>
                                                <span class="navi-text">{{ __('settings.session') }}</span>
                                            </a>
                                        </li>
                                    {{-- @endif --}}
                                    <li class="navi-item mb-2">
                                        <a class="navi-link" id="bond-start-period-tab" data-toggle="tab" href="#bond_start_period_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.bond_period')}}</span>
                                        </a>
                                    </li>
                                    <li class="navi-item mb-2">
                                        <a class="navi-link" id="print-tab" data-toggle="tab" href="#print_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.print')}}</span>
                                        </a>
                                    </li>
                                    <li class="navi-item mb-2">
                                        <a class="navi-link" id="issue-bond-tab" data-toggle="tab" href="#issue_bond_tab">
                                            <span class="nav-icon mr-3">
                                                <i class="flaticon2-rocket-1"></i>
                                            </span>
                                            <span class="navi-text">{{__('settings.issue_bond_print')}}</span>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Navigation-->
                            </div>
                            <div class="col-lg-9">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="company_tab" role="tabpanel" aria-labelledby="company-tab-1">
                                        @include('settings.company_form')
                                    </div>

                                    {{-- <div class="tab-pane fade" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                                        @include('settings.bank_form')
                                    </div>
                                    <div class="tab-pane fade" id="quotation_tab" role="tabpanel" aria-labelledby="quotation-tab">
                                        @include('settings.quotation_form')
                                    </div>
                                    <div class="tab-pane fade" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                        @include('settings.invoice_form')
                                    </div> --}}
                                    <div class="tab-pane fade" id="session_tab" role="tabpanel" aria-labelledby="account-tab-6">
                                        @include('settings.session_form')
                                    </div>
                                    <div class="tab-pane fade" id="bond_start_period_tab" role="tabpanel" aria-labelledby="bond-start-period-tab">
                                        @include('settings.bond_start_period')
                                    </div>
                                    <div class="tab-pane fade" id="print_tab" role="tabpanel" aria-labelledby="print-tab">
                                        @include('settings.print')
                                    </div>
                                    <div class="tab-pane fade" id="issue_bond_tab" role="tabpanel" aria-labelledby="issue-bond-tab">
                                        @include('settings.issue_bond_tab')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
@include('settings.script')