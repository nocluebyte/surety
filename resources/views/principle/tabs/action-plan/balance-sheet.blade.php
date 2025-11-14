<div class="row g-3">
    <div class="col-md-6">
        <table class="table table-separate table-head-custom table-checkable w-100">
            <tr>
                <td></td>
                <td>
                    <table>
                        <tr>
                            @if(isset($datesArr) && count($datesArr)>0)
                                @foreach($datesArr as $dkey => $dval)
                                @php
                                $dateData = explode("_",$dval);
                                $fromDate = custom_date_format($dateData[0],'d/m/Y');
                                $toDate = custom_date_format($dateData[1],'d/m/Y');
                                @endphp
                                <th class="w-275px text-center filter_{{$dval}}">{{$fromDate.' To '.$toDate}}</th>
                                @endforeach
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
            @if(count($balance_sheet_a) > 0)
                @foreach($balance_sheet_a as $balanceakey => $balanceaval)
                    @php
                    $readonly = $class_a = $soild = '';
                    if(in_array($balanceakey, ['total_ca','total_fa','total_bs_a', 'quick']))
                    {
                        $readonly = 'readonly';
                        $class_a = 'totalcalc jsReadOnlyData';
                        $soild = 'form-control-solid';
                    }
                    $dnone = $disable = '';

                    if(in_array($balanceakey, ['1','2']))
                    {
                        $dnone = 'd-none';
                        $disable = 'disabled';
                    }
                    @endphp
                    <tr>
                        <td><label class="col-form-label">{{$balanceaval}}</label></td>
                        <td>
                            <table>
                                <tr>
                                    @if(isset($datesArr) && count($datesArr)>0)
                                    @foreach($datesArr as $dkey => $dval)
                                    <td class="w-225px text-center">
                                       {{$balanceSheetData[$balanceakey][$dval] ?? ''}}
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
    </div>
    <div class="col-md-6">
        <table class="table table-separate table-head-custom table-checkable w-100">
            <tr>
                <td></td>
                <td>
                    <table>
                        @if(isset($datesArr) && count($datesArr)>0)
                            @foreach($datesArr as $dkey => $dval)
                                @php
                                $dateData = explode("_",$dval);
                                $fromDate = custom_date_format($dateData[0],'d/m/Y');
                                $toDate = custom_date_format($dateData[1],'d/m/Y');
                                @endphp
                                <th class="w-275px text-center filter_{{$dval}}">{{$fromDate.' To '.$toDate}}</th>
                            @endforeach
                        @endif
                    </table>
                </td>
            </tr>
            @foreach($balance_sheet_b as $balancebkey => $balancebval)
            @php
            $readonly = ''; $class_b = '';$soild = '';
            if(in_array($balancebkey, ['total_cl','total_ltd','net_worth','total_bs_b']))
            {
                $readonly = 'readonly';
                $class_b = 'totalcalc jsReadOnlyData';
                $soild = 'form-control-solid';
            }
            $class = '';
            if($balancebkey == 'total_bs_b' )
            {
                $class = 'totalBsB';
            }

            $dnone = '';
            $disable = '';
            if(in_array($balancebkey, ['1','2']))
            {
                $dnone = 'd-none';
                $disable = 'disabled';
            }
            @endphp
            <tr>
                <td><label class="col-form-label">{{$balancebval}}</label></td>
                <td>
                    <table>
                        <tr>
                            @if(isset($datesArr) && count($datesArr)>0)
                                @foreach($datesArr as $dkey => $dval)
                                    <td class="w-225px text-center">
                                        {{$balanceSheetData[$balancebkey][$dval] ?? ''}}
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>