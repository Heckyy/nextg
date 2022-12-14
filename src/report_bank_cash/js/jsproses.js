$(document).ready(function() {

	$("#bulan").select2({
	    theme: "bootstrap-5",
	});
	$("#tahun").select2({
	    theme: "bootstrap-5",
	});
	$("#bank").select2({
	    theme: "bootstrap-5",
	});

	function view_data(){

			var html	= "";
			var data 	= "";
			var cari	= document.getElementById("cari").value;
				cari 	= cari.replace("&", "and_symbol");

			var bulan	= document.getElementById("bulan").value;
			var tahun	= document.getElementById("tahun").value;
			var bank	= document.getElementById("bank").value;

				data +='&cari='+cari;
				data +='&bulan='+bulan;
				data +='&tahun='+tahun;
				data +='&bank='+bank;
				data +='&proses=tarik_data';

			console.log(data);
            $.ajax({
				url:localStorage.getItem('data_link')+"/src/report_bank_cash/proses/get_data_proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success:function(data){	

					var total_receipt=0;
					var total_payment=0;
					var total=0;

					response = JSON.parse(data);

			        if(response.length) {

			          	$.each(response, function(key,trk) {

			          		total_receipt=trk.receipt_asli;
			          		total_payment=trk.payment_asli;
			          		total=trk.total;

				            html += '<tr>';
				            html += '<td align="center">'+trk.no+'.</td>'
				            html += '<td>'+trk.number+'</td>';
				            html += '<td>'+trk.type_of_transaction+'</td>';
				            html += '<td>'+trk.dari_untuk+'</td>';
				            html += '<td>'+trk.bank_cash+'</td>';
				            html += '<td>'+trk.receipt+'</td>';
				            html += '<td>'+trk.payment+'</td>';
				            html += '<td>'+trk.total+'</td>';
					        html += '</tr>';

						});

						html +='<tr>';
						html +='<td colspan="4" align="right"><b>Total</b></td>';
						html +='<td><b>'+total_receipt+'</b></td>';
						html +='<td><b>'+total_payment+'</b></td>';
						html +='<td><b>'+total+'</b></td>';
						html +='</tr>';

					}else{

						html = '<tr><td colspan="7">Data not found!</td></tr>';

					}

					$("#data_view").html(html);

				}

			});


}


	$('#search').submit(function() {
		view_data();
		return false;
		
	});


	view_data();

});
