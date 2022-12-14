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
				url:localStorage.getItem('data_link')+"/src/position/proses/get_data_proses.php",
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
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.code_position+'</td>';
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.position+'</td>';
				            html += '<td onclick="link_view(this);" data-id="'+trk.target+'">'+trk.note+'</td>';
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





function link_view(e){
	var id = e.getAttribute('data-id');
	document.location.href=localStorage.getItem('data_link')+"/position/view/"+id;
}
