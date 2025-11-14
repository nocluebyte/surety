@if(isset($stand_alone_adverse_information) && count($stand_alone_adverse_information) > 0)
    {{ Form::label('adverse_information', __('proposals.adverse_information'), ['class' => 'text-danger']) }} 
    <ol class="adverse_information_ids">
        @foreach($stand_alone_adverse_information as $item)
            @if($item)
                <li>
                    <a href="#" data-toggle="modal" data-target="#adverseInformation_{{ $item->id }}" class="call-modal navi-link">{{ $item->code }}</a>
                </li>
            @endif

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformation_{{ $item->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('adverse_information.adverse_information') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('common.code') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {{ $item->code ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('adverse_information.attachment') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        <a href="#" data-toggle="modal"
                                        data-target="#adverseInformationDocuments_{{ $item->id }}"
                                        class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('adverse_information.adverse_information') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {!! $item->adverse_information ?? '' !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformationDocuments_{{ $item->id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adverse Information Documents</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                @foreach ($item->dMS as $docs)
                                    <div class="mb-3">
                                        <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                            target="_blanck">
                                            {!! getdmsFileIcon(e($docs->file_name)) !!}
                                        </a>
                                        {{ $docs->file_name ?? '' }}
                                    </div>
                                @endforeach
                            @else
                                <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </ol>
@endif