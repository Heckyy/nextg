<?php
	class new_cluster{
		
		function new_view($db,$e){

			if($_SESSION['cluster_new']==1){
				
				$rt=$db->select('tb_rt','id_rt','number','ASC');
?>
				<script src="<?php echo $e; ?>/src/cluster/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Cluster
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
								<input type="text" name="code_cluster" id="code_cluster" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="cluster" id="cluster" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Harga Per Meter
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="the_land_price" id="the_land_price" class="form-control square" placeholder="Tanah" style="text-align:right" required="required">
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="building_price" id="building_price" class="form-control square" placeholder="Bangunan" style="text-align:right" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2"></div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="macro_price" id="macro_price" class="form-control square" placeholder="Makro" style="text-align:right" required="required">
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="empty_land" id="empty_land" class="form-control square" placeholder="Tanah Kosong" style="text-align:right" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address" id="address" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row none">
							<div class="col-sm-2 col-lg-2">
								Area
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="area" id="area" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
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