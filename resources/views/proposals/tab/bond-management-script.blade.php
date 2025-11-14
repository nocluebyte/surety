<script type="text/javascript">
	$(document).on('click', '.jsForeClosureBtn', function(e) {
		var bond_number = {{Js::from($bond_policy_issue->bond_number ?? null)}};
		if(bond_number == null) {
			message.fire({
                text: "Add Bond Number in Bond Issued Tab first.",
                type: 'warning',
            });
		} else {
			e.preventDefault();
			message.fire({
				title: 'Are you sure',
				text: "Do you want to submit Bond ForeClosure ?",
				type: 'warning',
				customClass: {
					confirmButton: 'btn btn-success shadow-sm ',
					cancelButton: 'btn btn-danger shadow-sm'
				},
				buttonsStyling: false,
				showCancelButton: true,
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
			}).then((result) => {
				if (result.value) {
					window.location.href = $(this).attr('data-redirect');
				}
			});
		}
	});

	$(document).on('click', '.jsBondCancellationBtn', function(e) {
	    e.preventDefault();
	    message.fire({
	        title: 'Are you sure',
	        text: "Do you want to submit Bond Cancellation ?",
	        type: 'warning',
	        customClass: {
	            confirmButton: 'btn btn-success shadow-sm ',
	            cancelButton: 'btn btn-danger shadow-sm'
	        },
	        buttonsStyling: false,
	        showCancelButton: true,
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	    }).then((result) => {
	        if (result.value) {
                window.location.href = $(this).attr('data-redirect');
	        }
	    });
	});
</script>