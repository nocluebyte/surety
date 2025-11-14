@push('scripts')
    <script type="text/javascript">
        let pollingInterval = @json($proposal_auto_save_duration) * 60 * 1000;
        if ('{{ $is_proposal_auto_save }}' == 'Yes') {
            let timeoutID;

            $(document).on('input', '.form-control', function() {
                clearTimeout(timeoutID);

                timeoutID = setTimeout(() => {
                    updateData();
                }, pollingInterval);
            });
        }

        function updateData() {
            $('.contractor_bond_country_id, .contractor_bond_state_id, .is_jv, .pd_beneficiary, .tender_beneficiary_id').prop('disabled', false);
            let formElement = $('#proposalsForm')[0];
            let formData = new FormData(formElement);
            let data = {};

            for (let [name, value] of formData.entries()) {
                let keys = name.split(/\[|\]/).filter(k => k);
                let current = data;

                for (let i = 0; i < keys.length; i++) {
                    let key = isNaN(keys[i]) ? keys[i] : parseInt(keys[i]);

                    if (i === keys.length - 1) {
                        if (current[key] !== undefined) {
                            if (!Array.isArray(current[key])) {
                                current[key] = [current[key]];
                            }
                            current[key].push(value);
                        } else {
                            current[key] = value;
                        }
                    } else {
                        if (!current[key]) {
                            current[key] = isNaN(keys[i + 1]) ? {} : [];
                        }
                        current = current[key];
                    }
                }
            }

            formData.append('autosave', true);
            formData.append('is_autosave', 1);

            const proposalAttachments = [
                'company_details',
                'company_technical_details',
                'company_presentation',
                'certificate_of_incorporation',
                'memorandum_and_articles',
                'gst_certificate',
                'company_pan_no',
                'last_three_years_itr',

                'bond_attachment',
                'rfp_attachment',
                'bond_wording_file',
            ];

            proposalAttachments.forEach(item => {
                let fileInput = $('.' + item)[0];
                let files = fileInput.files;

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        formData.append(item + '[]', files[i]);
                    }
                }
            });

            // function appendFormData(formData, data, parentKey = '') {
            //     if (typeof data === 'object' && data !== null && !(data instanceof File)) {
            //         Object.keys(data).forEach(key => {
            //             let fullKey = parentKey
            //                 ? `${parentKey}[${key}]`
            //                 : key;
            //             appendFormData(formData, data[key], fullKey);
            //         });
            //     } else {
            //         formData.append(parentKey, data);
            //     }
            // }

            // appendFormData(formData, data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('proposals.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    $('.auto_proposal_id').val(data.proposal_id);

                    const pblItems = $('.pbl_row').find('.jsPblId').toArray();
                    pblItems.forEach((item, index) => {
                        if (data.autosaved_pbl_items[index]) {
                            $(item).val(data.autosaved_pbl_items[index]);
                        }
                    });

                    const obfpItems = $('.obfp_row').find('.jsObfpId').toArray();
                    obfpItems.forEach((item, index) => {
                        if (data.autosaved_obfp_items[index]) {
                            $(item).val(data.autosaved_obfp_items[index]);
                        }
                    });

                    const ptrItems = $('.ptr_row').find('.jsPtrId').toArray();
                    ptrItems.forEach((item, index) => {
                        if (data.autosaved_ptr_items[index]) {
                            $(item).val(data.autosaved_ptr_items[index]);
                        }
                    });

                    const mpItems = $('.mp_row').find('.jsMpId').toArray();
                    mpItems.forEach((item, index) => {
                        if (data.autosaved_mp_items[index]) {
                            $(item).val(data.autosaved_mp_items[index]);
                        }
                    });

                    const jVItems = $('.jv_contractor_rows').find('.jVItemId').toArray();
                    jVItems.forEach((item, index) => {
                        if (data.autosaved_jv_items[index]) {
                            $(item).val(data.autosaved_jv_items[index]);
                        }
                    });

                    const spVItems = $('.spv_contractor_rows').find('.spVItemId').toArray();
                    spVItems.forEach((item, index) => {
                        if (data.autosaved_spv_items[index]) {
                            $(item).val(data.autosaved_spv_items[index]);
                        }
                    });

                    const contractorItems = $('.contractor_data_rows').find('.contractorItemId').toArray();
                    contractorItems.forEach((item, index) => {
                        if (data.autosaved_contractor_items[index]) {
                            $(item).val(data.autosaved_contractor_items[index]);
                        }
                    });

                    const beneficiaryTradeSectorItems = $('.trade_sector_row').find('.beneficiaryTradeSectorId')
                        .toArray();
                    beneficiaryTradeSectorItems.forEach((item, index) => {
                        if (data.autosavedBeneficiaryTradeSector[index]) {
                            $(item).val(data.autosavedBeneficiaryTradeSector[index]);
                        }
                    });

                    const contractorTradeSectorItems = $('.contractor_trade_sector_row').find(
                        '.contractorTradeSectorId').toArray();
                    contractorTradeSectorItems.forEach((item, index) => {
                        if (data.autosaved_tradesector_items[index]) {
                            $(item).val(data.autosaved_tradesector_items[index]);
                        }
                    });

                    const contactDetails = $('.contact_detail_row').find('.contactDetailId').toArray();
                    contactDetails.forEach((item, index) => {
                        if (data.autosaved_contact_details[index]) {
                            $(item).val(data.autosaved_contact_details[index]);
                        }
                    });

                    const contractorRatingDetails = $('.rating_detail_row').find(
                        '.contractorRatingDetailId').toArray();
                    contractorRatingDetails.forEach((item, index) => {
                        if (data.autosaved_rating_details[index]) {
                            $(item).val(data.autosaved_rating_details[index]);
                        }
                    });

                    $('.contractor_bond_country_id, .contractor_bond_state_id, .is_jv, .pd_beneficiary, .tender_beneficiary_id').prop('disabled', true);
                }
            });
        }
    </script>
@endpush
