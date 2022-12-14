$(document).ready(function() {
    $('#edit').submit(function() {
    	var group_account 	= document.getElementById("group_account").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		group_account = group_account.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&group_account='+group_account;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/group_account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/account/group-account/view/"+data;

				}

			})
 			return false;
	});
});
