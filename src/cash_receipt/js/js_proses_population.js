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

  $("#type_of_receipt").select2({
    theme: "bootstrap-5",
  });

  $("#tanggal_bank").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
  });

  $("#new").submit(function () {
    Swal.fire({
      icon: "question",
      text: "Apakah Anda Yakin???",
      showDenyButton: true,
      confirmButtonText: "Yes",
    }).then((result) => {
      document.getElementById("btn").disabled = true;

      var invoice = document.getElementById("invoice").value;
      var type_of_receipt = document.getElementById("type_of_receipt").value;
      var tanggal_bank = document.getElementById("tanggal_bank").value;
      var account_name = document.getElementById("account_name").value;
      var account_number = document.getElementById("account_number").value;
      var amount = document.getElementById("amount").value;
      var note = document.getElementById("note").value;
      alert(tanggal_bank);
      var data = "";

      account_name = account_name.replace("&", "and_symbol");
      account_number = account_number.replace("&", "and_symbol");
      note = note.replace("&", "and_symbol");

      data += "&invoice=" + invoice;
      data += "&type_of_receipt=" + type_of_receipt;
      data += "&tanggal_bank=" + tanggal_bank;
      data += "&account_name=" + account_name;
      data += "&account_number=" + account_number;
      data += "&amount=" + amount;
      data += "&note=" + note;
      data += "&proses=new";

      console.log(data);
      $.ajax({
        url:
          localStorage.getItem("data_link") +
          "/src/cash_receipt/proses/proses_warga.php",
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
              localStorage.getItem("data_link") +
              "/cash-receipt/view-invoice/" +
              data;
          }
        },
      });
    });

    return false;
  });
});

function cancel() {
  Swal.fire({
    icon: "question",
    text: "Apakah Anda Yakin?",
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
            localStorage.getItem("data_link") + "/cash-receipt/bank/MQ";
        },
      });

      return false;
    }
  });
}

function priode_bayar(e) {
  var val = document.getElementById("priode_bayar_" + e).value;
  var data = "";

  data += "&proses=priode_bayar";
  data += "&val=" + val;
  data += "&id=" + e;

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/cash_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {},
  });

  return false;
}

function discount(e) {
  var val = document.getElementById("discount_" + e).value;
  var data = "";

  data += "&proses=discount";
  data += "&val=" + val;
  data += "&id=" + e;

  console.log(data);
  $.ajax({
    url:
      localStorage.getItem("data_link") + "/src/cash_receipt/proses/proses.php",
    method: "POST",
    data: data,
    type: "json",
    cache: false,
    success: function (data) {},
  });

  return false;
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
            localStorage.getItem("data_link") +
            "/cash-receipt/view-ipl/" +
            data;
        },
      });

      return false;
    }
  });
}

function print_transaction(e) {
  var link =
    localStorage.getItem("data_link") + "/print/cash-receipt-warga/" + e;
  window.open(link, "_blank");
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
          "/src/cash_receipt/proses/proses.php",
        method: "POST",
        data: data,
        type: "json",
        cache: false,
        success: function (data) {
          document.location.href =
            localStorage.getItem("data_link") + "/cash-receipt/bank/MQ";
        },
      });

      return false;
    }
  });
}
