<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>{{ __('adverse_information.source_of_adverse_information') }}</th>
            <th>{{ __('common.date') }}</th>
            <th>{{ __('adverse_information.adverse_information') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($adverse_information as $key => $data)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $data->source_of_adverse_information ?? '' }}</td>
                <td>{{ date('d/m/Y | H:i', strtotime($data->created_at)) }}</td>
                <td>
                    <div class="d-inline-block text-truncate" style="max-width: 200px;">
                        <p>{!! $data->adverse_information ?? '' !!}</p>
                        @if(Str::of($data->adverse_information)->length() > 30)
                            <a href="#" data-toggle="modal" data-target="#adverseInformation_{{ $key }}" class="call-modal navi-link">...Read More</a>
                        @endif
                    </div>

                    <div class="modal fade" tabindex="-1" id="adverseInformation_{{ $key }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('adverse_information.adverse_information') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    {!! $data->adverse_information ?? '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="6">{{ __('common.no_records_found') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

