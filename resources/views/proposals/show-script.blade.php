{{-- <script type="text/javascript">
$(document).on('click', '.jsConfirmBtn', function(e) {
    e.preventDefault();
    message.fire({
        title: 'Are you sure',
        text: "You want to confirm this ?",
        type: 'warning',
        customClass: {
            confirmButton: 'btn btn-success shadow-sm ',
            cancelButton: 'btn btn-danger shadow-sm'
        },
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.value) {
            window.location.href = "{{route('tender-evaluation',$proposal_id)}}";
        }else if(result.dismiss && result.dismiss == 'cancel'){
            // updateStatus('Cancel');
        }
    });
});
$(document).on('click', '.jsApproveBtn', function(e) {
    e.preventDefault();
    message.fire({
        title: 'Are you sure',
        text: "You want to approve this ?",
        type: 'warning',
        customClass: {
            confirmButton: 'btn btn-success shadow-sm ',
            cancelButton: 'btn btn-danger shadow-sm'
        },
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Reject',
    }).then((result) => {
        if (result.value) {
            updateStatus('Approve');
        }else if(result.dismiss && result.dismiss == 'cancel'){
            updateStatus('Reject');
        }
    });
});
function updateStatus(newStatus){
    $.ajax({
        type: "POST",
        url: '{{ $proposals_status_url }}',
        cache: false,
        data: {
            'new_status':newStatus,
            current_status:'{{ $status }}'
        },
    }).always(function(respons) {})
    .done(function(respons) {
        location.reload();
    }).fail(function(respons) {
        var res = respons.responseJSON;
        var msg = 'something went wrong please try again !';
        if (res.errormessage) {
            toastr.warning(res.errormessage, "Warning");
        }
        toastr.error(msg, "Error");
    });
}
</script> --}}

