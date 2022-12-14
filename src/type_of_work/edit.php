<?php
	class edit_type_of_work{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_type_of_work=$db->select('tb_type_of_work','code_type_of_work="'.$view.'"','id_type_of_work','DESC');

			if(mysqli_num_rows($view_type_of_work)>0 && $_SESSION['type_of_work_edit']==1){
				$v=mysqli_fetch_assoc($view_type_of_work);
?>
				<script src="<?php echo $e; ?>/src/type_of_work/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Tipe Pekerjaan
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
								<input type="text" name="code_type_of_work" id="code_type_of_work" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Pekerjaan
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="type_of_work" id="type_of_work" class="form-control square" value="<?php echo $v['type_of_work']; ?>" required="required">
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
					document.location.href=localStorage.getItem('data_link')+"/type_of_work";
				</script>
<?php
			}
		}

	}
?>