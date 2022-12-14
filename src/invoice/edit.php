<?php
	class edit_invoice{
		
		function edit_view($db,$e,$code){

			$dues_type=$db->select('tb_dues','id_dues','dues_type','ASC');
			$warga=$db->select('tb_warga INNER JOIN tb_cluster ON tb_warga.id_cluster=tb_cluster.id_cluster INNER JOIN tb_rt ON tb_warga.id_rt=tb_rt.id_rt','tb_warga.type="0"','tb_warga.name','ASC','tb_warga.id_warga,tb_warga.name,tb_cluster.cluster,tb_rt.number,tb_warga.house_number');

			$view=base64_decode($code);
			$view_invoicet=$db->select('tb_invoice','number_invoice="'.$view.'" && status="0"','id_invoice','DESC');

			if(mysqli_num_rows($view_invoicet)>0 && $_SESSION['invoice_edit']==1){
				$v=mysqli_fetch_assoc($view_invoicet);

				$tanggal=substr($v['tanggal'], 8,2);
				$bulan=substr($v['tanggal'], 5,2);
				$tahun=substr($v['tanggal'], 0,4);
				$date=$tanggal."-".$bulan."-".$tahun;

				$sampai_tanggal=substr($v['till_date'], 8,2);
				$sampai_bulan=substr($v['till_date'], 5,2);
				$sampai_tahun=substr($v['till_date'], 0,4);
				$till_date=$sampai_tanggal."-".$sampai_bulan."-".$sampai_tahun;

				$_SESSION['number_invoice'] = $v['number_invoice'];

				if($v['status']==1){
					$status=" - Finish";
				}else if($v['status']==2){
					$status=" - Cancel";
				}else{
					$status="";
				}

?>
				<script src="<?php echo $e; ?>/src/invoice/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Tagihan
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Nomor
						</div>
						<div class="col-sm-2 col-lg-3">
							<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['number_invoice']; ?>" required="required" disabled="disabled">
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
							Tanggal
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Tipe Dana Hiba
						</div>
						<div class="col-sm-2 col-lg-3">
							<select id="dues_type" name="dues_type" class="form-control square bg-white" required disabled="disabled">
								<option value="">Select</option>
					       		<?php
					             	foreach ($dues_type as $key => $c) {
					       		?>

					                    <option value="<?php echo $c['id_dues']; ?>" <?php if($c['id_dues']==$v['id_dues']){ echo "selected"; } ?>>
					                    	<?php echo $c['dues_type']; ?>
					                    </option>

					           <?php
					           		}
					       		?>
					       </select>
						</div>
						<div class="col-sm-2 col-lg-2" align="right">
								Sampai Tanggal
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="till_date" id="till_date" value="<?php echo $till_date; ?>" class="form-control square" required="required">
							</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Untuk
						</div>
						<div class="col-sm-3 col-lg-3">
							<select id="warga" name="warga" class="form-control square bg-white" required>
								<option value="">Select</option>
					       		<?php
					             	foreach ($warga as $key => $c) {
					       		?>

					                    <option value="<?php echo $c['id_warga']; ?>" <?php if($c['id_warga']==$v['id_warga']){ echo "selected"; } ?>>
					                    	<?php echo $c['name'].' ('.$c['cluster'].' - '.$c['number'].' - '.$c['house_number'].')'; ?>
					                    </option>

					           <?php
					           		}
					       		?>
					       </select>
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Kredit
						</div>
						<div class="col-sm-3 col-lg-3">
							<input type="text" name="amount" id="amount" value="<?php echo number_format($v['amount'],2,',','.'); ?>" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Catatan
						</div>
						<div class="col-sm-5 col-lg-5">
							<textarea  name="note" id="note" class="form-control square textarea-edit"><?php echo $v['note']; ?></textarea>
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
					document.location.href=localStorage.getItem('data_link')+"/invoice";
				</script>
<?php
			}
		}

	}
?>