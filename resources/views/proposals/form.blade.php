@php
    $current_user_role = $current_user->roles->first();
    // $readonly = ($proposals) ? 'readonly' : '';
    // $readonly_cls = ($proposals) ? 'form-control-solid' : '';
    // $disabled = ($proposals) ? 'disabled' : '';
    // dd($is_amendment);
    $readonly = (isset($is_amendment) && $is_amendment == 'yes') ? 'readonly' : '';
    $readonly_cls = (isset($is_amendment) && $is_amendment == 'yes') ? 'form-control-solid' : '';
    $disabled = (isset($is_amendment) && $is_amendment == 'yes') ? 'disabled' : '';
@endphp
<div class="card card-custom gutter-b">

    <div class="card-body">
        <div class="example">
            <div class="example-preview">
                <div class="row">
                    <div class="col-lg-3">
                        <!--begin::Navigation-->
                        <ul class="navi navi-link-rounded navi-accent navi-hover navi-active nav flex-column mb-8 mb-lg-0 nav-tabs"
                            role="tablist">
                            <!--begin::Nav Item-->
                            <li class="navi-item mb-2">
                                <a class="navi-link active" id="contractor-details" data-toggle="tab"
                                    href="#contractor_details">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.contractor_details') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="proposal-banking-limits" data-toggle="tab"
                                    href="#proposal_banking_limits" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.proposal_banking_limits') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="project-track-records" data-toggle="tab"
                                    href="#project_track_records" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.project_track_records') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="order-book-and-future-projects" data-toggle="tab"
                                    href="#order_book_and_future_projects" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.order_book_and_future_projects') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="management-profiles" data-toggle="tab"
                                    href="#management_profiles" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.management_profiles') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="additional-details-for-assessment" data-toggle="tab"
                                    href="#additional_details_for_assessment" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span
                                        class="navi-text">{{ __('proposals.additional_details_for_assessment') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="beneficiary-details" data-toggle="tab"
                                    href="#beneficiary_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.beneficiary_details') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="project-details" data-toggle="tab"
                                    href="#project_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.project_details') }}</span>
                                </a>
                            </li>
                            <!--end::Nav Item-->

                            {{-- <li class="navi-item mb-2">
                                <a class="navi-link" id="requirement-details" data-toggle="tab"
                                    href="#requirement_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.requirement_details') }}</span>
                                </a>
                            </li> --}}

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="tender-details" data-toggle="tab"
                                    href="#tender_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.tender_details') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="bond-details" data-toggle="tab"
                                    href="#bond_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.bond_details') }}</span>
                                </a>
                            </li>

                             {{-- <li class="navi-item mb-2">
                                <a class="navi-link" id="additional-bonds" data-toggle="tab"
                                    href="#additional_bonds" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.additional_bonds') }}</span>
                                </a>
                            </li> --}}

                            {{-- <li class="navi-item mb-2">
                                <a class="navi-link" id="assessment-of-the-risk" data-toggle="tab"
                                    href="#assessment_of_the_risk">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.assessment_of_the_risk') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="for-nhai-projects" data-toggle="tab" href="#for_nhai_projects">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('proposals.for_nhai_projects') }}</span>
                                </a>
                            </li> --}}
                        </ul>
                        <!--end::Navigation-->
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content tab-validate">
                            <div class="tab-pane fade show active" id="contractor_details" role="tabpanel"
                                aria-labelledby="contractor-details">
                                @include('proposals.form.contractor_details')
                            </div>

                            <div class="tab-pane fade" id="proposal_banking_limits" role="tabpanel"
                                aria-labelledby="proposal-banking-limits">
                                @include('proposals.form.proposal_banking_limits')
                            </div>
                            <div class="tab-pane fade" id="project_track_records" role="tabpanel"
                                aria-labelledby="project-track-records">
                                @include('proposals.form.project_track_records')
                            </div>
                            <div class="tab-pane fade" id="order_book_and_future_projects" role="tabpanel"
                                aria-labelledby="order-book-and-future-projects">
                                @include('proposals.form.order_book_and_future_projects')
                            </div>
                            <div class="tab-pane fade" id="management_profiles" role="tabpanel"
                                aria-labelledby="management-profiles">
                                @include('proposals.form.management_profiles')
                            </div>
                            <div class="tab-pane fade" id="additional_details_for_assessment" role="tabpanel"
                                aria-labelledby="additional-details-for-assessment">
                                @include('proposals.form.additional_details_for_assessment')
                            </div>

                            <div class="tab-pane fade" id="beneficiary_details" role="tabpanel"
                                aria-labelledby="beneficiary-details">
                                @include('proposals.form.beneficiary_details')
                            </div>

                            <div class="tab-pane fade" id="project_details" role="tabpanel"
                                aria-labelledby="project-details">
                                @include('proposals.form.project_details')
                            </div>

                            {{-- <div class="tab-pane fade" id="requirement_details" role="tabpanel"
                                aria-labelledby="requirement-details">
                                @include('proposals.form.requirement_details')
                            </div> --}}

                            <div class="tab-pane fade" id="tender_details" role="tabpanel"
                                aria-labelledby="tender-details">
                                @include('proposals.form.tender_details')
                            </div>

                            <div class="tab-pane fade" id="bond_details" role="tabpanel"
                                aria-labelledby="bond-details">
                                @include('proposals.form.bond_details')
                            </div>

                            {{-- <div class="tab-pane fade" id="additional_bonds" role="tabpanel"
                                aria-labelledby="additional-bonds">
                                @include('proposals.form.additional_bonds')
                            </div> --}}
                            {{-- <div class="tab-pane fade" id="assessment_of_the_risk" role="tabpanel"
                                aria-labelledby="assessment-of-the-risk">
                                @include('proposals.form.assessment_of_the_risk')
                            </div>
                            <div class="tab-pane fade" id="for_nhai_projects" role="tabpanel"
                                aria-labelledby="for-nhai-projects">
                                @include('proposals.form.for_nhai_projects')
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer pb-5 pt-5">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="" class="mr-2">Reset</a>
                    <button type="submit" id="btn_loader" class="btn btn-primary proposals_save"
                        name="saveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>

</div>

@include('proposals.scripts.script')
