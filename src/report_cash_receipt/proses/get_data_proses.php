<?php
	error_reporting(0);
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

			$data = $db->selectpage('tb_cash_receipt_payment','id_bank="'.$select_bank.'" && tanggal LIKE "%'.$priod.'%" && number LIKE "%'.$ubah_pencarian.'%" && type="i" && status="1" || id_bank="'.$select_bank.'" && tanggal LIKE "%'.$priod.'%" && dari LIKE "%'.$ubah_pencarian.'%" && type="i" && status="1" || id_bank="'.$select_bank.'" && tanggal LIKE "%'.$priod.'%" && type_of_receipt LIKE "%'.$ubah_pencarian.'%" && type="i" && status="1"','id_cash_receipt_payment','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$rows.='{"no":"'.$no.'",';
					$rows.='"number":"'.$v["number"].'",';
					$rows.='"type_of_receipt":"'.$v["type_of_receipt"].'",';
					$rows.='"untuk":"'.$v["dari"].'",';
					$rows.='"amount":"Rp.'.number_format($v['amount'],2,',','.').'"}';

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
