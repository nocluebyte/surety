<div class="card-body">
    <div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="accordionExample7">

        <div class="card">
            <div class="card-header" id="banking_limits_header">
                <div class="card-title" data-toggle="collapse" data-target="#banking_limits" aria-expanded="false">
                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                    <div class="card-label pl-4">{{ __('principle.banking_limits') }}</div>
                </div>
            </div>
            <div id="banking_limits" class="collapse show" data-parent="#accordionExample7">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('principle.banking_category_label') }}
                                    </th>
                                    <th>
                                        {{ __('principle.facility_types_label') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.sanctioned_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </th>
                                    <th class="text-center">
                                        {{ __('principle.bank_name') }}
                                    </th>
                                    <td class="text-right">
                                        {{ __('principle.latest_limit_utilized') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ __('principle.unutilized_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ __('principle.commission_on_pg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ __('principle.commission_on_fg') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </td>
                                    <td class="text-right">
                                        {{ __('principle.margin_collateral') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </td>
                                    <td>
                                        {{ __('principle.other_banking_details') }}
                                    </td>
                                    <td>
                                        {{ __('principle.banking_limits_attachment') }}
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($principle->bankingLimits->sortDesc() as $bankingLimit)
                                    <tr>
                                        <td class="width_10em">{{ $bankingLimit->getBankingLimitCategoryName->name ?? '' }}</td>
                                        <td class="width_10em">{{ $bankingLimit->getFacilityTypeName->name ?? '' }}</td>
                                        <td class="text-right width_10em">
                                            {{ isset($bankingLimit->sanctioned_amount) ? numberFormatPrecision($bankingLimit->sanctioned_amount, 0) : '' }}</td>
                                        <td class="text-center width_10em">{{ $bankingLimit->bank_name ?? '' }}</td>
                                        <td class="text-right width_10em">{{ numberFormatPrecision($bankingLimit->latest_limit_utilized, 0) }}
                                        </td>
                                        <td class="text-right width_10em">
                                            {{ isset($bankingLimit->unutilized_limit) ? numberFormatPrecision($bankingLimit->unutilized_limit, 0) : '' }}</td>
                                        <td class="text-right width_10em">
                                            {{ isset($bankingLimit->commission_on_pg) ? numberFormatPrecision($bankingLimit->commission_on_pg, 0) : '' }}</td>
                                        <td class="text-right width_10em">
                                            {{ isset($bankingLimit->commission_on_fg) ? numberFormatPrecision($bankingLimit->commission_on_fg, 0) : '' }}</td>
                                        <td class="text-right width_10em">
                                            {{ isset($bankingLimit->margin_collateral) ? numberFormatPrecision($bankingLimit->margin_collateral, 0) : '' }}</td>
                                        <td class="width_35em">
                                            {{ isset($bankingLimit->other_banking_details) ? $bankingLimit->other_banking_details : '-' }}</td>
                                        <td class="width_10em">
                                            <!-- Button trigger modal-->
                                            <a type="button" data-toggle="modal"
                                                data-target="#bankingLimit_attachment_modal_{{ $loop->iteration }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <!-- Modal-->
                                            <div class="modal fade"
                                                id="bankingLimit_attachment_modal_{{ $loop->iteration }}"
                                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div data-scroll="true" data-height="100">
                                                                @foreach ($bankingLimit->dMS as $document)
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            {{ $loop->iteration }}.
                                                                            {{ $document->file_name }}
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo7">
                <div class="card-title collapsed" data-toggle="collapse" data-target="#projectTrackRecords">
                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                    <div class="card-label pl-4">{{ __('principle.project_track_records') }}</div>
                </div>
            </div>
            <div id="projectTrackRecords" class="collapse" data-parent="#accordionExample7">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('principle.project_name') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.project_cost') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </th>
                                    <th>
                                        {{ __('principle.project_description') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_start_date') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_end_date') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_tenor') }}
                                    </th>
                                    {{-- <th>
                                        {{ __('principle.description') }}
                                    </th> --}}
                                    <th>
                                        {{ __('principle.bank_guarantees_details') }}
                                    </th>
                                    {{-- <th>
                                        {{ __('principle.principal_name') }}
                                    </th>
                                    <th>
                                        {{ __('principle.estimated_date_of_completion') }}
                                    </th>
                                    <th>
                                        {{ __('principle.type_of_project_track') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_share_track') }}
                                    </th> --}}
                                    <th>
                                        {{ __('principle.actual_date_completion') }}
                                    </th>
                                    {{-- <th>
                                        {{ __('principle.amount_margin') }}
                                    </th> --}}
                                    <th class="text-right">
                                        {{ __('principle.bg_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </th>
                                    {{-- <th>
                                        {{ __('principle.completion_status') }}
                                    </th> --}}
                                    <th>
                                        {{ __('principle.project_track_records_attachment') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($principle->projectTrackRecords->sortDesc() as $projectTrackRecord)
                                    <tr>
                                        <td class="width_10em">{{ isset($projectTrackRecord->project_name) ? $projectTrackRecord->project_name : '-' }}</td>
                                        <td class="text-right width_10em">
                                            {{ isset($projectTrackRecord->project_cost) ? numberFormatPrecision($projectTrackRecord->project_cost, 0) : '-' }}</td>
                                        <td class="width_35em">{{ isset($projectTrackRecord->project_description) ? $projectTrackRecord->project_description : '-' }}</td>
                                        <td class="width_10em">{{ isset($projectTrackRecord->project_start_date) ? custom_date_format($projectTrackRecord->project_start_date, 'd/m/Y') : '-' }}</td>
                                        <td class="width_10em">{{ isset($projectTrackRecord->project_end_date) ? custom_date_format($projectTrackRecord->project_end_date, 'd/m/Y') : '-' }}</td>
                                        <td class="width_10em">
                                            {{ isset($projectTrackRecord->project_tenor) ? $projectTrackRecord->project_tenor : '-' }}</td>

                                        <td class="width_35em">{{ isset($projectTrackRecord->bank_guarantees_details) ? $projectTrackRecord->bank_guarantees_details : '-' }}</td>
                                        {{-- <td>{{ $projectTrackRecord->description ?? '' }}</td> --}}
                                        {{-- <td>{{ $projectTrackRecord->principal_name ?? '' }}</td>
                                        <td>{{ custom_date_format($projectTrackRecord->estimated_date_of_completion, 'd/m/Y') }}
                                        </td>
                                        <td>
                                            {{ $projectTrackRecord->getProjectTypeName->name ?? '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($projectTrackRecord->project_share_track) ? numberFormatPrecision($projectTrackRecord->project_share_track, 0) : '' }}
                                        </td> --}}
                                        <td class="width_10em">{{ custom_date_format($projectTrackRecord->actual_date_completion, 'd/m/Y') }}
                                        </td>
                                        {{-- <td class="text-right">
                                            {{ isset($projectTrackRecord->amount_margin) ? numberFormatPrecision($projectTrackRecord->amount_margin, 0) : '' }}</td> --}}
                                        <td class="text-right width_10em">
                                            {{ isset($projectTrackRecord->bg_amount) ? numberFormatPrecision($projectTrackRecord->bg_amount, 0) : '-' }}</td>
                                        {{-- <td>
                                            {{ $projectTrackRecord->completion_status }}
                                        </td> --}}
                                        <td class="width_10em">
                                            <!-- Button trigger modal-->
                                            <a type="button" data-toggle="modal"
                                                data-target="#project_track_records_attachment_modal_{{ $loop->iteration }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <!-- Modal-->
                                            <div class="modal fade"
                                                id="project_track_records_attachment_modal_{{ $loop->iteration }}"
                                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div data-scroll="true" data-height="100">
                                                                @foreach ($projectTrackRecord->dMS as $document)
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            {{ $loop->iteration }}.
                                                                            {{ $document->file_name }}
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo7">
                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo7">
                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                    <div class="card-label pl-4">{{ __('principle.order_book_and_future_projects') }}</div>
                </div>
            </div>
            <div id="collapseTwo7" class="collapse" data-parent="#accordionExample7">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th>
                                        {{ __('principle.project_scope') }}
                                    </th>
                                    <th>
                                        {{ __('principle.principal_name') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_location') }}
                                    </th>
                                    <th>
                                        {{ __('principle.type_of_project') }}
                                    </th>
                                    <th>
                                        {{ __('principle.contract_value') }}
                                    </th>
                                    <th>
                                        {{ __('principle.anticipated_date') }}
                                    </th>
                                    <th>
                                        {{ __('principle.tenure') }}
                                    </th> --}}
                                    <th>
                                        {{ __('principle.project_name') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.project_cost') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </th>
                                    <th>
                                        {{ __('principle.project_description') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_start_date') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_end_date') }}
                                    </th>
                                    <th>
                                        {{ __('principle.project_tenor') }}
                                    </th>
                                    <th>
                                        {{ __('principle.bank_guarantees_details') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.project_share') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.guarantee_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </th>
                                    <th>
                                        {{ __('principle.current_status') }}
                                    </th>
                                    <th>
                                        {{ __('principle.order_book_and_future_projects_attachment') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($principle->orderBookAndFutureProjects->sortDesc() as $orderBookAndFutureProjects)
                                    <tr>
                                        {{-- <td>{{ $orderBookAndFutureProjects->project_scope ?? '' }}</td>
                                        <td>{{ $orderBookAndFutureProjects->principal_name ?? '' }}</td>
                                        <td>{{ $orderBookAndFutureProjects->project_location ?? '' }}</td>
                                        <td>{{ $orderBookAndFutureProjects->getProjectTypeName->name ?? '' }}</td>
                                        <td class="text-right">
                                            {{ isset($orderBookAndFutureProjects->contract_value) ? numberFormatPrecision($orderBookAndFutureProjects->contract_value, 0) : '' }}
                                        </td>
                                        <td>{{ custom_date_format($orderBookAndFutureProjects->anticipated_date, 'd/m/Y') }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($orderBookAndFutureProjects->tenure) ? numberFormatPrecision($orderBookAndFutureProjects->tenure, 0) : '' }}
                                        </td> --}}
                                        <td class="width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_name) ? $orderBookAndFutureProjects->project_name : '-' }}
                                        </td>
                                        <td class="text-right width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_cost) ? numberFormatPrecision($orderBookAndFutureProjects->project_cost, 0) : '-' }}
                                        </td>
                                        <td class="width_35em">
                                            {{ isset($orderBookAndFutureProjects->project_description) ? $orderBookAndFutureProjects->project_description : '-' }}
                                        </td>
                                        <td class="width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_start_date) ? custom_date_format($orderBookAndFutureProjects->project_start_date, 'd/m/Y') : '-' }}
                                        </td>
                                        <td class="width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_end_date) ? custom_date_format($orderBookAndFutureProjects->project_end_date, 'd/m/Y') : '-' }}
                                        </td>
                                        <td class="width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_tenor) ? $orderBookAndFutureProjects->project_tenor : '-' }}
                                        </td>
                                        <td class="width_35em">
                                            {{ isset($orderBookAndFutureProjects->bank_guarantees_details) ? $orderBookAndFutureProjects->bank_guarantees_details : '-' }}
                                        </td>
                                        <td class="text-right width_10em">
                                            {{ isset($orderBookAndFutureProjects->project_share) ? numberFormatPrecision($orderBookAndFutureProjects->project_share, 0) : '-' }}
                                        </td>
                                        <td class="text-right width_10em">
                                            {{ isset($orderBookAndFutureProjects->guarantee_amount) ? numberFormatPrecision($orderBookAndFutureProjects->guarantee_amount, 0) : '-' }}
                                        </td>
                                        <td class="width_10em">
                                            {{ $orderBookAndFutureProjects->current_status ?? '-' }}
                                        </td>
                                        <td class="width_10em">
                                            <!-- Button trigger modal-->
                                            <a type="button" data-toggle="modal"
                                                data-target="#order_book_and_future_projects_attachment_modal_{{ $loop->iteration }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <!-- Modal-->
                                            <div class="modal fade"
                                                id="order_book_and_future_projects_attachment_modal_{{ $loop->iteration }}"
                                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div data-scroll="true" data-height="100">
                                                                @foreach ($orderBookAndFutureProjects->dMS as $document)
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            {{ $loop->iteration }}.
                                                                            {{ $document->file_name }}
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo7">
                <div class="card-title collapsed" data-toggle="collapse" data-target="#managementProfiles">
                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                    <div class="card-label pl-4">{{ __('principle.management_profiles') }}</div>
                </div>
            </div>
            <div id="managementProfiles" class="collapse" data-parent="#accordionExample7">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('principle.designation') }}
                                    </th>
                                    <th>
                                        {{ __('principle.name') }}
                                    </th>
                                    <th>
                                        {{ __('principle.qualifications') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('principle.experience') }}
                                    </th>
                                    <th>
                                        {{ __('principle.management_profiles_attachment') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($principle->managementProfiles->sortDesc() as $managementProfile)
                                    <tr>
                                        <td>{{ $managementProfile->getDesignationName->name ?? '' }}</td>
                                        <td>{{ $managementProfile->name ?? '' }}</td>
                                        <td>{{ $managementProfile->qualifications ?? '' }}</td>
                                        <td class="text-right">{{ numberFormatPrecision($managementProfile->experience, 0) ?? '' }}</td>
                                        <td>
                                            <!-- Button trigger modal-->
                                            <a type="button" data-toggle="modal"
                                                data-target="#management_profiles_attachment_modal_{{ $loop->iteration }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <!-- Modal-->
                                            <div class="modal fade"
                                                id="management_profiles_attachment_modal_{{ $loop->iteration }}"
                                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div data-scroll="true" data-height="100">
                                                                @foreach ($managementProfile->dMS as $document)
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            {{ $loop->iteration }}.
                                                                            {{ $document->file_name }}
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="additional_details_for_assessment_header">
                <div class="card-title collapsed" data-toggle="collapse" data-target="#additional_details_for_assessment" aria-expanded="false">
                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                    <div class="card-label pl-4">{{ __('principle.additional_details_for_assessment') }}</div>
                </div>
            </div>
            <div id="additional_details_for_assessment" class="collapse" data-parent="#accordionExample7">
                <div class="card-body">
                    <table style="width:100%">
                        <tr>
                            @if($principle->is_bank_guarantee_provided == 'Yes')
                                <td style="width: 15%;">
                                    <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.circumstance_short_notes') }} </div>
                                </td>
                                <td style="width: 12%;">
                                    <div class=" font-weight-bold text-black">: {{ $principle->circumstance_short_notes ?? '-' }}</div>
                                </td>
                            @else
                                <td style="width: 12%;">
                                    <div class="font-weight-bold p-1 text-light-grey">{{  __('principle.is_bank_guarantee_provided') }}</div>
                                </td>
                                <td style="width: 12%;">
                                    <div class=" font-weight-bold text-black">: {{ $principle->is_bank_guarantee_provided ?? '-' }}</div>
                                </td>
                            @endif
                        </tr>
                        <tr>&nbsp;</tr>

                        <tr>
                            @if($principle->is_action_against_proposer == 'Yes')
                                <td style="width: 15%;">
                                    <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.action_details') }} </div>
                                </td>
                                <td style="width: 12%;">
                                    <div class=" font-weight-bold text-black">: {{ $principle->action_details ?? '-' }}</div>
                                </td>
                            @else
                                <td style="width: 12%;">
                                    <div class="font-weight-bold p-1 text-light-grey">{{  __('principle.is_action_against_proposer') }}</div>
                                </td>
                                <td style="width: 12%;">
                                    <div class=" font-weight-bold text-black">: {{ $principle->is_action_against_proposer ?? '-' }}</div>
                                </td>
                            @endif
                        </tr>
                        <tr>&nbsp;</tr>

                        <tr>
                            <td style="width: 15%;">
                                <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.contractor_failed_project_details') }} </div>
                            </td>
                            <td style="width: 12%;">
                                <div class=" font-weight-bold text-black">: {{ $principle->contractor_failed_project_details ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>&nbsp;</tr>

                        <tr>
                            <td style="width: 15%;">
                                <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.completed_rectification_details') }} </div>
                            </td>
                            <td style="width: 12%;">
                                <div class=" font-weight-bold text-black">: {{ $principle->completed_rectification_details ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>&nbsp;</tr>

                        <tr>
                            <td style="width: 15%;">
                                <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.performance_security_details') }} </div>
                            </td>
                            <td style="width: 12%;">
                                <div class=" font-weight-bold text-black">: {{ $principle->performance_security_details ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>&nbsp;</tr>

                        <tr>
                            <td style="width: 15%;">
                                <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.relevant_other_information') }} </div>
                            </td>
                            <td style="width: 12%;">
                                <div class=" font-weight-bold text-black">: {{ $principle->relevant_other_information ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>&nbsp;</tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
