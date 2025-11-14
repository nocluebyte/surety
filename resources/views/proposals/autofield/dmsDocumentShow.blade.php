<div class="modal fade" id="commonModalID" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <div class="modal-body jsDocumentDiv">

                <a class="jsFileRemove"></a>

                {{-- @dd($attachment_type) --}}
                {{-- <a class="jsAutoFetch">
                    @foreach ($dmsData as $key => $item)
                        @if ($key)
                            @foreach ($item as $document)
                                <span>{{ $document->file_name }}</span>
                            @endforeach
                        @endif
                    @endforeach
                </a> --}}

                @if (isset($dms) && $dms->count() > 0)
                    @foreach ($dms as $key => $view)
                        <table>
                            <tbody>
                                <tr>
                                    <td style="padding: 0%;">{!! getdmsFileIcon(e($view->file_name)) !!}&nbsp;{{ $view->file_name ?? '' }} <a href="{{ isset($view->attachment) && !empty($view->attachment) ? route('secure-file', encryptId($view->attachment)) : asset('/default.jpg') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                        </a></td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @endif

            </div>

        </div>
    </div>
</div>


{{-- @extends('app-modal')

@section('modal-content')
    <div class="form-group">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>

        <div class="modal-body jsDocumentDiv">

            <a class="jsFileRemove"></a>

            @if (isset($dms) && $dms->count() > 0)
                @foreach ($dms as $key => $view)
                    <table>
                        <tbody>
                            <tr>
                                <td> <a href="{{ asset($view->attachment ?? '') }}" target="_blank">
                                        {{ $view->file_name ?? '' }}</a></td>
                                <td>&nbsp;<a type="button"><i class="flaticon2-cross small dms_attachment_remove"
                                            data-prefix=""
                                            data-url="{{ route('removeDmsAttachment') }}"
                                            data-id="{{ $view->id }}"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @endif

        </div>
    </div>

@endsection --}}
