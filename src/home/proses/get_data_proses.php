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

			$data = $db->selectpage_app('tb_report','id_report','id_report','DESC',$startFrom,$perPage,'id_report,category,no_ticket,date_post,time_post,id_user,description,additional_location,status');
			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['id_report']));

					$hitung_description=strlen($v["description"]);
					$hitung_additional_location=strlen($v["additional_location"]);

					$titik_description="";
					$titik_additional_location="";

					if($hitung_description>35){
						$titik_description="...";
					}

					if($hitung_additional_location>35){
						$titik_additional_location="...";
					}

					$description = substr($v["description"],0,35);
					$additional_location = substr($v["additional_location"],0,35);

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"no_ticket":"'.$v["no_ticket"].'",';
					$rows.='"category":"'.$v["category"].'",';
					$rows.='"waktu":"'.$v["date_post"].' <br> '.$v["time_post"].'",';
					$rows.='"nama":"'.$v["id_user"].'",';
					$rows.='"description":"'.$description.$titik_description.'",';
					$rows.='"additional_location":"'.$additional_location.$titik_additional_location.'",';
					$rows.='"status":"'.$v["status"].'"}'; 

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
