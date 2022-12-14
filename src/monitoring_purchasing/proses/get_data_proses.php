<?php
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

		if (!empty($_POST['cari'])) {
			$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
		} else {
			$ubah_pencarian = "";
		}

		if (!empty($_POST['bulan']) && !empty($_POST['tahun'])) {
			$select_tahun = mysqli_real_escape_string($db->query, $_POST['tahun']);
			$select_bulan = mysqli_real_escape_string($db->query, $_POST['bulan']);

			if ($select_bulan < 10) {
				$select_bulan = "0" . $select_bulan;
			}

			$priod = $select_tahun . '-' . $select_bulan;
		} else {
			$select_tahun = $library_class->tahun();
			$select_bulan = $library_class->bulan();
			$priod = $select_tahun . '-' . $select_bulan;
		}




		$data_request = $db->selectpage('tb_request', 'number_request LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%" || note LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%"', 'id_request', 'ASC', $startFrom, $perPage);

		$no = $startFrom + 1;
		$jum_data = mysqli_num_rows($data_request);
		// echo $jum_data;


		if (mysqli_num_rows($data_request) > 0) {
			$i = 1;
			$rows = '[';
			$jum = mysqli_num_rows($data_request);
			foreach ($data_request as $dr) {

				$tanggal = substr($dr['tanggal'], 8, 2);
				$bulan = substr($dr['tanggal'], 5, 2);
				$tahun = substr($dr['tanggal'], 0, 4);
				$date = $tanggal . "-" . $bulan . "-" . $tahun;
				$cluster = $dr['cluster'];
				if ($dr['status_purchasing'] == '1') {
					$status = "<i class='bi bi-check2-square'></i>";
				} else if ($dr['status_purchasing'] == '2') {
					$status = "<i class='bi bi-x-square'></i>";
				} else {
					$status = "<div class='spinner-border spinner-border-sm' role='status'></div>";
				}

				// $permintaan = '<b>' . $dr['request_number'] . '</b><br>Date : ' . $date . '<br>Cluster : ' . $dr['supplier'] . '<br>Status : ' . $status;
				$break = "<br>";
				// $permintaan = $dr['number_request'] . $break . $date . $break . $cluster . $break . $status;
				$permintaan = "<b>" . $dr['number_request'] . "</b>" . $break;
				$permintaan .= "Date : " . $date . $break;
				$permintaan .= "Cluster : " . $cluster . $break;
				$permintaan .= "Status : " . $status;





				// GET DATA PURCHASING FROM TABLE PURCHASING
				$data_purchasing = $db->select('tb_purchasing', 'number_request = "' . $dr['number_request'] . '"', 'id_purchasing', 'DESC');
				if (mysqli_num_rows($data_purchasing) > 0) {



					$jum_data_purchasing = mysqli_num_rows($data_purchasing);
					// echo $jum_data_purchasing;
					foreach ($data_purchasing as $key => $v) {

						$tanggal = substr($v['tanggal'], 8, 2);
						$bulan = substr($v['tanggal'], 5, 2);
						$tahun = substr($v['tanggal'], 0, 4);
						$date = $tanggal . "-" . $bulan . "-" . $tahun;

						if ($v['status'] == '1') {
							$status = "<i class='bi bi-check2-square'></i>";
						} else if ($v['status'] == '2') {
							$status = "<i class='bi bi-x-square'></i>";
						} else {
							$status = "<div class='spinner-border spinner-border-sm' role='status'></div>";
						}


						$tanggal_purchase = substr($v['tanggal'], 8, 2);
						$bulan_purchase = substr($v['tanggal'], 5, 2);
						$tahun_purchase = substr($v['tanggal'], 0, 4);
						$date_purchase = $tanggal_purchase . "-" . $bulan_purchase . "-" . $tahun_purchase;

						if ($v['type_of_purchase'] == 0) {
							$type_of_purchase = "Buy Stuff";
						} else {
							$type_of_purchase = "Service";
						}

						$purchase = '<b>' . $v['number_purchasing'] . '</b><br>Date : ' . $date_purchase . '<br>Supplier : ' . $v['supplier'] . '<br>Type of Purchase : ' . $type_of_purchase . '<br>Rp.' . number_format($v['total'], 2, ',', '.') . '<br>Status : ' . $status;

						$finance = '';

						$finance_data = $db->select('tb_cash_receipt_payment', 'number_purchasing="' . $v['number_purchasing'] . '" && status="1"', 'id_cash_receipt_payment', 'DESC');
						if (mysqli_num_rows($finance_data) > 0) {

							foreach ($finance_data as $key => $fd) {

								if ($fd['status'] == '1') {
									$status_finance = "<i class='bi bi-check2-square'></i>";
								} else if ($fd['status'] == '2') {
									$status_finance = "<i class='bi bi-x-square'></i>";
								} else {
									$status_finance = "<div class='spinner-border spinner-border-sm' role='status'></div>";
								}

								$tanggal_finance = substr($fd['tanggal'], 8, 2);
								$bulan_finance = substr($fd['tanggal'], 5, 2);
								$tahun_finance = substr($v['tanggal'], 0, 4);
								$date_finance = $tanggal_finance . "-" . $bulan_finance . "-" . $tahun_finance;

								$div = "<div class='col-auto'>";

								$finance = $finance . $div . '<b>' . $fd['number'] . '</b><br>Date : ' . $date_finance . '<br>Rp.' . number_format($fd['amount'], 2, ',', '.') . '<br>Status : ' . $status_finance . '</div>';
							}
						} else {
							$finance = '-';
						}
						// GET WAREHOUSE DATA FROM TABLE ITEM RECEIPT OUT
						$query_warehouse = 'SELECT * from tb_item_receipt_out JOIN tb_warehouse ON tb_item_receipt_out.id_warehouse = tb_warehouse.id_warehouse WHERE tb_item_receipt_out.status = 1 and number_purchasing = "' . $v['number_purchasing'] . '"';
						$warehouse_data = $db->selectAll($query_warehouse);
						// $warehouse_data = $db->select('tb_item_receipt_out', 'number_purchasing="' . $v['number_purchasing'] . '" && status="1"', 'id_item_receipt_out', 'DESC');
						if (mysqli_num_rows($warehouse_data) > 0) {
							foreach ($warehouse_data as $key => $wr) {

								if ($wr['status'] == '1') {
									$status_warehouse = "<i class='bi bi-check2-square'></i>";
								} else if ($wr['status'] == '2') {
									$status_warehouse = "<i class='bi bi-x-square'></i>";
								} else {
									$status_warehouse = "<div class='spinner-border spinner-border-sm' role='status'></div>";
								}

								$tanggal_warehouse = substr($wr['tanggal'], 8, 2);
								$bulan_warehouse = substr($fd['tanggal'], 5, 2);
								$tahun_warehouse = substr($v['tanggal'], 0, 4);
								$date_warehouse = $tanggal_warehouse . "-" . $bulan_warehouse . "-" . $tahun_warehouse;

								$div = "<div class='col-auto'>";

								$warehouse = "<b>" . $wr['number_item_receipt_out'] . "</b>" . "<br>";
								$warehouse .= "Date : " . $date_warehouse . $break;
								$warehouse .= "Warehouse : " . $wr['warehouse'] . $break;
								$warehouse .= "Status : " . $status;
								//$warehouse .= 
							}
						} else {
							$warehouse = '-';
						}


						$rows .= '{"no":"' . $no . '",';
						$rows .= '"permintaan":"' . $permintaan . '",';
						$rows .= '"purchase":"' . $purchase . '",';
						$rows .= '"finance":"' . $finance . '",';
						$rows .= '"warehouse":"' . $warehouse . '"}';

						$no++;

						if ($i < $jum) {
							$rows .= ",";
							$i++;
						}
					}
				} else {
					$purchase = "-";
					$finance = "-";
					$warehouse = "-";
					$rows .= '{"no":"' . $no . '",';
					$rows .= '"permintaan":"' . $permintaan . '",';
					$rows .= '"purchase":"' . $purchase . '",';
					$rows .= '"finance":"' . $finance . '",';
					$rows .= '"warehouse":"' . $warehouse . '"}';
					$no++;

					if ($i < $jum) {
						$rows .= ",";
						$i++;
					}
				}
			}

			$rows = $rows . ']';

			echo $rows;
		}
	}
}
