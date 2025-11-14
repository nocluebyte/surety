@push('scripts')
    <script type="text/javascript">
        $(document).on('change', '.project_details', function() {
            let project_details = $(this).val();

            if (project_details.length === 0) {
                projectDetailsFields.forEach(field => {
                    $("." + field).val("");
                    $("." + field).prop('readonly', false).removeClass(
                        'form-control-solid');
                });
                $('select[name="pd_beneficiary"]').val('').trigger('change');
                $('select[name="pd_type_of_project"]').val('').trigger(
                'change');
                // $(".second_tender").val('').trigger("change");
            }

            if (project_details > 0) {
                let ajaxUrl = $(this).attr('data-ajaxurl');

                // if(['Stand Alone', ''].includes($('#contract_type').val())){
                    var tender_details_id = "";
                    $.ajax({
                        type: "POST",
                        url: '{{route("get-tender-details")}}',
                        data: {
                            'project_details_id': project_details,
                        },
                        success: function(res) {
                            if (res) {
                                var options = '';
                                var data = [{
                                    'id': '',
                                    'text': '',
                                    'html': '',
                                }];
                                $.each(res, function(id,name) {

                                    if (tender_details_id > 0 && id == tender_details_id) {
                                        var selected = true;
                                    } else {
                                        var selected = false;
                                    }

                                    // if(id != $('.tender_details_id').val()){
                                    //     $('.second_tender').val('').trigger('change');
                                    //     $('.spv_contractor').val('').trigger('change');
                                    //     $('.jv_contractor').val('').trigger('change');
                                    //     $('.JsspvContractorRepeater').html('');
                                    //     $('.JsjvContractorRepeater').html('');
                                    //     $(".spv_contractor option").attr('disabled', false);
                                    // }

                                    var obj = {
                                        'id': id,
                                        'text': name,
                                        'html': name,
                                        "selected": selected
                                    };
                                    data.push(obj);
                                });
                                $(".tender_details_id").select2({
                                    data: data,
                                    templateResult: selectTemplate,
                                    escapeMarkup: function(m) {
                                        return m;
                                    },
                                });

                                if (tender_details_id > 0) {
                                    $(".tender_details_id").val(tender_details_id).trigger("change");
                                }
                            }
                        }
                    });
                // }

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'project_details_id': project_details,
                    },
                }).always(function() {

                }).done(function(response) {
                    // console.log(response);
                    if (response) {
                        projectDetailsFields.forEach(field => {
                            $("." + field).val(response[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('select[name="pd_beneficiary"]').val(response.pd_beneficiary).trigger(
                        'change');

                        $('select[name="pd_type_of_project"]').val(response.pd_type_of_project).trigger(
                        'change');
                    } else {
                        projectDetailsFields.forEach(field => {
                            $("." + field).val("");
                            $("." + field).prop('readonly', false).removeClass(
                                'form-control-solid');
                        });
                    }
                })
            }
        });

        const projectDetailsFields = [
            'pd_project_name',
            'pd_project_description',
            'pd_project_value',
            'pd_project_start_date',
            'pd_project_end_date',
            'pd_period_of_project',
        ];
    </script>
@endpush
