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
                                <a class="navi-link active" id="principle-contractor-details" data-toggle="tab"
                                    href="#principle_contractor_details">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.contractor_details') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="banking-limits" data-toggle="tab"
                                    href="#banking_limits" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.banking_limits') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="project-track-records" data-toggle="tab"
                                    href="#project_track_records" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.project_track_records') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="order-book-and-future-projects" data-toggle="tab"
                                    href="#order_book_and_future_projects" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.order_book_and_future_projects') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="management-profiles" data-toggle="tab"
                                    href="#management_profiles" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.management_profiles') }}</span>
                                </a>
                            </li>
                            <li class="navi-item mb-2">
                                <a class="navi-link" id="additional-details-for-assessment" data-toggle="tab"
                                    href="#additional_details_for_assessment" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.additional_details_for_assessment') }}</span>
                                </a>
                            </li>
                            {{-- <li class="navi-item mb-2">
                                <a class="navi-link" id="agency-rating" data-toggle="tab"
                                    href="#agency_rating" aria-controls="contact">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('principle.agency_rating') }}</span>
                                </a>
                            </li> --}}
                        </ul>
                        <!--end::Navigation-->
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content tab-validate">
                            <div class="tab-pane fade show active" id="principle_contractor_details" role="tabpanel"
                                aria-labelledby="principle-contractor-details">
                                @include('principle.tabs.details')
                            </div>
                            <div class="tab-pane fade" id="banking_limits" role="tabpanel"
                                aria-labelledby="banking-limits">
                                @include('principle.tabs.banking_limits')
                            </div>
                            <div class="tab-pane fade" id="project_track_records" role="tabpanel"
                                aria-labelledby="project-track-records">
                                @include('principle.tabs.project_track_records')
                            </div>
                            <div class="tab-pane fade" id="order_book_and_future_projects" role="tabpanel"
                                aria-labelledby="order-book-and-future-projects">
                                @include('principle.tabs.order_book_and_future_projects')
                            </div>
                            <div class="tab-pane fade" id="management_profiles" role="tabpanel"
                                aria-labelledby="management-profiles">
                                @include('principle.tabs.management_profiles')
                            </div>
                            <div class="tab-pane fade" id="additional_details_for_assessment" role="tabpanel"
                            aria-labelledby="additional-details-for-assessment">
                                @include('principle.tabs.additional_details_for_assessment')
                            </div>
                            {{-- <div class="tab-pane fade" id="agency_rating" role="tabpanel"
                                aria-labelledby="agency-rating">
                                @include('principle.tabs.agency_rating')
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div id="load-modal"></div> --}}
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

@section('scripts')
    @include('principle.script')
@endsection
