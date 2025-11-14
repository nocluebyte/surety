<table class="w-100">
    <tr>
        <td class="w-20">
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.total_approved_limit')) }}
            </div>
        </td>
        <td>:</td>
        <th class="w-10">
            <div class="font-weight-bold text-right text-black">
                {{ isset($total_approved_limit) && $total_approved_limit > 0 ? format_amount($total_approved_limit ?? '', '0') : '0' }}
            </div>
        </th>
        <th class="w-10">
            <div class="font-weight-bold text-black"></div>
        </th>
        <td class="w-20">
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.pending')) }}
            </div>
        </td>
        <td>:</td>
        <th class="w-10">
            <div class="font-weight-bold text-right text-black">
                {{ 0 }}
            </div>
        </th>
        <th class="w-10">
            <div class="font-weight-bold text-black"></div>
        </th>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.highest')) }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ isset($highest) && $highest > 0 ? format_amount($highest ?? '', '0', '.') : '0' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.spare_capacity')) }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ isset($sparecapacity) && $sparecapacity > 0 ? format_amount($sparecapacity ?? '', '0', '.') : '0' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.individual_cap')) }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ isset($total_individual_cap) && $total_individual_cap > 0 ? format_amount($total_individual_cap ?? '', '0', '.') : '0' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.overall_cap')) }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ isset($total_overall_cap) && $total_overall_cap > 0 ? format_amount($total_overall_cap ?? '', '0', '.') : '0' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
                {{ Form::label(__('principle.group_cap')) }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ isset($total_group_cap) && $total_group_cap > 0 ? format_amount($total_group_cap ?? '', '0') : '0' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('principle.regular_review_date') }}</div>
        </td>
        <td>:</td>
        <th>
            @if (isset($casesLimitStrategy))
                <div class="font-weight-bold text-right text-black">
                    {{ $casesLimitStrategy['proposed_valid_till'] ? custom_date_format($casesLimitStrategy['proposed_valid_till'], 'd/m/Y'): '' }}
                </div>
            @else
                <div class="font-weight-bold text-right text-black">NA</div>
            @endif
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
    </tr>
    <tr>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">
            {{ Form::label(__('principle.last_analysis_date')) }}
            </div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ 'NA' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
        <td>
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('principle.last_bs_date') }}</div>
        </td>
        <td>:</td>
        <th>
            <div class="font-weight-bold text-right text-black">
                {{ 'NA' }}
            </div>
        </th>
        <th>
            <div class="font-weight-bold text-black"></div>
        </th>
    </tr>
</table>