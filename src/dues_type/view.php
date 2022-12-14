<?php
	class view_dues_type{
		
		function data_view($db,$e,$code){

			$view=base64_decode($code);
			$view_dues=$db->select('tb_dues','code_dues="'.$view.'"','id_dues','DESC');

			if(mysqli_num_rows($view_dues)>0 && $_SESSION['dues_type']==1){
				$v=mysqli_fetch_assoc($view_dues);
	
?>
				<script src="<?php echo $e; ?>/src/dues_type/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Tipe Dana Hiba
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_dues" id="code_dues" class="form-control square" required="required" value="<?php echo $view; ?>" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Dana Hiba
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="dues_type" id="dues_type" class="form-control square" required="required" value="<?php echo $v['dues_type']; ?>" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit" disabled><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<?php
									if($_SESSION['dues_type_new']==1){
								?>
										<a href="<?php echo $e; ?>/dues-type/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
								<?php
									}
									if($_SESSION['dues_type_edit']==1){
								?>
										<a href="<?php echo $e; ?>/dues-type/edit/<?php echo $code; ?>">
											<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
										</a>
								<?php
									}
								?>
							</div>
						</div>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/dues-type";
				</script>
<?php
			}
		}

	}
?>