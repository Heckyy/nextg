$(document).ready(function() {

	$("#cluster").select2({
	    theme: "bootstrap-5",
	});


    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 

    	var code_rt 			= document.getElementById("code_rt").value;
    	var cluster 			= document.getElementById("cluster").value;
    	var rt 			= document.getElementById("rt").value;
    	var ketua_rt 		= document.getElementById("ketua_rt").value;
    	var address 	= document.getElementById("address").value;

    	var wakil_rt 		= document.getElementById("wakil_rt").value;
    	var address_wakil 	= document.getElementById("address_wakil").value;

    	var note        = document.getElementById("note").value;
		var data 		= "";
		

		data += '&code_rt='+code_rt;

		data += '&rt='+rt;
		data += '&cluster='+cluster;
		data += '&ketua_rt='+ketua_rt;
		data += '&address='+address;

		data += '&wakil_rt='+wakil_rt;
		data += '&address_wakil='+address_wakil;

		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){
						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/rt/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_rt 			= document.getElementById("code_rt").value;
    	var rt 			= document.getElementById("rt").value;
    	var cluster 			= document.getElementById("cluster").value;
    	var ketua_rt 		= document.getElementById("ketua_rt").value;
    	var address 	= document.getElementById("address").value;

    	var wakil_rt 		= document.getElementById("wakil_rt").value;
    	var address_wakil 	= document.getElementById("address_wakil").value;

    	var note        = document.getElementById("note").value;
		var data 		= "";
		

		data += '&code_rt='+code_rt;

		data += '&rt='+rt;
		data += '&cluster='+cluster;
		data += '&ketua_rt='+ketua_rt;
		data += '&address='+address;

		data += '&wakil_rt='+wakil_rt;
		data += '&address_wakil='+address_wakil;

		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/rt/view/"+data;

					}
				}

			})
 			return false;
	});

	$('#citizen_code').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				response = JSON.parse(data);

			        if(response.length) {

			        	html+='<option value="">Select</option>';

			          	$.each(response, function(key,trk) {

				            html += '<option value="'+trk.id+'">'+trk.name+'</option>';

						});

					}else{
						html+='<option value="">Select</option>';
					}

					$("#ketua_rt").html(html);

			}

		})

		return false;

	});


	$('#ketua_rt').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population_address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address").html(data);

			}

		})

		return false;

	});



	$('#citizen_code_wakil').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				response = JSON.parse(data);

			        if(response.length) {

			        	html+='<option value="">Select</option>';

			          	$.each(response, function(key,trk) {

				            html += '<option value="'+trk.id+'">'+trk.name+'</option>';

						});

					}else{
						html+='<option value="">Select</option>';
					}

					$("#wakil_rt").html(html);

			}

		})

		return false;

	});


	$('#wakil_rt').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population_address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rt/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_wakil").html(data);

			}

		})

		return false;

	});

});
