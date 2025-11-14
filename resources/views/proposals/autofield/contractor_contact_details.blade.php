<div class="row">
    <div class="form-group col-12">
        <div id="contactDetailRepeater">
            <table class="table table-separate table-head-custom table-checkable contactDetailSector" id="machine"
                data-repeater-list="contactDetail">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.contact_person') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.phone_no') }}</th>
                        {{-- <th width="20"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (isset($contact_detail) && count($contact_detail) > 0)
                        @foreach ($contact_detail as $index => $item)
                            <tr data-repeater-item="" class="contact_detail_row">
                                <td class="contact-list-no">{{ ++$index }} . </td>
                                <td>
                                    {!! Form::hidden("contactDetail[{$index}][contact_item_id]", $item->id ?? '', ['class' => 'contactDetailId contact_item_id']) !!}
                                    {!! Form::hidden("contactDetail[{$index}][proposal_contact_item_id]", $item->id ?? '') !!}
                                    {!! Form::hidden("contactDetail[{$index}][autoFetch]", 'autoFetch') !!}
                                    {!! Form::text("contactDetail[{$index}][contact_person]", $item->contact_person, [
                                        'class' => 'form-control jsClearContractorType',
                                        'data-rule-AlphabetsV1' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::email("contactDetail[{$index}][email]", $item->email, ['class' => 'form-control jsClearContractorType email']) !!}
                                </td>
                                <td>
                                    {!! Form::text("contactDetail[{$index}][phone_no]", $item->phone_no, [
                                        'class' => 'form-control jsClearContractorType number',
                                        'data-rule-MobileNo' => true,
                                    ]) !!}
                                </td>
                                {{-- <td>
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2 contact_detail_delete">
                                        <i class="flaticon-delete"></i></a>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div id="load-modal"></div>
    </div>
</div>