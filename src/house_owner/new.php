<?php
	class new_house_owner{
		
		function new_view($db,$e){

			if($_SESSION['house_owner_new']==1){

				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$rt=$db->select('tb_rt','id_rt','number','ASC');
?>
				<script src="<?php echo $e; ?>/src/house_owner/js/js_proses.js"></script>

				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								House owner
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
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="code_population" id="code_population" class="form-control square" value="BGM/BAST/">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Name
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="name" id="name" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								KK
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="kk" id="kk" class="form-control square">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								KTP/ID
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="ktp" id="ktp" class="form-control square">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-5 col-lg-5">
								<select id="cluster" name="cluster" onchange="get_data_other();" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($cluster as $key => $b) {
									?>
											<option value="<?php echo $b['id_cluster']; ?>"><?php echo $b['code_cluster'].' - '.$b['cluster']; ?></option>
									<?php
										}
									?>
								</select>					
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Type
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="type_property" name="type_property" onchange="hitung();" class="choices form-select square bg-white" required="required">
									<option value="1">Rumah</option>
									<option value="2">Kavling</option>
								</select>					
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								RT
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="rt" name="rt" class="choices form-select square bg-white" >
									<option value="">Select</option>
								</select>			
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								House Number
							</div>
							<div class="col-sm-2 col-lg-1">
								<input type="text" name="number" id="number" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Address
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address" id="address" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Telp
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="telp" id="telp" class="form-control square">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Hp
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="hp" id="hp" class="form-control square">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Surface Area
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="surface_area" id="surface_area" class="form-control square" value="0">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								House Area
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="building_area" id="building_area" class="form-control square" value="0">
							</div>
						</div>
						<div class="col-lg-12" id="hitung"></div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Status
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="status" name="status" class="choices form-select square bg-white" required="required">
									<option value="0">Active</option>
									<option value="2">Not Active</option>
								</select>			
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