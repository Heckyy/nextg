<?php
	class error_page{
		
		function view_error_page($db,$e){
?>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Error Page
						</h6>
					</div>
				</div>
			</div>

			<div class="app-card-body pb-3 main-content container-fluid" align="center">
				<img src="<?php echo $e; ?>/assets/images/error_page.gif" style="width:30%; margin-top: 7%;">
			</div>
<?php
		}

	}
?>