$(document).ready(function () {
  $("#login").submit(function () {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var data = "";

    data += "&username=" + username;
    data += "&password=" + password;
    data += "&proses=login";

    console.log(data);
    $.ajax({
      url: localStorage.getItem("data_link") + "/src/login/proses/proses.php",
      method: "POST",
      data: data,
      type: "json",
      cache: false,

      success: function (data) {
        if (data == 1) {
          Swal.fire("", "Username Atau Password Anda Salah", "error");
        } else {
          document.location.href = localStorage.getItem("data_link") + "/home";
        }
      },
    });
    return false;
  });
});
