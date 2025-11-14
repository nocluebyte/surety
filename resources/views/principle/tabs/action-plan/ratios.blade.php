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
                        $fromDate = Carbon\Carbon::parse($dateData[0])->format('d/m/Y');
                        $toDate = Carbon\Carbon::parse($dateData[1])->format('d/m/Y');
                        @endphp
                        <th class="w-275px text-center filter_{{$dval}}">{{$fromDate.' To '.$toDate}}</th>
                    @endforeach
                    @endif
                </tr>
            </table>
        </td>
    </tr>
    @if(count($ratios) > 0)
        @foreach($ratios as $ratioskey => $ratiosval)
            @php
            $dnone = '';
            $disable = '';
            $soild = '';
            if($ratioskey == '1')
            {
                $dnone = 'd-none';
                $disable = 'disabled';
                $soild = 'form-control-solid';
            }
            @endphp
            <tr>
                <td><label class="col-form-label">{{$ratiosval}}</label></td>
                <td class="jsTd p-0">
                    <table class="w-100">
                        <tr>
                            @if(isset($datesArr) && count($datesArr)>0)
                                @foreach($datesArr as $dkey => $dval)
                                    <td class="w-225px text-center">
                                        {{$ratiosData[$ratioskey][$dval] ?? ''}}
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