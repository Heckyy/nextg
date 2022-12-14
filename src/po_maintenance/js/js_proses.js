$(document).ready(function() {

	$("#permintaan").select2({
	    theme: "bootstrap-5",
	});
	$("#cluster").select2({
	    theme: "bootstrap-5",
	});
	$("#divisi").select2({
	    theme: "bootstrap-5",
	});
	$("#employee").select2({
	    theme: "bootstrap-5",
	});




    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 

		var data 			 	= $(this).serialize();
    	var supplier        	= document.getElementById("supplier").value;
     	var permintaan        	= document.getElementById("permintaan").value;
   	
   		supplier = supplier.replace("&", "and_symbol");
		permintaan = permintaan.replace("&", "and_symbol");

		data += '&supplier='+supplier;
		data += '&permintaan='+permintaan;
		data += '&proses=new';


			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {


					if(data==1){
						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/po-maintenance/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var number 				= document.getElementById("number").value;
    	var note        		= document.getElementById("note").value;
		var data 			 	= $(this).serialize();

		note = note.replace("&", "and_symbol");

		data += '&number='+number;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/po-maintenance/edit/"+data;

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
				url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/po-maintenance/edit/"+data;

				}

			})

			return false;
		
		}

    })
}

function cancel(){

    Swal.fire({
      text: 'Apakah Anda Yakin???',
      showDenyButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&proses=cancel';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/po-maintenance/view/"+data;

				}

			})

			return false;
		
		}

    })
}

function process_transaction(){

    Swal.fire({
      text: 'Apakah Anda Yakin???',
      showDenyButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&proses=process';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/po-maintenance/view/"+data;

				}

			})

			return false;
		
		}

    })
}

function nomor_permintaan(){
	var x = document.getElementById("permintaan").value;

	var data 		= "";
				
	data += '&id='+x;
	data += '&proses=permintaan_cluster';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#cluster").html(data);

		}

	})

	var data 		= "";
				
	data += '&id='+x;
	data += '&proses=permintaan_divisi';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#divisi").html(data);

		}

	})

	var data 		= "";
				
	data += '&id='+x;
	data += '&proses=permintaan_pengurus';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#employee").html(data);

		}

	})

	var data 		= "";
				
	data += '&id='+x;
	data += '&proses=permintaan_item';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#detail").html(data);

		}

	})

	return false;

}
    
function hitung(e){
	var x = document.getElementById("amount"+e).value;
	var q = document.getElementById("qty"+e).value;

	var data 		= "";
				
	data += '&a='+x;
	data += '&b='+q;
	data += '&proses=hitung';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/po_maintenance/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#total"+e).val(data);

		}

	})

	return false;
}