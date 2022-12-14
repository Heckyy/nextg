$(document).ready(function() {
	$("#unit").select2({
	    theme: "bootstrap-5",
	});
	$("#position").select2({
	    theme: "bootstrap-5",
	});
	$("#sex").select2({
	    theme: "bootstrap-5",
	});
	$("#religion").select2({
	    theme: "bootstrap-5",
	});

	 $("#date_of_birth").datepicker({
		dateFormat: "dd-mm-yy",
        changeMonth: true
	 });

    $('#new').submit(function() {

        document.getElementById("btn").disabled = true; 

    	var code_employee 	= document.getElementById("code_employee").value;
    	var name 			= document.getElementById("name").value;
    	var unit 			= document.getElementById("unit").value;
    	var position 		= document.getElementById("position").value;
    	var sex 			= document.getElementById("sex").value;
    	var religion 		= document.getElementById("religion").value;
    	var place_of_birth 	= document.getElementById("place_of_birth").value;
    	var date_of_birth 	= document.getElementById("date_of_birth").value;
    	var id_card 		= document.getElementById("id_card").value;
    	var address 		= document.getElementById("address").value;
    	var city 			= document.getElementById("city").value;
    	var postal_code 	= document.getElementById("postal_code").value;
    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;
    	var note        	= document.getElementById("note").value;
		var data 			= "";
		

    	data += '&code_employee='+code_employee;
    	data += '&name='+name;
    	data += '&unit='+unit;
    	data += '&position='+position;
    	data += '&sex='+sex;
    	data += '&religion='+religion;
    	data += '&place_of_birth='+place_of_birth;
    	data += '&date_of_birth='+date_of_birth;
    	data += '&id_card='+id_card;
    	data += '&address='+address;
    	data += '&city='+city;
    	data += '&postal_code='+postal_code;
    	data += '&telp='+telp;
    	data += '&hp='+hp;
    	data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/employee/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

                        document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/employee/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var code_employee 	= document.getElementById("code_employee").value;
    	var name 			= document.getElementById("name").value;
    	var unit 			= document.getElementById("unit").value;
    	var position 		= document.getElementById("position").value;
    	var sex 			= document.getElementById("sex").value;
    	var religion 		= document.getElementById("religion").value;
    	var place_of_birth 	= document.getElementById("place_of_birth").value;
    	var date_of_birth 	= document.getElementById("date_of_birth").value;
    	var id_card 		= document.getElementById("id_card").value;
    	var address 		= document.getElementById("address").value;
    	var city 			= document.getElementById("city").value;
    	var postal_code 	= document.getElementById("postal_code").value;
    	var telp 			= document.getElementById("telp").value;
    	var hp 				= document.getElementById("hp").value;
    	var note        	= document.getElementById("note").value;
		var data 			= "";
		

    	data += '&code_employee='+code_employee;
    	data += '&name='+name;
    	data += '&unit='+unit;
    	data += '&position='+position;
    	data += '&sex='+sex;
    	data += '&religion='+religion;
    	data += '&place_of_birth='+place_of_birth;
    	data += '&date_of_birth='+date_of_birth;
    	data += '&id_card='+id_card;
    	data += '&address='+address;
    	data += '&city='+city;
    	data += '&postal_code='+postal_code;
    	data += '&telp='+telp;
    	data += '&hp='+hp;
    	data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/employee/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/employee/view/"+data;

					}
				}

			})
 			return false;
	});
});
