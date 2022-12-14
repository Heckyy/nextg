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
	//$date_asli	= $tahun . '-' . $bulan . '-' . $tanggal;

	$proses = mysqli_real_escape_string($db->query, $_POST['proses']);

	if ($proses == 'new' && $_SESSION['item_out_new'] == 1) {
		if (!empty($_POST['qty']) && !empty($_POST['item'])) {

			$type_of_out_wh = mysqli_real_escape_string($db->query, $_POST['type_of_out_wh']);
			$warehouse = mysqli_real_escape_string($db->query, $_SESSION['warehouse']);
			$untuk = mysqli_real_escape_string($db->query, $_POST['untuk']);
			$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
			$item = mysqli_real_escape_string($db->query, $_POST['item']);
			$qty = mysqli_real_escape_string($db->query, $_POST['qty']);
			$date_asli = $_POST['tanggal'];
			$potong_bln = explode('-', $date_asli);
			$bulan_potong = $potong_bln[0] . '-' . $potong_bln[1];
			// echo $bulan_potong;

			$cek = $db->select('tb_item_receipt_out', 'type_transaction="i" && tanggal LIKE "%' . $bulan_potong . '%"', 'urut', 'DESC');

			$result_cek = mysqli_num_rows($cek);
			//echo $result_cek;

			if (mysqli_num_rows($cek) > 0) {

				$bulan = $potong_bln[1];
				$tahun = $potong_bln[0];

				$potong = substr($tahun, 2);

				$c = mysqli_fetch_assoc($cek);

				$tambah = $c['urut'] + 1;

				$number = 'BKB/' . $bulan . '/' . $potong . '/' . $tambah;

				$urut = $tambah;
			} else {

				$bulan = $potong_bln[1];
				$tahun = $potong_bln[0];

				$potong = substr($tahun, 3);

				$number = 'BKB/' . $bulan . '/' . $potong . '/1';

				$urut = "1";
			}

			$cek_data = 0;

			$data_item = $db->select('tb_item', 'id_item="' . $item . '"', 'item', 'ASC');
			$i = mysqli_fetch_assoc($data_item);

			$data_type_receipt = $db->select('tb_type_of_out_wh', 'id_type_of_out_wh="' . $type_of_out_wh . '"', 'type_of_out_wh', 'ASC');
			$tr = mysqli_fetch_assoc($data_type_receipt);



			$db->insert('tb_item_receipt_out', 'number_item_receipt_out="' . $number . '",tanggal="' . $date_asli . '",from_for="' . $untuk . '",id_type_receipt_out="' . $type_of_out_wh . '",type_receipt_out="' . $tr['type_of_out_wh'] . '",note="' . $note . '",id_Warehouse="' . $warehouse . '",urut="' . $urut . '",type_transaction="o",input_data="' . $_SESSION['id_employee'] . '"');

			$db->insert('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $number . '",id_item="' . $item . '",item="' . $i['item'] . '",qty="' . $qty . '"');

			echo str_replace("=", "", base64_encode($number));
		}
	} else if ($proses == 'edit' && $_SESSION['item_out_edit'] == 1) {
		if (!empty($_POST['number']) && !empty($_POST['qty']) && !empty($_POST['item'])) {

			$number = mysqli_real_escape_string($db->query, $_POST['number']);
			$warehouse = mysqli_real_escape_string($db->query, $_SESSION['warehouse']);
			$untuk = mysqli_real_escape_string($db->query, $_POST['untuk']);
			$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
			$item = mysqli_real_escape_string($db->query, $_POST['item']);
			$qty = mysqli_real_escape_string($db->query, $_POST['qty']);

			$cek = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $number . '"', 'id_item_receipt_out', 'DESC');

			$detail = $db->select('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $number . '" && id_item="' . $item . '"', 'id_item_receipt_out_detail', 'DESC');

			$data_item = $db->select('tb_item', 'id_item="' . $item . '"', 'item', 'ASC');
			$i = mysqli_fetch_assoc($data_item);

			$total = "0";
			if (mysqli_num_rows($cek) > 0) {

				if (mysqli_num_rows($detail) > 0) {
					$d = mysqli_fetch_assoc($detail);
					$db->update('tb_item_receipt_out_detail', 'qty="' . $qty . '"', 'id_item_receipt_out_detail="' . $d['id_item_receipt_out_detail'] . '"');
				} else {
					$db->insert('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $number . '",id_item="' . $item . '",item="' . $i['item'] . '",qty="' . $qty . '"');
				}


				$db->update('tb_item_receipt_out', 'from_for="' . $untuk . '",note="' . $note . '",update_data="' . $_SESSION['id_employee'] . '"', 'number_item_receipt_out="' . $number . '"');


				echo str_replace("=", "", base64_encode($number));
			} else {

				echo "1";
			}
		}
	} else if ($proses == 'cancel' && !empty($_SESSION['number_item_receipt_out']) && $_SESSION['item_out_cancel'] == 1) {
		$cek = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '" && status="1"', 'id_item_receipt_out', 'DESC');
		$jum = mysqli_num_rows($cek);

		if ($jum > 0) {

			$c = mysqli_fetch_assoc($cek);

			$db->update('tb_purchasing', 'status_terima_barang="0"', 'number_purchasing="' . $c['number_purchasing'] . '"');

			$cek_detail = $db->select('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $c['number_item_receipt_out'] . '"', 'id_item_receipt_out_detail', 'DESC');

			foreach ($cek_detail as $key => $d) {

				$cek_detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $c['number_purchasing'] . '" && id_item="' . $d['id_item'] . '"', 'id_purchasing_detail', 'DESC');
				$cd = mysqli_fetch_assoc($cek_detail);

				$ganti_qty = $cd['terima'] - $d['qty'];

				$db->update('tb_purchasing_detail', 'terima="' . $ganti_qty . '"', 'number_purchasing="' . $c['number_purchasing'] . '" && id_item="' . $d['id_item'] . '"');
			}
		}

		$db->update('tb_item_receipt_out', 'status="2"', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '"');

		echo str_replace("=", "", base64_encode($_SESSION['number_item_receipt_out']));
	} else if ($proses == 'process' && !empty($_SESSION['number_item_receipt_out']) && $_SESSION['item_out_process'] == 1) {

		$cek = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '" && status="0"', 'id_item_receipt_out', 'DESC');
		$jum = mysqli_num_rows($cek);
		$success_data = 0;

		if ($jum > 0) {

			$c = mysqli_fetch_assoc($cek);

			$db->update('tb_item_receipt_out', 'status="1"', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '"');
		}

		echo str_replace("=", "", base64_encode($_SESSION['number_item_receipt_out']));
	} else if ($proses == 'hapus' && $_SESSION['item_out_edit'] == 1) {

		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

		$cek = $db->select('tb_item_receipt_out_detail', 'id_item_receipt_out_detail="' . $id . '"', 'id_item_receipt_out_detail', 'DESC');
		$jum = mysqli_num_rows($cek);
		if ($jum > 0) {
			$d = mysqli_fetch_assoc($cek);

			$hasil = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $d['number_item_receipt_out'] . '" && status="0"', 'id_item_receipt_out', 'DESC');
			$jum_hasil = mysqli_num_rows($hasil);
			if ($jum_hasil > 0) {
				$db->hapus('tb_item_receipt_out_detail', 'id_item_receipt_out_detail="' . $id . '"');
			}
			echo str_replace("=", "", base64_encode($d['number_item_receipt_out']));
		}
	}
}
