<div class="row">
    <div class="card-body py-0">
        <div class="example example-basic">
            <div class="example-preview">
                <div class="timeline timeline-6 mt-3">
                    @if (isset($principle->analysis) && $principle->analysis->count() > 0)
                        @foreach ($principle->analysis as $arow)
                            @php
                                $first_name = $arow->createdBy->first_name ?? '';
                                $last_name = $arow->createdBy->last_name ?? '';
                            @endphp
                            <div class="timeline-item align-items-start">
                                <div>
                                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">
                                        {{ $first_name }} {{ $last_name }}
                                    </div>
                                    <div class="font-weight-bold text-dark-50 font-size-xs timeline-content">
                                        {{ custom_date_format($arow->created_at, 'd/m/Y : H:i') }}
                                    </div>
                                </div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning icon-xl"></i>
                                </div>
                                <div>
                                    <div class="font-weight-bolder font-size-lg timeline-content pl-3 text-dark-75">
                                        {!! $arow->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="text-center">
                            {{__('common.no_record_found')}}
                        </h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>