<?php
	class new_type_of_payment{
		
		function new_view($db,$e){

			if($_SESSION['type_of_payment_new']==1){
?>
			<script src="<?php echo $e; ?>/src/type_of_payment/js/js_proses.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
						Jenis Pengeluaran
						</h6>
					</div>
				</div>
			</div>

			 <div class="app-card-body pb-3 main-content container-fluid">
				<form method="POST" id="new">
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Kode
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="code_type_of_payment" id="code_type_of_payment" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Jenis Pengeluaran
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="type_of_payment" id="type_of_payment" class="form-control square" required="required">
						</div>
					</div>
					<div class="space_line row">
						<div class="col-sm-2 col-lg-2">
							Catatan
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