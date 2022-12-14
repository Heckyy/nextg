<?php
	class edit_employee{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$employee=$db->select('tb_employee','code_employee="'.$view.'"','id_employee','ASC');

			if(mysqli_num_rows($employee)>0 && $_SESSION['employee_edit']==1){
				
				$v=mysqli_fetch_assoc($employee);

				$unit=$db->select('tb_unit','id_unit','unit','ASC');
				$position=$db->select('tb_position','id_position','position','ASC');

				$sex = array("MALE","FEMALE");
				$religion = array("ISLAM","KATOLIK","KRISTEN","BUDDHA","HINDU","KONGHUCU","LAINNYA");

				$date_of_birth=$v['date_of_birth'];
				$tanggal=substr($date_of_birth, 8,2);
				$bulan=substr($date_of_birth, 5,2);
				$tahun=substr($date_of_birth, 0,4);
				$date_of_birth=$tanggal."-".$bulan."-".$tahun;

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
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_employee" id="code_employee" class="form-control square" value="<?php echo $v['code_employee']; ?>" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nama
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="name" id="name" class="form-control square" value="<?php echo $v['name']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Jabatan
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="unit" name="unit" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($unit as $key => $u) {
									?>
											<option value="<?php echo $u['id_unit']; ?>" <?php if($u['id_unit']==$v['id_unit']){ echo "selected"; } ?>><?php echo $u['unit']; ?></option>
									<?php
										}
									?>
								</select>
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Posisi
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="position" name="position" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($position as $key => $p) {
									?>
											<option value="<?php echo $p['id_position']; ?>" <?php if($p['id_position']==$v['id_position']){ echo "selected"; } ?>><?php echo $p['position']; ?></option>
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
											<option value="<?php echo $religion[$i]; ?>" <?php if($religion[$i]==$v['religion']){ echo "selected"; } ?>><?php echo $religion[$i]; ?></option>
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
											<option value="<?php echo $sex[$i]; ?>" <?php if($sex[$i]==$v['sex']){ echo "selected"; } ?>><?php echo $sex[$i]; ?></option>
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
								<input type="text" name="place_of_birth" id="place_of_birth" class="form-control square" value="<?php echo $v['place_of_birth']; ?>">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Tanggal Lahir
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="date_of_birth" id="date_of_birth" class="form-control square" value="<?php echo $date_of_birth; ?>">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nomor KTP
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="number" name="id_card" id="id_card" class="form-control square" value="<?php echo $v['id_card']; ?>">
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
							<div class="col-sm-2 col-lg-2">
								Kota
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="city" id="city" class="form-control square" value="<?php echo $v['city']; ?>">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Kode POS
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="number" name="postal_code" id="postal_code" class="form-control square" value="<?php echo $v['postal_code']; ?>">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Telp
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="number" name="telp" id="telp" class="form-control square" value="<?php echo $v['telp']; ?>">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								HP
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="number" name="hp" id="hp" class="form-control square" value="<?php echo $v['hp']; ?>">
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
					document.location.href=localStorage.getItem('data_link')+"/employee";
				</script>
<?php

			}

		}

	}
?>