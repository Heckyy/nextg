<?php
	class view_item_receipt{
		
		function data_view($db,$e,$library_class,$code){

			$view=base64_decode($code);
			$view_item_receipt_out=$db->select('tb_item_receipt_out','number_item_receipt_out="'.$view.'" && type_transaction="i"','id_item_receipt_out','DESC');

			if(mysqli_num_rows($view_item_receipt_out)>0){
				$v=mysqli_fetch_assoc($view_item_receipt_out);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_item_receipt_out_detail INNER JOIN tb_item ON tb_item_receipt_out_detail.id_item=tb_item.id_item','tb_item_receipt_out_detail.number_item_receipt_out="'.$v['number_item_receipt_out'].'"','tb_item_receipt_out_detail.id_item_receipt_out_detail','DESC','tb_item_receipt_out_detail.id_item_receipt_out_detail,tb_item_receipt_out_detail.qty,tb_item.item');

				$type_of_receipt_wh=$db->select('tb_type_of_receipt_wh','id_type_of_receipt_wh','type_of_receipt_wh','ASC');
				$purchasing=$db->select('tb_purchasing','status="1"','id_purchasing','ASC');
				$item=$db->select('tb_item','id_item','item','ASC');

				$_SESSION['number_item_receipt_out']=$v['number_item_receipt_out'];

				$inputan=$tahun.'-'.$bulan;
				$sekarang=$library_class->tahun().'-'.$library_class->bulan();

				if($v['status']==1){
					$status=" - Finish";
				}else if($v['status']==2){
					$status=" - Cancel";
				}else{
					$status="";
				}

				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');

?>
				<script src="<?php echo $e; ?>/src/item_receipt/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Item Receipt <b><?php echo $status; ?></b>
							</h6>
						</div>
						<?php 
							if($v['status']==0){
						?>
								<div class="col-auto">
									<button class="btn btn-sm btn-info" onclick="process_transaction()">
										Proses <b><?php echo $status; ?></b>
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
									<option value="other" <?php if($v['from_for']=='other'){ echo "selected"; } ?>>OTHER</option>	
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
								<textarea  name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?php echo $v['note']; ?></textarea>
							</div>
						</div>


						<table class="table mb-0">
							<thead>
								<tr>
									<td width="50px" align="center">No</td>
									<td>Item</td>
									<td width="150px">Qty Accepted</td>
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
											<td align="center"><?php echo $no; ?></td>
											<td><?php echo $d['item']; ?></td>
											<td>
												<input type="number" maxlength="<?php echo $hitung; ?>" name="qty<?php echo $acak_id; ?>" id="qty<?php echo $acak_id; ?>" value="<?php echo $result; ?>" class="form-control" onchange="hitung('<?php echo $acak_id; ?>');" disabled="disabled">
											</td>
										</tr>
								<?php
										$no++;
									}
								?>
							</tbody>
						</table>
							<div class="space_line row">
								<div class="col-lg-12">
									<?php
										if($_SESSION['item_receipt_new']==1){
									?>
										<a href="<?php echo $e; ?>/item-receipt/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
									<?php
										}
										if($v['status']=='0' && $_SESSION['item_receipt_edit']==1){
									?>
											<a href="<?php echo $e; ?>/item-receipt/edit/<?php echo $code; ?>">
												<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
											</a>
									<?php
										}
										if($inputan==$sekarang && $v['status']!=='2' && $_SESSION['item_receipt_cancel']==1){
									?>
											<a href="#" onclick="cancel()">
												<button type="button" class="btn btn-sm btn-danger btn-custom" id="cancel">Cancel</button>
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
					document.location.href=localStorage.getItem('data_link')+"/item-receipt";
				</script>
<?php
			}
		}

	}
?>