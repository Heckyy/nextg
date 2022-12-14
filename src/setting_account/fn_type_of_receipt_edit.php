<?php
	class edit_fn_type_of_receipt{
		
		function edit_view($db,$e,$view){

			if($_SESSION['setting_account']==1){

				$result = $db->select('tb_type_of_receipt','id_type_of_receipt','type_of_receipt','ASC');

				$totalRecords = mysqli_num_rows($result);
?>
				<script type="text/javascript">
					$(document).ready(function() {

<?php
						foreach ($result as $key => $r) {
?>
								$("#account_<?php echo $r['id_type_of_receipt']; ?>").select2({
								    theme: "bootstrap-5",
								});
<?php
						}
?>
					});
				</script>

				<script src="<?php echo $e; ?>/src/setting_account/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Account - Finance Type of Receipt
							</h6>
						</div>
					</div>
					<?php
						if($_SESSION['account_new']==1 || $_SESSION['group_account']==1 || $_SESSION['type_of_account']==1 || $_SESSION['setting_account']==1){
					?>
							<div class="col" align="right">
								<?php
									if($_SESSION['group_account']==1){
								?>
										<a href="<?php echo $e; ?>/account/group-account" class="btn btn-default btn-sm link-new">
								           	Group Account
										</a>
								<?php
									}
									if($_SESSION['type_of_account']==1){
								?>
										<a href="<?php echo $e; ?>/account/type-of-account" class="btn btn-default btn-sm link-new">
								           	Type of Account
										</a>
								<?php
									}
									if($_SESSION['setting_account']==1){
								?>
										<a href="#" class="btn btn-default btn-sm link-new" data-bs-toggle="modal" data-bs-target="#setting_account">
								           	Setting Account
										</a>
								<?php
									}
									if($_SESSION['account']==1){
								?>
										<a href="<?php echo $e; ?>/account" class="btn btn-default btn-sm link-new">
								           	Account
										</a>
								<?php
									}
								?>
							</div>
					<?php
						}
					?>
				</div>


				 <div class="app-card-body pb-3 main-content container-fluid">
				 	<div class="scroll">
						<table class="table mb-0">
						    <thead>
						        <tr>
						            <td width="50px" align="center">No</td>
						            <td>Type of Receipt</td>
						            <td>Account</td>
						        </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		if($totalRecords>0){
						    	?>
						    			<form method="POST" id="edit_fn_type_of_receipt">
						    	<?php
						    			$no=1;
										foreach ($result as $key => $r) {
											$account = $db->select('tb_account','id_account','account_no','ASC');
								?>
											<tr>
												<td align="center">
													<?php
														echo $no;
													?>
												</td>
												<td width="50%">
													<?php
														echo $r['type_of_receipt'];
													?>
												</td>
												<td>
													<select id="account_<?php echo $r['id_type_of_receipt']; ?>" name="account_<?php echo $r['id_type_of_receipt']; ?>" class="form-control square bg-white">
														<option value="">
															Select
														</option>
														<?php
															foreach ($account as $key => $a) {
														?>
																<option value="<?php echo $a['id_account']; ?>" <?php if($a['id_account']==$r['id_account']){ echo 'selected'; } ?>>
																	<?php echo $a['account_no'].' - '.$a['account']; ?>
																</option>
														<?php
															}
														?>
													</select>
												</td>
											</tr>
								<?php
											$no++;
										}
								?>
											<tr>
												<td colspan="3" align="right" class="bg-white">
													<button class="btn btn-success btn-sm">Save</button>
												</td>
											</tr>
										</form>
								<?php
									}else{
										echo '<tr><td colspan="3">Data not found!</td></tr>';
									}
						    	?>
						    </tbody>
						</table>
					</div>
				</div>

				<input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">

				<div class="row">
					<div id="pagination"></div>    
				</div>   
<?php
				if($_SESSION['setting_account']==1){
?>
					<div class="modal fade" id="setting_account" tabindex="-1" aria-labelledby="setting_accountLabel" aria-hidden="true">
					  	<div class="modal-dialog">
					    	<div class="modal-content">
					      		<div class="modal-header">
					        		<h5 class="modal-title" id="setting_accountLabel">Setting Account</h5>
					        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      		</div>
							      	<div class="modal-body">
							      		<table class="table">
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Purchasing</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/pcg/purchasing" style="width: 100%; float: left;">
							      						Purchasing
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Finance</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/fn/type-of-receipt" style="width: 100%; float: left;">
							      						Type of Receipt
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/fn/type-of-payment" style="width: 100%; float: left;">
							      						Type of Payment
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Warehouse</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/wh/type-of-receipt" style="width: 100%; float: left;">
							      						Type of Receipt
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/wh/type-of-out" style="width: 100%; float: left;">
							      						Type of Out
							      					</a>
							      				</td>
							      			</tr>
							      		</table>
							      	</div>
					    	</div>
					  	</div>
					</div>
<?php
				}
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