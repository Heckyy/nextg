<?php
class starting_balance
{
	function create_starting_balance($db, $e, $library_class, $view, $page)
	{
		if ($_SESSION['begining_balance'] == 1) {
			$thisMonth = date("F - Y");
			$date = date("d-m-Y");

			date_default_timezone_set("asia/jakarta");
			$realTime = date('H:i:s');
			$tanggal 	= $library_class->tanggal();
			$bulan 		= $library_class->bulan();
			$tahun 		= $library_class->tahun(); ?>


			<script src="<?php echo $e; ?>/src/starting_balance/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Starting Balance
						</h6>
					</div>
				</div>
			</div>
			<div class="app-card-body pb-3 main-content container-fluid">
				<form method="POST" id="new">
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Periode
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="date" name="periode" id="periode" value="<?= $date; ?>" class="form-control square">
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Date
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Nominal
						</div>
						<div class="col-sm-3 col-lg-3">
							<input type="text" name="nominal" id="nominal" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Division
						</div>
						<div class="col-sm-2 col-lg-3">
							<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
								<option value="">Select</option>


							<?php
						}
							?>
							</select>
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Relocation
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
						</div>
					</div>

					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Note
						</div>
						<div class="col-sm-5 col-lg-5">
							<textarea name="note" id="note" class="form-control square textarea-edit"></textarea>
						</div>
					</div>

					<div class="space_line row">
						<div class="col-lg-12">
							<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
						</div>
					</div>
				</form>
			</div>



	<?php
	}
}

	?>