$(document).ready(function() {

	$("#type_of_work").select2({
	    theme: "bootstrap-5",
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_contractor 	= document.getElementById("code_contractor").value;
    	var contractor 		= document.getElementById("contractor").value;
    	var type_of_work 		= document.getElementById("type_of_work").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		contractor = contractor.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		contractor = contractor.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_contractor='+code_contractor;
		data += '&contractor='+contractor;
		data += '&type_of_work='+type_of_work;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/contractor/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/contractor/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_contractor 	= document.getElementById("code_contractor").value;
    	var contractor 		= document.getElementById("contractor").value;
    	var type_of_work 		= document.getElementById("type_of_work").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		contractor = contractor.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		contractor = contractor.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_contractor='+code_contractor;
		data += '&contractor='+contractor;
		data += '&type_of_work='+type_of_work;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/contractor/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/contractor/view/"+data;

					}
				}

			})
 			return false;
	});
});
