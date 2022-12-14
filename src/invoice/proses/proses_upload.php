<?php
session_start();
include_once "./../../../core/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include_once "../../../core/file/function_proses.php";
$db = new db();

$proses = $_POST['proses'];
if ($proses == 'upload' && $_SESSION['cash_receipt_new'] == 1) {
    $arr_file = explode('.', $_FILES['file_excel']['name']);
    $extension = end($arr_file);

    if ('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $no = 1;
    $html = '<div class="col-lg-12" id="process" align="right"> </div><div class="scroll"><table class="table"><tr class="sticky-top"><td width="50px" align="center">No</td><td width="300px">Number Bast</td><td width="300px">Property,ID</td><td width="300px">Period Month</td><td width="300px">Year Period</td><td width="300px">Floor ID</td><td width="300px">Cluster</td><td width="300px">Store ID</td><td width="300px">Customer</td><td width="300px">Total</td><td>IPL Price</td><td width="300px">Total Unit</td><td width="300px">LT</td><td width="300px">Tarif IPL Makro</td><td width="300px">Total IPL Makro</td><td width="300px">IPL Pengelola</td></tr>';
    $total_semua = 0;

    // Get Data From Row Excel
    for ($i = 1; $i < count($sheetData); $i++) {
        $number_bast         = $sheetData[$i]['0'];
        $property            = $sheetData[$i]['1'];
        $priod_mont            = $sheetData[$i]['2'];
        $year_priod            = $sheetData[$i]['3'];
        $floor_id            = $sheetData[$i]['4'];
        $cluster            = $sheetData[$i]['5'];
        $store_id            = $sheetData[$i]['6'];
        $invoice_no            = $sheetData[$i]['7'];
        $customer_name        = $sheetData[$i]['8'];
        $total                = str_replace(",", "", $sheetData[$i]['9']);
        $status                = $sheetData[$i]['10'];
        $paid_date_asli        = str_replace("/", "-", $sheetData[$i]['11']);
        $no_paymnet            = $sheetData[$i]['12'];
        $total_unit            = $sheetData[$i]['13'];
        $luas_tanah            = str_replace(",", "", $sheetData[$i]['14']);
        $tarif_ipl_makro    = str_replace(",", "", $sheetData[$i]['15']);
        $total_ipl_makro    = str_replace(",", "", $sheetData[$i]['16']);
        $ipl_pengelolah        = str_replace(",", "", $sheetData[$i]['17']);
        $ubah_tarif_ipl_makro    = $sheetData[$i]['15'];
        $ubah_total_ipl_makro    = $sheetData[$i]['16'];
        $ubah_ipl_pengelolah    = str_replace(",", "", $sheetData[$i]['17']);



        // Query To Get Grand IPL Price
        $query_get_ipl = "SELECT * from tb_invoice_fix ";
        $get_ipl_data = $db->select('tb_invoice_fix', 'nomor_bast="' . $number_bast . '"', "nomor_tgh", "ASC");
        $result_get_ipl_data = mysqli_fetch_assoc($get_ipl_data);
        if (isset($result_get_ipl_data)) {
            //$grand_total_ipl =  number_format($result_get_ipl_data['nominal_tagihan'], 0, ',', ',');
            $grand_total_ipl =  $result_get_ipl_data['nominal_tagihan'];
        }
        $grand_total_int = intval($grand_total_ipl);
        if ($ipl_pengelolah == $grand_total_int) {
            $html = $html . '<tr><td align="center">' . $no . '.</td><td>' . $number_bast . '</td><td>' . $property . '</td><td>' . $priod_mont . '</td><td>' . $year_priod . '</td><td>' . $floor_id . '</td><td>' . $cluster . '</td><td>' . $store_id . '</td><td>' . $customer_name . '</td><td>' . $total . '</td><td>' . $grand_total_ipl . '</td><td>' . $total_unit . '</td><td>' . $luas_tanah . '</td><td>' . $ubah_tarif_ipl_makro . '</td><td>' . $ubah_total_ipl_makro . '</td><td>' . $ubah_ipl_pengelolah . '</td></tr>';
        } else {
            $html = $html . '<tr class="bg-danger"><td align="center" >' . $no . '.</td><td>' . $number_bast . '</td><td>' . $property . '</td><td>' . $priod_mont . '</td><td>' . $year_priod . '</td><td>' . $floor_id . '</td><td>' . $cluster . '</td><td>' . $store_id . '</td><td>' . $customer_name . '</td><td>' . $total . '</td><td>' . $grand_total_ipl . '</td><td>' . $total_unit . '</td><td>' . $luas_tanah . '</td><td>' . $ubah_tarif_ipl_makro . '</td><td>' . $ubah_total_ipl_makro . '</td><td>' . $ubah_ipl_pengelolah . '</td></tr>';
        }
        $no++;
    }

    echo $html;
}
