<?php
error_reporting(0);
session_start();
if (!empty($_SESSION['id_employee']) && !empty($_POST['proses'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";
	$db = new db();
	$library_class = new library_class();
	if ($_POST['proses'] == 'tarik_data') {
		$perPage = 10;
		if (isset($_POST["page"])) {
			$page  = $_POST["page"];
		} else {
			$page = 1;
		};
		$startFrom = ($page - 1) * $perPage;
		$e = mysqli_fetch_assoc($db->select('tb_settings', 'id_settings', 'id_settings', 'DESC'));
		$bank = $db->select('tb_bank_cash', 'id_bank_cash', 'bank_cash', 'ASC');
		$b = mysqli_fetch_assoc($bank);
		if (!empty($_POST['from']) && !empty($_POST['to']) && !empty($_POST['bank'])) {
			$select_from = mysqli_real_escape_string($db->query, $_POST['from']);
			$select_to = mysqli_real_escape_string($db->query, $_POST['to']);
			$select_bank_pilih = mysqli_real_escape_string($db->query, $_POST['bank']);
			$tanggal_from = substr($select_from, 0, 2);
			$bulan_from = substr($select_from, 3, 2);
			$tahun_from = substr($select_from, 6, 4);
			$tanggal_awal = $tahun_from . '-' . $bulan_from . '-' . $tanggal_from;
			$tanggal_to = substr($select_to, 0, 2);
			$bulan_to = substr($select_to, 3, 2);
			$tahun_to = substr($select_to, 6, 4);
			$tanggal_akhir = $tahun_to . '-' . $bulan_to . '-' . $tanggal_to;
			$current_period = new DateTime($select_from);
			$period_fix = $current_period->format("Y-m");
			$date_previous_month = new DateTime();
			$select_to2 = explode('-', $select_to);
			$previous_month = $select_to2[1] - 1;
			$previous_priod = $select_to2[2] . "-" . $previous_month;
			if ($select_bank_pilih == 'all') {
				$select_bank = '';
			} else {
				$select_bank = 'id_bank="' . $select_bank_pilih . '" && ';
			}
		} else {
			$tanggal_awal = $tanggal_awal = date("Y-m-01", time());
			$tanggal_akhir = date("Y-m-t", time());

			$bank = $db->select('tb_bank_cash', 'id_bank_cash', 'bank_cash', 'ASC');
			$b = mysqli_fetch_assoc($bank);
			$select_bank_pilih = $b['id_bank_cash'];
			$select_bank = 'id_bank="' . $b['id_bank_cash'] . '" && ';
		}
		$_SESSION['bank'] = $select_bank_pilih;
		$data = $db->selectpage('tb_cash_receipt_payment', $select_bank . 'tanggal_bank BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '" && status="1"', 'tanggal_bank', 'ASC', $startFrom, $perPage);
		$no = $startFrom + 1;
		if (mysqli_num_rows($data) > 0) {
			$jum = mysqli_num_rows($data);
			$i = 1;
			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $select_bank_pilih . '"', 'bank_cash', 'ASC');
			$result_bank = mysqli_fetch_assoc($bank);
			$date_previous_month2 = date('Y-m', strtotime('-1 month', strtotime($select_to)));
			// $date_previous_month = $date_previous_month - 1;
			// Get Ending Saldo From Previous Month For To Be Made Begining Saldo on Current Month
			$query_get_data_previous_month = "SELECT * from tb_priod where id_bank_cash='" . $select_bank_pilih . "' AND priod = '" . $period_fix . "'";
			$data_previous_month = $db->selectAll($query_get_data_previous_month);


			$result_data_previous_month = mysqli_fetch_assoc($data_previous_month);
			$saldo_awal_bulan = $result_data_previous_month['saldo_awal'];
			// echo $result_data_previous_month['nominal'];
			if ($page == 1) {
				$_SESSION['total' . $page] = 0;
				$total = 0;
			} else {
				$ambil = $page - 1;
				$awal = $_SESSION['total' . $ambil];
				$total = $awal;
			}
			$rows = '[';
			$rows .= '{"no":"' . $no . '",';
			$rows .= '"number":"",';
			$rows .= '"bank_date":" ",';
			$rows .= '"type_of_receipt":"",';
			$rows .= '"dari":"",';
			$rows .= '"bank":"Balance",';
			$rows .= '"receipt":"Rp.' . number_format($total, 2, ',', '.') . '",';
			$rows .= '"payment":"",';
			$rows .= '"total":"Rp.' . number_format($saldo_awal_bulan, 2, ',', '.')  . '"},';
			// $rows .= '"total":"' . $previous_priod . '"},';
			$no++;
			foreach ($data as $key => $v) {
				$b = mysqli_fetch_assoc($db->select('tb_bank_cash', 'id_bank_cash="' . $v['id_bank'] . '"', 'bank_cash', 'ASC'));
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
						$total = $saldo_awal_bulan - $payment;
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



				$rows .= '{"no":"' . $no . '",';
				$rows .= '"number":"' . $v["number"] . '",';
				$rows .= '"bank_date":"' . $v["tanggal_bank"] . '",';
				$rows .= '"type_of_receipt":"' . $type_transaction . '",';
				$rows .= '"dari":"' . $dari . '",';
				$rows .= '"bank":"' . $b["bank_cash"] . '",';
				$rows .= '"receipt":"Rp.' . number_format($receipt, 2, ',', '.') . '",';
				$rows .= '"payment":"Rp.' . number_format($payment, 2, ',', '.') . '",';
				$rows .= '"total":"Rp.' . number_format($total, 2, ',', '.') . '"}';

				$no++;

				if ($i < $jum) {
					$rows .= ",";
					$i++;
				}
			}

			$_SESSION['total' . $page] = $total;

			$rows = $rows . ']';

			echo $rows;
		}
	}
}
