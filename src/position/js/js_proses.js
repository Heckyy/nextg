$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_position 	= document.getElementById("code_position").value;
    	var position 		= document.getElementById("position").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";
		
		position = position.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_position='+code_position;
		data += '&position='+position;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/position/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/position/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_position 	= document.getElementById("code_position").value;
    	var position 		= document.getElementById("position").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";
		
		position = position.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_position='+code_position;
		data += '&position='+position;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/position/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/position/view/"+data;

					}
				}

			})
 			return false;
	});
});
