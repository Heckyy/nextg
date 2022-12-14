$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_warehouse 	= document.getElementById("code_warehouse").value;
    	var warehouse 		= document.getElementById("warehouse").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		warehouse = warehouse.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		warehouse = warehouse.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_warehouse='+code_warehouse;
		data += '&warehouse='+warehouse;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/warehouse/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/warehouse/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_warehouse 	= document.getElementById("code_warehouse").value;
    	var warehouse 		= document.getElementById("warehouse").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		warehouse = warehouse.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		warehouse = warehouse.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_warehouse='+code_warehouse;
		data += '&warehouse='+warehouse;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/warehouse/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/warehouse/view/"+data;

					}
				}

			})
 			return false;
	});
});
