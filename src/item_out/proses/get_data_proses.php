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

			$warehouse = $db->select('tb_warehouse','id_warehouse','warehouse','ASC');
			$w=mysqli_fetch_assoc($warehouse);


				if(!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['warehouse'])){
					$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
					$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);
					$select_warehouse=mysqli_real_escape_string($db->query, $_POST['warehouse']);

					if($select_bulan<10){
						$select_bulan="0".$select_bulan;
					}

					$priod=$select_tahun.'-'.$select_bulan;
					
				}else{

					$select_tahun=$library_class->tahun();
					$select_bulan=$library_class->bulan();	
					$priod=$select_tahun.'-'.$select_bulan;

					if(!empty($_SESSION['warehouse'])){
						$select_warehouse=$_SESSION['warehouse'];
					}else{
						if(!empty($w['warehouse'])){
							$select_warehouse=$w['warehouse'];
						}else{
							$select_warehouse="";
						}
					}
				}


			$data = $db->selectpage('tb_item_receipt_out','number_item_receipt_out LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && type_transaction="o" && id_warehouse="'.$select_warehouse.'" || from_for LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && type_transaction="o" && id_warehouse="'.$select_warehouse.'" || type_receipt_out LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && type_transaction="o" && id_warehouse="'.$select_warehouse.'" || note LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && type_transaction="o" && id_warehouse="'.$select_warehouse.'"','id_item_receipt_out','DESC',$startFrom,$perPage);


			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number_item_receipt_out']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;


					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"number":"'.$v["number_item_receipt_out"].'",';
					$rows.='"type_receipt_out":"'.$v['type_receipt_out'].'",';
					$rows.='"from_for":"'.$v['from_for'].'",';
					$rows.='"tanggal":"'.$date.'",';
					$rows.='"note":"'.$v["note"].'",';
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
?>
