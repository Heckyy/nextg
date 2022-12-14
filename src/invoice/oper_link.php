<?php
	class view_oper_link{

		function data_view($db,$e,$view){
			$view=mysqli_real_escape_string($db->query, base64_decode($view));

			$invoice=$db->select('tb_invoice','acak="'.$view.'"','id_invoice','ASC');


				foreach ($invoice as $key => $i) {
					$acak=str_replace("=", "", base64_encode($i['number_invoice']));
?>
					<script type="text/javascript">
						var link = localStorage.getItem('data_link')+"/print/invoice/<?php echo $acak; ?>";		
						window.open(link,'_blank');
					</script>
<?php
				}
?>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Hasilkan Tautan
							</h6>
						</div>
					</div>
				</div>
				<div class="app-card-body pb-3 main-content container-fluid" align="center" style="margin-top: 10%">
					<i class="bi bi-link size-icons-100"></i>
				</div>
<?php

		}

	}
?>