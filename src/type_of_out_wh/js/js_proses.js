$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_type_of_out_wh 	= document.getElementById("code_type_of_out_wh").value;
    	var type_of_out_wh 		= document.getElementById("type_of_out_wh").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_out_wh = type_of_out_wh.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		type_of_out_wh = type_of_out_wh.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_type_of_out_wh='+code_type_of_out_wh;
		data += '&type_of_out_wh='+type_of_out_wh;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_out_wh/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-out-wh/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_type_of_out_wh 	= document.getElementById("code_type_of_out_wh").value;
    	var type_of_out_wh 		= document.getElementById("type_of_out_wh").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_out_wh = type_of_out_wh.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		type_of_out_wh = type_of_out_wh.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_type_of_out_wh='+code_type_of_out_wh;
		data += '&type_of_out_wh='+type_of_out_wh;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_out_wh/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-out-wh/view/"+data;

					}
				}

			})
 			return false;
	});
});
