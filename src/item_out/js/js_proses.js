$(document).ready(function () {
  $("#item").select2({
    theme: "bootstrap-5",
  });

  $("#type_of_out_wh").select2({
    theme: "bootstrap-5",
  });
  $("#cluster").select2({
    theme: "bootstrap-5",
  });

  $("#new").submit(function () {
    //document.getElementById("btn").disabled = true;
    var type_of_out_wh = document.getElementById("type_of_out_wh").value;
    var tanggal = document.getElementById("tanggal").value;
    var untuk = document.getElementById("untuk").value;
    var note = document.getElementById("note").value;
    var item = document.getElementById("item").value;
    var qty = document.getElementById("qty").value;
    var data = "";
    note = note.replace("&", "and_symbol");
    data += "&type_of_out_wh=" + type_of_out_wh;
    data += "&tanggal= " + tanggal;
    data += "&untuk=" + untuk;
    data += "&note=" + note;
    data += "&item=" + item;
    data += "&qty=" + qty;
    data += "&proses=new";
    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") + "/src/item_out/proses/proses.php",
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
            localStorage.getItem("data_link") + "/item-out/edit/" + data;
        }
      },
    });
    return false;
  });

  $("#edit").submit(function () {
    var number = document.getElementById("number").value;
    var untuk = document.getElementById("untuk").value;
    var note = document.getElementById("note").value;
    var item = document.getElementById("item").value;
    var qty = document.getElementById("qty").value;
    var data = "";

    note = note.replace("&", "and_symbol");

    data += "&number=" + number;
    data += "&untuk=" + untuk;
    data += "&note=" + note;
    data += "&item=" + item;
    data += "&qty=" + qty;
    data += "&proses=edit";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") + "/src/item_out/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/item-out/edit/" + data;
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
          localStorage.getItem("data_link") + "/src/item_out/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-out/edit/" + data;
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
          localStorage.getItem("data_link") + "/src/item_out/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-out/view/" + data;
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
          localStorage.getItem("data_link") + "/src/item_out/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/item-out/view/" + data;
        },
      });

      return false;
    }
  });
}
