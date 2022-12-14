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

			$data = $db->selectpage('tb_group_account INNER JOIN tb_type_of_account ON tb_group_account.id_group_account=tb_type_of_account.id_group_account','tb_type_of_account.type_of_account LIKE "%'.$ubah_pencarian.'%" || tb_group_account.group_account LIKE "%'.$ubah_pencarian.'%" || tb_group_account.position LIKE "%'.$ubah_pencarian.'%" || tb_group_account.type_of_report LIKE "%'.$ubah_pencarian.'%"','tb_type_of_account.type_of_account','ASC',$startFrom,$perPage,'tb_type_of_account.id_type_of_account,tb_type_of_account.type_of_account,tb_group_account.group_account,tb_group_account.position,tb_group_account.type_of_report');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['id_type_of_account']));

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"type_of_account":"'.$v["type_of_account"].'",';
					$rows.='"position":"'.$v["position"].'",';
					$rows.='"type_of_report":"'.$v["type_of_report"].'",'; 
					$rows.='"group_account":"'.$v["group_account"].'"}';

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
