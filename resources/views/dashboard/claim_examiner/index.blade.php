{{-- Extends layout --}}
@extends($theme)
@section('title', $title)
{{-- Content --}}
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
               
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
