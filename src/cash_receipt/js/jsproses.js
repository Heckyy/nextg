$(document).ready(function () {
  $("#bulan").select2({
    theme: "bootstrap-5",
  });
  $("#tahun").select2({
    theme: "bootstrap-5",
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
        var cari = document.getElementById("cari").value;
        cari = cari.replace("&", "and_symbol");
        var bulan = document.getElementById("bulan").value;
        var tahun = document.getElementById("tahun").value;
        cari = cari.replace("&", "and_symbol");
        data += "&cari=" + cari;
        data += "&bulan=" + bulan;
        data += "&tahun=" + tahun;
        data += "&page=" + page;
        data += "&proses=tarik_data";

        console.log(data);
        $.ajax({
          url:
            localStorage.getItem("data_link") +
            "/src/cash_receipt/proses/get_data_proses.php",
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
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.number +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.Date +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.dari +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.note +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.account_name +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '">' +
                  trk.amount +
                  "</td>";
                html +=
                  '<td onclick="link_view(this);" data-id="' +
                  trk.target +
                  '" data-folder="' +
                  trk.target_folder +
                  '" align="center">' +
                  status +
                  "</td>";
                html += "</tr>";
              });
            } else {
              html = '<tr><td colspan="10">Data not found!</td></tr>';
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
  var folder = e.getAttribute("data-folder");
  document.location.href =
    localStorage.getItem("data_link") + "/cash-receipt/" + folder + "/" + id;
}
