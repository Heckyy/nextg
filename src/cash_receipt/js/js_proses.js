$(document).ready(function () {
  $("#new").submit(function () {
    document.getElementById("btn").disabled = true;

    var type_of_receipt = document.getElementById("type_of_receipt").value;
    var tanggal = document.getElementById("tanggal").value;
    var tanggal_bank = document.getElementById("tanggal_bank").value;
    var dari = document.getElementById("dari").value;
    var account_name = document.getElementById("account_name").value;
    var account_number = document.getElementById("account_number").value;
    var amount = document.getElementById("amount").value;
    var note = document.getElementById("note").value;
    var data = "";

    dari = dari.replace("&", "and_symbol");
    account_name = account_name.replace("&", "and_symbol");
    account_number = account_number.replace("&", "and_symbol");
    note = note.replace("&", "and_symbol");

    data += "&tanggal=" + tanggal;
    data += "&type_of_receipt=" + type_of_receipt;
    data += "&tanggal_bank=" + tanggal_bank;
    data += "&dari=" + dari;
    data += "&account_name=" + account_name;
    data += "&account_number=" + account_number;
    data += "&amount=" + amount;
    data += "&note=" + note;
    data += "&proses=new";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/cash_receipt/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          document.getElementById("btn").disabled = false;
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/view/" + data;
        }
      },
    });
    return false;
  });

  $("#edit").submit(function () {
    document.getElementById("btn").disabled = true;

    var number = document.getElementById("number").value;
    var type_of_receipt = document.getElementById("type_of_receipt").value;
    var tanggal_bank = document.getElementById("tanggal_bank").value;
    var dari = document.getElementById("dari").value;
    var account_name = document.getElementById("account_name").value;
    var account_number = document.getElementById("account_number").value;
    var amount = document.getElementById("amount").value;
    var note = document.getElementById("note").value;
    var data = "";

    dari = dari.replace("&", "and_symbol");
    account_name = account_name.replace("&", "and_symbol");
    account_number = account_number.replace("&", "and_symbol");
    note = note.replace("&", "and_symbol");

    data += "&number=" + number;
    data += "&type_of_receipt=" + type_of_receipt;
    data += "&tanggal_bank=" + tanggal_bank;
    data += "&dari=" + dari;
    data += "&account_name=" + account_name;
    data += "&account_number=" + account_number;
    data += "&amount=" + amount;
    data += "&note=" + note;
    data += "&proses=edit";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/cash_receipt/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          document.getElementById("btn").disabled = false;
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/view/" + data;
        }
      },
    });
    return false;
  });

  $("#upload").submit(function () {
    document.getElementById("btn").disabled = true;
    var tanggal_bank = document.getElementById("tanggal_bank").value;
    var tanggal = document.getElementById("tanggal").value;

    $("#data_view").html(
      '<div style="width:100%; float:left;" align="center"><img src="' +
        localStorage.getItem("data_link") +
        '/assets/images/loading.gif" width="30%"></div>'
    );

    const file_excel = $("#file_excel").prop("files")[0];
    var proses = "upload";

    if (proses != "" && file_excel != "") {
      let formData = new FormData();
      formData.append("file_excel", file_excel);
      formData.append("tanggal_bank", tanggal_bank);
      formData.append("tanggal", tanggal);
      formData.append("proses", proses);

      $.ajax({
        type: "POST",
        url:
          localStorage.getItem("data_link") +
          "/src/cash_receipt/proses/proses.php",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
          // alert(data);
          document.getElementById("btn").disabled = false;
          $("#data_view").html(data);
        },
        error: function () {
          document.getElementById("btn").disabled = false;
          Swal.fire("", "File Gagal di Proses", "error");
          batal_upload();
        },
      });
    }
    return false;
  });
});

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
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/view/" + data;
        },
      });

      return false;
    }
  });
}

function process_transaction() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin????",
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
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/view/" + data;
        },
      });

      return false;
    }
  });
}

function diketahui_transaction() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin???",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = "";

      data += "&proses=diketahui";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/view/" + data;
        },
      });

      return false;
    }
  });
}

function print_transaction(e) {
  var link = localStorage.getItem("data_link") + "/print/cash-receipt/" + e;
  window.open(link, "_blank");
}

function cancel_upload() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin???",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = "";

      data += "&proses=cancel_upload";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/upload";
        },
      });

      return false;
    }
  });
}

function process_upload() {
  document.getElementById("process_upload").disabled = true;
  document.getElementById("cancel_upload").disabled = true;

  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin????",
    showDenyButton: true,
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("", "Data sedang dimasukan!!!", "warning");
      var data = "";
      var tanggal_bank = document.getElementById("tanggal_bank").value;
      var tanggal = document.getElementById("tanggal").value;
      data += "&proses=process_upload";
      data += "&tanggal_bank=" + tanggal_bank;
      data += "&tanggal=" + tanggal;
      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          //alert(data);
          document.getElementById("process_upload").disabled = false;
          Swal.fire("", "Data Berhasil di Masukan", "success");
          hapus_upload(data);
          console.log(data);
          document.location.href =
            localStorage.getItem("data_link") +
            "/cash-receipt/view-ipl/" +
            data;
        },
      });

      return false;
    } else {
      document.getElementById("process_upload").disabled = false;
    }
  });
}

function hapus_upload(number) {
  var data = "";

  data += "&proses=hapus_upload";
  data += "&number=" + number;

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/cash_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      document.location.href =
        localStorage.getItem("data_link") + "/cash-receipt/edit-ipl/" + data;
    },
  });

  return false;
}

function batal_upload() {
  var data = "";

  data += "&proses=cancel_upload";

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/cash_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {
      $("#data_view").html("");
    },
  });

  return false;
}
