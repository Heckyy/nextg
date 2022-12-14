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


			$data = $db->selectpage('tb_population','code_population LIKE "%'.$ubah_pencarian.'%" && status<3 || name LIKE "%'.$ubah_pencarian.'%" && status<3 || kk LIKE "%'.$ubah_pencarian.'%" && status<3 || ktp LIKE "%'.$ubah_pencarian.'%" && status<3 || cluster LIKE "%'.$ubah_pencarian.'%" && status<3','code_population','DESC',$startFrom,$perPage,'code_population,id_cluster,house_number,name,hp,note,number_rt,cluster,surface_area,building_area,type_property');

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','id_cluster','DESC');
					$c=mysqli_fetch_assoc($cluster);

					$ubah=str_replace("=", "", base64_encode($v['code_population']));

					if($v['type_property']==1){
						$type_property='House';
					}else{
						$type_property='Kavling';
					}

					$data_cluster=$c['code_cluster'].'/'.$v['house_number'];

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code":"'.$v['code_population'].'",'; 
					$rows.='"name":"'.$v['name'].'",'; 
					$rows.='"cluster":"'.$data_cluster.'",';
					$rows.='"number_rt":"'.$v['number_rt'].'/05",';
					$rows.='"house_number":"'.$v['house_number'].'",';
					$rows.='"surface_area":"'.$v['surface_area'].'",'; 
					$rows.='"building_area":"'.$v['building_area'].'",'; 
					$rows.='"type_property":"'.$type_property.'"}'; 


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
