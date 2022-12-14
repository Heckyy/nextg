<?php
	class edit_po_maintenance{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_po_maintenance=$db->select('tb_purchasing','type_of_purchase="2" && number_purchasing="'.$view.'" && status="0"','id_purchasing','DESC');

			if(mysqli_num_rows($view_po_maintenance)>0 && $_SESSION['po_maintenance_edit']==1){
				$v=mysqli_fetch_assoc($view_po_maintenance);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_request_detail','number_request="'.$v['number_request'].'"','id_request_detail','DESC');

				$_SESSION['number_purchasing']=$v['number_purchasing'];

				$permintaan=$db->select('tb_request','type_of_request="2" && status_purchasing="0"','id_request','ASC');

				$position=$db->select('tb_position','id_position="'.$v['id_position'].'"','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee="'.$v['id_population'].'"','name','ASC');

?>
				<script src="<?php echo $e; ?>/src/po_maintenance/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								PO Maintenance
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
								Pemasok
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="supplier" id="supplier" class="form-control square" value="<?php echo $v['supplier']; ?>" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Permintaan
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
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square" disabled="disabled">
									<option value="">Select</option>
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>" selected>
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
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
									<option value="">Select</option>
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_position']; ?>" selected>
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
								Pengurus
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="employee" name="employee" class="form-control square" disabled="disabled">
									<option value="">Select</option>
						       			<?php
							             	foreach ($employee as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_employee']; ?>" selected>
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


					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Item</td>
								<td width="200px">Price</td>
								<td width="100px">Qty Request</td>
								<td width="250px">Qty</td>
								<td width="200px">Total</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $dr) {

									$acak=str_replace("=", "", base64_encode($dr['id_request_detail']));

									$detail_po=$db->select('tb_purchasing_detail','number_purchasing="'.$v['number_purchasing'].'" && id_item="'.$dr['id_item'].'"','id_purchasing_detail','DESC','id_purchasing_detail,qty,amount,id_item');
									if(!empty(mysqli_num_rows($detail_po))){
										$d=mysqli_fetch_assoc($detail_po);

										$total=$d['amount']*$d['qty'];
							?>
										<tr>
											<td align="center">
												<?php echo $no; ?>.
											</td>
											<td>
												<?php echo $dr['item']; ?>
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
												<input type="text" name="amount<?php echo $acak; ?>" id="amount<?php echo $acak; ?>" class="form-control" style="width:150px;" onchange="hitung('<?php echo $acak; ?>')" value="<?php echo $d['amount']; ?>">
											</td>
											<td><?php echo $dr['qty']; ?></td>
											<td>
												<input type="number" min="0" name="qty<?php echo $acak; ?>" id="qty<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo $d['qty']; ?>" onchange="hitung('<?php echo $acak; ?>')">
											</td>
											<td>
												<input type="text" name="total<?php echo $acak; ?>" id="total<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo number_format($total,2,',','.'); ?>" disabled="disabled">
											</td>
										</tr>
							<?php
										$no++;
									}
								}
							?>
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
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/po-maintenance";
				</script>
<?php
			}
		}

	}
?>