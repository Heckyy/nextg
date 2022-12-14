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

			$data = $db->selectpage('tb_house_size','code_house_size LIKE "%'.$ubah_pencarian.'%" || house_size LIKE "%'.$ubah_pencarian.'%"','code_house_size','ASC',$startFrom,$perPage,'id_house_size,code_house_size,house_size,amount_meter,amount,note');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['code_house_size']));

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code_house_size":"'.$v["code_house_size"].'",';
					$rows.='"house_size":"'.$v["house_size"].'",';
					$rows.='"amount_meter":"Rp.'.number_format($v['amount_meter'],0,',','.').'",';
					$rows.='"amount":"Rp.'.number_format($v['amount'],2,',','.').'",';
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
