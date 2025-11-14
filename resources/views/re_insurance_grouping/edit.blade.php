{{-- {!! Form::model($re_insurance_grouping, ['route' => ['re-insurance-grouping.update', encryptId($re_insurance_grouping->id)], 'id' => 'reInsurancForm']) !!}
    @method('PUT')
    {!! Form::hidden('id',$re_insurance_grouping->id, ['id' => 'id']) !!}
    @include('re_insurance_grouping.form',[
        're_insurance_grouping' => $re_insurance_grouping
    ])
{!! Form::close() !!} --}}


{!! Form::model($re_insurance_grouping, [
    'route' => ['re-insurance-grouping.update', encryptId($re_insurance_grouping->id)],
    'id' => 'reInsurancForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $re_insurance_grouping->id, ['id' => 'id']) !!}
@include('re_insurance_grouping.form', [
    're_insurance_grouping' => $re_insurance_grouping,
])
{!! Form::close() !!}