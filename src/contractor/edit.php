<?php
	class edit_contractor{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_contractor=$db->select('tb_contractor','code_contractor="'.$view.'"','id_contractor','DESC');

			if(mysqli_num_rows($view_contractor)>0 && $_SESSION['contractor_edit']==1){
				$v=mysqli_fetch_assoc($view_contractor);

				$type_of_work=$db->select('tb_type_of_work','id_type_of_work','type_of_work','DESC');
?>
				<script src="<?php echo $e; ?>/src/contractor/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Kontraktor
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
								<input type="text" name="code_contractor" id="code_contractor" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Kontraktor
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="contractor" id="contractor" class="form-control square" value="<?php echo $v['contractor']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Pekerjaan
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="type_of_work" name="type_of_work" class="form-control square bg-white" required="required">
									<option value="">Select</option>
						       		<?php
						             	foreach ($type_of_work as $key => $tr) {
						       		?>

						                    <option value="<?php echo $tr['id_type_of_work']; ?>" <?php if($v['id_type_of_work']==$tr['id_type_of_work']){ echo "selected"; } ?> >
						                    	<?php echo $tr['type_of_work']; ?>
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
					document.location.href=localStorage.getItem('data_link')+"/contractor";
				</script>
<?php
			}
		}

	}
?>