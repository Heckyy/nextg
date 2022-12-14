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

			if(!empty($_POST['bulan']) && !empty($_POST['tahun'])){
				$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
				$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);

				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}

				$priod=$select_tahun.'-'.$select_bulan;
			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;

			}



			$data = $db->selectpage('tb_purchasing','type_of_purchase="2" && number_purchasing LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || type_of_purchase="2" && note LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%"','id_purchasing','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number_purchasing']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;


					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"number":"'.$v["number_purchasing"].'",';
					$rows.='"supplier":"'.$v["supplier"].'",';
					$rows.='"number_request":"'.$v["number_request"].'",';
					$rows.='"cluster":"'.$v["cluster"].'",';
					$rows.='"position":"'.$v["position"].'",';
					$rows.='"tanggal":"'.$date.'",';
					$rows.='"total":"'.number_format($v["total"],2,',','.').'",';
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
