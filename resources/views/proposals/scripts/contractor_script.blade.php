@push('scripts')
    <script type="text/javascript">
        $(document).on('change', '.contractor_id', function() {
            let contractor_id = $(this).val();

            if (contractor_id.length === 0) {
                contractorFields.forEach(field => {
                    $("." + field).val("");
                    $("." + field).prop('readonly', false).removeClass(
                        'form-control-solid');
                });
                $("#full_name").val('');
                $('.contractor_same_as_above').prop('checked', false).trigger('change');
                $('.showAdverseInformation').addClass('d-none');
                $('.showBlacklistInformation').addClass('d-none');
            }

            if (contractor_id > 0) {
                let ajaxUrl = $(this).attr('data-ajaxurl');

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'contractor_id': contractor_id,
                    },
                }).always(function() {

                }).done(function({
                    contractor_detail,
                    banking_limits,
                    order_book_and_future_projects,
                    project_track_records,
                    management_profiles,
                    contact_detail,
                    trade_sector,
                    dmsData,
                    states,
                    documentCount,
                    agencyData,
                    stand_alone_adverse_information,
                    stand_alone_blacklist_information,
                }) {
                    // console.log(response);
                    if (contractor_detail) {
                        // console.log(documentCount);
                        contractorFields.forEach(field => {
                            $("." + field).val(contractor_detail[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('.stand_alone_pan_no').val(contractor_detail.pan_no);

                        $('input[name="is_bank_guarantee_provided"][value="' + contractor_detail
                            .is_bank_guarantee_provided + '"]').prop(
                            'checked', true);

                        $('input[name="is_action_against_proposer"][value="' + contractor_detail
                            .is_action_against_proposer + '"]').prop(
                            'checked', true);

                        if (contractor_detail.is_bank_guarantee_provided == 'No') {
                            $('.isBankGuaranteeProvidedData').addClass('d-none');
                        }

                        if (contractor_detail.is_action_against_proposer == 'No') {
                            $('.isActionAgainstProposerData').addClass('d-none');
                        }

                        $('.pbl_repeater_row').html(banking_limits);
                        $('.obfp_repeater_row').html(order_book_and_future_projects);
                        $('.ptr_repeater_row').html(project_track_records);
                        $('.mp_repeater_row').html(management_profiles);
                        $('.contactDetailSector').html(contact_detail);
                        $('.tradeSector').html(trade_sector);
                        $('.ratingDetails').html(agencyData);
                        // $('.jsDocumentDiv').html(dmsData);

                        var cID = contractor_detail.id;

                        $('.JsCompanyDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_details').attr('data-count_company_details', documentCount.company_details).text(typeof(documentCount.company_details) == "undefined" ? 0 + ' document' : documentCount.company_details + ' document');

                        $('.JsCompanyTechnicalDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_technical_details').attr('data-count_company_technical_details', documentCount.company_technical_details).text(typeof(documentCount.company_technical_details) == "undefined" ? 0 + ' document' : documentCount.company_technical_details + ' document');

                        $('.JsCompanyPresentation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_presentation').attr('data-count_company_presentation', documentCount.company_presentation).text(typeof(documentCount.company_presentation) == "undefined" ? 0 + ' document' : documentCount.company_presentation + ' document');

                        $('.JsCertificateofIncorporation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_certificate_of_incorporation').attr('data-count_certificate_of_incorporation', documentCount.certificate_of_incorporation).text(typeof(documentCount.certificate_of_incorporation) == "undefined" ? 0 + ' document' : documentCount.certificate_of_incorporation + ' document');

                        $('.JsMemorandumAndArticles').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_memorandum_and_articles').attr('data-count_memorandum_and_articles', documentCount.memorandum_and_articles).text(typeof(documentCount.memorandum_and_articles) == "undefined" ? 0 + ' document' : documentCount.memorandum_and_articles + ' document');

                        $('.JsGstCertificate').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_gst_certificate').attr('data-count_gst_certificate', documentCount.gst_certificate).text(typeof(documentCount.gst_certificate) == "undefined" ? 0 + ' document' : documentCount.gst_certificate + ' document');

                        $('.JsCompanyPanNo').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_pan_no').attr('data-count_company_pan_no', documentCount.company_pan_no).text(typeof(documentCount.company_pan_no) == "undefined" ? 0 + ' document' : documentCount.company_pan_no + ' document');

                        $('.JsLastThreeYearsItr').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_last_three_years_itr').attr('data-count_last_three_years_itr', documentCount.last_three_years_itr).text(typeof(documentCount.last_three_years_itr) == "undefined" ? 0 + ' document' : documentCount.last_three_years_itr + ' document');

                        // console.log(bankingLimitDmsCount);
                        // bankingLimitDmsCount.forEach(item => {
                        //     // console.log(item);
                        //     $('.JsProposalBankingLimitsAttachment').attr('data-url', decodeURIComponent("{{ route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'proposal_banking_limits_attachment', 'dmsable_type' => 'BankingLimits']) }}".replace('__ID__', item)));
                        // });

                        // $('.JsProposalBankingLimitsAttachment').attr('data-url', decodeURIComponent("{{ route('AutoFetchdMSDocument', ['id' => '223', 'attachment_type' => 'banking_limits_attachment', 'dmsable_type' => 'BankingLimits']) }}"));

                        // $('.contractor_state_id').html(states);
                        // $('select[name="contractor_state_id"]').empty().append(states);

                        $('select[name="contractor_country_id"]').val(contractor_detail.country_id).trigger('change');

                        // $('select[name="contractor_state_id"]').val(contractor_detail.state_id).trigger('change');
                        if(states){
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(states.states, function(id, name) {

                                // if (contractor_detail.state_id > 0 && id == contractor_detail.state_id) {
                                //     var selected = true;
                                // } else {
                                //     var selected = false;
                                // }

                                var obj = {
                                    'id': id,
                                    'text': name,
                                    'html': name,
                                    // "selected": selected
                                };
                                data.push(obj);
                            });
                            $(".contractor_state_id").select2({
                                data: data,
                                // templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (contractor_detail.state_id > 0) {
                                $('select[name="contractor_state_id"]').val(contractor_detail.state_id).trigger('change');
                            }
                        }

                        if ($('#contractor_country_id option:selected').text().toLowerCase() != 'india') {
                            $('.contractorGstAndPanNoFields').addClass('d-none');
                            // $('.contractor_gst_no').removeClass('required');
                            $('.contractor_pan_no').removeClass('required');
                        }

                        $('select[name="principle_type_id"]').val(contractor_detail.principle_type_id)
                            .trigger(
                                'change');

                        $('select[name="contractor_entity_type_id"]').val(contractor_detail.contractor_entity_type_id)
                            .trigger('change');
                        // $('select[name="principle_type_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');
                        // $('select[name="agency_id"]').val(contractor_detail.agency_id).trigger(
                        //     'change');
                        // $('select[name="agency_rating_id"]').val(contractor_detail.agency_rating_id)
                        //     .trigger(
                        //         'change');

                        // $('input[name="is_jv"][value="' + contractor_detail.is_jv + '"]').prop('checked', true);
                        // if (contractor_detail.is_jv == 'No'){
                        //     $('.contractRepeater').addClass('d-none');
                        // }

                        $('.contractor_same_as_above').prop('checked', false).trigger('change');
                        
                        $('.showAdverseInformation').removeClass('d-none');
                        $('.stand_alone_adverse_information').html(stand_alone_adverse_information);
                        $('.showBlacklistInformation').removeClass('d-none');
                        $('.stand_alone_blacklist_information').html(stand_alone_blacklist_information);
                        $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                    } else {
                        contractorFields.forEach(field => {
                            $("." + field).val("");
                            $("." + field).prop('readonly', false).removeClass(
                                'form-control-solid');
                        });
                        $("#full_name").val('');
                        $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                    }
                })
            }
        });

        const attchamentTypes = [
            'company_details',
            'company_technical_details',
            'company_presentation',
            'certificate_of_incorporation',
            'memorandum_and_articles',
            'gst_certificate',
            'company_pan_no',
            'last_three_years_itr',
        ];
        attchamentTypes.forEach(item => {
            $("." + item).on("change", function(){
                var selectedFiles = $("." + item).get(0).files.length;
                var numFiles = $(".count_" + item).attr('data-count_' + item);
                var autoFetched = numFiles.length == 0 ? 0 : parseInt(numFiles);
                var totalFiles = selectedFiles + autoFetched;
                $('.count_' + item).text(totalFiles + ' document');
            });

            $(".delete_proposal_document").on("click", function(){
                var filePrefix = $(this).attr('data-prefix');
                if(filePrefix == item){
                    remainingFiles = $("." + item).get(0).files.length - 1;
                    $('.count_' + item).text(remainingFiles + ' document');
                }
            });
        });

        $(document).on('change', '.banking_limits_attachment', function () {
            let currentInput = $(this);
            countProposalRepeaterDocuments(currentInput ,'pbl_row', 'banking_limits_attachment');
        });

        $(document).on('change', '.order_book_and_future_projects_attachment', function () {
            let currentInput = $(this);
            countProposalRepeaterDocuments(currentInput ,'obfp_row', 'order_book_and_future_projects_attachment');
        });

        $(document).on('change', '.project_track_records_attachment', function () {
            let currentInput = $(this);
            countProposalRepeaterDocuments(currentInput ,'ptr_row', 'project_track_records_attachment');
        });

        $(document).on('change', '.management_profiles_attachment', function () {
            let currentInput = $(this);
            countProposalRepeaterDocuments(currentInput ,'mp_row', 'management_profiles_attachment');
        });

        function countProposalRepeaterDocuments(input, itemRow, attachment) {
            var fileInput = input;
            var fileCount = input.get(0).files.length;

            var countDisplay = fileInput.closest('.' + itemRow).find('.count_' + attachment);

            var getFiles = countDisplay.attr('data-count_' + attachment);

            // if($('.repeater_proposal_delete_group').length != 0){
            //     getFiles = countDisplay.removeAttr('data-count_' + attachment);
            //     getFiles = 0;
            // }
            var autoFetchedFiles = getFiles.length == 0 ? 0 : parseInt(getFiles);

            totalCount = fileCount + autoFetchedFiles;


            if (countDisplay.length) {
                countDisplay.text(totalCount + ' document');
                // countDisplay.attr('data-count_' + attachment, totalCount);
            }
        }

        // $(document).on('change', '.banking_limits_attachment', function () {
        //     var fileInput = $(this);
        //     var fileCount = this.files.length;
        //     console.log($(this));
        //     console.log(this);

        //     var countDisplay = fileInput.closest('.pbl_row').find('.count_banking_limits_attachment');

        //     var getFiles = countDisplay.attr('data-count_banking_limits_attachment');
        //     var autoFetchedFiles = getFiles.length == 0 ? 0 : parseInt(getFiles);

        //     totalCount = fileCount + autoFetchedFiles;
        //     // console.log(totalCount);

        //     if (countDisplay.length) {
        //         countDisplay.text(totalCount + ' file(s) selected');
        //         countDisplay.attr('data-count_banking_limits_attachment', totalCount);
        //     }
        // });

        const contractorFields = [
            'first_name',
            'middle_name',
            'last_name',
            'register_address',
            'date_of_incorporation',
            'parent_group_name',
            'contractor_company_name',
            'circumstance_short_notes',
            'action_details',
            'contractor_failed_project_details',
            'completed_rectification_details',
            'performance_security_details',
            'relevant_other_information',
            'registration_no',
            'contractor_website',
            'contractor_city',
            'contractor_pincode',
            'contractor_pan_no',
            'contractor_gst_no',
            'contractor_email',
            'contractor_mobile',
            'rating_remarks',
            // 'contractor_inception_date',
            'contractor_staff_strength',
            'rating_date',
        ];

        var id = $('#id').val();
        if (id > 0) {
            var isrepeater = false;
            $('.JsSourceId').select2({
                allowClear: true
            });
        } else {
            var isrepeater = true;
        }

        // jQuery.validator.addMethod("maxShareHolding", function(value, element) {
        //     var is_spv = $('.form_is_spv:checked').val();
        //     if (is_spv == 'Yes') {
        //         var totalShareHold = 0;
        //         $(".share_holding").each(function(index, sval) {
        //             var sharehold = $(this).val();
        //             if ($(this).val() > 0) {
        //                 totalShareHold += parseFloat(sharehold);
        //             }
        //         })
        //         return (totalShareHold <= 100);
        //     }
        // }, "Total share holding must be only 100%.");

        // $('#jv_repeater_contractor').repeater({
        //     initEmpty: isrepeater,

        //     defaultValues: {
        //         'text-input': 'foo'
        //     },

        //     show: function() {
        //         $(this).find('.list-no').text($(this).index() + 1 + ' .');
        //         var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
        //         var contractor_id = $("." + contractor_type + "_contractor").find(':selected').val();
        //         if (contractor_id > 0) {
        //             var contractor_rows = $(this).closest("." + contractor_type + "_contractor_rows");
        //             getContractorJvFullDetail(contractor_id, contractor_type, contractor_rows);
        //         }
        //         $('.select2-container').css('width', '100%');
        //         $(this).slideDown();
        //     },

        //     hide: function(deleteElement) {
        //         message.fire({
        //             title: 'Are you sure',
        //             text: "You want to delete this ?",
        //             type: 'warning',
        //             customClass: {
        //                 confirmButton: 'btn btn-success shadow-sm mr-2',
        //                 cancelButton: 'btn btn-danger shadow-sm'
        //             },
        //             buttonsStyling: false,
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, delete it!',
        //             cancelButtonText: 'No, cancel!',
        //         }).then((result) => {
        //             if (result.value) {
        //                 var jv_contractor = $(this).find('.jv_contractor_id').val();
        //                 $(".jv_contractor option[value='" + jv_contractor + "']").attr(
        //                     'disabled',
        //                     false);
        //                 $(this).slideUp(deleteElement);
        //                 setTimeout(function() {
        //                     $('.list-no').each(function(index) {
        //                         $(this).html(index + 1);
        //                     });
        //                 }, 500);
        //             }
        //         });
        //     },
        //     ready: function(setIndexes) {
        //         $('.select2-container').css('width', '100%');
        //     },
        //     isFirstItemUndeletable: true
        // });
        $('#spv_repeater_contractor').repeater({
            initEmpty: isrepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.list-no').text($(this).index() + 1 + ' .');
                $(this).find('.spv_adverse_information').attr('data-index-adverse-info-spv', $(this).index() - 1 + 1);
                $(this).find('.spv_blacklist_information').attr('data-index-blacklist-info-spv', $(this).index() - 1 + 1);
                // var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
                // var contractor_id = $("." + contractor_type + "_contractor").find(':selected').val();
                // if (contractor_id > 0) {
                //     var contractor_rows = $(this).closest("." + contractor_type + "_contractor_rows");
                //     getContractorSpvFullDetail(contractor_id, contractor_type, contractor_rows);
                // }

                // var spvRowsLength = $('.spv_contractor_rows').length;
                // if(spvRowsLength >= 1) {
                //     $('.spv_contractor').removeClass('required');
                // }

                $('.select2-container').css('width', '100%');
                $('.spv_count').val($(this).index());
                $(this).slideDown();
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
                        var spv_contractor = $(this).find('.spv_contractor_id').val();
                        $(".spv_contractor option[value='" + spv_contractor + "']").attr(
                            'disabled',
                            false);
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {
                $('.select2-container').css('width', '100%');
            },
            isFirstItemUndeletable: true
        });

        // $('#spv_repeater_contractor').repeater({
        //     initEmpty: isrepeater,

        //     defaultValues: {
        //         'text-input': 'foo'
        //     },

        //     show: function() {
        //         $(this).find('.list-no').text($(this).index() + 1 + ' .');
        //         $('.select2-container').css('width', '100%');
        //         $('.spv_count').val($(this).index());
        //         $(this).slideDown();
        //     },

        //     hide: function(deleteElement) {
        //         message.fire({
        //             title: 'Are you sure',
        //             text: "You want to delete this ?",
        //             type: 'warning',
        //             customClass: {
        //                 confirmButton: 'btn btn-success shadow-sm mr-2',
        //                 cancelButton: 'btn btn-danger shadow-sm'
        //             },
        //             buttonsStyling: false,
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, delete it!',
        //             cancelButtonText: 'No, cancel!',
        //         }).then((result) => {
        //             if (result.value) {
        //                 var spv_contractor = $(this).find('.spv_contractor_id').val();
        //                 $(".spv_contractor option[value='" + spv_contractor + "']").attr(
        //                     'disabled',
        //                     false);
        //                 $(this).slideUp(deleteElement);
        //                 setTimeout(function() {
        //                     $('.list-no').each(function(index) {
        //                         $(this).html(index + 1);
        //                     });
        //                 }, 500);
        //             }
        //         });
        //     },
        //     ready: function(setIndexes) {
        //         $('.select2-container').css('width', '100%');
        //     },
        //     isFirstItemUndeletable: true
        // });
        $('#jv_repeater_contractor').repeater({
            initEmpty: isrepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.list-no').text($(this).index() + 1 + ' .');
                $(this).find('.jv_adverse_information').attr('data-index-adverse-info', $(this).index() - 1 + 1);
                $(this).find('.jv_blacklist_information').attr('data-index-blacklist-info', $(this).index() - 1 + 1);
                $('.select2-container').css('width', '100%');
                $('.jv_count').val($(this).index());
                $(this).slideDown();
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
                        var jv_contractor = $(this).find('.jv_contractor_id').val();
                        $(".jv_contractor option[value='" + jv_contractor + "']").attr(
                            'disabled',
                            false);
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {
                $('.select2-container').css('width', '100%');
            },
            isFirstItemUndeletable: true
        });

        $(document).on('keyup', '.jv_share_holding,.spv_share_holding, .tender_bond_value', function() {
            calculateJvExposure();
        });

        function calculateJvExposure() {
            var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
            var bond_value = $(".tender_bond_value").val();
            $("." + contractor_type + "_share_holding").each(function() {
                var jv_contractor_rows = $(this).closest('.' + contractor_type + '_contractor_rows');
                var share_holding = $(this).val();
                if (bond_value > 0 && share_holding > 0) {
                    var jv_exposure = parseFloat(bond_value) * (parseFloat(share_holding) / 100);
                    jv_contractor_rows.find('.' + contractor_type + '_exposure').val(numberFormatPrecision(jv_exposure, 0));
                } else {
                    jv_contractor_rows.find('.' + contractor_type + '_exposure').val('0');
                }
            });
        }

        $('#kt_repeater_contractor').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.list-no').text($(this).index() + 1 + ' .');
                $(this).find('.JvSpvContractorId').select2({
                    allowClear: true
                });
                $(this).find('.JvSpvContractorId').addClass('required');
                $(this).find('.share_holding').addClass('required');
                $('.select2-container').css('width', '100%');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {
                $('.JvSpvContractorId').select2({
                    allowClear: true
                });
                $('.select2-container').css('width', '100%');
            },
            isFirstItemUndeletable: true
        });

        var contact_item_id = $('.contact_item_id').val();
        if (contact_item_id > 0) {
            var isContactDetailRepeater = false;
        } else {
            var isContactDetailRepeater = true;
        }

        $('#contactDetailRepeater').repeater({
            initEmpty: isContactDetailRepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.contact-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.contact-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: true
        });

        // $(document).on('change', '.form_is_spv', function() {
        //     var is_spv = $('.form_is_spv:checked').val();
        //     if (is_spv == 'Yes') {
        //         $(".contractRepeater").removeClass('d-none');
        //         $('.JvSpvContractorId').addClass('required');
        //         $('.share_holding').addClass('required');
        //     } else {
        //         $(".contractRepeater").addClass('d-none');
        //         $('.JvSpvContractorId').removeClass('required');
        //         $('.share_holding').removeClass('required');
        //     }
        // });
        // $(document).on('change', '.form_is_jv', function() {
        //     var is_jv = $('.form_is_jv:checked').val();
        //     if (is_jv == 'Yes') {
        //         $(".contractRepeater").removeClass('d-none');
        //         $('.JvSpvContractorId').addClass('required');
        //         $('.share_holding').addClass('required');
        //     } else {
        //         $(".contractRepeater").addClass('d-none');
        //         $('.JvSpvContractorId').removeClass('required');
        //         $('.share_holding').removeClass('required');
        //     }
        // });

        jQuery(document).on('change', '#proposalsForm .contractor_data_rows .JvSpvContractorId', function() {
            var ar = $('.contractor_data_rows .JvSpvContractorId').map(function() {
                if ($(this).val() != '') return $(this).val()
            }).get();

            var unique = ar.filter(function(item, pos) {
                return ar.indexOf(item) != pos;
            });

            var message = "Selected contractor is duplicate";
            if ((unique.length != 0)) {
                $('.duplicateError').removeClass('d-none');
                $('.duplicateError').text(message);
                $(this).val('').select2();
            } else {
                $('.duplicateError').addClass('d-none');
                $('.duplicateError').text('');
            }
        });

        $(document).on('change', '.JvSpvContractorId', function() {
            var contractor_id = $(this).val();
            var contractor_data_rows = $(this).closest('.contractor_data_rows');
            if (contractor_id > 0) {
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'contractor_id': contractor_id
                    },
                }).always(function() {

                }).done(function(response) {
                    if (response) {
                        contractor_data_rows.find(".contractor_pan_no").val(response.pan_no);
                        contractor_data_rows.find(".contractor_pan_no");
                    } else {
                        contractor_data_rows.find(".contractor_pan_no").val('');
                        contractor_data_rows.find(".contractor_pan_no").prop('readonly', false);
                    }
                });
            } else {
                contractor_data_rows.find(".contractor_pan_no").val('');
                contractor_data_rows.find(".share_holding").val('');
            }
        });

        $('#tradeSectorRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.trade-list-no').text($(this).index() + 1 + ' .');
                $('.contractor_trade_sector').select2({
                    allowClear: true,
                });
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.trade-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },

            ready: function(setIndexes) {
                $('.contractor_trade_sector').select2({
                    allowClear: true,
                });
            },
            isFirstItemUndeletable: true

        });

        $('.JvSpvContractorId').select2({
            allowClear: true
        });

        $(document).on("change", ".contractor_is_main", function() {
            $('.contractor_is_main').each(function() {
                $(this).prop("checked", "").removeClass('required');
            });
            $(this).prop("checked", "checked").addClass('required');
        });

        // function checkExitTradeSector(_this = '') {
        //     var tradeSector = _this.val();
        //     var isExits = false
        //     $('.trade_sector').each(function(key, value) {
        //         if (!_this.is($(this))) {
        //             if ($(this).val() == tradeSector) {
        //                 isExits = true;
        //             }
        //         }
        //     });
        //     return isExits;
        // }

        // $(document).on("change", ".trade_sector", function() {
        //     var _ths = $(this);
        //     var dataRow = $(this).closest('.trade_sector_row');
        //     if (checkExitTradeSector(_ths)) {
        //         $(".item-dul-error").removeClass('d-none')
        //         dataRow.find(".jsTradeSector").val('').select2({
        //             allowClear: true,
        //         });
        //     } else {
        //         $(".item-dul-error").addClass('d-none')
        //     }
        // });

        function errorMessage(err_message) {
            message.fire({
                title: '',
                text: err_message,
                type: 'warning',
                customClass: {
                    confirmButton: 'btn btn-success shadow-sm mr-2',
                },
                buttonsStyling: false,
                showCancelButton: false,
                confirmButtonText: 'OK',
            }).then((result) => {

            });
        }

        // $(document).on('change', '.from', function() {
        //     var row = $(this).closest('.trade_sector_row');
        //     var fromDate = moment(row.find('.from').val()).format('DD/MM/YYYY');
        //     row.find('.till').attr('data-msg-min', "Please enter a value greater than or equal to " +
        //         fromDate);
        // });

        $(document).on('change', '.jv_contractor', function() {
            $('#jv_repeater_contractor tbody').html('');
        });

        $(document).on('change', '.spv_contractor', function() {
            $('#spv_repeater_contractor tbody').html('');
        });

        $(document).on('change', '.contractor_type', function() {
            var contractor_type = $(this).val();
            if (contractor_type == 'SPV') {
                $('.spv_contractor').addClass('required');
                $('.jv_contractor').removeClass('required');
                $(".spvCls").removeClass('d-none');
                //$(".jv_contractor_rows").find(':input').addClass('required');
                //$(".spv_contractor_rows input").removeClass('required');
                $(".standaloneCls").addClass('d-none');
                $(".jvCls").addClass('d-none');
                $(".jvClsData").addClass('d-none');
                $(".jv_contractor option").attr('disabled', false);
                $('#jv_repeater_contractor tbody').html('');
                $('.JsNotJvSpv').prop('readonly', false).removeClass('form-control-solid');
                $(".standaloneCls .pan_no").val('');
                $('.tenderDetail').removeClass('d-none');
                $('.jsClearContractorType').val('');
                $('.jsClearContractorType').val('').trigger('change');
                $('.pbl_repeater_row .jsClearContractorType').val('');
                $('.obfp_repeater_row .jsClearContractorType').val('');
                $('.ptr_repeater_row .jsClearContractorType').val('');
                $('.mp_repeater_row .jsClearContractorType').val('');
                $('.contactDetailSector .jsClearContractorType').val('');
                $('.tradeSector .jsClearContractorType').val('');
                $('.jsAgencyDetails .jsClearContractorType').val('');
                $('.jsShowIsJV').addClass('d-none');
                $('.contractRepeater').addClass('d-none');
                // $('.beneficiary_id').attr('disabled', true);
                // $('.project_details').attr('disabled', true);
                // $('.second_tender').attr('disabled', true);
                $('.contractor_id').removeClass('required');
            } else if (contractor_type == 'JV') {
                $('.jv_contractor').addClass('required');
                $('.spv_contractor').removeClass('required');
                $(".spvCls").addClass('d-none');
                //$(".jv_contractor_rows input").removeClass('required');
                //$(".spv_contractor_rows input").addClass('required');
                $(".spvClsData").addClass('d-none');
                $(".spv_contractor option").attr('disabled', false);
                $('#spv_repeater_contractor tbody').html('');
                $(".standaloneCls").addClass('d-none');
                $(".jvCls").removeClass('d-none');
                $('.JsNotJvSpv').prop('readonly', false).removeClass('form-control-solid');
                $(".standaloneCls .pan_no").val('');
                $('.tenderDetail').removeClass('d-none');
                $('.jsClearContractorType').val('');
                $('.jsClearContractorType').val('').trigger('change');
                $('.pbl_repeater_row .jsClearContractorType').val('');
                $('.obfp_repeater_row .jsClearContractorType').val('');
                $('.ptr_repeater_row .jsClearContractorType').val('');
                $('.mp_repeater_row .jsClearContractorType').val('');
                $('.contactDetailSector .jsClearContractorType').val('');
                $('.tradeSector .jsClearContractorType').val('');
                $('.jsAgencyDetails .jsClearContractorType').val('');
                $('.jsShowIsJV').removeClass('d-none');
                $('.contractRepeater').removeClass('d-none');
                // $('.beneficiary_id').attr('disabled', true);
                // $('.project_details').attr('disabled', true);
                // $('.second_tender').attr('disabled', true);
                $('.contractor_id').removeClass('required');
            } else {
                $('.jv_contractor').removeClass('required');
                $('.spv_contractor').removeClass('required');
                $(".contractor_id").addClass('required');
                // $(".pan_no").addClass('required');
                //$(".jv_contractor_rows input").removeClass('required');
                //$(".spv_contractor_rows input").removeClass('required');
                $(".jvCls").addClass('d-none');
                $(".jvClsData").addClass('d-none');
                $(".standaloneCls").removeClass('d-none');
                $(".spvCls").addClass('d-none');
                $(".spvClsData").addClass('d-none');
                $(".spv_contractor option").attr('disabled', false);
                $(".jv_contractor option").attr('disabled', false);
                $('#jv_repeater_contractor tbody').html('');
                $('#spv_repeater_contractor tbody').html('');
                $('.tenderDetail').addClass('d-none');
                $('#tender_details_id').removeClass('required');
                $('.stand_alone_tender_bond_value').removeClass('required');
                $('.jsClearContractorType').val('');
                $('.jsClearContractorType').val('').trigger('change');
                $('.pbl_repeater_row .jsClearContractorType').val('');
                $('.obfp_repeater_row .jsClearContractorType').val('');
                $('.ptr_repeater_row .jsClearContractorType').val('');
                $('.mp_repeater_row .jsClearContractorType').val('');
                $('.contactDetailSector .jsClearContractorType').val('');
                $('.tradeSector .jsClearContractorType').val('');
                $('.jsAgencyDetails .jsClearContractorType').val('');
                $('.jsShowIsJV').addClass('d-none');
                $('.contractRepeater').addClass('d-none');
                // $('.beneficiary_id').attr('disabled', false);
                // $('.project_details').attr('disabled', false);
                // $('.second_tender').attr('disabled', false);
            }

            if (contractor_type != 'Stand Alone') {
                $("#first_name, #middle_name, #last_name").on('keyup', function() {
                    let fullName = $("#first_name").val() + " " + $("#middle_name").val() + " " + $(
                        "#last_name").val();
                    $("#full_name").val(fullName).addClass(
                        'form-control-solid');
                });
            }
        })

        let contractor_id = $('.contractor_type').val();

        if (contractor_id != 'Stand Alone') {
            $('.first_name, .middle_name, .last_name').on('keyup', function() {
                let fullName = $("#first_name").val() + " " + $("#middle_name").val() + " " + $(
                    "#last_name").val();
                $("#full_name").val(fullName).addClass('form-control-solid');
            });
        }

        $(document).on('click', '.contAdd', function() {
            var contractArr = [];
            var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
            var contractor_id = $("." + contractor_type + "_contractor").find(':selected').val();

            $(".contractCls").removeClass('required');
            if (contractor_id > 0 && contractor_type == 'spv') {
                $("." + contractor_type + "ClsData").removeClass('d-none');
                // $("." + contractor_type + "RepeaterAdd").click();
                // $("." + contractor_type + "_contractor_rows input:not(:hidden)").addClass('required');
                contractArr.push(parseInt(contractor_id));
                getContractorSpvFullDetail(contractArr, contractor_type);
            }
            if (contractor_id > 0 && contractor_type == 'jv') {
                $("." + contractor_type + "ClsData").removeClass('d-none');
                contractArr.push(parseInt(contractor_id));
                getContractorJvFullDetail(contractArr, contractor_type);
            }
        });

        $(document).on('change', '.contractor_id', function() {
            var contractor_id = $(this).val();
            if (contractor_id > 0) {
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'contractor_id': contractor_id
                    },
                }).always(function() {

                }).done(function(response) {
                    if (response) {
                        $(".pan_no").val(response.pan_no);
                    } else {
                        $(".pan_no").val('');
                    }
                });
            }
        });

        function getContractorJvFullDetail(contractIdsArr, contractor_type) {
            // if (contractIdsArr.length === 0) {
            //     contractorFields.forEach(field => {
            //         $("." + field).val("");
            //         $("." + field).prop('readonly', false).removeClass(
            //             'form-control-solid');
            //     });
            //     $("#full_name").val('');
            //     $('.contractor_same_as_above').prop('checked', false).trigger('change');
            // }

            var ajaxUrl = $("." + contractor_type + "_contractor").attr('data-ajaxurl');
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                data: {
                    'contractor_id': contractIdsArr,
                    'contractor_type': contractor_type
                },
            }).always(function() {

            }).done(function({
                contractor_detail,
                banking_limits,
                order_book_and_future_projects,
                project_track_records,
                management_profiles,
                contact_detail,
                trade_sector,
                // jv_details,
                dmsData,
                states,
                agencyData,
                documentCount,
                adverse_information,
                blacklist_information,
            }) {
                // var totalLength = contractor_detail.length;
                var contractor_id = $("." + contractor_type + "_contractor").find(':selected').val();
                if (contractor_type == 'jv' && contractor_detail) {
                    $("#jv_repeater_contractor .table tr.jv_contractor_rows").remove();
                    jQuery.each(contractor_detail.contractor_item, function(conkey, conrow) {
                        $("." + contractor_type + "RepeaterAdd").click();
                        var company_name = conrow.contractor.company_name;
                        var panNo = conrow.contractor.pan_no;
                        var jv_share_holding = conrow.share_holding;
                        if (panNo) {
                            jQuery("input[name='jvContractorDetails[" + conkey + "][jv_pan_no]']")
                                .val(
                                    panNo);
                            jQuery("input[name='jvContractorDetails[" + conkey + "][jv_pan_no]']")
                                .removeClass('required');
                        }
                        jQuery("input[name='jvContractorDetails[" + conkey +
                                "][jv_contractor_name]']")
                            .val(company_name);
                        jQuery("input[name='jvContractorDetails[" + conkey +
                                "][jv_share_holding]']").val(jv_share_holding);
                        jQuery("input[name='jvContractorDetails[" + conkey +
                            "][jv_contractor_id]']").val(conrow.contractor_id);
                            
                        $('.jv_adverse_information[data-index-adverse-info = "' + conkey + '"]').html(adverse_information[conkey]);
                        $('.jv_blacklist_information[data-index-blacklist-info = "' + conkey + '"]').html(blacklist_information[conkey]);
                    });

                        contractorFields.forEach(field => {
                            $("." + field).val(contractor_detail[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('input[name="is_bank_guarantee_provided"][value="' + contractor_detail
                            .is_bank_guarantee_provided + '"]').prop(
                            'checked', true);

                        $('input[name="is_action_against_proposer"][value="' + contractor_detail
                            .is_action_against_proposer + '"]').prop(
                            'checked', true);

                        if (contractor_detail.is_bank_guarantee_provided == 'No') {
                            $('.isBankGuaranteeProvidedData').addClass('d-none');
                        }

                        if (contractor_detail.is_action_against_proposer == 'No') {
                            $('.isActionAgainstProposerData').addClass('d-none');
                        }

                        $('.pbl_repeater_row').html(banking_limits);
                        $('.obfp_repeater_row').html(order_book_and_future_projects);
                        $('.ptr_repeater_row').html(project_track_records);
                        $('.mp_repeater_row').html(management_profiles);
                        $('.contactDetailSector').html(contact_detail);
                        $('.tradeSector').html(trade_sector);
                        // $('.contractorDetails').html(jv_details);
                        $('.jsAutoFetch').html(dmsData);
                        // $('.jsAgencyDetails').html(agencyData);
                        $('.ratingDetails').html(agencyData);

                        var cID = contractor_detail.id;

                        $('.JsCompanyDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_details').attr('data-count_company_details', documentCount.company_details).text(typeof(documentCount.company_details) == "undefined" ? 0 + ' document' : documentCount.company_details + ' document');

                        $('.JsCompanyTechnicalDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_technical_details').attr('data-count_company_technical_details', documentCount.company_technical_details).text(typeof(documentCount.company_technical_details) == "undefined" ? 0 + ' document' : documentCount.company_technical_details + ' document');

                        $('.JsCompanyPresentation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_presentation').attr('data-count_company_presentation', documentCount.company_presentation).text(typeof(documentCount.company_presentation) == "undefined" ? 0 + ' document' : documentCount.company_presentation + ' document');

                        $('.JsCertificateofIncorporation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_certificate_of_incorporation').attr('data-count_certificate_of_incorporation', documentCount.certificate_of_incorporation).text(typeof(documentCount.certificate_of_incorporation) == "undefined" ? 0 + ' document' : documentCount.certificate_of_incorporation + ' document');

                        $('.JsMemorandumAndArticles').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_memorandum_and_articles').attr('data-count_memorandum_and_articles', documentCount.memorandum_and_articles).text(typeof(documentCount.memorandum_and_articles) == "undefined" ? 0 + ' document' : documentCount.memorandum_and_articles + ' document');

                        $('.JsGstCertificate').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_gst_certificate').attr('data-count_gst_certificate', documentCount.gst_certificate).text(typeof(documentCount.gst_certificate) == "undefined" ? 0 + ' document' : documentCount.gst_certificate + ' document');

                        $('.JsCompanyPanNo').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_pan_no').attr('data-count_company_pan_no', documentCount.company_pan_no).text(typeof(documentCount.company_pan_no) == "undefined" ? 0 + ' document' : documentCount.company_pan_no + ' document');

                        $('.JsLastThreeYearsItr').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_last_three_years_itr').attr('data-count_last_three_years_itr', documentCount.last_three_years_itr).text(typeof(documentCount.last_three_years_itr) == "undefined" ? 0 + ' document' : documentCount.last_three_years_itr + ' document');

                        $('select[name="contractor_country_id"]').val(contractor_detail.country_id).trigger(
                            'change');

                        if(states){
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(states.states, function(id, name) {

                                // if (contractor_detail.state_id > 0 && id == contractor_detail.state_id) {
                                //     var selected = true;
                                // } else {
                                //     var selected = false;
                                // }

                                var obj = {
                                    'id': id,
                                    'text': name,
                                    'html': name,
                                    // "selected": selected
                                };
                                data.push(obj);
                            });
                            $(".contractor_state_id").select2({
                                data: data,
                                // templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (contractor_detail.state_id > 0) {
                                $('select[name="contractor_state_id"]').val(contractor_detail.state_id).trigger('change');
                            }
                        }

                        if ($('#contractor_country_id option:selected').text().toLowerCase() != 'india') {
                            $('.contractorGstAndPanNoFields').addClass('d-none');
                            // $('.contractor_gst_no').removeClass('required');
                            $('.contractor_pan_no').removeClass('required');
                        }

                        $('select[name="principle_type_id"]').val(contractor_detail.principle_type_id)
                            .trigger(
                                'change');

                        $('select[name="contractor_entity_type_id"]').val(contractor_detail.contractor_entity_type_id)
                            .trigger('change');

                        $('select[name="agency_id"]').val(contractor_detail.agency_id).trigger(
                            'change');
                        $('select[name="agency_rating_id"]').val(contractor_detail.agency_rating_id)
                            .trigger('change');

                        // $('input[name="is_jv"][value="' + contractor_detail.is_jv + '"]').prop('checked', true);

                        $('.contractor_same_as_above').prop('checked', false).trigger('change');
                        $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                } else {
                    dataRows.find("." + contractor_type + "_pan_no").val('');
                    dataRows.find("." + contractor_type + "_contractor_name").val('');
                    dataRows.find("." + contractor_type + "_contractor_id").val('');
                    $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                }
            });
        }

        function getContractorSpvFullDetail(contractIdsArr, contractor_type) {
            var ajaxUrl = $("." + contractor_type + "_contractor").attr('data-ajaxurl');
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                data: {
                    'contractor_id': contractIdsArr,
                    'contractor_type': contractor_type
                },
            }).always(function() {

            }).done(function({
                contractor_detail,
                banking_limits,
                order_book_and_future_projects,
                project_track_records,
                management_profiles,
                contact_detail,
                trade_sector,
                dmsData,
                states,
                agencyData,
                documentCount,
                adverse_information,
                blacklist_information,
            }){
                // var totalLength = contractor_detail.length;
                var contractor_id = $("." + contractor_type + "_contractor").find(':selected').val();
                if (contractor_type == 'spv' && contractor_detail) {
                    $("#spv_repeater_contractor .table tr.spv_contractor_rows").remove();
                    jQuery.each(contractor_detail.contractor_item, function(conkey, conrow) {
                        $("." + contractor_type + "RepeaterAdd").click();
                        var company_name = conrow.contractor.company_name;
                        var panNo = conrow.contractor.pan_no;
                        var spv_share_holding = conrow.share_holding;
                        if (panNo) {
                            jQuery("input[name='spvContractorDetails[" + conkey + "][spv_pan_no]']")
                                .val(
                                    panNo);
                            jQuery("input[name='spvContractorDetails[" + conkey + "][spv_pan_no]']")
                                .removeClass('required');
                        }
                        jQuery("input[name='spvContractorDetails[" + conkey +
                                "][spv_contractor_name]']")
                            .val(company_name);
                        jQuery("input[name='spvContractorDetails[" + conkey +
                            "][spv_contractor_id]']").val(conrow.contractor_id);
                        jQuery("input[name='spvContractorDetails[" + conkey + "][spv_share_holding]']").val(spv_share_holding);
                            
                        $('.spv_adverse_information[data-index-adverse-info = "' + conkey + '"]').html(adverse_information[conkey]);
                        $('.spv_blacklist_information[data-index-blacklist-info = "' + conkey + '"]').html(blacklist_information[conkey]);
                    });

                        contractorFields.forEach(field => {
                            $("." + field).val(contractor_detail[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('input[name="is_bank_guarantee_provided"][value="' + contractor_detail
                            .is_bank_guarantee_provided + '"]').prop(
                            'checked', true);

                        $('input[name="is_action_against_proposer"][value="' + contractor_detail
                            .is_action_against_proposer + '"]').prop(
                            'checked', true);

                        if (contractor_detail.is_bank_guarantee_provided == 'No') {
                            $('.isBankGuaranteeProvidedData').addClass('d-none');
                        }

                        if (contractor_detail.is_action_against_proposer == 'No') {
                            $('.isActionAgainstProposerData').addClass('d-none');
                        }

                        $('.pbl_repeater_row').html(banking_limits);
                        $('.obfp_repeater_row').html(order_book_and_future_projects);
                        $('.ptr_repeater_row').html(project_track_records);
                        $('.mp_repeater_row').html(management_profiles);
                        $('.contactDetailSector').html(contact_detail);
                        $('.tradeSector').html(trade_sector);
                        // $('.contractorDetails').html(spv_details);
                        $('.jsAutoFetch').html(dmsData);
                        // $('.jsAgencyDetails').html(agencyData);
                        $('.ratingDetails').html(agencyData);

                        var cID = contractor_detail.id;

                        $('.JsCompanyDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_details').attr('data-count_company_details', documentCount.company_details).text(typeof(documentCount.company_details) == "undefined" ? 0 + ' document' : documentCount.company_details + ' document');

                        $('.JsCompanyTechnicalDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_technical_details').attr('data-count_company_technical_details', documentCount.company_technical_details).text(typeof(documentCount.company_technical_details) == "undefined" ? 0 + ' document' : documentCount.company_technical_details + ' document');

                        $('.JsCompanyPresentation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_presentation').attr('data-count_company_presentation', documentCount.company_presentation).text(typeof(documentCount.company_presentation) == "undefined" ? 0 + ' document' : documentCount.company_presentation + ' document');

                        $('.JsCertificateofIncorporation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_certificate_of_incorporation').attr('data-count_certificate_of_incorporation', documentCount.certificate_of_incorporation).text(typeof(documentCount.certificate_of_incorporation) == "undefined" ? 0 + ' document' : documentCount.certificate_of_incorporation + ' document');

                        $('.JsMemorandumAndArticles').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_memorandum_and_articles').attr('data-count_memorandum_and_articles', documentCount.memorandum_and_articles).text(typeof(documentCount.memorandum_and_articles) == "undefined" ? 0 + ' document' : documentCount.memorandum_and_articles + ' document');

                        $('.JsGstCertificate').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_gst_certificate').attr('data-count_gst_certificate', documentCount.gst_certificate).text(typeof(documentCount.gst_certificate) == "undefined" ? 0 + ' document' : documentCount.gst_certificate + ' document');

                        $('.JsCompanyPanNo').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_company_pan_no').attr('data-count_company_pan_no', documentCount.company_pan_no).text(typeof(documentCount.company_pan_no) == "undefined" ? 0 + ' document' : documentCount.company_pan_no + ' document');

                        $('.JsLastThreeYearsItr').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
                        $('.count_last_three_years_itr').attr('data-count_last_three_years_itr', documentCount.last_three_years_itr).text(typeof(documentCount.last_three_years_itr) == "undefined" ? 0 + ' document' : documentCount.last_three_years_itr + ' document');

                        $('select[name="contractor_country_id"]').val(contractor_detail.country_id).trigger(
                            'change');

                        if(states){
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(states.states, function(id, name) {

                                // if (contractor_detail.state_id > 0 && id == contractor_detail.state_id) {
                                //     var selected = true;
                                // } else {
                                //     var selected = false;
                                // }

                                var obj = {
                                    'id': id,
                                    'text': name,
                                    'html': name,
                                    // "selected": selected
                                };
                                data.push(obj);
                            });
                            $(".contractor_state_id").select2({
                                data: data,
                                // templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (contractor_detail.state_id > 0) {
                                $('select[name="contractor_state_id"]').val(contractor_detail.state_id).trigger('change');
                            }
                        }

                        if ($('#contractor_country_id option:selected').text().toLowerCase() != 'india') {
                            $('.contractorGstAndPanNoFields').addClass('d-none');
                            // $('.contractor_gst_no').removeClass('required');
                            $('.contractor_pan_no').removeClass('required');
                        }

                        $('select[name="principle_type_id"]').val(contractor_detail.principle_type_id)
                            .trigger(
                                'change');

                        $('select[name="contractor_entity_type_id"]').val(contractor_detail.contractor_entity_type_id)
                            .trigger('change');

                        $('select[name="agency_id"]').val(contractor_detail.agency_id).trigger(
                            'change');
                        $('select[name="agency_rating_id"]').val(contractor_detail.agency_rating_id)
                            .trigger('change');

                        // $('input[name="is_jv"][value="' + contractor_detail.is_jv + '"]').prop('checked', true);

                        $('.contractor_same_as_above').prop('checked', false).trigger('change');
                        $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                } else {
                    dataRows.find("." + contractor_type + "_pan_no").val('');
                    dataRows.find("." + contractor_type + "_contractor_name").val('');
                    dataRows.find("." + contractor_type + "_contractor_id").val('');
                    $('.parent_group_name').attr('readonly', true).addClass('form-control-solid');
                }
            });

            // var spvRowsLength = $('.spv_contractor_rows').length;
            // var ajaxUrl = $("." + contractor_type + "_contractor").attr('data-ajaxurl');

            // // if (contractor_id.length === 0) {
            // //     contractorFields.forEach(field => {
            // //         $("." + field).val("");
            // //         $("." + field).prop('readonly', false).removeClass(
            // //             'form-control-solid');
            // //     });
            // //     $("#full_name").val('');
            // //     $('.contractor_same_as_above').prop('checked', false).trigger('change');
            // // }

            // $.ajax({
            //     type: "GET",
            //     url: ajaxUrl,
            //     data: {
            //         'contractor_id': contractor_id,
            //         'contractor_type': contractor_type
            //     },
            // }).always(function() {

            // }).done(function({
            //     contractor_detail,
            //     banking_limits,
            //     order_book_and_future_projects,
            //     project_track_records,
            //     management_profiles,
            //     contact_detail,
            //     trade_sector,
            //     dmsData,
            //     states,
            //     agencyData,
            //     documentCount,
            //     adverse_information,
            //     blacklist_information,
            // }) {

            //     // var totalLength = response.length;
            //     if (contractor_detail) {
            //         if (contractor_detail.pan_no) {
            //             dataRows.find("." + contractor_type + "_pan_no").val(contractor_detail.pan_no);
            //             dataRows.find("." + contractor_type + "_pan_no").removeClass('required');
            //         }
            //         dataRows.find("." + contractor_type + "_contractor_name").val(contractor_detail.company_name);
            //         dataRows.find("." + contractor_type + "_contractor_id").val(contractor_detail.id);
            //         $("." + contractor_type + "_contractor").val('').change();
            //         $("." + contractor_type + "_contractor option[value='" + contractor_detail.id + "']").attr(
            //             'disabled',
            //             true);

            //         $('.spv_adverse_information[data-index-adverse-info-spv = "' + dataRows.index() + '"]').html(adverse_information);
            //         $('.spv_blacklist_information[data-index-blacklist-info-spv = "' + dataRows.index() + '"]').html(blacklist_information);

            //         if(spvRowsLength > 1){
            //             $('.spv_contractor').removeClass('required');
            //         }

            //         if(spvRowsLength == 1){
            //             contractorFields.forEach(field => {
            //                 $("." + field).val(contractor_detail[field]);
            //                 // $("." + field).addClass('form-control-solid');
            //             });

            //             $('.pbl_repeater_row').html(banking_limits);
            //             $('.obfp_repeater_row').html(order_book_and_future_projects);
            //             $('.ptr_repeater_row').html(project_track_records);
            //             $('.mp_repeater_row').html(management_profiles);
            //             $('.contactDetailSector').html(contact_detail);
            //             $('.tradeSector').html(trade_sector);
            //             $('.jsAutoFetch').html(dmsData);
            //             // $('.jsAgencyDetails').html(agencyData);
            //             $('.ratingDetails').html(agencyData);

            //             var cID = contractor_detail.id;

            //             $('.JsCompanyDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_company_details').attr('data-count_company_details', documentCount.company_details).text(typeof(documentCount.company_details) == "undefined" ? 0 + ' document' : documentCount.company_details + ' document');

            //             $('.JsCompanyTechnicalDetails').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_company_technical_details').attr('data-count_company_technical_details', documentCount.company_technical_details).text(typeof(documentCount.company_technical_details) == "undefined" ? 0 + ' document' : documentCount.company_technical_details + ' document');

            //             $('.JsCompanyPresentation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_company_presentation').attr('data-count_company_presentation', documentCount.company_presentation).text(typeof(documentCount.company_presentation) == "undefined" ? 0 + ' document' : documentCount.company_presentation + ' document');

            //             $('.JsCertificateofIncorporation').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_certificate_of_incorporation').attr('data-count_certificate_of_incorporation', documentCount.certificate_of_incorporation).text(documentCount.certificate_of_incorporation + ' document');

            //             $('.JsMemorandumAndArticles').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_memorandum_and_articles').attr('data-count_memorandum_and_articles', documentCount.memorandum_and_articles).text(documentCount.memorandum_and_articles + ' document');

            //             $('.JsGstCertificate').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_gst_certificate').attr('data-count_gst_certificate', documentCount.gst_certificate).text(documentCount.gst_certificate + ' document');

            //             $('.JsCompanyPanNo').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_company_pan_no').attr('data-count_company_pan_no', documentCount.company_pan_no).text(documentCount.company_pan_no + ' document');

            //             $('.JsLastThreeYearsItr').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Principle']) !!}".replace('__ID__', cID)));
            //             $('.count_last_three_years_itr').attr('data-count_last_three_years_itr', documentCount.last_three_years_itr).text(documentCount.last_three_years_itr + ' document');

            //             $('input[name="is_bank_guarantee_provided"][value="' + contractor_detail
            //                 .is_bank_guarantee_provided + '"]').prop(
            //                 'checked', true);

            //             $('input[name="is_action_against_proposer"][value="' + contractor_detail
            //                 .is_action_against_proposer + '"]').prop(
            //                 'checked', true);

            //             if (contractor_detail.is_bank_guarantee_provided == 'No') {
            //                 $('.isBankGuaranteeProvidedData').addClass('d-none');
            //             }

            //             if (contractor_detail.is_action_against_proposer == 'No') {
            //                 $('.isActionAgainstProposerData').addClass('d-none');
            //             }

            //             $('select[name="contractor_country_id"]').val(contractor_detail.country_id).trigger('change');

            //             if(states){
            //                 var options = '';
            //                 var data = [{
            //                     'id': '',
            //                     'text': '',
            //                     'html': '',
            //                 }];
            //                 $.each(states.states, function(id, name) {

            //                     // if (contractor_detail.state_id > 0 && id == contractor_detail.state_id) {
            //                     //     var selected = true;
            //                     // } else {
            //                     //     var selected = false;
            //                     // }

            //                     var obj = {
            //                         'id': id,
            //                         'text': name,
            //                         'html': name,
            //                         // "selected": selected
            //                     };
            //                     data.push(obj);
            //                 });
            //                 $(".contractor_state_id").select2({
            //                     data: data,
            //                     // templateResult: selectTemplate,
            //                     escapeMarkup: function(m) {
            //                         return m;
            //                     },
            //                 });

            //                 if (contractor_detail.state_id > 0) {
            //                     $('select[name="contractor_state_id"]').val(contractor_detail.state_id).trigger('change');
            //                 }
            //             }

            //             if ($('#contractor_country_id option:selected').text().toLowerCase() != 'india') {
            //                 $('.contractorGstAndPanNoFields').addClass('d-none');
            //                 $('.contractor_gst_no').removeClass('required');
            //                 $('.contractor_pan_no').removeClass('required');
            //             }

            //             $('select[name="principle_type_id"]').val(contractor_detail.principle_type_id)
            //                 .trigger(
            //                     'change');

            //             $('select[name="contractor_entity_type_id"]').val(contractor_detail.contractor_entity_type_id)
            //                     .trigger('change');

            //             $('select[name="agency_id"]').val(contractor_detail.agency_id).trigger(
            //                 'change');
            //             $('select[name="agency_rating_id"]').val(contractor_detail.agency_rating_id).trigger(
            //                 'change');

            //             // $('input[name="is_jv"][value="' + contractor_detail.is_jv + '"]').prop('checked', true);
            //             // if (contractor_detail.is_jv == 'No'){
            //             //     $('.contractRepeater').addClass('d-none');
            //             // }

            //             $('.contractor_same_as_above').prop('checked', false).trigger('change');
            //         }
            //     } else {
            //         dataRows.find("." + contractor_type + "_pan_no").val('');
            //         dataRows.find("." + contractor_type + "_contractor_name").val('');
            //         dataRows.find("." + contractor_type + "_contractor_id").val('');
            //     }
            // });
        }

        // $(document).on('keyup', '.assign_exposure', function() {
        //     var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
        //     var dataRows = $(this).closest('.' + contractor_type + '_contractor_rows');
        //     var assign_exposure = dataRows.find('.' + contractor_type + '_assign_exposure').val();
        //     var bond_value = $(".tender_bond_value").val();
        //     if (assign_exposure > 0 && bond_value > 0) {
        //         var consumed = parseFloat(bond_value) * parseFloat(assign_exposure);
        //         dataRows.find('.' + contractor_type + '_consumed').val(consumed);
        //         var spare_capacity = dataRows.find('.' + contractor_type + '_spare_capacity').val();
        //         if (spare_capacity > 0 && consumed > 0) {
        //             var remaining_cap = parseFloat(spare_capacity) - parseFloat(consumed);
        //             dataRows.find('.' + contractor_type + '_remaining_cap').val(remaining_cap);
        //         } 
        //     } else {
        //         dataRows.find('.' + contractor_type + '_consumed').val('');
        //         dataRows.find('.' + contractor_type + '_remaining_cap').val('');
        //     }
        // });

        $(document).on('keyup', '.assign_exposure,.tender_bond_value,.spare_capacity', function() {
            var contractor_type = $(".contractor_type").find(':selected').val().toLowerCase();
            var dataRows = $(this).closest('.' + contractor_type + '_contractor_rows');
            var assign_exposure = dataRows.find('.' + contractor_type + '_assign_exposure').val();
            var bond_value = $(".tender_bond_value").val();
            if (assign_exposure > 0 && bond_value > 0) {
                var consumed = parseFloat(bond_value) * parseFloat(assign_exposure);
                dataRows.find('.' + contractor_type + '_consumed').val(consumed);
                var spare_capacity = dataRows.find('.' + contractor_type + '_spare_capacity').val();
                if (spare_capacity > 0 && consumed > 0) {
                    var remaining_cap = parseFloat(spare_capacity) - parseFloat(consumed);
                    dataRows.find('.' + contractor_type + '_remaining_cap').val(remaining_cap);
                }
            } else {
                dataRows.find('.' + contractor_type + '_consumed').val('');
                dataRows.find('.' + contractor_type + '_remaining_cap').val('');
            }
        });

        // $(document).on('change', '.agency_id', function() {
        //     var agency_id = $(this).val();

        //     if (agency_id > 0) {
        //         var ajaxUrl = $(this).attr('data-ajaxurl');
        //         $.ajax({
        //             type: "GET",
        //             url: ajaxUrl,
        //             data: {
        //                 'agency_id': agency_id
        //             },
        //         }).always(function() {

        //         }).done(function({html}) {
        //             // console.log(agencyData);
        //             if (html) {
        //                 $('.jsAgencyDetails').html(html);
        //             }
        //         });
        //     } else {
        //     }
        // });

        $(document).on('change','.contractor_country_id', function(){
            getstates('contractor_country_id', 'contractor_state_id');
        });

        $(document).on('change','.contractor_bond_country_id', function(){
            getstates('contractor_bond_country_id', 'contractor_bond_state_id');
        });

        let isCountryIndiaContractor = () => {
            let countryContractor = $('#contractor_country_id').find("option:selected").text();
            let countryContractorId = $('#contractor_country_id').val();

            if (countryContractorId.length > 0) {
                if (countryContractor.toLowerCase() == 'india') {
                    $('.contractorGstAndPanNoFields').removeClass('d-none');
                    // $('.contractor_gst_no').addClass('required');
                    $('.contractor_pan_no').addClass('required');
                } else {
                    $('.contractorGstAndPanNoFields').addClass('d-none');
                    // $('.contractor_gst_no').val('');
                    $('.contractor_pan_no').removeClass('required').val('');
                }
            }
        }

        let isCountryIndiaContractorBond = () => {
            let countryContractorBond = $('#contractor_bond_country_id').find("option:selected").text();
            let countryContractorIdBond = $('#contractor_bond_country_id').val();

            if (countryContractorIdBond.length > 0) {
                if (countryContractorBond.toLowerCase() == 'india') {
                    $('.contractorBondGstNo').removeClass('d-none');
                    // $('.contractor_bond_gst_no').addClass('required');
                } else {
                    $('.contractorBondGstNo').addClass('d-none');
                    // $('.contractor_bond_gst_no').val('');
                }
            }
        }

        $(document).on('select2:select', '#contractor_country_id', function() {
            isCountryIndiaContractor();
            var countryNameContractor = $('#contractor_country_id').find("option:selected").text();
            checkPinCodeValidation('jsPinCodeContractor', 'contractor_pincode', countryNameContractor);
        });

        $(document).on('select2:select', '#contractor_bond_country_id', function() {
            isCountryIndiaContractorBond();
            var countryNameContractorBond = $('#contractor_bond_country_id').find("option:selected").text();
            checkPinCodeValidation('jsPinCodeContractorBond', 'contractor_bond_pincode', countryNameContractorBond);
        });

        $(document).on('change', '.first_tender', function() {
            var firstTenderID = $(this).val();
            $('.second_tender').val(firstTenderID).trigger('change.select2');
        });

        $(document).on('change', '.second_tender', function() {
            var secondTenderID = $(this).val();
            $('.first_tender').val(secondTenderID).trigger('change.select2');
        });

        $(document).on('change', '.contractor_same_as_above', function() {
            var same_as_above = $('.contractor_same_as_above:checked').val();
            if(same_as_above == 'Yes'){
                console.log($('.register_address').val());
                $('.contractor_bond_address').val($('.register_address').val()).addClass('form-control-solid').attr('readonly', true);
                $('.contractor_bond_city').val($('.contractor_city').val()).addClass('form-control-solid').attr('readonly', true);
                $('.contractor_bond_pincode').val($('.contractor_pincode').val()).addClass('form-control-solid').attr('readonly', true);
                $('.contractor_bond_gst_no').val($('.contractor_gst_no').val()).addClass('form-control-solid').attr('readonly', true);
                $('select[name="contractor_bond_country_id"]').val($('.contractor_country_id').val()).trigger('change').attr('disabled', true);

                if ($('#contractor_bond_country_id option:selected').text().toLowerCase() != 'india') {
                    $('.contractorBondGstNo').addClass('d-none');
                    // $('.contractor_bond_gst_no').removeClass('required');
                }

                var contractor_bond_state_id = "";
                var countryId= $('.contractor_bond_country_id').val();
                $(".contractor_bond_state_id option").remove();
                if(countryId > 0){
                    $.ajax({
                        url: '{{route("get-states")}}',
                        type: 'POST',
                        data: {
                            'country_id': countryId
                        },
                        success: function(res) {
                            if (res) {
                                console.log(res);
                                var options = '';
                                var data = [{
                                    'id': '',
                                    'text': '',
                                    'html': '',
                                }];
                                $.each(res, function(id,name) {

                                    if (contractor_bond_state_id > 0 && id == contractor_bond_state_id) {
                                        var selected = true;
                                    } else {
                                        var selected = false;
                                    }

                                    var obj = {
                                        'id': id,
                                        'text': name,
                                        'html': name,
                                        "selected": selected
                                    };
                                    data.push(obj);
                                });
                                $(".contractor_bond_state_id").select2({
                                    data: data,
                                    // templateResult: selectTemplate,
                                    escapeMarkup: function(m) {
                                        return m;
                                    },
                                });

                                if ($('.contractor_state_id').val() > 0) {
                                    $(".contractor_bond_state_id").val($('.contractor_state_id').val()).trigger("change").attr('disabled', true);
                                }
                            }
                        }
                    });
                }
            } else {
                $('.contractor_bond_address').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.contractor_bond_city').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.contractor_bond_pincode').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.contractor_bond_gst_no').val('').removeClass('form-control-solid').attr('readonly', false);
                $('select[name="contractor_bond_country_id"]').val('').trigger('change').attr('disabled', false);
                $('select[name="contractor_bond_state_id"]').val('').trigger('change').attr('disabled', false);
            }
        });

        function checkExitContractorTradeSector(_this = '') {
            var tradeSector = _this.val();
            var isExits = false
            $('.contractor_trade_sector').each(function(key, value) {
                if (!_this.is($(this))) {
                    if ($(this).val() == tradeSector) {
                        isExits = true;
                    }
                }
            });
            return isExits;
        }

        $(document).on("change", ".contractor_trade_sector", function() {
            var _ths = $(this);
            var dataRow = $(this).closest('.contractor_trade_sector_row');
            if (checkExitContractorTradeSector(_ths)) {
                $(".item-dul-error").removeClass('d-none')
                dataRow.find(".jsTradeSector").val('').select2({
                    allowClear: true,
                });
            } else {
                $(".item-dul-error").addClass('d-none')
            }
        });

        $(document).on('change', '#contractor_country_id', function(){
            getCountryCurrencySymbol($(this));
        });

        function checkExitContractorAgency(_this = '') {
            var agency = _this.val();
            var isExits = false
            $('.item_agency_id').each(function(key, value) {
                if (!_this.is($(this))) {
                    if ($(this).val() == agency) {
                        isExits = true;
                    }
                }
            });
            return isExits;
        }

        $(document).on('change', '.agency_id', function() {
            var agency_id = $(this).val();

            var _ths = $(this);
            var dataRow = $(this).closest('.rating_detail_row');
            if (checkExitContractorAgency(_ths)) {
                $(".item-dul-error").removeClass('d-none');
                $(this).val(null).trigger('change');
                $('.rating_id').removeClass('required');
                // agency_id.val(null);
                $(".jsSelectRating").addClass('invisible');
            } else {
                $(".item-dul-error").addClass('d-none');
                $(".jsSelectRating").removeClass('invisible');
            }
            if (agency_id.length == 0) {
                $(".rating_id").removeClass('required');
            }

            var rating_id = '';
            // $('.jsSelectRating').removeClass('d-none');
            if (agency_id > 0) {
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'agency_id': agency_id
                    },
                    success: function(res) {
                        $(".rating_id").addClass('required');
                        $('.jsIsAgency').removeClass('d-none');
                        if (res) {
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(res, function(id,rating) {
                                if (rating_id > 0 && id == rating_id) {
                                    var selected = true;
                                } else {
                                    var selected = false;
                                }
                                var obj = {
                                    'id': id,
                                    'text': rating,
                                    'html': rating,
                                    "selected": selected
                                };
                                data.push(obj);
                            });
                            $(".rating_id").select2({
                                data: data,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (rating_id > 0) {
                                $(".rating_id").val(rating_id).trigger("change");
                            }
                        }
                    }
                });
            } else {
                
            }
        });

        function getRatingDetail(rating_id, dataRows){
            var ajaxUrl = $(".rating_id").attr('data-ajaxurl');
            $(".agency_id").val(null);
            // console.log($(".agency_id").val(null));
            $.ajax({
                url: ajaxUrl,
                type: "GET",
                data: {
                    'rating_id' : rating_id,
                },
            }).always(function() {

            }).done(function({ratingDetails}) {
                if (ratingDetails) {
                    dataRows.find(".rating").val(ratingDetails.rating);
                    dataRows.find(".agency_name").val(ratingDetails.agency_name);
                    dataRows.find(".item_agency_id").val(ratingDetails.agency_id);
                    dataRows.find(".rating_remarks").val(ratingDetails.remarks);
                    dataRows.find(".item_rating_id").val(ratingDetails.rating_id);
                    dataRows.find(".rating_date").val($(".item_rating_date").val());
                    $(".agency_id option[value='" + ratingDetails.agency_id + "']").attr('disabled', true);
                    // console.log($(".agency_id option:selected"));
                    $(".agency_id").val('').trigger('change');
                    $(".rating_id").html('').trigger('change').removeClass('required');
                    $(".item_rating_date").val('');
                    // $(".item_rating_date").addClass('required');
                    $('.jsIsAgency').addClass('d-none');
                    $(".rating_detail_create").prop('disabled', true);
                    $('.jsSelectRating').addClass('invisible');
                } else {
                    dataRows.find(".rating").val('');
                    dataRows.find(".agency_name").val('');
                    dataRows.find(".item_agency_id").val('');
                    dataRows.find(".rating_remarks").val('');
                    dataRows.find(".item_rating_id").val('');
                }
            });
        }

        // $(document).on('change', '.rating_id', function(){
        //     var rating_id = $(this).val();
        //     if(rating_id > 0) {
        //         $(".rating_detail_create").trigger('click');
        //         $(".jsAgencyDetails").removeClass('d-none');
        //     }
        // });

        $(document).on('change', '.item_rating_date, .agency_id, .rating_id', function() {
            var itemRatingDate = $('.item_rating_date').val();
            var agencyId = $('.agency_id').val();
            var ratingId = $('.rating_id').val();
            var allFieldsFilled = itemRatingDate && agencyId && ratingId;

            $('.rating_detail_create').prop('disabled', !allFieldsFilled);
            $('.jsAgencyDetails').removeClass('d-none', !allFieldsFilled);
        });

        $(".rating_detail_create").click(function() {
            $('.add_rating_detail').trigger('click');
        });

        var id = $('.rating_item_id').val();
        if (id > 0) {
            var isRatingRepeater = false;
        } else {
            var isRatingRepeater = true;
        }

        $('#ratingDetailRepeater').repeater({
            initEmpty: isRatingRepeater,

            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                console.log($(".rating_detail_create"));
                
                $(this).find('.rating-list-no').text($(this).index() + 1 + ' .');
                var rating_id = $(".rating_id").find(':selected').val();

                if(rating_id > 0) {
                    var rating_rows = $(this).closest(".rating_detail_row");
                    getRatingDetail(rating_id, rating_rows);
                }

                $('.select2-container').css('width', '100%');
                $(this).slideDown();
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
                        var agency_id = $(this).find('.item_agency_id').val();
                        console.log(agency_id);
                        $(".agency_id option[value='" + agency_id + "']").attr(
                            'disabled',false);
                        // $(".item_rating_date").removeClass('required');
                        // $(".agency_id option[value='" + agency_id + "']").removeAttr('selected');
                        // $(".agency_id").val('').trigger('change');
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.rating-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {
                $('.select2-container').css('width', '100%');
            },
            isFirstItemUndeletable: false
        });

        jQuery.validator.addClassRules("minDate", {
            min: () => $('.from').val(),
        });

        jQuery.validator.addClassRules("statusDate", {
            min: () => $('.ptr_project_start_date').val()
        });

        jQuery.validator.addClassRules("jsPtrEndDate", {
            min: () => $('.ptr_project_start_date').val()
        });

        jQuery.validator.addClassRules("jsObfpEndDate", {
            min: () => $('.obfp_project_start_date').val()
        });

        $(document).on('change', '.from, .till', function() {
            let fromInput = $(this);
            // $('.till').attr('data-msg-min', '');
            checkToDateLessThanFromDateForRepeater(fromInput, 'from', 'till', 'trade_sector_row');
        });

        $(document).on('change', '.ptr_project_start_date', function() {
            let ptr_project_start_date = $(this);
            checkToDateLessThanFromDateForRepeater(ptr_project_start_date, 'ptr_project_start_date', 'actual_date_completion', 'ptr_row');

            checkToDateLessThanFromDateForRepeater(ptr_project_start_date, 'ptr_project_start_date', 'ptr_project_end_date', 'ptr_row');
        });

        $(document).on('change', '.obfp_project_start_date, .obfp_project_end_date', function() {
            let obfp_project_start_date = $(this);
            checkToDateLessThanFromDateForRepeater(obfp_project_start_date, 'obfp_project_start_date', 'obfp_project_end_date', 'obfp_row');
        });

        $(document).on('change', '.bond_value_first, .bond_value_second, .bond_value_third', function() {
            var bond_value = $(this).val();
            $('.bond_value_first, .bond_value_second, .bond_value_third').val(bond_value);
        });

        $(document).on('change', '.contract_value_first, .contract_value_second', function() {
            var contract_value = $(this).val();
            $('.contract_value_first, .contract_value_second').val(contract_value);
        });

        $(document).on('change', '.contractor_type', function(){
            if($(this).val() == 'Stand Alone'){
                $('.registration_no, .contractor_gst_no, .contractor_bond_gst_no').addClass('required');
                $('.jsVentureTypeRequired').removeClass('d-none');
            } else {
                $('.registration_no, .contractor_gst_no, .contractor_bond_gst_no').removeClass('required').val('');
                $('.jsVentureTypeRequired').addClass('d-none');
            }
        });
    </script>
    {{-- {!! ajax_fill_dropdown('contractor_country_id', 'contractor_state_id', route('get-states')) !!} --}}
    {{-- {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!} --}}
@endpush
