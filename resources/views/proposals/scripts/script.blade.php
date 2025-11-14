@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        function updateTabValidation() {
            $('.tab-content.tab-validate .tab-pane').each(function() {

                var id = $(this).attr('id');
                if ($(this).find('input.error, textarea.error, select.error').length) {
                    // console.log($(this).find('input.error, textarea.error, select.error').length);
                    // if ($(".form_is_manual_entry:checked").val() == 'Yes') {
                    //     $('.nav-tabs li a[href="#' + id + '"]').addClass('border border-danger');
                    // }
                    // console.log($(this).find('input.error').length);
                    // $('.tab-content.tab-validate #contractor_details, .tab-content.tab-validate #requirement_details')
                    //     .each(function() {
                    //         if ($(".form_is_manual_entry:checked").val() == 'No') {
                    //             $('.nav-tabs li a[href="#' + id + '"]').addClass('border border-danger');
                    //         }
                    //     });
                    $('.nav-tabs li a[href="#' + id + '"]').addClass('border border-danger');
                } else {
                    $('.nav-tabs li a[href="#' + id + '"]').removeClass('border border-danger');
                }
            });
        }

        jQuery.validator.addMethod("filesize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than 2 MB');

        var initValidation = function() {

            $(document).on('change', '.statusDate', function() {
                var row = $(this).closest('.ptr_row');
                var estDate = row.find('.estimated_date_of_completion').val();
                var actDate = row.find('.actual_date_completion').val();

                if (estDate != '' && actDate != '') {
                    (estDate > actDate) ? row.find('.completion_status').val('Advance'): '';
                    (estDate < actDate) ? row.find('.completion_status').val('Delayed'): '';
                    (estDate === actDate) ? row.find('.completion_status').val('On Time'): '';
                }
            });

            const disabledFields = [
                'contractor_type',
                'tender_details_id',
                'contractor_id',
                'jv_contractor',
                'spv_contractor',
                'contractor_country_id',
                'contractor_state_id',
                'agency_id',
                // 'agency_rating_id',
                'principle_type_id',
                'JvSpvContractorId',
                'contractor_trade_sector',
                'beneficiary_id',
                'project_type',
                'bond_type_id',
                'type_of_contracting',
                'project_details',
                'pd_beneficiary',
                'pd_type_of_project',
                'beneficiary_country_id',
                'beneficiary_state_id',
                'establishment_type_id',
                'ministry_type',
                'beneficiary_trade_sector_id',
                'bond_type',
                'banking_category_id',
                'facility_type_id',
                'current_status_dropdown',
                'designation_dropdown',
                'contractor_bond_country_id',
                'contractor_bond_state_id',
                'beneficiary_bond_country_id',
                'beneficiary_bond_state_id',
                'tender_beneficiary_id',
                'second_tender',
                'contractor_entity_type_id',
                'rating_id',

                'management_profiles_attachment',
                'project_track_records_attachment',
                'order_book_and_future_projects_attachment',
                'banking_limits_attachment',
                'bond_wording_file',
                'bond_attachment',
                'rfp_attachment',
                'last_three_years_itr',
                'company_pan_no',
                'gst_certificate',
                'memorandum_and_articles',
                'certificate_of_incorporation',
                'company_presentation',
                'company_technical_details',
                'company_details',

                'are_you_blacklisted',
                'contractor_is_main',
                'beneficiary_type',
                'beneficiary_is_main',
                'form_is_bank_guarantee_provided',
                'form_is_action_against_proposer',

                'beneficiary_same_as_above',
                'contractor_same_as_above',
            ];

            $('#proposalsForm').validate({
                debug: false,
                // ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                // ignore: '.select2-search__field, [data-id=\'Yes\'], [data-id=\'No\'], :hidden:not("textarea, .files, select, input")',
                ignore: '.select2-search__field, .jv_pan_no, .spv_pan_no, .rfp_attachment, :hidden:not("textarea, .files, select, input")',
                rules: {
                    bond_end_date: {
                        min: () => $(".bond_start_date").val(),
                    },

                    pd_project_end_date: {
                        min: () => $(".pd_project_start_date").val(),
                    },
                },
                messages: {
                    bond_end_date: {
                        min: () => "Please enter a value greater than or equal to " + moment($(
                            ".bond_start_date").val()).format('DD/MM/YYYY'),
                    },

                    pd_project_end_date: {
                        min: () => "Please enter a value greater than or equal to " + moment($(
                            ".pd_project_start_date").val()).format('DD/MM/YYYY'),
                    },
                },
                // errorPlacement: function(error, element) {
                //     error.appendTo(element.parent()).addClass('text-danger');
                // },
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function(e) {
                    // $('.JvSpvContractorId').prop('disabled', false);
                    $('select[name="type_of_bond"]').prop('disabled', false);
                    // $('.beneficiary_type').prop('disabled', false);
                    $('.form_is_jv').prop('disabled', false);

                    disabledFields.forEach(item => {
                        $("." + item).prop('disabled', false);
                    });

                    $(".agency_id").prop('disabled', false);
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    $('.jsDisabled').attr('disabled', false);

                    // if ($('.contractor_is_main:checked').length === 0) {
                    //     errorMessage('Please check at least one main in trade sector')
                    //     return false;
                    // }

                    // if ($('.beneficiary_is_main:checked').length === 0) {
                    //     errorMessage('Please check at least one main in trade sector')
                    //     return false;
                    // }
                    return true;
                },
                invalidHandler: function() {
                    setTimeout(updateTabValidation, 0);
                },
            });
            $('.tab-content.tab-validate').on('input change', 'input, textarea, select', updateTabValidation);
            $('.proposals_save').on('click', updateTabValidation);

            $(document).on('change', '.project_start_date', function() {
                var row = $(this).closest('.ptr_row');
                var fromDateFormat = moment(row.find('.project_start_date').val()).format('DD/MM/YYYY');
                var fromDate = moment(row.find('.project_start_date').val()).add(1, 'day').format('YYYY-MM-DD');

                row.find('.estimated_date_of_completion').attr('min', fromDate).attr('data-msg-min',
                    "Please enter a date greater than " +
                    fromDateFormat);
                row.find('.actual_date_completion').attr('min', fromDate).attr('data-msg-min',
                    "Please enter a date greater than " +
                    fromDateFormat);
            });

            function manageRepeaterAttachments(formRepeater) {
                $(document).on('change', formRepeater, function() {
                    var fileInput = $(this);
                    var fileNamesContainer = fileInput.closest('.form-group').find('.fileNamesContainer');

                    fileNamesContainer.empty();

                    for (var i = 0; i < this.files.length; i++) {
                        var fileName = this.files[i].name;
                        // console.log(this.files[i].webkitRelativePath);
                        fileNamesContainer.append(
                            '<div class="file_attachment delete_attachment" role="button" data-index="' +
                            i + '">' + fileName +
                            ' <i class="fa fa-trash-alt" style="font-size:10px;color:red"></i></div>'
                        );
                    }
                });

                $(document).on('click', '.delete_attachment', function() {
                    var fileAttachment = $(this).closest('.file_attachment');
                    var fileInput = $(this).closest('.form-group').find(
                        formRepeater);
                    var index = $(this).data('index');

                    fileAttachment.remove();

                    var files = fileInput[0].files;
                    var newFileList = Array.from(files).filter((file, i) => i !== index);
                    var dataTransfer = new DataTransfer();
                    newFileList.forEach(file => dataTransfer.items.add(file));

                    fileInput[0].files = dataTransfer.files;
                });

                if ($('.jsPblId').val() === '') {
                    // $(formRepeater).addClass('required').attr('aria-required', 'true');
                }
            }

            manageRepeaterAttachments('.proposal_banking_limits_attachment');
            manageRepeaterAttachments('.order_book_and_future_projects_attachment');
            manageRepeaterAttachments('.project_track_records_attachment');
            manageRepeaterAttachments('.management_profiles_attachment');


            let removedValues = new Set();

            $(document).on('click', '.dms_data', function() {
                const fileId = $(this).data('id');

                $(this).remove();

                $('.remove_dms').remove();

                if (!removedValues.has(fileId)) {
                    removedValues.add(fileId);

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_dms[]',
                        value: fileId
                    }).appendTo('form');
                }
            });

            function updateFieldBasedOnRadio(radioId, fieldClass, requiredClass) {
                if ($(radioId).is(':checked')) {
                    $(fieldClass).show().attr('aria-hidden', 'false');
                    $(requiredClass).addClass('required').attr('aria-required', 'true');

                    if ($(requiredClass).data('id') == "Yes" && $(requiredClass).attr('data-document-uploaded') ==
                        'false') {
                        $(requiredClass).removeClass('required').removeAttr('aria-required');
                    }
                    if ($(requiredClass).data('id') == "No" && $(requiredClass).attr('data-document-uploaded') ==
                        'false') {
                        $(requiredClass).removeClass('required').removeAttr('aria-required');
                    }
                } else {
                    $(fieldClass).hide().attr('aria-hidden', 'true');
                    $(requiredClass).val('').removeClass('required').removeAttr('aria-required');
                }
            }

            $('form').on('change', 'input[type="radio"]', function() {
                updateFieldBasedOnRadio('#is_yes_accreditation_data', '.isAccreditationData',
                    '.issuer_name, .accreditation_date');
                // updateFieldBasedOnRadio('#is_yes_agency_rating', '.isAgencyRatingData',
                //     '.agency_rating, .agency_rating_date');
                updateFieldBasedOnRadio('#is_yes_project_agreement', '.isProjectAgreementData',
                    '.project_attachment');
                updateFieldBasedOnRadio('#is_yes_rfp_of_project', '.rfpOfProjectData', '.rfp_attachment');
                updateFieldBasedOnRadio('#is_yes_is_feasibility_attachment', '.isFeasibilityAttachmentData',
                    '.feasibility_attachment');
                updateFieldBasedOnRadio('#is_yes_audited_financials_public_domain',
                    '.auditedFinancialsDetailsData',
                    '.audited_financials_details');
                updateFieldBasedOnRadio('#is_no_audited_financials_public_domain',
                    '.auditedFinancialsAttachmentData',
                    '.audited_financials_attachment');
                updateFieldBasedOnRadio('#is_yes_latest_presentation_domain',
                    '.latestPresentationDetailsData',
                    '.latest_presentation_details');
                updateFieldBasedOnRadio('#is_no_latest_presentation_domain',
                    '.latestPresentationAttachmentData',
                    '.latest_presentation_attachment');
                updateFieldBasedOnRadio('#is_yes_rating_rationale_domain', '.ratingRationaleDetailsData',
                    '.rating_rationale_details');
                updateFieldBasedOnRadio('#is_no_rating_rationale_domain', '.ratingRationaleAttachmentData',
                    '.rating_rationale_attachment');
                // updateFieldBasedOnRadio('#is_yes_is_bank_guarantee_provided',
                //     '.isBankGuaranteeProvidedData', '.circumstance_short_notes');
                // updateFieldBasedOnRadio('#is_yes_is_action_against_proposer',
                //     '.isActionAgainstProposerData', '.action_details');
                updateFieldBasedOnRadio('#is_no_manual_entry', '.isManualEntryData',
                    '.proposal_attachment');
            });

            updateFieldBasedOnRadio('#is_yes_accreditation_data', '.isAccreditationData',
                '.issuer_name, .accreditation_date');
            // updateFieldBasedOnRadio('#is_yes_agency_rating', '.isAgencyRatingData',
            //     '.agency_rating, .agency_rating_date');
            updateFieldBasedOnRadio('#is_yes_project_agreement', '.isProjectAgreementData', '.project_attachment');
            updateFieldBasedOnRadio('#is_yes_rfp_of_project', '.rfpOfProjectData', '.rfp_attachment');
            updateFieldBasedOnRadio('#is_yes_is_feasibility_attachment', '.isFeasibilityAttachmentData',
                '.feasibility_attachment');
            updateFieldBasedOnRadio('#is_yes_audited_financials_public_domain', '.auditedFinancialsDetailsData',
                '.audited_financials_details');
            updateFieldBasedOnRadio('#is_no_audited_financials_public_domain', '.auditedFinancialsAttachmentData',
                '.audited_financials_attachment');
            updateFieldBasedOnRadio('#is_yes_latest_presentation_domain', '.latestPresentationDetailsData',
                '.latest_presentation_details');
            updateFieldBasedOnRadio('#is_no_latest_presentation_domain', '.latestPresentationAttachmentData',
                '.latest_presentation_attachment');
            updateFieldBasedOnRadio('#is_yes_rating_rationale_domain', '.ratingRationaleDetailsData',
                '.rating_rationale_details');
            updateFieldBasedOnRadio('#is_no_rating_rationale_domain', '.ratingRationaleAttachmentData',
                '.rating_rationale_attachment');
            // updateFieldBasedOnRadio('#is_yes_is_bank_guarantee_provided', '.isBankGuaranteeProvidedData',
            //     '.circumstance_short_notes');
            // updateFieldBasedOnRadio('#is_yes_is_action_against_proposer',
            //     '.isActionAgainstProposerData', '.action_details');
            updateFieldBasedOnRadio('#is_no_manual_entry', '.isManualEntryData',
                '.proposal_attachment');


            // var beneficiaries_address = @json($beneficiary_address);
            // var beneficiary_type = @json($beneficiary_type);

            // $('#beneficiary_id').change(function() {
            //     var beneficiaryId = $(this).val();

            //     if (beneficiaryId && beneficiaries_address[beneficiaryId] && beneficiary_type[
            //             beneficiaryId]) {
            //         var selectedBeneficiary_address = beneficiaries_address[beneficiaryId];
            //         var selectedBeneficiary_type = beneficiary_type[beneficiaryId];

            //         $('textarea[name="beneficiary_address"]').val(selectedBeneficiary_address).prop(
            //             'readonly', true).addClass('form-control-solid');

            //         $('input[name="beneficiary_type"][value="' + selectedBeneficiary_type + '"]').prop(
            //             'checked', true).addClass('form-control-solid');
            //         $('.beneficiary_type').prop('disabled', true);
            //     } else {
            //         $('textarea[name="beneficiary_address"]').val('');
            //         $('input[name="beneficiary_type"]').prop('checked', false);
            //         $('.beneficiary_type').prop('disabled', false);
            //     }
            // });

            
        };

        $('#jv_contractor,#spv_contractor,.contractor_id').select2({
            allowClear: true
        });

        $(".proposals_save").on('click', function() {
            let is_manual = $(".form_is_manual_entry:checked").val();

            if (is_manual == 'No') {
                $("#assessment_of_the_risk .required").removeClass("required");
                $("#assessment_of_the_risk input[type='file']").removeAttr("required");
                $("#for_nhai_projects .required").removeClass("required");
                $("#additional_details_for_assessment .required").removeClass("required");

                $("#proposal_banking_limits .required").removeClass("required");
                $("#proposal_banking_limits input[type='file']").removeAttr("required");

                $("#order_book_and_future_projects .required").removeClass("required");
                $("#order_book_and_future_projects input[type='file']").removeAttr("required");

                $("#project_track_records .required").removeClass("required");
                $("#project_track_records input[type='file']").removeAttr("required");

                $("#management_profiles .required").removeClass("required");
                $("#management_profiles input[type='file']").removeAttr("required");
            } else {
                $("#assessment_of_the_risk .required").addClass('required');
                $("#assessment_of_the_risk input[type='file']").attr("required");
                $("#for_nhai_projects .required").addClass("required");
                $("#additional_details_for_assessment .required").addClass("required");

                $("#proposal_banking_limits .required").addClass("required");
                $("#proposal_banking_limits input[type='file']").attr("required");

                $("#order_book_and_future_projects .required").addClass("required");
                $("#order_book_and_future_projects input[type='file']").attr("required");

                $("#project_track_records .required").addClass("required");
                $("#project_track_records input[type='file']").attr("required");

                $("#management_profiles .required").addClass("required");
                $("#management_profiles input[type='file']").attr("required");
            }
        });

        function addOrDeleteRepeater(repeater, repeater_row, delete_item, click_event, add_button = '') {
            if (click_event === "add") {
                $(add_button).on('click', function() {
                    if ($(repeater).find(repeater_row).length === 1) {
                        $(repeater).find(delete_item).first().hide();
                    } else if ($(repeater).find(repeater_row).length > 1) {
                        $(repeater).find(delete_item).first().show();
                    }
                });
            } else if (click_event === "delete") {
                if (($(repeater).find(repeater_row).length - 1) === 1) {
                    $(repeater).find(delete_item).hide();
                } else if (($(repeater).find(repeater_row).length - 1) > 1) {
                    $(repeater).find(delete_item).show();
                }
            }
        }

        function removeDms(repeaterRow){
            setTimeout(function () {
                $('.' + repeaterRow).each(function (index) {
                    const row = $(this);
                    const modal = row.find('.modal');
                    // const link = row.find('[data-toggle="modal"]');
                    if (!modal.attr('data-initialized')) {
                        // const newId = 'pbl_attachment_' + Date.now() + '_' + index;
                        // modal.attr('id', newId);
                        modal.find('.modal-body').empty();
                        // modal.attr('data-initialized', 'true');
                        // link.attr('data-target', '#' + newId);
                    }
                });
            }, 100);
        }
        $(document).on('click', '.jsAddProposalBankingLimits', function () {
            removeDms('pbl_row');
        });
        $(document).on('click', '.jsAddOrderBookAndFutureProjects', function () {
            removeDms('obfp_row');
        });
        $(document).on('click', '.jsAddProjectTrackRecords', function () {
            removeDms('ptr_row');
        });
        $(document).on('click', '.jsAddManagementProfiles', function () {
            removeDms('mp_row');
        });


        $('#proposalBankingLimitsRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $('.banking_category_id').select2();
                $('.facility_type_id').select2();
                $('.select2-container').css('width', '100%');

                $(this).find('.dms_data').remove();
                $(this).attr('data-row-index', $(this).index());
                $(this).find('.count_banking_limits_attachment').text('');
                $(this).find('.currency_symbol').text($('.currency_symbol').first().text());
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.banking_category_id').select2();
                $('.facility_type_id').select2();
                $('.select2-container').css('width', '100%');

                $(this).find('.dms_data').remove();
            },
            hide: function(deleteElement) {
                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        var deletedId = $('.jsDeletePblId').val();
                        if (deletedId != '') {
                            addOrDeleteRepeater('.pbl_repeater_row', '.pbl_row', '.delete_pbl_item',
                                'delete');
                            var ids = deletedId + ',' + $('.jsPblId', this).val();
                        } else {
                            addOrDeleteRepeater('.pbl_repeater_row', '.pbl_row', '.delete_pbl_item',
                                'delete');
                            var ids = $('.jsPblId', this).val();
                        }
                        $('.jsDeletePblId').val(ids);
                        $(this).slideUp(deleteElement);
                    }
                });
            },
        });

        if ($('.pbl_repeater_row').find('.pbl_row').length === 1) {
            $('.pbl_repeater_row').find('.delete_pbl_item').first().hide();
        } else {
            $('.pbl_repeater_row').find('.delete_pbl_item').first().show();
        }
        if($('.pbl_repeater_row').find('.pbl_row .jsPblId').val() == null) {
            $('.pbl_repeater_row').find('.delete_pbl_item').removeClass('d-none');
        } else {
            $('.pbl_repeater_row').find('.delete_pbl_item').addClass('d-none');
        }

        addOrDeleteRepeater('.pbl_repeater_row', '.pbl_row', '.delete_pbl_item', 'add', '.jsAddProposalBankingLimits');


        // Order Book and Future Projects Repeater

        var obfp_repeater_id = $('.obfp_repeater_id').val();
        if (obfp_repeater_id > 0) {
            var isObfpRepeater = false;
        } else {
            var isObfpRepeater = true;
        }

        $('#orderBookAndFutureProjectsRepeater').repeater({
            initEmpty: isObfpRepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $('.type_of_project').select2();
                $('.current_status_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
                $(this).attr('data-row-index', $(this).index());
                $(this).find('.currency_symbol').text($('.currency_symbol').first().text());
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.type_of_project').select2();
                $('.current_status_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
            },
            hide: function(deleteElement) {

                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        var deletedId = $('.jsDeleteObfpId').val();
                        if (deletedId != '') {
                            addOrDeleteRepeater('.obfp_repeater_row', '.obfp_row', '.delete_obfp_item',
                                'delete');
                            var ids = deletedId + ',' + $('.jsObfpId', this).val();
                        } else {
                            addOrDeleteRepeater('.obfp_repeater_row', '.obfp_row', '.delete_obfp_item',
                                'delete');
                            var ids = $('.jsObfpId', this).val();
                        }
                        $('.jsDeleteObfpId').val(ids);
                        $(this).slideUp(deleteElement);
                    }
                });
            },
        });
        if ($('.obfp_repeater_row').find('.obfp_row').length === 1) {
            $('.obfp_repeater_row').find('.delete_obfp_item').first().hide();
        } else {
            $('.obfp_repeater_row').find('.delete_obfp_item').first().show();
        }
        if($('.obfp_repeater_row').find('.obfp_row .jsObfpId').val() == null) {
            $('.obfp_repeater_row').find('.delete_obfp_item').removeClass('d-none');
        } else {
            $('.obfp_repeater_row').find('.delete_obfp_item').addClass('d-none');
        }

        addOrDeleteRepeater('.obfp_repeater_row', '.obfp_row', '.delete_obfp_item', 'add',
            '.jsAddOrderBookAndFutureProjects');

        // Project Track Records Repeater

        var ptr_repeater_id = $('.ptr_repeater_id').val();
        if (ptr_repeater_id > 0) {
            var isPtrRepeater = false;
        } else {
            var isPtrRepeater = true;
        }

        $('#projectTrackRecordsRepeater').repeater({
            initEmpty: isPtrRepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $('.type_of_project_track').select2();
                $('.completion_status_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
                $(this).attr('data-row-index', $(this).index());
                $(this).find('.currency_symbol').text($('.currency_symbol').first().text());
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.type_of_project_track').select2();
                $('.completion_status_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
            },
            hide: function(deleteElement) {

                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        var deletedId = $('.jsDeletePtrId').val();
                        if (deletedId != '') {
                            addOrDeleteRepeater('.ptr_repeater_row', '.ptr_row', '.delete_ptr_item',
                                'delete');
                            var ids = deletedId + ',' + $('.jsPtrId', this).val();
                        } else {
                            addOrDeleteRepeater('.ptr_repeater_row', '.ptr_row', '.delete_ptr_item',
                                'delete');
                            var ids = $('.jsPtrId', this).val();
                        }
                        $('.jsDeletePtrId').val(ids);
                        $(this).slideUp(deleteElement);
                    }
                });
            },
        });
        if ($('.ptr_repeater_row').find('.ptr_row').length === 1) {
            $('.ptr_repeater_row').find('.delete_ptr_item').first().hide();
        } else {
            $('.ptr_repeater_row').find('.delete_ptr_item').first().show();
        }
        if($('.ptr_repeater_row').find('.ptr_row .jsPtrId').val() == null) {
            $('.ptr_repeater_row').find('.delete_ptr_item').removeClass('d-none');
        } else {
            $('.ptr_repeater_row').find('.delete_ptr_item').addClass('d-none');
        }

        addOrDeleteRepeater('.ptr_repeater_row', '.ptr_row', '.delete_ptr_item', 'add', '.jsAddProjectTrackRecords');

        // Management Profiles Repeater

        var mp_repeater_id = $('.mp_repeater_id').val();
        if (mp_repeater_id > 0) {
            var isMpRepeater = false;
        } else {
            var isMpRepeater = true;
        }

        $('#managementProfilesRepeater').repeater({
            initEmpty: isMpRepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $('.designation_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
                $(this).attr('data-row-index', $(this).index());
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.designation_dropdown').select2();
                $('.select2-container').css('width', '100%');
                $(this).find('.dms_data').remove();
            },
            hide: function(deleteElement) {

                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        var deletedId = $('.jsDeleteMpId').val();
                        if (deletedId != '') {
                            addOrDeleteRepeater('.mp_repeater_row', '.mp_row', '.delete_mp_item',
                                'delete');
                            var ids = deletedId + ',' + $('.jsMpId', this).val();
                        } else {
                            addOrDeleteRepeater('.mp_repeater_row', '.mp_row', '.delete_mp_item',
                                'delete');
                            var ids = $('.jsMpId', this).val();
                        }
                        $('.jsDeleteMpId').val(ids);
                        $(this).slideUp(deleteElement);
                    }
                });
            },
        });
        if ($('.mp_repeater_row').find('.mp_row').length === 1) {
            $('.mp_repeater_row').find('.delete_mp_item').first().hide();
        } else {
            $('.mp_repeater_row').find('.delete_mp_item').first().show();
        }
        if($('.mp_repeater_row').find('.mp_row .jsMpId').val() == null) {
            $('.mp_repeater_row').find('.delete_mp_item').removeClass('d-none');
        } else {
            $('.mp_repeater_row').find('.delete_mp_item').addClass('d-none');
        }

        addOrDeleteRepeater('.mp_repeater_row', '.mp_row', '.delete_mp_item', 'add', '.jsAddManagementProfiles');

         jQuery(document).on('change', '#proposalsForm .additional_repeater_row .additional_bond_id', function() {
            //Create array of input values
            var ar = $('.additional_repeater_row .additional_bond_id').map(function() {
                if ($(this).val() != '') return $(this).val()
            }).get();

            //Create array of duplicates if there are any
            var unique = ar.filter(function(item, pos) {
                return ar.indexOf(item) != pos;
            });

            var message = "Selected bond is duplicate";
            //show/hide error msg
            if ((unique.length != 0)) {
                $('.duplicateError').removeClass('d-none');
                $('.duplicateError').text(message);
                $(this).val('').select2();
            } else {
                $('.duplicateError').addClass('d-none');
                $('.duplicateError').text('');
            }
        });

        $(document).on('change', '.JsSource', function(e) {
            var source = $(this).val();
            $(".JsUserId option").remove();
            if (source != '' && source != 'direct') {
                $('.jsSourceNameDiv').removeClass('d-none');
                $('.JsUserId').addClass('required');
                $.ajax({
                    url: '{{ route('get-soure') }}',
                    data: {
                        source: source,
                    }
                }).done(function(response) {
                    var data = [{
                        'id': '',
                        'text': '',
                        'html': ''
                    }];
                    $.each(response, function(index, value) {
                        var obj = {
                            'id': index,
                            'text': value,
                            'html': value,
                        };
                        data.push(obj);
                    });
                    $('.JsUserId').select2({
                        data: data,
                        escapeMarkup: function(m) {
                            return m;
                        }
                    });
                });
            } else {
                 $('.JsUserId').removeClass('required');
                $('.jsSourceNameDiv').addClass('d-none');
            }
        });

        $('.jsPrimaryBondStartDate').on('change', function() {
            var startDate = $(this).val();
            $('.jsPrimaryBondEndDate').attr('min', startDate);
            var endDate = $('.jsPrimaryBondEndDate').val();
            if (startDate != '' && endDate != '') {
                var daysCal = daysCalculate(startDate, endDate);
                $('.jsPrimaryPeriodOfBond').val(daysCal);
                yearCalculate(daysCal);
            }
        });
        $('.jsPrimaryBondEndDate').on('change', function() {
            var endDate = $(this).val();
            $('.jsPrimaryBondStartDate').attr('max', endDate);
            var startDate = $('.jsPrimaryBondStartDate').val();
            if (startDate != '' && endDate != '') {
                var daysCal = daysCalculate(startDate, endDate);
                $('.jsPrimaryPeriodOfBond').val(daysCal);
                yearCalculate(daysCal);
            }
        });

        $('.jsPrimaryBondIssuedDate').on('change', function() {
            var issuedDate = $(this).val();
            $('.jsPrimaryBondStartDate').attr('min', issuedDate).attr('data-msg-min',
                'Please enter a Date greater than or equal to Bond Issued Date (' + moment(issuedDate).format(
                    'DD/MM/YYYY') + ')');
        });

        function yearCalculate(days) {
            const avgDaysInYear = 365;
            const monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            // Calculate years
            const years = Math.floor(days / avgDaysInYear);
            // Calculate remaining days
            let remainingDays = days - (years * avgDaysInYear);
            // Calculate leap years
            let leapYears = 0;
            for (let i = 0; i <= years; i++) {
                if ((i % 4 === 0 && i % 100 !== 0) || i % 400 === 0) {
                    leapYears++;
                }
            }
            // Distribute remaining days across months
            let months = 0;
            let currentMonth = 0;
            while (remainingDays > monthLengths[currentMonth]) {
                remainingDays -= monthLengths[currentMonth];
                currentMonth++;
                months++;
                if (currentMonth === 1 && leapYears > 0) {
                    remainingDays--;
                    leapYears--;
                }
            }
            $('.jsPrimaryPeriodOfBondYear').val(`${years} year`);
            $('.jsPrimaryPeriodOfBondMonth').val(`${months} month`);
            $('.jsPrimaryPeriodOfBondDays').val(`${remainingDays} days`);
        }


        $(document).on('change', '.jsBondStartDate', function() {
            // var startDate = $(this).val();
            var startDateRow = $(this).closest('.additional_bond_row');

            var startDate = startDateRow.find(this).val();
            startDateRow.find('.jsBondEndDate').attr('min', startDate);
            var endDate = startDateRow.find('.jsBondEndDate').val();

            if (startDate != '' && endDate != '') {
                var daysCal = daysCalculate(startDate, endDate);
                startDateRow.find('.jsPeriodOfBond').val(daysCal);

                const avgDaysInYear = 365;
                const monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                const years = Math.floor(daysCal / avgDaysInYear);

                let remainingDays = daysCal - (years * avgDaysInYear);

                let leapYears = 0;
                for (let i = 0; i <= years; i++) {
                    if ((i % 4 === 0 && i % 100 !== 0) || i % 400 === 0) {
                        leapYears++;
                    }
                }

                let months = 0;
                let currentMonth = 0;
                while (remainingDays > monthLengths[currentMonth]) {
                    remainingDays -= monthLengths[currentMonth];
                    currentMonth++;
                    months++;
                    if (currentMonth === 1 && leapYears > 0) {
                        remainingDays--;
                        leapYears--;
                    }
                }

                startDateRow.find('.jsPeriodOfBondYear').val(`${years} year`);
                startDateRow.find('.jsPeriodOfBondMonth').val(`${months} month`);
                startDateRow.find('.jsPeriodOfBondDays').val(`${remainingDays} days`);
            }
        });
        $(document).on('change', '.jsBondEndDate', function() {
            var endDateRow = $(this).closest('.additional_bond_row');

            var endDate = endDateRow.find(this).val();
            endDateRow.find('.jsBondStartDate').attr('max', endDate);
            var startDate = endDateRow.find('.jsBondStartDate').val();

            if (startDate != '' && endDate != '') {
                var daysCal = daysCalculate(startDate, endDate);
                endDateRow.find('.jsPeriodOfBond').val(daysCal);


                const avgDaysInYear = 365;
                const monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                const years = Math.floor(daysCal / avgDaysInYear);

                let remainingDays = daysCal - (years * avgDaysInYear);

                let leapYears = 0;
                for (let i = 0; i <= years; i++) {
                    if ((i % 4 === 0 && i % 100 !== 0) || i % 400 === 0) {
                        leapYears++;
                    }
                }

                let months = 0;
                let currentMonth = 0;
                while (remainingDays > monthLengths[currentMonth]) {
                    remainingDays -= monthLengths[currentMonth];
                    currentMonth++;
                    months++;
                    if (currentMonth === 1 && leapYears > 0) {
                        remainingDays--;
                        leapYears--;
                    }
                }
                endDateRow.find('.jsPeriodOfBondYear').val(`${years} year`);
                endDateRow.find('.jsPeriodOfBondMonth').val(`${months} month`);
                endDateRow.find('.jsPeriodOfBondDays').val(`${remainingDays} days`);
            }
        });

        $(document).on('change', '.jsBondIssuedDate', function() {
            var pbrow = $(this).closest('.additional_bond_row');
            // var issuedDate = $(this).val();
            var issuedDate = pbrow.find(this).val();
            // $('.jsBondStartDate').attr('min', issuedDate).attr('data-msg-min',
            //     'Please enter a Date greater than or equal to Bond Issued Date (' + moment(issuedDate).format(
            //         'DD/MM/YYYY') + ')');
            pbrow.find('.jsBondStartDate').attr('min', issuedDate).attr('data-msg-min',
                'Please enter a Date greater than or equal to Bond Issued Date (' + moment(issuedDate).format(
                    'DD/MM/YYYY') + ')');
        });

        $(document).on('change', '.agency_rating_id', function() {
            var agency_rating_id = $(this).val();

            if (agency_rating_id > 0) {
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'agency_rating_id': agency_rating_id
                    },
                }).always(function() {

                }).done(function(response) {
                    if (response) {
                        $(".rating_remarks").val(response.remarks);
                    } else {
                        $(".rating_remarks").val('');
                    }
                });
            } else {
                $(".rating_remarks").val('');
            }
        });

        $('form').on('click', '.form_is_bank_guarantee_provided', function() {
            if($('.form_is_bank_guarantee_provided:checked').val() == 'Yes') {
                $('.isBankGuaranteeProvidedData').removeClass('d-none');
            } else {
                $('.isBankGuaranteeProvidedData').addClass('d-none');
                $('.circumstance_short_notes').val(null);
            }
        });

        $('form').on('click', '.form_is_action_against_proposer', function() {
            if($('.form_is_action_against_proposer:checked').val() == 'Yes') {
                $('.isActionAgainstProposerData').removeClass('d-none');
            } else {
                $('.isActionAgainstProposerData').addClass('d-none');
                $('.action_details').val(null);
            }
        });

        // $(document).on('change', '.jsChangeDate', function() {
        //     var startDate = $('.bond_start_date').val();
        //     // $('.bond_end_date').attr('min', startDate).attr('data-msg-min',
        //     //     'Please enter a Date greater than or equal to ' + moment(startDate).format('DD/MM/YYYY'));

        //     var endDate = $('.bond_end_date').val();
        //     // $('.bond_start_date').attr('max', endDate).attr('data-msg-max',
        //     //     'Please enter a Date less than or equal to ' + moment(endDate).format('DD/MM/YYYY'));

        //     if (startDate != '' && endDate != '') {
        //         $('.jsBondPeriod').val(daysCalculate(startDate, endDate));
        //     }
        // });

        $("#bond_start_date, #bond_end_date").change(function() {
            const startDate = $('#bond_start_date').val();
            const endDate = $('#bond_end_date').val();

            if (!startDate || !endDate) {
                $('.jsBondPeriod').val('');
                return;
            }

            $('.jsBondPeriod').val(dateDifferenceInDays(startDate, endDate));
        });

        $(document).on('change', '.jsObfpPeriod', function() {
            var obfpRow = $(this).closest('.obfp_row');

            var obfpStartDate = obfpRow.find('.obfp_project_start_date').val();
            obfpRow.find('.obfp_project_end_date');

            var obfpEndDate = obfpRow.find('.obfp_project_end_date').val();
            obfpRow.find('.obfp_project_start_date');

            if (obfpStartDate != '' && obfpEndDate != '') {
                obfpRow.find('.jsObfpProjectTenor').val(dateDifferenceInDays(obfpStartDate, obfpEndDate));
            }
        });

        $(document).on('change', '.jsPtrPeriod', function() {
            var ptrRow = $(this).closest('.ptr_row');

            var ptrStartDate = ptrRow.find('.ptr_project_start_date').val();
            ptrRow.find('.ptr_project_end_date');

            var ptrEndDate = ptrRow.find('.ptr_project_end_date').val();
            ptrRow.find('.ptr_project_start_date');

            if (ptrStartDate != '' && ptrEndDate != '') {
                ptrRow.find('.jsPtrProjectTenor').val(dateDifferenceInDays(ptrStartDate, ptrEndDate));
            }
        });

        // $(document).on('change', '.project_end_date', function() {
        //     var endDateRow = $(this).closest('.obfp_repeater_row');

        //     var endDate = endDateRow.find(this).val();
        //     endDateRow.find('.project_start_date').attr('max', endDate);
        //     var startDate = endDateRow.find('.project_start_date').val();
        //     // endDateRow.find('.project_start_date').attr('data-msg-min',
        //     //     'Please enter a Date greater than or equal to ' + moment(startDate).format('DD/MM/YYYY'));
        //     endDateRow.find('.project_end_date').attr('data-msg-max',
        //         'Please enter a Date less than or equal to opopopopopop' + moment(endDate).format('DD/MM/YYYY'));

        //     if (startDate != '' && endDate != '') {
        //         var daysCal = daysCalculate(startDate, endDate);
        //         endDateRow.find('.jsProjectTenor').val(daysCal);
        //     }
        // });

        // $(document).on('change', '.project_start_date', function() {
        //     // var startDate = $(this).val();
        //     var startDateRow = $(this).closest('.obfp_repeater_row');

        //     var startDate = startDateRow.find(this).val();
        //     startDateRow.find('.project_end_date').attr('min', startDate);
        //     var endDate = startDateRow.find('.project_end_date').val();
        //     // startDateRow.find('.project_end_date').attr('data-msg-max',
        //     //     'Please enter a Date less than or equal to ' + moment(endDate).format('DD/MM/YYYY'));
        //     startDateRow.find('.project_start_date').attr('data-msg-min',
        //         'Please enter a Date greater than or equal to tytytytyty' + moment(startDate).format('DD/MM/YYYY'));

        //     if (startDate != '' && endDate != '') {
        //         var daysCal = daysCalculate(startDate, endDate);
        //         startDateRow.find('.jsProjectTenor').val(daysCal);
        //     }
        // });

        $(".bond_wording_file").on("change", function(){
            var selectedFiles = $(".bond_wording_file").get(0).files.length;
            var numFiles = $(".count_bond_wording_file").attr('data-count_bond_wording_file');
            var autoFetched = numFiles.length == 0 ? 0 : parseInt(numFiles);
            var totalFiles = selectedFiles + autoFetched;
            $('.count_bond_wording_file').text(totalFiles + ' document');
        });

        $(".delete_group").on("click", function(){
            var filePrefix = $(this).attr('data-prefix');
            if(filePrefix == 'bond_wording_file'){
                remainingFiles = $(".bond_wording_file").get(0).files.length - 1;
                $('.count_bond_wording_file').text(remainingFiles + ' document');
            }
        });

        // Proposal Documents Count

        var pImages = {};
        $(document).on('click', '.jsShowProposalDocument', function() {

            var _pDiv = $(this).closest('.jsDivClass');
            var _pThs = $('.jsDocument', _pDiv)[0];
            var _pPrefix = $(this).attr('data-prefix');
            var _pDeletePrefix = $(this).attr('data-delete');
            var pOldCount = $('.length_' + _pPrefix).attr('data-' + _pPrefix);
            // alert(pOldCount);

            pImages[_pPrefix] = [];

            var length = _pThs.files.length;
            if (length > 0 || pOldCount > 0) {
                setTimeout(function() {
                    $('.jsFileRemove').html('');
                    var htmlData = '';
                    for (var i = 0; i < length; i++) {
                        var file = _pThs.files[i];
                        var icon = getdmsFileIcon(file.name);

                        pImages[_pPrefix].push(file);
                        htmlData += '<span class="pip_' + _pPrefix + '_' + i + '">' + icon + '&nbsp;' + file.name +
                            ' <a type="button" class="delete_proposal_document" value="Delete" data-imgno="' + i +
                            '" data-prefix="' + _pPrefix +
                            '" data-delete="' + _pDeletePrefix +
                            '" data-clicked="" download>  <i class="flaticon2-cross small"></i></a></span><br>';
                    }

                    $('.jsFileRemove').html(htmlData);
                    var total = parseFloat(length) + parseFloat(pOldCount);

                    $('.length_' + _pPrefix).html(total);

                }, 1000);
            } else {
                setTimeout(function() {
                    $('.delete_proposal_document').attr('data-delete', _pDeletePrefix)
                }, 1000);
            }
        });

        $(document).on('click', '.delete_proposal_document', function() {

            var pImgIndex = $(this).attr('data-imgno');
            var pImgPrefix = $(this).attr('data-prefix');
            var pDeleteName = $(this).attr('data-delete');

            var pImgName = $(this).attr('data-name');

            if (pImgName != undefined) {
                var _pThs = $('.' + pDeleteName);

                var imgs = (_pThs.val() != undefined) ? _pThs.val().split(",") : [];
                imgs.push(pImgName);
                _pThs.val(imgs.join(','));

            }

            pImages[pImgPrefix].splice(pImgIndex, 1);

            $(this).parent(".pip_" + pImgPrefix + '_' + pImgIndex).remove();

            var dt = new DataTransfer();
            var pInputData = document.getElementById(pImgPrefix);
            // console.log(pInputData);

            const {
                files
            } = pInputData;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (pImgIndex != i) {
                    dt.items.add(file);
                }
            }
            pInputData.files = dt.files;
            $(".jsDocument").trigger('change');

        });

        // Proposal Repeater Documents Count

        var repeaterProposalImages = {};

        $(document).on('click', '.jsRepeaterProposalShowDocument', function() {
            var rowName = $(this).attr('data-repeater-row');
            var modalType = $(this).attr('data-modal');
            var repeaterItem = $(this).closest('.' + rowName);
            var _rDiv = repeaterItem.find('.jsDivClass');
            var _rThs = repeaterItem.find('.jsDocument')[0];
            var _rPrefix = $(this).attr('data-prefix');
            var _rDeletePrefix = $(this).attr('data-delete');
            var rOldCount = repeaterItem.find('.length_' + _rPrefix).attr('data-' + _rPrefix);
            // console.log(repeaterItem.attr('data-row-index'));
            var rowIndex = repeaterItem.attr('data-row-index');

            repeaterProposalImages[_rPrefix] = [];

            var rLength = _rThs.files.length;

            if (rLength > 0 || rOldCount > 0) {
                setTimeout(function() {
                    repeaterItem.find('.jsFileRemove').html('');
                    var rHtmlData = '';

                    for (var i = 0; i < rLength; i++) {
                        var file = _rThs.files[i];
                        var icon = getdmsFileIcon(file.name);

                        repeaterProposalImages[_rPrefix].push(file);
                        rHtmlData += '<span class="pip_' + _rPrefix + '_' + i + '">' + icon + '&nbsp;' + file.name +
                            ' <a type="button" class="repeater_proposal_delete_group" value="Delete" data-row-Name="' + rowName + '" data-row-Index="' + rowIndex + '" data-imgno="' + i +
                            '" data-prefix="' + _rPrefix +
                            '" data-delete="' + _rDeletePrefix +
                            '" download>  <i class="flaticon2-cross small"></i></a></span><br>';
                    }

                    if(modalType == 'p'){
                        repeaterItem.find('.jsFileRemove').html(rHtmlData);
                    } else {
                        $('.jsFileRemove').html(rHtmlData);
                    }

                    // repeaterItem.find('.jsFileRemove').html(rHtmlData);
                    // $('.jsFileRemove').html(rHtmlData);

                    var total = parseFloat(rLength) + parseFloat(rOldCount);
                    repeaterItem.find('.length_' + _rPrefix).html(total);
                }, 1000);
            } else {
                setTimeout(function() {
                    repeaterItem.find('.repeater_proposal_delete_group').attr('data-delete', _rDeletePrefix);
                }, 1000);
            }
        });

        $(document).on('click', '.repeater_proposal_delete_group', function() {

            var rImgIndex = $(this).attr('data-imgno');
            var rImgPrefix = $(this).attr('data-prefix');
            var rDeleteName = $(this).attr('data-delete');
            var rImgName = $(this).attr('data-name');
            var rRowName = $(this).attr('data-row-Name');

            var repeaterItem = $('.' + rImgPrefix).closest('.' + rRowName);
            var rowIndex = $(this).attr('data-row-index');

            // var matchingRow = repeaterItem.parent().find('.pbl_row[data-row-index="' + rowIndex + '"]');
            var matchingRow = repeaterItem.parent().find('.' + rRowName + '[data-row-index="' + rowIndex + '"]');

            // var matchingRow = repeaterItem.find('.pbl_row[data-row-index="' + rowIndex + '"]');


            if (rImgName !== undefined) {
                var _rThs = matchingRow.find('.' + rDeleteName);

                var imgs = (_rThs.val() !== undefined) ? _rThs.val().split(",") : [];
                imgs.push(rImgName);
                _rThs.val(imgs.join(','));
            }

            repeaterProposalImages[rImgPrefix].splice(rImgIndex, 1);

            $(this).parent('.pip_' + rImgPrefix + '_' + rImgIndex).find('[data-row-Index="' + rowIndex + '"]').prevObject.remove();

            var dt = new DataTransfer();
            var rInputData = matchingRow.find('#' + rImgPrefix)[0];

            const { files } = rInputData;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (rImgIndex != i) {
                    dt.items.add(file);
                }
            }

            // var remainingLength = matchingRow.find('.jsDocument')[0].files.length - 1;
            var remainingLength = matchingRow.find('.count_' + rImgPrefix).attr('data-count_' + rImgPrefix) - 1;
            // var autoFetchedFilesRepeater = auto.length == 0 ? 0 : parseInt(auto);

            matchingRow.find('.count_' + rImgPrefix).text(remainingLength);
            // matchingRow.find('.count_' + rImgPrefix).attr('data-count_' + rImgPrefix, remainingLength);

            rInputData.files = dt.files;

            matchingRow.find(".jsDocument").trigger('change');
        });

    </script>

    @include('proposals.scripts.beneficiary_script')
    @include('proposals.scripts.contractor_script')
    @include('proposals.scripts.project_details_script')
    @include('proposals.scripts.tender_script')
    {{-- {!! ajax_fill_dropdown('contractor_country_id', 'contractor_state_id', route('get-states')) !!} --}}
    {{-- {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!} --}}
@endpush
