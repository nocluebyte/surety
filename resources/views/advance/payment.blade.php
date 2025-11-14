@php
$index = 1;
$creditTotal = 0;
$debitTotal = 0;
$balanceTotal = 0;
@endphp

<table class="table" id="ledger_table">
    <thead>
        <tr>
            <!-- <th>{{__('common.no')}}</th> -->
            <th>{{__('common.date')}}</th>
            <th>{{__('loan.voucher_no')}}</th>
            <th class="text-right">{{__('loan.credit')}}</th>
            <th class="text-right">{{__('loan.debit')}}</th>
            <th class="text-right">{{__('loan.balance')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($statement))
        @php
        $balance_re = $statement->amount;
        @endphp
        <tr>
            <td>{{ (!empty($statement->created_at)) ? date('d-m-Y', strtotime($statement->created_at)) : '-' }}</td>
            <td>{{ $statement->code ?? '' }}</td>
            <td class="text-right">{{ '0.00' }}</td>
            <td class="text-right">{{ (!empty($balance_re)) ? format_amount($balance_re, 2) : '0.00' }}</td>
            <td class="text-right">{{ (!empty($balance_re)) ? format_amount($balance_re, 2) : '0.00' }}</td>
        </tr>


            @foreach($statement->saleryData as $ldata)
                @php
                $balance_re = $balance_re - $ldata->advance;
                @endphp
               
                <tr>
                    <!-- <td>{{ $index++ }}</td> -->
                    <td>{{ (!empty($ldata->created_at)) ? date('d-m-Y', strtotime($ldata->created_at)) : '-' }}</td>
                    
                    <td><a href="{{route('salarySlipGenerate',[$ldata->month,$ldata->employee_id,'year' => $ldata->year])}}">{{ date("F", mktime(0, 0, 0, $ldata->month, 1)) }}-{{ $ldata->year}}</a></td>
                    <td class="text-right">{{ (!empty($ldata->advance)) ? format_amount($ldata->advance, 2) : '0.00' }}</td>
                    <td class="text-right">{{ '0.00' }}</td>
                    <td class="text-right">{{ (!empty($balance_re)) ? format_amount($balance_re, 2) : '0.00' }}</td>
                </tr>
           
            @endforeach
        @endif
        
    </tbody>

</table>

@push('scripts')
<script type="text/javascript">
    // var table = null;
    $(document).ready(function() {
        $('#ledger_table').DataTable({
            paging: false,
            searching: false,
            'columnDefs': [{
                'targets': [0, 1, 2, 4, 5],
                'orderable': false,
            }]
        });
    });
</script>
@endpush