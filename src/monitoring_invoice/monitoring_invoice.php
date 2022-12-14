<?php
	class monitoring_invoice{
		
		function view_monitoring_invoice($db,$e,$library_class,$view,$page){

			if($_SESSION['monitoring_invoice']==1){

				$perPage = 10;

				$dues_type = $db->select('tb_dues','id_dues','dues_type','ASC');
				$b=mysqli_fetch_assoc($dues_type);

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}

				if(!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['dues_type'])){
					$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
					$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);
					$select_dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
					$select_dues_type_pilih=mysqli_real_escape_string($db->query, $_POST['dues_type']);

					if($select_bulan<10){
						$select_bulan="0".$select_bulan;
					}

					$priod=$select_tahun.'-'.$select_bulan;
					
				}else{

					$select_tahun=$library_class->tahun();
					$select_bulan=$library_class->bulan();	
					$priod=$select_tahun.'-'.$select_bulan;

					if(!empty($_SESSION['dues_type'])){
						$select_dues_type=$_SESSION['dues_type'];
					}else{
						$select_dues_type="all";
					}
				}

				if($select_dues_type=='all'){
					$select_dues_type_query='';
					$select_dues_type_pilih='all';
				}else{
					$select_dues_type_pilih=$select_dues_type;
					$select_dues_type_query=' && tb_invoice.id_dues="'.$select_dues_type.'"';
				}


				$_SESSION['dues_type'] = $select_dues_type;

				$result = $db->select('tb_invoice INNER JOIN tb_warga ON tb_invoice.id_warga=tb_warga.id_warga INNER JOIN tb_dues ON tb_invoice.id_dues=tb_dues.id_dues','tb_invoice.number_invoice LIKE "%'.$ubah_pencarian.'%" && tb_invoice.status_pembayaran="0" && tb_invoice.status="1" && tb_warga.type="0"'.$select_dues_type_query.' || tb_warga.name LIKE "%'.$ubah_pencarian.'%" && tb_invoice.status_pembayaran="0" && tb_invoice.status="1" && tb_warga.type="0"'.$select_dues_type_query,'tb_invoice.id_invoice','DESC');


				$totalRecords = mysqli_num_rows($result);
				$totalPages = ceil($totalRecords/$perPage);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="8">Data not found!</td></tr>';
				}

				$bulan=array('','January','February','March','April','May','June','July','August','September','October','November','December');
				$tahun=$library_class->tahun();
?>

				<script src="<?php echo $e; ?>/src/monitoring_invoice/js/jsproses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Pemantauan Tagihan
							</h6>
						</div>
					    <div class="col-auto">
						     <div class="page-utilities">
							    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								    <div class="col-auto">
									    <form class="table-search-form row gx-1 align-items-center" id="search" method="POST">
						                    <div class="col-auto">
						                    	<select id="bulan" name="bulan" class="form-control search-input bg-white">
						                    		<?php
						                    			for($i=1; $i<=12; $i++){
						                    		?>

						                    				<option value="<?php echo $i; ?>" <?php if($i==$select_bulan){ echo "selected"; } ?>>
						                    					<?php echo $bulan[$i]; ?>
						                    				</option>

						                    		<?php
						                    			}
						                    		?>
						                    	</select>
						                    </div>
						                    <div class="col-auto">
						                        <select id="tahun" name="tahun" class="form-control search-input bg-white" style="width: 100px">
						                    		<?php
						                    			for($i=$tahun; $i>=2010; $i--){
						                    		?>

						                    				<option value="<?php echo $i; ?>" <?php if($i==$select_tahun){ echo "selected"; } ?>>
						                    					<?php echo $i; ?>
						                    				</option>

						                    		<?php
						                    			}
						                    		?>					                    	
						                    	</select>
						                    </div>
						                    <div class="col-auto">
						                        <select id="dues_type" name="dues_type" class="form-control search-input bg-white" style="width: 150px">
						                        	<option value="all">Select All</option>
						                    		<?php
						                    			foreach ($dues_type as $key => $bk) {
						                    		?>

						                    				<option value="<?php echo $bk['id_dues']; ?>" <?php if($bk['id_dues']==$select_dues_type_pilih){ echo "selected"; } ?>>
						                    					<?php echo $bk['dues_type']; ?>
						                    				</option>

						                    		<?php
						                    			}
						                    		?>					                    	
						                    	</select>
						                    </div>
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
				</div>


				 <div class="app-card-body pb-3 main-content container-fluid">
				 	<div class="scroll">
						<table class="table mb-0">
						    <thead>
						        <tr>
						            <td width="50px" align="center">No</td>
						            <td width="50%">Tagihan</td>
						            <td width="50%">Keuangan</td>
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