<?php
	class edit_cluster{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_cluster=$db->select('tb_cluster','code_cluster="'.$view.'"','id_cluster','DESC');

			if(mysqli_num_rows($view_cluster)>0 && $_SESSION['cluster_edit']==1){
				$v=mysqli_fetch_assoc($view_cluster);

					$the_land_price=0;
					$building_price=0;
					$macro_price=0;
					$empty_land=0;
					
					if($v['the_land_price']>0){
						$the_land_price=$v['the_land_price'];
					}
					if($v['building_price']>0){
						$building_price=$v['building_price'];
					}
					if($v['macro_price']>0){
						$macro_price=$v['macro_price'];
					}
					if($v['empty_land']>0){
						$empty_land=$v['empty_land'];
					}
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
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_cluster" id="code_cluster" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="cluster" id="cluster" class="form-control square" value="<?php echo $v['cluster']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Harga Per Meter
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="the_land_price" id="the_land_price" class="form-control square" placeholder="Tanah" value="<?php echo number_format($the_land_price,2,',','.'); ?>" style="text-align:right" required="required">
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="building_price" id="building_price" class="form-control square" placeholder="Bangunan" value="<?php echo number_format($building_price,2,',','.'); ?>" style="text-align:right" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2"></div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="macro_price" id="macro_price" class="form-control square" placeholder="Makro" value="<?php echo number_format($macro_price,2,',','.'); ?>" style="text-align:right" required="required">
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="empty_land" id="empty_land" class="form-control square" placeholder="Tanah Kosong" value="<?php echo number_format($empty_land,2,',','.'); ?>" style="text-align:right" required="required">
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
						<div class="space_line row none">
							<div class="col-sm-2 col-lg-2">
								Area
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="area" id="area" class="form-control square textarea-edit"><?php echo $v['area']; ?></textarea>
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
					document.location.href=localStorage.getItem('data_link')+"/cluster";
				</script>
<?php
			}
		}

	}
?>