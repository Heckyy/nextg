$(document).ready(function () {
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

        var dues_type = document.getElementById("dues_type").value;

        cari = cari.replace("&", "and_symbol");

        data += "&cari=" + cari;
        data += "&dues_type=" + dues_type;
        data += "&page=" + page;
        data += "&proses=tarik_data";

        console.log(data);
        $.ajax({
          url:
            localStorage.getItem("data_link") +
            "/src/cash_receipt/proses/get_data_proses_warga.php",
          method: "POST",
          data: data,
          type: "json",
          cache: false,
          success: function (data) {
            response = JSON.parse(data);

            if (response.length) {
              $.each(response, function (key, trk) {
                var bg = "";
                if (trk.status == "1") {
                  var status = '<i class="bi bi-check2-square"></i>';
                } else if (trk.status == "2") {
                  var status = '<i class="bi bi-x-square"></i>';
                  bg = ' class="bg-light text-dark"';
                } else {
                  var status =
                    '<div class="spinner-border spinner-border-sm" role="status"></div>';
                }

                html += "<tr" + bg + ">";
                html += '<td align="center">' + trk.no + ".</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '">' +
                  trk.number +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '">' +
                  trk.tanggal +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '">' +
                  trk.name +
                  " " +
                  trk.cluster +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '">' +
                  trk.dues_type +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '">' +
                  trk.amount +
                  "</td>";
                html += "</tr>";
              });
            } else {
              html = '<tr><td colspan="7">Data not found!</td></tr>';
            }

            $("#data_view").html(html);
          },
        });
      },
    });
  }

  $("#search").submit(function () {
    view_data();
    return false;
  });

  view_data();
});

function link_view(e) {
  var id = e.getAttribute("data-id");
  document.location.href =
    localStorage.getItem("data_link") + "/cash-receipt/invoice/" + id;
}
