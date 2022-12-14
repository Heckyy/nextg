<?php
	class view_warehouse{
		
		function data_view($db,$e,$code){

			$view=base64_decode($code);
			$view_warehouse=$db->select('tb_warehouse','code_warehouse="'.$view.'"','id_warehouse','DESC');

			if(mysqli_num_rows($view_warehouse)>0 && $_SESSION['warehouse']==1){
				$v=mysqli_fetch_assoc($view_warehouse);
?>
				<script src="<?php echo $e; ?>/src/warehouse/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Warehouse
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
								<input type="text" name="code_warehouse" id="code_warehouse" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Warehouse
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="warehouse" id="warehouse" class="form-control square" value="<?php echo $v['warehouse']; ?>" required="required" disabled>
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
									if($_SESSION['warehouse_new']==1){
								?>
										<a href="<?php echo $e; ?>/warehouse/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
								<?php
									}
									if($_SESSION['warehouse_edit']==1){
								?>
										<a href="<?php echo $e; ?>/warehouse/edit/<?php echo $code; ?>">
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
					document.location.href=localStorage.getItem('data_link')+"/warehouse";
				</script>
<?php
			}
		}

	}
?>