<div class="modal fade bd-example-modal-lg pl-modal" id="pl-model" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl min-w-200px">
        <div class="modal-content pl-3 pb-0">
            <div class="modal-header">
                <h5 class="modal-title modal-common-title" id="exampleModalLabel">Profit & Loss</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">


            <ul class="nav nav-light-success nav-bold nav-pills">
                <li class="nav-item">
                    <a class="nav-link profitLossTab" id="pl-top-tab" data-toggle="tab" href="#pl">
                        <span class="nav-text">{{ __('cases.profit_loss') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link balanceSheetTab" data-toggle="tab" href="#bs">
                        <span class="nav-text">{{ __('cases.balance_sheet') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ratiosTab" data-toggle="tab" href="#ratios">
                        <span class="nav-text">{{ __('cases.ratios') }}</span>
                    </a>
                </li>
            </ul>
            <hr class="w-100 text-left ml-0">
            <div class="tab-content">
                <div class="tab-pane pt-3 p-5" id="pl" role="tabpanel" aria-labelledby="pl">
                        @include('principle.tabs.action-plan.profit-loss')
                </div>

                <div class="tab-pane fade pt-3 p-5" id="bs" role="tabpanel" aria-labelledby="bs">
                       @include('principle.tabs.action-plan.balance-sheet')
                </div>

                <div class="tab-pane fade pt-3 p-5" id="ratios" role="tabpanel" aria-labelledby="ratios">
                        @include('principle.tabs.action-plan.ratios')
                </div>
            </div>
            </div>
        </div>
    </div>
</div>