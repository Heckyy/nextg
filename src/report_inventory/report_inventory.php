<?php
class report_inventory
{

	function view_report_inventory($db, $e, $library_class, $view, $page)
	{

		if ($_SESSION['report_inventory'] == 1) {

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

			$item_name = $db->select('tb_item', 'id_item="' . $select_item . '"', 'item', 'ASC');
			$bn = mysqli_fetch_assoc($item_name);


			$warehouse_name = $db->select('tb_warehouse', 'id_warehouse="' . $select_warehouse . '"', 'warehouse', 'ASC');
			$wr = mysqli_fetch_assoc($warehouse_name);

			$_SESSION['warehouse'] = $select_warehouse;


			$_SESSION['item'] = $select_item;


			$result = $db->select('tb_item_receipt_out INNER JOIN tb_item_receipt_out_detail ON tb_item_receipt_out.number_item_receipt_out=tb_item_receipt_out_detail.number_item_receipt_out', 'tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.number_item_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.type_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal LIKE "%' . $priod . '%" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.from_for LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '"', 'tb_item_receipt_out.id_item_receipt_out', 'DESC');

			$totalRecords = mysqli_num_rows($result);

			$cek_error = "";

			if ($totalRecords == 0) {

				$tambah_priod = $priod . '-01';

				$awal_priod = '2000-01-01';

				$priod_sebelumnya = date('Y-m-d', strtotime('-1 days', strtotime($tambah_priod)));

				$data_awal = $db->select('tb_item_receipt_out INNER JOIN tb_item_receipt_out_detail ON tb_item_receipt_out.number_item_receipt_out=tb_item_receipt_out_detail.number_item_receipt_out', 'tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.number_item_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.type_receipt_out LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '" || tb_item_receipt_out.tanggal between "' . $awal_priod . '" AND "' . $priod_sebelumnya . '" && tb_item_receipt_out.status="1" && tb_item_receipt_out_detail.id_item="' . $select_item . '" && tb_item_receipt_out.from_for LIKE "%' . $ubah_pencarian . '%" && tb_item_receipt_out.id_warehouse="' . $select_warehouse . '"', 'tb_item_receipt_out.id_item_receipt_out', 'ASC');

				$jum_data_awal = mysqli_num_rows($data_awal);

				if ($jum_data_awal > 0) {

					$total_balance = "";
					foreach ($data_awal as $key => $da) {
						if ($da['type_transaction'] == 'i') {
							$total_balance = $total_balance + $da['qty'];
						} else {
							$total_balance = $total_balance - $da['qty'];
						}
					}

					$cek_error = '<tr><td align="center">1</td><td colspan="2"></td><td>Balance</td><td>' . $total_balance . '</td><td>0</td><td>' . $total_balance . '</td></tr><tr><td colspan="3"></td><td align="right"><b>Total</b></td><td><b>' . $total_balance . '</b></td><td><b>0</b></td><td><b>' . $total_balance . '</b></td></tr>';
				} else {

					$cek_error = '<tr><td colspan="7">Data not found!</td></tr>';
				}
			}

			$bulan = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$tahun = $library_class->tahun();

?>

			<script src="<?php echo $e; ?>/src/report_inventory/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Laporan Stock<b> (Stock Card)</b>
						</h6>
					</div>
					<div class="col-auto">
						<div class="page-utilities">
							<div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								<div class="col-auto">
									<form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
										<div class="col-auto">
											<select id="bulan" name="bulan" class="form-control search-input bg-white">
												<?php
												for ($i = 1; $i <= 12; $i++) {
												?>

													<option value="<?php echo $i; ?>" <?php if ($i == $select_bulan) {
																							echo "selected";
																						} ?>>
														<?php echo $bulan[$i]; ?>
													</option>

												<?php
												}
												?>
											</select>
										</div>
										<div class="col-auto">
											<select id="tahun" name="tahun" class="form-control search-input bg-white" style="width: 100px">
												<?php
												for ($i = $tahun; $i >= 2010; $i--) {
												?>

													<option value="<?php echo $i; ?>" <?php if ($i == $select_tahun) {
																							echo "selected";
																						} ?>>
														<?php echo $i; ?>
													</option>

												<?php
												}
												?>
											</select>
										</div>
										<div class="col-auto">
											<select id="item" name="item" class="form-control search-input bg-white" style="width: 100px">
												<?php
												foreach ($item as $key => $bk) {
												?>

													<option value="<?php echo $bk['id_item']; ?>" <?php if ($bk['id_item'] == $select_item) {
																										echo "selected";
																									} ?>>
														<?php echo $bk['item']; ?>
													</option>

												<?php
												}
												?>
											</select>
										</div>
										<div class="col-auto">
											<select id="warehouse" name="warehouse" class="form-control search-input bg-white" style="width: 100px">
												<?php
												foreach ($warehouse as $key => $bk) {
												?>

													<option value="<?php echo $bk['id_warehouse']; ?>" <?php if ($bk['id_warehouse'] == $select_warehouse) {
																											echo "selected";
																										} ?>>
														<?php echo $bk['warehouse']; ?>
													</option>

												<?php
												}
												?>
											</select>
										</div>
										<div class="col-auto">
											<input type="text" id="cari" name="cari" value="<?php echo $ubah_pencarian; ?>" class="form-control search-input" placeholder="Search">
										</div>
										<div class="col-auto">
											<button type="submit" class="btn btn-success">
												<i class="bi bi-search"></i>
											</button>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-lg-end">
					<button class="btn btn-primary" onclick="print_transaction();" id="cetak">
						Cetak
					</button>
				</div>
			</div>


			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="scroll">
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td width="150px">Item</td>
								<td width="200px">Tanggal</td>
								<td width="200px"></td>
								<td>Masuk</td>
								<td>Keluar</td>
								<td>Stock</td>
							</tr>
						</thead>
						<tbody id="data_view"><?php echo $cek_error; ?></tbody>
					</table>
				</div>
			</div>

		<?php
		} else {
		?>
			<script type="text/javascript">
				document.location.href = localStorage.getItem('data_link') + "/error-page";
			</script>
<?php
		}
	}
}
?>