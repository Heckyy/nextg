<?php
	class edit_maintenance{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_request=$db->select('tb_request','number_request="'.$view.'" && status="0" && type_of_request="2"','id_request','DESC');

			if(mysqli_num_rows($view_request)>0 && $_SESSION['maintenance_edit']==1){
				$v=mysqli_fetch_assoc($view_request);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_request_detail INNER JOIN tb_item ON tb_request_detail.id_item=tb_item.id_item','tb_request_detail.number_request="'.$v['number_request'].'"','tb_request_detail.id_request_detail','DESC','tb_request_detail.id_request_detail,tb_request_detail.qty,tb_request_detail.note,tb_item.item');

				$item=$db->select('tb_item','type_of_item="3"','item','ASC');

				$_SESSION['number_request']=$v['number_request'];

				$type_of_item=$db->select('tb_type_of_item','type_of_item="MAINTENANCE"','type_of_item','ASC');
				
				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');
?>
				<script src="<?php echo $e; ?>/src/maintenance/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Maintenance
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
								<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number_request']; ?>" required="required" disabled="disabled">
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
								Cluster
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square bg-white">
									<option value="">Select</option>
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>" <?php if($tr['id_cluster']==$v['id_cluster']){ echo "selected"; }; ?>>
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
								<select id="divisi" name="divisi" class="form-control square bg-white">
									<option value="">Select</option>
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_position']; ?>" <?php if($p['id_position']==$v['id_position']){ echo "selected"; }; ?>>
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
								<select id="employee" name="employee" class="form-control square bg-white">
									<option value="">Select</option>
						       			<?php
							             	foreach ($employee as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_employee']; ?>" <?php if($p['id_employee']==$v['id_employee']){ echo "selected"; }; ?>>
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
								Maintenance <a href="#" data-bs-toggle="modal" data-bs-target="#tambah_barang"><i class="bi bi-plus-circle"></i></a>
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
							<div class="col-sm-2 col-lg-2">
								Request Information
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="keterangan" id="keterangan" class="form-control square textarea-edit"></textarea>
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
								<td>Note</td>
								<td width="150px" align="center">Aksi</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $d) {

									$acak=str_replace("=", "", base64_encode($d['id_request_detail']));
							?>
									<tr>
										<td align="center">
											<?php echo $no; ?>.
										</td>
										<td>
											<?php echo $d['item']; ?>
										</td>
										<td>
											<?php echo $d['qty']; ?>
										</td>
										<td>
											<?php echo $d['note']; ?>
										</td>
										<td align="center">
											<a href="#" onclick="hapus('<?php echo $acak; ?>')">
												<i class="bi bi-trash"></i>
											</a>
										</td>
									</tr>
							<?php
									$no++;
								}
							?>
						</tbody>
					</table>
				</div>


				<div class="modal fade" id="tambah_barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Tambah Maintenance</h5>
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
									Maintenance
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
					document.location.href=localStorage.getItem('data_link')+"/maintenance/";
				</script>
<?php
			}
		}

	}
?>