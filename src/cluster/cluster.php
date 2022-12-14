<?php
	class cluster{
		function view_cluster($db,$e,$view,$page){

			if($_SESSION['cluster']==1){

				$perPage = 10;

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}

				$result = $db->select('tb_cluster','code_cluster LIKE "%'.$ubah_pencarian.'%" || cluster LIKE "%'.$ubah_pencarian.'%" || address LIKE "%'.$ubah_pencarian.'%"','cluster','ASC','code_cluster,cluster,address,note');

				$totalRecords = mysqli_num_rows($result);
				$totalPages = ceil($totalRecords/$perPage);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="5">Data not found!</td></tr>';
				}

?>

				<script src="<?php echo $e; ?>/src/cluster/js/jsproses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Cluster
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
						if($_SESSION['cluster_new']==1){
					?>
							<div class="col" align="right">
								<a href="<?php echo $e; ?>/cluster/new" class="btn btn-default btn-sm link-new">
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
						            <td width="100px">Code</td>
						            <td width="250px">Cluster</td>
						            <td width="150px" align="right">Tanah</td>
						            <td width="150px" align="right">Bangunan</td>
						            <td width="150px" align="right">Makro</td>
						            <td width="100px" align="right">Tanah Kosong</td>
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