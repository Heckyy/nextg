<?php
	session_start();

	if(!empty($_SESSION['id_employee']) && !empty($_POST['proses'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		if($_POST['proses']=='tarik_data'){


			$perPage = 10;
			if (isset($_POST['page'])) { 
				$page  = $_POST['page']; 
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


			$data = $db->selectpage('tb_warga','code_warga LIKE "%'.$ubah_pencarian.'%" && status<3 || name LIKE "%'.$ubah_pencarian.'%" && status<3 || kk LIKE "%'.$ubah_pencarian.'%" && status<3 || ktp LIKE "%'.$ubah_pencarian.'%" && status<3 || ktp LIKE "%'.$ubah_pencarian.'%" && status<3 || cluster LIKE "%'.$ubah_pencarian.'%" && status<3','code_warga','DESC',$startFrom,$perPage,'code_warga,house_number,name,hp,note,number_rt,cluster');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['code_warga']));


					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code":"'.$v['code_warga'].'",'; 
					$rows.='"name":"'.$v['name'].'",'; 
					$rows.='"cluster":"'.$v['cluster'].'",';
					$rows.='"number":"'.$v['number_rt'].'",';
					$rows.='"house_number":"'.$v['house_number'].'"}'; 

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
