function convertRupiah(angka, prefix) { 
    var number_string = angka.replace(/[^,\d]/g, "").toString(), 
        split = number_string.split(","), 
        sisa = split[0].length % 3, 
        rupiah = split[0].substr(0, sisa), 
        ribuan = split[0].substr(sisa).match(/\d{3}/gi); 

        if (ribuan) { 
            separator = sisa ? "." : ""; rupiah += separator + ribuan.join("."); 
        } 

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah; 
        return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : ""; 
} 

function isNumberKey(evt) { 
    key = evt.which || evt.keyCode; 
    if ( key != 188 && key != 8 && key != 9 && key != 13 && key != 17  && key != 86 & key != 67  && (key < 48 || key > 57)  && (key < 96 || key > 105)) { 
        evt.preventDefault(); 
        return; 
    } 
}

function logout(){

    Swal.fire({
      text: 'Do you want to go out???',
      showDenyButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {

        if (result.isConfirmed) {
            var data        = "";
                
            data += '&proses=logout';

            console.log(data);
            $.ajax({
                url:localStorage.getItem('data_link')+"/src/themes/proses/proses.php",
                method:"POST",
                data:data,
                type: 'json',
                cache:false,
                success: function(data) {

                    document.location.href=localStorage.getItem('data_link')+"/home";

                }

            })

            return false;
        
        }

    })
}

function change_password(){

    Swal.fire({
        icon: 'question',
        text: 'New Password',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Change',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {

            if(password==''){
                Swal.showValidationMessage(
                    "You haven't entered a new password yet!!!"
                )
            }else{

              Swal.fire({
                icon: 'question',
                text: 'Are you sure you want to change your password?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
              }).then((result) => {

                if (result.isConfirmed) {

                    var data        = $(this).serialize();

                    data += '&password='+password;
                    data += '&proses=change';

                        console.log(data);
                        $.ajax({
                            url:localStorage.getItem('data_link')+"/src/login/proses/proses.php",
                            method:"POST",
                            data:data,
                            type: 'json',
                            cache:false,
                            
                            success: function(data) {

                                Swal.fire("", "Password changed successfully", "success");

                            }

                        })

                    }

                })

            }

        },
    })
    
}