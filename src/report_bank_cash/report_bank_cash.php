<?php
	class report_bank_cash{
		
		function view_report_bank_cash($db,$e,$library_class,$view,$page){

			if($_SESSION['report_bank_cash']==1){
				
				$bank = $db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
				
				$b=mysqli_fetch_assoc($bank);

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}

				if(!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['bank'])){
					$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
					$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);
					$select_bank=mysqli_real_escape_string($db->query, $_POST['bank']);

					if($select_bulan<10){
						$select_bulan="0".$select_bulan;
					}

					$priod=$select_tahun.'-'.$select_bulan;
					
				}else{

					$select_tahun=$library_class->tahun();
					$select_bulan=$library_class->bulan();	
					$priod=$select_tahun.'-'.$select_bulan;

					if(!empty($_SESSION['bank'])){
						$select_bank=$_SESSION['bank'];
					}else{
						$select_bank=$b['id_bank_cash'];
					}
				}



				$_SESSION['bank'] = $select_bank;


					$bank_name = $db->select('tb_bank_cash','id_bank_cash="'.$select_bank.'"','bank_cash','ASC');
					$bn=mysqli_fetch_assoc($bank_name);
					$select_bank='id_bank="'.$select_bank.'" && ';
									

				$result = $db->select('tb_cash_receipt_payment',$select_bank.'tanggal LIKE "%'.$priod.'%" && number LIKE "%'.$ubah_pencarian.'%" && status="1" || '.$select_bank.'tanggal LIKE "%'.$priod.'%" && dari LIKE "%'.$ubah_pencarian.'%" && status="1" || '.$select_bank.'tanggal LIKE "%'.$priod.'%" && type_of_receipt LIKE "%'.$ubah_pencarian.'%" && status="1"','id_cash_receipt_payment','DESC');

				$totalRecords = mysqli_num_rows($result);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="7">Data not found!</td></tr>';
				}

				$bulan=array('','January','February','March','April','May','June','July','August','September','October','November','December');
				$tahun=$library_class->tahun();

?>

				<script src="<?php echo $e; ?>/src/report_bank_cash/js/jsproses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Report Bank / Cash
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
						                        <select id="bank" name="bank" class="form-control search-input bg-white" style="width: 100px">
						                    		<?php
						                    			foreach ($bank as $key => $bk) {

						                    				$access_bank=$db->select('tb_access_bank','id_bank_cash="'.$bk['id_bank_cash'].'" && id_employee="'.$_SESSION['id_employee'].'"','id_access_bank','DESC');
						                    				if(mysqli_num_rows($access_bank)>0){
						                    		?>

							                    				<option value="<?php echo $bk['id_bank_cash']; ?>" <?php if($bk['id_bank_cash']==$select_bank){ echo "selected"; } ?>>
							                    					<?php echo $bk['bank_cash']; ?>
							                    				</option>

						                    		<?php
						                    				}
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
						                    <div class="col-auto" style="display: none">
												<button class="btn btn-primary" onclick="print_transaction()">
													Cetak
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
						            <td width="150px">Number</td>
						            <td width="200px">Tipe Transaksi</td>
						            <td width="200px">Dari / Untuk</td>
						            <td>Bank / Cash</td>
						            <td>Pemasukan</td>
						            <td>Pembayaran</td>
						            <td>Nominal</td>
						        </tr>
						    </thead>
						    <tbody id="data_view"><?php echo $cek_error; ?></tbody>
						</table>
					</div>
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