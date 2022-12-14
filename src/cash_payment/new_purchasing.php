<?php
	class new_purchasing_cash_payment{
		
		function new_purchasing_view($db,$e,$library_class,$view){

			$view=base64_decode($view);
			$puchasing = $db->select('tb_purchasing','number_purchasing="'.$view.'"','id_purchasing','ASC');
			$jum=mysqli_num_rows($puchasing);
			$v=mysqli_fetch_assoc($puchasing);
				
			$position=$db->select('tb_position','id_position="'.$v['id_position'].'"','position','ASC');

			if($jum>0 && !empty($_SESSION['bank']) && $v['total']>=$v['bayar'] && $_SESSION['payment_for_purchasing']==1 && !empty($_SESSION['bank'])){


				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$type_of_payment=$db->select('tb_type_of_payment','id_type_of_payment','type_of_payment','ASC');
				$cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','cluster','ASC');

				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();

				$date 		= $tanggal.'-'.$bulan.'-'.$tahun;

				if(!empty($v['bayar'])){
					if($v['total']>=$v['bayar']){
						$sisah=$v['total']-$v['bayar'];
					}else{
						$sisah=$v['bayar'];
					}
				}else{
					$sisah=$v['total'];
				}

				$detail=$db->select('tb_purchasing_detail INNER JOIN tb_item ON tb_purchasing_detail.id_item=tb_item.id_item','tb_purchasing_detail.number_purchasing="'.$v['number_purchasing'].'"','tb_purchasing_detail.id_purchasing_detail','DESC','tb_purchasing_detail.id_purchasing_detail,tb_purchasing_detail.qty,tb_purchasing_detail.amount,tb_item.item');

?>
				<script src="<?php echo $e; ?>/src/cash_payment/js/js_proses_purchasing.js"></script>
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
								Cluster
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square" disabled="disabled">
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
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
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

						                    <option value="<?php echo $tr['id_type_of_payment']; ?>" <?php if($tr['type_of_payment']=='OPERASIONAL'){ echo "selected"; } ?>>
						                    	<?php echo $tr['type_of_payment']; ?>
						                    </option>

						           <?php
						           		}
						       		?>
						       </select>
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Jenis Pengeluaran
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control square bg-white" required="required">
									<option value="">Select</option>

						                <option value="1">
						                    Transfer
						                </option>
						                <option value="2">
						                    Giro
						                </option>
						                <option value="3">
						                    Cash
						                </option>

						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Pembelian
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" id="purchasing" name="purchasing" class="form-control square" value="<?php echo $v['number_purchasing']; ?>" required disabled="disabled">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Bank
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="bank_tf" id="bank_tf" class="form-control square" value="">
							</div>
						</div>
						<div class="space_line row">
						
							<div class="col-sm-2 col-lg-2">
								Receiver
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="untuk" id="untuk" class="form-control square" value="<?php echo $v['supplier']; ?>" required="required" disabled="disabled">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="nomor_rek" id="nomor_rek" class="form-control square" value="">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Nominal
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" value="<?php echo number_format($sisah,2,',','.'); ?>" required="required">
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Nama Akun
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="nama_akun" id="nama_akun" class="form-control square" value="">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-2 col-lg-3">
								<textarea  name="note" id="note" class="form-control square textarea-edit"></textarea>
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Tanggal Bank
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="tanggal_bank" id="tanggal_bank" class="form-control square" value="" required="required">
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
								<td width="250px">Item</td>
								<td width="200px">Price</td>
								<td width="200px">Jumlah</td>
								<td>Total</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $d) {

									$acak=str_replace("=", "", base64_encode($d['id_purchasing_detail']));
									$total=$d['amount']*$d['qty'];
							?>
									<tr>
										<td align="center">
											<?php echo $no; ?>.
										</td>
										<td>
											<?php echo $d['item']; ?>
										</td>
										<td>
											<?php echo $d['amount']; ?>
										</td>
										<td>
											<?php echo $d['qty']; ?>
										</td>
										<td>
											<?php echo number_format($total,2,',','.'); ?>
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