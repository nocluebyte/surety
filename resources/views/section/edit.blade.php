{!! Form::model($section, ['route' => ['section.update', $section->id],'id' => 'sectionForm']) !!}
@method('PUT')
{!! Form::hidden ('id', $section->id ,['id' => 'id' ])!!}

   	@include('section.form',[
    	'section' => $section
    ])

{!! Form::close() !!}
