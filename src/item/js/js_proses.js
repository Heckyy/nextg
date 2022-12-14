$(document).ready(function() {
	$("#type_of_item").select2({
	    theme: "bootstrap-5",
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var item 		= document.getElementById("item").value;
    	var type_of_item 		= document.getElementById("type_of_item").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		// USER SANITASI INPUT

		// item = item.replace("&", "and_symbol");
		// note = note.replace("&", "and_symbol");

		// // item = item.replace("&", "and_symbol");
		// note = note.replace("&", "and_symbol");

		// END OF SANITASI 
		
		data += '&item='+item;
		data += '&type_of_item='+type_of_item;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/item/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/item/view/"+data;

				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var item 		= document.getElementById("item").value;
    	var type_of_item 		= document.getElementById("type_of_item").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";


		// USER INPUT SANITASI

		// item = item.replace("&", "and_symbol");
		// note = note.replace("&", "and_symbol");

		// item = item.replace("&", "and_symbol");
		// note = note.replace("&", "and_symbol");

		//END OF INPUT SANITASI USER

		data += '&item='+item;
		data += '&type_of_item='+type_of_item;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/item/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/item/view/"+data;

					}
				}

			})
 			return false;
	});
});
