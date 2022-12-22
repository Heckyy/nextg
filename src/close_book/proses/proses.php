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
		$previous_period = $previous_date_periode->format("Y-m");
		//echo $date_periode->format("Y-m");

		// Get Data Starting Balance
		// Response 1 For Succes ,  Response 2 For Error (Starting Balance Not Set )
		$query_get_starting_balance = "SELECT * from tb_priod";
		$get_data_starting_balance = $db->selectAll($query_get_starting_balance);
		$result_get_data_starting_balance = mysqli_fetch_assoc($get_data_starting_balance);
		if (mysqli_num_rows($get_data_starting_balance) > 0) {
			// GET DATA FROM CURRENT PERIOD
			$final_balance = 0;
			$query_get_data_current_period = "SELECT * from tb_cash_receipt_payment where tanggal like '%" . $periode3 . "%'";
			$result_get_data_current_period = $db->selectAll($query_get_data_current_period);
			$final_get_data_current_period = mysqli_fetch_assoc($result_get_data_current_period);
			$tanggal_bank = $final_get_data_current_period['tanggal_bank'];
			$jum = mysqli_num_rows($result_get_data_current_period);

			// Get Starting Balance
			$query_get_starting_balance = "SELECT * from tb_priod where priod='" . $previous_period . "'";
			$result_get_starting_balance = $db->selectAll($query_get_data_current_period);
			$final_get_starting_balance = mysqli_fetch_assoc($result_get_starting_balance);
			$saldo_awal = "";
			$saldo_akhir = "";
			if (mysqli_num_rows($result_get_starting_balance) > 0) {
				$saldo_akhir = $final_get_starting_balance['saldo_akhir'];

				if ($saldo_akhir == null) {

					$saldo_awal = $final_get_starting_balance['saldo_awal'];
					$finance_balance_previous = $saldo_awal;
				} else {
					$finance_balance_previous = $final_get_starting_balance['saldo_akhir'];
				}
			}

			foreach ($result_get_data_current_period as $data) {
				$type_dana = $data['type'];
				if ($type_dana == "i") {
					$final_balance += $data['amount'];
				} else {
					$final_balance -= $data['amount'];
				}
			}
			$final_balance += $finance_balance_previous;
			// insert data for next periode


		} else {
			$response = 2;
		}
	}
	echo $final_balance;
}
