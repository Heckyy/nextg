$(document).ready(function() {

	$("#tanggal").datepicker({
		dateFormat: "dd-mm-yy",
        changeMonth: true
	 });

	$("#type_of_purchase").select2({
	    theme: "bootstrap-5",
	});
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
	$("#item").select2({
	    theme: "bootstrap-5",
	});


	var amount = document.getElementById("amount"); 

	amount.addEventListener("keyup", function(e) { 
	    amount.value = convertRupiah(this.value); 
	}); 

	amount.addEventListener('keydown', function(event) { 
	    return isNumberKey(event); 
	});

	var qty = document.getElementById("qty"); 

	qty.addEventListener("keyup", function(e) { 
	    qty.value = convertRupiah(this.value); 
	}); 

	qty.addEventListener('keydown', function(event) { 
	    return isNumberKey(event); 
	});

    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 

		var data 			 	= "";
    	var tanggal      		= document.getElementById("tanggal").value;
    	var supplier        	= document.getElementById("supplier").value;
     	var type_of_purchase    = document.getElementById("type_of_purchase").value;
     	var divisi        		= document.getElementById("divisi").value;
     	var cluster        		= document.getElementById("cluster").value;
     	var employee        	= document.getElementById("employee").value;
     	var note        		= document.getElementById("note").value;
     	var item        		= document.getElementById("item").value;
     	var qty        			= document.getElementById("qty").value;
     	var unit        		= document.getElementById("unit").value;
     	var amount        		= document.getElementById("amount").value;
   	
   		supplier = supplier.replace("&", "and_symbol");
		note = note.replace("&", "and_symbol");

		data += '&tanggal='+tanggal;
		data += '&supplier='+supplier;
		data += '&type_of_purchase='+type_of_purchase;
		data += '&divisi='+divisi;
		data += '&cluster='+cluster;
		data += '&employee='+employee;
		data += '&note='+note;
		data += '&item='+item;
		data += '&qty='+qty;
		data += '&unit='+unit;
		data += '&amount='+amount;
		data += '&proses=new';


			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){
						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/purchasing/edit-manual/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {
    	var number 				= document.getElementById("number").value;
     	var divisi        		= document.getElementById("divisi").value;
    	var cluster        		= document.getElementById("cluster").value;
     	var employee        	= document.getElementById("employee").value;
     	var note        		= document.getElementById("note").value;
     	var item        		= document.getElementById("item").value;
     	var qty        			= document.getElementById("qty").value;
     	var unit        		= document.getElementById("unit").value;
     	var amount        		= document.getElementById("amount").value;


		var data 			 	= "";

		note = note.replace("&", "and_symbol");

		data += '&number='+number;
		data += '&divisi='+divisi;
		data += '&cluster='+cluster;
		data += '&employee='+employee;
		data += '&note='+note;
		data += '&item='+item;
		data += '&qty='+qty;
		data += '&unit='+unit;
		data += '&amount='+amount;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {


					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/purchasing/edit-manual/"+data;

					}
				}

			})
 			return false;
	});


    $('#new_barang').submit(function() {
		document.getElementById("btn_item").disabled = true; 
		
    	var barang 		= document.getElementById("barang").value;
    	var type_of_item 		= document.getElementById("type_of_item").value;
		var data 		= "";

		barang = barang.replace("&", "and_symbol");

		barang = barang.replace("&", "and_symbol");
		
		data += '&barang='+barang;
		data += '&type_of_item='+type_of_item;
		data += '&proses=tambah_item';


			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/request/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.getElementById("btn_item").disabled = false; 
					Swal.fire("", "Barang Berhasil di Simpan", "success");
					item();

				}

			})
 			return false;
	});

    function item(){
		var type_of_purchase     = document.getElementById("type_of_purchase").value;
		var data 		= "";

		data += '&type_of_purchase='+type_of_purchase;
		data += '&proses=item';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					$("#item").html(data);

				}

			})
 			return false;
 	}

 	item();
});

	
function ubah_type_item(){
	var type_of_purchase     = document.getElementById("type_of_purchase").value;
	var data 		= "";
	data += '&type_of_purchase='+type_of_purchase;
	data += '&proses=item';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {

			$("#item").html(data);

		}

	})
	return false;
}

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
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/purchasing/edit-manual/"+data;

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
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/purchasing/view-manual/"+data;

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
				url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses_manual.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/purchasing/view/"+data;

				}

			})

			return false;
		
		}

    })
}
function tambah_item(){

    Swal.fire({
        icon: '',
        text: 'Tambah Barang',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        showLoaderOnConfirm: true,
        preConfirm: (barang) => {

            if(barang==''){
                Swal.showValidationMessage(
                    "Anda belum memasukan nama barang New!!!"
                )
            }else{

              Swal.fire({
                icon: 'question',
                text: 'Apakah Anda Yakin?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
              }).then((result) => {

                if (result.isConfirmed) {

                    var data        = $(this).serialize();

                    data += '&item='+barang;
                    data += '&proses=tambah_item';

                        console.log(data);
                        $.ajax({
                            url:localStorage.getItem('data_link')+"/src/request/proses/proses.php",
                            method:"POST",
                            data:data,
                            type: 'json',
                            cache:false,
                            
                            success: function(data) {

                                Swal.fire("", "Barang Berhasil di Simpan", "success");
                                item();

                            }

                        })

                    }

                })

            }

        },
    })
    
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
		url:localStorage.getItem('data_link')+"/src/purchasing/proses/proses.php",
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