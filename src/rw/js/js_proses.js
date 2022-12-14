$(document).ready(function() {

    $('#edit').submit(function() {
    	var ketua_rw 				= document.getElementById("ketua_rw").value;
    	var address 				= document.getElementById("address").value;
    	var wakil_rw 				= document.getElementById("wakil_rw").value;
    	var address_representative	= document.getElementById("address_representative").value;
    	var finance_monitoring 				= document.getElementById("finance_monitoring").value;
    	var address_finance_monitoring 		= document.getElementById("address_finance_monitoring").value;
    	var treasurer 				= document.getElementById("treasurer").value;
    	var address_treasurer 		= document.getElementById("address_treasurer").value;
    	var estate_manager 				= document.getElementById("estate_manager").value;
    	var address_estate_manager 		= document.getElementById("address_estate_manager").value;
    	var purchasing 				= document.getElementById("purchasing").value;
    	var address_purchasing 		= document.getElementById("address_purchasing").value;
    	var admin 				= document.getElementById("admin").value;
    	var address_admin 		= document.getElementById("address_admin").value;
   
		var data 		= "";
		

    	data += '&ketua_rw='+ketua_rw;
    	data += '&address='+address;
    	data += '&wakil_rw='+wakil_rw;
    	data += '&address_representative='+address_representative;
    	data += '&finance_monitoring='+finance_monitoring;
    	data += '&address_finance_monitoring='+address_finance_monitoring;
    	data += '&treasurer='+treasurer;
    	data += '&address_treasurer='+address_treasurer;
    	data += '&estate_manager='+estate_manager;
    	data += '&address_estate_manager='+address_estate_manager;
    	data += '&purchasing='+purchasing;
    	data += '&address_purchasing='+address_purchasing;
    	data += '&admin='+admin;
    	data += '&address_admin='+address_admin;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {
					
					document.location.href=localStorage.getItem('data_link')+"/rw";

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
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#ketua_rw").html(html);

			}

		})

		return false;

	});


	$('#ketua_rw').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#wakil_rw").html(html);

			}

		})

		return false;

	});


	$('#wakil_rw').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_representative").html(data);

			}

		})

		return false;

	});



	$('#citizen_code_finance_monitoring').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#finance_monitoring").html(html);

			}

		})

		return false;

	});


	$('#finance_monitoring').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_finance_monitoring").html(data);

			}

		})

		return false;

	});	



	$('#citizen_code_treasurer').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#treasurer").html(html);

			}

		})

		return false;

	});


	$('#treasurer').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_treasurer").html(data);

			}

		})

		return false;

	});	



	$('#citizen_code_quality_control').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#quality_control").html(html);

			}

		})

		return false;

	});


	$('#quality_control').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_quality_control").html(data);

			}

		})

		return false;

	});	



	$('#citizen_code_estate_manager').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#estate_manager").html(html);

			}

		})

		return false;

	});


	$('#estate_manager').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_estate_manager").html(data);

			}

		})

		return false;

	});	


	$('#citizen_code_purchasing').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#purchasing").html(html);

			}

		})

		return false;

	});


	$('#purchasing').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_purchasing").html(data);

			}

		})

		return false;

	});	

	$('#citizen_code_admin').on('change', function() {

		var html= '';
	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
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

					$("#admin").html(html);

			}

		})

		return false;

	});


	$('#admin').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";

	  	data += '&id='+id;
	  	data += '&proses=address';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/rw/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#address_admin").html(data);

			}

		})

		return false;

	});	






});
