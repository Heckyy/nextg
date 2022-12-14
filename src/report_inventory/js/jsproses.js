$(document).ready(function () {
  $("#bulan").select2({
    theme: "bootstrap-5",
  });
  $("#tahun").select2({
    theme: "bootstrap-5",
  });
  $("#item").select2({
    theme: "bootstrap-5",
  });
  $("#warehouse").select2({
    theme: "bootstrap-5",
  });

  function view_data() {
    var html = "";
    var data = "";
    var cari = document.getElementById("cari").value;
    cari = cari.replace("&", "and_symbol");

    var bulan = document.getElementById("bulan").value;
    var tahun = document.getElementById("tahun").value;
    var item = document.getElementById("item").value;
    var warehouse = document.getElementById("warehouse").value;

    data += "&cari=" + cari;
    data += "&bulan=" + bulan;
    data += "&tahun=" + tahun;
    data += "&item=" + item;
    data += "&warehouse=" + warehouse;
    data += "&proses=tarik_data";

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/report_inventory/proses/get_data_proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,
      success: function (data) {
        var total_in = 0;
        var total_out = 0;
        var total = 0;
        var number;
        //alert(data);
        response = JSON.parse(data);
        //alert(response);

        if (response.length) {
          $.each(response, function (key, trk) {
            total_in = trk.total_in_jum;
            total_out = trk.total_out_jum;
            total = trk.total;
            number = trk.number;

            html += "<tr>";
            html += '<td align="center">' + trk.no + ".</td>";
            html += "<td>" + trk.number + "</td>";
            html += "<td>" + trk.type_receipt_out + "</td>";
            html += "<td></td>";
            html += "<td>" + trk.in + "</td>";
            html += "<td>" + trk.out + "</td>";
            html += "<td>" + trk.total + "</td>";
            html += "</tr>";
          });

          html += "<tr>";
          html += '<td colspan="4" align="right"><b>Total</b></td>';
          html += "<td><b>" + total_in + "</b></td>";
          html += "<td><b>" + total_out + "</b></td>";
          html += "<td><b>" + total + "</b></td>";
          html += "</tr>";

          $("#data_view").html(html);
        } else {
          $("#data_view").html('<tr><td colspan="7">Data not found!</td></tr>');
        }
      },
    });
  }

  $("#search").submit(function () {
    view_data();
    return false;
  });

  view_data();

  $("#cetak").click(function () {
    var view = document.getElementById("data_view").innerHTML;
    var item = document.getElementById("item").value;
    var warehouse = document.getElementById("warehouse").value;
    var bulan = document.getElementById("bulan").value;
    var tahun = document.getElementById("tahun").value;
    var data = {
      item: item,
      warehouse: warehouse,
      bulan: bulan,
      tahun: tahun,
    };

    // alert(data.bulan);
    // alert(data.item);
    // alert(data.tahun);
    // alert(data.warehouse);

    console.log(data);
    $.ajax({
      url:
        localStorage.getItem("data_link") +
        "/src/print/report_inventory_print.php",
      method: "POST",
      data: data,
      type: JSON,
      cache: false,
      success: function (data) {
        //alert(data);
        var link =
          localStorage.getItem("data_link") +
          "/print/report_inventory_print/" +
          item +
          "/" +
          bulan;
        window.open(link);
      },
    });
  });
});

// function print_transaction() {
//   var test = document.getElementById("data_view").innerHTML;
//   alert(test);
// }
