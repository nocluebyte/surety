{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', $master_title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('master.masters'),
])
@endcomponent

@php
    $nsureMasterPerm = [
        'users.superadmin',
        'financing_sources.list',
        'bond_types.list',
        'insurance_companies.list',
        'file_source.list',
        'principle_type.list',
        'document_type.list',
        'trade_sector.list',
        'relevant_approval.list',
        'facility_type.list',
        'project_type.list',
        'banking_limit_categories.list',
        'type_of_entities.list',
        'establishment_types.list',
        'ministry_types.list',
        'tenure.list',
        'work_type.list',
        'reason.list',
        'uw-view.list',
        'issuing_office_branch.list',
        'additional_bond.list',
        'rejection_reason.list',
        'agency.list',
        'agency-rating.list',
        'type_of_foreclosure.list',
        'rating.list',
    ];
    $hrmMasterPerm = ['designation.list', 'users.superadmin'];
    $otherMasterPerm = [
        'country.list',
        'state.list',
        'years.list',
        'currency.list',
        'users.superadmin',
        'smtp_configuration.list',
        'mail_template.list',
        'hsn-code.list',
    ];
    $invocationPerm =[
        'users.superadmin',
        'invocation_reason.list'
    ];
@endphp

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom gutter-b">

            <div class="card-body">
                <div class="row">
                    @if ($current_user->hasAnyAccess($nsureMasterPerm))

                        <div class="form-group col-lg-3">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Policy</span>
                            </h3>

                            @if ($current_user->hasAnyAccess(['financing_sources.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('financing_sources') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('financing_sources.financing_sources') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['bond_types.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('bond_types') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('bond_types.bond_types') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['insurance_companies.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('insurance_companies') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('insurance_companies.insurance_companies') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['file_source.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('file_source') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('file_source.file_source') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['principle_type.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('principle_type') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('principle_type.principle_type') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['document_type.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('document_type') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('document_type.document_type') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['trade_sector.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('trade_sector') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('trade_sector.trade_sector') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['relevant_approval.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('relevant_approval') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('relevant_approval.relevant_approval') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['issuing_office_branch.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('issuing-office-branch') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('issuing_office_branch.issuing_office_branch') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['additional_bond.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('additional-bond') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('additional_bond.additional_bond') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['rejection_reason.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('rejection-reason') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('rejection_reason.rejection_reason') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['type_of_foreclosure.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('type-of-foreclosure') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('type_of_foreclosure.type_of_foreclosure') }}</a>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="form-group col-lg-3">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">&nbsp;</span>
                            </h3>
                            @if ($current_user->hasAnyAccess(['re_insurance_grouping.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ route('re-insurance-grouping.index') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('master.re_insurance_grouping') }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($current_user->hasAnyAccess(['facility_type.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('facility_type') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('facility_type.facility_type') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['project_type.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('project_type') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('project_type.project_type') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['banking_limit_categories.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('banking_limit_categories') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('banking_limit_categories.banking_limit_categories') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['type_of_entities.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('type_of_entities') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('type_of_entities.type_of_entities') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['establishment_types.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('establishment_types') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('establishment_types.establishment_types') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['ministry_types.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('ministry_types') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('ministry_types.ministry_types') }}</a>
                                    </div>
                                </div>
                            @endif

                            {{-- This module remove confirm with fenil bhai --}}
                            {{-- @if ($current_user->hasAnyAccess(['tenure.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('tenure') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('tenure.tenure') }}</a>
                                    </div>
                                </div>
                            @endif --}}

                            @if ($current_user->hasAnyAccess(['work_type.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('work-type') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('work_type.work_type') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['reason.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('reason') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reason.reason') }}</a>
                                    </div>
                                </div>
                            @endif

                            {{-- @if ($current_user->hasAnyAccess(['uw-view.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('uw-view') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('uw-view.uw-view') }}</a>
                                    </div>
                                </div>
                            @endif --}}

                            @if ($current_user->hasAnyAccess(['agency.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('agency') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('agency.agency') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['agency-rating.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('agency-rating') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('agency_rating.agency_rating') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['rating.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('rating') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('rating.rating') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($current_user->hasAnyAccess($hrmMasterPerm))
                        <div class="form-group col-lg-3">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">HRM</span>
                            </h3>

                            @if ($current_user->hasAnyAccess(['designation.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('designation') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('designation.designation') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($current_user->hasAnyAccess($otherMasterPerm))
                        <div class="form-group col-lg-3">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Other</span>
                            </h3>

                            @if ($current_user->hasAnyAccess(['country.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('country') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('country.country') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['state.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('state') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('state.state') }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($current_user->hasAnyAccess(['currency.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('currency') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('currency.title') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['years.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5" id="life_report"
                                        name="life_report">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('year') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('year.year') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['smtp_configuration.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('smtp-configuration') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('smtp_configuration.smtp_configuration') }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($current_user->hasAnyAccess(['mail_template.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('mail-template') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('mail_template.mail_template') }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($current_user->hasAnyAccess(['hsn-code.list', 'users.superadmin']))
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-primary mr-5">
                                        <i class="flaticon2-arrow text-primary"></i>
                                    </div>

                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="{{ url('hsn-code') }}"
                                            class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('hsn_code.hsn-code') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif


                @if ($current_user->hasAnyAccess($invocationPerm))
                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Invocation</span>
                        </h3>

                        @if ($current_user->hasAnyAccess(['invocation_reason.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                    <i class="flaticon2-arrow text-primary"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('invocation-reason.index')}}"
                                        class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('invocation_reason_master.invocation_reason') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
