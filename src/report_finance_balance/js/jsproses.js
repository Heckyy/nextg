$(document).ready(function () {
  $("#from").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
  });

  $("#to").datepicker({
    dateFormat: "dd-mm-yy",
    changeMonth: true,
  });

  $("#bank").select2({
    theme: "bootstrap-5",
  });

  function view_data() {
    var totalPage = parseInt($("#totalPages").val());
    var pag = $("#pagination").simplePaginator({
      totalPages: totalPage,
      maxButtonsVisible: 5,
      currentPage: 1,
      nextLabel: "Next",
      prevLabel: "Prev",
      firstLabel: "First",
      lastLabel: "Last",
      clickCurrentPage: true,
      pageChange: function (page) {
        var html = "";
        var data = "";

        var from = document.getElementById("from").value;
        var to = document.getElementById("to").value;
        var bank = document.getElementById("bank").value;

        data += "&from=" + from;
        data += "&to=" + to;
        data += "&bank=" + bank;
        data += "&page=" + page;
        data += "&proses=tarik_data";

        console.log(data);
        $.ajax({
          url:
            localStorage.getItem("data_link") +
            "/src/report_finance_balance/proses/get_data_proses.php",
          method: "POST",
          data: data,
          type: "json",
          cache: false,
          success: function (data) {
            //alert(data);
            response = JSON.parse(data);
            var total = 0;
            if (response.length) {
              $.each(response, function (key, trk) {
                html += "<tr>";
                html += '<td align="center">' + trk.no + ".</td>";
                html += "<td>" + trk.number + "</td>";
                html += "<td>" + trk.bank_date + "</td>";
                html += "<td>" + trk.type_of_receipt + "</td>";
                html += "<td>" + trk.dari + "</td>";
                html += "<td>" + trk.bank + "</td>";
                html += "<td>" + trk.receipt + "</td>";
                html += "<td>" + trk.payment + "</td>";
                html += "<td>" + trk.total + "</td>";
                html += "</tr>";
                total = trk.total;
              });
              html += "<tr>";
              html += "<td></td>";
              html += '<td colspan="7" align="right">Total </td>';
              html += "<td><b>" + total + "</b></td>";
              html += "</tr>";
            } else {
              html = '<tr><td colspan="4">Data not found!</td></tr>';
            }
            $("#data_view").html(html);
          },
        });
      },
    });
    $("#cetak").click(function () {
      var from = document.getElementById("from").value;
      var to = document.getElementById("to").value;
      var bank = document.getElementById("bank").value;
      var data = {
        from: from,
        to: to,
        bank: bank,
      };
      var link =
        localStorage.getItem("data_link") +
        "/print/report_finance_balance_print/" +
        from +
        "/" +
        to +
        "/" +
        bank;
      window.open(link, "_blank");
    });
  }
  $("#search").submit(function () {
    view_data();
    return false;
  });

  view_data();
});
