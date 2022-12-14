<?php
	session_start();

	if(!empty($_SESSION['id_employee']) && !empty($_POST['proses'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

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

			$data = $db->selectpage('tb_type_of_receipt_wh','code_type_of_receipt_wh LIKE "%'.$ubah_pencarian.'%" || type_of_receipt_wh LIKE "%'.$ubah_pencarian.'%"','code_type_of_receipt_wh','ASC',$startFrom,$perPage,'id_type_of_receipt_wh,code_type_of_receipt_wh,type_of_receipt_wh,note');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['code_type_of_receipt_wh']));

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code_type_of_receipt_wh":"'.$v["code_type_of_receipt_wh"].'",';
					$rows.='"type_of_receipt_wh":"'.$v["type_of_receipt_wh"].'",';
					$rows.='"note":"'.$v["note"].'"}'; 

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
