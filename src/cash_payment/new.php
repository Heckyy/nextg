<?php
	class new_cash_payment{
		
		function new_view($db,$e,$library_class){
			if($_SESSION['cash_payment_new']==1 && !empty($_SESSION['bank'])){

				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$type_of_payment=$db->select('tb_type_of_payment','id_type_of_payment','type_of_payment','ASC');
				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');

				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();

				$date 		= $tanggal.'-'.$bulan.'-'.$tahun;
?>
				<script src="<?php echo $e; ?>/src/cash_payment/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bank / Cash Payment <b>( <?php if(!empty($b['bank_cash'])) { echo $b['bank_cash']; } ?> )</b>
							</h6>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#divisi").select2({
						    theme: "bootstrap-5",
						});
						$("#tanggal").datepicker({
							dateFormat: "dd-mm-yy",
					        changeMonth: true
						 });

					});
				</script>
				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="new">
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
								<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Output Type
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="jenis_uang_keluar" name="jenis_uang_keluar" onchange="jenis_transaksi()" class="form-control square bg-white" required="required">
									<option value="">Select</option>
									<option value="1" selected>Administrasi & Operasional</option>
									<option value="2">Pembelian</option>
						       </select>
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
						
							<div class="col-sm-2 col-lg-2" align="right">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square bg-white">
									<option value="">Select</option>
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_position']; ?>">
							                    	<?php echo $p['position']; ?>
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

						                    <option value="<?php echo $tr['id_type_of_payment']; ?>">
						                    	<?php echo $tr['type_of_payment']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
						
							<div class="col-sm-2 col-lg-2" align="right">
								Receiver
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="untuk" id="untuk" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Total
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="total_amount" id="total_amount" class="form-control square" disabled="disabled">
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
								Necessity
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="necessity" id="necessity" class="form-control square" required="required">
							</div>
						
							<div class="col-sm-2 col-lg-2" align="right">
								Nominal
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" required="required">
							</div>
						</div>

						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					</form>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Necessity</td>
								<td width="250px" align="right">Nominal</td>
								<td width="100px" align="center">Action</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="4">Data Not Found!</td>
							</tr>
						</tbody>
					</table>
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