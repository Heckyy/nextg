<?php
	class new_purchasing_manual{
		
		function new_manual_view($db,$e,$library_class,$code){

			if($_SESSION['purchasing_new']==1){
								
				$ubah=base64_decode($code);

				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();

				$date 		= $tanggal.'-'.$bulan.'-'.$tahun;

				$permintaan=$db->select('tb_request','status="1" && status_purchasing="0"','id_request','ASC');

				

				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');
				$item=$db->select('tb_item','id_item','item','ASC');
				$type_of_item=$db->select('tb_type_of_item','id_type_of_item','type_of_item','ASC');

				if(!empty($code)){
					$ambil_code=$db->select('tb_request','number_request="'.$ubah.'"','id_request','ASC');
					$v=mysqli_fetch_assoc($ambil_code);
				}
?>
				<script src="<?php echo $e; ?>/src/purchasing/js/js_proses_manual.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Purchasing
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
								Supplier
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="supplier" id="supplier" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Type of Purchase
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_purchase" name="type_of_purchase" class="form-control square bg-white" onchange="ubah_type_item();">
									<option value="1">PURCHASE</option>
									<option value="2">SERVICE</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square">
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
								<select id="cluster" name="cluster" class="form-control square">
									<option value="">Select</option>
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>">
							                    	<?php echo $tr['code_cluster'].' - '.$tr['cluster']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       </select>
							</div>
						</div>
						
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Request By
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="employee" name="employee" class="form-control square">
									<option value="">Select</option>
						       			<?php
							             	foreach ($employee as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_employee']; ?>">
							                    	<?php echo $p['name']; ?>
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
								<textarea  name="note" id="note" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Item <a href="#" data-bs-toggle="modal" data-bs-target="#tambah_barang"><i class="bi bi-plus-circle"></i></a>
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="item" name="item" class="form-control square">
									<option value="">Select</option>
						       			<?php
							             	foreach ($item as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_item']; ?>">
							                    	<?php echo $p['item']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       </select>
							</div>
							<div class="col-sm-1 col-lg-1">
								Qty
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="qty" id="qty" class="form-control square" required="required">
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="unit" id="unit" value="Pcs" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Price
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
						<table class="table mb-0">
							<thead>
								<tr>
									<td width="50px" align="center">No</td>
									<td>Item</td>
									<td width="200px">Price</td>
									<td width="100px" align="center">Qty Request</td>
									<td width="250px">Qty</td>
									<td width="200px">Total</td>
								</tr>
							</thead>
							<tbody id="detail">
								<tr><td colspan="6">Data not found!</td></tr>
							</tbody>
						</table>

					</form>
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
							<div class="space_line row">
								<div class="col-sm-6 col-lg-6">
									Type of Item
								</div>
								<div class="col-sm-6 col-lg-6">
									<select id="type_of_item" name="type_of_item" class="form-control square bg-white" required="required">
										<option value="">Select</option>
										<?php
											foreach ($type_of_item as $key => $t) {
										?>
												<option value="<?php echo $t['id_type_of_item']; ?>"><?php echo $t['type_of_item']; ?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
				      </div>
				      <div class="modal-footer">
				        <button type="submit" id="btn_item" class="btn btn-primary">Save</button>
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				      </div>
					</form>
				    </div>
				  </div>
				</div>

<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/error-page";
				</script>
<?php
			}
		}

	}
?>