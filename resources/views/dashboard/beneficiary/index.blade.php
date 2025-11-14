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
                        @if($current_user->hasAnyAccess(['users.superadmin', 'project-details.list']))
                            <a href="{{ route('project-details.index') }}" target="_blank">
                                <div class="card-body p-4">
                                    <span
                                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">{{ $totalProjects ?? '0' }}</span>
                                    <span class="font-weight-bold text-dark-50 font-size-lg">Total Projects</span>
                                </div>
                            </a>
                        @else
                            <div class="card-body p-4">
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">{{ $totalProjects ?? '0' }}</span>
                                <span class="font-weight-bold text-dark-50 font-size-lg">Total Projects</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        @if($current_user->hasAnyAccess(['users.superadmin', 'tender.list']))
                            <a href="{{ route('tender.index') }}" target="_blank">
                                <div class="card-body p-4">
                                    <span
                                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">{{ $totalTenders ?? '0' }}</span>
                                    <span class="font-weight-bold text-dark-50 font-size-lg">Total Tenders</span>
                                </div>
                            </a>
                        @else
                            <div class="card-body p-4">
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">{{ $totalTenders ?? '0' }}</span>
                                <span class="font-weight-bold text-dark-50 font-size-lg">Total Tenders</span>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        @if($current_user->hasAnyAccess(['users.superadmin', 'bond_policies_issue.list']))
                            <a href="{{ route('bond_policies_issue.index') }}" target="_blank">
                                <div class="card-body p-4">
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                        {{$bond_count}}
                                    </span>
                                    <span class="font-weight-bold text-dark-50 font-size-lg">Total Bonds</span>
                                </div>
                            </a>
                        @else
                            <div class="card-body p-4">
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                    {{$bond_count}}
                                </span>
                                <span class="font-weight-bold text-dark-50 font-size-lg">Total Bonds</span>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                            <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                {{$amended_bonds_count ?? 0}}
                            </span>
                            <span class="font-weight-bold text-dark-50 font-size-lg">Amended Bonds</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                            <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">
                                {{$expiring_bonds ?? 0}}
                            </span>
                            <span class="font-weight-bold text-dark-50 font-size-lg">Expiring Bonds</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body p-4">
                            <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 d-block">{{ $expired_bonds ?? 0 }}
                            </span>
                            <span class="font-weight-bold text-dark-50 font-size-lg">Expired Bonds</span>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Tenders</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        {{-- @dd($header_year) --}}
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="tenderCountBarChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Invoked Amount</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="invokedAmountChart"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-3">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start ">
                                <span class="card-label font-weight-bolder text-dark">Bond Type</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="BondTypePieChart"></div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                        <div class="card card-custom card-shadowless gutter-b">
                            <div class="card-header border-0 d-flex align-items-center">
                                <h3 class="card-title align-items-start">
                                    <span class="card-label font-weight-bolder text-dark">Approved Application Amount and Issued Bond Amount</span>
                                </h3>
                                @php
                                    $default_year = Session::get('default_year');
                                @endphp
                                <div class="d-flex align-items-center py-3">
                                    <div class="dropdown dropdown-inline" title="" data-placement="left">
                                        <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                            {{ $default_year->yearname ?? '' }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                            <ul class="navi navi-hover py-5">
                                                @if (isset($header_year) && $header_year->count() > 0)
                                                    @foreach ($header_year as $y)
                                                        @if ($y->is_displayed == 'Yes')
                                                            <li class="navi-item">
                                                                <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                    class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                    <span class="font-weight-bolder text-dark-50 pr-3">
                                                                        FY
                                                                    </span>
                                                                    <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 pr-5 pl-5">
                                <div id="decisionAndIssuedAmountChart"></div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-3">
                        <div class="card card-custom card-shadowless gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start ">
                                    <span class="card-label font-weight-bolder text-dark">NBIs</span>
                                </h3>
                            </div>
                            <div class="card-body pt-0 pr-5 pl-5">
                                <div id="SectorWiseNbiChart"></div>

                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-9"> --}}
                        {{-- <div class="card card-custom card-shadowless gutter-b"> --}}
                            {{-- <div class="card-header border-0 d-flex align-items-center">
                                <h3 class="card-title align-items-start">
                                    <span class="card-label font-weight-bolder text-dark">Bond Issue</span>
                                </h3>
                                @php
                                    $default_year = Session::get('default_year');
                                @endphp
                                <div class="d-flex align-items-center py-3">
                                    <div class="dropdown dropdown-inline" title="" data-placement="left">
                                        <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                            {{ $default_year->yearname ?? '' }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                            <ul class="navi navi-hover py-5">
                                                @if (isset($header_year) && $header_year->count() > 0)
                                                    @foreach ($header_year as $y)
                                                        @if ($y->is_displayed == 'Yes')
                                                            <li class="navi-item">
                                                                <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                    class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                    <span class="font-weight-bolder text-dark-50 pr-3">
                                                                        FY
                                                                    </span>
                                                                    <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="card-body pt-0 pr-5 pl-5"> --}}
                                {{-- <div id="BondTypeChart"></div> --}}
                                {{-- <div id="bondCountBarChart"></div> --}}
                            {{-- </div> --}}
                        {{-- </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
            </div>

            {{-- <div class="row">
                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Bond Amount</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="bondAmountBarChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Total Premium</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="totalPremiumBarChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Bond Count</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="bondCountBarChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-custom card-shadowless gutter-b">
                        <div class="card-header border-0 d-flex align-items-center">
                            <h3 class="card-title align-items-start">
                                <span class="card-label font-weight-bolder text-dark">Risk Exposure</span>
                            </h3>
                            @php
                                $default_year = Session::get('default_year');
                            @endphp
                            <div class="d-flex align-items-center py-3">
                                <div class="dropdown dropdown-inline" title="" data-placement="left">
                                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                                        {{ $default_year->yearname ?? '' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                                        <ul class="navi navi-hover py-5">
                                            @if (isset($header_year) && $header_year->count() > 0)
                                                @foreach ($header_year as $y)
                                                    @if ($y->is_displayed == 'Yes')
                                                        <li class="navi-item">
                                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                                    FY
                                                                </span>
                                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pr-5 pl-5">
                            <div id="riskExposureBarChart"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

    @section('scripts')
        <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/dashboard_chart.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pages/features/charts/apexcharts.js') }}"></script>
        {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script> --}}

        <script>
            $(function() {
                const apexChart = "#decisionAndIssuedAmountChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: "Decision Amount",
                            data: [{{ implode(',', $decision_amount_month_wise) }}]
                        },
                        {
                            name: "Issued Amount",
                            data: [{{ implode(',', $issued_amount_month_wise) }}]
                        },
                        {
                            name: "Invoked Amount",
                            data: [{{ implode(',', $invoked_amount_month_wise) }}]
                        },
                        {
                            name: "Cancelled Amount",
                            data: [{{ implode(',', $cancelled_amount_month_wise) }}]
                        },
                        {
                            name: "ForeClosed Amount",
                            data: [{{ implode(',', $foreclosed_amount_month_wise) }}]
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight',
                        width: 3,
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            });

             $(function() {
                 const apexChart = "#BondTypePieChart";

                 var options = {
                     series: [<?= implode(',', $bondIssuedCount ?? []) ?>],
                     chart: {
                         width: '100%',
                         type: 'donut',
                         stacked: false,
                     },
                     plotOptions: {
                         pie: {
                             size: 200
                         }
                     },
                     labels: [<?= "'" . implode("', '", array_keys($bondIssuedCount ?? [])) . "'" ?>],
                     legend: {
                         show: false
                     },
                     dataLabels: {
                         enabled: false,
                     },
                     responsive: [{
                         breakpoint: 480,
                         options: {
                             chart: {
                                 width: 200
                             },
                             legend: {
                                 position: 'bottom'
                             }
                         }
                     }],
                     noData: {
                         text: 'NO DATA FOUND',
                         align: 'center',
                         verticalAlign: 'middle',
                         offsetX: 0,
                         offsetY: 0,
                         style: {
                             color: undefined,
                             fontSize: '14px',
                             fontFamily: undefined
                         }
                     },
                     colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                         '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                         '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                         '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                         '#2983FF', '#00B1F2', '	#D7263D'
                     ]
                 };

                 var chart = new ApexCharts(document.querySelector(apexChart), options);
                 chart.render();
             });

            $(function() {
                const bondCountBarChart = "#bondCountBarChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: 'No. of Bonds',
                            data: @json($bond_issued_month_wise ?? []),
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(bondCountBarChart), options);
                chart.render();
            });

            $(function() {
                const bondAmountBarChart = "#bondAmountBarChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: 'Bond Amount',
                            data: @json($bond_amount_month_wise ?? []),
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(bondAmountBarChart), options);
                chart.render();
            });

            $(function() {
                const totalPremiumBarChart = "#totalPremiumBarChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: 'Total Premium',
                            data: @json($total_premium_month_wise ?? []),
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(totalPremiumBarChart), options);
                chart.render();
            });

            $(function() {
                const riskExposureBarChart = "#riskExposureBarChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: 'Risk Exposure',
                            data: @json($risk_exposure_month_wise ?? []),
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(riskExposureBarChart), options);
                chart.render();
            });

            $(function() {
                const tenderCountBarChart = "#tenderCountBarChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: 'No. of Tenders',
                            data: @json($month_wise_tenders ?? []),
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(tenderCountBarChart), options);
                chart.render();
            });

            $(function() {
                const apexChart = "#invokedAmountChart";
                var options = {
                    title:{
                        text: "{{$default_year->year ?? ''}}",
                        align: 'center',
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: true
                    },
                    series: [
                        {
                            name: "Invoked Amount",
                            data: [{{ implode(',', $invoked_amount_month_wise) }}]
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar:false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight',
                        width: 3,
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },

                    xaxis: {
                        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec','Jan', 'Feb', 'Mar'],
                    },
                    yaxis: [
                    {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(0);
                            }
                        }
                    },
                    ],
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#03A9F4', '#4CAF50',
                        '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A', '#D4526E', '#13D8AA', '#A5978B', '#4ECDC4',
                        '#C7F464', '#81D4FA', '#FD6A6A', '#662E9B', '#F86624', '#F9C80E', '#EA3546', '#43BCCD',
                        '#5C4742', '#A5978B', '#8D5B4C', '#5A2A27', '#C4BBAF', '#A300D6', '#7D02EB', '#5653FE',
                        '#2983FF', '#00B1F2', '	#D7263D'
                    ]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            });
        </script>
    @endsection