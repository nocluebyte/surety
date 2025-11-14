@push('scripts')
    <script type="text/javascript">
        $('form').on('click', '.beneficiary_type', function() {
            if ($('.beneficiary_type:checked').val() == 'Government') {
                $('#ministry_type').addClass('required');
                $('.ministryType').removeClass('d-none');
            } else {
                $('#ministry_type').removeClass('required');
                $('.ministryType').addClass('d-none');
                $('#ministry_type').val(null).trigger("change.select2");
            }
        });

        // $('#beneficiary_id').change
        $(document).on('change', '.beneficiary_id', function() {
            let beneficiary_id = $(this).val();
            $(".project_details").val('').trigger("change");

            if (beneficiary_id.length === 0) {
                beneficiaryFields.forEach(field => {
                    $("." + field).val('');
                });
                $('.beneficiary_same_as_above').prop('checked', false).trigger('change');
            }

            if (beneficiary_id > 0) {
                let ajaxUrl = $(this).attr('data-ajaxurl');

                var project_details_id = "";
                $.ajax({
                    type: "POST",
                    url: '{{route("get-beneficiary-project-details")}}',
                    data: {
                        'beneficiary_id': beneficiary_id,
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

                                if (project_details_id > 0 && id == project_details_id) {
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
                            $(".project_details").select2({
                                data: data,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (project_details_id > 0) {
                                $(".project_details").val(project_details_id).trigger("change");
                            }
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'beneficiary_id': beneficiary_id,
                    },
                }).always(function() {

                }).done(function({
                    beneficiaryData,
                    beneficiary_trade_sector,
                    beneficiary_states,
                    documentCount,
                }) {
                    // console.log(response);
                    if (beneficiaryData) {
                        // console.log(beneficiaryData);
                        beneficiaryFields.forEach(field => {
                            $("." + field).val(beneficiaryData[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('input[name="beneficiary_type"][value="' + beneficiaryData.beneficiary_type +
                            '"]').prop(
                            'checked', true);

                        if (beneficiaryData.beneficiary_type == 'Non-Government') {
                            $('.ministryType').addClass('d-none');
                            $('.ministry_type').removeClass('required');
                        }

                        $('.beneficiary_trade_sector_repeater').html(beneficiary_trade_sector);

                        $('select[name="beneficiary_country_id"]').val(beneficiaryData.country_id).trigger('change');

                        // $('select[name="beneficiary_state_id"]').val(beneficiaryData.country_id).trigger('change');
                        // console.log(beneficiary_states);

                        if(beneficiary_states){
                            var options = '';
                            var data = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(beneficiary_states.beneficiary_states, function(id, name) {

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
                            $(".beneficiary_state_id").select2({
                                data: data,
                                // templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (beneficiaryData.state_id > 0) {
                                $('select[name="beneficiary_state_id"]').val(beneficiaryData.state_id).trigger('change');
                            }
                        }

                        // $('select[name="country_id"] option:selected');
                        if ($('#beneficiary_country_id option:selected').text().toLowerCase() != 'india') {
                            $('.beneficiaryGstAndPanNoFields').addClass('d-none');
                            $('.beneficiary_gst_no').removeClass('required');
                            $('.beneficiary_pan_no').removeClass('required');
                        }

                        // $('select[name="country_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        $('select[name="establishment_type_id"]').val(beneficiaryData.establishment_type_id)
                            .trigger(
                                'change');
                        // $('select[name="establishment_type_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        if (beneficiaryData.beneficiary_type == 'Government') {
                            $('select[name="ministry_type_id"]').val(beneficiaryData.ministry_type_id).trigger(
                            'change');
                        }
                        // $('select[name="ministry_type_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        var bID = beneficiaryData.id;
                        
                        $('.JsBondAttachment').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'bond_attachment', 'dmsable_type' => 'Beneficiary']) !!}".replace('__ID__', bID)));
                        $('.count_bond_attachment').attr('data-count_bond_attachment', documentCount.bond_attachment ?? 0).text(typeof(documentCount.bond_attachment) == "undefined" ? 0 + ' document' : documentCount.bond_attachment + ' document');

                        if($('#contract_type').val() == 'Stand Alone'){
                            $('.beneficiary_same_as_above').prop('checked', false).trigger('change');
                        }
                    } else {
                        beneficiaryFields.forEach(field => {
                            $("." + field).val("");
                            $("." + field).prop('readonly', false).removeClass(
                                'form-control-solid');
                        });
                        $("#full_name").val('');
                    }
                })
            }
        });

        $(".bond_attachment").on("change", function(){
            var selectedFiles = $(".bond_attachment").get(0).files.length;
            var numFiles = $(".count_bond_attachment").attr('data-count_bond_attachment');
            var autoFetched = numFiles.length == 0 ? 0 : parseInt(numFiles);
            var totalFiles = selectedFiles + autoFetched;
            $('.count_bond_attachment').text(totalFiles + ' document');
        });

        $(".delete_proposal_document").on("click", function(){
            var filePrefix = $(this).attr('data-prefix');
            if(filePrefix == 'bond_attachment'){
                remainingFiles = $(".bond_attachment").get(0).files.length - 1;
                $('.count_bond_attachment').text(remainingFiles + ' document');
            }
        });

        const beneficiaryFields = [
            'beneficiary_registration_no',
            'beneficiary_company_name',
            'beneficiary_email',
            'beneficiary_phone_no',
            'beneficiary_address',
            'beneficiary_website',
            'beneficiary_city',
            'beneficiary_pincode',
            'beneficiary_gst_no',
            'beneficiary_pan_no',
            'beneficiary_bond_wording',
        ];

        $('#beneficiaryTradeSectorRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.trade-list-no').text($(this).index() + 1 + ' .');
                $('.trade_sector').select2({
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
                $('.trade_sector').select2({
                    allowClear: true,
                });
            },
            isFirstItemUndeletable: true

        });

        $(document).on("change", ".beneficiary_is_main", function() {
            $('.beneficiary_is_main').each(function() {
                $(this).prop("checked", "").removeClass('required');
            });
            $(this).prop("checked", "checked").addClass('required');
        });

        $(document).on('change','.beneficiary_country_id', function(){
            getstates('beneficiary_country_id', 'beneficiary_state_id');
        });

        $(document).on('change','.beneficiary_bond_country_id', function(){
            getstates('beneficiary_bond_country_id', 'beneficiary_bond_state_id');
        });

        let isCountryIndiaBeneficiary = () => {
            let countryBeneficiary = $('#beneficiary_country_id').find("option:selected").text();
            let countryBeneficiaryId = $('#beneficiary_country_id').val();

            if (countryBeneficiaryId.length > 0) {
                if (countryBeneficiary.toLowerCase() == 'india') {
                    $('.beneficiaryGstAndPanNoFields').removeClass('d-none');
                    $('.beneficiary_gst_no').addClass('required');
                    $('.beneficiary_pan_no').addClass('required');
                } else {
                    $('.beneficiaryGstAndPanNoFields').addClass('d-none');
                    $('.beneficiary_gst_no').removeClass('required').val('');
                    $('.beneficiary_pan_no').removeClass('required').val('');
                }
            }
        }

        let isCountryIndiaBeneficiaryBond = () => {
            let countryBeneficiaryBond = $('#beneficiary_bond_country_id').find("option:selected").text();
            let countryBeneficiaryBondId = $('#beneficiary_bond_country_id').val();

            if (countryBeneficiaryBondId.length > 0) {
                if (countryBeneficiaryBond.toLowerCase() == 'india') {
                    $('.beneficiaryBondGstNo').removeClass('d-none');
                    $('.beneficiary_bond_gst_no').addClass('required');
                } else {
                    $('.beneficiaryBondGstNo').addClass('d-none');
                    $('.beneficiary_bond_gst_no').removeClass('required').val('');
                }
            }
        }

        $(document).on('select2:select', '#beneficiary_country_id', function() {
            isCountryIndiaBeneficiary();
            var countryNameBeneficiary = $('#beneficiary_country_id').find("option:selected").text();
            checkPinCodeValidation('jsPinCodeBeneficiary', 'beneficiary_pincode', countryNameBeneficiary);
        });

        $(document).on('select2:select', '#beneficiary_bond_country_id', function() {
            isCountryIndiaBeneficiaryBond();
            var countryNameBeneficiaryBond = $('#beneficiary_bond_country_id').find("option:selected").text();
            checkPinCodeValidation('jsPinCodeBeneficiaryBond', 'beneficiary_bond_pincode', countryNameBeneficiaryBond);
        });

        $(document).on('change', '.beneficiary_same_as_above', function() {
            var same_as_above = $('.beneficiary_same_as_above:checked').val();
            if(same_as_above == 'Yes'){
                $('.beneficiary_bond_address').val($('.beneficiary_address').val()).addClass('form-control-solid').attr('readonly', true);
                $('.beneficiary_bond_city').val($('.beneficiary_city').val()).addClass('form-control-solid').attr('readonly', true);
                $('.beneficiary_bond_pincode').val($('.beneficiary_pincode').val()).addClass('form-control-solid').attr('readonly', true);
                $('.beneficiary_bond_gst_no').val($('.beneficiary_gst_no').val()).addClass('form-control-solid').attr('readonly', true);
                $('select[name="beneficiary_bond_country_id"]').val($('.beneficiary_country_id').val()).trigger('change').attr('disabled', true);

                if ($('#beneficiary_bond_country_id option:selected').text().toLowerCase() != 'india') {
                    $('.beneficiaryBondGstNo').addClass('d-none');
                    $('.beneficiary_bond_gst_no').removeClass('required');
                }

                var beneficiary_bond_state_id = "";
                var beneficiaryCountryId= $('.beneficiary_bond_country_id').val();
                $(".beneficiary_bond_state_id option").remove();
                if(beneficiaryCountryId > 0){
                    $.ajax({
                        url: '{{route("get-states")}}',
                        type: 'POST',
                        data: {
                            'country_id': beneficiaryCountryId
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

                                    if (beneficiary_bond_state_id > 0 && id == beneficiary_bond_state_id) {
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
                                $(".beneficiary_bond_state_id").select2({
                                    data: data,
                                    // templateResult: selectTemplate,
                                    escapeMarkup: function(m) {
                                        return m;
                                    },
                                });

                                if ($('.beneficiary_state_id').val() > 0) {
                                    $(".beneficiary_bond_state_id").val($('.beneficiary_state_id').val()).trigger("change").attr('disabled', true);
                                }
                            }
                        }
                    });
                }
            } else {
                $('.beneficiary_bond_address').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.beneficiary_bond_city').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.beneficiary_bond_pincode').val('').removeClass('form-control-solid').attr('readonly', false);
                $('.beneficiary_bond_gst_no').val('').removeClass('form-control-solid').attr('readonly', false);
                $('select[name="beneficiary_bond_country_id"]').val('').trigger('change').attr('disabled', false);
                $('select[name="beneficiary_bond_state_id"]').val('').trigger('change').attr('disabled', false);
            }
        });

        function checkExitBeneficiaryTradeSector(_this = '') {
            var tradeSector = _this.val();
            var isExits = false
            $('.beneficiary_trade_sector_id').each(function(key, value) {
                if (!_this.is($(this))) {
                    if ($(this).val() == tradeSector) {
                        isExits = true;
                    }
                }
            });
            return isExits;
        }

        $(document).on("change", ".beneficiary_trade_sector_id", function() {
            var _ths = $(this);
            var dataRow = $(this).closest('.trade_sector_row');
            if (checkExitBeneficiaryTradeSector(_ths)) {
                $(".item-dul-error").removeClass('d-none')
                dataRow.find(".jsTradeSector").val('').select2({
                    allowClear: true,
                });
            } else {
                $(".item-dul-error").addClass('d-none')
            }
        });

        $(document).on('change', '#beneficiary_country_id', function(){
            getCountryCurrencySymbol($(this));
        });

        jQuery.validator.addClassRules("beneficiaryMinDate", {
            min: () => $('.beneficiary_from').val(),
        });

        $(document).on('change', '.beneficiary_from, .beneficiary_till', function() {
            let fromInput = $(this);
            // $('.till').attr('data-msg-min', '');
            checkToDateLessThanFromDateForRepeater(fromInput, 'beneficiary_from', 'beneficiary_till', 'beneficiary_trade_sector_row');
        });
    </script>
    {{-- {!! ajax_fill_dropdown('beneficiary_country_id', 'beneficiary_state_id', route('get-states')) !!} --}}
@endpush
