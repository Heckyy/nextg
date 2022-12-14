$(document).ready(function() {

	$("#coordinator").select2({
	    theme: "bootstrap-5",
	});
	$("#contractor").select2({
	    theme: "bootstrap-5",
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_coordinator 	= document.getElementById("code_coordinator").value;
    	var coordinator 		= document.getElementById("coordinator").value;
    	var contractor 		= document.getElementById("contractor").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		coordinator = coordinator.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		coordinator = coordinator.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_coordinator='+code_coordinator;
		data += '&coordinator='+coordinator;
		data += '&contractor='+contractor;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/coordinator/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/coordinator/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_coordinator 	= document.getElementById("code_coordinator").value;
    	var coordinator 		= document.getElementById("coordinator").value;
    	var contractor 		= document.getElementById("contractor").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		coordinator = coordinator.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		coordinator = coordinator.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_coordinator='+code_coordinator;
		data += '&coordinator='+coordinator;
		data += '&contractor='+contractor;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/coordinator/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/coordinator/edit/"+data;

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
				url:localStorage.getItem('data_link')+"/src/coordinator/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/coordinator/edit/"+data;

				}

			})

			return false;
		
		}

    })
}