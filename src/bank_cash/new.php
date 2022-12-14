<?php
	class new_bank_cash{
		
		function new_view($db,$e){
			if($_SESSION['bank_cash_new']==1){

				$employee=$db->select('tb_employee','id_employee','name','ASC');

?>
				<script src="<?php echo $e; ?>/src/bank_cash/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bank / Cash
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
								<input type="text" name="code_bank_cash" id="code_bank_cash" minlength="3" maxlength="3" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Bank / Cash
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="bank_cash" id="bank_cash" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								No. Rek
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="account_number" id="account_number" class="form-control square">
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
								Access
							</div>
							<div class="col-sm-5 col-lg-5">
								<select id="access" name="access" class="form-control square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($employee as $key => $em) {
									?>
											<option value="<?php echo $em['id_employee']; ?>"><?php echo $em['name']; ?></option>
									<?php
										}
									?>
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