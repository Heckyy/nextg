<?php
	class view_house_size{
		
		function data_view($db,$e,$code){

			$view=base64_decode($code);
			$view_house_size=$db->select('tb_house_size','code_house_size="'.$view.'"','id_house_size','DESC');

			if(mysqli_num_rows($view_house_size)>0 && $_SESSION['house_size']==1){
				$v=mysqli_fetch_assoc($view_house_size);
?>
				<script src="<?php echo $e; ?>/src/house_size/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								House Size
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
								<input type="text" name="code_house_size" id="code_house_size" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								House Size
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="house_size" id="house_size" class="form-control square" value="<?php echo $v['house_size']; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								IPL/m2
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="amount" id="amount" class="form-control square" value="<?php echo number_format($v['amount_meter'],2,',','.'); ?>" required="required" disabled="disabled">
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
									if($_SESSION['house_size_new']==1){
								?>
										<a href="<?php echo $e; ?>/house-size/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
								<?php
									}
									if($_SESSION['house_size_edit']==1){
								?>
										<a href="<?php echo $e; ?>/house-size/edit/<?php echo $code; ?>">
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
					document.location.href=localStorage.getItem('data_link')+"/house-size";
				</script>
<?php
			}
		}

	}
?>