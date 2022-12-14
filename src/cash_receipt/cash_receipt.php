<?php
class cash_receipt
{

	function view_cash_receipt($db, $e, $library_class, $view, $page)
	{


		$view = base64_decode($view);
		$cek_access = $db->select('tb_access_bank', 'id_bank_cash="' . $view . '" && id_employee="' . $_SESSION['id_employee'] . '"', 'id_access_bank', 'ASC');

		if ($_SESSION['cash_receipt'] == 1 && !empty($view) && !empty(mysqli_num_rows($cek_access))) {

			$perPage = 10;

			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $view . '"', 'bank_cash', 'ASC');

			$b = mysqli_fetch_assoc($bank);

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

			$bank_name = $db->select('tb_bank_cash', 'id_bank_cash="' . $b['id_bank_cash'] . '"', 'bank_cash', 'ASC');
			$bn = mysqli_fetch_assoc($bank_name);

			$_SESSION['bank'] = $bn['id_bank_cash'];

			$result = $db->select('tb_cash_receipt_payment', 'number LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%" && id_bank="' . $b['id_bank_cash'] . '" && type="i" || type_of_receipt  LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%" && id_bank="' . $b['id_bank_cash'] . '" && type="i"', 'id_cash_receipt_payment', 'DESC');

			$totalRecords = mysqli_num_rows($result);
			$totalPages = ceil($totalRecords / $perPage);

			$cek_error = "";

			if ($totalRecords == 0) {
				$cek_error = '<tr><td colspan="8">Data not found!</td></tr>';
			}

			$bulan = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$tahun = $library_class->tahun();
?>

			<script src="<?php echo $e; ?>/src/cash_receipt/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Cash Receipt <b>( <?php if (!empty($bn['bank_cash'])) {
													echo $bn['bank_cash'];
												} ?> )</b>
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
				<div class="col" align="right">
					<?php
					if ($_SESSION['receipt_from_population'] == 1) {
					?>
						<a href="<?php echo $e; ?>/cash-receipt/get-invoice" class="btn btn-info btn-sm">
							Penerimaan
						</a>
					<?php
					}
					if ($_SESSION['cash_receipt_new'] == 1) {
					?>
						<a href="<?php echo $e; ?>/invoice" class="btn btn-secondary btn-sm">
							Tagihan
						</a>
						<a href="<?php echo $e; ?>/cash-receipt/upload" class="btn btn-secondary btn-sm">
							Pembayaran
						</a>

						<a href="<?php echo $e; ?>/cash-receipt/new" class="btn btn-default btn-sm link-new">
							New
						</a>
					<?php
					}
					?>
				</div>
			</div>


			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="scroll">
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="130PX">Number</td>
								<td width="100PX">Date</td>
								<td>From</td>
								<td>Uraian/Bagian</td>
								<td>Rekening</td>
								<td>Total</td>
								<td align="center" width="80px">Status</td>
							</tr>
						</thead>
						<tbody id="data_view"><?php echo $cek_error; ?></tbody>
					</table>
				</div>
			</div>

			<input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">

			<div class="row">
				<div id="pagination"></div>
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