{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('title', $title)

@section('content')
@component('partials._subheader.subheader-v6',
[
'page_title' => __('advance.advance'),
'back_action'=> route('advance.index'),
'text' => __('common.back'),
'permission' => true,
]),
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
            <div class="card">
                <div class="card-header" id="faqHeading1">
                    <div class="d-flex justify-content-between flex-column flex-md-row col-lg-12">
                        <a class="card-title text-dark collapsed" data-toggle="collapse" href="#faq1"
                            aria-expanded="false" aria-controls="faq1" role="button">
                            <h3 class="font-weight-bolder pt-5">
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
                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)">
                                            </path>
                                        </g>
                                    </svg>
                                </span>&nbsp;
                                {{ $advance->employeeData->first_name .' '. $advance->employeeData->last_name ?? 'N/A' }}
                            </h3>
                        </a>

                        <span class="svg-icon pt-4" style="float:right;">

                            @if ($current_user->hasAnyAccess(['advance.edit', 'users.superadmin']) && ($advance->status == 'Pending' && $advance->amount == $advance->due_amount))
                                <a href="{{route('advance.edit',$advance->id)}}" data-toggle="modal" data-target-modal="#commonModalID" data-url="{{route('advance.edit',$advance->id)}}" class="call-modal btn btn-light-primary btn-sm font-weight-bold">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                    Edit
                                    </a>
                            @endif
                             @if ($current_user->hasAnyAccess(['advance.delete', 'users.superadmin']) && ($advance->status == 'Pending' && $advance->amount == $advance->due_amount)) 
                                <a href="{{route('advance.destroy',$advance->id)}}" data-redirect="{{route('advance.index')}}" class="btn btn-light-danger btn-sm font-weight-bold delete-confrim">
                                <i class="fas fa-trash-alt fa-1x"></i>
                                Delete
                                </a>
                            @endif
                            @if ($current_user->hasAnyAccess(['users.info', 'users.superadmin'])) 
                                <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info" data-toggle="modal" data-target="#AddModelInfo"
                                data-table="{{$table_name}}" data-id="{{$advance->id}}" data-url="{{route('get-info')}}">
                                    <span class="navi-icon">
                                        <i class="fas fa-info-circle fa-1x"></i>
                                    </span>
                                    <span class="navi-text">Info</span>
                                </a>
                            @endif
                        </span>
                    </div>
                </div>
                <div id="faq1" class="collapse" aria-labelledby="faqHeading1" data-parent="#faq">
                    <div class="card-body pl-10 pt-5 pb-2">
                        <div class="row">
                            <div class="col-lg-2">
                                <table>
                                    <tr>
                                        <th>
                                            <div class="font-weight-bold my-2" style=" color : #9d9595;"></div>
                                        </th>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-10">
                               <table style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th width="20%">
                                                <div class="font-weight-bold text-dark-50">Date</div>
                                            </th>
                                            <th width="20%">
                                                <div class="font-weight-bold text-dark-50">Amount</div>
                                            </th>
                                            
                                            <th width="20%">
                                                <div class="font-weight-bold text-dark-50">{{__('common.status')}}</div>
                                            </th>
                                            <th width="30%">
                                                <div class="font-weight-bold text-dark-50">Comment</div>
                                            </th>
                                            <th width="10%">
                                                <div class="font-weight-bold text-dark-50"></div>
                                            </th>
                                            
                                        </tr>
                                        <tr>
                                            <th>
                                                <div class="font-weight-bolder">{{date('d-m-Y', strtotime($advance->date))}}</div>
                                            </th>
                                            <th>
                                                <div class="font-weight-bolder"><span class="fas fa-rupee-sign"></span> {{format_amount($advance->amount)}}</div>
                                            </th>
                                            <th>
                                                @if($advance->status == 'Pending')
                                                    <span class="label label-lg label-light-warning font-weight-bolder label-inline">{{$advance->status}}</span>
                                                @elseif($advance->status == 'Approved')
                                                    <span class="label label-lg label-light-success font-weight-bolder label-inline">{{$advance->status}}</span>
                                                @else
                                                    <span class="label label-lg label-light-danger font-weight-bolder label-inline">{{$advance->status}}</span>
                                                @endif
                                            </th>
                                            <th>
                                                <div class="font-weight-bolder">
                                                {{ $advance->comment ?? 'N/A' }}
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title font-weight-bolder text-dark">
                            <ul class="nav nav-light-success nav-bold nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#Overview">
                                        <span class="nav-text">Statement</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pt-1">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                                aria-labelledby="Overview">
                                @include('advance.payment')

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>
@include('info')
@endsection
