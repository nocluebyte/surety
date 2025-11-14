{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('reports.reports'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom gutter-b">

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">{{ __('reports.contractor') }}</span>
                        </h3>
                        @if ($current_user->hasAnyAccess(['contractor_wise.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5" id="approved_limit_policy_wise" name="approved_limit_policy_wise">
                                    <i class="star flaticon-star text-warning"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('report.contractor-wise.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reports.contractor_wise') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">{{ __('reports.bond') }}</span>
                        </h3>

                        @if ($current_user->hasAnyAccess(['bond_type_wise.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                    <i class="star flaticon-star text-warning"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('report.bond-type-wise.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reports.bond_type_wise') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">{{ __('reports.beneficiary') }}</span>
                        </h3>

                        @if ($current_user->hasAnyAccess(['beneficiary_wise.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                    <i class="star flaticon-star text-warning"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('report.beneficiary-wise.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reports.beneficiary_wise') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">{{ __('reports.project') }}</span>
                        </h3>

                        @if ($current_user->hasAnyAccess(['project_details_wise.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                    <i class="star flaticon-star text-warning"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('report.project-details-wise.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reports.project_details_wise') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-lg-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">{{ __('reports.tender') }}</span>
                        </h3>

                        @if ($current_user->hasAnyAccess(['tender_wise.list', 'users.superadmin']))
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                    <i class="star flaticon-star text-warning"></i>
                                </div>

                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="{{route('report.tender-wise.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ __('reports.tender_wise') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".star").click(function() {
            $(this).toggleClass("flaticon-star text-warning flaticon-star");
        });
    </script>
@endsection
