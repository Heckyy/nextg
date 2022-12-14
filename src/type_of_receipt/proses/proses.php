<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['type_of_receipt_new']==1){
			if(!empty($_POST['code_type_of_receipt']) && !empty($_POST['type_of_receipt'])){

				$code_type_of_receipt=mysqli_real_escape_string($db->query, $_POST['code_type_of_receipt']);
				$type_of_receipt=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_receipt']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_type_of_receipt=str_replace(" ", "", strtoupper($code_type_of_receipt));
				$type_of_receipt=strtoupper($type_of_receipt);

				$cek=$db->select('tb_type_of_receipt','code_type_of_receipt="'.$code_type_of_receipt.'"','id_type_of_receipt','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_type_of_receipt','code_type_of_receipt="'.$code_type_of_receipt.'",type_of_receipt="'.$type_of_receipt.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_type_of_receipt));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['type_of_receipt_edit']==1){
			if(!empty($_POST['code_type_of_receipt']) && !empty($_POST['type_of_receipt'])){

				$code_type_of_receipt=mysqli_real_escape_string($db->query, $_POST['code_type_of_receipt']);
				$type_of_receipt=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_receipt']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_type_of_receipt=str_replace(" ", "", strtoupper($code_type_of_receipt));
				$type_of_receipt=strtoupper($type_of_receipt);

				$cek=$db->select('tb_type_of_receipt','code_type_of_receipt="'.$code_type_of_receipt.'"','id_type_of_receipt','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_type_of_receipt','type_of_receipt="'.$type_of_receipt.'",note="'.$note.'"','code_type_of_receipt="'.$code_type_of_receipt.'"');

					echo str_replace("=", "", base64_encode($code_type_of_receipt));

				}else{

					echo "1";

				}

			}
		}
	}

?>