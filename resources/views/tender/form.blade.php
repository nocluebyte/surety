<div class="card card-custom gutter-b">

    <div class="card-body">
        <div class="example">
            <div class="example-preview">
                <div class="row">
                    <div class="col-lg-3">
                        <ul class="navi navi-link-rounded navi-accent navi-hover navi-active nav flex-column mb-8 mb-lg-0 nav-tabs"
                            role="tablist">
                            <li class="navi-item mb-2">
                                <a class="navi-link active" id="tender-details" data-toggle="tab"
                                    href="#tender_details">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('tender.tender_details') }}</span>
                                </a>
                            </li>

                            <li class="navi-item mb-2">
                                <a class="navi-link" id="project-details" data-toggle="tab"
                                    href="#project_details" aria-controls="profile">
                                    <span class="nav-icon mr-3">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">{{ __('tender.project_details') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content tab-validate">
                            <div class="tab-pane fade show active" id="tender_details" role="tabpanel"
                                aria-labelledby="tender-details">
                                @include('tender.form.tender_details')
                            </div>

                            <div class="tab-pane fade" id="project_details" role="tabpanel"
                                aria-labelledby="project-details">
                                @include('tender.form.project_details')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer pb-5 pt-5">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="" class="mr-2">Reset</a>
                    <button type="submit" id="btn_loader" class="btn btn-primary tender_save jsBtnLoader"
                        name="saveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
    @include('tender.script')
@endsection
