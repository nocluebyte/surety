@push('scripts')
    <script type="text/javascript">
        // $('.beneficiary_id,.project_details_id,.tender_id').select2({
        //     allowClear:true
        // }); 
        // $('.edit_contractor_id').select2({
        //     allowClear: true,
        // });

        $(document).ready(function() {
            loaTabForm();
        });

        var loaTabForm = function() {
            $('#loaTabForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {},
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                }
            });

            $('#loaEditTabForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {},
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                }
            });
        };

        $(".add_loa_attachment").on("change", function(){
            getAttachmentsCount("add_loa_attachment");
        });

        $(".loa_attachment").on("change", function(){
            getAttachmentsCount("loa_attachment");
        });

        $(document).on('change', '.beneficiary_id', function() {
            var beneficiary_id = $(this).val();

            if(beneficiary_id.length === 0) {
                $('select[name="project_details_id"]').val('').html('').trigger('change');
            }

            if(beneficiary_id > 0) {
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
                            $(".project_details_id").select2({
                                data: data,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (project_details_id > 0) {
                                $(".project_details_id").val(project_details_id).trigger("change");
                            }
                        }
                        $('select[name="project_details_id"]').val('').trigger('change');
                    }
                });
            }
        });

        $(document).on('change', '.project_details_id', function() {
            var project_details_id = $(this).val();

            if(project_details_id.length === 0) {
                $('select[name="tender_id"]').val('').html('').trigger('change');
            }

            if(project_details_id > 0) {
                var tender_id = "";
                $.ajax({
                    type: "POST",
                    url: '{{route("get-tender-details")}}',
                    data: {
                        'project_details_id': project_details_id,
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

                                if (tender_id > 0 && id == tender_id) {
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
                            $(".tender_id").select2({
                                data: data,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });

                            if (tender_id > 0) {
                                $(".tender_id").val(tender_id).trigger("change");
                            }
                        }
                    }
                });
            }
        });

        $(document).on('click', '.JsAddItem', function() {
            var contractor_id = $(this).attr('data-addContractorId');

            if(contractor_id.length > 0) {
                var beneficiary_id = '';
                $.ajax({
                    type: "GET",
                    url: '{{route("filterLetterOfAwardDetails")}}',
                    data: {
                        "contractor_id" : contractor_id,
                    },
                }).always(function() {

                }).done(function({
                    beneficiaries
                }) {
                    if(beneficiaries){
                        var pdOptions = '';
                        var data = [{
                            'id': '',
                            'text': '',
                            'html': '',
                        }];
                        $.each(beneficiaries, function(id,name) {

                            if (beneficiary_id > 0 && id == beneficiary_id) {
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
                        $(".beneficiary_id").select2({
                            data: data,
                            templateResult: selectTemplate,
                            escapeMarkup: function(m) {
                                return m;
                            },
                        });

                        if (beneficiary_id > 0) {
                            $(".beneficiary_id").val(beneficiary_id).trigger("change");
                        }
                    }
                })
            }
        })

        $(document).on('click', '.JsItem', function() {
            var itemId = $(this).attr('data-itemId');
            var contractor_id = $(this).attr('data-contractorId');
            var beneficiary_id = $(this).attr('data-beneficiaryId');
            var project_details_id = $(this).attr('data-projectDetailsId');
            var tender_id = $(this).attr('data-tenderId');

            if(itemId.length > 0) {
                $.ajax({
                    type: "GET",
                    // url: '{{ route("filterLetterOfAwardDetails", ["contractor_id" => "__contractor_id__", "beneficiary_id" => "__beneficiary_id__", "project_details_id" => "__project_details_id__", "tender_id" => "__tender_id__"]) }}'.replace('__contractor_id__', contractor_id).replace('__beneficiary_id__', beneficiary_id).replace('__project_details_id__', project_details_id).replace('__tender_id__', tender_id),
                    url: '{{route("filterLetterOfAwardDetails")}}',
                    data: {
                        "contractor_id" : contractor_id,
                        "beneficiary_id" : beneficiary_id,
                        "project_details_id" : project_details_id,
                        "tender_id" : tender_id,
                    },

                    // success: function(project_details, tenders) {
                    //     // console.log(response);
                    //     if(project_details){
                    //         var pdOptions = '';
                    //         var data = [{
                    //             'id': '',
                    //             'text': '',
                    //             'html': '',
                    //         }];
                    //         $.each(project_details, function(id,name) {

                    //             if (project_details_id > 0 && id == project_details_id) {
                    //                 var selected = true;
                    //             } else {
                    //                 var selected = false;
                    //             }

                    //             var obj = {
                    //                 'id': id,
                    //                 'text': name,
                    //                 'html': name,
                    //                 "selected": selected
                    //             };
                    //             data.push(obj);
                    //         });
                    //         $(".project_details_id").select2({
                    //             data: data,
                    //             templateResult: selectTemplate,
                    //             escapeMarkup: function(m) {
                    //                 return m;
                    //             },
                    //         });

                    //         if (project_details_id > 0) {
                    //             $(".project_details_id").val(project_details_id).trigger("change");
                    //         }
                    //     }

                    //     if(tenders){
                    //         var tOptions = '';
                    //         var tData = [{
                    //             'id': '',
                    //             'text': '',
                    //             'html': '',
                    //         }];
                    //         $.each(tenders, function(id,name) {

                    //             if (tender_id > 0 && id == tender_id) {
                    //                 var selected = true;
                    //             } else {
                    //                 var selected = false;
                    //             }

                    //             var obj = {
                    //                 'id': id,
                    //                 'text': name,
                    //                 'html': name,
                    //                 "selected": selected
                    //             };
                    //             tData.push(obj);
                    //         });
                    //         $(".tender_id").select2({
                    //             data: tData,
                    //             templateResult: selectTemplate,
                    //             escapeMarkup: function(m) {
                    //                 return m;
                    //             },
                    //         });

                    //         if (tender_id > 0) {
                    //             $(".tender_id").val(tender_id).trigger("change");
                    //         }
                    //     }
                    // }
                }).always(function() {

                }).done(function({
                    beneficiaries, project_details, tenders
                }) {
                    if(beneficiaries){
                        var bOptions = '';
                        var data = [{
                            'id': '',
                            'text': '',
                            'html': '',
                        }];
                        $.each(beneficiaries, function(id,name) {

                            if (beneficiary_id > 0 && id == beneficiary_id) {
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
                        $(".beneficiary_id").select2({
                            data: data,
                            templateResult: selectTemplate,
                            escapeMarkup: function(m) {
                                return m;
                            },
                        });

                        if (beneficiary_id > 0) {
                            $(".beneficiary_id").val(beneficiary_id).trigger("change");
                        }
                    }

                    if(project_details){
                        var pdOptions = '';
                        var data = [{
                            'id': '',
                            'text': '',
                            'html': '',
                        }];
                        $.each(project_details, function(id,name) {

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
                        $(".project_details_id").select2({
                            data: data,
                            templateResult: selectTemplate,
                            escapeMarkup: function(m) {
                                return m;
                            },
                        });

                        if (project_details_id > 0) {
                            $(".project_details_id").val(project_details_id).trigger("change");
                        }
                    }

                    if(tenders){
                        var tOptions = '';
                        var tData = [{
                            'id': '',
                            'text': '',
                            'html': '',
                        }];
                        $.each(tenders, function(id,name) {

                            if (tender_id > 0 && id == tender_id) {
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
                            tData.push(obj);
                        });
                        $(".tender_id").select2({
                            data: tData,
                            templateResult: selectTemplate,
                            escapeMarkup: function(m) {
                                return m;
                            },
                        });

                        if (tender_id > 0) {
                            $(".tender_id").val(tender_id).trigger("change");
                        }
                    }
                })
            }
        })
    </script>
@endpush