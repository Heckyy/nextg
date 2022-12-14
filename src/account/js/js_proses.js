$(document).ready(function() {

	$("#type_of_account").select2({
	    theme: "bootstrap-5",
	});

	$("#sub_account_from").select2({
	    theme: "bootstrap-5",
	});

	$("#sub_account_from_2").select2({
	    theme: "bootstrap-5",
	});


	$("#position").select2({
	    theme: "bootstrap-5",
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var type_of_account 	= document.getElementById("type_of_account").value;
    	var sub_account_from 		= document.getElementById("sub_account_from").value;
    	var sub_account_from_2 		= document.getElementById("sub_account_from_2").value;
    	var account_number 		= document.getElementById("account_number").value;
    	var account 		= document.getElementById("account").value;
    	var position 		= document.getElementById("position").value;
    	var type_of_report 		= document.getElementById("type_of_report").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_account = type_of_account.replace("&", "and_symbol");
		sub_account_from = sub_account_from.replace("&", "and_symbol");
		sub_account_from_2 = sub_account_from_2.replace("&", "and_symbol");
		account_number = account_number.replace("&", "and_symbol");
		account = account.replace("&", "and_symbol");
		position = position.replace("&", "and_symbol");
		type_of_report = type_of_report.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&type_of_account='+type_of_account;
		data += '&sub_account_from='+sub_account_from;
		data += '&sub_account_from_2='+sub_account_from_2;
		data += '&account_number='+account_number;
		data += '&account='+account;
		data += '&position='+position;
		data += '&type_of_report='+type_of_report;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Account Number already used, please enter another Account Number!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/account/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var type_of_account 	= document.getElementById("type_of_account").value;
    	var sub_account_from 		= document.getElementById("sub_account_from").value;
    	var sub_account_from_2 		= document.getElementById("sub_account_from_2").value;
    	var account_number 		= document.getElementById("account_number").value;
    	var account 		= document.getElementById("account").value;
    	var position 		= document.getElementById("position").value;
    	var type_of_report 		= document.getElementById("type_of_report").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_account = type_of_account.replace("&", "and_symbol");
		sub_account_from = sub_account_from.replace("&", "and_symbol");
		sub_account_from_2 = sub_account_from_2.replace("&", "and_symbol");
		account_number = account_number.replace("&", "and_symbol");
		account = account.replace("&", "and_symbol");
		position = position.replace("&", "and_symbol");
		type_of_report = type_of_report.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&type_of_account='+type_of_account;
		data += '&sub_account_from='+sub_account_from;
		data += '&sub_account_from_2='+sub_account_from_2;
		data += '&account_number='+account_number;
		data += '&account='+account;
		data += '&position='+position;
		data += '&type_of_report='+type_of_report;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Account Number already used, please enter another Account Number!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/account/view/"+data;

					}
				}

			})
 			return false;
	});


	$('#sub_account_from').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";
	  	var html = "";
	  	data += '&id='+id;
	  	data += '&proses=ambil_nomor';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#account_number").val(data);

			}

		})

		return false;

	});

	$('#sub_account_from_2').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";
	  	var html = "";
	  	data += '&id='+id;
	  	data += '&proses=ambil_nomor_lagi';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#account_number").val(data);

			}

		})

		return false;

	});


});

function account_sub(){

	var type_of_account 	= document.getElementById("type_of_account").value;

	if(type_of_account>0){

		var data="";

		data += '&type_of_account='+type_of_account;
		data += '&proses=sub';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					$("#sub_account_from").html(data);

				}

			})

			type_of_report(type_of_account);

 			return false;

	}else{

		$("#sub_account_from").html('<option value="">Select</option>');

	}

	
}

function account_sub_2(){

	var type_of_account 	= document.getElementById("type_of_account").value;
	var sub_account_from 	= document.getElementById("sub_account_from").value;

	if(sub_account_from>0){

		var data="";

		data += '&type_of_account='+type_of_account;
		data += '&sub='+sub_account_from;
		data += '&proses=sub_2';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					$("#sub_account_from_2").html(data);

				}

			})

			type_of_report(type_of_account);

 			return false;

	}else{

		$("#sub_account_from_2").html('<option value="">Select</option>');

	}

	
}
function type_of_report(e){

	if(e>0){

		var data="";

		data += '&type_of_account='+e;
		data += '&proses=type_of_report';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {


					$("#type_of_report").val(data);

				}

			})
 			return false;

	}else{

		$("#type_of_report").val('');

	}
}

function position(e){

	if(e>0){

		var data="";

		data += '&type_of_account='+e;
		data += '&proses=position';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/account/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {


					$("#position").val(data);

				}

			})
 			return false;

	}else{

		$("#position").val('');

	}
}


