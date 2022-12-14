$(document).ready(function() {

	$("#cluster").select2({
	    theme: "bootstrap-5",
	});

	$("#status").select2({
	    theme: "bootstrap-5",
	});


    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code 			= document.getElementById("code_warga").value;
    	var first_name 		= document.getElementById("first_name").value;
    	var last_name 		= document.getElementById("last_name").value;
    	var kk 				= document.getElementById("kk").value;
    	var ktp 			= document.getElementById("ktp").value;
    	var cluster 			= document.getElementById("cluster").value;

    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;

    	var note        	= document.getElementById("note").value;

    	var status        	= document.getElementById("status").value;
		var data 			= "";
		

	    	data += '&code='+code;
	    	data += '&first_name='+first_name;
	    	data += '&last_name='+last_name;
	    	data += '&kk='+kk;
	    	data += '&ktp='+ktp;
	    	data += '&cluster='+cluster;

	    	data += '&address='+address;
	    	data += '&telp='+telp;
	    	data += '&hp='+hp;

			data += '&note='+note;
			data += '&status='+status;
			data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/population/view/"+data;

				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var code 			= document.getElementById("code_warga").value;
    	var first_name 		= document.getElementById("first_name").value;
    	var last_name 		= document.getElementById("last_name").value;
    	var kk 				= document.getElementById("kk").value;
    	var ktp 			= document.getElementById("ktp").value;
    	var cluster 			= document.getElementById("cluster").value;

    	var address 		= document.getElementById("address").value;
    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;

    	var note        	= document.getElementById("note").value;

    	var status        	= document.getElementById("status").value;
		var data 			= "";
		


	    	data += '&code='+code;
	    	data += '&first_name='+first_name;
	    	data += '&last_name='+last_name;
	    	data += '&kk='+kk;
	    	data += '&ktp='+ktp;
	    	data += '&cluster='+cluster;

	    	data += '&address='+address;
	    	data += '&telp='+telp;
	    	data += '&hp='+hp;

			data += '&note='+note;
			data += '&status='+status;
			data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/population/view/"+data;

					}

				}

			})
 			return false;
	});




});

function get_data_other(){
	var cluster = document.getElementById("cluster").value;
	rt(cluster);
	house_number(cluster);
	address(cluster);
}


	function rt(e){
	  	var data 			= "";

	  	data += '&id='+e;
	  	data += '&proses=rt';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#rt").val(data);
			}

		})

		return false;
	}

	function house_number(e){
	  	var data 			= "";

	  	data += '&id='+e;
	  	data += '&proses=house_number';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {
				$("#number").val(data);
			}

		})

		return false;
	}

	function address(e){
	  	var data 			= "";

	  	data += '&id='+e;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {
				$("#address").val(data);
			}

		})

		return false;
	}

function delete_population(e){

    Swal.fire({
      text: 'Apakah Anda Yakin???',
      showDenyButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&id='+e;
			data += '&proses=delete';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/population/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/population";

				}

			})

			return false;
		
		}

    })
}
