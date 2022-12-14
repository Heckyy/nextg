<?php
	class new_coordinator{
		
		function new_view($db,$e){

			if($_SESSION['coordinator_new']==1){

				$contractor=$db->select('tb_contractor','id_contractor','contractor','DESC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');

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
					<form method="POST" id="new">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_coordinator" id="code_coordinator" class="form-control square" required="required">
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

						                    <option value="<?php echo $ep['id_employee']; ?>">
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
								<select id="contractor" name="contractor" class="form-control square bg-white" required="required">
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
								<textarea  name="note" id="note" class="form-control square textarea-edit"></textarea>
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
								<td width="250px">Kode Kontraktor</td>
								<td>Kontraktor</td>
								<td>Tipe Pekerjaan</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
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