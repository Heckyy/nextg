<?php
	class edit_coordinator{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_coordinator=$db->select('tb_coordinator','code_coordinator="'.$view.'"','id_coordinator','DESC');

			if(mysqli_num_rows($view_coordinator)>0 && $_SESSION['coordinator_edit']==1){
				$v=mysqli_fetch_assoc($view_coordinator);

				$contractor=$db->select('tb_contractor','id_contractor','contractor','DESC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');

				$detail=$db->select('tb_coordinator_detail INNER JOIN tb_contractor ON tb_coordinator_detail.id_contractor=tb_contractor.id_contractor','tb_coordinator_detail.code_coordinator="'.$v['code_coordinator'].'"','tb_coordinator_detail.id_coordinator_detail','DESC','tb_coordinator_detail.id_coordinator_detail,tb_coordinator_detail.code_coordinator,tb_contractor.code_contractor,tb_contractor.contractor,tb_contractor.type_of_work');


?>
				<script src="<?php echo $e; ?>/src/coordinator/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Koordinator
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_coordinator" id="code_coordinator" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Koordinator
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="coordinator" name="coordinator" class="form-control square bg-white" required="required">
									<option value="">Select</option>
						       		<?php
						             	foreach ($employee as $key => $ep) {
						       		?>

						                    <option value="<?php echo $ep['id_employee']; ?>" <?php if($ep['id_employee']==$v['id_employee']){ echo "selected"; } ?>>
						                    	<?php echo $ep['name']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Kontraktor
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="contractor" name="contractor" class="form-control square bg-white">
									<option value="">Select</option>
						       		<?php
						             	foreach ($contractor as $key => $tr) {
						       		?>

						                    <option value="<?php echo $tr['id_contractor']; ?>">
						                    	<?php echo $tr['contractor']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
						   </div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Catatan Starndar Kerja
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<?php
									if($_SESSION['coordinator_new']==1){
								?>		
										<a href="<?php echo $e; ?>/coordinator/new" class="btn btn-default btn-sm link-new btn-custom">
								           	New
										</a>	
								<?php
									}
								?>
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					</form>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td width="250px">Kode Kontraktor</td>
								<td>Kontraktor</td>
								<td>Tipe Pekerjaan</td>
								<td width="150px" align="center">Aksi</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $d) {

									$acak=str_replace("=", "", base64_encode($d['id_coordinator_detail']));
							?>
									<tr>
										<td align="center">
											<?php echo $no; ?>.
										</td>
										<td>
											<?php echo $d['code_contractor']; ?>
										</td>
										<td>
											<?php echo $d['contractor']; ?>
										</td>
										<td>
											<?php echo $d['type_of_work']; ?>
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
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/coordinator";
				</script>
<?php
			}
		}

	}
?>