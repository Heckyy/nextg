<?php
	class new_payroll_cash_payment{
		
		function new_payroll_view($db,$e,$library_class){
			if($_SESSION['payroll']==1 && !empty($_SESSION['bank'])){

				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$type_of_payment=$db->select('tb_type_of_payment','id_type_of_payment','type_of_payment','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');

				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();

				$date 		= $tanggal.'-'.$bulan.'-'.$tahun;

				$coordinator=$db->select('tb_coordinator','id_coordinator','coordinator','ASC');
				$contractor=$db->select('tb_contractor','id_contractor','contractor','ASC');

?>
				<script src="<?php echo $e; ?>/src/cash_payment/js/js_proses.js"></script>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#untuk_payroll").select2({
						    theme: "bootstrap-5",
						});
					});
				</script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bank / Cash Payment <b>( <?php if(!empty($b['bank_cash'])) { echo $b['bank_cash']; } ?> )</b>
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="new_payroll">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="number" id="number" class="form-control square" required="required" disabled="disabled">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Date
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Cluster
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square bg-white">
									<option value="">Select</option>
						       		<?php
						             	foreach ($cluster as $key => $tr) {
						       		?>

						                    <option value="<?php echo $tr['id_cluster']; ?>">
						                    	<?php echo $tr['code_cluster'].' - '.$tr['cluster']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Payment
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_payment" name="type_of_payment" class="form-control square bg-white" required>
									<option value="">Select</option>
						       		<?php
						             	foreach ($type_of_payment as $key => $tr) {
						       		?>

						                    <option value="<?php echo $tr['id_type_of_payment']; ?>" <?php if($tr['type_of_payment']=='PAYROLL'){ echo "selected"; } ?>>
						                    	<?php echo $tr['type_of_payment']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Staff
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="untuk_payroll" name="untuk_payroll" class="form-control square bg-white" required>
									<option value="">Select</option>
						       		<?php
						             	foreach ($coordinator as $key => $c) {
						       		?>

						                    <option value="<?php echo $c['coordinator']; ?>">
						                    	<?php echo $c['coordinator']; ?>
						                    </option>

						           <?php
						           		}
						           		foreach ($contractor as $key => $c) {
						       		?>

						                    <option value="<?php echo $c['contractor']; ?>">
						                    	<?php echo $c['contractor']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nominal
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" required="required">
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