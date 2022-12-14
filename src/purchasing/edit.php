<?php
	class edit_purchasing{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_purchasing=$db->select('tb_purchasing','number_purchasing="'.$view.'" && status="0"','id_purchasing','DESC');

			if(mysqli_num_rows($view_purchasing)>0 && $_SESSION['purchasing_edit']==1){
				$v=mysqli_fetch_assoc($view_purchasing);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$_SESSION['number_purchasing']=$v['number_purchasing'];

				$permintaan=$db->select('tb_request','status_purchasing="0"','id_request','ASC');

				$type_of_item=$db->select('tb_type_of_item','id_type_of_item','type_of_item','ASC');

				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');

?>
				 <?php 
				 	if(empty($_GET['manual'])){
				 ?>
						<script src="<?php echo $e; ?>/src/purchasing/js/js_proses.js"></script>
				<?php
					}else{
				?>	
						<script src="<?php echo $e; ?>/src/purchasing/js/js_proses_manual.js"></script>
				<?php
					}
				?>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Purchasing
							</h6>
						</div>
						<?php 
							if($v['status']==0){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-info" onclick="process_transaction()">
										Process
									</button>
								</div>
						<?php
							}
						?>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number_purchasing']; ?>" required="required" disabled="disabled">
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
								Supplier
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="supplier" id="supplier" class="form-control square" value="<?php echo $v['supplier']; ?>" required="required" disabled="disabled">
							</div>
						</div>
						<?php 
							if(empty($_GET['manual'])){
						?>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Number Request
									</div>
									<div class="col-sm-2 col-lg-3">
										<select id="permintaan" name="permintaan" class="form-control square" onchange="nomor_permintaan()" disabled="disabled">
											<option value="">Select</option>
									       		<?php
									             	foreach ($permintaan as $key => $p) {
									       		?>

									                    <option value="<?php echo $p['id_request']; ?>" <?php if($p['number_request']==$v['number_request']){ echo "selected"; } ?>>
									                    	<?php echo $p['number_request'].' - ('.$p['code_cluster'].' - '.$p['cluster'].' - '.$p['position'].')'; ?>
									                    </option>

									           <?php
									           		}
									       		?>
								       </select>
									</div>
								</div>
						<?php
							}
						?>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Type of Purchase
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_purchase" name="type_of_purchase" class="form-control square bg-white" disabled="disabled">
									<option value="1" <?php if(!empty($code)){ if($v['type_of_purchase']=='1'){ echo "selected"; }}; ?>>PURCHASE</option>
									<option value="2" <?php if(!empty($code)){ if($v['type_of_purchase']=='2'){ echo "selected"; }}; ?>>SERVICE</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
									<option value="">Select</option>
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_position']; ?>" <?php if($p['id_position']==$v['id_position']){ echo 'selected'; }?>>
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
								<select id="cluster" name="cluster" class="form-control square" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
									<option value="">Select</option>
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>" <?php if($tr['id_cluster']==$v['id_cluster']){ echo 'selected'; }?>>
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
								<select id="employee" name="employee" class="form-control square" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
									<option value="">Select</option>
						       			<?php
							             	foreach ($employee as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_employee']; ?>" <?php if($p['id_employee']==$v['id_population']){ echo 'selected'; }?>>
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
								<textarea  name="note" id="note" class="form-control square textarea-edit"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Item <?php if(!empty($_GET['manual'])){ ?><a href="#" data-bs-toggle="modal" data-bs-target="#tambah_barang"><i class="bi bi-plus-circle"></i></a> <?php } ?>
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="item" name="item" class="form-control square" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
									<option value="">Select</option>
						       </select>
							</div>
							<div class="col-sm-1 col-lg-1">
								Qty
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="qty" id="qty" class="form-control square" required="required" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="unit" id="unit" value="Pcs" class="form-control square" required="required" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Price
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" <?php if(empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
							</div>
						</div>

					<?php
						if(!empty($_GET['manual'])){
					?>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					<?php
						}
					?>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Item</td>
								<td width="200px">Price</td>
								<?php 
									if(empty($_GET['manual'])){
								?>
										<td width="100px" align="center">Qty Request</td>
								<?php
									}
								?>
								<td width="250px">Qty</td>
								<td width="200px">Total</td>
								<?php 
									if(!empty($_GET['manual'])){ 
								?>
									<td width="30px" align="center">Action</td>
								<?php
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;

									$detail_po=$db->select('tb_purchasing_detail','number_purchasing="'.$v['number_purchasing'].'"','id_purchasing_detail','DESC','id_purchasing_detail,qty,unit,amount,id_item,item');
									if(!empty(mysqli_num_rows($detail_po))){
										foreach ($detail_po as $key => $d) {

										$acak=str_replace("=", "", base64_encode($d['id_purchasing_detail']));

										$total=$d['amount']*$d['qty'];
							?>
										<tr>
											<td align="center">
												<?php echo $no; ?>.
											</td>
											<td>
												<?php echo $d['item']; ?>
											</td>
											<td>
												<script type="text/javascript">
													$(document).ready(function() {
														var amount<?php echo $acak; ?> = document.getElementById("amount<?php echo $acak; ?>"); 

													    amount<?php echo $acak; ?>.addEventListener("keyup", function(e) { 
													        amount<?php echo $acak; ?>.value = convertRupiah(this.value); 
													    }); 

													    amount<?php echo $acak; ?>.addEventListener('keydown', function(event) { 
													        return isNumberKey(event); 
													    });
												    });
												</script>
												<input type="text" name="amount<?php echo $acak; ?>" id="amount<?php echo $acak; ?>" class="form-control" style="width:150px;" onchange="hitung('<?php echo $acak; ?>')" value="<?php echo $d['amount']; ?>" <?php if(!empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
											</td>
											<?php
												if(empty($_GET['manual'])){
											?>
													<td><?php echo $d['qty'].' '.$d['unit']; ?></td>
											<?php
												}
											?>
											<td>
												<input type="number" min="0" name="qty<?php echo $acak; ?>" id="qty<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo $d['qty']; ?>" onchange="hitung('<?php echo $acak; ?>')" <?php if(!empty($_GET['manual'])){ echo 'disabled="disabled"'; } ?>>
											</td>
											<td>
												<input type="text" name="total<?php echo $acak; ?>" id="total<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo number_format($total,2,',','.'); ?>" disabled="disabled">
											</td>
											<?php 
												if(!empty($_GET['manual'])){ 
											?>
													<td align="center">
														<a href="#" onclick="hapus('<?php echo $acak; ?>')">
															<i class="bi bi-trash"></i>
														</a>
													</td>
											<?php
												}
											?>
										</tr>
							<?php
										$no++;
										}
									}
							?>
						</tbody>
					</table>
					<?php
						if(empty($_GET['manual'])){
					?>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					<?php
						}
					?>
					</form>
				</div>



			<?php 
				if(!empty($_GET['manual'])){
			?>
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
				}
			?>


<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/purchasing";
				</script>
<?php
			}
		}

	}
?>