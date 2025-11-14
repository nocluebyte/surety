@extends($theme)
@section('content')
@section('title', $page_title)
@php
    $navigation = [
        'page_title' => $page_title ? $page_title : __('dms.document'),
        'back_action' => route('dms.show', encryptId($contractor_id)),
        'target' => '#commonModalID',
        'text' => __('common.back'),
        // 'filter_modal_id' => '#dmsFilter',
        'permission' => true,
    ];
    if($dms->isNotEmpty()){
        $navigation = array_merge($navigation, [
            'add_modal' => collect([
                'action' => route('dms.create', ['type' => encryptId($type), 'review_case_id' => encryptId($review_case_id), 'contractor_id' => encryptId($contractor_id)]),
                'target' => '#commonModalID',
                'text' => __('common.add'),
            ]),
            'text' => __('common.back'),
            'permission' => $current_user->hasAnyAccess('users.superadmin', 'dms.add'),
        ]);
    }
@endphp
@component('partials._subheader.subheader-v6', $navigation)
@endcomponent
@php
$user = Sentinel::getUser();
$underWriter = $user->roles->first();
$slug = $underWriter->slug ?? '';
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                @if ($isfilter && $dms->isNotEmpty())

                    @foreach ($dms->groupBy('dmsable_id') as $docs)
                        <div class="col-12 my-5">
                            {{-- <h4><strong>{{ Str::headline($key) }}</strong></h4> --}}
                            {{-- <h5><strong>{{ __('dms.review') . " | " . custom_date_format($docs->first()->created_at, 'd/m/Y | H:i') }}</strong></h5> --}}
                            <h5>{{ __('dms.review') . " | " . custom_date_format($docs->first()->created_at, 'd/m/Y | H:i') }}</h5>
                        </div>
                        @foreach ($docs as $attachment)
                            @php
                                $fileext = pathinfo(storage_path($attachment->attachment), PATHINFO_EXTENSION);
                                $allowedAccess = $user->hasAnyAccess(['users.superadmin']);
                                // $isVisible = $allowedAccess || in_array($slug, ['underwriter', 'contractor-principle']);
                                $isVisible = $current_user->hasAnyAccess('users.superadmin', 'dms.view');
                                $hideClass = $isVisible ? '' : 'd-none';
                            @endphp

                            <div class="col-md-6 col-lg-4 col-xl-2 pb-5 {{ $hideClass }}">
                                <div class="card h-100">
                                         <div class="ribbon ribbon-top ribbon-ver ribbon ribbon-clip ribbon-left">
                                    @if ($attachment->final_submission === 'Yes')    
                                        <div class="ribbon-target" style="top: 15px; height: 45px;">
                                            <span class="ribbon-inner bg-warning"></span><i class="fa fa-lock text-white"></i>
                                        </div>
                                    @endif
                                    @if ($attachment->trashed())
                                        <div class="ribbon-target" style="top: 70px; height: 45px;">
                                            <span class="ribbon-inner bg-danger"></span><i class="fa fa-trash text-white"></i>
                                        </div>
                                    @endif
                                        <div class="float-right">
                                                 <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                                            <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="ki ki-bold-more-hor"></i>
                                            </a>
                                            @if (!$attachment->trashed())
                                                <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                                                    <ul class="navi navi-hover">
                                                        @if($current_user->hasAnyAccess('users.superadmin', 'dms.edit'))
                                                            <li class="navi-item">
                                                                <a class="call-modal navi-link" data-toggle="modal"
                                                                    data-original-title="test"
                                                                    data-target-modal="#commonModalID"
                                                                    data-url="{{ route('dms.edit', [encryptId($attachment->id), 'contractor_id' => encryptId($contractor_id)]) }}">
                                                                        <span class="navi-icon"><i class="fas fa-edit"></i></span><span
                                                                        class="navi-text">Edit</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if($current_user->hasAnyAccess('users.superadmin'))
                                                            <li class="navi-item">
                                                                <a class="delete-confrim navi-link"  href="{{route('dms.destroy', [encryptId($attachment->id)])}}">
                                                                        <span class="navi-icon"><i class="fas fa-trash all"></i></span><span
                                                                        class="navi-text">Delete</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        </div>
                                    </div>

                                    <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4">
                                        <a href="{{ isset($attachment->attachment) ? route('secure-file', encryptId($attachment->attachment)) : '' }}"
                                        class="text-gray-800 text-hover-primary d-flex flex-column"
                                        target="_blank">
                                            <div class="symbol-60px mb-5">
                                                @switch($fileext)
                                                    @case('xlsx') @case('xls')
                                                        <img class="dmsIcon" src="{{ asset('/media/svg/files/exl.png') }}" alt="">
                                                        @break
                                                    @case('doc') @case('docx')
                                                        <img class="dmsIcon" src="{{ asset('/media/svg/files/doc.svg') }}" alt="">
                                                        @break
                                                    @case('pdf')
                                                        <img class="dmsIcon" src="{{ asset('/media/svg/files/pdf.svg') }}" alt="">
                                                        @break
                                                    @case('png') @case('jpg') @case('jpeg') @case('svg') @case('webp')
                                                        <img class="dmsIcon" src="{{ asset('/media/svg/files/337948.png') }}" alt="">
                                                        @break
                                                @endswitch
                                            </div>
                                        </a>
                                    </div>

                                    <div class="fs-5 fw-bold mb-2 text-center">{{ $attachment->file_name }}</div>
                                    <div class="fs-5 fw-bold mb-2 text-center">{{ $attachment->documentType->name ?? '' }}</div>
                                    <div class="fs-7 fw-semibold text-gray-400 text-center pb-2">
                                        {{ $attachment->fileSource->name ?? '' }}
                                    </div>
                                    <div class="fs-7 fw-semibold text-gray-400 text-center pb-4">
                                        {{ custom_date_format($attachment->created_at, 'd/m/Y | H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @elseif($invocationNotifications && $invocation_docs)
                    @foreach($invocationNotifications as $item)
                        <div class="col-md-6 col-lg-4 col-xl-2 pb-10">
                            <div class="card h-100">
                                <div class="ribbon ribbon-top ribbon-ver"></div>
                                <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4 ">
                                    <a href="{{ route('dms.show', [encryptId($principle->id), 'invocation_notification_id' => encryptId($item->id), 'contractor_id' => encryptId($contractor_id), 'dmsable_type' => encryptId('Cases'), 'type' => encryptId('review'), 'review_type' => encryptId('invocation_review_docs'), 'invocation_review_case_id' => encryptId($invocation_review_case_id)]) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                        <span class="svg-icon svg-icon-5x">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24">
                                                    </rect>
                                                    <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <div class="fs-5 fw-bold mb-2 text-center">{{ $item->code }}</div>
                                <div class="fs-7 fw-semibold text-gray-400 text-center pb-4 p-1"></div>
                            </div>
                        </div>
                    @endforeach
                @elseif($type === 'review')
                    <div class="col-md-6 col-lg-4 col-xl-2 pb-10">
                        <div class="card h-100">
                            <div class="ribbon ribbon-top ribbon-ver"></div>
                            <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4 ">
                                <a href="{{ route('dms.show', [encryptId($principle->id), 'contractor_id' => encryptId($principle->id), 'type' => encryptId('review'), 'review_type' => encryptId('contractor_review_docs'), 'dmsable_type' => encryptId('Cases'), 'review_case_id' => encryptId($review_case_id)]) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                    <span class="svg-icon svg-icon-5x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24">
                                                </rect>
                                                <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="fs-5 fw-bold mb-2 text-center">{{__('dms.contractor')}}</div>
                            <div class="fs-7 fw-semibold text-gray-400 text-center pb-4 p-1"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-2 pb-10">
                        <div class="card h-100">
                            <div class="ribbon ribbon-top ribbon-ver"></div>
                            <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4 ">
                                <a href="{{ route('dms.show', [encryptId($principle->id), 'type' => encryptId('review'), 'contractor_id' => encryptId($principle->id), 'invocation_docs' => encryptId(true)]) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                    <span class="svg-icon svg-icon-5x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24">
                                                </rect>
                                                <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="fs-5 fw-bold mb-2 text-center">{{__('dms.invocation_notification')}}</div>
                            <div class="fs-7 fw-semibold text-gray-400 text-center pb-4 p-1"></div>
                        </div>
                    </div>
                @endif

                {{-- @if ($invocationNotifications)
                    @foreach($invocationNotifications as $item)
                        <div class="col-md-6 col-lg-4 col-xl-2 pb-10">
                            <div class="card h-100">
                                <div class="ribbon ribbon-top ribbon-ver"></div>
                                <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4 ">
                                    <a href="{{ route('dms.show', [$principle->id, 'invocation_notification_id' => $item->id, 'contractor_id' => $contractor_id, 'dmsable_type' => 'InvocationNotification', 'type' => 'invocation_notification_view']) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                        <span class="svg-icon svg-icon-5x">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24">
                                                    </rect>
                                                    <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <div class="fs-5 fw-bold mb-2 text-center">{{ $item->code }}</div>
                                <div class="fs-7 fw-semibold text-gray-400 text-center pb-4 p-1"></div>
                            </div>
                        </div>
                    @endforeach
                @endif --}}
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>

@push('scripts')
    @include('dms.script')
@endpush
{{-- @include('dms.contractor.review.filter') --}}
@endsection
