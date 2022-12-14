$(document).ready(function () {
  $("#upload").submit(function () {
    document.getElementById("btn").disabled = true;
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
      formData.append("proses", proses);

      $.ajax({
        type: "POST",
        url:
          localStorage.getItem("data_link") +
          "/src/invoice/proses/proses_upload.php",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
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
