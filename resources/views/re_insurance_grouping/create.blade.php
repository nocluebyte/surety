{!! Form::open(array('route' => 're-insurance-grouping.store','role'=>"form",'id'=>'reInsurancForm')) !!}

   @include('re_insurance_grouping.form',[
    	're_insurance_grouping' => null
    ])

{!! Form::close() !!}
