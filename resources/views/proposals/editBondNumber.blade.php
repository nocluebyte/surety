<div class="modal fade" id="bondNumberModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @include('components.error')
            {!! Form::open([
                'route' => 'updateBondNumber',
                'id' => 'updateBondNumberForm',
                'enctype' => 'multipart/form-data',
            ]) !!}
            {!! Form::hidden('bond_issue_id', $bond_policy_issue->id ?? '') !!}
            {!! Form::hidden('proposal_id', $bond_policy_issue->proposal_id ?? '') !!}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ !isset($bond_policy_issue->bond_number) ? __('bond_policies_issue.add_bond_number') : __('bond_policies_issue.edit_bond_number') }}</h5>
                {!! Form::button('<i aria-hidden="true" class="ki ki-close"></i>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('bond_number', __('bond_policies_issue.bond_number')) !!}
                    {!! Form::text('bond_number', $bond_policy_issue->bond_number ?? null, [
                        'class' => 'form-control',
                        'data-rule-Remarks' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'bond_number',
                            'model' => 'bond_policies_issue',
                            'id' => $bond_policy_issue['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'The Bond Number has already been taken.',
                    ]) !!}
                </div>

                <div class="form-group">
                    <div class="d-block">
                        {!! Form::label('bond_stamp_paper', __('bond_policies_issue.bond_stamp_paper')) !!}
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('bond_stamp_paper[]', [
                            'class' => 'bond_stamp_paper jsDocument',
                            'multiple',
                            'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}
                        @php
                            $data_bond_stamp_paper = isset($bond_policy_issue_dms['bond_stamp_paper'])
                                ? count($bond_policy_issue_dms['bond_stamp_paper'])
                                : 0;
                            $dsbtcls = $data_bond_stamp_paper == 0 ? 'disabled' : '';
                        @endphp

                        <a href="#" data-toggle="modal" data-target="#bond_stamp_paper_modal"
                            class="call-modal JsBondStampPaper jsShowDocument navi-link {{ $dsbtcls }}"
                            data-delete="jsBondStampPaperDeleted" data-prefix="bond_stamp_paper"><i class="fa fa-file"
                                aria-hidden="true"></i>&nbsp;
                            <span class = "count_bond_stamp_paper"
                                data-count_bond_stamp_paper = "{{ $data_bond_stamp_paper }}">{{ $data_bond_stamp_paper }}&nbsp;document</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit('Save', ['class' => 'btn btn-primary jsBtnLoader']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="bond_stamp_paper_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bond Stamp Paper</h5>
                {!! Form::button('<i aria-hidden="true" class="ki ki-close"></i>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <a class="jsFileRemove"></a>
                    @if (isset($bond_policy_issue_dms) && isset($bond_policy_issue_dms['bond_stamp_paper']) && count($bond_policy_issue_dms['bond_stamp_paper']) > 0)
                        @foreach ($bond_policy_issue_dms['bond_stamp_paper'] as $documents)
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            {!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;
                                            {{ $documents->file_name ?? '' }}
                                            <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}" target="_blank"
                                                download><i class="fa fa-download text-black m-5"
                                                    aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td>&nbsp;
                                            <a type="button">
                                                <i class="flaticon2-cross small dms_attachment_remove" data-prefix=""
                                                    data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('proposals.editBondNumberScript')
@endpush