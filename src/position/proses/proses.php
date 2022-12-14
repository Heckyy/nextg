<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['position_new']==1){
			if(!empty($_POST['code_position']) && !empty($_POST['position'])){

				$code_position=mysqli_real_escape_string($db->query, $_POST['code_position']);
				$position=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['position']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_position=str_replace(" ", "", strtoupper($code_position));
				$position=strtoupper($position);

				$cek=$db->select('tb_position','code_position="'.$code_position.'"','id_position','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_position','code_position="'.$code_position.'",position="'.$position.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_position));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['position_edit']==1){
			if(!empty($_POST['code_position']) && !empty($_POST['position'])){

				$code_position=mysqli_real_escape_string($db->query, $_POST['code_position']);
				$position=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['position']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_position=str_replace(" ", "", strtoupper($code_position));
				$position=strtoupper($position);

				$cek=$db->select('tb_position','code_position="'.$code_position.'"','id_position','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_position','position="'.$position.'",note="'.$note.'"','code_position="'.$code_position.'"');

					echo str_replace("=", "", base64_encode($code_position));

				}else{

					echo "1";

				}

			}
		}
	}

?>