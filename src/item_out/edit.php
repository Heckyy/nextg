<?php
	class edit_item_out{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_item_receipt_out=$db->select('tb_item_receipt_out','number_item_receipt_out="'.$view.'" && status="0" && type_transaction="o"','id_item_receipt_out','DESC');

			if(mysqli_num_rows($view_item_receipt_out)>0 && $_SESSION['item_out_edit']==1){
				$v=mysqli_fetch_assoc($view_item_receipt_out);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$detail=$db->select('tb_item_receipt_out_detail INNER JOIN tb_item ON tb_item_receipt_out_detail.id_item=tb_item.id_item','tb_item_receipt_out_detail.number_item_receipt_out="'.$v['number_item_receipt_out'].'"','tb_item_receipt_out_detail.id_item_receipt_out_detail','DESC','tb_item_receipt_out_detail.id_item_receipt_out_detail,tb_item_receipt_out_detail.qty,tb_item.item');

				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				
				$type_of_out_wh=$db->select('tb_type_of_out_wh','id_type_of_out_wh','type_of_out_wh','ASC');

				$item=$db->select('tb_item','id_item','item','ASC');

				$_SESSION['number_item_receipt_out']=$v['number_item_receipt_out'];

?>
				<script src="<?php echo $e; ?>/src/item_out/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Item Out
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
								Tipe Item Out
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="type_of_out_wh" name="type_of_out_wh" class="choices form-select square" required="required" disabled="disabled">
									<option value="">Select</option>	
									<?php
										foreach ($type_of_out_wh as $key => $t){
									?>
											<option value="<?php echo $t['id_type_of_out_wh']; ?>" <?php if($t['id_type_of_out_wh']==$v['id_type_receipt_out']){ echo "selected"; } ?>><?php echo $t['type_of_out_wh']; ?></option>
									<?php
										}	
									?>							
								</select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Uraian/Bagian
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="cluster" name="cluster" class="form-control square bg-white">
									<option value="">Select</option>
									<optgroup label="CLUSTER">
							       		<?php
							             	foreach ($cluster as $key => $tr) {
							       		?>

							                    <option value="C_<?php echo $tr['id_cluster']; ?>">
							                    	<?php echo $tr['code_cluster'].' - '.$tr['cluster']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       		</optgroup>
						       		<optgroup label="BAGIAN">
						       			<?php
							             	foreach ($position as $key => $p) {
							       		?>

							                    <option value="P_<?php echo $p['id_position']; ?>">
							                    	<?php echo $p['position']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       		</optgroup>
						       </select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								For
							</div>
							<div class="col-sm-3 col-lg-3">
								<input type="text" name="untuk" id="untuk" value="<?php echo $v['from_for']; ?>" class="form-control square" required="required">
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
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Item
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="item" name="item" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($item as $key => $i) {
									?>
											<option value="<?php echo $i['id_item']; ?>">
												<?php echo $i['item']; ?>
											</option>
									<?php
										}
									?>
								</select>
							</div>
							<div class="col-sm-1 col-lg-1" align="right">
								Qty
							</div>
							<div class="col-sm-1 col-lg-1">
								<input type="number" name="qty" id="qty" min="1" class="form-control square" required="required">
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
								<td>Total</td>
								<td width="150px" align="center">Aksi</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($detail as $key => $d) {

									$acak=str_replace("=", "", base64_encode($d['id_item_receipt_out_detail']));

							?>
									<tr>
										<td align="center">
											<?php echo $no; ?>.
										</td>
										<td>
											<?php echo $d['item']; ?>
										</td>
										<td>
											<?php echo $d['qty']; ?>
										</td>
										<td align="center">
											<a href="#" onclick="hapus('<?php echo $acak; ?>')">
												<i class="bi bi-trash"></i>
											</a>
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
					document.location.href=localStorage.getItem('data_link')+"/item-out";
				</script>
<?php
			}
		}

	}
?>