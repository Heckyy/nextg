$(document).ready(function() {

    $('#edit_acn_purchasing').submit(function() {

   		var data 			 	= $(this).serialize();

		data += '&proses=edit_acn_purchasing';
					

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/setting_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/pcg/purchasing";

				}

			})
 			return false;
	});

	$('#edit_fn_type_of_receipt').submit(function() {

   		var data 			 	= $(this).serialize();

		data += '&proses=edit_fn_type_of_receipt';
					

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/setting_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/fn/type-of-receipt";

				}

			})
 			return false;
	});

	$('#edit_fn_type_of_payment').submit(function() {

   		var data 			 	= $(this).serialize();

		data += '&proses=edit_fn_type_of_payment';
					

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/setting_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/fn/type-of-payment";

				}

			})
 			return false;
	});

    $('#edit_wh_type_of_receipt').submit(function() {

   		var data 			 	= $(this).serialize();

		data += '&proses=edit_wh_type_of_receipt';
					

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/setting_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/wh/type-of-receipt";

				}

			})
 			return false;
	});

	$('#edit_wh_type_of_out').submit(function() {

   		var data 			 	= $(this).serialize();

		data += '&proses=edit_wh_type_of_out';
					

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/setting_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/wh/type-of-out";

				}

			})
 			return false;
	});

});
