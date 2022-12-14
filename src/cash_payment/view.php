<?php
	class view_cash_payment{
		
		function data_view($db,$e,$library_class,$code){

			$type_of_payment=$db->select('tb_type_of_payment','id_type_of_payment','type_of_payment','ASC');

			$view=base64_decode($code);
			$view_cash_payment=$db->select('tb_cash_receipt_payment','number="'.$view.'" && type="o" && number_purchasing=""','id_cash_receipt_payment','DESC');

			if(mysqli_num_rows($view_cash_payment)>0 && $_SESSION['cash_payment']==1){
				$v=mysqli_fetch_assoc($view_cash_payment);

				$detail=$db->select('tb_cash_receipt_payment_detail','number="'.$v['number'].'"','id_detail','DESC');
							
				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$v['id_bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$position=$db->select('tb_position','id_position','position','ASC');

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;


				$inputan=$tahun.'-'.$bulan;
				$sekarang=$library_class->tahun().'-'.$library_class->bulan();

				$_SESSION['number_payment'] = $v['number'];

				if($v['status']==1){
					$status=" - Finish";
				}else if($v['status']==2){
					$status=" - Cancel";
				}else{
					$status="";
				}

				$acak=str_replace("=", "", base64_encode($v['number']));
?>

				<script type="text/javascript">
					$(document).ready(function() {
						$("#divisi").select2({
						    theme: "bootstrap-5",
						});
					});
				</script>
				<script src="<?php echo $e; ?>/src/cash_payment/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bank / Cash Payment <b>( <?php if(!empty($b['bank_cash'])) { echo $b['bank_cash']; } ?> ) <?php echo $status; ?></b>
							</h6>
						</div>
						<?php 
							if($v['status']==0 && $_SESSION['cash_payment_process']==1){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-info" onclick="process_transaction()">
										Process
									</button>
								</div>
						<?php
							}else if($v['status']==1){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-primary" onclick="print_transaction('<?php echo $acak; ?>')">
										Print
									</button>
								</div>
						<?php
							}else if($v['status']==3){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-warning" onclick="diketahui_transaction()">
										Is known
									</button>
								</div>
						<?php
							}
						?>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number']; ?>" required="required" disabled="disabled">
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
								Output Type
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="jenis_uang_keluar" name="jenis_uang_keluar" onchange="jenis_transaksi()" class="form-control square bg-white" required="required" disabled="disabled">
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
								<select id="cluster" name="cluster" class="form-control square" disabled="disabled">
									<option value="">Select</option>
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>" <?php if($tr['id_cluster']==$v['id_cluster']){ echo "selected"; }; ?>>
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
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
									<option value="">Select</option>
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_position']; ?>" <?php if($p['id_position']==$v['id_position']){ echo "selected"; }; ?>>
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
								<select id="type_of_payment" name="type_of_payment" class="form-control square bg-white" disabled="disabled" required>
									<option value="">Select</option>
						       		<?php
						             	foreach ($type_of_payment as $key => $tr) {
						       		?>

						                    <option value="<?php echo $tr['id_type_of_payment']; ?>" <?php if($v['id_type_of_payment']==$tr['id_type_of_payment']){ echo "selected"; } ?> >
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
								<?php
									if($v['type_transaction']==0){
								?>
										<input type="text" name="untuk" id="untuk" value="<?php echo $v['untuk']; ?>" class="form-control square" required="required" disabled="disabled">
								<?php
									}else{
								?>
										<script type="text/javascript">
											$(document).ready(function() {
												$("#untuk_payroll").select2({
												    theme: "bootstrap-5",
												});
											});
										</script>
										<select id="untuk_payroll" name="untuk_payroll" class="form-control square" required="required" disabled="disabled">
											<option value="<?php echo $v['untuk']; ?>"><?php echo $v['untuk']; ?></option>
								       </select>
								<?php
									}
								?>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Total
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" value="<?php echo number_format($v["amount"],2,',','.'); ?>" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Necessity
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="necessity" id="necessity" class="form-control square" required="required" disabled="disabled">
							</div>
						
							<div class="col-sm-2 col-lg-2" align="right">
								Nominal
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
							<div class="space_line row">
								<div class="col-lg-12">
									<?php
										if($_SESSION['cash_payment_new']==1){
									?>
											<a href="<?php echo $e; ?>/cash-payment/new">
												<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
											</a>
									<?php
										}
										if($v['status']=='0' && $_SESSION['cash_payment_edit']==1){
									?>
											<a href="<?php echo $e; ?>/cash-payment/edit/<?php echo $code; ?>">
												<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
											</a>
									<?php
										}
										if($inputan==$sekarang && $v['status']!=='2' && $_SESSION['cash_payment_cancel']==1){
									?>
											<a href="#" onclick="cancel()">
												<button type="button" class="btn btn-sm btn-danger btn-custom">Cancel</button>
											</a>
									<?php
										}
									?>
								</div>
							</div>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Necessity</td>
								<td width="250px" align="right">Nominal</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $dr) {
									$acak=str_replace("=", "", base64_encode($dr['id_detail']));
							?>
										<tr>
											<td align="center">
												<?php echo $no; ?>.
											</td>
											<td>
												<?php echo $dr['necessity']; ?>
											</td>
											<td align="right">
												<?php echo number_format($dr['price'],2,',','.'); ?>
											</td>
										</tr>
							<?php
										$no++;
								}
							?>
						</tbody>
					</table>

				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/cash-payment";
				</script>
<?php
			}
		}

	}
?>