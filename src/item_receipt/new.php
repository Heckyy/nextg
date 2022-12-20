<?php
class new_item_receipt
{

	function new_view($db, $e, $library_class)
	{

		if ($_SESSION['item_receipt_new'] == 1) {

			$tanggal 	= $library_class->tanggal();
			$bulan 		= $library_class->bulan();
			$tahun 		= $library_class->tahun();

			$date 		= $tanggal . '-' . $bulan . '-' . $tahun;

			$type_of_receipt_wh = $db->select('tb_type_of_receipt_wh', 'id_type_of_receipt_wh', 'type_of_receipt_wh', 'ASC');
			$purchasing = $db->select('tb_purchasing', 'type_of_purchase="1" && status_terima_barang="0" && status="1"', 'id_purchasing', 'ASC');
			$item = $db->select('tb_item', 'id_item', 'item', 'ASC');
			$position = $db->select('tb_position', 'id_position', 'position', 'ASC');
			$cluster = $db->select('tb_cluster', 'id_cluster', 'cluster', 'ASC');
?>
			<script src="<?php echo $e; ?>/src/item_receipt/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Item Receipt
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
							<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							From
						</div>
						<div class="col-sm-3 col-lg-3">
							<select id="from" name="from" class="choices form-select square bg-white" required="required" onchange="from_po()">
								<option value="">Select</option>
								<?php
								foreach ($purchasing as $key => $t) {
									$acak = str_replace("=", "", base64_encode($t['number_purchasing']));;
								?>
									<option value="<?php echo $acak; ?>"><?php echo $t['supplier']; ?> - ( <?php echo $t['number_purchasing']; ?> )</option>
								<?php
								}
								?>
							</select>
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
								foreach ($position as $key => $p) {
								?>

									<option value="<?php echo $p['id_position']; ?>">
										<?php echo $p['position']; ?>
									</option>

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
							<select id="cluster" name="cluster" class="form-control square" disabled="disabled">
								<option value="">Select</option>
								<?php
								foreach ($cluster as $key => $tr) {
								?>

									<option value="<?php echo $tr['id_cluster']; ?>">
										<?php echo $tr['code_cluster'] . ' - ' . $tr['cluster']; ?>
									</option>

								<?php
								}
								?>
							</select>
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

					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td width="250px">Item</td>
								<td width="150px">Qty</td>
								<td width="150px">Qty Accepted</td>
								<td width="150px">Difference</td>
							</tr>
						</thead>
						<tbody id="data_list">
							<tr>
								<td colspan="6">Data not found!</td>
							</tr>
						</tbody>
					</table>

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