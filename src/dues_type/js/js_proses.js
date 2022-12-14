$(document).ready(function() {
    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_dues 	= document.getElementById("code_dues").value;
    	var dues_type 	= document.getElementById("dues_type").value;
    	var note         		= document.getElementById("note").value;
		var data 			 	= "";
		
		dues_type = dues_type.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_dues='+code_dues;
		data += '&dues_type='+dues_type;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/dues_type/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/dues-type/view/"+data;

					}
				}

			})
 			return false;
	});
    $('#edit').submit(function() {
    	var code_dues 	= document.getElementById("code_dues").value;
    	var dues_type 	= document.getElementById("dues_type").value;
    	var note         		= document.getElementById("note").value;
		var data 			 	= "";
		
		dues_type = dues_type.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_dues='+code_dues;
		data += '&dues_type='+dues_type;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/dues_type/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/dues-type/view/"+data;

					}
				}

			})
 			return false;
	});
});
