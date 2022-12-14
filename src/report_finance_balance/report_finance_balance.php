<?php
class report_finance_balance
{

	function view_report_finance_balance($db, $e, $library_class, $view, $page)
	{

		if ($_SESSION['report_finance_balance'] == 1) {

			$perPage = 10;

			$bank = $db->select('tb_bank_cash', 'id_bank_cash', 'bank_cash', 'ASC');

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


				if ($select_bank_pilih == 'all') {
					$select_bank = '';
				} else {
					$select_bank = 'id_bank="' . $select_bank_pilih . '" && ';
				}
			} else {
				$select_from = '01-' . $library_class->bulan() . '-' . $library_class->tahun();
				$select_to = date("t-m-Y", time());

				$tanggal_awal = $library_class->tahun() . '-' . $library_class->bulan() . '-01';
				$tanggal_akhir = date("Y-m-t", time());

				$b = mysqli_fetch_assoc($bank);
				$select_bank_pilih = $b['id_bank_cash'];

				$select_bank = 'id_bank="' . $b['id_bank_cash'] . '" && ';
			}


			$_SESSION['bank'] = $select_bank_pilih;



			$result = $db->select('tb_cash_receipt_payment', $select_bank . 'tanggal BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '" && status="1"', 'id_cash_receipt_payment', 'DESC');

			$totalRecords = mysqli_num_rows($result);
			$totalPages = ceil($totalRecords / $perPage);

			$cek_error = "";

			if ($totalRecords == 0) {
				$cek_error = '<tr><td colspan="8">Data not found!</td></tr>';
			}

?>

			<script src="<?php echo $e; ?>/src/report_finance_balance/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Report Finance Balance
						</h6>
					</div>
				</div>
			</div>


			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="col-lg-12">
					<form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
						<table class="table">
							<tr>
								<td width="280px"><input type="text" class="form-control" name="from" id="from" placeholder="From" value="<?php echo $select_from; ?>"></td>
								<td width="280px"><input type="text" class="form-control" name="to" id="to" placeholder="To" value="<?php echo $select_to; ?>"></td>
								<td width="250px">
									<select id="bank" name="bank" class="form-control search-input bg-white">
										<?php
										foreach ($bank as $key => $bk) {
											$access_bank = $db->select('tb_access_bank', 'id_bank_cash="' . $bk['id_bank_cash'] . '" && id_employee="' . $_SESSION['id_employee'] . '"', 'id_access_bank', 'DESC');
											if (mysqli_num_rows($access_bank) > 0) {
										?>

												<option value="<?php echo $bk['id_bank_cash']; ?>" <?php if ($bk['id_bank_cash'] == $select_bank_pilih) {
																										echo "selected";
																									} ?>>
													<?php echo $bk['bank_cash']; ?>
												</option>

										<?php
											}
										}
										?>
										<option value="all" <?php if ($select_bank_pilih == 'all') {
																echo "selected";
															} ?>>All</option>
									</select>
								</td>
								<td>
									<button class="btn btn-primary">
										<i class="bi bi-search"></i>
									</button>
								</td>
								<td><button class="btn btn-success" onclick="print_transaction();" id="cetak">Cetak</button></td>
							</tr>
						</table>
					</form>
				</div>
				<!-- <div class="button-print col-auto d-flex justify-content-end p-3">
					<button class="btn btn-success">Print</button>
				</div> -->
				<div class="scroll">
					<table class="table mb-0">
						<thead>
							<tr>
								<td align="center">No</td>
								<td width="150px">Number</td>
								<td widht="150px">Bank Date</td>
								<td width="100px">Type of Transaction</td>
								<td width="100px">From / For</td>
								<td width="100px">Bank / Cash</td>
								<td>Receipt</td>
								<td>Payment</td>
								<td>Total</td>
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