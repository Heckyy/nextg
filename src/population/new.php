<?php
	class new_population{
		
		function new_view($db,$e){

			if($_SESSION['population_new']==1){

				$cluster=$db->select('tb_population ','id_cluster','cluster','ASC');
				$warga=$db->select('tb_warga ','id_warga','urut','ASC');

				if(mysqli_num_rows($warga)){
					$w=mysqli_fetch_assoc($warga);
					$urut=$w['urut']+1;
					$jum=strlen($urut);

					if($jum=1){
						$urut='0000'.$urut;
					}else if($jum=2){
						$urut='000'.$urut;
					}else if($jum=3){
						$urut='00'.$urut;
					}else if($jum=4){
						$urut='0'.$urut;
					}else{
						$urut=$urut;
					}
				}else{
					$urut='00001';
				}

				$urut='POP-'.$urut;

?>
				<script src="<?php echo $e; ?>/src/population/js/js_proses.js"></script>

				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Warga
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
								<input type="text" name="code_warga" id="code_warga" class="form-control square" value="<?php echo $urut; ?>" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nama Depan
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="first_name" id="first_name" class="form-control square" required="required">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Nama Belakang
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="last_name" id="last_name" class="form-control square">
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
											<option value="<?php echo $b['id_population']; ?>"><?php echo $b['code_population'].' - '.$b['cluster'].' ( RT '.$b['number_rt'].' - Number '.$b['house_number']. ' ) '; ?></option>
									<?php
										}
									?>
								</select>					
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								RT
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" id="rt" name="rt" class="form-control square" disabled="disabled">		
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nomor Rumah
							</div>
							<div class="col-sm-2 col-lg-1">
								<input type="text" name="number" id="number" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Alamat
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="address" id="address" class="form-control square textarea-edit" disabled="disabled"></textarea>
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
									<option value="0">Akrif</option>
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