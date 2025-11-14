{{-- <div id="additional_bond_repeater">
    <p class="duplicateError text-danger d-none"></p>
    @if (isset($additionalBonds))
        <div class="repeaterRow additional_repeater_row" data-repeater-list="additional_bond_items">
            @foreach ($additionalBonds as $item)
                <div class="row bond_row" data-repeater-item="">
                    {!! Form::hidden('ab_id', $item->id ?? '', ['class' => 'jsAbId']) !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.additional_bond'), __('proposals.additional_bond')) !!}<i class="text-danger">*</i>

                        {!! Form::select('additional_bond_id', ['' => 'Select Additional Bond'] + $additional_bonds, $item->additional_bond_id ?? null, [
                            'class' => 'form-control required additional_bond_id',
                            'style' => 'width:100%;',
                            'data-placeholder' => 'Select Additional Bond',
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.bond_value'), __('proposals.bond_value')) !!}<i class="text-danger">*</i>
                        {!! Form::text('additional_bond_value', $item->bond_value ?? null, [
                            'class' => 'form-control required number additional_bond_value',
                            'data-rule-Numbers' => true,
                            'min' => 1,
                        ]) !!}
                    </div>
                    <div class="col-2 mt-10 delete_mp_item">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="repeaterRow additional_repeater_row" data-repeater-list="additional_bond_items">
            <div class="row bond_row" data-repeater-item="">
                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.additional_bond'), __('proposals.additional_bond')) !!}<i class="text-danger">*</i>

                    {!! Form::select('additional_bond_id', ['' => 'Select Additional Bond'] + $additional_bonds, null, [
                        'class' => 'form-control required additional_bond_id',
                        'style' => 'width:100%;',
                        'data-placeholder' => 'Select Additional Bond',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.bond_value'), __('proposals.bond_value')) !!}<i class="text-danger">*</i>
                    {!! Form::text('additional_bond_value', null, [
                        'class' => 'form-control required number additional_bond_value',                        
                        'data-rule-Numbers' => true,
                        'min' => 1,
                    ]) !!}
                </div>

                <div class="col-2 mt-10 delete_mp_item">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>                
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAdditionalBond">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div> --}}
