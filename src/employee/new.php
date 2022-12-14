	<?php
		class new_employee{
			
			function new_view($db,$e){

				if($_SESSION['employee_new']==1){

					$unit=$db->select('tb_unit','id_unit','unit','ASC');
					$position=$db->select('tb_position','id_position','position','ASC');

					$sex = array("MALE","FEMALE");
					$religion = array("ISLAM","KATOLIK","KRISTEN","BUDDHA","HINDU","KONGHUCU","LAINNYA");
	?>
					<script src="<?php echo $e; ?>/src/employee/js/js_proses.js"></script>
					<div class="app-card-header p-3 main-content container-fluid">
						<div class="row justify-content-between align-items-center line">
							<div class="col-auto">
								<h6 class="app-card-title">
									Pengurus
								</h6>
							</div>
						</div>
					</div>

					 <div class="app-card-body pb-3 main-content container-fluid">
						<form method="POST" id="new">
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Kode
									</div>
									<div class="col-sm-2 col-lg-2">
										<input type="text" name="code_employee" id="code_employee" class="form-control square" required="required">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Nama
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="text" name="name" id="name" class="form-control square" required="required">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Jabatan
									</div>
									<div class="col-sm-3 col-lg-3">
										<select id="unit" name="unit" class="choices form-select square bg-white">
											<option value="">Select</option>
											<?php
												foreach ($unit as $key => $u) {
											?>
													<option value="<?php echo $u['id_unit']; ?>"><?php echo $u['unit']; ?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="col-sm-2 col-lg-2" align="right">
										Posisi
									</div>
									<div class="col-sm-3 col-lg-3">
										<select id="position" name="position" class="choices form-select square bg-white">
											<option value="">Select</option>
											<?php
												foreach ($position as $key => $p) {
											?>
													<option value="<?php echo $p['id_position']; ?>"><?php echo $p['position']; ?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Agama
									</div>
									<div class="col-sm-3 col-lg-3">
										<select id="religion" name="religion" class="choices form-select square bg-white" required="required">
											<?php
												for($i=0; $i<=6; $i++){
											?>
													<option value="<?php echo $religion[$i]; ?>"><?php echo $religion[$i]; ?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="col-sm-2 col-lg-2" align="right">
										Jenis Kelamin
									</div>
									<div class="col-sm-3 col-lg-3">
										<select id="sex" name="sex" class="choices form-select square bg-white" required="required">
											<?php
												for($i=0; $i<=1; $i++){
											?>
													<option value="<?php echo $sex[$i]; ?>"><?php echo $sex[$i]; ?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Tempat Lahir
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="text" name="place_of_birth" id="place_of_birth" class="form-control square">
									</div>
									<div class="col-sm-2 col-lg-2" align="right">
										Tanggal Lahir
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="text" name="date_of_birth" id="date_of_birth" class="form-control square">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Nomor KTP
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="number" name="id_card" id="id_card" class="form-control square">
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
									<div class="col-sm-2 col-lg-2">
										Kota
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="text" name="city" id="city" class="form-control square">
									</div>
									<div class="col-sm-2 col-lg-2" align="right">
										Kode POS
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="number" name="postal_code" id="postal_code" class="form-control square">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Telp
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="number" name="telp" id="telp" class="form-control square">
									</div>
									<div class="col-sm-2 col-lg-2" align="right">
										HP
									</div>
									<div class="col-sm-3 col-lg-3">
										<input type="number" name="hp" id="hp" class="form-control square">
									</div>
								</div>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Catatan
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