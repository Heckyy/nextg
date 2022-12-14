<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['warehouse_new']==1){
			if(!empty($_POST['code_warehouse']) && !empty($_POST['warehouse'])){

				$code_warehouse=mysqli_real_escape_string($db->query, $_POST['code_warehouse']);
				$warehouse=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['warehouse']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_warehouse=str_replace(" ", "", strtoupper($code_warehouse));
				$warehouse=strtoupper($warehouse);

				$cek=$db->select('tb_warehouse','code_warehouse="'.$code_warehouse.'"','id_warehouse','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_warehouse','code_warehouse="'.$code_warehouse.'",warehouse="'.$warehouse.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_warehouse));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['warehouse_edit']==1){
			if(!empty($_POST['code_warehouse']) && !empty($_POST['warehouse'])){

				$code_warehouse=mysqli_real_escape_string($db->query, $_POST['code_warehouse']);
				$warehouse=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['warehouse']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_warehouse=str_replace(" ", "", strtoupper($code_warehouse));
				$warehouse=strtoupper($warehouse);

				$cek=$db->select('tb_warehouse','code_warehouse="'.$code_warehouse.'"','id_warehouse','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_warehouse','warehouse="'.$warehouse.'",note="'.$note.'"','code_warehouse="'.$code_warehouse.'"');

					echo str_replace("=", "", base64_encode($code_warehouse));

				}else{

					echo "1";

				}

			}
		}
	}

?>