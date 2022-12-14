<?php
class employee
{
	function view_employee($db, $e, $view, $page)
	{

		if ($_SESSION['employee'] == 1) {

			$perPage = 10;

			if (!empty($_POST['cari'])) {
				$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			} else {
				$ubah_pencarian = "";
			}

			$result = $db->select('tb_employee', 'code_employee LIKE "%' . $ubah_pencarian . '%" || name LIKE "%' . $ubah_pencarian . '%" || unit LIKE "%' . $ubah_pencarian . '%" || position LIKE "%' . $ubah_pencarian . '%"', 'code_employee', 'ASC');

			$totalRecords = mysqli_num_rows($result);
			$totalPages = ceil($totalRecords / $perPage);

			$cek_error = "";

			if ($totalRecords == 0) {
				$cek_error = '<tr><td colspan="7">Data not found!</td></tr>';
			}

?>

			<script src="<?php echo $e; ?>/src/employee/js/jsproses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Pengurus
						</h6>
					</div>
					<div class="col-auto">
						<div class="page-utilities">
							<div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								<div class="col-auto">
									<form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
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
				if ($_SESSION['employee_new'] == 1) {
				?>
					<div class="col" align="right">
						<a href="<?php echo $e; ?>/employee/new" class="btn btn-default btn-sm link-new">
							New
						</a>
					</div>
				<?php
				}
				?>
			</div>


			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="scroll">
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td width="100px">Kode</td>
								<td width="250px">Nama</td>
								<td width="100px">Jenis Kelamin</td>
								<td>Jabatan</td>
								<td>Posisi</td>
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