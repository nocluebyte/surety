<div class="modal fade bd-example-modal-lg pl-modal" id="pl-model" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl min-w-200px">
        <div class="modal-content pl-3 pb-0">
            <div class="modal-header">
                <h5 class="modal-title modal-common-title" id="exampleModalLabel">Profit & Loss</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 pt-3">
                        {{ Form::label('form_date', __('cases.form_date')) }}
                    </div>
                    <div class="col-lg-3">
                        {{ Form::date('form_date', null, ['class' => 'form-control jsFormDate required', 'min' => '1000-01-01',
                        'max' => '9999-12-31', 'data-msg-min' => 'Please enter a value greater than or equal to 01/01/1000.', 'data-msg-max' => 'Please enter a value less than or equal to 31/12/9999.']) }}
                        <label class="jsFormDateError text-danger d-none">This field is required</label>
                    </div>
                    <div class="col-lg-2 pt-3">
                        {{ Form::label('to_date', __('cases.to_date')) }}
                    </div>
                    <div class="col-lg-3">
                        {{ Form::date('to_date', null, ['class' => 'form-control jsToDate required', 'min' => '1000-01-01',
                        'max' => '9999-12-31', 'data-msg-min' => 'Please enter a value greater than or equal to 01/01/1000.', 'data-msg-max' => 'Please enter a value less than or equal to 31/12/9999.']) }}
                        <label class="jsToDateError text-danger d-none">This field is required</label>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary jsAddDate" type="button">{{ __('common.add') }}</button>
                    </div>
                </div>
                <div class="jsDateList"></div>
            </div>
            <span class="lossSuccess font-size-base mb-4 ml-6 text-success d-none">Saved Successfully</span>
            <span class="jsBalanceSheet font-size-base mb-4 ml-6 text-danger d-none">Total Assets and total must be same</span>
            <ul class="nav nav-light-success nav-bold nav-pills">
                <li class="nav-item">
                    <a class="nav-link  {{ !$tab ? 'active' : '' }} jsAnalysisTab" data-toggle="tab" href="#analysis" onclick="modalTitle('Analysis')">
                        <span class="nav-text">{{ __('cases.analysis') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link profitLossTab" id="pl-top-tab" data-toggle="tab" href="#pl" onclick="modalTitle('Profit & Loss')">
                        <span class="nav-text">{{ __('cases.profit_loss') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link balanceSheetTab" data-toggle="tab" href="#bs" onclick="modalTitle('Balance Sheet')">
                        <span class="nav-text">{{ __('cases.balance_sheet') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ratiosTab" data-toggle="tab" href="#ratios" onclick="modalTitle('Ratios')">
                        <span class="nav-text">{{ __('cases.ratios') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link jsAnalysisTl" data-toggle="tab" href="#at" onclick="modalTitle('Analysis TimeLine')">
                        <span class="nav-text">{{ __('cases.analysis_timeLine') }}</span>
                    </a>
                </li>
                <li class="nav-item text-right jsSaveProfitLoss d-none">
                    <button class="btn btn-primary jsSaveProfitLossBtn" disabled type="button">Save</button>
                </li>
            </ul>
            <hr class="w-100 text-left ml-0">
            <div class="tab-content">
                <div class="tab-pane fade {{ !$tab ? 'active show' : '' }} pt-5" id="analysis" role="tabpanel" aria-labelledby="analysis">
                    <div id="top-analysis">
                        <div class="modal-body">
                            <h4 class="modal-title" id="myLargeModalLabel">{{ __('cases.analysis') }}
                            </h4>
                            <div class="form-group">
                                <br>
                                {{ Form::hidden('cases_id',$case->id ?? null, ['class'=>'jsCasesId']) }}
                                {{ Form::hidden('case_action_plan_id',$case_action_plan->id ?? null, ['class'=>'jsCaseActionPlanId']) }}
                                <textarea id="analysisDescription" name="editor1" cols="30" rows="10" class="form-control"></textarea>
                                <label class="jsAnalysisError text-danger d-none">This field is required</label>
                                <br>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary jsAnalysisButton" type="button">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade pt-3 p-5" id="pl" role="tabpanel" aria-labelledby="pl">
                    <div class="jsTr"></div>
                </div>

                <div class="tab-pane fade pt-3 p-5" id="bs" role="tabpanel" aria-labelledby="bs">
                    <div class="jsTrBalanceSheet"></div>
                </div>

                <div class="tab-pane fade pt-3 p-5" id="ratios" role="tabpanel" aria-labelledby="ratios">
                    <div class="jsTrratios"></div>
                </div>
                <div class="tab-pane fade pt-3 p-5" id="at" role="tabpanel" aria-labelledby="at">
                    <div class="example example-basic">
                        <div class="example-preview analysis-time-line-preview">
                                @include('cases.tabs.action-plan.analysistimeline_log')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>