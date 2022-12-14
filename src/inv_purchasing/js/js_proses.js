$(document).ready(function() {

    $("#type_of_request").select2({
	    theme: "bootstrap-5",
	});
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




	$('#new').submit(function(){
		document.getElementById("btn-save").disabled=true;
		var bmb = document.getElementById("delivery_order").value;
		var tanggal	= document.getElementById("tanggal").value;
		var supplier	= document.getElementById("supplier").value;
		var number = document.getElementById("number").value;
		var delivery_order	= document.getElementById("delivery_order").value;
		var invoice	= document.getElementById("invoice").value;
		var note	= document.getElementById("note").value;
		var data= {
			bmb:bmb,
			tanggal:tanggal,
			number_inv_purchasing:number,
			supplier:supplier,
			delivery_order:delivery_order,
			invoice:invoice,
			note:note,
			proses:"new"
	
		};
	
		console.log(data);
		$.ajax({
			url:localStorage.getItem('data_link')+"/src/inv_purchasing/proses/proses.php",
			method : "POST",
			data :data,
			type :"json",
			cache:false,
			success:function(data){
				if(data==1){

					document.getElementById("btn").disabled = false; 
					Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");

				}else{
					//alert(data);
					Swal.fire({
						title: 'Data Berhasil Di Simpan',
						
						confirmButtonText: 'Oke',
						
					  }).then((result) => {
						/* Read more about isConfirmed, isDenied below */
						if (result.isConfirmed) {
							document.location.href=localStorage.getItem('data_link')+"/inv_purchasing/"
						} 
					  })
					
					
					// alert(data);

				}
				
				
			}
		});
		return false;
		

	});

	
 
});













function from_po(){
	var data = "";
	var sp = document.getElementById("supplier").value;
	var data= {
		supplier:sp,
		proses:"tarik_po"

	};
	//alert("OK");
	
	
	 
	 $.ajax({
				url:localStorage.getItem('data_link')+"/src/inv_purchasing/proses/proses.php",
				method : "POST",
				data :data,
				type :"json",
				cache:false,
				success:function(data){
					var do1 = document.getElementById("delivery_order").innerHTML =data;
					//  alert(data);
				}
			});
	
	var data = "";
	var bmb = document.getElementById("delivery_order").value;
	var data= {
		bmb:bmb,
		proses:"tarik_do"

	};
	
	
	 
	 $.ajax({
				url:localStorage.getItem('data_link')+"/src/inv_purchasing/proses/proses.php",
				method : "POST",
				data :data,
				type :"json",
				cache:false,
				success:function(data){
					// $("#delivery_order").addClass(bg-warning);
					var do1 = document.getElementById("datalist").innerHTML =data;
					
				}
			});

}
function from_do(){
	var data = "";
	var bmb = document.getElementById("delivery_order").value;
	var data= {
		bmb:bmb,
		proses:"tarik_do"

	};
	
	
	 
	 $.ajax({
				url:localStorage.getItem('data_link')+"/src/inv_purchasing/proses/proses.php",
				method : "POST",
				data :data,
				type :"json",
				cache:false,
				success:function(data){
					// $("#delivery_order").addClass(bg-warning);
					var do1 = document.getElementById("datalist").innerHTML =data;
					
				}
			});

}

if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); }

function pilihTanggal(){
	var data = "";
	var tanggal = document.getElementById("tanggal").value;
	var data= {
		tanggal:tanggal,
		proses:"pilih_tanggal"

	};
	
	
	 
	 $.ajax({
				url:localStorage.getItem('data_link')+"/src/inv_purchasing/proses/proses.php",
				method : "POST",
				data :data,
				type :"json",
				cache:false,
				success:function(data){
					// $("#delivery_order").addClass(bg-warning);
				 	document.getElementById("number").value =data;
				//  	alert (data);
				
					
				}
			});

}


	



