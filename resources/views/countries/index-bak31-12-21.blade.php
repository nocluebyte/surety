{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')

@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('common.country'),
        'modal_id' => '#addCountry',
        'text' => __('common.add'),
     ])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <table class="table table-separate table-head-custom table-checkable" id="country">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{__('common.country')}}</th>
                        </tr>
                        <tr>
                            <th>{{__('common.action')}}</th>
                            <th>{{__('common.country')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <div class="dropdown dropdown-inline" title="" data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                                <span class="navi-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-trash-alt"></i>
                                                </span>
                                                <span class="navi-text">Delete</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="modal" data-target="#AddModelInfo">
                                                <span class="navi-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="navi-text">info</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </td>
                            <td>Brazil</td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="dropdown dropdown-inline" title="" data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                                <span class="navi-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-trash-alt"></i>
                                                </span>
                                                <span class="navi-text">Delete</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="modal" data-target="#AddModelInfo">
                                                <span class="navi-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="navi-text">info</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </td>
                            <td>India</td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="dropdown dropdown-inline" title="" data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                                <span class="navi-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-trash-alt"></i>
                                                </span>
                                                <span class="navi-text">Delete</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="modal" data-target="#AddModelInfo">
                                                <span class="navi-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="navi-text">info</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </td>
                            <td>Australia</td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="dropdown dropdown-inline" title="" data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                                <span class="navi-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="far fa-trash-alt"></i>
                                                </span>
                                                <span class="navi-text">Delete</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="modal" data-target="#AddModelInfo">
                                                <span class="navi-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="navi-text">info</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </td>
                            <td>Newzeland</td>
                        </tr>
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>  
    </div>
</div>

<div class="modal fade" id="addCountry" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('country.add_country')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>{{__('common.country')}} :<i class="text-danger">*</i></label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary font-weight-bold">{{__('common.save')}}</button>
            </div>
        </div>
    </div>
</div>
@include('info')
@endsection

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/crud/datatables/country.js') }}" type="text/javascript"></script>
@endsection