$(document).ready(function() {

    
	$("#item").select2({
	    theme: "bootstrap-5",
	});

	$("#type_of_purchase").select2({
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


    $('#new').submit(function() {

		document.getElementById("btn").disabled = true; 

    	var cluster        		= document.getElementById("cluster").value;
    	var divisi        		= document.getElementById("divisi").value;
    	var employee        	= document.getElementById("employee").value;
    	var note        		= document.getElementById("note").value;
    	var item        		= document.getElementById("item").value;
    	var qty        			= document.getElementById("qty").value;
    	var keterangan        	= document.getElementById("keterangan").value;
		var data 		= "";

		note = note.replace("&", "and_symbol");
		keterangan = keterangan.replace("&", "and_symbol");

		data += '&cluster='+cluster;
		data += '&divisi='+divisi;
		data += '&employee='+employee;
		data += '&note='+note;
		data += '&keterangan='+keterangan;
		data += '&item='+item;
		data += '&qty='+qty;
		data += '&proses=new';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						document.getElementById("btn").disabled = false; 
						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/maintenance/edit/"+data;

					}
				}

			})
 			return false;
	});

    $('#edit').submit(function() {

    	var number        		= document.getElementById("number").value;
    	var cluster        		= document.getElementById("cluster").value;
    	var divisi        		= document.getElementById("divisi").value;
    	var employee        	= document.getElementById("employee").value;
    	var note        		= document.getElementById("note").value;
    	var item        		= document.getElementById("item").value;
    	var qty        			= document.getElementById("qty").value;
    	var keterangan        			= document.getElementById("keterangan").value;
		var data 		= "";

		note = note.replace("&", "and_symbol");
		keterangan = keterangan.replace("&", "and_symbol");

		data += '&number='+number;
		data += '&cluster='+cluster;
		data += '&divisi='+divisi;
		data += '&employee='+employee;
		data += '&note='+note;
		data += '&keterangan='+keterangan;
		data += '&item='+item;
		data += '&qty='+qty;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					if(data==1){

						Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

					}else{
					
						document.location.href=localStorage.getItem('data_link')+"/maintenance/edit/"+data;

					}
				}

			})
 			return false;
	});


    function item(){

		var data 		= "";

		data += '&proses=item';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
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
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
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

 	item();
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
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/maintenance/edit/"+data;

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
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/maintenance/view/"+data;

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
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/maintenance/view/"+data;

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
				url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					document.location.href=localStorage.getItem('data_link')+"/maintenance/view/"+data;

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
                            url:localStorage.getItem('data_link')+"/src/maintenance/proses/proses.php",
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