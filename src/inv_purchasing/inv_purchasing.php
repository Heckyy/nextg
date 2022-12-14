<?php
class inv_purchasing
{
	function view_inv_purchasing($db, $e, $library_class, $view, $page)
	{

		if ($_SESSION['purchasing'] == 1) {
			$perPage = 10;
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
				$priod = $select_tahun;
			} else {
				$select_tahun = $library_class->tahun();
				$select_bulan = $library_class->bulan();
				//$priod=$select_tahun.'-'.$select_bulan;
				$priod = $select_tahun;
			}
			$result = $db->select('tb_inv_purchasing', 'number_inv_purchasing LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%" || supplier LIKE "%' . $ubah_pencarian . '%" && tanggal LIKE "%' . $priod . '%" ', 'id_inv_purchasing', 'DESC');

			$totalRecords = mysqli_num_rows($result);
			$totalPages = ceil($totalRecords / $perPage);
			$cek_error = "";
			if ($totalRecords == 0) {
				$cek_error = '<tr><td colspan="8">Data not found!</td></tr>';
			}
			$bulan = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'All');
			$tahun = $library_class->tahun();

?>
			<script src="<?php echo $e; ?>/src/inv_purchasing/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Bills From Suppliers
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
												for ($i = 1; $i <= 13; $i++) {
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
					if ($_SESSION['purchasing'] == 1) {
					?>
						<a href="<?php echo $e; ?>/inv_purchasing/new" class="btn btn-default btn-sm link-new">
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
								<td width="50PX">No</td>
								<td width="150px">Number</td>
								<td>Date</td>
								<td width="200px">Supplier</td>
								<td>Total</td>
								<td>Note</td>
								<td align="center" width="80px">Status</td>
							</tr>
						</thead>
						<tbody id="data_view"></tbody>
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