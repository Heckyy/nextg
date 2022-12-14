<?php
session_start();
if (!empty($_SESSION['id_employee'])) {
  include_once "../../core/file/function_proses.php";
  include_once "../../core/settings/terbilang.php";
  include_once "./../../core/file/library.php";
  $library_class = new library_class();
  $db = new db();

  $ubah = $_GET['view'];
  $ubah_explode = explode("/", $ubah);
  $item = $ubah_explode[0];
  $bulan = $ubah_explode[1];

  // Konversi Bulan Menjadi Format 2 Digit

  $settings = $db->select('tb_settings', 'id_settings', 'id_settings', 'DESC');
  $s = mysqli_fetch_assoc($settings);
  $link_ubah = str_replace('https', 'http', $s['link']);
  $e = mysqli_fetch_assoc($db->select('tb_settings', 'id_settings', 'id_settings', 'DESC'));
  $warehouse = $db->select('tb_warehouse', 'id_warehouse', 'warehouse', 'ASC');
  $w = mysqli_fetch_assoc($warehouse);
  $item = $db->select('tb_item', 'id_item = "' . $item . '"', 'item', 'ASC');
  // $item = $db->select('tb_item', 'id_item = "77"', 'item', 'ASC');
  $b = mysqli_fetch_assoc($item);
  if ($bulan < 10) {
    $bulan = "0" . $bulan;
  }
  if (!empty($_POST['cari'])) {
    $ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
  } else {
    $ubah_pencarian = "";
  }

  if (!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['item']) && !empty($_POST['warehouse'])) {
    $select_tahun = mysqli_real_escape_string($db->query, $_POST['tahun']);
    $select_bulan = mysqli_real_escape_string($db->query, $_POST['bulan']);
    $select_item = $$item;
    $select_warehouse = mysqli_real_escape_string($db->query, $_POST['warehouse']);



    $priod = $select_tahun . '-' . $select_bulan;
  } else {
    $select_tahun = $library_class->tahun();
    $select_bulan = $library_class->bulan();
    $priod = $select_tahun . '-' . $select_bulan;

    // if (!empty($_SESSION['item'])) {
    //   $select_item = $select_item;
    // } else {
    $select_item = $ubah;


    // 

    if (!empty($_SESSION['warehouse'])) {
      $select_warehouse = $_SESSION['warehouse'];
    } else {
      if (!empty($w['warehouse'])) {
        $select_warehouse = $w['warehouse'];
      } else {
        $select_warehouse = "";
      }
    }
  }


  $tambah_priod = $priod . '-01';

  $awal_priod = '2000-01-01';

  $priod_sebelumnya = date('Y-m-d', strtotime('-1 days', strtotime($tambah_priod)));

  $data = $db->select('tb_item_receipt_out INNER JOIN tb_item_receipt_out_detail ON tb_item_receipt_out.number_item_receipt_out=tb_item_receipt_out_detail.number_item_receipt_out', 'tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.number_item_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.type_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.from_for LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '"', 'tb_item_receipt_out.id_item_receipt_out', 'ASC');
  $result_item = mysqli_fetch_assoc($data);
  $nama_item = $result_item['item'];

  $tampung = '';
  $tampung_data = '';
  $tampung_jum_out = '';
  $simpan = '';




  $data_awal = $db->select('tb_item_receipt_out INNER JOIN tb_item_receipt_out_detail ON tb_item_receipt_out.number_item_receipt_out=tb_item_receipt_out_detail.number_item_receipt_out', 'tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.number_item_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.type_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.from_for LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '"', 'tb_item_receipt_out.id_item_receipt_out', 'ASC');

  // $tampung .= "test" . mysqli_num_rows($data_awal);






  $no = 1;
  $i = 1;


  if (mysqli_num_rows($data) > 0) {
    $total_balance = 0;
    $total = 0;
    $total_in_jum = 0;
    $total_out_jum = 0;

    $jum_data_awal = mysqli_num_rows($data_awal);
    $data_awal = mysqli_fetch_assoc($data_awal);


    if ($jum_data_awal > 0) {
      foreach ($data_awal as $key => $da) {

        if ($da['type_transaction'] == 'i') {
          $total_balance = $total_balance + $da['qty'];
        } else {
          $total_balance = $total_balance - $da['qty'];
        }
      }
    }
    $jum = mysqli_num_rows($data);

    $no = 1;

    foreach ($data as $key => $v) {

      $tampung .= '<tr>';



      $tampung .= '<td align="center">' . $no . '</td>';
      $tampung .= '<td align="center">' . $v['number_item_receipt_out'] . '</td>';
      $tampung .= '<td align = "center">' . $v['tanggal'] . '</td>';


      if ($v['type_transaction'] == 'i') {
        $total = $total + $v['qty'];
        $in = $v['qty'];
        $total_in_jum = $total_in_jum + $v['qty'];
        $out = '';
        $tampung .=  '<td align="center">' . $total . '</td>';
        $tampung .=  '<td align="center">' . $out . '</td>';
        $tampung .=  '<td align="center">' . $total . '</td>';
        $tampung_data = $total;
      } else {
        $total = $total - $v['qty'];
        $in = '';
        $total_out_jum = $total_out_jum + $v['qty'];
        $out = $v['qty'];
        $tampung .=  '<td align="center">' . $in . '</td>';
        $tampung .= '<td align ="center">' . $total . '</td>';
        $tampung .= '<td align = "center">' . $total . '</td>';
        $tampung_jum_out = $total;
      }

      if (!empty($v['number_purchasing'])) {
        $from_for = $v['from_for'] . ' - ( ' . $v['number_purchasing'] . ' )';
      } else {
        $from_for = $v['from_for'];
      }


      $no++;
      $tampung .= '</tr>';
    }
    $total_stock = $tampung_data - $tampung_jum_out;
  } else {
    $jum_data_awal = mysqli_num_rows($data_awal);

    //if ($jum_data_awal > 0) {

    $total_balance = 0;

    foreach ($data_awal as $key => $da) {
      if ($da['type_transaction'] == 'i') {
        $total_balance = $total_balance + $da['qty'];
      } else {
        $total_balance = $total_balance - $da['qty'];
      }
    }
    //}
  }
  // $tampung .= '<h1>' . $ubah . '</h1>';
  $html = ' <style>
                @page { margin: 10px 30px; }
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
                .table tr td{
                  border: thin solid #333333;
                  padding: 3px;
                }
                .table_no_border{
                  margin-top: 10px;
                  border: none;
                  width: 100%;
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
              <div  align="center"><h1>Laporan Stock (Stock Card)</h1></div>
                <h4>Item : ' .  $nama_item . ' </h4>
                <h4>Periode  : ' . $priod . ' </h4>
                <table class = "table">
                <tr>
                <th>No</th>
                <th>Number</th>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Stock</th>
                </tr>
                ';

  $html .= $tampung;






  $html .= '<tr>
              <td colspan ="3" align="right">Total : </td>
              <td align = "center">' . $tampung_data . '</td>
              <td align = "center">' . $tampung_jum_out . '</td>
              <td align = "center">' . $total_balance . '</td>
              </tr>';




  $html .= '</table>
                <br>
                <br>
                <table border = "0">
                <tr>
                <td width="150px" align="center">Dibuat</td>
                <td width="150px" align="center">Disetujui</td>
                <td width="150px" align="center">Diketahui</td>
                <td width="150px" align="center">Diterima</td>
                </tr>
                <br>
                <br>
                <br>
                <br>

                <tr>
                <td width="150px" align="center">(Admin)</td>
                <td width="150px" align="center">(Kepala Gudang / Manager)</td>
                <td width="150px" align="center">(Ketua)</td>
                <td width="150px" align="center">(.............................)</td>


                </tr>

                </table>


              </body>
              </html>';
}


require_once("../../assets/vendors/dompdf/autoload.inc.php");


$filename = "newpdffile";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$customPaper = array(0, 0, 470.95, 595.28);
$dompdf->set_paper($customPaper, 'landscape');


$dompdf->render();

$dompdf->stream($filename);
