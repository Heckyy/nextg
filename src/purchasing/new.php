<?php
	class new_purchasing{
		
		function new_view($db,$e,$library_class,$code){

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

				if(!empty($code)){
					$ambil_code=$db->select('tb_request','number_request="'.$ubah.'"','id_request','ASC');
					$v=mysqli_fetch_assoc($ambil_code);
				}
?>
				<script src="<?php echo $e; ?>/src/purchasing/js/js_proses.js"></script>
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
								<input type="text" name="tanggal" id="tanggal" value="<?php echo $ubah; ?>" class="form-control square" required="required" disabled="disabled">
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
								Request By
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="permintaan" name="permintaan" class="form-control square bg-white" onchange="nomor_permintaan()" disabled="disabled">
									<option value="">Select</option>
							       		<?php
							             	foreach ($permintaan as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_request']; ?>" <?php if($p['number_request']==$ubah){ echo "selected"; } ?>>
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
								Type of Purchase
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_purchase" name="type_of_purchase" class="form-control square bg-white" disabled="disabled">
									<option value="1" <?php if(!empty($code)){ if($v['type_of_request']=='1'){ echo "selected"; }}; ?>>PURCHASE</option>
									<option value="2" <?php if(!empty($code)){ if($v['type_of_request']=='2'){ echo "selected"; }}; ?>>SERVICE</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
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
								<select id="employee" name="employee" class="form-control square" disabled="disabled">
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

						<table class="table mb-0">
							<thead>
								<tr>
									<td width="50px" align="center">No</td>
									<td>Item</td>
									<td width="200px">Harga</td>
									<td width="100px" align="center">Qty Request</td>
									<td width="250px">Qty</td>
									<td width="200px">Total</td>
								</tr>
							</thead>
							<tbody id="detail">
								<tr><td colspan="6">Data not found!</td></tr>
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
					document.location.href=localStorage.getItem('data_link')+"/error-page";
				</script>
<?php
			}
		}

	}
?>