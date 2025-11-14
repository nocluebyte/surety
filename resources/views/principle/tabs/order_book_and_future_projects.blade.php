<div id="orderBookAndFutureProjectsRepeater">
    @if (isset($order_book_and_future_projects))
        <div class="repeaterRow obfp_repeater_row" data-repeater-list="obfp_items">
            @foreach ($order_book_and_future_projects as $item)
                <div class="row mb-5 obfp_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden('obfp_id', $item->id ?? '', ['class' => 'jsObfpId']) !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.project_name'), __('principle.project_name')) !!}
                        {!! Form::text('project_name', $item->project_name ?? null, [
                            'class' => 'form-control',
                            'name' => 'project_name',
                            'data-rule-AlphabetsAndNumbersV8' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.project_cost'), __('principle.project_cost')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('project_cost', $item->project_cost ?? null, [
                            'class' => 'form-control number',
                            'name' => 'project_cost',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('principle.project_description'), __('principle.project_description')) !!}
                        {!! Form::textarea('project_description', $item->project_description ?? null, [
                            'class' => 'form-control',
                            'name' => 'project_description',
                            'rows' => 2,
                            'data-rule-Remarks' => true,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_start_date'), __('principle.project_start_date')) !!}
                        {!! Form::date('project_start_date', $item->project_start_date ?? null, ['class' => 'form-control obfp_project_start_date jsObfpPeriod', 'min' => '1000-01-01', 'max' => '9999-12-31',]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_end_date'), __('principle.project_end_date')) !!}
                        {!! Form::date('project_end_date', $item->project_end_date ?? null, ['class' => 'form-control obfp_project_end_date jsObfpPeriod',
                        //  'min' => '1000-01-01', 'max' => '9999-12-31',
                         ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_tenor'), __('principle.project_tenor')) !!}
                        {!! Form::text('project_tenor', $item->project_tenor ?? null, [
                            'class' => 'form-control number jsObfpProjectTenor form-control-solid',
                            'name' => 'project_tenor',
                            'data-rule-Numbers' => true,
                            'readonly',
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('principle.bank_guarantees_details'), __('principle.bank_guarantees_details')) !!}
                        {!! Form::textarea('bank_guarantees_details', $item->bank_guarantees_details ?? null, [
                            'class' => 'form-control',
                            'name' => 'bank_guarantees_details',
                            'rows' => 2,
                            'data-rule-AlphabetsAndNumbersV3' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.project_share'), __('principle.project_share')) !!}
                        {!! Form::text('project_share', $item->project_share ?? null, [
                            'class' => 'form-control',
                            'name' => 'project_share',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.guarantee_amount'), __('principle.guarantee_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('guarantee_amount', $item->guarantee_amount ?? null, [
                            'class' => 'form-control number',
                            'name' => 'guarantee_amount',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.current_status'), __('principle.current_status')) !!}
                        {!! Form::select('current_status', ['' => 'Select Current Status'] + $current_status, $item->current_status ?? null, [
                            'class' => 'form-control current_status_dropdown jsSelect2ClearAllow',
                            'data-placeholder' => 'Select Current Status',
                            'style' => 'width: 100%;',
                            'name' => 'current_status',
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(
                            __('principle.order_book_and_future_projects_attachment'),
                            __('principle.order_book_and_future_projects_attachment'),
                        ) !!}
                        {!! Form::file('order_book_and_future_projects_attachment', [
                            'id' => 'order_book_and_future_projects_attachment',
                            'class' => 'order_book_and_future_projects_attachment',
                            'multiple',
                        ]) !!}
                        <div class="fileNamesContainer mt-2"></div>
                        <hr>
                        @if (isset($item->id))
                            @foreach ($item->dMS as $attachment)
                                @if ($attachment->file_name)
                                    <div class="dms_data" data-id="{{ $attachment->id }}">
                                        <input type="hidden" class="dms_data_id">
                                        {{ $attachment->file_name }}&nbsp;
                                        <i class="fa fa-trash-alt" style="font-size:10px;color:red"></i>
                                    </div>
                                @endif
                            @endforeach
                        @endif --}}

                        <div class="d-block">
                            {!! Form::label(
                                __('proposals.order_book_and_future_projects_attachment'),
                                __('proposals.order_book_and_future_projects_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file('order_book_and_future_projects_attachment', [
                                'class' => 'order_book_and_future_projects_attachment jsDocument',
                                'id' => 'order_book_and_future_projects_attachment',
                                // empty($dms_data) ? '' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_order_book_and_future_projects_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                                $dsbtcls = $data_order_book_and_future_projects_attachment == 0 ? 'disabled' : '';
                            @endphp
                            {{-- <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-toggle="modal"
                                data-target-modal="#commonModalID"
                                data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'order_book_and_future_projects_attachment', 'dmsable_type' => 'OrderBookAndFutureProjects']) }}"
                                class="call-modal JsOrderBookAndFutureProjectsAttachment navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="order_book_and_future_projects_attachment"
                                data-delete="jsOrderBookAndFutureProjectsAttachmentDeleted">
                                <span class="navi-icon"><span class="length_order_book_and_future_projects_attachment"
                                        data-order_book_and_future_projects_attachment ='{{ $data_order_book_and_future_projects_attachment }}'>{{ $data_order_book_and_future_projects_attachment }}</span>&nbsp;Document</span>
                            </a> --}}
                            {{-- @dd($item) --}}
                            <a href="#" data-toggle="modal" data-repeater-row="obfp_row" data-target="#obfp_attachment_{{ $item->id }}"
                                class="call-modal jsRepeaterShowDocument navi-link {{ $dsbtcls }}" data-delete="jsOrderBookAndFutureProjectsAttachmentDeleted" data-prefix="order_book_and_future_projects_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_order_book_and_future_projects_attachment" data-count_order_book_and_future_projects_attachment = "{{ $data_order_book_and_future_projects_attachment }}">{{ $data_order_book_and_future_projects_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="obfp_attachment_{{ $item->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Principle/Contractor Documents</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body jsDocumentDiv">
                                            <a class="jsFileRemove"></a>
                                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                                @foreach ($item->dMS as $documents)
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    {!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp; {{ $documents->file_name ?? '' }}
                                                                    <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>
                                                                <td>&nbsp;
                                                                    <a type="button" class="dms_order_book_and_future_projects_attachment_{{ $documents->id }}">
                                                                        <i class="flaticon2-cross small remove_repeater_attachment" data-repeater-row="obfp_row" data-prefix="order_book_and_future_projects_attachment" data-url="{{ route('removeDmsAttachment') }}"
                                                                        data-id="{{ $documents->id }}">
                                                                        </i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endforeach
                                                {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                                        target="_blanck">
                                                                                        {{ $dms_data->file_name }}
                                                                                    </a> --}}
                                            @else
                                                {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-5 delete_obfp_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>

                <input type="hidden" name="delete_obfp_id" value="" class="jsDeleteObfpId">
            @endforeach
        </div>
    @else
        <div class="repeaterRow obfp_repeater_row" data-repeater-list="obfp_items">
            <div class="row mb-5 obfp_row" data-row-index="1" data-repeater-item="" style="border-bottom: 1px solid grey;">
                <input type="hidden" name="obfp_id" class="jsObfpId">

                <div class="col-6 form-group">
                    {!! Form::label(__('principle.project_name'), __('principle.project_name')) !!}
                    {!! Form::text('project_name', null, [
                        'class' => 'form-control',
                        'name' => 'project_name',
                        'data-rule-AlphabetsAndNumbersV8' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('principle.project_cost'), __('principle.project_cost')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('project_cost', null, [
                        'class' => 'form-control number',
                        'name' => 'project_cost',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-12 form-group">
                    {!! Form::label(__('principle.project_description'), __('principle.project_description')) !!}
                    {!! Form::textarea('project_description', null, [
                        'class' => 'form-control',
                        'name' => 'project_description',
                        'rows' => 2,
                        'data-rule-Remarks' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('principle.project_start_date'), __('principle.project_start_date')) !!}
                    {!! Form::date('project_start_date', null, ['class' => 'form-control jsObfpPeriod obfp_project_start_date', 'min' => '1000-01-01', 'max' => '9999-12-31',]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('principle.project_end_date'), __('principle.project_end_date')) !!}
                    {!! Form::date('project_end_date', null, ['class' => 'form-control jsObfpPeriod obfp_project_end_date', 
                    // 'min' => '1000-01-01', 'max' => '9999-12-31',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('principle.project_tenor'), __('principle.project_tenor')) !!}
                    {!! Form::text('project_tenor', null, [
                        'class' => 'form-control number jsObfpProjectTenor form-control-solid',
                        'name' => 'project_tenor',
                        'data-rule-Numbers' => true,
                        'readonly',
                    ]) !!}
                </div>

                <div class="col-12 form-group">
                    {!! Form::label(__('principle.bank_guarantees_details'), __('principle.bank_guarantees_details')) !!}
                    {!! Form::textarea('bank_guarantees_details', null, [
                        'class' => 'form-control',
                        'name' => 'bank_guarantees_details',
                        'rows' => 2,
                        'data-rule-AlphabetsAndNumbersV3' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('principle.project_share'), __('principle.project_share')) !!}
                    {!! Form::text('project_share', null, [
                        'class' => 'form-control',
                        'name' => 'project_share',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('principle.guarantee_amount'), __('principle.guarantee_amount')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('guarantee_amount', null, [
                        'class' => 'form-control number',
                        'name' => 'guarantee_amount',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('principle.current_status'), __('principle.current_status')) !!}
                    {!! Form::select('current_status', ['' => 'Select Current Status'] + $current_status, null, [
                        'class' => 'form-control current_status_dropdown jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Current Status',
                        'style' => 'width: 100%;',
                        'name' => 'current_status',
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {{-- {!! Form::label(
                        __('principle.order_book_and_future_projects_attachment'),
                        __('principle.order_book_and_future_projects_attachment'),
                    ) !!}
                    {!! Form::file('order_book_and_future_projects_attachment', [
                        'id' => 'order_book_and_future_projects_attachment',
                        'class' => 'order_book_and_future_projects_attachment',
                        'multiple',
                    ]) !!}
                    <div class="fileNamesContainer" class="mt-2"></div> --}}

                    <div class="d-block">
                        {!! Form::label(
                            __('proposals.order_book_and_future_projects_attachment'),
                            __('proposals.order_book_and_future_projects_attachment'),
                        ) !!}
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('order_book_and_future_projects_attachment', [
                            'class' => 'order_book_and_future_projects_attachment jsDocument',
                            'id' => 'order_book_and_future_projects_attachment',
                            // empty($dms_data) ? '' : '',
                            'multiple',
                            'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}
                        @php
                            $data_order_book_and_future_projects_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                            $dsbtcls = $data_order_book_and_future_projects_attachment == 0 ? 'disabled' : '';
                        @endphp
                        {{-- <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'order_book_and_future_projects_attachment', 'dmsable_type' => 'OrderBookAndFutureProjects']) }}"
                            class="call-modal JsOrderBookAndFutureProjectsAttachment navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="order_book_and_future_projects_attachment"
                            data-delete="jsOrderBookAndFutureProjectsAttachmentDeleted">
                            <span class="navi-icon"><span class="length_order_book_and_future_projects_attachment"
                                    data-order_book_and_future_projects_attachment ='{{ $data_order_book_and_future_projects_attachment }}'>{{ $data_order_book_and_future_projects_attachment }}</span>&nbsp;Document</span>
                        </a> --}}

                        <a href="#" data-toggle="modal" data-repeater-row="obfp_row" data-target="#obfp_attachment"
                            class="call-modal jsRepeaterShowDocument navi-link {{ $dsbtcls }}" data-delete="jsOrderBookAndFutureProjectsAttachmentDeleted" data-prefix="order_book_and_future_projects_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                            <span class = "count_order_book_and_future_projects_attachment" data-count_order_book_and_future_projects_attachment = "0"></span>
                        </a>

                        <div class="modal fade" tabindex="-1" id="obfp_attachment">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Principle/Contractor Documents</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <a class="jsFileRemove"></a>
                                        @if (isset($item->dMS) && count($item->dMS) > 0)
                                            @foreach ($item->dMS as $documents)
                                                <div class="mb-3">
                                                    <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? asset($documents->attachment) : asset('/default.jpg') }}"
                                                        target="_blanck">
                                                        {!! getdmsFileIcon(e($documents->file_name)) !!}
                                                    </a>
                                                    {{ $documents->file_name ?? '' }}
                                                </div>
                                            @endforeach
                                            {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                                    target="_blanck">
                                                                                    {{ $dms_data->file_name }}
                                                                                </a> --}}
                                        @else
                                            {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-5 delete_obfp_item" style="text-align: end;">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>

            <input type="hidden" name="delete_obfp_id" value="" class="jsDeleteObfpId">
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAddOrderBookAndFutureProjects">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div>