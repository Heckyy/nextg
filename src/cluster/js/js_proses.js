$(document).ready(function() {

	var the_land_price = document.getElementById("the_land_price"); 
	var building_price = document.getElementById("building_price"); 
	var macro_price = document.getElementById("macro_price"); 
	var empty_land = document.getElementById("empty_land"); 

    the_land_price.addEventListener("keyup", function(e) { 
        the_land_price.value = convertRupiah(this.value); 
    }); 

    the_land_price.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });

    building_price.addEventListener("keyup", function(e) { 
        building_price.value = convertRupiah(this.value); 
    }); 

    building_price.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });

    macro_price.addEventListener("keyup", function(e) { 
        macro_price.value = convertRupiah(this.value); 
    }); 

    macro_price.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });

    empty_land.addEventListener("keyup", function(e) { 
        empty_land.value = convertRupiah(this.value); 
    }); 

    empty_land.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_cluster 	= document.getElementById("code_cluster").value;
    	var cluster 		= document.getElementById("cluster").value;
    	var the_land_price 		= document.getElementById("the_land_price").value;
    	var building_price 		= document.getElementById("building_price").value;
    	var macro_price 		= document.getElementById("macro_price").value;
    	var empty_land 		= document.getElementById("empty_land").value;
    	var address 	= document.getElementById("address").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";
		
		cluster = cluster.replace("&", "and_symbol");
		address = address.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_cluster='+code_cluster;
		data += '&cluster='+cluster;
		data += '&the_land_price='+the_land_price;
		data += '&building_price='+building_price;
		data += '&macro_price='+macro_price;
		data += '&empty_land='+empty_land;
		data += '&address='+address;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cluster/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cluster/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var code_cluster 	= document.getElementById("code_cluster").value;
    	var cluster 		= document.getElementById("cluster").value;
    	var the_land_price 		= document.getElementById("the_land_price").value;
    	var building_price 		= document.getElementById("building_price").value;
    	var macro_price 		= document.getElementById("macro_price").value;
    	var empty_land 		= document.getElementById("empty_land").value;
    	var address 	= document.getElementById("address").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";
		
		cluster = cluster.replace("&", "and_symbol");
		address = address.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_cluster='+code_cluster;
		data += '&cluster='+cluster;
		data += '&the_land_price='+the_land_price;
		data += '&building_price='+building_price;
		data += '&macro_price='+macro_price;
		data += '&empty_land='+empty_land;
		data += '&address='+address;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cluster/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cluster/view/"+data;

					}
				}

			})
 			return false;
	});
});
