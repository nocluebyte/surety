{!! Form::model($banking_limit_categories, [
    'route' => ['banking_limit_categories.update', encryptId($banking_limit_categories->id)],
    'id' => 'bankingLimitCategoriesForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $banking_limit_categories->id, ['id' => 'id']) !!}
@include('banking_limit_categories.form', [
    'banking_limit_categories' => $banking_limit_categories,
])
{!! Form::close() !!}
