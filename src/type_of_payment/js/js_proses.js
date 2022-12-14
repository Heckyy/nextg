$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_type_of_payment 	= document.getElementById("code_type_of_payment").value;
    	var type_of_payment 		= document.getElementById("type_of_payment").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_payment = type_of_payment.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_type_of_payment='+code_type_of_payment;
		data += '&type_of_payment='+type_of_payment;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-payment/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_type_of_payment 	= document.getElementById("code_type_of_payment").value;
    	var type_of_payment 		= document.getElementById("type_of_payment").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";
		
		type_of_payment = type_of_payment.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_type_of_payment='+code_type_of_payment;
		data += '&type_of_payment='+type_of_payment;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-payment/view/"+data;

					}
				}

			})
 			return false;
	});
});
