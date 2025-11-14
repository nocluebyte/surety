<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card" id="default">

                <div class="card-body">
                    @php
                        if (!isset($group->id)) {
                            $disabled = 'disabled';
                        } else {
                            $disabled = '';
                        }

                    @endphp
                    {{-- @dd($group->contractor_id) --}}
                    <div class="row g-3">
                        <div class="form-group col-md-4">
                            {{ Form::label('contractor_id', __('group.group_name')) }}<i class="text-danger">*</i>
                            {!! Form::select('contractor_id', ['' => 'Select'] + $contractors, null, [
                                'class' => 'form-control required cls-group-contractor contractor_id jscontractorName',
                                'id' => 'contractor_id',
                                'data-placeholder' => 'Select Group',
                                isset($group) && $group->count() > 0 ? 'disabled' : '',
                            ]) !!}
                        </div>
                    </div><br>
                    <div class="row g-3">
                        <div class="form-group col-md-6">
                            {{ Form::label('contractor', __('group.contractor')) }}<i class="text-danger">*</i>
                            {!! Form::select('contractor', ['' => 'Select'] + $contractors, null, [
                                'class' => 'form-control jscontractor contractor jscontractorNameGroup',
                                'data-placeholder' => 'Select',
                                'id' => 'contractor',
                                $disabled,
                            ]) !!}
                        </div>

                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary group_add {{ $disabled }}" type="button">Add</button>
                        </div>
                    </div><br><br>
                    <table class="table table-separate table-head-custom table-checkable" id="TableBuilder">
                        <tr>
                            <th>{{ __('group.contractor_name') }}</th>
                            <th>{{ __('group.country') }}</th>
                            <th>{{ __('group.type') }}<i class="text-danger">*</i></th>
                            <th>{{ __('group.last_updated_by') }}</th>
                            <th>{{ __('group.from') }}<i class="text-danger">*</i></th>
                            <th>{{ __('group.till') }}</th>
                            <th style="width: 6px;" class="text-center">{{ __('common.action') }}</th>
                        </tr>
                        @if (isset($group->id) && $group->count() > 0)
                            @foreach ($groupcontractor as $item)
                                {{-- @dd($item) --}}
                                <tr class="groupRow">
                                    <td>{{ $item->contractor->company_name }}</td>
                                    <td>{{ $item->contractor->country->name }}</td>
                                    <td>{!! Form::select(
                                        'contractorids[' . $item->contractor_id . '][type]',
                                        ['' => 'Select'] + $type,
                                        $item->type ?? '',
                                        ['class' => 'form-control type', 'required', 'data-placeholder' => 'Select'],
                                    ) !!}
                                    </td>

                                    <td>{{ $item->updatedBy->first_name ?? '' }}</td>

                                    <td>{{ Form::date('contractorids[' . $item->contractor_id . '][from_date]', $item->from_date ?? null, ['class' => 'form-control from_date', 'required', 'date' => true]) }}
                                    </td>

                                    <td>
                                        {{ Form::date('contractorids[' . $item->contractor_id . '][till_date]', $item->till_date ?? null, ['class' => 'form-control till_date minDate', 'date' => true]) }}
                                    </td>
                                    <td style="width: 7px;" class="text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-danger mr-2 jsDeleteGroup"
                                            value="Delete" data-contractorId="{{ $item->contractor_id }}">
                                            <i class="flaticon-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- <tbody class="data-row">
                            @if (isset($contractor))
                                @include('group.group_row',$contractor)
                            @endif
                        </tbody> --}}
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-right ">
                            {!! link_to(URL::full(), __('common.reset'), ['class' => 'btn btn-light mr-3']) !!}
                            {!! Form::submit(__('common.save'), [
                                'name' => 'saveBtn',
                                'class' => 'btn btn-primary disaRemoveSave',
                                $disabled,
                            ]) !!}
                            <button type="submit" class="btn btn-primary disaRemoveSaveExit"
                                {{ $disabled }}>{{ __('common.save_exit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @include('group.script')
@endsection
