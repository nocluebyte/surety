<table class="table table-separate table-head-custom table-checkable w-100">
    <tr>
        <td></td>
        <td>
            <table class="w-100">
                <tr>
                    @if(isset($datesArr) && count($datesArr)>0)
                        @foreach($datesArr as $dkey => $dval)
                            @php
                            $dateData = explode("_",$dval);
                            $fromDate = custom_date_format($dateData[0],'d/m/Y');
                            $toDate = custom_date_format($dateData[1],'d/m/Y');
                            @endphp
                            <th class="w-275px text-center filter_{{$dval}}">
                                {{$fromDate.' To '.$toDate}}
                            </th>
                        @endforeach
                    @endif
                </tr>
            </table>
        </td>
    </tr>
    @if(count($profit_loss) > 0)
        @foreach($profit_loss as $loskey => $lossval)
            @php
            $readonly = '';
            $soild = '';
            if($loskey == 'pbt' || $loskey == 'pat' || $loskey == 'ebidta')
            {
                $readonly = 'readonly';
                $soild = 'form-control-solid jsReadOnlyData';
            }
            @endphp
            <tr>
                <td>
                    <label class="col-form-label">{{$lossval}}</label>
                </td>
                <td class="p-0">
                    <table class="w-100">
                        <tr>
                            @if(isset($datesArr) && count($datesArr)>0)
                                @foreach($datesArr as $dkey => $dval)
                                <td class="w-275px text-center filter_{{$dval}}">
                                    {!! Form::number('losses['.$loskey.']['.$dval.']', $lossData[$loskey][$dval] ?? '', ['class' => 'form-control losses '.$soild.' '.$loskey.'_'.$dval,'id'=>'losses['.$loskey.']['.$dval.']','data-slug' => $loskey,'data-year' => $dval, $readonly,'']) !!}
                                </td>
                                @endforeach
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    @endif
</table>