<div class="row p-2">
    <div class="col text-light-grey">{{__('principle.type_of_entity')}}</div>:
    <div class="col">{{ $invocationData->contractor->typeOfEntity->name ?? '' }}</div>
    <div class="col text-light-grey">{{__('common.gst')}}</div>:
    <div class="col">{{$invocationData->proposal->contractor_gst_no ?? ''}}</div>
    <div class="col text-light-grey">{{__('common.pan_no')}}</div>:
    <div class="col">{{$invocationData->proposal->contractor_pan_no ?? ''}}</div>
</div>
<div class="row p-2">
    <div class="col text-light-grey">{{__('principle.group_no')}}</div>:
    <div class="col"> {{$invocationData->contractor->group->contractor->code ?? $invocationData->contractor->code ?? ''}}</div>
    <div class="col text-light-grey">{{__('principle.group_name')}}</div>:
    <div class="col">{{$invocationData->contractor->group->contractor->company_name ?? $invocationData->contractor->company_name ?? ''}}</div>
    <div class="col text-light-grey">{{__('invocation_notification.incharge')}}</div>:
    <div class="col"> {{$invocationData->cases->first()->underwriterUserName ?? '-'}}</div>
</div>
<div class="row p-2">
    <div class="col text-light-grey">{{__('invocation_notification.incharge_since')}}</div>:
    <div class="col"> {{isset($invocationData->cases->first()->underwriter_assigned_date) ? custom_date_format($invocationData->cases->first()->underwriter_assigned_date,'d/m/Y | H:i') : '-'}}</div>
    <div class="col text-light-grey">{{__('principle.date_of_incorporation')}}</div>:
    <div class="col">{{ isset($invocationData->contractor->date_of_incorporation) ? custom_date_format($invocationData->contractor->date_of_incorporation, 'd/m/Y') : '' }}</div>
    <div class="col text-light-grey">{{__('principle.staff_strength')}}</div>:
    <div class="col">{{ $invocationData->contractor->staff_strength ?? '' }}</div>
</div>
<div class="row p-2">
    <div class="col text-light-grey">{{__('principle.rating')}}</div>:
    <div class="col">{{ $invocationData->contractor->contractor_rating ?? '' }}</div>
    <div class="col text-light-grey">{{__('principle.uv_view')}}</div>:
    <div class="col">{{ $invocationData->contractor->uwViewName->name ?? '' }}</div>
    <div class="col"></div>
    <div class="col"></div>
</div>

<hr>

<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="tradsectoraccordion">
    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsetradsector"
                aria-expanded="false">
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
                <div class="card-label pl-4">{{ __('cases.tradesector') }}</div>
            </div>
        </div>
        <div id="collapsetradsector" class="collapse" data-parent="#tradsectoraccordion">
            <div class="card-body">
                <table class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="p-2">{{ __('common.no') }}</th>
                            <th class="p-2 w-40">
                                {{ __('proposals.trade_sector') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.from') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.till') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.main') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($invocationData->contractor->tradeSector) && $invocationData->contractor->tradeSector->count() > 0)
                            @foreach ($invocationData->contractor->tradeSector as $item)
                                <tr>
                                    <td class="p-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="p-2">
                                        {{ $item->tradeSector->name ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ custom_date_format($item->from, 'd/m/Y') ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ custom_date_format($item->till, 'd/m/Y') ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ $item->is_main ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="10">
                                    {{ __('common.no_records_found') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>