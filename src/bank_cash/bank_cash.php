<?php
class bank_cash
{

	function view_bank_cash($db, $e, $library_class, $view, $page)
	{
		$perPage = 10;

		if (!empty($_POST['cari'])) {
			$ubah_pencarian = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
		} else {
			$ubah_pencarian = "";
		}

		$result = $db->select('tb_bank_cash', 'code_bank_cash LIKE "%' . $ubah_pencarian . '%" || bank_cash LIKE "%' . $ubah_pencarian . '%"', 'bank_cash', 'ASC');

		$totalRecords = mysqli_num_rows($result);
		$totalPages = ceil($totalRecords / $perPage);

		$cek_error = "";

		if ($totalRecords == 0) {
			$cek_error = '<tr><td colspan="5">Data not found!</td></tr>';
		}

		$access = $db->select('tb_access', 'code_employee="' . $_SESSION['code_employee'] . '"', 'id_access', 'DESC');
		$acs = mysqli_fetch_assoc($access);
?>

		<script src="<?php echo $e; ?>/src/bank_cash/js/jsproses.js"></script>
		<div class="app-card-header p-3 main-content container-fluid">
			<div class="row justify-content-between align-items-center line">
				<div class="col-auto">
					<h6 class="app-card-title">
						Bank / Cash
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
			if ($_SESSION['bank_cash_new'] == 1) {
			?>
				<div class="col" align="right">
					<a href="<?php echo $e; ?>/bank-cash/new" class="btn btn-default btn-sm link-new">
						New
					</a>
					<a href="<?php echo $e; ?>/bank-cash/input-saldo" class="btn btn-primary btn-sm ">
						Input Saldo
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
							<td width="100px">Code</td>
							<td width="250px">Bank / Cash</td>
							<td width="250px">No. Rek</td>
							<td>Note</td>
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
	}
}
?>