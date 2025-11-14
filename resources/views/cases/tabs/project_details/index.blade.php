<form action="{{route('project-details-store')}}" method="POST" id="casesProjectDetailsForm">
    <input type="hidden" name="cases_id" value="{{ $case->id ?? '' }}">
    <input type="hidden" name="underwriter_id" value="{{$case->underwriter_id ?? ''}}">
    @csrf
    <table style="width:100%">
        <tr>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.pin') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->projectDetails->code ?? '-' }}
                </div>
            </td>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.beneficiary') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->projectDetailsBeneficiary->company_name ?? '-' }}
                </div>
            </td>
        </tr>
        <tr>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.project_name') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->pd_project_name ?? '-' }}
                </div>
            </td>

            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.project_value') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ numberFormatPrecision($case->proposal->pd_project_value, 0) ?? '-' }}
                </div>
            </td>
        </tr>
        <tr>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.project_description') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->pd_project_description ?? '-' }}
                </div>
            </td>
        </tr>
        <tr>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.type_of_project') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->projectDetailsProjectType->name ?? '-' }}
                </div>
            </td>

            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.project_start_date') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ isset($case->proposal->pd_project_start_date) ? custom_date_format($case->proposal->pd_project_start_date, 'd/m/Y') : '-' }}
                </div>
            </td>
        </tr>
        <tr>
            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.project_end_date') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ isset($case->proposal->pd_project_end_date) ? custom_date_format($case->proposal->pd_project_end_date, 'd/m/Y') : '-' }}
                </div>
            </td>

            <td width="10%">
                <div class="font-weight-bold p-1 davy-grey-color">
                    {{ __('project_details.period_of_project') }}
                </div>
            </td>
            <td width="25%">
                <div class=" font-weight-bold  text-black">:
                    {{ $case->proposal->pd_period_of_project ?? '-' }}
                </div>
            </td>
        </tr>
    </table>
    <br>
    <hr>
    <div class="row">
        <div class="col">
            <div class="form-group">
                {!! Form::label(__('cases.what_is_the_current_status_of_the_project'), __('cases.what_is_the_current_status_of_the_project')) !!}<i
                    class="text-danger">*</i>
                {!! Form::textarea('project_details_current_status_of_the_project',$case->project_details_current_status_of_the_project ?? null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) !!}
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                {!! Form::label(__('cases.any_updates'), __('cases.any_updates')) !!}<i class="text-danger">*</i>
                {!! Form::textarea('project_details_any_updates',$case->project_details_any_updates ?? null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) !!}
            </div>
        </div>
    </div>
    <br>
    <table class="row">
        <tr>
            <span class="p-1 text-danger project-details-error-0 d-none">
                Please assign underwriter to take any action.
            </span>
          </tr>
    </table>
    <br>
    <div class="card-footer pt-3 pb-1 ">
        <div class="row">
            <div class="col-12 text-right ">
                 @if ($current_user->id === $case->underwriterUserId)
                    <button class="btn btn-primary" type="submit">Save</button>
                 @endif
            </div>
        </div>
    </div>
</form>