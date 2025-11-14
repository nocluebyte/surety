<div class="modal fade" tabindex="-1" id="intermendiary-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">IndemnityLetter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="font-size: 30px;">&times;</i>
                </button>
            </div>
            {!!Form::open(['route' => 'sendIntermediaryLatterForSign','method' => 'POST','enctype' => 'multipart/form-data','id'=>'IntermediaryLatterForSignForm'])!!}
            <div class="modal-body">
                <div class="row">
                    {!!Form::hidden('proposal_id',$proposals->id)!!}
                    <div class="col form-group">
                        {!! Form::label('indemnity_letter', trans('proposals.indemnity_letter')) !!}
                        <div class="radio-inline pt-4">
                            <label class="radio radio-rounded">
                                {{ Form::radio('indemnity_letter_type', 'Manually', '', ['class' => 'form-check-input indemnityLetterType']) }}
                                <span></span>{{ __('proposals.manually') }}
                            </label>
                            <label class="radio radio-rounded">
                                {{ Form::radio('indemnity_letter_type', 'Leegality', '', ['class' => 'form-check-input indemnityLetterType',$proposals->IndemnityLetterThroughLeegality ? 'disabled' : '']) }}
                                <span></span><image type="image" width="80em" src="{{asset('media/svg/logos/leegality.svg')}}" alt="">
                            </label>
                           
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col indemnityLetterManualSection d-none">
                        {!!Form::file('indemnity_letter_document', ['class' => 'indemnityLetterDocument form-control'])!!}
                    </div>
                    <div class="col form-group indemnityLetterLeegalitySection d-none">
                        {!! Form::label('indemnity_letter_sign_through', trans('proposals.indemnity_letter_sign_through')) !!}
                        <div class="radio-inline pt-4">
                            <label class="radio radio-rounded">
                                {{ Form::radio('indemnity_signing_through', 'Phone', '', ['class' => 'form-check-input indemnitySigningThrough',$proposals->IndemnityLetterThroughLeegality ? 'disabled' : '']) }}
                                <span></span><i class="fas fa-mobile-alt fa-2x"></i>
                            </label>
                            <label class="radio radio-rounded">
                                {{ Form::radio('indemnity_signing_through', 'Email', '', ['class' => 'form-check-input indemnitySigningThrough',$proposals->IndemnityLetterThroughLeegality ? 'disabled' : '']) }}
                                <span></span><i class="fas fa-envelope fa-2x"></i>
                            </label>
                            <label class="radio radio-rounded">
                                {{ Form::radio('indemnity_signing_through', 'Aadhar', '', ['class' => 'form-check-input indemnitySigningThrough',$proposals->IndemnityLetterThroughLeegality ? 'disabled' : '']) }}
                                <span></span><image type="image" width="45em" src="{{asset('media/svg/logos/aadhar.webp')}}" alt="">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">{{__('common.close')}}</button>
                <button type="submit" class="btn btn-primary font-weight-bold jsBtnLoader"
                    id="btn_loader">{{__('common.save')}}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>