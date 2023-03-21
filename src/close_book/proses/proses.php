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
	if ($proses == "close_book") {
		$periode = $_POST['periode'];
		$periode2 = new DateTime($periode);
		$periode3 = $periode2->format("Y-m");
		$next_date_periode = new DateTime($periode);
		$previous_date_periode = new DateTime($periode);
		$note = $_POST['note'];
		$bank = $_POST['bank'];
		$next_date_periode->modify("+1 month");
		$previous_date_periode->modify("-1 month");
		$next_period = $next_date_periode->format("Y-m");

		//echo $date_periode->format("Y-m");

		// Get Data Starting Balance
		// Response 1 For Succes ,  Response 2 For Error (Starting Balance Not Set )
		// $query_get_starting_balance = "SELECT * from tb_priod";
		// $get_data_starting_balance = $db->selectAll($query_get_starting_balance);
		// $result_get_data_starting_balance = mysqli_fetch_assoc($get_data_starting_balance);

		// ! Get Saldo awal!

		$query_get_saldo_awal = "SELECT * from tb_priod where priod='2023-01' and id_bank_cash = '" . $bank . "'";
		// $query_get_saldo_awal = "SELECT * from tb_priod where priod='" . $periode3 . "'";
		$result_get_saldo_awal = mysqli_fetch_assoc($db->selectAll($query_get_saldo_awal));
		$saldo_awal = $result_get_saldo_awal['saldo_awal'];
		$saldo_akhir = $saldo_awal;



		// ! Get seluruh tranksasi pada periode saat ini untuk di ambil total pengeluaran dan pemasukan!
		// $query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal_bank like '%" . $periode3 . "%'";
		$query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal like '%2023-01%' and id_bank='" . $bank . "'";
		$result_get_transaksi = $db->selectAll($query_get_data_transaksi);

		foreach ($result_get_transaksi as $data) {
			$tipe_dana = $data['type'];
			if ($tipe_dana == "i") {
				$saldo_akhir += intval($data['amount']);
			} else {
				$saldo_akhir -= intval($data['amount']);
			}
		}
		// INSERT FINAL BALANCE
		$query_update_saldo = "UPDATE tb_priod SET saldo_akhir='" . $saldo_akhir . "'where id_bank_cash='" . $bank . "'";
		$db->selectAll($query_update_saldo);
		// $db->update("tb_priod", "saldo_akhir='" . $saldo_akhir . "'", "priod='" . $periode3 . "'", "id_bank_cash='" . $bank . "'");
		// $db->insert("tb_priod", "id_bank_cash='" . $bank . "',saldo_awal='" . $saldo_akhir . "',priod='" . $next_period . "',note='" . $note . "'");
		$db->insert("tb_priod", "id_bank_cash='" . $bank . "',saldo_awal='" . $saldo_akhir . "',priod='2023-02',note='" . $note . "'");

		// if (mysqli_num_rows($get_data_starting_balance) > 0) {
		// GET DATA FROM CURRENT PERIOD
		// $final_balance = 0;

		// $query_get_data_current_period = "SELECT * from tb_cash_receipt_payment where tanggal like '%" . $periode3 . "%'";
		// $result_get_data_current_period = $db->selectAll($query_get_data_current_period);
		// $final_get_data_current_period = mysqli_fetch_assoc($result_get_data_current_period);
		// $tanggal_bank = $final_get_data_current_period['tanggal_bank'];
		// $jum = mysqli_num_rows($result_get_data_current_period);

		// Get Starting Balance
		// $query_get_starting_balance = "SELECT * from tb_priod where priod='" . $previous_period . "'";
		// $result_get_starting_balance = $db->selectAll($query_get_starting_balance);
		// $final_get_starting_balance = mysqli_fetch_assoc($result_get_starting_balance);
		// if (mysqli_num_rows($result_get_starting_balance) > 0) {
		// 	$saldo_akhir = $final_get_starting_balance['saldo_akhir'];

		// 	if ($saldo_akhir == null) {

		// 		$saldo_awal = intval($final_get_starting_balance['saldo_awal']);
		// 		$finance_balance_previous = $saldo_awal;
		// 		$finance_balance_previous = 1;
		// 	} else {
		// 		// $finance_balance_previous = intval($final_get_starting_balance['saldo_akhir']);
		// 		$finance_balance_previous = 2;
		// 	}
		// } else {
		// 	$saldo_akhir = $final_get_starting_balance['saldo_awal'];
		// }

		// foreach ($result_get_data_current_period as $data) {
		// 	$type_dana = $data['type'];
		// 	if ($type_dana == "i") {
		// 		$final_balance += $data['amount'];
		// 	} else {
		// 		$final_balance -= $data['amount'];
		// 	}
		// }

		// $final_balance += $finance_balance_previous;
		// echo var_dump();
		// die();

		// } else {
		// 	$response = 2;
		// }
	}
	// echo $periode3;
}
