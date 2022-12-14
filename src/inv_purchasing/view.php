<?php
class view_inv_purchasing
{

	function data_view_inv_purchasing($db, $e, $library_class, $code)
	{
		// Get Data From Database
		$view = base64_decode($code);
		$view_inv_purchasing = $db->select('tb_inv_purchasing', 'number_inv_purchasing="' . $view . '"', 'number_inv_purchasing', 'DESC');
		$jumlahData = mysqli_num_rows($view_inv_purchasing);
		$data = mysqli_fetch_assoc($view_inv_purchasing);
		$bmb = $data['number_item_receipt_out'];
		$cekPo = $db->select('tb_item_receipt_out', 'number_item_receipt_out="' . $bmb . '"', 'number_item_receipt_out', 'DESC');
		$resultPo = mysqli_fetch_assoc($cekPo);
		$po = $resultPo['number_purchasing'];
		$query = "SELECT ir.number_item_receipt_out, ir.item, ir.qty, pd.amount,pd.id_purchasing_detail FROM tb_item_receipt_out_detail AS ir LEFT JOIN tb_purchasing_detail AS pd ON pd.number_purchasing = ir.number_purchasing AND ir.qty = pd.qty AND ir.item = pd.item WHERE ir.number_item_receipt_out ='" . $bmb . "' ";
		$cek1 = $db->selectDo($query);


		if ($_SESSION['purchasing'] == 1 && $jumlahData > 0) {


			$tanggal 	= $library_class->tanggal();
			$bulan 		= $library_class->bulan();
			$tahun 		= $library_class->tahun();
			$date 		= $tahun . '-' . $bulan . '-' . $tanggal;
?>
			<script src="<?php echo $e; ?>/src/inv_purchasing/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Bills From Suppliers
						</h6>
					</div>
				</div>
			</div>


			<div class="app-card-body pb-3 main-content container-fluid">
				<form method="POST" id="new" action="proses.php">
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Number
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="number" id="number" class="form-control square" required="required" disabled="disabled" value=<?php echo $data['number_inv_purchasing']; ?>>
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Date
						</div>

						<div class="col-sm-2 col-lg-2">
							<input type="text" name="tanggal" id="tanggal" class="form-control square" required="required" disabled="disabled" value="<?php echo $data['tanggal'] ?>">
						</div>

					</div>

					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Supplier
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="supplier" id="supplier" class="form-control square" required="required" disabled="disabled" value="<?php echo $data['supplier'] ?>">
						</div>

					</div>

					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Purchase Order
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="po" id="po" class="form-control square" required="required" disabled="disabled" value="<?php echo $po; ?>">
						</div>
					</div>

					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Invoice
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="supplier" id="supplier" class="form-control square" required="required" disabled="disabled" value="<?php echo $data['invoice']; ?>">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Note
						</div>
						<div class="col-sm-5 col-lg-5">
							<textarea name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?= $data['note']; ?></textarea>
						</div>
					</div>

				</form>

				<table class="table mb-0">
					<thead>
						<tr>
							<td width="50px" align="center">No</td>
							<td width="250px">Item</td>
							<td width="200px">Qty</td>
							<td>Price</td>
							<td width="200px">Total</td>
							<td width="150px" align="center">Aksi</td>
						</tr>
					</thead>
					<tbody id="datalist">
						<?php $no = 1; ?>
						<?php while ($row = mysqli_fetch_assoc($cek1)) { ?>
							<tr>
								<td><?php echo $no ?></td>
								<td><?= $row['item'] ?></td>
								<td><?= $row['qty'] ?></td>
								<td><?= number_format($row['amount'], 2, ',', '.'); ?></td>
								<?php $total = $row['qty'] * $row['amount']; ?>
								<td><?= number_format($total, 2, ',', '.'); ?></td>
								<td></td>
							</tr>
						<?php $no++;
						} ?>
						<tr>
							<td colspan="6"><b>Grand Total : <?php echo number_format($data['total'], 2, ',', '.') ?></b></td>
						</tr>

					</tbody>
				</table>
			</div>



			<div class="modal fade" id="tambah_barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="POST" id="new_barang">
							<div class="modal-body">
								<div class="space_line row">
									<div class="col-sm-6 col-lg-6">
										Code
									</div>
									<div class="col-sm-6 col-lg-6">
										<input type="text" name="code_item" id="code_item" class="form-control square" required="required" disabled="disabled">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-6 col-lg-6">
										Item
									</div>
									<div class="col-sm-6 col-lg-6">
										<input type="text" name="barang" id="barang" class="form-control square" required="required">
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<button type="submit" id="btn_item" class="btn btn-primary" name="save">Save</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
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