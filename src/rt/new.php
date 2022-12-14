<?php
	class new_rt{
		
		function new_view($db,$e){

			if($_SESSION['rt_new']==1){

				$population1=$db->select('tb_population','type="0"','name','ASC');
				$population2=$db->select('tb_population','type="0"','name','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
?>
				<script src="<?php echo $e; ?>/src/rt/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								RT
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
								<input type="text" name="code_rt" id="code_rt" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-5 col-lg-5">
								<select id="cluster" name="cluster" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($cluster as $key => $c) {
									?>
											<option value="<?php echo $c['id_cluster']; ?>"><?php echo $c['code_cluster'].' - '.$c['cluster']; ?></option>
									<?php
										}
									?>
								</select>						
							</div>
						</div>

						<div class="space_line row">
							<div class="col-sm-2 col-lg-2 p-3"></div>
						</div>
						
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								RT
							</div>
							<div class="col-sm-2 col-lg-1">
								<input type="text" name="rt" id="rt" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Kepala RT
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="ketua_rt" id="ketua_rt" class="form-control square">
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

						<div class="space_line row">
							<div class="col-sm-2 col-lg-2 p-3"></div>
						</div>

						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Wakil RT
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="wakil_rt" id="wakil_rt" class="form-control square">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_wakil" id="address_wakil" class="form-control square textarea-edit"></textarea>
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