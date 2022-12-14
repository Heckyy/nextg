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

	var totalPage = parseInt($('#totalPages').val());	
	var pag = $('#pagination').simplePaginator({
		totalPages: totalPage,
		maxButtonsVisible: 5,
		currentPage: 1,
		nextLabel: 'Next',
		prevLabel: 'Prev',
		firstLabel: 'First',
		lastLabel: 'Last',
		clickCurrentPage: true,
		pageChange: function(page) {

			var html	= "";
			var data 	= "";

			var cari	= document.getElementById("cari").value;
				cari 	= cari.replace("&", "and_symbol");
					
			var bulan	= document.getElementById("bulan").value;
			var tahun	= document.getElementById("tahun").value;

				data +='&cari='+cari;
				data +='&bulan='+bulan;
				data +='&tahun='+tahun;
				data +='&page='+page;
				data +='&proses=tarik_data';

			console.log(data);
            $.ajax({
				url:localStorage.getItem('data_link')+"/src/report_cash_receipt/proses/get_data_proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success:function(data){	

					response = JSON.parse(data);

			        if(response.length) {

			          	$.each(response, function(key,trk) {

				            html += '<tr>';
				            html += '<td align="center">'+trk.no+'.</td>'
				            html += '<td>'+trk.number+'</td>';
				            html += '<td>'+trk.type_of_receipt+'</td>';
				            html += '<td>'+trk.untuk+'</td>';
				            html += '<td>'+trk.amount+'</td>';
					        html += '</tr>';

						});
					}else{

						html = '<tr><td colspan="4">Data not found!</td></tr>';

					}

					$("#data_view").html(html);

				}

			});

		}

	});
}




	$('#search').submit(function() {
		view_data();
		return false;
		
	});


	view_data();

});
