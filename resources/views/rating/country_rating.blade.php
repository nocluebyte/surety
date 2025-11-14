<div class="row">
    <div class="form-group col-lg-8">
        <div id="countryRatingsRepeater">
            <table style="width:100%" class="table table-separate table-head-custom table-checkable"
                data-repeater-list="countryRatings">
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
                    @if (!empty($countryRating) && $countryRating->count())
                        @foreach ($countryRating as $key => $country)
                            @if ($country->slug != 'country-weightage')
                                <tr data-repeater-item="" class="country_rating_detail_row">
                                    <td class="country-list-no">{{ ++$key-1 }}</td>
                                    <td> {!! Form::text('country[name]', $country['name'], [
                                        'class' => 'form-control required',
                                        'data-rule-AlphabetsV1' => true,
                                    ]) !!}
                                    </td>

                                    <td> {!! Form::number('country[financial]', $country['financial'], [
                                        'class' => 'form-control required',
                                        'data-rule-Numbers' => true,
                                        'max'=>99
                                    ]) !!}
                                    </td>

                                    <td> {!! Form::number('country[non_financial]', $country['non_financial'], [
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
                        <tr data-repeater-item="" class="country_rating_detail_row">
                            <td class="country-list-no">1 .</td>

                            <td> {!! Form::text('country[name]', null, [
                                'class' => 'form-control required',
                                'data-rule-AlphabetsV1' => true,
                            ]) !!}
                            </td>

                            <td> {!! Form::number('country[financial]', null, [
                                'class' => 'form-control required',
                                'data-rule-Numbers' => true,
                                'max'=>99
                            ]) !!}
                            </td>

                            <td> {!! Form::number('country[non_financial]', null, [
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
                <td width="200">{!! Form::label('country_weightage', trans('rating.weightage'), ['class' => 'col-form-label pt-7 text-right']) !!}</td>
                <td>
                    Total<br>
                    <input type="hidden" name="countryRatings[-1][name]" value="Country Weightage">
                    {!! Form::number('countryRatings[-1][financial]', $country_weightage->financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'country_weightage',
                        'data-rule-Numbers' => true,
                        'max' => 15,
                        'min' => 15,
                    ]) !!}
                </td>
                <td>
                    Total<br>
                    {!! Form::number('countryRatings[-1][non_financial]', $country_weightage->non_financial ?? null, [
                        'class' => 'form-control required',
                        'id' => 'country_weightage_non_financial',
                        'data-rule-Numbers' => true,
                        'max' => 20,
                        'min' => 20,
                    ]) !!}
                </td>
            </tr>
        </table>
    </div>
</div>
