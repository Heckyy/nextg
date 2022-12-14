<?php
	class edit_rw{
		function edit_view($db,$e){

			if($_SESSION['rw_edit']==1){
				$rw=$db->select('tb_rw','id_rw','id_rw','ASC');
				$v=mysqli_fetch_assoc($rw);
?>

				<script src="<?php echo $e; ?>/src/rw/js/js_proses.js"></script>

				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Posisi Pengurus
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<h6><b>Komisaris / Kepala RW</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Komisaris / Kepala RW
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="ketua_rw" id="ketua_rw" value="<?php echo $v['ketua_rw']; ?>" class="form-control">			
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address" id="address" class="form-control square textarea-edit"><?php echo $v['address']; ?></textarea>
							</div>
						</div>

						<div class="space_line row">
							<h6><b>Wakil Komisaris / Wakil RW</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Wakil Komisaris / Wakil RW
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="wakil_rw" id="wakil_rw" value="<?php echo $v['wakil_rw']; ?>" class="form-control">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_representative" id="address_representative" class="form-control square textarea-edit"><?php echo $v['address_representative']; ?></textarea>
							</div>
						</div>

						<div class="space_line row">
							<h6><b>Keuangan</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Keuangan
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="treasurer" id="treasurer" value="<?php echo $v['treasurer']; ?>" class="form-control">		
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_treasurer" id="address_treasurer" class="form-control square textarea-edit"><?php echo $v['address_treasurer']; ?></textarea>
							</div>
						</div>

						<div class="space_line row">
							<h6><b>Pemantau Keuangan</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Pemantau Keuangan
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="finance_monitoring" id="finance_monitoring" value="<?php echo $v['finance_monitoring']; ?>" class="form-control">			
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_finance_monitoring" id="address_finance_monitoring" class="form-control square textarea-edit"><?php echo $v['address_finance_monitoring']; ?></textarea>
							</div>
						</div>


						<div class="space_line row">
							<h6><b>Estate Manager</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Estate Manager
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="estate_manager" id="estate_manager" value="<?php echo $v['estate_manager']; ?>" class="form-control">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_estate_manager" id="address_estate_manager" class="form-control square textarea-edit"><?php echo $v['address_estate_manager']; ?></textarea>
							</div>
						</div>

						<div class="space_line row">
							<h6><b>Pembelian</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Pembelian
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="purchasing" id="purchasing" value="<?php echo $v['purchasing']; ?>" class="form-control">		
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_purchasing" id="address_purchasing" class="form-control square textarea-edit"><?php echo $v['address_purchasing']; ?></textarea>
							</div>
						</div>

						<div class="space_line row">
							<h6><b>Adm / Akutansi</b></h6>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Adm / Akutansi
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="admin" id="admin" value="<?php echo $v['admin']; ?>" class="form-control">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_admin" id="address_admin" class="form-control square textarea-edit"><?php echo $v['address_admin']; ?></textarea>
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