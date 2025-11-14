<script type="text/javascript">
	$(document).on('click', '.jsProposalNbiPendingBtn', function(e) {
	    e.preventDefault();
	    message.fire({
	        title: 'Are you sure',
	        text: "You want to Approved this ?",
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
				updateProposalNbiStatus($(this).attr('data-id'),'Approved');
	        } else if (result.dismiss && result.dismiss == 'cancel'){
				message.fire({
                    title: "Reason",
                    input: "select",
                    inputOptions:rejection_reasons,
                    inputPlaceholder: "Select Rejection Reasons",
                    showCancelButton: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
                    inputValidator: (value) => {
                        return new Promise((resolve,reject) => {
                            rejection_reason_id = value;
                            resolve();
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
						if(result.dismiss && result.dismiss == 'cancel') {
							//
						} else {
							updateProposalNbiStatus($(this).attr('data-id'),'Rejected', rejection_reason_id);
						}
                	});
			}
	    });
	});

	$(document).on('click', '.jsNbiRejectedBtn', function(e) {
	    e.preventDefault();
	    message.fire({
	        title: 'Are you sure',
	        text: "You want to Reject this ?",
	        type: 'warning',
	        customClass: {
	            confirmButton: 'btn btn-danger shadow-sm ',
	            cancelButton: 'btn btn-success shadow-sm'
	        },
	        buttonsStyling: false,
	        showCancelButton: true,
	        confirmButtonText: 'Reject',
	        cancelButtonText: 'Cancel',
	    }).then((result) => {
	        if (result.value) {
				message.fire({
                    title: "Reason",
                    input: "select",
                    inputOptions:rejection_reasons,
                    inputPlaceholder: "Select Rejection Reasons",
                    showCancelButton: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
                    inputValidator: (value) => {
                        return new Promise((resolve,reject) => {
							rejection_reason_id = value;
							resolve();
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
						if(result.dismiss && result.dismiss == 'cancel') {
							//
						} else {
							updateProposalNbiStatus($(this).attr('data-id'),'Rejected', rejection_reason_id);
						}
                	});
	        } else if (result.dismiss && result.dismiss == 'cancel'){
			}
	    });
	});

	function updateProposalNbiStatus(id,newStatus, rejection_reason_id){
		$.ajax({
			type:'POST',
			url:"{{route('nbi-status-change')}}",
			// 'cache': false,
			data:{
				'id':id,
				'new_status':newStatus,
				'rejection_reason_id':rejection_reason_id,
			},
		}).done(function(res){
			location.reload();
		}).fail(function(respons){
			var res = respons.responseJSON;
	        var msg = 'something went wrong please try again !';
	        if (res.errormessage) {
	            toastr.warning(res.errormessage, "Warning");
	        }
	        toastr.error(msg, "Error");
		});
	}

	$(document).on('click', '.jsTerminateProposal', function(e) {
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
            confirmButtonText: 'Cancel',
            cancelButtonText: 'Close',
        }).then((result) => {
            if (result.value) {
               terminateProposal($(this).attr('data-id'));
            } else if (result.dismiss && result.dismiss == 'cancel') {
            }
        });
    });

	function terminateProposal(nbiId) {
        $.ajax({
			type: "POST",
			url: '{{ route("terminateProposal") }}',
			cache: false,
			data: {
				'nbi_id': nbiId,
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
</script>