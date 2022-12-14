<?php
	class edit_item_receipt{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_item_receipt_out=$db->select('tb_item_receipt_out','number_item_receipt_out="'.$view.'" && status="0" && type_transaction="i"','id_item_receipt_out','DESC');

			if(mysqli_num_rows($view_item_receipt_out)>0 && $_SESSION['item_receipt_edit']==1){
				$v=mysqli_fetch_assoc($view_item_receipt_out);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$type_of_receipt_wh=$db->select('tb_type_of_receipt_wh','id_type_of_receipt_wh','type_of_receipt_wh','ASC');
				$purchasing=$db->select('tb_purchasing','type_of_purchase="1" && status_terima_barang="0" && status="1"','id_purchasing','ASC');
				$item=$db->select('tb_item','id_item','item','ASC');

				$_SESSION['number_item_receipt_out']=$v['number_item_receipt_out'];

				
?>
				<script src="<?php echo $e; ?>/src/item_receipt/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Item Receipt
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
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number_item_receipt_out']; ?>" required="required" disabled="disabled">
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
								From
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="from" name="from" class="choices form-select square" required="required" disabled="disabled">
									<option value="">Select</option>	
									<?php
										foreach ($purchasing as $key => $t){
									?>
											<option value="<?php echo $t['number_purchasing']; ?>" <?php if($v['number_purchasing']==$t['number_purchasing']){ echo "selected"; } ?>><?php echo $t['supplier']; ?> - ( <?php echo $t['number_purchasing']; ?> )</option>
									<?php
										}	
									?>
								</select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Division
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="divisi" name="divisi" class="form-control square" disabled="disabled">

							                    <option value="<?php echo $v['id_position']; ?>">
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

							                    <option value="<?php echo $v['id_cluster']; ?>">
							                    	<?php echo $v['code_cluster'].' - '.$v['cluster']; ?>
							                    </option>
						       </select>
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



						<table class="table mb-0">
							<thead>
								<tr>
									<td width="50px" align="center">No</td>
									<td width="250px">Item</td>
									<td width="150px">Qty</td>
									<td width="150px">Qty Accepted</td>
									<td width="150px">Difference</td>
								</tr>
							</thead>
							<tbody>
								<?php
									$detail=$db->select('tb_purchasing_detail','number_purchasing="'.$v['number_purchasing'].'"','id_purchasing_detail','DESC');

									$no=1;
									foreach ($detail as $key => $d) {

										$acak_id=str_replace("=", "", base64_encode($d['id_purchasing_detail']));

										if(empty($d['terima'])){
											$terima=0;
										}else{
											$terima=$d['terima'];
										}

										$hitung=$d['qty']-$terima;

										$detail_wh=$db->select('tb_item_receipt_out_detail','number_item_receipt_out="'.$v['number_item_receipt_out'].'" && id_item="'.$d['id_item'].'"','id_item_receipt_out_detail','DESC');
										if(mysqli_num_rows($detail_wh)>0){
											$dh=mysqli_fetch_assoc($detail_wh);
											$result=$dh['qty'];
											$terima=$hitung-$dh['qty'];
										}else{
											$result="0";
										}



								?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $d['item']; ?></td>
											<td><?php echo $hitung; ?></td>
											<td>
												<input type="number" maxlength="<?php echo $hitung; ?>" name="qty<?php echo $acak_id; ?>" id="qty<?php echo $acak_id; ?>" value="<?php echo $result; ?>" class="form-control" onchange="hitung('<?php echo $acak_id; ?>');">
											</td>
											<td id="hasil<?php echo $acak_id; ?>"><?php echo $terima; ?></td>
										</tr>
								<?php
										$no++;
									}
								?>
							</tbody>
						</table>
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
					document.location.href=localStorage.getItem('data_link')+"/item-receipt";
				</script>
<?php
			}
		}

	}
?>