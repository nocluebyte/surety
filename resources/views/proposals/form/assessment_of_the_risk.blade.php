<div class="row">
    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label(__('proposals.latest_sanction_attachment'), __('proposals.latest_sanction_attachment')) !!}<i class="text-danger displayNone">*</i>
        </div>
        <div class="d-block">
            {!! Form::file('latest_sanction_attachment', [
                'class' => 'latest_sanction_attachment',
                empty($dms_data['latest_sanction_attachment']) ? 'required' : '',
            ]) !!}
        </div>
        @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['latest_sanction_attachment']))
            @foreach ($dms_data['latest_sanction_attachment'] as $item)
                @if ($item->file_name)
                    <span>{{ $item->file_name ?? '' }}</span>
                @endif
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(
            __('proposals.audited_financials_public_domain'),
            __('proposals.audited_financials_public_domain'),
        ) !!}<i class="text-danger displayNone">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('audited_financials_public_domain', 'Yes', true, ['class' => 'form_audited_financials_public_domain', 'id' => 'is_yes_audited_financials_public_domain']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('audited_financials_public_domain', 'No', '', ['class' => 'form_audited_financials_public_domain', 'id' => 'is_no_audited_financials_public_domain']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="auditedFinancialsAttachmentData">
            <div class="d-block">
                {!! Form::label(__('proposals.audited_financials_attachment'), __('proposals.audited_financials_attachment')) !!}<i class="text-danger displayNone">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('audited_financials_attachment', [
                    'class' => 'audited_financials_attachment',
                    'data-id' => $proposals->audited_financials_public_domain ?? null,
                    // empty($dms_data['audited_financials_attachment']) ? 'required' : '',
                    'data-document-uploaded' => empty($dms_data['audited_financials_attachment']) ? 'true' : 'false',
                ]) !!}
            </div>
            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['audited_financials_attachment']))
                @foreach ($dms_data['audited_financials_attachment'] as $item)
                    @if ($item->file_name)
                        <span>{{ $item->file_name ?? '' }}</span>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="auditedFinancialsDetailsData">
            <div class="d-block">
                {!! Form::label(__('proposals.audited_financials_details'), __('proposals.audited_financials_details')) !!}<i class="text-danger displayNone">*</i>
            </div>
            <div class="d-block">
                {!! Form::text('audited_financials_details', null, [
                    'class' => 'form-control required audited_financials_details',
                    'id' => 'audited_financials_details',
                    'data-rule-AlphabetsAndNumbersV3' => true,
                ]) !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label(__('proposals.last_3_years_itr'), __('proposals.last_3_years_itr')) !!}<i class="text-danger displayNone">*</i>
        </div>
        <div class="d-block">
            {!! Form::file('last_3_years_itr', [
                'class' => 'last_3_years_itr',
                empty($dms_data['last_3_years_itr']) ? 'required' : '',
            ]) !!}
        </div>
        @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['last_3_years_itr']))
            @foreach ($dms_data['last_3_years_itr'] as $item)
                @if ($item->file_name)
                    <span>{{ $item->file_name ?? '' }}</span>
                @endif
            @endforeach
        @endif
    </div>

    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label(__('proposals.analysis_of_partner'), __('proposals.analysis_of_partner')) !!}<i class="text-danger displayNone">*</i>
        </div>
        <div class="d-block">
            {!! Form::file('analysis_of_partner', [
                'class' => 'analysis_of_partner',
                empty($dms_data['analysis_of_partner']) ? 'required' : '',
            ]) !!}
        </div>
        @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['analysis_of_partner']))
            @foreach ($dms_data['analysis_of_partner'] as $item)
                @if ($item->file_name)
                    <span>{{ $item->file_name ?? '' }}</span>
                @endif
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.latest_presentation_domain'), __('proposals.latest_presentation_domain')) !!}<i class="text-danger displayNone">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('latest_presentation_domain', 'Yes', true, ['class' => 'form_latest_presentation_domain', 'id' => 'is_yes_latest_presentation_domain']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('latest_presentation_domain', 'No', '', ['class' => 'form_latest_presentation_domain', 'id' => 'is_no_latest_presentation_domain']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="latestPresentationAttachmentData">
            <div class="d-block">
                {!! Form::label(__('proposals.latest_presentation_attachment'), __('proposals.latest_presentation_attachment')) !!}<i class="text-danger displayNone">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('latest_presentation_attachment', [
                    'class' => 'latest_presentation_attachment',
                    'data-id' => $proposals->latest_presentation_domain ?? null,
                    // empty($dms_data['latest_presentation_attachment']) ? 'required' : '',
                    'data-document-uploaded' => empty($dms_data['latest_presentation_attachment']) ? 'true' : 'false',
                ]) !!}
            </div>

            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['latest_presentation_attachment']))
                @foreach ($dms_data['latest_presentation_attachment'] as $item)
                    @if ($item->file_name)
                        <span>{{ $item->file_name ?? '' }}</span>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="latestPresentationDetailsData">
            {!! Form::label(__('proposals.latest_presentation_details'), __('proposals.latest_presentation_details')) !!}<i class="text-danger displayNone">*</i>
            {!! Form::text('latest_presentation_details', null, [
                'class' => 'form-control required latest_presentation_details',
                'id' => 'latest_presentation_details',
                'data-rule-AlphabetsAndNumbersV3' => true,
            ]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        <div class="d-block">
            {!! Form::label(__('proposals.group_structure_diagram'), __('proposals.group_structure_diagram')) !!}<i class="text-danger displayNone">*</i>
        </div>
        <div class="d-block">
            {!! Form::file('group_structure_diagram', [
                'class' => 'group_structure_diagram',
                empty($dms_data['group_structure_diagram']) ? 'required' : '',
            ]) !!}
        </div>

        @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['group_structure_diagram']))
            @foreach ($dms_data['group_structure_diagram'] as $item)
                @if ($item->file_name)
                    <span>{{ $item->file_name ?? '' }}</span>
                @endif
            @endforeach
        @endif
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.rating_rationale_domain'), __('proposals.rating_rationale_domain')) !!}<i class="text-danger displayNone">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('rating_rationale_domain', 'Yes', true, ['class' => 'form_rating_rationale_domain', 'id' => 'is_yes_rating_rationale_domain']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('rating_rationale_domain', 'No', '', ['class' => 'form_rating_rationale_domain', 'id' => 'is_no_rating_rationale_domain']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="ratingRationaleAttachmentData">
            <div class="d-block">
                {!! Form::label(__('proposals.rating_rationale_attachment'), __('proposals.rating_rationale_attachment')) !!}<i class="text-danger displayNone">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('rating_rationale_attachment', [
                    'class' => 'rating_rationale_attachment',
                    'data-id' => $proposals->rating_rationale_domain ?? null,
                    // empty($dms_data['rating_rationale_attachment']) ? 'required' : '',
                    'data-document-uploaded' => empty($dms_data['rating_rationale_attachment']) ? 'true' : 'false',
                ]) !!}
            </div>

            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['rating_rationale_attachment']))
                @foreach ($dms_data['rating_rationale_attachment'] as $item)
                    @if ($item->file_name)
                        <span>{{ $item->file_name ?? '' }}</span>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="ratingRationaleDetailsData">
            {!! Form::label(__('proposals.rating_rationale_details'), __('proposals.rating_rationale_details')) !!}<i class="text-danger displayNone">*</i>
            {!! Form::text('rating_rationale_details', null, [
                'class' => 'form-control required rating_rationale_details',
                'id' => 'rating_rationale_details',
                'data-rule-AlphabetsAndNumbersV3' => true,
            ]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(
            __('proposals.last_5_years_completed_projects'),
            __('proposals.last_5_years_completed_projects'),
        ) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('last_5_years_completed_projects', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label(
                __('proposals.last_5_years_completed_projects_file'),
                __('proposals.last_5_years_completed_projects_file'),
            ) !!}<i class="text-danger displayNone">*</i>
        </div>
        <div class="d-block">
            {!! Form::file('last_5_years_completed_projects_file', [
                'class' => 'last_5_years_completed_projects_file',
                empty($dms_data['last_5_years_completed_projects_file']) ? 'required' : '',
            ]) !!}
        </div>

        @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['last_5_years_completed_projects_file']))
            @foreach ($dms_data['last_5_years_completed_projects_file'] as $item)
                @if ($item->file_name)
                    <span>{{ $item->file_name ?? '' }}</span>
                @endif
            @endforeach
        @endif
    </div>
</div>
