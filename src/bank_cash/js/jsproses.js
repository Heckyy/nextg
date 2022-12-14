$(document).ready(function() {

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


			data +='&cari='+cari;
			data +='&page='+page;
			data +='&proses=tarik_data';

			console.log(data);
            $.ajax({
				url:localStorage.getItem('data_link')+"/src/bank_cash/proses/get_data_proses.php",
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
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.code_bank_cash+'</td>';
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.bank_cash+'</td>';
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.account_number+'</td>';
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.note+'</td>';
					        html += '</tr>';

						});
					}else{

						html = '<tr><td colspan="5">Data not found!</td></tr>';

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





function link_view(e){
	var id = e.getAttribute('data-id');
	document.location.href=localStorage.getItem('data_link')+"/bank-cash/view/"+id;
}
