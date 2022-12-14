<?php
	class view_request{
		
		function data_view($db,$e,$library_class,$code){

			$view=base64_decode($code);
			$view_request=$db->select('tb_request','number_request="'.$view.'"','id_request','DESC');

			if(mysqli_num_rows($view_request)>0 && $_SESSION['request']==1){
				$v=mysqli_fetch_assoc($view_request);

				$permintaan=$db->select('tb_request','id_request="'.$v['id_request'].'" && status="1" && status_purchasing="0"','id_request','ASC');
				$jum_permintaan=mysqli_num_rows($permintaan);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_request_detail INNER JOIN tb_item ON tb_request_detail.id_item=tb_item.id_item','tb_request_detail.number_request="'.$v['number_request'].'"','tb_request_detail.id_request_detail','DESC','tb_request_detail.id_request_detail,tb_request_detail.qty,tb_request_detail.unit,tb_request_detail.note,tb_item.item');

				$inputan=$tahun.'-'.$bulan;
				$sekarang=$library_class->tahun().'-'.$library_class->bulan();

				$_SESSION['number_request']=$v['number_request'];


				$item=$db->select('tb_item','id_item','item','ASC');

				$type_of_item=$db->select('tb_type_of_item','id_type_of_item','type_of_item','ASC');
				
				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');

				$purchasing_cek=$db->select('tb_purchasing','number_request="'.$v['number_request'].'" && status="1"','id_purchasing','ASC');
				$jum_purchasing=mysqli_num_rows($purchasing_cek);

				if($v['status']==1){
					$status=" - Finish";
				}else if($v['status']==2){
					$status=" - Cancel";
				}else{
					$status="";
				}
?>
				<script src="<?php echo $e; ?>/src/request/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Request <b><?php echo $status; ?></b>
							</h6>
						</div>
						<?php 
							if($v['status']==0){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-info" onclick="process_transaction()">
										Approved
									</button>
								</div>
						<?php
							}else if($v['status']==1){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-primary" onclick="print_transaction('<?php echo $acak; ?>')">
										Print
									</button>
								</div>
						<?php
							}else if($v['status']==3){
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
								Type of Request
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_request" name="type_of_request" class="form-control square" disabled="disabled">
									<option value="1" <?php if($v['type_of_request']=='1'){ echo "selected"; }; ?>>PURCHASE</option>
									<option value="2" <?php if($v['type_of_request']=='2'){ echo "selected"; }; ?>>SERVICE</option>
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
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
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
								Request By
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="employee" name="employee" class="form-control square" disabled="disabled">
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
								<textarea  name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Item
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="item" name="item" class="choices form-select square bg-white" required="required" disabled="disabled">
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
								<input type="number" name="qty" id="qty" class="form-control square" required="required" disabled="disabled">
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="unit" id="unit" value="Pcs" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Request Information
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="keterangan" id="keterangan" class="form-control square textarea-edit" disabled="disabled"></textarea>
							</div>
						</div>

							<div class="space_line row">
								<div class="col-lg-12">
									<?php
										if($v['status']=='1' && $_SESSION['purchasing_new']==1 && $jum_permintaan>0){
									?>
											<a href="<?php echo $e; ?>/purchasing/new/<?php echo $code; ?>">
												<button type="button" class="btn btn-sm btn-info btn-custom">Purchase</button>
											</a>
									<?php
										}
										if($_SESSION['request_new']==1){
									?>
										<a href="<?php echo $e; ?>/request/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
									<?php
										}
										if($v['status']=='0' && $_SESSION['request_edit']==1){
									?>
											<a href="<?php echo $e; ?>/request/edit/<?php echo $code; ?>">
												<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
											</a>
									<?php
										}
										if($inputan==$sekarang && $v['status']!=='2' && $_SESSION['request_cancel']==1){
											if($jum_purchasing==0){
									?>
											<a href="#" onclick="cancel()">
												<button type="button" class="btn btn-sm btn-danger btn-custom">Cancel</button>
											</a>
									<?php
											}
										}
									?>
								</div>
							</div>

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
											<?php echo $d['qty'].' '.$d['unit']; ?>
										</td>
										<td>
											<?php echo $d['note']; ?>
										</td>
										<td align="center"></td>
									</tr>
							<?php
									$no++;
								}
							?>
						</tbody>
					</table>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/request";
				</script>
<?php
			}
		}

	}
?>