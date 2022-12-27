 <?php
  session_start();
  if (!empty($_SESSION['id_employee']) && !empty($_GET['view'])) {
    include_once "../../core/file/function_proses.php";
    include_once "../../core/settings/terbilang.php";
    $params = "";
    $params = $_GET['view'];
    $db = new db();
    $explode_params = explode("/", $params);
    $tipe_bayar = $explode_params[0];
    $bulan = $explode_params[1];
    $tahun = $explode_params[2];
    $cari = $explode_params[3];
    $priod = $tahun . "-" . $bulan;
    $settings = $db->select('tb_settings', 'id_settings', 'id_settings', 'DESC');
    $s = mysqli_fetch_assoc($settings);
    $link_ubah = str_replace('https', 'http', $s['link']);
    $ubah = base64_decode($_GET['view']);
    $invoice = $db->select('tb_cash_receipt_payment', 'number="' . $ubah . '" && status="1" && type="o"', 'id_cash_receipt_payment', 'DESC');
    $i = mysqli_fetch_assoc($invoice);
    $u = mysqli_fetch_assoc($db->select('tb_employee', 'id_employee="' . $i['input_data'] . '"', 'id_employee', 'DESC'));
    $ap = mysqli_fetch_assoc($db->select('tb_employee', 'code_employee="' . $i['approved'] . '"', 'id_employee', 'DESC'));
    $ket = mysqli_fetch_assoc($db->select('tb_employee', 'code_employee="' . $i['diketahui'] . '"', 'id_employee', 'DESC'));
    $date = $bulan . "/" . $tahun;
    if ($cari == null) {
      if ($tipe_bayar == "all") {
        $query_get_data = "SELECT * from tb_invoice_fix where tanggal_tgh like'%" . $priod . "%'";
      } else {
        $query_get_data = "SELECT * from tb_invoice_fix where status='" . $tipe_bayar . "' && tanggal_tgh like'%" . $priod . "%'";
      }
    } else {
      if ($tipe_bayar == "all") {
        $query_get_data = "SELECT * from tb_invoice_fix where tanggal_tgh like'%" . $priod . "%' && pemilik like '%" . $cari . "%' || nomor_tgh like'%" . $cari . "%'";
      } else {
        $query_get_data = "SELECT * from tb_invoice_fix where status='" . $tipe_bayar . "' && tanggal_tgh like'%" . $priod . "%' && pemilik like'%" . $cari . "%' || nomor_tgh like'%" . $cari . "%'";
      }
    }
    // In This Below Is Query To Get Data From DataBase
    $result_get_data = $db->selectAll($query_get_data);
    $final_result_get_data = mysqli_fetch_assoc($result_get_data);
    $jum = mysqli_num_rows($result_get_data);
    $type = '';
    $no = 1;
    $tampung = "";
    foreach ($result_get_data as $data) {
      $bast = $data['nomor_bast'];
      // QUERY TO GET DATA ID CLUSTER
      $query_id_cluster = "SELECT * from tb_population where code_population='" . $bast . "'";
      $get_data_id_cluster = $db->selectAll($query_id_cluster);
      $result_get_data_id_cluster = mysqli_fetch_assoc($get_data_id_cluster);
      $id_cluster = $result_get_data_id_cluster['id_cluster'];
      // Query to get cluster
      $query_cluster_name = "SELECT * from tb_cluster where id_cluster='" . $id_cluster . "'";
      $get_cluster_name = $db->selectAll($query_cluster_name);
      $result_get_cluster_name = mysqli_fetch_assoc($get_cluster_name);
      $cluster_name = $result_get_cluster_name['cluster'];
      $nominal_bayar = intval($data['nominal_bayar']);
      $sisa = intval($data['sisa']);
      $tampung .= '<tr>';
      $tampung .= '<td align="center">' . $no . ' </td>';
      $tampung .= '<td align="center"> ' . $data['nomor_tgh'] . ' </td>';
      $tampung .= '<td align="center"> ' . $data['tanggal_tgh'] . ' </td>';
      $tampung .= '<td width="70"> ' . $data['pemilik'] . ' </td>';
      $tampung .= '<td align="center"> ' . "Rp. " . number_format($data['nominal_tagihan'], 0, ".", ",") . ' </td>';
      $tampung .= '<td align="center"> ' . "Rp. " . number_format($nominal_bayar, 0, ',', ',') . ' </td>';
      $tampung .= '<td align="center"> ' . "Rp. " . number_format($sisa, 0, ".", ",") . ' </td>';
      $tampung .= '<td align="center"> ' . $cluster_name . " / " .  $result_get_data_id_cluster['house_number'] . ' </td>';
      $tampung .= '<td align="center"> ' . strtoupper($data['status']) . ' </td>';
      $tampung .= '</tr>';
      $no++;
    };
    $html = ' <style>
                  @page {
                  margin: 20px 20px 20px 20px !important;
                  padding: 10px 10px 10px 10px !important;
        }
                  @font-face {
                      font-family: "time new roman";           
                      font-weight: normal;
                      font-style: normal;
                  }        
                  body{
                      font-family: "time new roman", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;   
                      font-size: 12px;     
                      margin:0px;
                  }
                  img{
                    margin-bottom:10px;
                  }
                  .table{
                    margin-top: 5px;
                    border-collapse: collapse;
                    border: thin solid #333333;
                    width: 100%;
                  }
                  .table{
                    border: thin solid #333333;
                    padding: 3px;
                  }
                   tr td{
                    border : thin solid #333333;
                   }
                  .table_no_border{
                    margin-top: 10px;
                    border: none;
                    width: 100%;
                  }
                  th{
                      border : thin solid #333333;
                  }
                  .bingkai{
                    width:100%;
                    float:left;
                  }
                  .font_size{
                    font-size = 24px;
                    font-weight = bold;
                  }
                </style>
                <html>
                  <body>
                  <div  align="center"><h1>Report Tagihan</h1></div>
                  <div>
                  <div style="margin-left:10px;"><b>Periode :' . $date . ' </b></div>
                  <div style="margin-left:10px;"><b>Status :' . strtoupper($tipe_bayar) . ' </b></div>
                  </div>
                  <table class = "table">
                  <tr>
                  <th>No</th>
                  <th>No. Tagihan</th>
                  <th>Tanggal</th>
                  <th>Pemilik</th>
                  <th>Tagihan</th>
                  <th>Bayar</th>
                  <th>Sisa</th>
                  <th>Alamat</th>
                  <th>Status</th>
                  </tr>

                  ';
    $html .= $tampung;
    $html .= '</body></html>';
  }
  require_once("../../assets/vendors/dompdf/autoload.inc.php");
  $filename = "Report-Tagihan";

  use Dompdf\Dompdf;

  $dompdf = new Dompdf();
  $dompdf->loadHtml($html);
  $customPaper = array(0, 0, 470.95, 595.28);
  $dompdf->set_paper("A4", 'landscape');
  $dompdf->render();
  $dompdf->stream($filename);
