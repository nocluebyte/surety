<div class="row">
    <div class="form-group col-lg-10">
        <div id="dateOfEstRepeater">
            <table style="width:100%" class="table table-separate table-head-custom table-checkable"
                data-repeater-list="dateEst">
                <thead>
                    <tr>
                        <th style="width: 3%"></th>
                        <th style="width: 12%">{{ __('rating.name') }}</th>
                        <th></th>
                        <th></th>
                        <th>{{ __('rating.financial') }}</th>
                        <th>{{ __('rating.non_financial') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($oci_date_of_est) && $oci_date_of_est->count())
                        @foreach ($oci_date_of_est as $key => $ociEst)
                            <tr data-repeater-item="" class="oci_date_est_row">
                                <td class="est-list-no">{{ ++$key }}</td>
                                <td class="pt-6 dateOfEst">
                                    {{ __('rating.date_of_est') }}
                                </td>
                                <td> {!! Form::number('ociEst[from]', $ociEst['from'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td> {!! Form::number('ociEst[to]', $ociEst['to'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td> {!! Form::number('ociEst[financial]', $ociEst['financial'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td> {!! Form::number('ociEst[non_financial]', $ociEst['non_financial'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td class="mb-3">
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2">
                                        <i class="flaticon-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="oci_date_est_row">
                            <td class="est-list-no pt-6">1 .</td>
                            <td class="pt-6 dateOfEst">{{ __('rating.date_of_est') }}</td>
                            <td> {!! Form::number('ociEst[from]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td> {!! Form::number('ociEst[to]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td> {!! Form::number('ociEst[financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td>{!! Form::number('ociEst[non_financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td class="mb-3">
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create=""
                        class="btn btn-sm font-weight-bolder btn-light-primary"><i
                            class="flaticon2-plus"></i>{{ __('common.add') }}</a>
                </div>
            </div>
        </div>
        <hr>
        <div id="ociEmployeeRepeater">
            <table style="width:100%" class="table table-separate table-head-custom table-checkable"
                data-repeater-list="ociEmployeeDetail">
                <thead>
                    <tr>
                        <th style="width: 3%"></th>
                        <th style="width: 12%">{{ __('rating.name') }}</th>
                        <th></th>
                        <th></th>
                        <th>{{ __('rating.financial') }}</th>
                        <th>{{ __('rating.non_financial') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($oci_employee) && $oci_employee->count())
                        @foreach ($oci_employee as $key => $employee)
                            <tr data-repeater-item="" class="oci_employee_row">
                                <td class="employee-list-no">{{ ++$key }}</td>
                                <td class="pt-6 ociEmployee">{{ __('rating.employee') }}
                                </td>
                                <td> {!! Form::number('employee[from]', $employee['from'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                ]) !!}</td>
                                <td> {!! Form::number('employee[to]', $employee['to'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                ]) !!}</td>
                                <td> {!! Form::number('employee[financial]', $employee['financial'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td> {!! Form::number('employee[non_financial]', $employee['non_financial'], [
                                    'class' => 'form-control required',
                                    'data-rule-Numbers' => true,
                                    'max' => 99,
                                ]) !!}</td>
                                <td class="mb-3">
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2">
                                        <i class="flaticon-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="oci_employee_row">
                            <td class="employee-list-no pt-6">1 .</td>
                            <td class="pt-6 ociEmployee">{{ __('rating.employee') }}</td>
                            <td> {!! Form::number('employee[from]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                            ]) !!}</td>
                            <td> {!! Form::number('employee[to]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                            ]) !!}</td>
                            <td> {!! Form::number('employee[financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td> {!! Form::number('employee[non_financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max' => 99,
                            ]) !!}</td>
                            <td class="mb-3">
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endisset
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create=""
                        class="btn btn-sm font-weight-bolder btn-light-primary"><i
                            class="flaticon2-plus"></i>{{ __('common.add') }}</a>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="col-10">
        <table class="table table-separate table-head-custom table-checkable">
            <tr>
                <td width="20"></td>

                <td width="200"> {!! Form::label('oci_weightage', trans('rating.weightage'), ['class' => 'col-form-label text-right']) !!}</td>
                <td width="100">&nbsp;</td>
                <td width="100">&nbsp;</td>

                <td>
                    Total<br>
                    {!! Form::number('oci_weightage[financial]', $oci_weightage['financial'] ?? null, [
                        'class' => 'form-control required',
                        'id' => 'oci_weightage_fi',
                        'data-rule-Numbers' => true,
                        'max' => 20,
                        'min' => 20,
                    ]) !!}
                </td>
                <td>
                    Total<br>
                    {!! Form::number('oci_weightage[non_financial]', $oci_weightage['non_financial'] ?? null, [
                        'class' => 'form-control required',
                        'id' => 'oci_weightage_non',
                        'data-rule-Numbers' => true,
                        'max' => 20,
                        'min' => 20,
                    ]) !!}
                </td>
            </tr>
        </table>
    </div>
</div>
