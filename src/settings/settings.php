<?php
	class settings_system{
		function view_settings($db,$e){

			if($_SESSION['settings']==1){
				$setting=$db->select('tb_settings','id_settings','id_settings','DESC');
				$s=mysqli_fetch_assoc($setting);
?>
				<script src="<?php echo $e; ?>/assets/vendors/tinymce/tinymce.min.js"></script>
				<script src="<?php echo $e; ?>/src/settings/js/js_proses.js"></script>

				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Settings
							</h6>
						</div>
					</div>
				</div>
				<div class="app-card-body pb-3 main-content container-fluid">
					<form id="edit" method="POST">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Title
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="title_print" id="title_print" value="<?php echo $s['title_print']; ?>" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Title 2
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="title_print2" id="title_print2" value="<?php echo $s['title_print2']; ?>" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Address
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea name="address" id="address" class="form-control square textarea-edit"><?php echo $s['alamat']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-12 col-lg-12">
								Payment Method
							</div>
							<div class="col-sm-12 col-lg-12">
								<textarea name="payment_method" id="payment_method" class="form-control square textarea-edit"><?php echo $s['cara_pembayaran']; ?></textarea>
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
					document.location.href=localStorage.getItem('data_link')+"/error-page";
				</script>
<?php
			}
		}

	}
?>