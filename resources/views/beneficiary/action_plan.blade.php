<table style="width:100%">
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.reason_for_submission') }}</div>
        </th>
        <th width="20%">
            <div class="font-weight-bold my-2 text-light-grey">{{ __('principle.any_adverse_notification') }}</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black"></div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black"></div>
        </th>
    </tr>
</table>
<hr>
<h4>{{ __('Financials') }}</h4>
<br>
<table style="width:100%">
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">{{ __('principle.types_of_account') }}</div>
        </th>
        <th width="20%">
            <div class="font-weight-bold my-2 text-light-grey">{{ __('common.currency') }}</div>
        </th>
    </tr>
    <tr>
        <th>
            <h6>
                <div class="form-group font-weight-bold mt-n2 text-black">
                    
                </div>
            </h6>
        </th>
        <th>
            <h6>
                <div class="form-group font-weight-bold mt-n2 text-black">
                </div>
            </h6>
        </th>
    </tr>
</table>
<div class="row">
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="profitLoss_tab" id="pl-model">{{ __('cases.profit_loss') }}</button>
        <div class="modal fade bd-example-modal-lg pl-modal" id="pl-model"
            role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 1200Px;">
                <div class="modal-content pl-3 pb-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('cases.profit_loss') }}
                        </h5>
                        <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <br>
                    <ul class="nav nav-light-success nav-bold nav-pills">
                        <li class="nav-item">
                            <a class="nav-link profitLoss_tab active"
                                id="pl-top-tab" data-toggle="tab" href="#pl">
                                <span class="nav-text">{{ __('cases.profit_loss') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link balanceSheet_tab" data-toggle="tab"
                                href="#bs">
                                <span class="nav-text">{{__('cases.balance_sheet')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ratios_tab" data-toggle="tab"
                                href="#ratios">
                                <span class="nav-text">{{__('cases.ratios')}}</span>
                            </a>
                        </li>
                    </ul>

                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="tab-content">
                        <div class="tab-pane fade pt-3 p-5 active show" id="pl" role="tabpanel" aria-labelledby="pl"></div>

                        <div class="tab-pane fade pt-3 p-5" id="bs" role="tabpanel" aria-labelledby="bs"></div>

                        <div class="tab-pane fade pt-3 p-5" id="ratios" role="tabpanel" aria-labelledby="ratios"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="balanceSheet_tab" id="pl-model">{{__('cases.balance_sheet')}}</button>

    </div>
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="ratios_tab" id="pl-model">{{__('cases.ratios')}}</button>

    </div>
</div>
<hr>
<h4>{{ __('cases.limit_strategy') }}</h4>
<br>
<div class="col-sm-12">
    <ul class="nav nav-tabs nav-light-info nav-bold  ">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
                <span class="nav-icon"><i
                        class="flaticon2-hourglass-1"></i></span>
                <span class="nav-text">{{ __('cases.current') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">
                <span class="nav-icon"><i
                        class="flaticon2-pie-chart-4"></i></span>
                <span class="nav-text">{{ __('cases.past') }}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel"
            aria-labelledby="kt_tab_pane_2">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 2%;"></th>
                        <th width="25%" class="text-right">{{ __('cases.individual_cap') }} </th>
                        <th width="25%" class="text-right">{{ __('cases.overall_cap') }}</th>
                        <th width="25%" class="text-center">{{ __('cases.valid_till') }}</th>
                        <th width="23%" class="text-right">{{ __('cases.group_cap') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">{{ __('common.no_records_found') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel"
            aria-labelledby="kt_tab_pane_2">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 2%;"></th>
                        <th width="25%" class="text-right">{{ __('cases.individual_cap') }} </th>
                        <th width="25%" class="text-right">{{ __('cases.overall_cap') }}</th>
                        <th width="25%" class="text-center">{{ __('cases.valid_till') }}</th>
                        <th width="23%" class="text-right">{{ __('cases.group_cap') }}</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td colspan="5" class="text-center">{{ __('common.no_records_found') }}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>