<?php
	class edit_type_of_account{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_account=$db->select('tb_group_account INNER JOIN tb_type_of_account ON tb_group_account.id_group_account=tb_type_of_account.id_group_account','tb_type_of_account.id_type_of_account="'.$view.'"','tb_type_of_account.type_of_account','ASC');

			if(mysqli_num_rows($view_account)>0 && $_SESSION['account_edit']==1){
				$v=mysqli_fetch_assoc($view_account);

				$_SESSION['type_of_account']=$v['id_type_of_account'];
?>
				<script src="<?php echo $e; ?>/src/type_of_account/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Tipe Akun
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Kelompok Akun
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="group_account" id="group_account" class="form-control square" value="<?php echo $v['group_account']; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Posisi
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="position" id="position" class="form-control square" value="<?php echo $v['position']; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Laporan
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="type_of_report" id="type_of_report" class="form-control square" value="<?php echo $v['type_of_report']; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Akun
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="type_of_account" id="type_of_account" class="form-control square" value="<?php echo $v['type_of_account']; ?>" required="required">
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
					document.location.href=localStorage.getItem('data_link')+"/account/type-of-account";
				</script>
<?php
			}
		}

	}
?>