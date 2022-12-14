function access(e){

	var data="";
	var val = e;
	var access_akun = $("#"+e+":checked").val();

	if (access_akun==undefined) {
	 	access_akun="0";
	}else{
	 	access_akun="1";
	}

	var gabung = val+'="'+access_akun+'"';

	var ubah =btoa(gabung);
	var data_encrips=ubah.replace("==", "");

	data += '&access_akun='+data_encrips;
	data += '&proses=access';

	console.log(data);
	$.ajax({
		url:localStorage.getItem('data_link')+"/src/employee/proses/proses.php",
		method:"POST",
		data:data,
		type: 'json',
		cache:false,
		success: function(data) {
			
		}

	})

	return false;
}