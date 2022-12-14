<?php
class new_item_out
{

	function new_view($db, $e, $library_class)
	{

		if ($_SESSION['item_out_new'] == 1) {

			$tanggal 	= $library_class->tanggal();
			$bulan 		= $library_class->bulan();
			$tahun 		= $library_class->tahun();

			$date 		= $tanggal . '-' . $bulan . '-' . $tahun;

			$type_of_out_wh = $db->select('tb_type_of_out_wh', 'id_type_of_out_wh', 'type_of_out_wh', 'ASC');

			$position = $db->select('tb_position', 'id_position', 'position', 'ASC');
			$cluster = $db->select('tb_cluster', 'id_cluster', 'cluster', 'ASC');

			$item = $db->select('tb_item', 'id_item', 'item', 'ASC');
?>
			<script src="<?php echo $e; ?>/src/item_out/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Item Out
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
							<input type="date" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Tipe Item Out
						</div>
						<div class="col-sm-3 col-lg-3">
							<select id="type_of_out_wh" name="type_of_out_wh" class="choices form-select square bg-white" required="required">
								<option value="">Select</option>
								<?php
								foreach ($type_of_out_wh as $key => $t) {
								?>
									<option value="<?php echo $t['id_type_of_out_wh']; ?>"><?php echo $t['type_of_out_wh']; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Uraian/Bagian
						</div>
						<div class="col-sm-2 col-lg-3">
							<select id="cluster" name="cluster" class="form-control square bg-white">
								<option value="">Select</option>
								<optgroup label="CLUSTER">
									<?php
									foreach ($cluster as $key => $tr) {
									?>

										<option value="C_<?php echo $tr['id_cluster']; ?>">
											<?php echo $tr['code_cluster'] . ' - ' . $tr['cluster']; ?>
										</option>

									<?php
									}
									?>
								</optgroup>
								<optgroup label="BAGIAN">
									<?php
									foreach ($position as $key => $p) {
									?>

										<option value="P_<?php echo $p['id_position']; ?>">
											<?php echo $p['position']; ?>
										</option>

									<?php
									}
									?>
								</optgroup>
							</select>
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							For
						</div>
						<div class="col-sm-3 col-lg-3">
							<input type="text" name="untuk" id="untuk" value="" class="form-control square" required="required">
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
						<div class="col-sm-2 col-lg-2">
							Item
						</div>
						<div class="col-sm-3 col-lg-3">
							<select id="item" name="item" class="choices form-select square bg-white" required="required">
								<option value="">Select</option>
								<?php
								foreach ($item as $key => $i) {
								?>
									<option value="<?php echo $i['id_item']; ?>">
										<?php echo $i['item']; ?>
									</option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="col-sm-1 col-lg-1" align="right">
							Qty
						</div>
						<div class="col-sm-1 col-lg-1">
							<input type="number" name="qty" id="qty" min="1" class="form-control square" required="required">
						</div>
					</div>

					<div class="space_line row">
						<div class="col-lg-12">
							<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
						</div>
					</div>
				</form>

				<table class="table mb-0">
					<thead>
						<tr>
							<td width="50px" align="center">No</td>
							<td width="250px">Item</td>
							<td>Total</td>
							<td width="150px" align="center">Aksi</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="6">Data not found!</td>
						</tr>
					</tbody>
				</table>
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