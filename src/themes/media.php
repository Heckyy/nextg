<?php
	class themes{
		function media($db,$e,$title,$body,$library_class,$session,$all_file,$settings,$hal,$get,$view,$page){
?>
			<!DOCTYPE html>
			<html lang="en">

				<head>
				    <meta charset="UTF-8">
				    <meta name="viewport" content="width=device-width, initial-scale=1.0">
				    <title>MANAGEMENT RW 05</title>

				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/css/bootstrap.css">

				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/chartjs/Chart.min.css">
				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/icons/font/bootstrap-icons.css">
				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/css/app.css">
				    <link rel="stylesheet" href="<?php echo $e; ?>/assets/css/style.css">
					<link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/sweetalert/css/sweetalert2.min.css">
					<link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/select2/css/select2.min.css" />
					<link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/select2/css/select2-bootstrap-5-theme.rtl.min.css" />
				    <link rel="shortcut icon" href="<?php echo $e; ?>/assets/images/favicon.png" type="image/x-icon">
					<link rel="stylesheet" href="<?php echo $e; ?>/assets/vendors/date/jquery-ui.css">
				    <script src="<?php echo $e; ?>/assets/js/jquery-2.1.4.min.js"></script>
					<script src="<?php echo $e; ?>/assets/vendors/date/jquery-ui.js"></script>

				</head>

				<body>
					<div id="<?php echo $body; ?>">

					    <?php
					    	echo $settings->halaman($db,$e,$body,$library_class,$session,$all_file,$hal,$get,$view,$page);
					    ?>

					</div>
				</body>

				<div id="view_detail"></div>

			    <script src="<?php echo $e; ?>/assets/js/simple-bootstrap-paginator.js"></script>
				<script src="<?php echo $e; ?>/assets/vendors/sweetalert/js/sweetalert2.min.js"></script>
			    <script src="<?php echo $e; ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
			    <script src="<?php echo $e; ?>/assets/js/app.js"></script>

			    <script src="<?php echo $e; ?>/assets/vendors/chartjs/Chart.min.js"></script>
			    <script src="<?php echo $e; ?>/assets/vendors/apexcharts/apexcharts.min.js"></script>

			    <script src="<?php echo $e; ?>/assets/vendors/select2/js/select2.min.js"></script>

			    <script src="<?php echo $e; ?>/assets/js/main.js"></script>
			    <script src="<?php echo $e; ?>/assets/js/js.js"></script>

			</html>

			<?php
				if(!empty($_SESSION['cash_receipt']) && !empty($_SESSION['code_employee'])){
			?>
					<div class="modal fade" id="cash_receipt_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog">
					    	<div class="modal-content">
							    <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Cash Receipt</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							    </div>
							    <div class="modal-body">
							    	<table class="table">
							        	<?php
							        		$jum_bank=0;
								        	$bank_cash_receipt=$db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
								        	foreach ($bank_cash_receipt as $key => $bcr) {
								        		$access_bank=$db->select('tb_access_bank','id_bank_cash="'.$bcr['id_bank_cash'].'" && id_employee="'.$_SESSION['id_employee'].'"','id_access_bank','DESC');

								        		if(!empty(mysqli_num_rows($access_bank))){
								        			$acak_bank=str_replace("=", "", base64_encode($bcr['id_bank_cash']));
								        ?>
									        		<tr>
									        			<td>
									        				<a href="<?php echo $e; ?>/cash-receipt/bank/<?php echo $acak_bank; ?>" class="link">
									        					<?php echo $bcr['bank_cash']; ?>
									        				</a>
									        			</td>
									        		</tr>
								        <?php
								        			$jum_bank++;
								        		}
								        	}
								        	if($jum_bank==0){
								        ?>
								        		<tr>
								        			<td>Do not have access to a bank!!!</td>
								        		</tr>
								        <?php
								        	}
								        ?>
							        </table>
					      		</div>
					    	</div>
					  	</div>
					</div>
			<?php
				}
				if(!empty($_SESSION['cash_payment']) && !empty($_SESSION['code_employee'])){
			?>
					<div class="modal fade" id="cash_payment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog">
					    	<div class="modal-content">
							    <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Cash Payment</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							    </div>
							    <div class="modal-body">
							    	<table class="table">
							        	<?php
							        		$jum_bank=0;
								        	$bank_cash_receipt=$db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
								        	foreach ($bank_cash_receipt as $key => $bcr) {
								        		$access_bank=$db->select('tb_access_bank','id_bank_cash="'.$bcr['id_bank_cash'].'" && id_employee="'.$_SESSION['id_employee'].'"','id_access_bank','DESC');

								        		if(!empty(mysqli_num_rows($access_bank))){
								        			$acak_bank=str_replace("=", "", base64_encode($bcr['id_bank_cash']));
								        ?>
									        		<tr>
									        			<td>
									        				<a href="<?php echo $e; ?>/cash-payment/bank/<?php echo $acak_bank; ?>" class="link">
									        					<?php echo $bcr['bank_cash']; ?>
									        				</a>
									        			</td>
									        		</tr>
								        <?php
								        			$jum_bank++;
								        		}
								        	}
								        	if($jum_bank==0){
								        ?>
								        		<tr>
								        			<td>Do not have access to a bank!!!</td>
								        		</tr>
								        <?php
								        	}
								        ?>
							        </table>
					      		</div>
					    	</div>
					  	</div>
					</div>
<?php
			}
		}
	}
?>
