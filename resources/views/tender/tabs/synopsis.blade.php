<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle"
                            id="accordionExample7">
    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title" data-toggle="collapse"
                data-target="#collapseOne7" aria-expanded="false">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
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
                <div class="card-label pl-4">{{ __('tender.tender_details') }}</div>
            </div>
        </div>
        <div id="collapseOne7" class="collapse show"
            data-parent="#accordionExample7">
            <div class="card-body pl-12">
                <table class="w-100">
                    <tr>
                        <td style="width: 20%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.contract_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            </div>
                        </td>
                        <td>:</td>
                        <td style="width: 30%">
                            <div class="font-weight-bold text-black">
                                {{ numberFormatPrecision($tender->contract_value, 0) ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td style="width: 20%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.period_of_contract') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td style="width: 30%">
                            <div class="font-weight-bold text-black">
                                {{ $tender->period_of_contract ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.bond_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ numberFormatPrecision($tender->bond_value, 0) ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.bond_type') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->bondType->name ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.location') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->location ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_type') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->projectType->name ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.type_of_contracting') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->type_of_contracting ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.rfp_date') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ custom_date_format($tender->rfp_date, 'd/m/Y') ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.rfp_attachment') }}
                            </div>
                        </td>
                        <td>:</td>
                        {{-- @dd($tender_document) --}}
                        <td>
                            <div class="font-weight-bold  text-black">
                                <a href="#" data-toggle="modal"
                                    data-target="#tenderDocuments"
                                    class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table class="w-100">
                    <tr>
                        <td class="w-30">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.tender_description') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->tender_description ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="w-30">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_description_label') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->project_description ?? '-' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingTwo7">
            <div class="card-title collapsed" data-toggle="collapse"
                data-target="#collapseTwo7">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
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
                <div class="card-label pl-4">{{ __('tender.project_details') }}</div>
            </div>
        </div>
        <div id="collapseTwo7" class="collapse" data-parent="#accordionExample7">
            <div class="card-body pl-12">
                <table class="w-100">
                    <tr>
                        <td style="width: 20%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.beneficiary') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td style="width: 30%">
                            <div class="font-weight-bold text-black">
                                {{ $tender->projectDetailsBeneficiary->company_name ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td style="width: 20%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_name') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td style="width: 30%">
                            <div class="font-weight-bold text-black">
                                {{ $tender->pd_project_name ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table class="w-100">
                    <tr>
                        <td class="position-absolute">
                            <div class="font-weight-bold p-1 davy-grey-color position-relative">
                                {{ __('tender.project_description') }} :
                            </div>
                        </td>
                        <td></td>
                        <td width="80%">
                            <div class="font-weight-bold  text-black">
                                {{ $tender->pd_project_description ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table class="w-100">
                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_value') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ numberFormatPrecision($tender->pd_project_value, 0) ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.type_of_project') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->projectType->name ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_start_date') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ custom_date_format($tender->pd_project_start_date, 'd/m/Y') ?? '-' }}
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.project_end_date') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ custom_date_format($tender->pd_project_end_date, 'd/m/Y') ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {{ __('tender.period_of_project') }}
                            </div>
                        </td>
                        <td>:</td>
                        <td>
                            <div class="font-weight-bold  text-black">
                                {{ $tender->pd_period_of_project ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>