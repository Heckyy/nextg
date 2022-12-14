<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['dues_type_new']==1){
			if(!empty($_POST['code_dues']) && !empty($_POST['dues_type'])){

				$code_dues=mysqli_real_escape_string($db->query, $_POST['code_dues']);
				$dues_type=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dues_type']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_dues=str_replace(" ", "", strtoupper($code_dues));
				$dues_type=strtoupper($dues_type);

				$cek=$db->select('tb_dues','code_dues="'.$code_dues.'"','id_dues','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_dues','code_dues="'.$code_dues.'",dues_type="'.$dues_type.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_dues));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['dues_type_edit']==1){
			if(!empty($_POST['code_dues']) && !empty($_POST['dues_type'])){

				$code_dues=mysqli_real_escape_string($db->query, $_POST['code_dues']);
				$dues_type=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dues_type']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_dues=str_replace(" ", "", strtoupper($code_dues));
				$dues_type=strtoupper($dues_type);

				$cek=$db->select('tb_dues','code_dues="'.$code_dues.'"','id_dues','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_dues','dues_type="'.$dues_type.'",note="'.$note.'"','code_dues="'.$code_dues.'"');

					echo str_replace("=", "", base64_encode($code_dues));

				}else{

					echo "1";

				}

			}
		}
	}

?>