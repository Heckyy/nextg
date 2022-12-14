<?php
	class edit_account{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_account=$db->select('tb_account','id_account="'.$view.'"','id_account','DESC');

			if(mysqli_num_rows($view_account)>0 && $_SESSION['account']==1){
				$v=mysqli_fetch_assoc($view_account);

				$group_account=$db->select('tb_group_account','id_group_account','group_account','ASC');

				$sub_account=$db->select('tb_account','id_type_of_account="'.$v['id_type_of_account'].'" && id_sub_account="0" && id_account!="'.$v['id_account'].'"','id_account','DESC');

				$sub_account_2=$db->select('tb_account','id_type_of_account="'.$v['id_type_of_account'].'" && id_sub_account="'.$v['id_sub_account'].'" && id_sub_account_2="0" && id_account!="'.$v['id_account'].'"','id_account','DESC');

?>
				<script src="<?php echo $e; ?>/src/account/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Akun
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
				 	<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Akun
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="type_of_account" name="type_of_account" onchange="account_sub();" class="form-control square bg-white" required="required">
									<option value="">Select</option>
						       		<?php
						             	foreach ($group_account as $key => $gc) {

						             		echo '<optgroup label="'.$gc['group_account'].'"><hr>';

						             		$type_of_account=$db->select('tb_type_of_account','id_group_account="'.$gc['id_group_account'].'"','type_of_account','ASC');
						             		
						             		foreach ($type_of_account as $key => $toa) {
						       		?>
										    	<option value="<?php echo $toa['id_type_of_account']; ?>" <?php if($toa['id_type_of_account']==$v['id_type_of_account']){ echo "selected"; } ?>>
										    		<?php
										    			echo '- '.$toa['type_of_account'];
										    		?>
										    	</option>
						           <?php
						           			}

						           			echo "</optgroup>";

						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Sub Akun
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="sub_account_from" name="sub_account_from" class="form-control square bg-white">
									<option value="">Select</option>
									<?php
						             	foreach ($sub_account as $key => $sc) {
						       		?>
										   	<option value="<?php echo $sc['id_account']; ?>" <?php if($sc['id_account']==$v['id_sub_account']){ echo "selected"; } ?>>
										    	<?php
										    		echo $sc['account'];
										    	?>
										    </option>
						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Sub Akun 2
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="sub_account_from_2" name="sub_account_from_2" class="form-control square bg-white">
									<option value="">Select</option>
									<?php
						             	foreach ($sub_account_2 as $key => $sca) {
						       		?>
										   	<option value="<?php echo $sca['id_account']; ?>" <?php if($sca['id_account']==$v['id_sub_account_2']){ echo "selected"; } ?>>
										    	<?php
										    		echo $sca['account'];
										    	?>
										    </option>
						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nomor Akun
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="account_number" id="account_number" class="form-control square" value="<?php echo $v['account_no']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Akun
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="account" id="account" class="form-control square" value="<?php echo $v['account']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Posisi
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="position" name="position" class="form-control square bg-white">
									<option value="DEBET" <?php if($v['position']=='DEBET') { echo 'selected'; } ?>>DEBIT</option>
									<option value="CREDIT" <?php if($v['position']=='CREDIT') { echo 'selected'; } ?>>KREDIT</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Laporan
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="type_of_report" id="type_of_report" class="form-control square" value="<?php echo $v['type_of_report']; ?>" required="required" disabled="disabled">
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
					document.location.href=localStorage.getItem('data_link')+"/account";
				</script>
<?php
			}
		}

	}
?>