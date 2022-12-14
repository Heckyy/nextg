<?php
	class account{
		
		function view_account($db,$e,$library_class,$view,$page){

			if($_SESSION['account']==1){
				$perPage = 10;

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}

				$result = $db->select('tb_account','account_no LIKE "%'.$ubah_pencarian.'%" || account LIKE "%'.$ubah_pencarian.'%"','account','ASC');

				$totalRecords = mysqli_num_rows($result);
				$totalPages = ceil($totalRecords/$perPage);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="7">Data not found!</td></tr>';
				}

?>

				<script src="<?php echo $e; ?>/src/account/js/jsproses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Akun
							</h6>
						</div>
					    <div class="col-auto">
						     <div class="page-utilities">
							    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								    <div class="col-auto">
									    <form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
						                    <div class="col-auto">
						                        <input type="text" id="cari" name="cari" value="<?php echo $ubah_pencarian; ?>" class="form-control search-input" placeholder="Search">
						                    </div>
						                    <div class="col-auto">
						                        <button type="submit" class="btn btn-success">
						                        	<i class="bi bi-search"></i>
						                        </button>
						                    </div>		                    
						                </form>						                
								    </div>
								</div>
						    </div>
						</div>
					</div>
					<?php
						if($_SESSION['account_new']==1 || $_SESSION['group_account']==1 || $_SESSION['type_of_account']==1 || $_SESSION['setting_account']==1){
					?>
							<div class="col" align="right">
								<?php
									if($_SESSION['group_account']==1){
								?>
										<a href="<?php echo $e; ?>/account/group-account" class="btn btn-default btn-sm link-new">
								           	Kelompok Akun
										</a>
								<?php
									}
									if($_SESSION['type_of_account']==1){
								?>
										<a href="<?php echo $e; ?>/account/type-of-account" class="btn btn-default btn-sm link-new">
								        	Tipe Akun
										</a>
								<?php
									}
									if($_SESSION['setting_account']==1){
								?>
										<a href="#" class="btn btn-default btn-sm link-new" data-bs-toggle="modal" data-bs-target="#setting_account">
								           	Setting Akun
										</a>
								<?php
									}
									if($_SESSION['account_new']==1){
								?>
										<a href="<?php echo $e; ?>/account/new" class="btn btn-default btn-sm link-new">
								           	New
										</a>
								<?php
									}
								?>
							</div>
					<?php
						}
					?>
				</div>


				 <div class="app-card-body pb-3 main-content container-fluid">
				 	<div class="scroll">
						<table class="table mb-0">
						    <thead>
						        <tr>
						            <td width="150px">Nomor Akun</td>
						            <td>Akun</td>
						            <td>Posisi</td>
						            <td>Tipe Laporan</td>
						            <td>Tipe Akun</td>
						            <td>Kelompok Akun</td>
						        </tr>
						    </thead>
						    <tbody id="data_view"><?php echo $cek_error; ?></tbody>
						</table>
					</div>
				</div>

				<input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">

				<div class="row">
					<div id="pagination"></div>    
				</div>   
<?php
				if($_SESSION['setting_account']==1){
?>
					<div class="modal fade" id="setting_account" tabindex="-1" aria-labelledby="setting_accountLabel" aria-hidden="true">
					  	<div class="modal-dialog">
					    	<div class="modal-content">
					      		<div class="modal-header">
					        		<h5 class="modal-title" id="setting_accountLabel">Setting Account</h5>
					        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      		</div>
							      	<div class="modal-body">
							      		<table class="table">
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Purchasing</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/pcg/purchasing" style="width: 100%; float: left;">
							      						Purchasing
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Finance</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/fn/type-of-receipt" style="width: 100%; float: left;">
							      						Type of Receipt
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/fn/type-of-payment" style="width: 100%; float: left;">
							      						Type of Payment
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="background-color: #FFFFFF; pointer-events: none;">
							      					<b>Warehouse</b>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/wh/type-of-receipt" style="width: 100%; float: left;">
							      						Type of Receipt
							      					</a>
							      				</td>
							      			</tr>
							      			<tr>
							      				<td style="padding-left: 30px;">
							      					<a href="<?php echo $e; ?>/account/wh/type-of-out" style="width: 100%; float: left;">
							      						Type of Out
							      					</a>
							      				</td>
							      			</tr>
							      		</table>
							      	</div>
					    	</div>
					  	</div>
					</div>
<?php
				}
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