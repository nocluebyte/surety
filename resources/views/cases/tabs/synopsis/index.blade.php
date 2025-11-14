<form action="{{route('synopsis-store')}}" method="POST" id="synopsis-form">
    @csrf
    <input type="hidden" name="cases_id" value="{{ $case->id}}">
    <input type="hidden" name="casesable_type" value="{{ $case->casesable_type}}">
    <input type="hidden" name="casesable_id" value="{{ $case->casesable_id}}">
    <table class="w-100">
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('proposal_type', trans('cases.proposal_type')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black">: 
                    {{ $case->proposal ? $case->proposal->version > 1 ? 'AMENDMENT' : 'NEW' : '' }}
                </div>
            </th>
        </tr>
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('entity_type', trans('cases.entity_type')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black">: 
                    {{ $case->contractor->typeOfEntity->name ?? '' }}
                </div>
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label(trans('cases.gst_vat_no.')) !!} </div>
            </th>
            <th width="25%">
                <div class="font-weight-bold text-black">: {{ $companyProfile->gst_no ?? '' }}</div>
            </th>
        </tr>
        <tr>
            <th width="12%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('form', trans('common.pan_no')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black"> :
                    {{ $companyProfile->pan_no ?? '' }}
                </div>
            </th>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('sector', trans('cases.sector')) !!}</div>
            </th>
            <th width="25%">
                <div class="font-weight-bold text-black"> :
                    {{ $case->contractor->tradeSectorMain->tradeSector->name ?? '' }}
                    @if (isset($case->contractor->tradeSectorMain))
                        <input type="hidden" class="jsSector"
                            data-slug-sector='{{ $case->contractor->tradeSectorMain->tradeSector->mid_level ?? "" }}'>
                    @endif
                </div>
            </th>
        </tr>
        @if($case->casesable_type == 'Principle' || $case->casesable_type == 'Proposal')
            <tr>
                <th width="10%">
                    <div class="font-weight-bold p-1 davy-grey-color">
                        {!! Form::label('parent_no', trans('cases.parent_no')) !!}</div>
                </th>
                <th width="25%">
                    <div class=" font-weight-bold  text-black"> :
                        {{ $parent->code ?? $companyProfile->code }}
                    </div>
                </th>
                <th width="12%">
                    <div class="font-weight-bold p-1 davy-grey-color">
                        {!! Form::label('parent_name', trans('cases.parent_name')) !!}</div>
                </th>
                <th width="25%">
                    <div class=" font-weight-bold  text-black"> :
                        {{ $parent->company_name ?? $companyProfile->company_name }}
                    </>
                </th>
            </tr>
        @endif
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('incharge', trans('cases.in_charge')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black">: {{ $case->underwriter_user_name ?? '' }}</div>
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1  davy-grey-color">
                    {!! Form::label('incharge_since', trans('cases.in_charge_since')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black">: {{ $case->underwriter_assigned_date ? custom_date_format($case->underwriter_assigned_date, 'd/m/Y') : '' }}</div>
            </th>
        </tr>
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label('date_of_incorporation', trans('cases.date_of_incorporation')) !!}</div>
            </th>
            <th width="25%">
                <div class=" font-weight-bold  text-black">: {{ $companyProfile->date_of_incorporation ? custom_date_format($companyProfile->date_of_incorporation, 'd/m/Y') : '' }}</div>
                {!! Form::hidden('date_of_incorporation', $companyProfile->date_of_incorporation ?? null, ['class' => 'form-control date_of_incorporation']) !!}
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('staff_strength', trans('cases.staff_strength')) !!}</div>
            </th>
            <th width="25%">
                <div class="font-weight-bold text-black">: {{ $companyProfile->staff_strength ?? '' }}</div>
                {!! Form::hidden('staff_strength', $companyProfile->staff_strength ?? null, ['class' => 'form-control staff_strength']) !!}
            </th>
        </tr>
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('contractor_rating', trans('cases.contractor_rating')) !!} </div>
            </th>
            <th width="25%">
                <div class="font-weight-bold text-black">:
                    <a type="button" data-toggle="modal" data-original-title="test" data-original-title=""
                        title=""><span
                            class="contractorRate">{{ $case->contractor_rating ?? '' }}</span></a>
                    {!! Form::hidden('contractor_rating', $case->contractor_rating ?? null, ['class' => 'form-control contractor_rating']) !!}
                </div>
            </th>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('uw_view', trans('cases.uw_view')) !!} </div>
            </th>
            <th width="25%">
                <div class="font-weight-bold text-black uw_view_dwidth"> :
                    {{ Form::select('uw_view_id', ['' => ''] + $uw_view, $case->uw_view_id ?? null, ['class' => 'form-control uw_view required jsSelect2ClearAllow', 'data-placeholder' => 'Select UW View', 'data-slug-uw' => $case->uwviewdata->mid_level ?? '', 'data-rate' => $case->uwviewdata->rating ?? ''], $mwOptAttr) }}
                </div>
            </th>
        </tr>
    </table>
    <br>
    <hr style="border-top: 1px dotted black;">
    <table style="width:100%">
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('individual_cap', trans('cases.individual_cap')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                    {{ format_amount($total_individual_cap ?? '0', '0') }}
                </div>
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('overall_cap', trans('cases.overall_cap')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                    {{ format_amount($total_overall_cap ?? '0', '0') }}

                </div>
            </th>
        </tr>
        <tr>
             <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('total_approved_limit', trans('cases.total_approved_limit')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span> </div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                    {{ isset($total_approved_limit) && $total_approved_limit > 0 ? format_amount($total_approved_limit ?? '', '0') : '0' }}
                </div>
            </th>
            
            <th width="12%">
                <div class="font-weight-bold p-1  davy-grey-color">
                    {!! Form::label('spare_capacity', trans('cases.spare_capacity')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                    {{ numberFormatPrecision($spare_capecity , 0)}}
                </div>
            </th>
        </tr>
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('credit_buyer_id', trans('cases.credit_buyer_id')) !!}</div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                </div>
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('credit_Insurance_exposure', trans('cases.credit_Insurance_exposure')) !!}</div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                </div>
            </th>  
        </tr>
        <tr>
              <th width="10%">
                <div class="font-weight-bold p-1  davy-grey-color">
                    {!! Form::label('pending', trans('cases.pending')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                    {{ isset($total_pending_limit) && $total_pending_limit > 0 ? format_amount($total_pending_limit ?? '', '0') : '0' }}
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1  davy-grey-color">
                    {!! Form::label('last_review_date', trans('cases.last_review_date')) !!}</div>
            </th>
            <th width="25%">
               
                    <div class="font-weight-bold  text-black">:
                        {{ isset($case->contractor->last_review_date) ? custom_date_format($case->contractor->last_review_date,'d/m/Y') : 'N/A' }}
                    </div>
            </th> 
        </tr>
        <tr>
            <th width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {!! Form::label('next_review_date', trans('cases.regular_review_date')) !!}</div>
            </th>
            <th width="25%">
                @if (isset($casesLimitStrategy))
                    <div class="font-weight-bold  text-black">:
                        {{ isset($casesLimitStrategy['proposed_valid_till']) ? custom_date_format($casesLimitStrategy['proposed_valid_till'],'d/m/Y') :'N/A' }}
                    </div>
                @else
                    <div class="font-weight-bold  text-black">: NA</div>
                @endif
            </th>
            <th width="12%">
                <div class="font-weight-bold p-1  davy-grey-color">
                    {!! Form::label('last_bs_date', trans('cases.last_bs_date')) !!}</div>
            </th>
            <th width="25%">
                <div class="font-weight-bold  text-black">:
                     {{ isset($case->contractor->last_balance_sheet_date) ?custom_date_format($case->contractor->last_balance_sheet_date,'d/m/Y') : 'N/A' }}
                </div>
            </th>
            
        </tr>
    </table>
    <div>
        <span class="synopsis-tab-error text-danger"></span>
    </div>
    <br>
   <div class="card-footer pt-3 pb-1 ">
        <div class="row">
            <div class="col-12  text-right">
                @if ($case->status != 'Completed' && $current_user->id === $case->underwriterUserId  &&  (($case->case_type ==='Application' &&  $case->decision_status !== NULL) || ($case->case_type ==='Review'))  )
                    <button class="btn btn-primary" type="submit">Save & Close</button>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- <div class="modal fade" id="contractorRatingModal" tabindex="-1" role="dialog"
    aria-labelledby="contractorRatingModallLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractorRatingModalLabel">Contractor Rating</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline">
                        <tbody >
                            <tr>
                                <th>Parameters</th>
                                <th><span class="contractorRatingName"></span></th>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><span class="countryRate"></span></td>
                            </tr>
                            <tr>
                                <td>Sectors</td>
                                <td><span class="sectorsRate"></span></td>
                            </tr>
                            <tr>
                                <td>Date of Est.</td>
                                <td><span class="estRate"></span></td>
                            </tr>
                            <tr>
                                <td>Employee</td>
                                <td><span class="employeeRate"></span></td>
                            </tr>
                            <tr>
                                <td>UW View</td>
                                <td><span class="uwRate"></span></td>
                            </tr>
                            <tr>
                                <td><b>Total</b></td>
                                <td><b><span class="contractorRate">{{ $cases->contractor_rating ?? '-' }}</span></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div> --}}