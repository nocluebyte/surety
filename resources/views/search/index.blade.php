{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('search.search'),
        'permission' => $current_user->hasAnyAccess(['search.add', 'users.superadmin']),
    ])
@endcomponent
   
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        <div class="card card-custom gutter-b">
            
            <div class="card-body">
                {!! Form::open(array('route' => 'search.index','class'=>'form-horizontal','id' => 'searchForm','method'=>'get')) !!}
                        
                    <div class="row">
                       
                        <div class="form-group col-lg-4">
                            {!! Form::label('search',trans("search.search"))!!}
                            {!! Form::text('txt_search',  $txtSearch ?? '', ['class' => 'form-control cls-search required','id'=> 'txt_search', 'placeholder' => 'Search','style' => 'width: 100%']) !!}
                            {{-- <h4 class="mt-3 text-muted">Click Search Button For Search</h4> --}}

                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-primary mr-2 btn_search mt-8" id="btn_search">{{__('search.search')}}</button>
                            <a href="{{ route('search.index')}}" class="btn btn-danger btn_reset mt-8">{{__('common.cancel')}}</a>
                            {{-- <button type="button" class="btn btn-danger btn_reset mt-8" id="btn_clear">{{__('common.cancel')}}</button> --}}
                        </div>
                    </div>

                    @if (isset($result))
                    {{-- @dd($result) --}}
                        <nav class="menu" style="margin-left: -50px;">
                            <ul class="mobile-menu font-heading">
                                @foreach ($result as $searchedData)                      
                                    <ul class="dropdown">
                                        <li class="menu-item-has-children" style="margin-bottom: 8px;">
                                            <a href="{{ $searchedData['url'] ?? '-' }}" class="font-weight-bold">{{ $searchedData['title'] ?? '-' }} ({{ $searchedData['module'] ?? '' }}) </a><br>
                                            @if($searchedData['description'])
                                                <p class="text-dark ml-5">
                                                    Description :
                                                    {{ $searchedData['description'] ?? '-' }}
                                                </p>
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            </ul>
                        </nav>
                    @endif   

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div id="load-modal"></div>

@include('info')
@endsection

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .select2-container {
        width: 100%!important;
    }
</style>
@endsection

@section('scripts')
@include('search.script')
@endsection