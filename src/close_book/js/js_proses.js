$(document).ready(function () {
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

  $("#nominal").keyup(rupiah);
  button();
  $("#btn").click(function () {
    document.getElementById("btn").disabled = true;
    var periode = document.getElementById("periode").value;
    var nominal = document.getElementById("nominal").value;
    var bank = document.getElementById("divisi").value;
    var note = document.getElementById("note").value;
    //alert(periode);
    // alert(nominal);
    // alert(bank);
    Swal.fire({
      title: "Loading",
      text: "Mohon Menunggu..",
      imageUrl:
        localStorage.getItem("data_link") + "/assets/images/loading.gif",
      imageWidth: 200,
      imageHeight: 200,
      showCancelButton: false,
      showConfirmButton: false,
    });
    var data = {
      periode: periode,
      nominal: nominal,
      bank: bank,
      note: note,
      proses: "close_book",
    };
    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") + "/src/close_book/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (response) {
        //(response);
        if (response == 2) {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Mohon Periksa Kembali Data Yang Dimasukan!",
          });
          document.getElementById("btn").disabled = false;
        } else {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Tutup Periode Berhasil",
            showConfirmButton: false,
            timer: 2000,
          });
          document.getElementById("btn").disabled = false;
          //     // document.location.href =
          //     // localStorage.getItem("data_link") + "/close_book";
        }
      },
    });
    return false;
  });
});

function convertRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
}

function rupiah() {
  var nominal = document.getElementById("nominal").value;
  nominal = convertRupiah(this.value);
  $("#nominal").val(nominal);
}

function button() {
  var nominal = document.getElementById("nominal").value;
  var bank = document.getElementById("divisi").value;
  if (bank == "null") {
    document.getElementById("btn").disabled = true;
  } else {
    document.getElementById("btn").disabled = false;
  }
}

function change() {
  var bank = document.getElementById("divisi").value;
  if (bank == "null") {
    document.getElementById("btn").disabled = true;
  } else {
    document.getElementById("btn").disabled = false;
  }
}
