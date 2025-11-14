<div class="modal fade" id="report_modal" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            {!!Form::open(['route'=>$action,'method'=>$method ?? 'POST' ])!!}
                @foreach($filters as $name => $value)
                    {{ Form::hidden($name, $value) }}
                @endforeach
                <div class="card-body pr-0">
                    @include('reports.common.fieldlist',[
                        'fields'=>$fields,
                        'checked_fields'=>$checked_fields])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">{{__('common.close')}}</button>
                    <button type="submit" class="btn btn-primary mr-2">{{ __('common.generate') }}</button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>

@push('scripts')
    @include($script)
@endpush
