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

			$data = $db->selectpage('tb_rt','number LIKE "%'.$ubah_pencarian.'%" || name_rt LIKE "%'.$ubah_pencarian.'%" || name_representative LIKE "%'.$ubah_pencarian.'%"','code_rt','ASC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$cluster=$db->select('tb_cluster','id_cluster="'.$v['id_cluster'].'"','id_cluster','DESC');
					$c=mysqli_fetch_assoc($cluster);

					$data_cluster=$c['code_cluster'].' - '.$v['cluster'];

					$ubah=str_replace("=", "", base64_encode($v['code_rt']));

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"code":"'.$v["code_rt"].'",';
					$rows.='"number":"'.$v["number"].'",';
					$rows.='"cluster":"'.$data_cluster.'",';
					$rows.='"name":"'.$v["name_rt"].'",'; 
					$rows.='"name_representative":"'.$v["name_representative"].'",';
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
