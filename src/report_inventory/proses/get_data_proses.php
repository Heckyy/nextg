<?php
session_start();

if (!empty($_SESSION['id_employee']) && !empty($_POST['proses'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";
	$db = new db();
	$library_class = new library_class();
	if ($_POST['proses'] == 'tarik_data') {
		$e = mysqli_fetch_assoc($db->select('tb_settings', 'id_settings', 'id_settings', 'DESC'));
		$warehouse = $db->select('tb_warehouse', 'id_warehouse', 'warehouse', 'ASC');
		$w = mysqli_fetch_assoc($warehouse);
		$item = $db->select('tb_item', 'id_item', 'item', 'ASC');
		$b = mysqli_fetch_assoc($item);
		if (!empty($_POST['cari'])) {
			$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
		} else {
			$ubah_pencarian = "";
		}
		if (!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['item']) && !empty($_POST['warehouse'])) {
			$select_tahun = mysqli_real_escape_string($db->query, $_POST['tahun']);
			$select_bulan = mysqli_real_escape_string($db->query, $_POST['bulan']);
			$select_item = mysqli_real_escape_string($db->query, $_POST['item']);
			$select_warehouse = mysqli_real_escape_string($db->query, $_POST['warehouse']);
			if ($select_bulan < 10) {
				$select_bulan = "0" . $select_bulan;
			}
			$priod = $select_tahun . '-' . $select_bulan;
		} else {
			$select_tahun = $library_class->tahun();
			$select_bulan = $library_class->bulan();
			$priod = $select_tahun . '-' . $select_bulan;

			if (!empty($_SESSION['item'])) {
				$select_item = $_SESSION['item'];
			} else {
				$select_item = $b['id_item'];
			}

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

		// Get Data Saldo Awal
		$data_awal = $db->select('tb_item_receipt_out INNER JOIN tb_item_receipt_out_detail ON tb_item_receipt_out.number_item_receipt_out=tb_item_receipt_out_detail.number_item_receipt_out', 'tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.number_item_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.type_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.from_for LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '"', 'tb_item_receipt_out.id_item_receipt_out', 'ASC');
		$no = 1;
		$i = 1;
		if (mysqli_num_rows($data) > 0) {
			$total = 0;
			$total_in_jum = 0;
			$total_out_jum = 0;
			$rows = '[';
			$jum_data_awal = mysqli_num_rows($data_awal);
			if ($jum_data_awal > 0) {
				$total_balance = 0;
				foreach ($data_awal as $key => $da) {
					if ($da['type_transaction'] == 'i') {
						$total_balance = $total_balance + $da['qty'];
					} else {
						$total_balance = $total_balance - $da['qty'];
					}
				}
				$rows = "";
				$rows .= '{"no":"1",';
				$rows .= '"number":"",';
				$rows .= '"type_receipt_out":"-",';
				$rows .= '"from_for":"Balance",';
				$rows .= '"in":"' . $total_balance . '",';
				$rows .= '"total_in_jum":"' . $total_balance . '",';
				$rows .= '"out":"",';
				$rows .= '"total_out_jum":"' . $total_balance . '",';
				$rows .= '"total":"' . $total_balance . '"},';
			}
			$jum = mysqli_num_rows($data);
			foreach ($data as $key => $v) {
				if ($v['type_transaction'] == 'i') {
					$total = $total + $v['qty'];
					$in = $v['qty'];
					$total_in_jum = $total_in_jum + $v['qty'];
					$out = '';
				} else {
					$total = $total - $v['qty'];
					$in = '';
					$total_out_jum = $total_out_jum + $v['qty'];
					$out = $v['qty'];
				}
				if (!empty($v['number_purchasing'])) {
					$from_for = $v['from_for'] . ' - ( ' . $v['number_purchasing'] . ' )';
				} else {
					$from_for = $v['from_for'];
				}
				$rows .= '{"no":"' . $no . '",';
				$rows .= '"number":"' . $v["item"] . '",';
				$rows .= '"type_receipt_out":"' . $v["tanggal"] . '",';
				$rows .= '"in":"' . $in . '",';
				$rows .= '"total_in_jum":"' . $total_in_jum . '",';
				$rows .= '"out":"' . $out . '",';
				$rows .= '"total_out_jum":"' . $total_out_jum . '",';
				$rows .= '"total":"' . $total . '"}';
				$no++;
				if ($i < $jum) {
					$rows .= ",";
					$i++;
				}
			}
			$rows = $rows . ']';
			echo $rows;
		} else {
			$jum_data_awal = mysqli_num_rows($data_awal);
			if ($jum_data_awal > 0) {
				$total_balance = 0;
				foreach ($data_awal as $key => $da) {
					if ($da['type_transaction'] == 'i') {
						$total_balance = $total_balance + $da['qty'];
					} else {
						$total_balance = $total_balance - $da['qty'];
					}
				}
				$rows = "";
				$rows .= '[{"no":"1",';
				$rows .= '"number":"",';
				$rows .= '"type_receipt_out":"",';
				$rows .= '"from_for":"Balance",';
				$rows .= '"in":"' . $total_balance . '",';
				$rows .= '"total_in_jum":"' . $total_balance . '",';
				$rows .= '"out":"",';
				$rows .= '"total_out_jum":"0",';
				$rows .= '"total":"' . $total_balance . '"}]';
				echo $rows;
			} else {

				echo $jum_data_awal;
			}
		}
	} //ga usah di bawa


	// In this Below is function for print

}
