<?php
	session_start();

	if(!empty($_SESSION['id_employee']) && !empty($_POST['proses'])){
		include_once "./../../../core/file/function_proses.php";
		include_once "./../../../core/file/library.php";
		$db = new db();
		$library_class = new library_class();

		if($_POST['proses']=='tarik_data'){


			$perPage = 10;
			if (isset($_POST["page"])) { 
				$page  = $_POST["page"]; 
			} else { 
				$page=1; 
			};  
			$startFrom = ($page-1) * $perPage;  

			$e=mysqli_fetch_assoc($db->select('tb_settings','id_settings','id_settings','DESC'));

			$bank = $db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
			$b=mysqli_fetch_assoc($bank);


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


			$data = $db->selectpage('tb_invoice INNER JOIN tb_population ON tb_invoice.id_population=tb_population.id_population INNER JOIN tb_dues ON tb_invoice.id_dues=tb_dues.id_dues','tb_invoice.number_invoice LIKE "%'.$ubah_pencarian.'%" && tb_invoice.tanggal LIKE "%'.$priod.'%" && tb_population.type="0"'.$select_dues_type_query.' || tb_population.name LIKE "%'.$ubah_pencarian.'%" && tb_invoice.tanggal LIKE "%'.$priod.'%" && tb_population.type="0"'.$select_dues_type_query,'tb_invoice.id_invoice','DESC',$startFrom,$perPage,'tb_invoice.number_invoice,tb_invoice.tanggal,tb_invoice.amount,tb_invoice.status,tb_invoice.note,tb_population.name,tb_population.id_rt,tb_population.type,tb_dues.dues_type');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$cluster=$db->select('tb_cluster INNER JOIN tb_rt ON tb_cluster.id_cluster=tb_rt.id_cluster','tb_rt.id_rt="'.$v['id_rt'].'"','tb_cluster.id_cluster','DESC');
					$c=mysqli_fetch_assoc($cluster);

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;

						if($v['status']=='1'){
							$status ="<i class='bi bi-check2-square'></i>";
						}else if($v['status']=='2'){
							$status ="<i class='bi bi-x-square'></i>";
						}else{
							$status ="<div class='spinner-border spinner-border-sm' role='status'></div>";
						}


					$tanggal_invoice=substr($v['tanggal'], 8,2);
					$bulan_invoice=substr($v['tanggal'], 5,2);
					$tahun_invoice=substr($v['tanggal'], 0,4);
					$date_invoice=$tanggal_invoice."-".$bulan_invoice."-".$tahun_invoice;

					$invoice='<b>'.$v['number_invoice'].'</b><br>Date : '.$date_invoice.'<br>Population : '.$v['name'].'<br>dues : '.$v['dues_type'].'<br>Rp.'.number_format($v['amount'],2,',','.').'<br>Status : '.$status;

					$finance='';

					$finance_data = $db->select('tb_cash_receipt_payment','number_invoice="'.$v['number_invoice'].'" && status="1"','id_cash_receipt_payment','DESC');
					if(mysqli_num_rows($finance_data)>0){

						foreach ($finance_data as $key => $fd) {

							if($fd['status']=='1'){
								$status_finance ="<i class='bi bi-check2-square'></i>";
							}else if($fd['status']=='2'){
								$status_finance ="<i class='bi bi-x-square'></i>";
							}else{
								$status_finance ="<div class='spinner-border spinner-border-sm' role='status'></div>";
							}

							$tanggal_finance=substr($fd['tanggal'], 8,2);
							$bulan_finance=substr($fd['tanggal'], 5,2);
							$tahun_finance=substr($v['tanggal'], 0,4);
							$date_finance=$tanggal_finance."-".$bulan_finance."-".$tahun_finance;

							$div="<div class='col-auto'>";

							$finance=$finance.$div.'<b>'.$fd['number'].'</b><br>Date : '.$date_finance.'<br>Rp.'.number_format($fd['amount'],2,',','.').'<br>Status : '.$status_finance.'</div>';
						}
					}else{
						$finance='-';
					}

					$rows.='{"no":"'.$no.'",';
					$rows.='"invoice":"'.$invoice.'",';
					$rows.='"finance":"'.$finance.'"}';

					$no++;

					if($i<$jum){
						$rows .= ",";
						$i++;
					}
				}

				$rows = $rows.']';

				echo $rows;

			}
		}

	}
?>
