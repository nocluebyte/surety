<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="tenderaccordion">
    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title" data-toggle="collapse" data-target="#collapsetender" aria-expanded="false">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"></path>
                            <path
                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                            </path>
                        </g>
                    </svg>
                </span>
                <div class="card-label pl-4">Tender Details</div>
            </div>
        </div>
        <div id="collapsetender" class="collapse show" data-parent="#tenderaccordion">
            <div class="card-body">


                <table class="w-100">
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.tender_id')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->tender->tender_id ?? ''}}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.tender_header')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->tender->tender_header ?? '' }}</div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.tender_description')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->tender->tender_description ?? ''}}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.location')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->tender->location ?? '' }}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.project_type')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->tender->projectType->name ?? ''}} -
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.beneficiary')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->tender->beneficiary->company_name ?? ''}}</div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label( __('tender.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{numberFormatPrecision($case->tender->contract_value, 0) ?? ''}}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label(__('tender.period_of_contract')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->tender->period_of_contract ?? ''}}</div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label('bond_value', __('tender.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{isset($case->tender->bond_value) ? numberFormatPrecision($case->tender->bond_value,0) : '' }}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.bond_type')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->tender->bondType->name ?? ''}}</div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.type_of_contracting')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->tender->type_of_contracting ?? ''}}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('tender.rfp_date')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">:
                                {{isset($case->tender->rfp_date) ? custom_date_format($case->tender->rfp_date,'d/m/Y') : '-'}}
                            </div>
                        </th>
                        <tr>
                            <th width="10%">
                                <div class="font-weight-bold p-1 davy-grey-color">
                                    {!! Form::label( __('tender.rfp_attachment')) !!}
                                </div>
                            </th>
                            <th width="25%">
                                <div class="font-weight-bold text-black">:
                                    <a href="#" data-toggle="modal" data-target="#tenderDocuments" class="call-modal navi-link"><i
                                    class="fa fa-file" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <div class="font-weight-bold p-1 davy-grey-color">
                                    {!! Form::label(__('tender.project_description_label')) !!}
                                </div>
                            </th>
                            <th>
                                <div class="font-weight-bold text-black">:
                                    {{$case->tender->project_description ?? ''}}
                                </div>
                            </th>
                        </tr>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="tenderDocuments">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tender Documents</h5>
            </div>
            <div class="modal-body">
                @if (isset($case->tender->dMS) && $case->tender->dMS->count() > 0)
                    @foreach ($case->tender->dMS as $item)
                        <div class="mb-3">
                            <a href="{{ isset($item->attachment) && !empty($item->attachment) ? route('secure-file', encryptId($item->attachment)) : asset('/default.jpg') }}"
                                target="_blanck">
                                {!! getdmsFileIcon(e($item->file_name)) !!}
                            </a>
                            {{ $item->file_name ?? '' }}
                        </div>
                    @endforeach
                @else
                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                @endif
            </div>
        </div>
    </div>
</div>