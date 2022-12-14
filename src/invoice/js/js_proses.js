$(document).ready(function () {
  var amount = document.getElementById("amount");

  amount.addEventListener("keyup", function (e) {
    amount.value = convertRupiah(this.value);
  });

  amount.addEventListener("keydown", function (event) {
    return isNumberKey(event);
  });

  $("#dues_type").select2({
    theme: "bootstrap-5",
  });

  $("#cluster").select2({
    theme: "bootstrap-5",
  });

  $("#rt").select2({
    theme: "bootstrap-5",
  });

  $("#warga").select2({
    theme: "bootstrap-5",
  });

  $("#till_date").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
  });

  $("#new").submit(function () {
    document.getElementById("btn").disabled = true;

    var dues_type = document.getElementById("dues_type").value;
    var warga = document.getElementById("warga").value;
    var till_date = document.getElementById("till_date").value;
    var amount = document.getElementById("amount").value;
    var note = document.getElementById("note").value;
    var data = "";

    note = note.replace("&", "and_symbol");

    data += "&dues_type=" + dues_type;
    data += "&warga=" + warga;
    data += "&till_date=" + till_date;
    data += "&amount=" + amount;
    data += "&note=" + note;
    data += "&proses=new";

    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
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
            localStorage.getItem("data_link") + "/invoice/view/" + data;
        }
      },
    });
    return false;
  });

  $("#new_all").submit(function () {
    document.getElementById("btn").disabled = true;

    var dues_type = document.getElementById("dues_type").value;
    var cluster = document.getElementById("cluster").value;
    var till_date = document.getElementById("till_date").value;
    var rt = document.getElementById("rt").value;
    var amount = document.getElementById("amount").value;
    var note = document.getElementById("note").value;
    var data = "";

    note = note.replace("&", "and_symbol");

    data += "&dues_type=" + dues_type;
    data += "&cluster=" + cluster;
    data += "&rt=" + rt;
    data += "&till_date=" + till_date;
    data += "&amount=" + amount;
    data += "&note=" + note;
    data += "&proses=new_all";

    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          Swal.fire({
            icon: "success",
            text: "Data has been successfully Simpand and sent to all",
            showDenyButton: false,
            confirmButtonText: "Yes",
            closeOnConfirm: false,
          }).then((result) => {
            var link =
              localStorage.getItem("data_link") +
              "/print/invoice-oper-link/" +
              data;
            window.open(link, "_blank");

            document.location.href =
              localStorage.getItem("data_link") + "/invoice";
          });
        }
      },
    });
    return false;
  });

  $("#new_dues").submit(function () {
    document.getElementById("btn").disabled = true;
    var dues_type = document.getElementById("dues_type").value;
    var cluster = document.getElementById("cluster").value;
    var till_date = document.getElementById("till_date").value;
    var rt = document.getElementById("rt").value;
    var note = document.getElementById("note").value;
    var data = "";
    note = note.replace("&", "and_symbol");
    data += "&dues_type=" + dues_type;
    data += "&cluster=" + cluster;
    data += "&till_date=" + till_date;
    data += "&rt=" + rt;
    data += "&note=" + note;
    data += "&proses=new_dues";
    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          Swal.fire({
            icon: "success",
            text: "Data has been successfully Simpand and sent to all",
            showDenyButton: false,
            confirmButtonText: "Yes",
            closeOnConfirm: false,
          }).then((result) => {
            var link =
              localStorage.getItem("data_link") +
              "/print/invoice-oper-link/" +
              data;
            window.open(link, "_blank");

            document.location.href =
              localStorage.getItem("data_link") + "/invoice";
          });
        }
      },
    });
    return false;
  });

  $("#edit").submit(function () {
    document.getElementById("btn").disabled = true;
    var number = document.getElementById("number").value;
    var dues_type = document.getElementById("dues_type").value;
    var till_date = document.getElementById("till_date").value;
    var warga = document.getElementById("warga").value;
    var amount = document.getElementById("amount").value;
    var note = document.getElementById("note").value;
    var data = "";
    note = note.replace("&", "and_symbol");
    data += "&number=" + number;
    data += "&dues_type=" + dues_type;
    data += "&till_date=" + till_date;
    data += "&warga=" + warga;
    data += "&amount=" + amount;
    data += "&note=" + note;
    data += "&proses=edit";
    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Maaf, Data tidak dapat di simpan!!!", "error");
        } else {
          document.location.href =
            localStorage.getItem("data_link") + "/invoice/view/" + data;
        }
      },
    });
    return false;
  });

  $("#cluster").on("change", function () {
    var cluster = this.value;
    var data = "";

    data += "&cluster=" + cluster;
    data += "&proses=rt";

    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        $("#rt").html(data);
      },
    });

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
          localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/invoice/view/" + data;
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
          localStorage.getItem("data_link") + "/src/invoice/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/invoice/view/" + data;
        },
      });

      return false;
    }
  });
}

function print_transaction(e) {
  var link = localStorage.getItem("data_link") + "/print/invoice/" + e;
  window.open(link, "_blank");
}
