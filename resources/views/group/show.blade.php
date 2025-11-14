{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', __('group.group'))


@component('partials._subheader.subheader-v6', [
    'page_title' => __('group.group'),
    'back_action' => url('group'),
    'text' => __('common.back'),
])
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card" id="default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('contractor_no', trans('Parent Contractor Name')) !!} :
                                {{ $group->contractor->code ?? '' }} | {{ $group->contractor->company_name ?? '' }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group text-right">
                                {!! Form::label('group_cap', __('group.group_cap')) !!} :
                                {{ isset($group->casesLimitStrategy) ? numberFormatPrecision($group->casesLimitStrategy->proposed_group_cap, 0) : 0 }}
                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th>{{ __('group.contractor_name') }}</th>
                                <th>{{ __('group.type') }}</th>
                                <th>{{ __('common.country') }}</th> </th>
                                <th class="text-right">{{ __('group.pending_application_limit') }}</th>
                                <th class="text-right">{{ __('group.total_approved_limit') }}</th>
                                <th class="text-right">{{ __('group.individual_cap') }}</th>
                                <th class="text-right">{{ __('group.overall_cap') }}</th>
                                <th>{{ __('group.regular_review_date') }}</th>
                                <th>{{ __('group.from') }} </th>
                                <th>{{ __('group.till') }}</th>
                                <th>{{ __('group.created_by') }}</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if (isset($group_approved_limit) && $group_approved_limit->count() > 0)
                                @foreach ($group_approved_limit as $item)
                                    <tr>
                                        <td>{{ $item->company_name ?? '-' }}</td>
                                        <td>{{ $item->type ?? '-' }}</td>
                                        <td>{{ $item->country ?? '-' }}</td>
                                        <td class="text-right">{{ numberFormatPrecision($item->pending_application_limit, 0) ?? 0 }}</td>
                                        <td class="text-right">{{ numberFormatPrecision($item->total_approved_limit, 0) ?? 0 }}</td>
                                        <td class="text-right">{{ numberFormatPrecision($item->proposed_individual_cap, 0) ?? 0 }}</td>
                                        <td class="text-right">{{ numberFormatPrecision($item->proposed_overall_cap, 0) ?? 0 }}</td>
                                        <td>{{ isset($item->reguler_review_date) ? custom_date_format($item->reguler_review_date, 'd/m/Y') : '-' }}</td>
                                        <td>{{ isset($item->from_date) ? custom_date_format($item->from_date,'d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ isset($item->till_date) ? custom_date_format($item->till_date,'d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $item->created_by ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong> : </td>
                                    <td class="text-right">{{ numberFormatPrecision($group_approved_limit->pluck('pending_application_limit')->sum(), 0) ?? '' }}</td>
                                    <td class="text-right">{{ numberFormatPrecision($group_approved_limit->pluck('total_approved_limit')->sum(), 0) ?? '' }}</td>
                                    <td class="text-right">{{ numberFormatPrecision($group_approved_limit->pluck('proposed_individual_cap')->sum(), 0) ?? '' }}</td>
                                    <td class="text-right">{{ numberFormatPrecision($group_approved_limit->pluck('proposed_overall_cap')->sum(), 0) ?? '' }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center" colspan="10">{{ __('group.no_data_available') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@include('group.script')
