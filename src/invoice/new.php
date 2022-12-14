<?php
	class new_invoice{
		
		function new_view($db,$e,$library_class){

			if($_SESSION['invoice_new']==1){

				$dues_type=$db->select('tb_dues','id_dues','dues_type','ASC');
				$warga=$db->select('tb_warga','id_warga','name','ASC');

				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();

				$date 		= $tanggal.'-'.$bulan.'-'.$tahun;
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
								<input type="text" name="tanggal" id="tanggal" value="<?php echo $date; ?>" class="form-control square" required="required" disabled="disabled">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Dana Hiba
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="dues_type" name="dues_type" class="form-control square bg-white" required>
									<option value="">Select</option>
						       		<?php
						             	foreach ($dues_type as $key => $c) {
						       		?>

						                    <option value="<?php echo $c['id_dues']; ?>">
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
								<input type="text" name="till_date" id="till_date" class="form-control square" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								For
							</div>
							<div class="col-sm-3 col-lg-3">
								<select id="warga" name="warga" class="form-control square bg-white" required>
									<option value="">Select</option>
						       		<?php
						             	foreach ($warga as $key => $c) {
						       		?>

						                    <option value="<?php echo $c['id_warga']; ?>">
						                    	<?php echo $c['name'].' ('.$c['cluster'].' - '.$c['number_rt'].' - '.$c['house_number'].')'; ?>
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