<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['unit_new']==1){
			if(!empty($_POST['code_unit']) && !empty($_POST['unit'])){

				$code_unit=mysqli_real_escape_string($db->query, $_POST['code_unit']);
				$unit=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['unit']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_unit=str_replace(" ", "", strtoupper($code_unit));
				$unit=strtoupper($unit);

				$cek=$db->select('tb_unit','code_unit="'.$code_unit.'"','id_unit','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_unit','code_unit="'.$code_unit.'",unit="'.$unit.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_unit));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['unit_edit']==1){
			if(!empty($_POST['code_unit']) && !empty($_POST['unit'])){

				$code_unit=mysqli_real_escape_string($db->query, $_POST['code_unit']);
				$unit=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['unit']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_unit=str_replace(" ", "", strtoupper($code_unit));
				$unit=strtoupper($unit);

				$cek=$db->select('tb_unit','code_unit="'.$code_unit.'"','id_unit','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_unit','unit="'.$unit.'",note="'.$note.'"','code_unit="'.$code_unit.'"');

					echo str_replace("=", "", base64_encode($code_unit));

				}else{

					echo "1";

				}

			}
		}
	}

?>