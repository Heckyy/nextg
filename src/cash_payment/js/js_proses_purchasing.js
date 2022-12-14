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

	$("#jenis_pembayaran").select2({
	    theme: "bootstrap-5",
	});

	$("#cluster").select2({
	    theme: "bootstrap-5",
	});

	$("#divisi").select2({
	    theme: "bootstrap-5",
	});
	
	$("#tanggal_bank").datepicker({
		dateFormat: "dd-mm-yy",
        changeMonth: true
	});

	$("#tanggal").datepicker({
		dateFormat: "dd-mm-yy",
        changeMonth: true
	 });

    $('#new').submit(function() {

	    Swal.fire({
	    	icon: 'question',
			text: 'Apakah Anda Yakin???',
			showDenyButton: true,
			confirmButtonText: 'Yes',
	    }).then((result) => {
			document.getElementById("btn").disabled = true; 

    		var tanggal 			= document.getElementById("tanggal").value;
    		var cluster 			= document.getElementById("cluster").value;
    		var divisi 			= document.getElementById("divisi").value;
	    	var purchasing 			= document.getElementById("purchasing").value;
	    	var type_of_payment 	= document.getElementById("type_of_payment").value;
	    	var jenis_pembayaran 	= document.getElementById("jenis_pembayaran").value;
	    	var bank_tf 			= document.getElementById("bank_tf").value;
	    	var nomor_rek 			= document.getElementById("nomor_rek").value;
	    	var nama_akun 			= document.getElementById("nama_akun").value;
	    	var tanggal_bank 		= document.getElementById("tanggal_bank").value;
	    	var untuk 				= document.getElementById("untuk").value;
	    	var amount 				= document.getElementById("amount").value;
	    	var note        		= document.getElementById("note").value;
			var data 		= "";

			untuk = untuk.replace("&", "and_symbol");
			note = note.replace("&", "and_symbol");

			data += '&tanggal='+tanggal;
			data += '&cluster='+cluster;
			data += '&divisi='+divisi;
			data += '&purchasing='+purchasing;
			data += '&type_of_payment='+type_of_payment;
			data += '&jenis_pembayaran='+jenis_pembayaran;
			data += '&bank_tf='+bank_tf;
			data += '&nomor_rek='+nomor_rek;
			data += '&nama_akun='+nama_akun;
			data += '&tanggal_bank='+tanggal_bank;
			data += '&untuk='+untuk;
			data += '&amount='+amount;
			data += '&note='+note;
			data += '&proses=new';

				console.log(data);
				$.ajax({
					url:localStorage.getItem('data_link')+"/src/cash_payment/proses/proses_purchasing.php",
					method:"POST",
					data:data,
					type: 'json',
					cache:false,
					success: function(data) {
						
						if(data==1){

							Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

						}else{
						
							document.location.href=localStorage.getItem('data_link')+"/cash-payment/view-purchasing/"+data;

						}
					}

				})
		});
	 			return false;
	 });
});

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

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view-purchasing/"+data;

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

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view-purchasing/"+data;

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

					document.location.href=localStorage.getItem('data_link')+"/cash-payment/view-purchasing/"+data;

				}

			})

			return false;
		
		}

    })
}

function print_transaction(e){
	var link = localStorage.getItem('data_link')+"/print/cash-payment-purchasing/"+e;		
	window.open(link,'_blank');
}