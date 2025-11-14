{{-- Extends layout --}}
@extends($theme)
@section('title', $title)
{{-- Content --}}
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                             @if($current_user->hasAnyAccess(['users.superadmin', 'proposals.list']))
                                 <a href="{{route('proposals.index')}}">
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$bond_count ?? 0}}
                                    </span>
                                </a>
                              @else
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$bond_count ?? 0}}
                                    </span>    
                              @endif
                            <span class="font-weight-bold text-dark-50 font-size-lg">Bonds</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                            @if($current_user->hasAnyAccess(['users.superadmin', 'principle.list']))
                                 <a href="{{route('principle.index')}}">
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$contractor_count ?? 0}}
                                    </span>
                                </a>
                            @else
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$contractor_count ?? 0}}
                                </span>    
                            @endif
                            <span class="font-weight-bold text-dark-50 font-size-lg">Contractor</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                                @if($current_user->hasAnyAccess(['users.superadmin', 'cases.list']))
                                    <a href="{{route('cases.index')}}">
                                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                            {{$cases_application_count ?? 0}}
                                        </span>
                                    </a>
                                @else
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                            {{$cases_application_count ?? 0}}
                                    </span>    
                                @endif
                            <span class="font-weight-bold text-dark-50 font-size-lg">Application</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                            @if($current_user->hasAnyAccess(['users.superadmin', 'cases.list']))
                                <a href="{{route('cases.index')}}">
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$cases_review_count ?? 0}}
                                    </span>
                                </a>
                            @else
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                    {{$cases_review_count ?? 0}}
                                </span>
                            @endif
                            <span class="font-weight-bold text-dark-50 font-size-lg">Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Today's Application</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>{{__('cases.contractor_name')}}</th>
                                        <th>{{__('cases.beneficiary_name')}}</th>
                                        <th class="text-right">{{__('cases.bond_value')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($todays_application as $item)
                                        <tr>
                                            <td>{{$item->contractor->company_name ?? ''}}</td>
                                            <td>{{$item->beneficiary->company_name ?? ''}}</td>
                                             <td>{{$item->contractor->company_name ?? ''}}</td>
                                            <td class="text-right">{{ numberFormatPrecision($item->bond_value,0)}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3">{{__('common.no_record_found')}}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                  <div class="col">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Today's Reviews</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{__('cases.contractor_name')}}</th>
                                        <th>{{__('cases.beneficiary_name')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @forelse ($todays_review as $item)
                                        <tr>
                                            <td>{{$item->contractor->company_name ?? ''}}</td>
                                            <td>{{$item->beneficiary->company_name ?? ''}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3">{{__('common.no_record_found')}}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dashboard_chart.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/features/charts/apexcharts.js') }}"></script>
@endsection
