$(document).ready(function() {

	$("#access").select2({
	    theme: "bootstrap-5",
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_bank_cash 	= document.getElementById("code_bank_cash").value;
    	var bank_cash 		= document.getElementById("bank_cash").value;
    	var account_number 		= document.getElementById("account_number").value;
    	var note        = document.getElementById("note").value;
    	var access        = document.getElementById("access").value;
		var data 		= "";
		
		bank_cash = bank_cash.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_bank_cash='+code_bank_cash;
		data += '&bank_cash='+bank_cash;
		data += '&account_number='+account_number;
		data += '&note='+note;
		data += '&access='+access;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/bank_cash/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {
					
					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/bank-cash/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_bank_cash 	= document.getElementById("code_bank_cash").value;
    	var bank_cash 		= document.getElementById("bank_cash").value;
    	var account_number 		= document.getElementById("account_number").value;
    	var note        = document.getElementById("note").value;
    	var access        = document.getElementById("access").value;
		var data 		= "";
		
		bank_cash = bank_cash.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_bank_cash='+code_bank_cash;
		data += '&bank_cash='+bank_cash;
		data += '&account_number='+account_number;
		data += '&note='+note;
		data += '&access='+access;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/bank_cash/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/bank-cash/edit/"+data;

					}
				}

			})
 			return false;
	});
});



function hapus(e){

    Swal.fire({
      text: 'Apakah Anda Yakin???',
      showDenyButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&id='+e;
			data += '&proses=hapus';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/bank_cash/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/bank-cash/edit/"+data;

				}

			})

			return false;
		
		}

    })
}