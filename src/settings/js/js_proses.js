tinyMCE.init({

        selector: 'textarea#payment_method',
        mode : "textareas",
        plugins : "autolink,lists,pagebreak,style,layer,table,Simpan,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autoSimpan,visualblocks",

        theme_advanced_buttons1 : "Simpan,cancel,|,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,cleanup,help,code,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,advhr",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });


$(document).ready(function() {
    $('#edit').submit(function() {
    	var title_print 	= document.getElementById("title_print").value;
    	var title_print2 		= document.getElementById("title_print2").value;
    	var address        = document.getElementById("address").value;
    	var payment_method        = tinyMCE.get('payment_method');
		var data 		= "";

		title_print = title_print.replace("&", "and_symbol");
		title_print2 = title_print2.replace("&", "and_symbol");
		address = address.replace("&", "and_symbol");
		payment_method=payment_method.getContent();
		
		data += '&title_print='+title_print;
		data += '&title_print2='+title_print2;
		data += '&address='+address;
		data += '&payment_method='+payment_method;
		data += '&proses=edit';

			console.log(data);
			$.ajax({
				url:localStorage.getItem('data_link')+"/src/settings/proses/proses.php",
				method:"POST",
				data:data,
				type: 'json',
				cache:false,
				success: function(data) {

					Swal.fire("", "Data Simpand successfully", "success");

				}

			})
 			return false;
	});
});
