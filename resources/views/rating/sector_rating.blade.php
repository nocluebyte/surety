<div class="row">
    <div class="form-group col-lg-8">
        <div id="sectorsRatingsRepeater">
            <table style="width:100%"
                class="table table-separate table-head-custom table-checkable"
                data-repeater-list="sectorRatings">
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
                    @if (!empty($sectorsRating) && $sectorsRating->count())
                        @foreach ($sectorsRating as $key => $sectors)
                            @if ($sectors->slug != 'sectors-weightage')
                                <tr data-repeater-item="" class="sector_rating_detail_row">
                                    <td class="sector-list-no">{{ ++$key-1 }}</td>
                                    <td> {!! Form::text('sectors[name]', $sectors['name'] ?? null, [
                                        'class' => 'form-control required',
                                        'data-rule-AlphabetsV1' => true,
                                    ]) !!}
                                    </td>

                                    <td> {!! Form::number('sectors[financial]', $sectors['financial'] ?? null, [
                                        'class' => 'form-control required',
                                        'data-rule-Numbers' => true,
                                        'max'=>99
                                    ]) !!}
                                    </td>

                                    <td> {!! Form::number('sectors[non_financial]', $sectors['non_financial'] ?? null, [
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
                        <tr data-repeater-item="" class="sector_rating_detail_row">
                            <td class="sector-list-no">1 .</td>

                            <td> {!! Form::text('sectors[name]', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) !!}
                            </td>

                            <td> {!! Form::number('sectors[financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max'=>99
                            ]) !!}
                            </td>

                            <td>{!! Form::number('sectors[non_financial]', null, [
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
                        class="btn btn-sm font-weight-bolder btn-light-primary"><i
                            class="flaticon2-plus"></i>{{ __('common.add') }}</a>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="col-8">
        <table class="table table-separate table-head-custom table-checkable">
            <tr>
                <td width="20"></td>
                <td width="200">{!! Form::label('sectors_weightage', trans('rating.weightage'), ['class' => 'col-form-label text-right']) !!}</td>
                <td>
                    Total<br>
                    <input type="hidden" name="sectorRatings[-1][name]"
                        value="Sectors Weightage">

                    {!! Form::number('sectorRatings[-1][financial]', $sectors_weightage->financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'sectors_weightage',
                        'data-rule-Numbers' => true,
                        'max' => 10,
                        'min' => 10
                    ]) !!}
                </td>
                <td>
                    Total<br>
                    {!! Form::number('sectorRatings[-1][non_financial]', $sectors_weightage->non_financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'sectors_weightage_non_financial',
                        'data-rule-Numbers' => true,
                        'max' => 20,
                        'min' => 20,
                    ]) !!}
                </td>
            </tr>
        </table>
    </div>
</div>