$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_type_of_item 	= document.getElementById("code_type_of_item").value;
    	var type_of_item 		= document.getElementById("type_of_item").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_item = type_of_item.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_type_of_item='+code_type_of_item;
		data += '&type_of_item='+type_of_item;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_item/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-item/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_type_of_item 	= document.getElementById("code_type_of_item").value;
    	var type_of_item 		= document.getElementById("type_of_item").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		type_of_item = type_of_item.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_type_of_item='+code_type_of_item;
		data += '&type_of_item='+type_of_item;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/type_of_item/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/type-of-item/view/"+data;

					}
				}

			})
 			return false;
	});
});
