<?php
	class view_purchasing{
		
		function data_view($db,$e,$library_class,$code){

			$view=base64_decode($code);
			$view_purchasing=$db->select('tb_purchasing','number_purchasing="'.$view.'"','id_purchasing','DESC');

			if(mysqli_num_rows($view_purchasing)>0 && $_SESSION['purchasing']==1){
				$v=mysqli_fetch_assoc($view_purchasing);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_purchasing_detail INNER JOIN tb_item ON tb_purchasing_detail.id_item=tb_item.id_item','tb_purchasing_detail.number_purchasing="'.$v['number_purchasing'].'"','tb_purchasing_detail.id_purchasing_detail','DESC','tb_purchasing_detail.id_purchasing_detail,tb_purchasing_detail.qty,tb_purchasing_detail.amount,tb_item.item');

				$cek_pembayaran=$db->select('tb_cash_receipt_payment','number_purchasing="'.$v['number_purchasing'].'"','id_cash_receipt_payment','DESC');

				if(mysqli_num_rows($cek_pembayaran)>0){
					$cb=mysqli_fetch_assoc($cek_pembayaran);
					if($cb['status']==2){
						$pembayaran="0";
					}else{
						$pembayaran="1";
					}
				}else{
					$pembayaran="0";
				}

				$inputan=$tahun.'-'.$bulan;
				$sekarang=$library_class->tahun().'-'.$library_class->bulan();

				$_SESSION['number_purchasing']=$v['number_purchasing'];

				if($v['status']==1){
					$status=" - Finish";
				}else if($v['status']==2){
					$status=" - Cancel";
				}else{
					$status="";
				}

				$detail=$db->select('tb_request_detail','number_request="'.$v['number_request'].'"','id_request_detail','DESC');

				$permintaan=$db->select('tb_request','number_request="'.$v['number_request'].'"','id_request','ASC');

				$position=$db->select('tb_position','id_position="'.$v['id_position'].'"','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee="'.$v['id_population'].'"','name','ASC');
?>
				<script src="<?php echo $e; ?>/src/purchasing/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Pembelian <b><?php echo $status; ?></b>
							</h6>
						</div>
						<?php 
							if($v['status']==0){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-info" onclick="process_transaction()">
										Process
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
								<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number_purchasing']; ?>" required="required" disabled="disabled">
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
								Supplier
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="supplier" id="supplier" class="form-control square" value="<?php echo $v['supplier']; ?>" required="required" disabled="disabled">
							</div>
						</div>
						<?php 
							if(!empty($v['number_request'])){
						?>
								<div class="space_line row">
									<div class="col-sm-2 col-lg-2">
										Number Request
									</div>
									<div class="col-sm-2 col-lg-3">
										<select id="permintaan" name="permintaan" class="form-control square" onchange="nomor_permintaan()" disabled="disabled">
											<option value="">Select</option>
									       		<?php
									             	foreach ($permintaan as $key => $p) {
									       		?>

									                    <option value="<?php echo $p['id_request']; ?>" <?php if($p['number_request']==$v['number_request']){ echo "selected"; } ?>>
									                    	<?php echo $p['number_request'].' - ('.$p['code_cluster'].' - '.$p['cluster'].' - '.$p['position'].')'; ?>
									                    </option>

									           <?php
									           		}
									       		?>
								       </select>
									</div>
								</div>
						<?php
							}
						?>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Type of Purchase
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="type_of_purchase" name="type_of_purchase" class="form-control square" disabled="disabled">
									<option value="1" <?php if(!empty($code)){ if($v['type_of_purchase']=='1'){ echo "selected"; }}; ?>>PURCHASE</option>
									<option value="2" <?php if(!empty($code)){ if($v['type_of_purchase']=='2'){ echo "selected"; }}; ?>>SERVICE</option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">
							                    <option value="" selected>
							                    	<?php echo $v['position']; ?>
							                    </option>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Relocation
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square" disabled="disabled">
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="<?php echo $tr['id_cluster']; ?>" selected>
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
								Request By
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="employee" name="employee" class="form-control square" disabled="disabled">
						       			<?php
							             	foreach ($employee as $key => $p) {
							       		?>

							                    <option value="<?php echo $p['id_employee']; ?>" selected>
							                    	<?php echo $p['name']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       </select>
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
								Item
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="item" name="item" class="form-control square" disabled="disabled">
									<option value="">Select</option>
						       </select>
							</div>
							<div class="col-sm-1 col-lg-1">
								Qty
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="qty" id="qty" class="form-control square" disabled="disabled">
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="text" name="unit" id="unit" value="Pcs" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Price
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="amount" id="amount" class="form-control square" disabled="disabled">
							</div>
						</div>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Item</td>
								<td width="200px">Price</td>
								<?php 
									if(!empty($v['number_request'])){
								?>
										<td width="100px" align="center">Qty Request</td>
								<?php
									}
								?>
								<td width="250px">Qty</td>
								<td width="200px">Total</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;


									$detail_po=$db->select('tb_purchasing_detail','number_purchasing="'.$v['number_purchasing'].'"','id_purchasing_detail','ASC','id_purchasing_detail,qty,unit,amount,item,id_item');


									if(!empty(mysqli_num_rows($detail_po))){
										while($d = mysqli_fetch_assoc($detail_po)):
										$acak=str_replace("=", "", base64_encode($d['id_purchasing_detail']));
										
									

										$total=$d['amount']*$d['qty'];

							?>
										
									<!-- Looping Data From Database -->

							

										<tr>
											<td align="center">
												<?php echo $no; ?>.
											</td>

											<td>
												<?php echo $d['item']; ?>
											</td>
  
											<td>
												<script type="text/javascript">
													$(document).ready(function() {
													var amount<?php echo $acak; ?> = document.getElementById("amount<?php echo $acak; ?>"); 

												    amount<?php echo $acak; ?>.addEventListener("keyup", function(e) { 
												        amount<?php echo $acak; ?>.value = convertRupiah(this.value); 
												    }); 

												    amount<?php echo $acak; ?>.addEventListener('keydown', function(event) { 
												        return isNumberKey(event); 
												    });
												    });
												</script>
												<input type="text" name="amount<?php echo $acak; ?>" id="amount<?php echo $acak; ?>" class="form-control" style="width:150px;" onchange="hitung('<?php echo $acak; ?>')" value="<?php echo $d['amount']; ?>" disabled="disabled">
											</td>
											<?php
												if(!empty($v['number_request'])){
											?>
													<td><?php echo $d['qty'].' '.$d['unit']; ?></td>
											<?php
												}
											?>
											<td>
												<input type="number" min="0" name="qty<?php echo $acak; ?>" id="qty<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo $d['qty']; ?>" onchange="hitung('<?php echo $acak; ?>')" disabled="disabled">
											</td>
											<td>
												<input type="text" name="total<?php echo $acak; ?>" id="total<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo number_format($total,2,',','.'); ?>" disabled="disabled">
											</td>
										</tr>



							<?php
										$no++;
											endwhile;
									}//end if 
							?>


						</tbody>

					</table>
							<div class="space_line row">
								<div class="col-lg-12">
									<?php
										if($_SESSION['purchasing_new']==1){
									?>
										<a href="<?php echo $e; ?>/purchasing/new-manual">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
									<?php
										}
										if($v['status']=='0' && $_SESSION['purchasing_edit']==1){

											if(!empty($v['number_request'])){
												$link_edit=$e.'/purchasing/edit/'.$code;
											}else{
												$link_edit=$e.'/purchasing/edit-manual/'.$code;
											}
									?>
											<a href="<?php echo $link_edit; ?>">
												<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
											</a>
									<?php
										}
										if($inputan==$sekarang && $v['status']!=='2' && $pembayaran=='0' && $_SESSION['purchasing_cancel']==1){
									?>
											<a href="#" onclick="cancel()">
												<button type="button" class="btn btn-sm btn-danger btn-custom">Cancel</button>
											</a>
									<?php
										}
									?>
								</div>
							</div>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/purchasing";
				</script>
<?php
			}
		}

	}
?>