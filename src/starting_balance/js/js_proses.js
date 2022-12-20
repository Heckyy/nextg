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

  $("#new").submit(function () {
    document.getElementById("btn-save").disabled = true;
    var bmb = document.getElementById("delivery_order").value;
    var tanggal = document.getElementById("tanggal").value;
    var supplier = document.getElementById("supplier").value;
    var number = document.getElementById("number").value;
    var delivery_order = document.getElementById("delivery_order").value;
    var invoice = document.getElementById("invoice").value;
    var note = document.getElementById("note").value;
    var data = {
      bmb: bmb,
      tanggal: tanggal,
      number_inv_purchasing: number,
      supplier: supplier,
      delivery_order: delivery_order,
      invoice: invoice,
      note: note,
      proses: "new",
    };
    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/inv_purchasing/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          document.getElementById("btn").disabled = false;
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          //alert(data);
          Swal.fire({
            title: "Data Berhasil Di Simpan",

            confirmButtonText: "Oke",
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              document.location.href =
                localStorage.getItem("data_link") + "/inv_purchasing/";
            }
          });

          // alert(data);
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
