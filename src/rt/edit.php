<?php
	class edit_rt{
		
		function edit_view($db,$e,$code){

			$code=base64_decode($code);
			$rt=$db->select('tb_rt','code_rt="'.$code.'"','id_rt','DESC');

			if(mysqli_num_rows($rt)>0 && $_SESSION['rt_edit']==1){

				$v=mysqli_fetch_assoc($rt);

				$population1=$db->select('tb_population INNER JOIN tb_cluster ON tb_population.id_cluster=tb_cluster.id_cluster','tb_population.type="0"','tb_population.name','ASC');

				$head=$db->select('tb_population INNER JOIN tb_cluster ON tb_population.id_cluster=tb_cluster.id_cluster','tb_population.id_population_detail="'.$v['code_population'].'" || tb_population.id_population="'.$v['code_population'].'"','tb_population.id_population','ASC');

				$wakil=$db->select('tb_population INNER JOIN tb_cluster ON tb_population.id_cluster=tb_cluster.id_cluster','tb_population.id_population_detail="'.$v['code_population_representative'].'" || tb_population.id_population="'.$v['code_population_representative'].'"','tb_population.id_population','ASC');

				$population2=$db->select('tb_population INNER JOIN tb_cluster ON tb_population.id_cluster=tb_cluster.id_cluster','tb_population.type="0"','tb_population.name','ASC');

				$cluster=$db->select('tb_cluster','id_cluster','id_cluster','ASC');

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
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_rt" id="code_rt" class="form-control square" value="<?php echo $code; ?>" required="required" disabled="disabled">
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
											<option value="<?php echo $c['id_cluster']; ?>" <?php if($c['id_cluster']==$v['id_cluster']){ echo "selected"; } ?>><?php echo $c['code_cluster'].' - '.$c['cluster']; ?></option>
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
								<input type="text" name="rt" id="rt" class="select2--small form-control square" value="<?php echo $v['number']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Kepala RT
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="ketua_rt" id="ketua_rt" class="form-control square" value="<?php echo $v['name_rt']; ?>">					
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
							<div class="col-sm-2 col-lg-2 p-3"></div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Wakil RT
							</div>
							<div class="col-sm-5 col-lg-5">
								<input type="text" name="wakil_rt" id="wakil_rt" class="form-control square" value="<?php echo $v['name_representative']; ?>">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address_wakil" id="address_wakil" class="form-control square textarea-edit"><?php echo $v['address_representative']; ?></textarea>
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
					document.location.href=localStorage.getItem('data_link')+"/rt";
				</script>
<?php
			}
		}

	}
?>