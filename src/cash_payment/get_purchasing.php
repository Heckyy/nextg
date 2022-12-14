<?php
	class get_purchasing{
		
		function view_get_purchasing($db,$e,$library_class,$view,$page){

			if($_SESSION['payment_for_purchasing']==1 && !empty($_SESSION['bank'])){

				$perPage = 10;

				if(!empty($_POST['cari'])){
					$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
				}else{
					$ubah_pencarian="";
				}


				$result = $db->select('tb_purchasing','number_purchasing LIKE "%'.$ubah_pencarian.'%" && status="1" && status_pembayaran="0" || note LIKE "%'.$ubah_pencarian.'%" && status="1" && status_pembayaran="0"','id_purchasing','DESC');

				$totalRecords = mysqli_num_rows($result);
				$totalPages = ceil($totalRecords/$perPage);

				$cek_error="";

				if($totalRecords==0){
					$cek_error='<tr><td colspan="6">Data not found!</td></tr>';
				}

				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

?>

			<script src="<?php echo $e; ?>/src/cash_payment/js/jsproses_purchasing.js"></script>
			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							Bank / Cash Payment <b>( <?php if(!empty($b['bank_cash'])) { echo $b['bank_cash']; } ?> )</b>
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
				<div class="col" align="right">
					<a href="<?php echo $e; ?>/cash-payment/new-pembayaran" class="btn btn-info btn-sm">
			           	Kembali
					</a>
				</div>
			</div>


			 <div class="app-card-body pb-3 main-content container-fluid">
			 	<div class="scroll">
					<table class="table mb-0">
					    <thead>
					        <tr>
					            <td width="50px" align="center">No</td>
					            <td width="130px">Number</td>
					            <td width="100px">Date</td>
					            <td width="250px">Pemasok</td>
					            <td>Total</td>
					            <td>Note</td>
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