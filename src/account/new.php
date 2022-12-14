<?php
	class new_account{
		
		function new_view($db,$e){

			$group_account=$db->select('tb_group_account','id_group_account','group_account','ASC');

			if($_SESSION['account_new']==1){
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
					<form method="POST" id="new">
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
										    	<option value="<?php echo $toa['id_type_of_account']; ?>">
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
								<select id="sub_account_from" name="sub_account_from" onchange="account_sub_2();" class="form-control square bg-white">
									<option value="">Select</option>
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
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nomor Akun
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="account_number" id="account_number" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Akun
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="account" id="account" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Posisi
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="position" name="position" class="form-control square bg-white">
									<option value="DEBET">DEBIT</option>
									<option value="CREDIT">KREDIT</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Laporan
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="type_of_report" id="type_of_report" class="form-control square" required="required" disabled="disabled">
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