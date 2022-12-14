$(document).ready(function() {
    $('#edit').submit(function() {
    	var type_of_account 	= document.getElementById("type_of_account").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_account = type_of_account.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&type_of_account='+type_of_account;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/type-of-account/view/"+data;

				}

			})
 			return false;
	});
});
