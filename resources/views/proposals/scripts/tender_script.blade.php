@push('scripts')
    <script type="text/javascript">
        $(document).on('change', '.tender_details_id', function() {
            let tender_details_id = $(this).val();

            if (tender_details_id.length === 0) {
                tenderFields.forEach(field => {
                    $("." + field).val('');
                });
                $('select[name="tender_beneficiary_id"]').val('').trigger('change');
                $('select[name="project_type"]').val('').trigger('change');
                $('select[name="bond_type_id"]').val('').trigger('change');
                $('select[name="bond_type"]').val('').trigger('change');
                $('select[name="type_of_contracting"]').val('').trigger('change');
            }

            if (tender_details_id > 0) {
                let ajaxUrl = $(this).attr('data-ajaxurl');

                // var beneficiary_id = "";
                // $.ajax({
                //     type: "POST",
                //     url: '{{route("get-beneficiary-details")}}',
                //     data: {
                //         'tender_details_id': tender_details_id,
                //     },
                //     success: function(res) {
                //         if (res) {
                //             var options = '';
                //             var data = [{
                //                 'id': '',
                //                 'text': '',
                //                 'html': '',
                //             }];
                //             $.each(res, function(id,name) {

                //                 if (beneficiary_id > 0 && id == beneficiary_id) {
                //                     var selected = true;
                //                 } else {
                //                     var selected = false;
                //                 }

                //                 var obj = {
                //                     'id': id,
                //                     'text': name,
                //                     'html': name,
                //                     "selected": selected
                //                 };
                //                 data.push(obj);
                //             });
                //             $(".beneficiary_id").select2({
                //                 data: data,
                //                 templateResult: selectTemplate,
                //                 escapeMarkup: function(m) {
                //                     return m;
                //                 },
                //             });

                //             if (beneficiary_id > 0) {
                //                 $(".beneficiary_id").val(beneficiary_id).trigger("change");
                //             }
                //         }
                //     }
                // });

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'tender_details_id': tender_details_id,
                    },
                }).always(function() {

                }).done(function({
                    tenderData,
                    documentCount,
                }) {
                    // console.log(tenderData);
                    if (tenderData) {
                        tenderFields.forEach(field => {
                            $("." + field).val(tenderData[field]);
                            // $("." + field).addClass('form-control-solid');
                        });

                        $('select[name="tender_beneficiary_id"]').val(tenderData.tender_beneficiary_id).trigger('change');

                        if(['JV', 'SPV'].includes($('#contract_type').val())){
                            $('select[name="beneficiary_id"]').val(tenderData.tender_beneficiary_id).trigger('change');
                        }

                        $('select[name="project_details"]').val(tenderData.project_details).trigger('change');
                        // $('select[name="beneficiary_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        $('select[name="project_type"]').val(tenderData.project_type).trigger(
                            'change');
                        // $('select[name="project_type"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        $('select[name="bond_type_id"]').val(tenderData.bond_type_id).trigger(
                            'change');
                        $('select[name="bond_type"]').val(tenderData.bond_type_id).trigger(
                            'change');
                        // $('select[name="bond_type_id"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        $('select[name="type_of_contracting"]').val(tenderData.type_of_contracting).trigger(
                            'change');
                        // $('select[name="type_of_contracting"]').prop('disabled', true).addClass(
                        //     'form-control-solid');

                        var tID = tenderData.id;

                        $('.JsRfpAttachment').attr('data-url', decodeURIComponent("{!! route('AutoFetchdMSDocument', ['id' => '__ID__', 'attachment_type' => 'rfp_attachment', 'dmsable_type' => 'Tender']) !!}".replace('__ID__', tID)));
                        $('.count_rfp_attachment').attr('data-count_rfp_attachment', documentCount.rfp_attachment).text(documentCount.rfp_attachment + ' document');
                    } else {
                        tenderFields.forEach(field => {
                            $("." + field).val("");
                            $("." + field).prop('readonly', false).removeClass(
                                'form-control-solid');
                        });
                        $("#full_name").val('');
                    }
                })
            }
        });

        $(".rfp_attachment").on("change", function(){
            var selectedFiles = $(".rfp_attachment").get(0).files.length;
            var numFiles = $(".count_rfp_attachment").attr('data-count_rfp_attachment');
            var autoFetched = numFiles.length == 0 ? 0 : parseInt(numFiles);
            var totalFiles = selectedFiles + autoFetched;
            $('.count_rfp_attachment').text(totalFiles + ' document');
        });

        $(".delete_proposal_document").on("click", function(){
            var filePrefix = $(this).attr('data-prefix');
            if(filePrefix == 'rfp_attachment'){
                remainingFiles = $(".rfp_attachment").get(0).files.length - 1;
                $('.count_rfp_attachment').text(remainingFiles + ' document');
            }
        });

        const tenderFields = [
            'tender_id',
            'tender_header',
            'contract_value',
            'period_of_contract',
            'location',
            'tender_bond_value',
            'rfp_date',
            'tender_description',
            'project_description',
        ];

        // $(document).on('change', '.jsPeriod', function() {
        //     var startDate = $('.pd_project_start_date').val();
        //     $('.pd_project_end_date').attr('min', startDate).attr('data-msg-min',
        //         'Please enter a Date greater than or equal to ' + moment(startDate).format('DD/MM/YYYY'));

        //     var endDate = $('.pd_project_end_date').val();
        //     $('.pd_project_start_date').attr('max', endDate).attr('data-msg-max',
        //         'Please enter a Date less than or equal to ' + moment(endDate).format('DD/MM/YYYY'));

        //     if (startDate != '' && endDate != '') {
        //         $('.jsProjectPeriod').val(daysCalculate(startDate, endDate));
        //     }
        // });

        $(".pd_project_start_date, .pd_project_end_date").change(function() {
            const startDate = $('.pd_project_start_date').val();
            const endDate = $('.pd_project_end_date').val();

            if (!startDate || !endDate) {
                $('.jsProjectPeriod').val('');
                return;
            }

            $('.jsProjectPeriod').val(dateDifferenceInDays(startDate, endDate));
        });
    </script>
@endpush
