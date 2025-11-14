@extends($theme)
@section('content')
@section('title', $page_title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $page_title ? $page_title : __('dms.document'),
    'back_action' => route('dms.show', encryptId($contractor_id)),
    'text' => __('common.back'),
    // 'filter_modal_id' => '#dmsFilter',
    'permission' => true,
])
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
                {{-- @if($type == 'application') --}}
                    @foreach($invocationNotifications as $item)
                        {{-- @dd($item) --}}
                        <div class="col-md-6 col-lg-4 col-xl-2 pb-10">
                            <div class="card h-100">
                                <div class="ribbon ribbon-top ribbon-ver"></div>
                                <div class="card-body d-flex justify-content-center text-center flex-column pb-2 pl-1 pr-1 pt-4 ">
                                    <a href="{{ route('dms.show', [encryptId($principle->id), 'invocation_notification_id' => encryptId($item->id), 'contractor_id' => encryptId($contractor_id), 'dmsable_type' => encryptId('InvocationNotification'), 'type' => encryptId('invocation_notification_view')]) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
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
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>

@push('scripts')
    @include('dms.script')
@endpush
{{-- @include('dms.contractor.application.filter') --}}
@endsection
