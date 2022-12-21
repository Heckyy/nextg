<?php
session_start();
if (!empty($_POST['proses']) && !empty($_SESSION['id_employee'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";

	$db = new db();
	$library_class = new library_class();

	$tanggal 	= $library_class->tanggal();
	$bulan 		= $library_class->bulan();
	$tahun 		= $library_class->tahun();
	$date		= $tahun . '-' . $bulan;
	$proses = $_POST['proses'];
	if ($proses == "starting_balance") {
		$periode = $_POST['periode'];
		$explode_periode = explode("-", $periode);
		$bulan = $explode_periode[1];
		$tahun = $explode_periode[0];
		$periode_fix = $tahun . "-" . $bulan;
		$bank = $_POST['bank'];
		$nominal = $_POST['nominal'];
		$note = $_POST['note'];
		// echo $nominal;

		if ($nominal != null && $bank != null) {
			$db->insert("tb_priod", "id_bank_cash='" . $bank . "',saldo_awal='" . $nominal . "',priod='" . $periode_fix . "',note='" . $note . "'");
		} else {
			$error = 1;
			echo $error;
		}
	}
}
