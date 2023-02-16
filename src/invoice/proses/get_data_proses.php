<?php
session_start();
if (!empty($_SESSION['id_employee']) && !empty($_POST['proses'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";
	$db = new db();
	$library_class = new library_class();
	if ($_POST['proses'] == 'tarik_data') {
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$perPage = 30;
		if (isset($_POST["page"])) {
			$page  = $_POST["page"];
		} else {
			$page = 1;
		};
		$startFrom = ($page - 1) * $perPage;
		$e = mysqli_fetch_assoc($db->select('tb_settings', 'id_settings', 'id_settings', 'DESC'));
		$bank = $db->select('tb_bank_cash', 'id_bank_cash', 'bank_cash', 'ASC');
		$b = mysqli_fetch_assoc($bank);
		if (!empty($_POST['cari'])) {
			$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
		} else {
			$ubah_pencarian = "";
		}
		if (!empty($_POST['bulan']) && !empty($_POST['tahun'])) {
			$select_tahun = mysqli_real_escape_string($db->query, $_POST['tahun']);
			$select_bulan = mysqli_real_escape_string($db->query, $_POST['bulan']);
			$select_dues_type = mysqli_real_escape_string($db->query, $_POST['dues_type']);
			$select_dues_type_pilih = mysqli_real_escape_string($db->query, $_POST['dues_type']);
			$total_bayar;
			if ($select_bulan < 10) {
				$select_bulan = "0" . $select_bulan;
			}
			$priod = $select_tahun . '-' . $select_bulan;
		} else {
			$select_tahun = $library_class->tahun();
			$select_bulan = $library_class->bulan();
			$priod = $select_tahun . '-' . $select_bulan;
		}
		//Line 44 - 63 : Select Data berdasarkan sudah bayar atau belum
		if ($select_dues_type == "Unpaid") {
			$result_nominal_tagihan = 0;
			$datas = $db->selectpage('tb_invoice_fix', 'status = "unpaid" && tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC", $startFrom, $perPage);
			$datas_all = $db->select('tb_invoice_fix', 'status = "unpaid" && tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC");
			$query_sum_nominal_tagihan = "SELECT SUM(nominal_tagihan) as nominal_tagihan from tb_invoice_fix where status = 'unpaid' && tanggal_tgh like'%" . $priod . "%'";
			while ($data = mysqli_fetch_assoc($datas_all)) {

				$nominal = intval($data['nominal_tagihan']);
				$result_nominal_tagihan += $nominal;
				$result_nominal_tagihan2 = (int)$result_nominal_tagihan;
			};
		} else if ($select_dues_type == "Paid") {
			$result_nominal_tagihan = 0;
			$datas = $db->selectpage('tb_invoice_fix', 'status = "paid" && tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC", $startFrom, $perPage);
			$datas_all = $db->select('tb_invoice_fix', 'status = "paid" && tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC");
			while ($data = mysqli_fetch_assoc($datas_all)) {

				$nominal = intval($data['nominal_tagihan']);
				$result_nominal_tagihan += $nominal;
				$result_nominal_tagihan2 = (int)$result_nominal_tagihan;
			};
		} else {
			$result_nominal_tagihan = 0;
			$datas = $db->selectpage('tb_invoice_fix', 'tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC", $startFrom, $perPage);
			$datas_all = $db->select('tb_invoice_fix', 'tanggal_tgh LIKE "%' . $priod . '%" && pemilik LIKE"%' . $ubah_pencarian . '%"', 'tanggal_tgh', "ASC");
			while ($data = mysqli_fetch_assoc($datas_all)) {

				$nominal = intval($data['nominal_tagihan']);
				$result_nominal_tagihan += $nominal;
				$result_nominal_tagihan2 = (int)$result_nominal_tagihan;
			};
		}
		//Line 65 - 67 : Untuk mengembalikan data yang tidak ada ketika mencari

		$nomor_urut = 1;
		$jumlah_datas = mysqli_num_rows($datas);
		$total_bayar = 0;
		foreach ($datas as $key => $data) {
			$nomor_tgh = $data['nomor_tgh'];
			$tanggal = $data['tanggal_tgh'];
			$pemilik = $data['pemilik'];
			$catatan = $data['catatan'];
			$status = strtoupper($data['status']);
			$intTagihan = intval($data['nominal_tagihan']);
			$intBayar = intval($data['nominal_bayar']);
			$intSisa = intval($data['sisa']);
			$tagihan = "Rp." . number_format($intTagihan, 0, ',', ',');
			$bayar = "Rp." . number_format($intBayar, 0, ',', ',');
			$sisa = "Rp." . number_format($intSisa, 0, ',', ',');
			// $total_bayar = $result_nominal_tagihan['nominal_tagihan'];
			$total_bayar_fix = "Rp. " . number_format($result_nominal_tagihan2, 0, ",", ",");
			$rows[] = array(
				"no" => $nomor_urut,
				"nomor" => $nomor_tgh,
				"tanggal" => $tanggal,
				"tagihan" => $tagihan,
				"pemilik" => $pemilik,
				"bayar" => $bayar,
				"sisa" => $sisa,
				"status" => $status,
				"catatan" => $catatan,
				"total_tagihan" => $total_bayar_fix,
				"total_bayar" => $total_bayar
			);
			$nomor_urut++;
		}
		echo json_encode($rows);
		//}
	}
}
