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
	$date_asli	= $tahun . '-' . $bulan . '-' . $tanggal;

	$proses = mysqli_real_escape_string($db->query, $_POST['proses']);

	if ($proses == 'new' && $_SESSION['item_receipt_new'] == 1) {
		// $js = '<script>alert("OKE")</script<>';
		// echo $js;
		// $qtyInput = $_POST['qtyMg'];
		// $po = base64_decode($_POST['number_po']);
		// $cekPo = $db->select('tb_purchasing_detail', 'number_purchasing="' . $po . '"', 'id_purchasing_detail', 'DESC');
		// $resultPo = mysqli_fetch_assoc($cekPo);
		// echo $resultPo['qty'];
		$warehouse = mysqli_real_escape_string($db->query, $_SESSION['warehouse']);
		$from = mysqli_real_escape_string($db->query, base64_decode($_POST['from']));
		$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));


		$cek = $db->select('tb_item_receipt_out', 'type_transaction="i" && tanggal LIKE "%' . $date . '%"', 'urut', 'DESC');

		if (mysqli_num_rows($cek) > 0) {

			$bulan = $library_class->bulan();
			$tahun = $library_class->tahun();
			$potong = substr($tahun, 2);

			$c = mysqli_fetch_assoc($cek);

			$tambah = $c['urut'] + 1;

			$number = 'BMB/' . $bulan . '/' . $potong . '/' . $tambah;

			$urut = $tambah;
		} else {

			$bulan = $library_class->bulan();
			$tahun = $library_class->tahun();
			$potong = substr($tahun, 2);

			$number = 'BMB/' . $bulan . '/' . $potong . '/1';

			$urut = "1";
		}


		$data_purchasing = $db->select('tb_purchasing', 'number_purchasing="' . $from . '"', 'id_purchasing', 'ASC');
		$dp = mysqli_fetch_assoc($data_purchasing);
		$from = $dp['supplier'];

		$number_purchasing = $dp['number_purchasing'];


		$error = 0;

		$cek_purchasing_detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $number_purchasing . '"', 'id_purchasing_detail', 'ASC');
		while ($cpd = mysqli_fetch_assoc($cek_purchasing_detail)) {

			$acak = str_replace("=", "", base64_encode($cpd['id_purchasing_detail']));

			if (!empty($_POST['qty' . $acak])) {
				$error++;
			}
		}



		if ($error > 0) {


			$purchasing_detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $dp['number_purchasing'] . '"', 'id_purchasing_detail', 'ASC');
			while ($pd = mysqli_fetch_assoc($purchasing_detail)) {

				$acak = str_replace("=", "", base64_encode($pd['id_purchasing_detail']));

				if (!empty($_POST['qty' . $acak])) {
					$qty = mysqli_real_escape_string($db->query, $_POST['qty' . $acak]);

					if (!empty($qty)) {

						$data_item = $db->select('tb_item', 'id_item="' . $pd['id_item'] . '"', 'item', 'ASC');
						$i = mysqli_fetch_assoc($data_item);

						$db->insert('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $number . '",id_item="' . $pd['id_item'] . '",item="' . $i['item'] . '",qty="' . $qty . '",number_purchasing="' . $dp['number_purchasing'] . '"');
					}
				}
			}



			$db->insert('tb_item_receipt_out', 'number_item_receipt_out="' . $number . '",tanggal="' . $date_asli . '",from_for="' . $from . '",number_purchasing="' . $number_purchasing . '",note="' . $note . '",id_cluster="' . $dp['id_cluster'] . '",id_position="' . $dp['id_position'] . '",cluster="' . $dp['cluster'] . '",code_cluster="' . $dp['code_cluster'] . '",position="' . $dp['position'] . '",id_Warehouse="' . $warehouse . '",urut="' . $urut . '",type_transaction="i",input_data="' . $_SESSION['id_employee'] . '",status_inv_purchasing="0"');



			echo str_replace("=", "", base64_encode($number));
			// echo  '<script>alert ("oke")</script>';
		} else {
			echo '1';
		}
	} else if ($proses == 'cek_cancel') {
		$bmb = $_POST['bmb'];
		$cekBmb = $db->select('tb_item_receipt_out', 'status_inv_purchasing = "1" and number_item_receipt_out =' . '"' . $bmb . '"', 'number_purchasing', 'ASC');
		$jum = mysqli_num_rows($cekBmb);
		echo $jum;
	} else if ($proses == 'edit' && $_SESSION['item_receipt_edit'] == 1) {
		if (!empty($_POST['number'])) {

			$number = mysqli_real_escape_string($db->query, $_POST['number']);
			$warehouse = mysqli_real_escape_string($db->query, $_SESSION['warehouse']);
			$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));


			$cek = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $number . '"', 'id_item_receipt_out', 'DESC');

			if (mysqli_num_rows($cek) > 0) {

				$dp = mysqli_fetch_assoc($cek);

				$db->hapus('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $dp['number_item_receipt_out'] . '"');

				$purchasing_detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $dp['number_purchasing'] . '"', 'id_purchasing_detail', 'ASC');
				while ($pd = mysqli_fetch_assoc($purchasing_detail)) {

					$acak = str_replace("=", "", base64_encode($pd['id_purchasing_detail']));

					if (!empty($_POST['qty' . $acak])) {
						$qty = mysqli_real_escape_string($db->query, $_POST['qty' . $acak]);

						if (!empty($qty)) {

							$data_item = $db->select('tb_item', 'id_item="' . $pd['id_item'] . '"', 'item', 'ASC');
							$i = mysqli_fetch_assoc($data_item);

							$db->insert('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $number . '",id_item="' . $pd['id_item'] . '",item="' . $i['item'] . '",qty="' . $qty . '"');
						}
					}
				}



				$db->update('tb_item_receipt_out', 'note="' . $note . '",update_data="' . $_SESSION['id_employee'] . '"', 'number_item_receipt_out="' . $number . '"');


				echo str_replace("=", "", base64_encode($number));
			} else {

				echo "1";
			}
		}
	} else if ($proses == 'cancel' && !empty($_SESSION['number_item_receipt_out']) && $_SESSION['item_receipt_cancel'] == 1) {
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
	} else if ($proses == 'process' && !empty($_SESSION['number_item_receipt_out']) && $_SESSION['item_receipt_process'] == 1) {

		$cek = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '" && status="0"', 'id_item_receipt_out', 'DESC');
		$jum = mysqli_num_rows($cek);
		$success_data = 0;

		if ($jum > 0) {

			$c = mysqli_fetch_assoc($cek);

			if (!empty($c['number_purchasing'])) {

				$cek_detail = $db->select('tb_item_receipt_out_detail', 'number_item_receipt_out="' . $c['number_item_receipt_out'] . '"', 'id_item_receipt_out_detail', 'DESC');

				foreach ($cek_detail as $key => $d) {

					$cek_detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $c['number_purchasing'] . '" && id_item="' . $d['id_item'] . '"', 'id_purchasing_detail', 'DESC');
					$cd = mysqli_fetch_assoc($cek_detail);

					$qty = $cd['qty'] * 1;

					$terima = $cd['terima'] + $d['qty'];

					$db->update('tb_purchasing_detail', 'terima="' . $terima . '"', 'number_purchasing="' . $c['number_purchasing'] . '" && id_item="' . $d['id_item'] . '"');

					if ($qty !== $terima) {
						$success_data++;
					}
				}
			}

			if ($success_data == 0) {
				$db->update('tb_purchasing', 'status_terima_barang="1"', 'number_purchasing="' . $c['number_purchasing'] . '"');
			}

			$db->update('tb_item_receipt_out', 'status="1"', 'number_item_receipt_out="' . $_SESSION['number_item_receipt_out'] . '"');
		}

		echo str_replace("=", "", base64_encode($_SESSION['number_item_receipt_out']));
	} else if ($proses == 'hapus' && $_SESSION['item_receipt_edit'] == 1) {

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
	} else if ($proses == 'tarik_po' && $_SESSION['item_receipt_new'] == 1) {

		$po = mysqli_real_escape_string($db->query, base64_decode($_POST['po']));
		$detail = $db->select('tb_purchasing_detail', 'number_purchasing="' . $po . '"', 'id_purchasing_detail', 'DESC');

		$no = 1;
		foreach ($detail as $key => $d) {

			$acak_id = str_replace("=", "", base64_encode($d['id_purchasing_detail']));

			if (empty($d['terima'])) {
				$terima = 0;
			} else {
				$terima = $d['terima'];
			}

			$hitung = $d['qty'] - $terima;

?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d['item']; ?></td>
				<td><?php echo $hitung; ?></td>
				<td>
					<input type="number" max="<?php echo $hitung; ?>" name="qty<?php echo $acak_id; ?>" id="qty<?php echo $acak_id; ?>" value="<?php echo $hitung; ?>" class="form-control" onchange="hitung('<?php echo $acak_id; ?>');">
				</td>
				<td id="hasil<?php echo $acak_id; ?>"><?php echo $terima; ?></td>
			</tr>
<?php
			$no++;
		}
	} else if ($proses == 'hitung' && $_SESSION['item_receipt_new'] == 1) {
		$detail = mysqli_real_escape_string($db->query, $_POST['detail']);
		$terima_qty = mysqli_real_escape_string($db->query, $_POST['qty']);

		$ubah = base64_decode($detail);
		$detail_select = $db->select('tb_purchasing_detail', 'id_purchasing_detail="' . $ubah . '"', 'id_purchasing_detail', 'DESC');
		$d = mysqli_fetch_assoc($detail_select);

		if (empty($terima_qty)) {
			$terima_qty = 0;
		} else {
			$terima_qty = $terima_qty;
		}

		if (empty($d['terima'])) {
			$terima = 0;
		} else {
			$terima = $d['terima'];
		}

		$hitung = $d['qty'] - $terima - $terima_qty;
		echo $hitung;
	} else if ($proses == 'ambil_divisi') {
		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
		$cek = $db->select('tb_purchasing', 'number_purchasing="' . $id . '"', 'id_purchasing', 'DESC');
		$jum = mysqli_num_rows($cek);
		if ($jum > 0) {
			$r = mysqli_fetch_assoc($cek);
			echo '<option value="">Select</option>';
			echo '<option value="' . $r['id_position'] . '" selected>' . $r['position'] . '</option>';
		} else {
			echo '<option value="">Select</option>';
		}
	} else if ($proses == 'ambil_cluster') {
		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
		$cek = $db->select('tb_purchasing', 'number_purchasing="' . $id . '"', 'id_purchasing', 'DESC');
		$jum = mysqli_num_rows($cek);
		if ($jum > 0) {
			$r = mysqli_fetch_assoc($cek);
			echo '<option value="">Select</option>';
			echo '<option value="' . $r['id_cluster'] . '" selected>' . $r['code_cluster'] . ' - ' . $r['cluster'] . '</option>';
		} else {
			echo '<option value="">Select</option>';
		}
	}
}

?>