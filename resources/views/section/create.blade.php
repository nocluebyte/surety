{!! Form::open(array('route' => 'section.store','role'=>"form",'id'=>'sectionForm')) !!}

   @include('section.form',[
    	'section' => null
    ])

{!! Form::close() !!}

