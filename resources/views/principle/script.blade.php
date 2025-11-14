@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            jQuery.validator.addClassRules("minDate", {
                min: () => $('.from').val(),
            });

            jQuery.validator.addClassRules("statusDate", {
                min: () => $('.ptr_project_start_date').val()
            });

            jQuery.validator.addClassRules("jsPtrEndDate", {
                min: () => $('.ptr_project_start_date').val()
            });

            // jQuery.validator.addMethod("maxShareHolding", function(value, element) {
            //     var is_spv = $('.form_is_spv:checked').val();
            //     if (is_spv == 'Yes') {
            //         var totalShareHold = 0;
            //         $(".share_holding").each(function(index, sval) {
            //             var sharehold = $(this).val();
            //             if($(this).val() > 0){
            //                 totalShareHold += parseFloat(sharehold);
            //             }
            //         })                     
            //         return (totalShareHold <= 100);
            //     }
            // }, "Total share holding must be only 100%.");

            jQuery.validator.addMethod("maxShareHolding", function(value, element) {
                var venture_type = $('.venture_type:checked').val();
                if ($.inArray(venture_type, ['JV', 'SPV']) !== -1) {
                    var totalShareHold = 0;
                    $(".share_holding").each(function(index, sval) {
                        var sharehold = $(this).val();
                        if($(this).val() > 0){
                            totalShareHold += parseFloat(sharehold);
                        }
                    })                     
                    return (totalShareHold <= 100);
                }
            }, "Total share holding must be only 100%.");

            $('#principleForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {
                    inception_date: {
                        min: () => "Please enter a value greater than or equal to " + moment($(
                            "#date_of_incorporation").val()).format('DD/MM/YYYY'),
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                invalidHandler: function() {
                    setTimeout(updateTabValidation, 0);
                },
                submitHandler: function(e) {
                    if ($('.main:checked').length === 0) {
                        errorMessage('Please check at least one main in trade sector')
                        return false;
                    }
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
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

            $('#kt_repeater_contractor').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).find('.list-no').text($(this).index() + 1 + ' .');
                    $(this).find('.contractor_id').select2({
                        allowClear: true
                    });
                    $(this).find('.contractor_id').addClass('required');
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
                    $('.contractor_id').select2({
                        allowClear: true
                    });
                    $('.select2-container').css('width', '100%');
                },
                isFirstItemUndeletable: true
            });

            $('#contactDetailRepeater').repeater({
                initEmpty: false,

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
        };

        // $(document).on('change', '.form_is_spv', function() {
        //     var is_spv = $('.form_is_spv:checked').val();
        //     if (is_spv == 'Yes') {
        //         $(".contractRepeater").removeClass('d-none');
        //         $('.contractor_id').addClass('required');
        //         $('.share_holding').addClass('required');
        //     } else {
        //         $(".contractRepeater").addClass('d-none');
        //         $('.contractor_id').removeClass('required');
        //         $('.share_holding').removeClass('required');
        //     }
        // });

        $(document).on('change', '.venture_type', function() {
            var venture_type = $('.venture_type:checked').val();
            
            if ($.inArray(venture_type, ['JV', 'SPV']) !== -1) {
                $(".contractRepeater").removeClass('d-none');
                $('.contractor_id').addClass('required');
                $('.share_holding').addClass('required');
            } else {
                $(".contractRepeater").addClass('d-none');
                $('.contractor_id').removeClass('required');
                $('.share_holding').removeClass('required');
            }
        });

        jQuery(document).on('change', '#principleForm .contractor_data_rows .contractor_id', function() {
            //Create array of input values
            var ar = $('.contractor_data_rows .contractor_id').map(function() {
                if ($(this).val() != '') return $(this).val()
            }).get();

            //Create array of duplicates if there are any
            var unique = ar.filter(function(item, pos) {
                return ar.indexOf(item) != pos;
            });

            var message = "Selected contractor is duplicate";
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

        $(document).on('change', '.contractor_id', function() {
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
                        contractor_data_rows.find(".contractor_pan_no").prop('readonly', true);
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

        $(document).on('change', '.agency_id', function() {
            var agency_id = $(this).val();
            var rating_id = '';
            // $('.jsSelectRating').removeClass('invisible');
            if (agency_id.length == 0) {
                $(".rating_id").removeClass('required');
            }
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
                    $('.jsIsAgency').addClass('d-none');
                    $(".rating_detail_create").prop('disabled', true);
                    // $('.jsSelectRating').addClass('invisible');
                } else {
                    dataRows.find(".rating").val('');
                    dataRows.find(".agency_name").val('');
                    dataRows.find(".item_agency_id").val('');
                    dataRows.find(".rating_remarks").val('');
                    dataRows.find(".item_rating_id").val('');
                }
            });
        }

        $(document).on('change', '.item_rating_date, .agency_id, .rating_id', function() {
            var itemRatingDate = $('.item_rating_date').val();
            var agencyId = $('.agency_id').val();
            var ratingId = $('.rating_id').val();
            var allFieldsFilled = itemRatingDate && agencyId && ratingId;

            $('.rating_detail_create').prop('disabled', !allFieldsFilled);
            $('.jsRatingDetails').removeClass('d-none', !allFieldsFilled);
        });

        $(".rating_detail_create").click(function() {
            $('.add_rating_detail').trigger('click');
        });

        var id = $('.rating_item_id').val();
        if (id > 0) {
            var isrepeater = false;
        } else {
            var isrepeater = true;
        }

        $('#contractorRatingDetailRepeater').repeater({
            initEmpty: isrepeater,

            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
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

        $('#tradeSectorRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.trade-list-no').text($(this).index() + 1 + ' .');
                $('.trade_sector').select2({
                    allowClear: true,
                });
                $('.select2-container').css('width', '100%');
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.trade_sector').select2({
                    allowClear: true,
                });
                $('.select2-container').css('width', '100%');
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
            isFirstItemUndeletable: true

        });

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.gstAndPanNoFields').removeClass('d-none');
                } else {
                    $('.gstAndPanNoFields').addClass('d-none');
                    // $('.gst_no').val('');
                    $('.pan_no').removeClass('required').val('');
                }
            }
        }

        $(document).on('select2:select', '#country', function() {
            isCountryIndia();
            var countryName = $('#country').find("option:selected").text();
            checkPinCodeValidation('jsPinCode', 'pin_code', countryName);
        });

        $('#country, #state, #principle_type, #type_of_entity, #trade_sector').select2({
            allowClear: true
        });

        $('.selectDate').on('change', function() {
            var startDate = $('#date_of_incorporation').val();
            $('#inception_date').attr('min',
                startDate);
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        $(document).on("change", ".main", function() {
            $('.main').each(function() {
                $(this).prop("checked", "").removeClass('required');
            });
            $(this).prop("checked", "checked").addClass('required');
        });

        function checkExitTradeSector(_this = '') {
            var tradeSector = _this.val();
            var isExits = false
            $('.trade_sector').each(function(key, value) {
                if (!_this.is($(this))) {
                    if ($(this).val() == tradeSector) {
                        isExits = true;
                    }
                }
            });
            return isExits;
        }

        $(document).on("change", ".trade_sector", function() {
            var _ths = $(this);
            var dataRow = $(this).closest('.trade_sector_row');
            if (checkExitTradeSector(_ths)) {
                $(".item-dul-error").removeClass('d-none')
                dataRow.find(".jsTradeSector").val('').select2({
                    allowClear: true,
                });
            } else {
                $(".item-dul-error").addClass('d-none')
            }
        });

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

        function updateTabValidation() {
            $('.tab-content.tab-validate .tab-pane').each(function() {

                var id = $(this).attr('id');
                if ($(this).find('input.error, textarea.error, select.error').length) {
                    $('.nav-tabs li a[href="#' + id + '"]').addClass('border border-danger');
                } else {
                    $('.nav-tabs li a[href="#' + id + '"]').removeClass('border border-danger');
                }
            });
        }

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

            let removedValues = new Set();

            $(document).on('click', '.dms_data', function() {
                const fileId = $(this).data('id');

                // $(this).remove();

                // $('.remove_dms').remove();

                if (!removedValues.has(fileId)) {
                    removedValues.add(fileId);

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_dms[]',
                        value: fileId
                    }).appendTo('form');
                }
            });

            function manageRepeaterAttachments(formRepeater) {
                $(document).on('change', formRepeater, function() {
                    var fileInput = $(this);
                    var fileNamesContainer = fileInput.closest('.form-group').find('.fileNamesContainer');

                    fileNamesContainer.empty();

                    for (var i = 0; i < this.files.length; i++) {
                        var fileName = this.files[i].name;
                        console.log(this.files[i].webkitRelativePath);
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
                // if ($('.jsPblId').val() === '') {
                //     $(formRepeater).addClass('required').attr('aria-required', 'true');
                // }
            }

            manageRepeaterAttachments('.banking_limits_attachment');
            manageRepeaterAttachments('.order_book_and_future_projects_attachment');
            manageRepeaterAttachments('.project_track_records_attachment');
            manageRepeaterAttachments('.management_profiles_attachment');


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

        addOrDeleteRepeater('.pbl_repeater_row', '.pbl_row', '.delete_pbl_item', 'add', '.jsAddProposalBankingLimits');


        // Order Book and Future Projects Repeater

        $('#orderBookAndFutureProjectsRepeater').repeater({
            initEmpty: false,

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

        addOrDeleteRepeater('.obfp_repeater_row', '.obfp_row', '.delete_obfp_item', 'add',
            '.jsAddOrderBookAndFutureProjects');

        // Project Track Records Repeater

        $('#projectTrackRecordsRepeater').repeater({
            initEmpty: false,

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

        addOrDeleteRepeater('.ptr_repeater_row', '.ptr_row', '.delete_ptr_item', 'add', '.jsAddProjectTrackRecords');

        // Management Profiles Repeater

        $('#managementProfilesRepeater').repeater({
            initEmpty: false,

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

        addOrDeleteRepeater('.mp_repeater_row', '.mp_row', '.delete_mp_item', 'add', '.jsAddManagementProfiles');

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

        $('form').on('click', '.is_bank_guarantee_provided', function() {
            if($('.is_bank_guarantee_provided:checked').val() == 'Yes') {
                $('.isBankGuaranteeProvidedData').removeClass('d-none');
            } else {
                $('.isBankGuaranteeProvidedData').addClass('d-none');
                $('.circumstance_short_notes').val(null);
            }
        });

        $('form').on('click', '.is_action_against_proposer', function() {
            if($('.is_action_against_proposer:checked').val() == 'Yes') {
                $('.isActionAgainstProposerData').removeClass('d-none');
            } else {
                $('.isActionAgainstProposerData').addClass('d-none');
                $('.action_details').val(null);
            }
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

        $(".company_details").on("change", function(){
            getAttachmentsCount("company_details");
        });

        $(".company_technical_details").on("change", function(){
            getAttachmentsCount("company_technical_details");
        });

        $(".company_presentation").on("change", function(){
            getAttachmentsCount("company_presentation");
        });

        $(".certificate_of_incorporation").on("change", function(){
            getAttachmentsCount("certificate_of_incorporation");
        });

        $(".memorandum_and_articles").on("change", function(){
            getAttachmentsCount("memorandum_and_articles");
        });

        $(".gst_certificate").on("change", function(){
            getAttachmentsCount("gst_certificate");
        });

        $(".company_pan_no").on("change", function(){
            getAttachmentsCount("company_pan_no");
        });

        $(".last_three_years_itr").on("change", function(){
            getAttachmentsCount("last_three_years_itr");
        });

        $(document).on('change', '.banking_limits_attachment', function () {
            let pblInput = $(this);
            countRepeaterDocuments(pblInput ,'pbl_row', 'banking_limits_attachment');
        });

        $(document).on('change', '.project_track_records_attachment', function () {
            let ptrInput = $(this);
            countRepeaterDocuments(ptrInput ,'ptr_row', 'project_track_records_attachment');
        });

        $(document).on('change', '.order_book_and_future_projects_attachment', function () {
            let obfpInput = $(this);
            countRepeaterDocuments(obfpInput ,'obfp_row', 'order_book_and_future_projects_attachment');
        });

        $(document).on('change', '.management_profiles_attachment', function () {
            let mpInput = $(this);
            countRepeaterDocuments(mpInput ,'mp_row', 'management_profiles_attachment');
        });

        $(document).on('change', '#country', function(){
            getCountryCurrencySymbol($(this));
        });

        $(document).on('change', '.venture_type', function(){
            if($('.venture_type:checked').val() == 'Stand Alone'){
                $('.registration_no, .gst_no, .gst_certificate, .company_pan_no').addClass('required');
                if($('.count_gst_certificate').attr('data-count_gst_certificate') > 0){
                    $('.gst_certificate').removeClass('required');
                }
                if($('.count_company_pan_no').attr('data-count_company_pan_no') > 0){
                    $('.company_pan_no').removeClass('required');
                }
                $('.jsVentureTypeRequired').removeClass('d-none');
            } else {
                $('.registration_no, .gst_no, .gst_certificate, .company_pan_no').removeClass('required');
                $('.gst_certificate, .company_pan_no').val('');
                if($('.count_gst_certificate').attr('data-count_gst_certificate') == 0){
                    $('.count_gst_certificate').text('0 document');
                }
                if($('.count_company_pan_no').attr('data-count_company_pan_no') == 0){
                    $('.count_company_pan_no').text('0 document');
                }
                $('.jsVentureTypeRequired').addClass('d-none');
            }
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
