<?php
class view_upload
{
	function data_view($db, $e, $library_class)
	{
		$library_class = new library_class();
		$tanggal 	= $library_class->tanggal();
		$bulan 		= $library_class->bulan();
		$tahun 		= $library_class->tahun();
		$date		= $tahun . '-' . $bulan;
		$date_asli	= $tahun . '-' . $bulan . '-' . $tanggal;
		if ($_SESSION['cash_receipt_new'] == 1) {
?>
			<!-- <script type="text/javascript">
				$(document).ready(function() {
					$("#tanggal_bank").datepicker({
						dateFormat: "dd-mm-yy",0
						changeMonth: true
					});
				});
			</script> -->
			<script src="<?php echo $e; ?>/src/cash_receipt/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Bank / Penerimaan <b>( Unggah )</b>
						</h6>
					</div>
				</div>
			</div>
			<div class="app-card-body pb-3 main-content container-fluid">
				<form method="POST" id="upload" enctype="multipart/form-data">
					<div class="space_line row">
						<div class="col-sm-4 col-lg-4">
							<table class="table">
								<tr class="bg-white">
									<td colspan="2">Unggah (Excel . xlsx , CSV)</td>
								</tr>
								<tr class="bg-white">
									<td class="d-block">
										<h6>Masukan Tanggal:</h6>
										<input type="date" name="tanggal" id="tanggal" required="required" class="form-control square" autocomplete="off" disabled="disabled" value="<?php echo $date_asli; ?>">
									</td>
									<td></td>
								</tr>
								<tr class="bg-white">
									<td class="d-block">
										<h6>Masukan Tanggal Bank:</h6>
										<input type="date" required="required" name=" tanggal_bank" id="tanggal_bank" class="form-control square" autocomplete="off">
									</td>
									<td></td>
								</tr>

								<tr class="bg-white">
									<td>
										<h6>Masukan File : </h6>
										<input type="file" name="file_excel" id="file_excel" class="form-control square bg-white" required="required">
									</td>
									<td class="">
										<button type="submit" id="btn" class="btn btn-success mt-4">
											Unggah
										</button>
									</td>
								</tr>
								<tr class="">
									<td><a href="<?= $e; ?>/download">Download Contoh Template IPL</a></td>
								</tr>
							</table>
						</div>
					</div>
				</form>
				<div class="col-lg-12" id="data_view"></div>
			</div>
		<?php
		} else {
		?>
			<script type="text/javascript">
				document.location.href = localStorage.getItem('data_link') + "/cash-receipt";
			</script>
<?php
		}
	}
}
?>