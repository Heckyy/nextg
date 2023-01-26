<?php
class view_cash_receipt_ipl
{

	function data_view($db, $e, $library_class, $code)
	{

		$type_of_receipt = $db->select('tb_type_of_receipt', 'id_type_of_receipt', 'type_of_receipt', 'ASC');

		$view = base64_decode($code);
		$view_cash_receipt = $db->select('tb_cash_receipt_payment', 'number="' . $view . '" && type="i" && priod!=""', 'id_cash_receipt_payment', 'ASC');

		if (mysqli_num_rows($view_cash_receipt) > 0 && !empty($_SESSION['bank'])) {
			$v = mysqli_fetch_assoc($view_cash_receipt);
			$dues_type = $db->select('tb_dues', 'id_dues="' . $v['id_dues'] . '"', 'id_dues', 'ASC');
			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $v['id_bank'] . '"', 'bank_cash', 'ASC');
			$b = mysqli_fetch_assoc($bank);
			$tanggal = substr($v['tanggal'], 8, 2);
			$bulan = substr($v['tanggal'], 5, 2);
			$tahun = substr($v['tanggal'], 0, 4);
			$date = $tanggal . "-" . $bulan . "-" . $tahun;
			if (!empty($v['tanggal_bank'])) {
				$tanggal_bank = substr($v['tanggal_bank'], 8, 2);
				$bulan_bank = substr($v['tanggal_bank'], 5, 2);
				$tahun_bank = substr($v['tanggal_bank'], 0, 4);
				$date_bank = $tanggal_bank . "-" . $bulan_bank . "-" . $tahun_bank;
			} else {
				$date_bank = "";
			}
			$inputan = $tahun . '-' . $bulan;
			$sekarang = $library_class->tahun() . '-' . $library_class->bulan();

			$_SESSION['number_receipt'] = $v['number'];

			if ($v['status'] == 1) {
				$status = " - Finish";
			} else if ($v['status'] == 2) {
				$status = " - Cancel";
			} else {
				$status = "";
			}
			$acak = str_replace("=", "", base64_encode($v['number']));
			$view_cash_receipt_detail = $db->select('tb_cash_receipt_payment_detail', 'number="' . $view . '"', 'id_detail', 'DESC');

?>
			<script type="text/javascript">
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

				$("#tanggal_bank").datepicker({
					dateFormat: "dd-mm-yy",
					changeMonth: true
				});
			</script>
			<script src="<?php echo $e; ?>/src/cash_receipt/js/js_proses_population.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Bank / Penerimaan <b>( <?php if (!empty($b['bank_cash'])) {
														echo $b['bank_cash'];
													} ?> ) <?php echo $status; ?></b>
						</h6>
					</div>
					<?php
					if ($v['status'] == 0) {
					?>
						<div class="col-auto">
							<button class="btn btn-sm btn-info" onclick="process_transaction()">
								Process
							</button>
						</div>
					<?php
					} else if ($v['status'] == 1) {
					?>
						<div class="col-auto">
							<button class="btn btn-sm btn-primary" onclick="print_transaction('<?php echo $acak; ?>')">
								Print
							</button>
						</div>
					<?php
					} else if ($v['status'] == 3) {
					?>
						<div class="col-auto">
							<button class="btn btn-sm btn-warning" onclick="diketahui_transaction()">
								Is known
							</button>
						</div>
					<?php
					}
					?>
				</div>
			</div>

			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Number
					</div>
					<div class="col-sm-2 col-lg-3">
						<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number']; ?>" required="required" disabled="disabled">
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
						Type of Receipt
					</div>
					<div class="col-sm-2 col-lg-3">
						<select id="type_of_receipt" name="type_of_receipt" class="form-control square" required disabled="disabled">
							<option value="">Select</option>
							<?php
							foreach ($type_of_receipt as $key => $tr) {
							?>

								<option value="<?php echo $tr['id_type_of_receipt']; ?>" <?php if ($tr['id_type_of_receipt'] == $v['id_type_of_receipt']) {
																								echo "selected";
																							} ?>>
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
						<input type="text" name="tanggal_bank" id="tanggal_bank" value="<?php echo $date_bank; ?>" class="form-control square" disabled="disabled">
					</div>

				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Total
					</div>
					<div class="col-sm-3 col-lg-3">
						<input type="text" name="amount" id="amount" class="form-control square" value="<?php echo number_format($v['amount'], 2, ',', '.'); ?>" required="required" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Note
					</div>
					<div class="col-sm-5 col-lg-5">
						<textarea name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?php echo $v['note']; ?></textarea>
					</div>
				</div>
				<div class="space_line row">
					<div class="scroll-height">
						<table class="table ">
							<tr class="bg-white sticky-top">
								<td width="50px" align="center"><b>No</b></td>
								<td width="250px"><b>Name</b></td>
								<td width="100px"><b>Cluster</b></td>
								<td width="100px"><b>No.R</b></td>
								<td><b>Priode</b></td>
								<td><b>Tanggal</b></td>
								<td><b>Nominal Bayar</b></td>
								<td align="center"><b>Priode Bayar</b></td>
								<td width="10px;"></td>
								<td><b>Discount</b></td>
							</tr>
							<?php
							$jum = 0;
							$no = 1;
							foreach ($view_cash_receipt_detail as $key => $d) {
								$p = mysqli_fetch_assoc($db->select('tb_population', 'id_population="' . $d['id_population'] . '"', 'id_population', 'DESC'));
								$c = mysqli_fetch_assoc($db->select('tb_cluster', 'id_cluster="' . $p['id_cluster'] . '"', 'id_cluster', 'DESC'));
								if ($p['type_property'] == 1) {
									$surface_area = $p['surface_area'];
									$building_area = $p['building_area'];
									$the_land_price = $c['the_land_price'] * $surface_area;
									$building_price = $c['building_price'] * $building_area;
									$macro_price = $c['macro_price'] * $surface_area;
									$grand_total_ipl = $the_land_price + $building_price - $macro_price;
								} else {
									$surface_area = $p['surface_area'];
									$the_land_price = $c['the_land_price'] * $surface_area;
									$macro_price = $c['macro_price'] * $surface_area;
									$grand_total_ipl = $the_land_price - $macro_price;
								}

								$jum += $d['price'];
							?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><?php echo $p['name']; ?></td>
									<td><?php echo $c['code_cluster']; ?></td>
									<td><?php echo $p['house_number']; ?></td>
									<td><?php echo $d['priod']; ?></td>
									<td><?php echo $d['date']; ?></td>
									<td><?php echo number_format($d['price'], 2, ',', '.'); ?></td>

									<td align="center"><?php echo $d['priode_payment']; ?></td>
									<td>/Bln</td>
									<td align="center"><?php echo number_format($d['discount'], 2, ',', '.'); ?></td>
								</tr>
							<?php
								$no++;
							}
							?>
							<tr>
								<td colspan="12"><b>Grand Total : <?= number_format($jum, 2, ',', '.') ?></b></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-lg-12">
						<?php
						if ($inputan == $sekarang && $v['status'] !== '2' && $_SESSION['cash_receipt_cancel'] == 1) {
						?>
							<a href="#" onclick="cancel()">
								<button type="button" class="btn btn-sm btn-danger btn-custom">Cancel</button>
							</a>
						<?php
						}
						if ($v['status'] == '0' && $_SESSION['cash_receipt_edit'] == 1) {
						?>
							<a href="<?php echo $e; ?>/cash-receipt/edit-ipl/<?php echo $code; ?>">
								<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
							</a>
						<?php
						}
						?>
					</div>
				</div>
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