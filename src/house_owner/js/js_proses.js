$(document).ready(function() {

	var surface_area = document.getElementById("surface_area"); 
    var building_area = document.getElementById("building_area"); 

    surface_area.addEventListener("keyup", function(e) { 
        surface_area.value = convertRupiah(this.value); 
    }); 

    surface_area.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });


    building_area.addEventListener("keyup", function(e) { 
        building_area.value = convertRupiah(this.value); 
    }); 

    building_area.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });


	$("#cluster").select2({
	    theme: "bootstrap-5",
	});

	$("#rt").select2({
	    theme: "bootstrap-5",
	});

	$("#type_property").select2({
	    theme: "bootstrap-5",
	});

	$("#status").select2({
	    theme: "bootstrap-5",
	});


    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code 			= document.getElementById("code_population").value;
    	var name 		= document.getElementById("name").value;
    	var kk 				= document.getElementById("kk").value;
    	var ktp 			= document.getElementById("ktp").value;
    	var cluster 			= document.getElementById("cluster").value;
    	var surface_area 			= document.getElementById("surface_area").value;
    	var building_area 			= document.getElementById("type_property").value;
    	var type_property 			= document.getElementById("type_property").value;
    	var rt 				= document.getElementById("rt").value;
    	var number 			= document.getElementById("number").value;

    	var address 		= document.getElementById("address").value;
    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;

    	var note        	= document.getElementById("note").value;

    	var status        	= document.getElementById("status").value;
		var data 			= "";
		
			note = note.replace("&", "and_symbol");
			address = address.replace("&", "and_symbol");

	    	data += '&code='+code;
	    	data += '&name='+name;
	    	data += '&kk='+kk;
	    	data += '&ktp='+ktp;
	    	data += '&cluster='+cluster;
	    	data += '&surface_area='+surface_area;
	    	data += '&building_area='+building_area;
	    	data += '&type_property='+type_property;
	    	data += '&rt='+rt;
	    	data += '&number='+number;

	    	data += '&address='+address;
	    	data += '&telp='+telp;
	    	data += '&hp='+hp;

			data += '&note='+note;
			data += '&status='+status;
			data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){
						
						document.getElementById("btn").disabled = false; 
						Swal.fire("", "The house number is already in use!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/house-owner/view/"+data;

					}

				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var code_population_real 			= document.getElementById("code_population_real").value;
    	var code 			= document.getElementById("code_population").value;
    	var name 		= document.getElementById("name").value;
    	var kk 				= document.getElementById("kk").value;
    	var ktp 			= document.getElementById("ktp").value;
    	var cluster 			= document.getElementById("cluster").value;
    	var surface_area 			= document.getElementById("surface_area").value;
    	var building_area 			= document.getElementById("building_area").value;
    	var type_property 			= document.getElementById("type_property").value;
    	var rt 				= document.getElementById("rt").value;
    	var number 			= document.getElementById("number").value;

    	var address 		= document.getElementById("address").value;
    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;

    	var note        	= document.getElementById("note").value;

    	var status        	= document.getElementById("status").value;
		var data 			= "";
		
			note = note.replace("&", "and_symbol");
			address = address.replace("&", "and_symbol");

	    	data += '&code_population_real='+code_population_real;
	    	data += '&code='+code;
	    	data += '&name='+name;
	    	data += '&kk='+kk;
	    	data += '&ktp='+ktp;
	    	data += '&cluster='+cluster;
	    	data += '&surface_area='+surface_area;
	    	data += '&building_area='+building_area;
	    	data += '&type_property='+type_property;
	    	data += '&rt='+rt;
	    	data += '&number='+number;

	    	data += '&address='+address;
	    	data += '&telp='+telp;
	    	data += '&hp='+hp;

			data += '&note='+note;
			data += '&status='+status;
			data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/house-owner/view/"+data;

					}

				}

			})
 			return false;
	});


	$('#cluster').on('change', function() {

	  	var id =  this.value ;
	  	var data = "";
	  	var html = "";
	  	data += '&id='+id;
	  	data += '&proses=cari_rt';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				html +='<option value="">Select</option>';

				response = JSON.parse(data);

			        if(response.length) {

			          	$.each(response, function(key,trk) {

			          		html +='<option value="'+trk.id_rt+'">'+trk.number+'</option>';
			          	});

				}

				$("#rt").html(html);

			}

		})

		return false;

	});


	function rt(e){
	  	var data = "";

	  	data += '&id='+e;
	  	data += '&proses=rt';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#rt").html(data);
			}

		})

		return false;
	}

	function house_number(e){
	  	var data = "";

	  	data += '&id='+e;
	  	data += '&proses=house_number';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
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


   $('#surface_area').on('keyup', function(){
		hitung();
   });

   $('#building_area').on('keyup', function(){
		hitung();
   });

   $('#number').on('change', function() {
   		code_population();
   });

});

function get_data_other(){
	hitung();
	code_population();
}

function hitung(){

	var cluster 		= document.getElementById("cluster").value;
    var type_property 	= document.getElementById("type_property").value;
    var surface_area 	= document.getElementById("surface_area").value;
    var building_area 	= document.getElementById("building_area").value;

    if(cluster>0){

	  	var data = "";

	  	data += '&cluster='+cluster;
	  	data += '&type_property='+type_property;
	  	data += '&surface_area='+surface_area;
	  	data += '&building_area='+building_area;
	  	data += '&proses=hitung';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#hitung").html(data);
			}

		})

		return false;

    }else{

    	Swal.fire("", "Cluster data must be filled", "error");
    	
    }
}


function code_population(){
	var cluster 		= document.getElementById("cluster").value;
	var number 		= document.getElementById("number").value;
	var data = "";

	data += '&cluster='+cluster;
	data += '&number='+number;
	data += '&proses=code_population';

		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
			method:"POST",
			data:data,
			type: 'json',
			cache:false,
			success: function(data) {

				$("#code_population").val(data);
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
				url:localStorage.getItem('data_link')+"/src/house_owner/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/house-owner";

				}

			})

			return false;
		
		}

    })
}
