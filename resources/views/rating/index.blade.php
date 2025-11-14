@extends($theme)

@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
    'back_text' => __('common.back'),
    'model_back_action' => route('masterPages'),
    'permission' => $current_user->hasAnyAccess(['rating.edit', 'users.superadmin']),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-toolbar">
                    <ul class="nav nav-light-success nav-bold nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#country">
                                <span class="nav-text">{{ __('rating.country') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#sectors">
                                <span class="nav-text">{{ __('rating.sectors') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#other_contractor_rating">
                                <span class="nav-text">{{ __('rating.other_contractor_information') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#uw_view">
                                <span class="nav-text">{{ __('rating.uw_view') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            {!! Form::open(['route' => 'rating.store', 'id' => 'rating']) !!}
            <div class="card-body pt-1">
                <div class="tab-content tab-validate">
                    <div class="tab-pane fade show active" id="country" role="tabpanel" aria-labelledby="country">
                        @include('rating.country_rating')
                    </div>

                    <div class="tab-pane fade" id="sectors" role="tabpanel" aria-labelledby="sectors">
                        @include('rating.sector_rating')
                    </div>

                    <div class="tab-pane fade" id="other_contractor_rating" role="tabpanel" aria-labelledby="other_contractor_rating">
                        @include('rating.other_contractor_rating')
                    </div>

                    <div class="tab-pane fade" id="uw_view" role="tabpanel" aria-labelledby="uw_view">
                        @include('rating.uv_view_rating')
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('common.save') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@include('rating.script')
