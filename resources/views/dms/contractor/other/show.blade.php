@extends($theme)
@section('content')
@section('title', $page_title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $page_title ? $page_title : __('dms.document'),
    'back_action' => route('dms.show', encryptId($contractor_id)),
    'target' => '#commonModalID',
    'add_modal' => collect([
        'action' => route('dms.create', ['type' => encryptId($type), 'case_id' => encryptId($case_id), 'contractor_id' => encryptId($contractor_id)]),
        'target' => '#commonModalID',
        'text' => __('common.add'),
    ]),
    'text' => __('common.back'),
    // 'filter_modal_id' => '#dmsFilter',
    'permission' => $current_user->hasAnyAccess('users.superadmin', 'dms.add'),
])
@endcomponent
@php
$user = Sentinel::getUser();
$underWriter = $user->roles->first();
$slug = $underWriter->slug ?? '';
@endphp
<div class="container-fluid">
    @include('components.error')
    <div class="row">
        <div class="col-sm-12">
            <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                @if ($isfilter && $dms->isNotEmpty())

                    @foreach ($dms->groupBy('dmsable_id') as $docs)
                        <div class="col-12 my-5">
                            <h5><strong>{{ __('dms.other') }}</strong></h5>
                        </div>
                        @foreach ($docs as $attachment)
                            @php
                                $fileext = pathinfo(storage_path($attachment->attachment), PATHINFO_EXTENSION);
                                $allowedAccess = $user->hasAnyAccess(['users.superadmin']);
                                // $isVisible = $allowedAccess || in_array($slug, ['underwriter', 'contractor-principle']);
                                $isVisible = $user->hasAnyAccess('users.superadmin', 'dms.view');
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
                                    {{-- @dd($attachment->attachment) --}}
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
                @endif
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
