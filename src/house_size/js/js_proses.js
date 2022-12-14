$(document).ready(function() {
	
	var amount = document.getElementById("amount"); 

    amount.addEventListener("keyup", function(e) { 
        amount.value = convertRupiah(this.value); 
    }); 

    amount.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    });

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 
		
    	var code_house_size 	= document.getElementById("code_house_size").value;
    	var house_size 		= document.getElementById("house_size").value;
    	var amount        = document.getElementById("amount").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		house_size = house_size.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		house_size = house_size.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		
		data += '&code_house_size='+code_house_size;
		data += '&house_size='+house_size;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/house_size/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/house-size/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_house_size 	= document.getElementById("code_house_size").value;
    	var house_size 		= document.getElementById("house_size").value;
    	var amount        = document.getElementById("amount").value;
    	var note        = document.getElementById("note").value;
		var data 		= "";

		house_size = house_size.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		house_size = house_size.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&code_house_size='+code_house_size;
		data += '&house_size='+house_size;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/house_size/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/house-size/view/"+data;

					}
				}

			})
 			return false;
	});
});
