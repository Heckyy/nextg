<?php
	class population{
		function view_population($db,$e,$library_class,$view,$page){

			if($_SESSION['population']==1){

				$perPage = 10;

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}

				$result = $db->select('tb_warga','code_warga LIKE "%'.$ubah_pencarian.'%" && status<3 || name LIKE "%'.$ubah_pencarian.'%" && status<3 || kk LIKE "%'.$ubah_pencarian.'%" && status<3 || ktp LIKE "%'.$ubah_pencarian.'%" && status<3 || ktp LIKE "%'.$ubah_pencarian.'%" && status<3 || cluster LIKE "%'.$ubah_pencarian.'%" && status<3','code_warga','DESC');

				$totalRecords = mysqli_num_rows($result);
				$totalPages = ceil($totalRecords/$perPage);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="6">Data not found!</td></tr>';
				}
?>
				<script src="<?php echo $e; ?>/src/population/js/jsproses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Warga
							</h6>
						</div>
					    <div class="col-auto">
						     <div class="page-utilities">
							    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								    <div class="col-auto">
									    <form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
						                    <div class="col-auto">
						                        <input type="text" id="cari" name="cari" class="form-control search-input" value="<?php echo $ubah_pencarian; ?>" placeholder="Search">
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
						if($_SESSION['population_new']==1){
					?>
							<div class="col" align="right">
								<a href="<?php echo $e; ?>/population/new" class="btn btn-default btn-sm link-new">
						           	New
								</a>
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
						            <td width="50px" align="center">No</td>
						            <td>Code</td>
						            <td>Name</td>
						            <td>Cluster</td>
						            <td>RT</td>
						            <td>Number</td>
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