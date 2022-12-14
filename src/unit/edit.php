<?php
	class edit_unit{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_unit=$db->select('tb_unit','code_unit="'.$view.'"','id_unit','DESC');

			if(mysqli_num_rows($view_unit)>0 && $_SESSION['unit_edit']==1){
				$v=mysqli_fetch_assoc($view_unit);
?>
				<script src="<?php echo $e; ?>/src/unit/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Jabatan
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
								<input type="text" name="code_unit" id="code_unit" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Jabatan
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="unit" id="unit" class="form-control square" value="<?php echo $v['unit']; ?>" required="required">
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
					document.location.href=localStorage.getItem('data_link')+"/unit";
				</script>
<?php
			}
		}

	}
?>