<?php
class invoice
{
	function view_invoice($db, $e, $library_class, $view, $page)
	{
		if ($_SESSION['invoice'] == 1) {
			$select_type = 'all';
			$perPage = 30;

			$dues_type = $db->select('tb_dues', 'id_dues', 'dues_type', 'ASC');
			$b = mysqli_fetch_assoc($dues_type);

			if (!empty($_POST['cari'])) {
				$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			} else {
				$ubah_pencarian = "";
			}
			// GET CURRENT DATE
			$this_date = date("d - m - Y");
			$this_date_split = explode("-", $this_date);
			$this_day = $this_date_split[0];
			$this_month = trim($this_date_split[1]);
			$this_year = trim($this_date_split[2]);

			// $custom_date = ("2022-01-08");
			// $this_date_db = date("Y-m-d");
			$this_date_db = date("Y-m-d");
			// $this_date_db = "2022-12-01";

			//Get Data Population
			$query_population = "SELECT * from tb_population";
			$cek_population = $db->selectAll($query_population);
			$result_cek_population = mysqli_fetch_assoc($cek_population);
			$building_area = $result_cek_population['building_area'];
			$type_property = $result_cek_population['type_property'];
			$surface_area = $result_cek_population['surface_area'];
			$tagihan_awal = 1;
			foreach ($cek_population as $key => $value) {
				$pemilik = $value['name'];
				$nomor_tagihan1 = str_pad($tagihan_awal, 4, "0", STR_PAD_LEFT);
				$nomor_tagihan_fix = trim("TGH{$this_year}{$this_month}{$nomor_tagihan1}");
				// $query_cek_tagihan = "SELECT * from tb_invoice_fix where nomor_tgh='{$nomor_tagihan_fix}'";
				// $query_cek_tagihan = "SELECT * from tb_invoice_fix where nomor_tgh='{$nomor_tagihan_fix}' && tanggal_tgh LIKE '%2022-12%'";
				$query_cek_tagihan = "SELECT * from tb_invoice_fix where nomor_tgh='{$nomor_tagihan_fix}' && tanggal_tgh LIKE '%" . $this_date_db . "%'";
				$cek_data_tagihan = $db->selectAll($query_cek_tagihan);
				$code_population = $value['code_population'];
				$explode_population = explode("/", $code_population);
				$code_population_result = $explode_population[2];
				$type_property = $result_cek_population['type_property'];
				$query_cluster = "SELECT * from tb_cluster where code_cluster = '{$code_population_result}'";
				$cek_cluster = $db->selectAll($query_cluster);
				while ($row = mysqli_fetch_assoc($cek_cluster)) {
					$surface_area = $value['surface_area'];
					$building_area = $value['building_area'];
					if ($type_property == 1) {
						$the_land_price = $row['the_land_price'] * $surface_area;
						$building_price = $row['building_price'] * $building_area;
						$macro_price = $row['macro_price'] * $surface_area;
						$grand_total_ipl = $the_land_price + $building_price - $macro_price;
					} else {
						$the_land_price = $row['the_land_price'] * $surface_area;
						$macro_price = $row['macro_price'] * $surface_area;
						$grand_total_ipl = $the_land_price - $macro_price;
					}
				}
				$tagihan_awal++;
				if (mysqli_num_rows($cek_data_tagihan) == 0) {
					$db->insert('tb_invoice_fix', 'nomor_bast="' . $value['code_population'] . '",nomor_tgh="' . $nomor_tagihan_fix . '",tanggal_tgh="' . $this_date_db . '",pemilik="' . $pemilik . '",nominal_tagihan="' . $grand_total_ipl . '",status="unpaid"');
					//$db->insert('tb_invoice_fix', 'nomor_bast="' . $value['code_population'] . '",nomor_tgh="' . $nomor_tagihan_fix . '",tanggal_tgh="2022-02-08",pemilik="' . $pemilik . '",nominal_tagihan="' . $grand_total_ipl . '",status="unpaid"');
				}
			}
			if (!empty($_POST['bulan']) && !empty($_POST['tahun'])) {
				$select_type = $_POST['dues_type'];
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
			$query_get_data_invoice = "SELECT * FROM tb_invoice_fix";
			$result_get_data_invoice = $db->selectAll($query_get_data_invoice);
			//var_dump(mysqli_num_rows($result_get_data_invoice));
			//$result = $db->select('tb_invoice INNER JOIN tb_warga ON tb_invoice.id_warga=tb_warga.id_warga INNER JOIN tb_dues ON tb_invoice.id_dues=tb_dues.id_dues', 'tb_invoice.number_invoice LIKE "%' . $ubah_pencarian . '%" && tb_invoice.tanggal LIKE "%' . $priod . '%" && tb_warga.type="0"' . $select_dues_type_query . ' || tb_warga.name LIKE "%' . $ubah_pencarian . '%" && tb_invoice.tanggal LIKE "%' . $priod . '%" && tb_warga.type="0"' . $select_dues_type_query, 'tb_invoice.id_invoice', 'DESC', 'tb_invoice.number_invoice,tb_invoice.tanggal,tb_invoice.amount,tb_invoice.status,tb_invoice.note,tb_warga.name,tb_warga.id_rt,tb_warga.type,tb_dues.dues_type');
			$totalRecords = mysqli_num_rows($result_get_data_invoice);
			$totalPages = ceil($totalRecords / $perPage);
			$final_get_data_invoice = mysqli_fetch_assoc($result_get_data_invoice);
			$cek_error = "";
			if ($totalRecords == 0) {
				$cek_error = '<tr><td colspan="12">Data Tidak Ada</td></tr>';
			}
			$bulan = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$tahun = $library_class->tahun();
?>

			<script src="<?php echo $e; ?>/src/invoice/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Tagihan
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
											<select id="dues_type" name="dues_type" class="form-control search-input bg-white" style="width: 150px">
												<option value="all">Select All</option>
												<?php
												$type_bayars = array("Paid", "Unpaid");
												foreach ($type_bayars as $type_bayar) {
												?>
													<option value="<?php echo $type_bayar; ?>" <?php if ($type_bayar == $select_type) {
																									echo "selected";
																								} ?>>
														<?php echo $type_bayar; ?>
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
				<?php
				if ($_SESSION['invoice_new'] == 1) {
				?>
					<div class="col" align="right">
						<a href="<?php echo $e; ?>/invoice/upload-invoice" class="btn btn-secondary btn-sm">
							Unggah
						</a>
						<a onclick="print_tagihan();" class="btn btn-secondary btn-sm" id="cetak">
							Print
						</a>

						<a href="<?php echo $e; ?>/invoice/new-dues" class="btn btn-secondary btn-sm">
							Iuran
						</a>
						<a href="<?php echo $e; ?>/invoice/new-all" class="btn btn-info btn-sm">
							Partisipasi
						</a>
						<a href="<?php echo $e; ?>/invoice/new" class="btn btn-default btn-sm link-new">
							New
						</a>
					</div>
				<?php
				}
				?>
			</div>
			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="">
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center"><b>No</b></td>
								<td width="100PX"><b>Nomor Tagihan</b></td>
								<td width="100PX"><b>Tanggal</b></td>
								<td><b>Pemilik</b></td>
								<td><b>Tagihan</b></td>
								<td><b>Sisa</b></td>
								<td><b>Catatan</b></td>
								<td align="center" width="80px"><b>Status</b></td>
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
			<!-- Modal For Edit Tagihan -->
			<form action="">
				<div class="modal" tabindex="-1" id="myModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Edit Tagihan</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="d-flex">
									<h6>Nomor Tagihan : </h6>
									<h6 id="nomor_tagihan"> TGH20201100001</h6>
								</div>
								<div class="d-flex">
									<h6>Pemilik : </h6>
									<h6 id="pemilik"> Andry Jaya</h6>
								</div>
								<div class="d-flex">
									<h6>Nominal Awal : </h6>
									<h6 id="nominal_awal">Rp.500.000</h6>
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" id="basic-addon1">Nominal Ubah</span>
									<input type="text" class="form-control" placeholder="Masukan Nominal Ubah" aria-label="Username" aria-describedby="basic-addon1">
								</div>
								<div class="input-group">
									<span class="input-group-text">Catatan</span>
									<textarea class="form-control" aria-label="With textarea"></textarea>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
								<button type="button" class="btn btn-primary" id="simpan">Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</form>

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