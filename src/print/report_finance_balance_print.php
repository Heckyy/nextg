<?php
session_start();
if (!empty($_SESSION['id_employee'])) {
  ob_start();
  include_once "../../core/file/function_proses.php";
  include_once "../../core/settings/terbilang.php";
  include_once "./../../core/file/library.php";
  $library_class = new library_class();
  $db = new db();
  // This Data From URL GET
  $data = $_GET['view'];
  $data = explode("/", $data);
  $from = $data[0];
  $from_date = date_create($from);
  $from = date_format($from_date, "Y/m/d");
  $to = $data[1];
  $to_date = date_create($to);
  $to = date_format($to_date, "Y/m/d");
  $to2 = date_format($to_date, "Y-m-d");
  $bank = $data[2];

  if (!empty($from) && !empty($to) && !empty($bank)) {
    $date_previous_month = date('Y-m', strtotime('-1 month', strtotime($to2)));
    // Get Ending Saldo From Previous Month For To Be Made Begining Saldo on This Month
    $query_get_data_previous_month = "SELECT * from tb_priod where id_bank_cash='" . $bank . "' AND priod = '" . $date_previous_month . "'";
    $data_previous_month = $db->selectAll($query_get_data_previous_month);

    $result_data_previous_month = mysqli_fetch_assoc($data_previous_month);
    $saldo_awal_bulan = $result_data_previous_month['nominal'];
    $query = 'SELECT * FROM `tb_cash_receipt_payment` WHERE id_bank = ' . $bank . ' AND tanggal_bank BETWEEN "' . $from . '" AND "' . $to . '" AND status = "1" order by tanggal_bank ASC';
    $data = $db->selectAll($query);
    $result_data  = mysqli_fetch_assoc($data);
    $bank_data = $db->select('tb_bank_cash', 'id_bank_cash="' . $bank . '"', 'bank_cash', 'ASC');
    $result_bank = mysqli_fetch_assoc($bank_data);
    $grand_total_awal = $result_bank['amount'];
    $no = 1;
    $total_awal = 0;
    $tampung = "<tr>";
    $tampung .= "<td>" . $no . "</td>";
    $tampung .= "<td> </td>";
    $tampung .= "<td></td>";
    $tampung .= "<td></td>";
    $tampung .= "<td></td>";
    $tampung .= "<td align ='center'><b>Balance</b></td>";
    $tampung .= "<td align ='center'> Rp." . number_format($total_awal, 2, ',', '.') . "</td>";
    $tampung .= "<td align ='center'> Rp." . number_format($total_awal, 2, ',', '.') . "</td>";
    $tampung .= "<td align ='center'> Rp." . number_format($saldo_awal_bulan, 2, ',', '.') . "</td>";
    $tampung .= "</tr>";
    $no++;
    foreach ($data as $key => $v) {
      $tampung .= '<tr>';

      $b = mysqli_fetch_assoc($db->select('tb_bank_cash', 'id_bank_cash="' . $v['id_bank'] . '"', 'bank_cash', 'ASC'));
      $tampung .= '<td align="center">' . $no . '</td>';
      $tampung .= '<td align="center">' . $v['number'] . '</td>';
      $tampung .= '<td align="center">' . $v['tanggal_bank'] . '</td>';

      if ($no == 2) {
        if ($v['type'] == 'i') {
          $receipt = $v['amount'];
          $payment = 0;
          $dari = $v["dari"];
          $type_transaction = $v["type_of_receipt"];
          //$total = $total + $v['amount'];
          $total = $saldo_awal_bulan + $receipt;
        } else {
          $dari = $v["untuk"];
          $receipt = 0;
          $payment = $v['amount'];
          $type_transaction = $v["type_of_payment"];
          $total = $saldo_awal_bulan  - $payment;
          //$total = $total - $payment;
        }
      } else {
        if ($v['type'] == 'i') {
          $receipt = $v['amount'];
          $payment = 0;
          $dari = $v["dari"];
          $type_transaction = $v["type_of_receipt"];
          $total = $total + $v['amount'];
          //$total = $b['amount'] + $dari;
        } else {
          $dari = $v["untuk"];
          $receipt = 0;
          $payment = $v['amount'];
          $type_transaction = $v["type_of_payment"];
          //$total = $b['amount'] - $payment;
          $total = $total - $payment;
        }
      }

      $tampung .= '<td align="center"> ' . $type_transaction . ' </td>';
      $tampung .= '<td align="center"> ' . $dari . ' </td>';
      $tampung .= '<td align="center"> ' . $b['bank_cash'] . ' </td>';
      $tampung .= '<td align="center"> Rp ' . number_format($receipt, 2, ',', '.') . ' </td>';
      $tampung .= '<td align="center"> Rp ' . number_format($payment, 2, ',', '.') . ' </td>';
      $tampung .= '<td align="center"> Rp ' . number_format($total, 2, ',', '.') . ' </td>';


      $no++;
    }

    // foreach ($data as $dt) {
    //   $html .= "Number : " . $dt['number'] . " ";
    //   $html .= "Bank Date : " . $dt['tanggal_bank'] . " ";
    //   $html .= "Type Of Receipt : " . $dt['type_of_receipt'] . " ";
    //   $html .= "Bank : " . $dt['id_bank'] . " ";
    // }

    $html = ' <style>
                  @page {
                  margin: 0px 0px 0px 0px !important;
                  padding: 0px 0px 0px 0px !important;
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
                  <div  align="center"><h1>Report Finance Balance</h1></div>
                  <div>
                  <h5>From : ' . $from . ' Until  : ' . $to . '</h5>
                  <h5>Bank / Cash : ' . $b['bank_cash'] . '</h5>
                  </div>

                  <table class = "table">
                  <tr>
                  <th>No</th>
                  <th>Number</th>
                  <th>Bank Date</th>
                  <th>Type Of Transaction</th>
                  <th>From / For</th>
                  <th>Bank / Cash</th>
                  <th>Receipt</th>
                  <th>Payment</th>
                  <th>Total</th>
                  </tr>
                  ';


    $html .= $tampung;

    $html .= '</table>
              </body>
              </html>';
  } else {
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
                    border: none;
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
                  th{
                      border-top:thin solid #333333;
                      border-bottom:thin solid #333333;
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
                  <div  align="center"><h1>Report Finance Balance</h1></div>
                  <div>
                  <h5>From : - Until  : - </h5>
                  <h5>Bank / Cash : - </h5>
                  </div>

                  <table class = "table">
                  <tr>
                  <th>No</th>
                  <th>Number</th>
                  <th>Bank Date</th>
                  <th>Type Of Transaction</th>
                  <th>From / For</th>
                  <th>Bank / Cash</th>
                  <th>Receipt</th>
                  <th>Payment</th>
                  <th>Total</th>
                  </tr>
                  ';


    $html .= '</table>
              </body>
              </html>';
  }
}



require_once("../../assets/vendors/dompdf/autoload.inc.php");


$filename = "ReportFinance";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->getOptions()->setChroot('report_finance_balance_print');

$dompdf->loadHtml($html);

$customPaper = array(0, 0, 470.95, 595.28);
$dompdf->set_paper('A4', 'potrait');

$dompdf->render();
$dompdf->stream($filename);
