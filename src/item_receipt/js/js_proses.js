$(document).ready(function () {
  $("#item").select2({
    theme: "bootstrap-5",
  });

  $("#type_of_receipt_wh").select2({
    theme: "bootstrap-5",
  });

  $("#from").select2({
    theme: "bootstrap-5",
  });
  $("#cluster").select2({
    theme: "bootstrap-5",
  });
  $("#divisi").select2({
    theme: "bootstrap-5",
  });

  $(window).load(function () {
    var bmb = document.getElementById("number").value;
    var data = "";
    data += "bmb=" + bmb;
    data += "&proses=cek_cancel";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/item_receipt/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          document.getElementById("cancel").style.display = "none";
        }
      },
    });
    return false;
  });

  $("#new").submit(function () {
    document.getElementById("btn").disabled = true;

    var x = document.getElementById("from").value;
    var note = document.getElementById("note").value;
    var data = $(this).serialize();
    var data;
    //alert(x);

    note = note.replace("&", "and_symbol");

    data += "&number_po=" + x;
    data += "&note=" + note;
    data += "&proses=new";
    // data += "&qtyInput=" +
    // alert(x);

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/item_receipt/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        //alert(data);
        if (data == 1) {
          document.getElementById("btn").disabled = false;
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/item-receipt/edit/" + data;
        }
      },
    });
    return false;
  });

  $("#edit").submit(function () {
    var number = document.getElementById("number").value;
    var note = document.getElementById("note").value;
    var data = $(this).serialize();

    note = note.replace("&", "and_symbol");

    data += "&number=" + number;
    data += "&note=" + note;
    data += "&proses=edit";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/item_receipt/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/item-receipt/edit/" + data;
        }
      },
    });
    return false;
  });
});

function hapus(e) {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin???",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = "";

      data += "&id=" + e;
      data += "&proses=hapus";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/item_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-receipt/edit/" + data;
        },
      });

      return false;
    }
  });
}

function cancel() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin???",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = "";

      data += "&proses=cancel";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/item_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-receipt/view/" + data;
        },
      });

      return false;
    }
  });
}

function process_transaction() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin???",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = "";

      data += "&proses=process";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/item_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-receipt/view/" + data;
        },
      });

      return false;
    }
  });
}

function from_po() {
  var x = document.getElementById("from").value;
  var data = "";

  data += "&po=" + x;
  data += "&proses=tarik_po";
  // alert(x);

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/item_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      $("#data_list").html(data);
    },
  });

  var data = "";

  data += "&id=" + x;
  data += "&proses=ambil_divisi";

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/item_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      $("#divisi").html(data);
    },
  });

  var data = "";

  data += "&id=" + x;
  data += "&proses=ambil_cluster";

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/item_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      $("#cluster").html(data);
    },
  });

  return false;
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

function hitung(x) {
  var data_isi = document.getElementById("qty" + x).value;
  var data = "";

  data += "&detail=" + x;
  data += "&qty=" + data_isi;
  data += "&proses=hitung";

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/item_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      if (data > 0) {
        $("#hasil" + x).html(data);
      } else {
        var text = data;
        var result = text.replace("-", "");

        $("#hasil" + x).html("+" + result);
      }
    },
  });

  return false;
}
