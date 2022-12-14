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

			$data = $db->selectpage('tb_account','account_no LIKE "%'.$ubah_pencarian.'%" || account LIKE "%'.$ubah_pencarian.'%"','account_no','ASC',$startFrom,$perPage,'id_account,account_no,id_sub_account,id_sub_account_2,account,position,type_of_report,id_type_of_account');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$toa=mysqli_fetch_assoc($db->select('tb_type_of_account','id_type_of_account="'.$v['id_type_of_account'].'"','id_type_of_account','DESC'));
					$ga=mysqli_fetch_assoc($db->select('tb_group_account','id_group_account="'.$toa['id_group_account'].'"','id_group_account','DESC'));

					$ubah=str_replace("=", "", base64_encode($v['id_account']));

					if($v['id_sub_account']==0){
						$account_no=$v['account_no'];
					}else if($v['id_sub_account_2']>0){
						$account_no='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$v['account_no'];
					}else{
						$account_no='&nbsp;&nbsp;&nbsp;'.$v['account_no'];
					}

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"account_no":"'.$account_no.'",';
					$rows.='"account":"'.$v["account"].'",';
					$rows.='"position":"'.$v["position"].'",';
					$rows.='"type_of_report":"'.$v["type_of_report"].'",'; 
					$rows.='"type_of_account":"'.$toa["type_of_account"].'",'; 
					$rows.='"group_account":"'.$ga["group_account"].'"}'; 

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
