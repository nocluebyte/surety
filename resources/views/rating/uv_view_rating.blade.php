<div class="row">
    <div class="form-group col-lg-8">
        <div id="uwViewRepeater">
            <table style="width:100%" class="table table-separate table-head-custom table-checkable"
                data-repeater-list="uwViewDetail">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('rating.name') }}</th>
                        <th>{{ __('rating.financial') }}</th>
                        <th>{{ __('rating.non_financial') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($uwViewRating) && $uwViewRating->count())
                        @foreach ($uwViewRating as $key => $uwView)
                            @if ($uwView->slug != 'uwview-weightage')
                                <tr data-repeater-item="" class="uw_view_row">
                                    <td class="uwView-list-no">{{ ++$key-1 }}</td>
                                    <td> {!! Form::text('uw_view[name]', $uwView['name'] ?? '', [
                                        'class' => 'form-control required',
                                        'data-rule-AlphabetsV1' => true,
                                    ]) !!}
                                    </td>

                                    <td> {!! Form::number('uw_view[financial]', $uwView['financial'] ?? '', [
                                        'class' => 'form-control required',
                                        'data-rule-Numbers' => true,
                                        'max'=>99
                                    ]) !!}
                                    </td>

                                    <td>{!! Form::number('uw_view[non_financial]', $uwView['non_financial'] ?? '', [
                                        'class' => 'form-control required',
                                        'data-rule-Numbers' => true,
                                        'max'=>99
                                    ]) !!}
                                    </td>
                                    <td class="mb-3">
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="uw_view_row">
                            <td class="uwView-list-no">1 .</td>

                            <td> {!! Form::text('uw_view[name]', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) !!}
                            </td>

                            <td> {!! Form::number('uw_view[financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max'=>99
                            ]) !!}
                            </td>

                            <td>{!! Form::number('uw_view[non_financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max'=>99
                            ]) !!}
                            </td>
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
                        class="btn btn-sm font-weight-bolder btn-light-primary">
                        <i class="flaticon2-plus"></i>{{ __('common.add') }}</a>
                </div>
            </div>
        </div>

        <hr>
        <table class="table table-separate table-head-custom table-checkable">
            <tr>
                <td width="20"></td>
                <td width="200">{!! Form::label('uw_view_weightage', trans('rating.weightage'), ['class' => 'col-form-label text-right']) !!}</td>
                <td>
                    Total<br>
                    <input type="hidden" name="uwViewDetail[-1][name]" value="Uwview Weightage">

                    {!! Form::number('uwViewDetail[-1][financial]', $uw_weightage->financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'uwview_weightage',
                        'max' => 30,
                        'min' => 30,
                        'data-rule-Numbers' => true,
                    ]) !!}
                </td>
                <td>
                    Total<br>
                    {!! Form::number('uwViewDetail[-1][non_financial]', $uw_weightage->non_financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'uwview_weightage_non_financial',
                        'max' => 40,
                        'min' => 40,
                        'data-rule-Numbers' => true,
                    ]) !!}
                </td>
            </tr>
        </table>

    </div>
</div>
