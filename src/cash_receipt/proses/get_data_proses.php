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


			if(!empty($_POST['cari'])){
				$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			}else{
				$ubah_pencarian="";
			}

			if(!empty($_POST['bulan']) && !empty($_POST['tahun'])){
				$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
				$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);

				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}

				$priod=$select_tahun.'-'.$select_bulan;
			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;
			}



			$data = $db->selectpage('tb_cash_receipt_payment','number LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && id_bank="'.$_SESSION['bank'].'" && type="i" || type_of_receipt  LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && id_bank="'.$_SESSION['bank'].'" && type="i"','id_cash_receipt_payment','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number']));


					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;

					if(!empty($v['tanggal_bank'])){
						$tanggal_bank=substr($v['tanggal_bank'], 8,2);
						$bulan_bank=substr($v['tanggal_bank'], 5,2);
						$tahun_bank=substr($v['tanggal_bank'], 0,4);
						$date_bank=$tanggal_bank."-".$bulan_bank."-".$tahun_bank;
					}else{
						$date_bank="";
					}

					if(!empty($v['account_number'])){
						$account_number=' - ('.$v['account_number'].')';
					}else{
						$account_number="";
					}

					if(!empty($v['number_invoice'])){
						$target_folder="view-invoice";
					}else if(!empty($v['priod'])){
						$target_folder="view-ipl";
					}else{
						$target_folder="view";						
					}

					$get_cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','id_cluster','DESC');
					if(mysqli_num_rows($get_cluster)>0){
						$gc=mysqli_fetch_assoc($get_cluster);
						$cluster=$gc['code_cluster'];
					}else{
						$cluster="";
					}

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"target_folder":"'.$target_folder.'",';
					$rows.='"number":"'.$v["number"].'",';
					$rows.='"Date":"'.$date.'",';
					$rows.='"cluster":"'.$cluster.'",';
					$rows.='"dari":"'.$v["dari"].'",';
					$rows.='"account_name":"'.$v["account_name"].''.$account_number.'",';
					$rows.='"amount":"'.number_format($v["amount"],2,',','.').'",';
					$rows.='"bd":"'.$date_bank.'",';
					$rows.='"status":"'.$v['status'].'"}'; 

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
