$(document).ready(function () {
  $("#bulan").select2({
    theme: "bootstrap-5",
  });
  $("#tahun").select2({
    theme: "bootstrap-5",
  });
  $("#dues_type").select2({
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
        var cari = document.getElementById("cari").value;
        cari = cari.replace("&", "and_symbol");
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var dues_type = document.querySelector("#dues_type").value;
        data += "&cari=" + cari;
        data += "&bulan=" + bulan;
        data += "&tahun=" + tahun;
        data += "&dues_type=" + dues_type;
        data += "&page=" + page;
        data += "&proses=tarik_data";
        console.log(data);
        $.ajax({
          url:
            localStorage.getItem("data_link") +
            "/src/invoice/proses/get_data_proses.php",
          method: "POST",
          data: data,
          type: "json",
          cache: false,
          success: function (data) {
            response = JSON.parse(data);
            // Untuk mengecek apakah data yang di cari ada atau tidak, jika tidak ada makan pagination tidak di tampilkan
            if (response == 1) {
              var pagination = document.getElementById("pagination");
              pagination.classList.add("d-none");
              html = '<tr><td colspan="12">Data not found!</td></tr>';
            } else {
              total_bayar = 0;
              total_tagihan_bayar = response[0].total_tagihan;
              html +=
                "<tr><td colspan = '12' align='right'><b>Grand Total : " +
                total_tagihan_bayar +
                "</b></td></tr>";
              if (response.length) {
                $.each(response, function (key, trk) {
                  nomor_tagihan = trk.nomor;
                  html += "<tr>";
                  html += "<td align='center'>" + trk.no + "</td>";
                  html +=
                    "<td id='no_tagihan' data-id='TGH20221100001'>" +
                    trk.nomor +
                    "</td>";
                  html += "<td>" + trk.tanggal + "</td>";
                  html += "<td>" + trk.pemilik + "</td>";
                  html +=
                    "<td style='color:blue;'><button style='background-color:transparent;border:none;' type='button' data-bs-toggle='modal' data-bs-target='#myModal'>" +
                    trk.tagihan +
                    "</button ></td>";
                  html += "<td>" + trk.bayar + "</td>";
                  html += "<td>" + trk.sisa + "</td>";
                  html += "<td>" + trk.catatan + "</td>";
                  html += "<td align='center'>" + trk.status + "</td>";
                  html += "</tr>";
                  total_tagihan_bayar = Number(trk.total_bayar);
                  total_tagihan_bayar2 = total_tagihan_bayar.simpleMoneyFormat;
                });
              }
            }
            $("#nomor_tagihan").html(nomor_tagihan);
            $("#data_view").html(html);
          },
        });
      },
    });
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  }
  $("#tagihanBtn").click(function () {
    alert("test");
  });
  $("#search").submit(function () {
    view_data();
    return false;
  });
  $("#cetak").click(function () {
    var bulan = document.getElementById("bulan").value;
    var tahun = document.getElementById("tahun").value;
    var tipe_bayar = document.getElementById("dues_type").value;
    var cari = document.getElementById("cari").value;
    alert(cari);
    var data;
    data += "&bulan=" + bulan;
    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/print/tagihan_print.php",
      method: "POST",
      data: data,
      type: JSON,
      cache: false,
      success: function (data) {
        var link =
          localStorage.getItem("data_link") +
          "/print/tagihan_print/" +
          tipe_bayar +
          "/" +
          bulan +
          "/" +
          tahun +
          "/" +
          cari;
        window.open(link);
      },
    });
  });

  view_data();
});

// function link_view(e) {
//   var id = e.getAttribute("data-id");
//   document.location.href =
//     localStorage.getItem("data_link") + "/invoice/view/" + id;
// }

function currencyIdr(angka, prefix) {
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
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}
