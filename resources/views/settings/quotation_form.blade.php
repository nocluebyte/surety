{!! Form::open( ['route' => 'settings.store' ,'id' => 'settingForm']) !!}

{{Form::hidden('group','quotation',['class' => 'form-control']);}}

<!--begin::Accordion-->

    <div class="row">
        <div class="form-group">
            {{Form::label('quotation_note', __('settings.note'))}}
            {{Form::textarea('quotation_note', $settings['quotation_note'] ?? '', ['class' => 'form-control', 'rows' => 5, 'id' => 'quotation_note']);}}
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-right">
            <a href="" class="mr-2">{{__('common.cancel')}}</a>
            <button type="submit" class="btn btn-primary">{{__('common.save')}}</button>
        </div>
    </div>


{!! Form::close() !!}

@push('scripts')
<script>
    ClassicEditor
            .create( document.querySelector( '#quotation_note' ) )
            .then( editor => {
                    // console.log( editor );
            } )
            .catch( error => {
                    // console.error( error );
            } );
</script>
@endpush