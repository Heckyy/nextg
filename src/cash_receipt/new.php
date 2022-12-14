<?php
class new_cash_receipt
{

	function new_view($db, $e, $library_class)
	{

		if ($_SESSION['cash_receipt_new'] == 1 && !empty($_SESSION['bank'])) {

			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $_SESSION['bank'] . '"', 'bank_cash', 'ASC');
			$b = mysqli_fetch_assoc($bank);

			$type_of_receipt = $db->select('tb_type_of_receipt', 'id_type_of_receipt', 'type_of_receipt', 'ASC');

			$tanggal 	= $library_class->tanggal();
			$bulan 		= $library_class->bulan();
			$tahun 		= $library_class->tahun();

			$date 		= $tanggal . '-' . $bulan . '-' . $tahun;
?>

			<script type="text/javascript">
				$(document).ready(function() {
					var amount = document.getElementById("amount");

					amount.addEventListener("keyup", function(e) {
						amount.value = convertRupiah(this.value);
					});

					amount.addEventListener('keydown', function(event) {
						return isNumberKey(event);
					});

					$("#type_of_receipt").select2({
						theme: "bootstrap-5",
					});

					$("#tanggal").datepicker({
						dateFormat: "dd-mm-yy",
						changeMonth: true
					});

					$("#tanggal_bank").datepicker({
						dateFormat: "dd-mm-yy",
						changeMonth: true
					});
				});
			</script>

			<script src="<?php echo $e; ?>/src/cash_receipt/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Cash Receipt <b>( <?php if (!empty($b['bank_cash'])) {
													echo $b['bank_cash'];
												} ?> )</b>
						</h6>
					</div>
				</div>
			</div>

			<div class="app-card-body pb-3 main-content container-fluid">
				<form method="POST" id="new">
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Number
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="number" id="number" class="form-control square" required="required" disabled="disabled">
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Date
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Type of Receipt
						</div>
						<div class="col-sm-2 col-lg-3">
							<select id="type_of_receipt" name="type_of_receipt" class="form-control square bg-white" required>
								<option value="">Select</option>
								<?php
								foreach ($type_of_receipt as $key => $tr) {
								?>

									<option value="<?php echo $tr['id_type_of_receipt']; ?>">
										<?php echo $tr['type_of_receipt']; ?>
									</option>

								<?php
								}
								?>
							</select>
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Bank Date
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="tanggal_bank" id="tanggal_bank" value="" class="form-control square">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							From
						</div>
						<div class="col-sm-3 col-lg-3">
							<input type="text" name="dari" id="dari" class="form-control square" required="required">
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Account Name
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="account_name" id="account_name" value="" class="form-control square">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Total
						</div>
						<div class="col-sm-3 col-lg-3">
							<input type="text" name="amount" id="amount" class="form-control square" required="required">
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							No. Rek
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="account_number" id="account_number" value="" class="form-control square">
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