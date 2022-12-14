<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='edit' && $_SESSION['account_edit']==1){
			if(!empty($_SESSION['group_account']) && !empty($_POST['group_account'])){

				$id_group_account=mysqli_real_escape_string($db->query, $_SESSION['group_account']);
				$group_account=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['group_account']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

					$db->update('tb_group_account','group_account="'.$group_account.'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','id_group_account="'.$id_group_account.'"');

					echo str_replace("=", "", base64_encode($id_group_account));

			}
		}
	}

?>