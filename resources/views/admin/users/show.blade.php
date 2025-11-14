{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}

@section('content')
@section('title', __('users.title'))
@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('users.title'),
        'back_action' => route('users.index'),
        'text' => __('common.back'),
        'permission' => true,
    ])
    ,
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                @if ($users->emp_id == '')
                                    <h4><span style="float:left;">{{ $users->first_name ?? '' }}
                                            {{ $users->last_name ?? '' }}</span></h4>
                                @else
                                    <h4><span style="float:left;"><a
                                                href="{{ route('employee.show', [encryptId($users->emp_id)]) }}">{{ $users->first_name ?? '' }}
                                                {{ $users->last_name ?? '' }}</a></span></h4>
                                @endif
                                <br>
                                {{ ucfirst($users->emp_type ?? '') }}
                            </div>
                            <div class="col-lg-6">
                                <div class="card-toolbar">
                                    <span class="svg-icon" style="float:right;">

                                        <a href="{{ route('users.edit', encryptId($users->id)) }}"
                                            class="btn btn-light-primary btn-sm font-weight-bold">
                                            <i class="fas fa-pencil-alt fa-1x"></i>
                                            Edit
                                        </a>

                                        <a href=""
                                            class="btn btn-light-success btn-sm font-weight-bold show-info"
                                            data-toggle="modal" data-target="#AddModelInfo"
                                            data-table="{{ $table_name }}" data-id="{{ $users->id }}"
                                            data-url="{{ route('get-info') }}">
                                            <span class="navi-icon">
                                                <i class="fas fa-info-circle fa-1x"></i>
                                            </span>
                                            <span class="navi-text">Info</span>
                                        </a>

                                        <a href="{{ route('user.auto-login', $users->id) }}"
                                            class="btn btn-light-dark btn-sm font-weight-bold">
                                            <i class="fa fa-sign-in-alt fa-1x"></i>
                                            Login
                                        </a>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body pt-1">
                        <table class="mt-5" style="width: 100%">
                            <tbody>
                                <tr>
                                    {{-- <th width="33%">
                                        <div class="col-lg-4 pl-0">
                                            <div class="font-weight-bold text-dark-50">User Type</div>
                                        </div>
                                    </th> --}}
                                    <th width="33%">
                                        <div class="col-lg-4 pl-0">
                                            <div class="font-weight-bold text-dark-50">Full Name</div>
                                        </div>
                                    </th>
                                    <th width="33%">
                                        <div class="col-lg-5 pl-0">
                                            <div class="font-weight-bold text-dark-50">Email</div>
                                        </div>
                                    </th>
                                    <th width="33%">
                                        <div class="col-lg-3 pl-0">
                                            <div class="font-weight-bold text-dark-50">Role</div>
                                        </div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>
                                        <div class="font-weight-bolder h6">{{ $users->first_name.' '.$users->middle_name.' '.$users->last_name }}</div>
                                    </th>
                                    <th>
                                        <div class="">
                                            <div class="font-weight-bolder h6">{{ $users->email ?? '' }}</div>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <div class="font-weight-bolder h6">{{ $users->rolesData->name ?? '' }}
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <th width="33%">
                                        <div class="col-lg-4 pl-0">
                                            <div class="font-weight-bold text-dark-50">Location</div>
                                        </div>
                                    </th>
                                    <th width="33%">
                                        <div class="col-lg-5 pl-0">
                                            <div class="font-weight-bold text-dark-50">Mobile</div>
                                        </div>
                                    </th>
                                    <th width="33%">
                                        <div class="col-lg-4 pl-0">
                                            <div class="font-weight-bold text-dark-50">Allow Multi Login</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="font-weight-bolder h6">{{ $users->locationData->name ?? '' }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder h6">{{ $users->mobile ?? '' }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder h6">{{ ($users->allow_multi_login == 1) ? 'Yes' : 'No' }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <th width="33%">
                                        <div class="col-lg-3 pl-0">
                                            <div class="font-weight-bold text-dark-50">IP Address.</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="font-weight-bolder h6">{{ $users->ip ?? '' }}</div>
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


@include('info')

@endsection
