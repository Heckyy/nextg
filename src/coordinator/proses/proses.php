<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['coordinator_new']==1){
			if(!empty($_POST['code_coordinator']) && !empty($_POST['coordinator'])){

				$code_coordinator=mysqli_real_escape_string($db->query, $_POST['code_coordinator']);
				$coordinator=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['coordinator']));
				$contractor=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['contractor']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_coordinator=str_replace(" ", "", strtoupper($code_coordinator));
				$coordinator=strtoupper($coordinator);

				$cek=$db->select('tb_coordinator','code_coordinator="'.$code_coordinator.'"','id_coordinator','DESC');
				$employee=$db->select('tb_employee','id_employee="'.$coordinator.'"','id_employee','DESC');
				$ep=mysqli_fetch_assoc($employee);

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_coordinator','code_coordinator="'.$code_coordinator.'",id_employee="'.$coordinator.'",coordinator="'.$ep['name'].'",note="'.$note.'"');
					$db->insert('tb_coordinator_detail','code_coordinator="'.$code_coordinator.'",id_contractor="'.$contractor.'"');

					echo str_replace("=", "", base64_encode($code_coordinator));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['coordinator_edit']==1){
			if(!empty($_POST['code_coordinator']) && !empty($_POST['coordinator'])){

				$code_coordinator=mysqli_real_escape_string($db->query, $_POST['code_coordinator']);
				$coordinator=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['coordinator']));
				$contractor=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['contractor']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_coordinator=str_replace(" ", "", strtoupper($code_coordinator));
				$coordinator=strtoupper($coordinator);

				$cek=$db->select('tb_coordinator','code_coordinator="'.$code_coordinator.'"','id_coordinator','DESC');
				$cek_detail=$db->select('tb_coordinator_detail','code_coordinator="'.$code_coordinator.'" && id_contractor="'.$contractor.'"','id_coordinator_detail','DESC');
				$employee=$db->select('tb_employee','id_employee="'.$coordinator.'"','id_employee','DESC');
				$ep=mysqli_fetch_assoc($employee);

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_coordinator','id_employee="'.$coordinator.'",coordinator="'.$ep['name'].'",note="'.$note.'"','code_coordinator="'.$code_coordinator.'"');

					if(mysqli_num_rows($cek_detail)==0){
						$db->insert('tb_coordinator_detail','code_coordinator="'.$code_coordinator.'",id_contractor="'.$contractor.'"');
					}


					echo str_replace("=", "", base64_encode($code_coordinator));

				}else{

					echo "1";

				}

			}
		}else if($proses=='hapus' && $_SESSION['coordinator_edit']==1){

			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

			$cek=$db->select('tb_coordinator_detail','id_coordinator_detail="'.$id.'"','id_coordinator_detail','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$d=mysqli_fetch_assoc($cek);
				$db->hapus('tb_coordinator_detail','id_coordinator_detail="'.$id.'"');
				echo str_replace("=", "", base64_encode($d['code_coordinator']));
			}

		}
	}

?>