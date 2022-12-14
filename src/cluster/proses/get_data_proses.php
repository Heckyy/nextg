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

			$data = $db->selectpage('tb_cluster','code_cluster LIKE "%'.$ubah_pencarian.'%" || cluster LIKE "%'.$ubah_pencarian.'%" || address LIKE "%'.$ubah_pencarian.'%"','cluster','ASC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['code_cluster']));

					$the_land_price=0;
					$building_price=0;
					$macro_price=0;
					$empty_land=0;
					
					if($v['the_land_price']>0){
						$the_land_price=$v['the_land_price'];
					}
					if($v['building_price']>0){
						$building_price=$v['building_price'];
					}
					if($v['macro_price']>0){
						$macro_price=$v['macro_price'];
					}
					if($v['empty_land']>0){
						$empty_land=$v['empty_land'];
					}



					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code_cluster":"'.$v["code_cluster"].'",';
					$rows.='"cluster":"'.$v["cluster"].'",'; 
					$rows.='"the_land_price":"'.number_format($the_land_price,2,',','.').'",';
					$rows.='"building_price":"'.number_format($building_price,2,',','.').'",';
					$rows.='"macro_price":"'.number_format($macro_price,2,',','.').'",';
					$rows.='"empty_land":"'.number_format($empty_land,2,',','.').'"}';

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
