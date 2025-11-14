<script type="text/javascript">
	$(document).on('click', '.jsNbiPendingBtn', function(e) {
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
	        cancelButtonText: 'Cancel',
	    }).then((result) => {
	        if (result.value) {
	           updateNbiStatus($(this).attr('data-id'),'Approved');
	        }
	    });
	});	
	function updateNbiStatus(id,newStatus){
		$.ajax({
			type:'POST',
			url:"{{route('bond-nbi-status-change')}}",
			// 'cache': false,
			data:{
				'id':id,
				'new_status':newStatus,
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
</script>