<script type="text/javascript">

    const rejection_reasons = {{Js::from($rejection_reasons)}};
    const proposal_id = {{Js::from($proposal_id ?? 0)}};
    let rejection_reason_id;
    const areProposalFieldsNonNull = {{Js::from($areProposalFieldsNonNull)}};

    $(document).on('click', '.jsApproveBtn', function(e) {
        if(areProposalFieldsNonNull == true){
            e.preventDefault();
            message.fire({
                title: 'Are you sure',
                text: "You want to confirm this ?",
                type: 'warning',
                customClass: {
                    confirmButton: 'btn btn-success shadow-sm',
                    cancelButton: 'btn btn-danger shadow-sm',
                    // rejectButton: 'position-absolute '
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Reject',
                // html: '<button type="button" class="rejectProposal btn btn-warning shadow-sm" aria-label="" style="display: inline-block;">Reject</button>',
            }).then((result) => {
                if (result.value) {

                    // message.fire({
                    //     title: "UnderWriter",
                    //     input: "select",
                    //     inputOptions:underwriters,
                    //     inputPlaceholder: "Select Underwriter",
                    //     showCancelButton: true,
                    //     inputValidator: (value) => {
                    //         return new Promise((resolve,reject) => {
                    //         if (value === "") {
                    //             resolve("Please Select UnderWriter");
                    //         } else {
                    //             underwriter_id = value;
                    //             resolve();
                    //         }
                    //         });
                    //     },
                    //     onOpen: function () {
                    //         $('.swal2-select').select2({
                    //             dropdownParent: $('.swal2-container'),
                    //             placeholder:'Select UnderWriter',
                    //             allowClear:true
                    //         });
                    //     },
                    //     }).then((result) => {
                            // if (result.value) {
                                createCase(proposal_id, rejection_reason_id = null, 'Confirm');
                            // }
                        // });
                } else if (result.dismiss && result.dismiss == 'cancel') {
                    // updateStatus('Cancel');

                    message.fire({
                        title: "Reason",
                        input: "select",
                        inputOptions:rejection_reasons,
                        inputPlaceholder: "Select Rejection Reasons",
                        showCancelButton: true,
                        inputValidator: (value) => {
                            return new Promise((resolve,reject) => {
                            if (value === "") {
                                resolve("Please Select Rejection Reasons");
                            } else {
                                rejection_reason_id = value;
                                resolve();
                            }
                            });
                        },
                        onOpen: function () {
                            $('.swal2-select').select2({
                                dropdownParent: $('.swal2-container'),
                                placeholder:'Select Rejection Reasons',
                                allowClear:true
                            });
                        },
                        }).then((result) => {
                            if (result.value) {
                                createCase(proposal_id,rejection_reason_id,'Cancel');
                            }
                        });
                }
            });
        } else {
            message.fire({
                text: "Do edit this proposal and fill all the required details first.",
                type: 'warning',
            });
        }
    });

    function createCase(proposal_id,rejection_reason_id,status){
        if(proposal_id){
             $.ajax({
                type: "POST",
                url: "{{ route('proposalCaseCreate')  }}",
                cache: false,
                data: {
                    'proposal_id': proposal_id,
                    'rejection_reason_id':rejection_reason_id,
                    'status': status,                    
                },
            }).always(function(respons) {})
            .done(function(respons) {
                if(respons){
                    window.location.href = respons;
                }
               
            }).fail(function(respons) {
                var res = respons.responseJSON;
                var msg = '  went wrong please try again !';
                if (res.errormessage) {
                    toastr.warning(res.errormessage, "Warning");
                }
                toastr.error(msg, "Error");
            });
        }
    }

    $(document).on('click', '.rejectProposal', function() {
        swal.close();
        $.ajax({
            type: "GET",
            url: "{{ route('proposal-rejection-reason', $proposal_id) }}",
        }).always(function() {
            $('#load-modal').html(' ')
            // $('.modal-footer').show();
        }).done(function(res) {
            // console.log(res);
            $('#load-modal').html(res.html);
            $('#commonModalID').modal('toggle');
        });
    })

    // $(document).on('click', '.jsApproveBtn', function(e) {
    //     e.preventDefault();
    //     message.fire({
    //         title: 'Are you sure',
    //         text: "You want to confirm this ?",
    //         type: 'warning',
    //         customClass: {
    //             confirmButton: 'btn btn-success shadow-sm ',
    //             cancelButton: 'btn btn-danger shadow-sm'
    //         },
    //         buttonsStyling: false,
    //         showCancelButton: true,
    //         confirmButtonText: 'Approve',
    //         cancelButtonText: 'Reject',
    //     }).then((result) => {
    //         if (result.value) {
    //             updateStatus('Approve');
    //         } else if (result.dismiss && result.dismiss == 'cancel') {
    //             // updateStatus('Cancel');

    //             $.ajax({
    //                 type: "GET",
    //                 url: "{{ route('proposal-rejection-reason', $proposal_id) }}",
    //             }).always(function() {
    //                 $('#load-modal').html(' ')
    //                 // $('.modal-footer').show();
    //             }).done(function(res) {
    //                 // console.log(res);
    //                 $('#load-modal').html(res.html);
    //                 $('#commonModalID').modal('toggle');
    //             });
    //             // updateStatus('Reject');
    //         }
    //     });
    // });

    $(document).on('click', '.jsReEvaluation', function(e) {
        e.preventDefault();
        message.fire({
            title: 'Are you sure',
            text: "You want to confirm this ?",
            type: 'warning',
            customClass: {
                confirmButton: 'btn btn-success shadow-sm ',
                cancelButton: 'btn btn-danger shadow-sm'
            },
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.value) {
               
            } else if (result.dismiss && result.dismiss == 'cancel') {
                // updateStatus('Cancel');
            }
        });
    });

    /*$(document).on('click', '.jsTenderEvaluationBtn', function(e) {
        e.preventDefault();
        message.fire({
            title: 'Are you sure',
            text: "You want to approve this ?",
            type: 'warning',
            customClass: {
                confirmButton: 'btn btn-success shadow-sm ',
                cancelButton: 'btn btn-danger shadow-sm'
            },
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Reject',
            // html: '<button id="rejectBtn" data-toggle="modal" data-url="{{ route('proposal-rejection-reason', $proposal_id) }}" data-target-modal="#commonModalID" class="btn btn-danger call-modal shadow-sm">Reject</button>',
        }).then((result) => {
            if (result.value) {
                updateStatus('Approve');
            } else if (result.dismiss && result.dismiss == 'cancel') {
                $.ajax({
                    type: "GET",
                    url: "{{ route('proposal-rejection-reason', [$proposal_id]) }}",
                }).always(function() {
                    $('#load-modal').html(' ')
                }).done(function(res) {
                    $('#load-modal').html(res.html);
                    $('#commonModalID').modal('toggle');
                    // updateStatus('Reject');
                });
            }
        });
    }); */

    function updateStatus(newStatus) {
        $.ajax({
                type: "POST",
                url: '{{ $proposals_status_url }}',
                cache: false,
                data: {
                    'new_status': newStatus,
                    current_status: 'Confirm'
                },
            }).always(function(respons) {})
            .done(function(respons) {
                location.reload();
            }).fail(function(respons) {
                var res = respons.responseJSON;
                var msg = 'something went wrong please try again !';
                if (res.errormessage) {
                    toastr.warning(res.errormessage, "Warning");
                }
                toastr.error(msg, "Error");
            });
    }

    $('#rejectedReasonTenderEvaluation').on('show.bs.modal', function(e) {
        var rejectionReason = $(e.relatedTarget).attr('data-id');
        var modal = $(this);

        modal.find('.rejectionReason').attr('data-id', rejectionReason);

        $.ajax({
            url: '/fetch-rejection-reason',
            method: 'GET',
            data: {
                tender_evaluation_id: rejectionReason
            },
            success: function(response) {
                modal.find('.rejectionReason .description').html(response.remarks);
                modal.find('.rejectionReason .reason').html(response.rejection_reason);
            },
            error: function() {
                modal.find('.rejectionReason').html('No rejection reason available.');
            }
        });
    });

       $('#IntermediaryLatterForSignForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                $('.jsBtnLoader').prop('disabled', true);
                return true;
            }
        });

    $('.indemnityLetterType').change(function(){
            var indemnityLetterType = $('.indemnityLetterType:checked').val();
            
            if (indemnityLetterType === 'Manually') {
                $('.indemnityLetterManualSection').removeClass('d-none');
                $('.indemnityLetterDocument').addClass('required');

                $('.indemnityLetterLeegalitySection').addClass('d-none');
                $('.indemnitySigningThrough').removeClass("required");
            }else{
                $('.indemnityLetterManualSection').addClass('d-none');
                $('.indemnityLetterDocument').removeClass('required');
                
                $('.indemnityLetterLeegalitySection').removeClass('d-none');
                $('.indemnitySigningThrough').addClass("required");
            }
    });
</script>
