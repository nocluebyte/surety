<table style="width: 100%">
    <tbody>
        <tr>
            <td class="p-3"><label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRowAll">
                    <span></span>&nbsp;&nbsp;All
                </label>
            </td>
        </tr>
        <tr>
            @foreach ($fields as $chuncked)
                <tr>
                    @foreach ($chuncked as $key => $value)
                        <td class="p-3"><label class="checkbox checkbox-lg">
                                <input type="checkbox" class="checkbox_animated checkRow" value="{{$value}}" name="multicheckbox[]" {{in_array($value,$checked_fields) ? 'checked' : ''}}>
                                <span></span>&nbsp;&nbsp;{{$key}}
                            </label>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tr>
        {{-- <tr>
            <td class="p-3"><label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="contractor_id"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Contractor ID
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="contractor_name"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Contractor Name
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="proposal_id" name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Proposal ID
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="bond_issue_number"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Bond Issue Number
                </label>
            </td>
        </tr>
        <tr>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="group_name" name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Bond Type
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="beneficiary_id"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Beneficiary ID
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="beneficiary_name"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Beneficiary Name
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="project_title"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Project Title
                </label>
            </td>
        </tr>
        <tr>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="tender_id" name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Tender ID
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="tender_header"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Tender Header
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="bond_start_date"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Bond Start Date
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="bond_end_date"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Bond End Date
                </label>
            </td>
        </tr>
        <tr>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="bond_value" name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Bond Value
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="project_value"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Project Value
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="premium_ammount"
                        name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Premium Ammount
                </label>
            </td>
            <td class="p-3">
                <label class="checkbox checkbox-lg">
                    <input type="checkbox" class="checkbox_animated checkRow" value="status" name="multichkbox[]">
                    <span></span>&nbsp;&nbsp;Status
                </label>
            </td>
        </tr> --}}
    </tbody>
</table>