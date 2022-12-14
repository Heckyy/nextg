$(document).ready(function() {

	var amount = document.getElementById("amount"); 

    amount.addEventListener("keyup", function(e) { 
        amount.value = convertRupiah(this.value); 
    }); 

    amount.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    }); 
    
	$("#type_of_payment").select2({
	    theme: "bootstrap-5",
	});

	$("#jenis_uang_keluar").select2({
	    theme: "bootstrap-5",
	});
	$("#cluster").select2({
	    theme: "bootstrap-5",
	});
	


	$("#tanggal_bank").datepicker({
		dateFormat: "dd-mm-yy",
        changeMonth: true
	 });

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 

    	var tanggal 			= document.getElementById("tanggal").value;
    	var cluster 			= document.getElementById("cluster").value;
    	var divisi 				= document.getElementById("divisi").value;
    	var type_of_payment 	= document.getElementById("type_of_payment").value;
    	var untuk 				= document.getElementById("untuk").value;
    	var necessity 			= document.getElementById("necessity").value;
    	var amount 				= document.getElementById("amount").value;
    	var note        		= document.getElementById("note").value;
		var data 		= "";

		untuk = untuk.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		necessity = necessity.replace("&", "and_symbol");

		data += '&tanggal='+tanggal;
		data += '&cluster='+cluster;
		data += '&divisi='+divisi;
		data += '&type_of_payment='+type_of_payment;
		data += '&untuk='+untuk;
		data += '&necessity='+necessity;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cash-payment/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#new_payroll').submit(function() {

		document.getElementById("btn").disabled = true; 

    	var cluster 			= document.getElementById("cluster").value;
    	var type_of_payment 	= document.getElementById("type_of_payment").value;
    	var untuk 				= document.getElementById("untuk_payroll").value;
    	var amount 				= document.getElementById("amount").value;
    	var note        		= document.getElementById("note").value;
		var data 		= "";

		untuk = untuk.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&cluster='+cluster;
		data += '&type_of_payment='+type_of_payment;
		data += '&untuk='+untuk;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=new_payroll';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Code already used, please enter another code!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cash-payment/view/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var number 				= document.getElementById("number").value;
    	var divisi 	= document.getElementById("divisi").value;
    	var cluster 	= document.getElementById("cluster").value;
    	var type_of_payment 	= document.getElementById("type_of_payment").value;
    	var untuk 				= document.getElementById("untuk").value;
    	var necessity 				= document.getElementById("necessity").value;
    	var amount 				= document.getElementById("amount").value;
    	var note        		= document.getElementById("note").value;
		var data 		= "";

		untuk = untuk.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");
		necessity = necessity.replace("&", "and_symbol");

		data += '&number='+number;
		data += '&divisi='+divisi;
		data += '&cluster='+cluster;
		data += '&type_of_payment='+type_of_payment;
		data += '&untuk='+untuk;
		data += '&necessity='+necessity;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {


					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cash-payment/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit_payroll').submit(function() {
    	var number 				= document.getElementById("number").value;
    	var cluster 	= document.getElementById("cluster").value;
    	var type_of_payment 	= document.getElementById("type_of_payment").value;
    	var untuk 				= document.getElementById("untuk_payroll").value;
    	var amount 				= document.getElementById("amount").value;
    	var note        		= document.getElementById("note").value;
		var data 		= "";

		untuk = untuk.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&number='+number;
		data += '&cluster='+cluster;
		data += '&type_of_payment='+type_of_payment;
		data += '&untuk='+untuk;
		data += '&amount='+amount;
		data += '&note='+note;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/cash-payment/view/"+data;

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
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/edit/"+data;

				}

			})

			return false;
		
		}

    })
}


function cancel(){

    Swal.fire({
    	icon: 'question',
		text: 'Apakah Anda Yakin???',
		showDenyButton: true,
		confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&proses=cancel';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view/"+data;

				}

			})

			return false;
		
		}

    })
}

function process_transaction(){

    Swal.fire({
    	icon: 'question',
		text: 'Apakah Anda Yakin???',
		showDenyButton: true,
		confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {
			var data 		= "";
				
			data += '&proses=process';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view/"+data;

				}

			})

			return false;
		
		}

    })
}

function diketahui_transaction(){

    Swal.fire({
    	icon: 'question',
    	text: 'Apakah Anda Yakin???',
      	showDenyButton: true,
      	confirmButtonText: 'Yes',
    }).then((result) => {

		if (result.isConfirmed) {

			var data 		= "";
				
			data += '&proses=diketahui';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view/"+data;

				}

			})

			return false;
		
		}

    })
}

function jenis_transaksi(){
	var x = document.getElementById("jenis_uang_keluar").value;
	if(x==1){
		document.location.href=localStorage.getItem('data_link')+"/cash-payment/new";
	}else if(x==2){
		document.location.href=localStorage.getItem('data_link')+"/cash-payment/get-purchasing";		
	}
}

function print_transaction(e){
	var link = localStorage.getItem('data_link')+"/print/cash-payment/"+e;		
	window.open(link,'_blank');
}
