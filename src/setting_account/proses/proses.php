<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee']) && $_SESSION['setting_account']==1){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='edit_acn_purchasing'){
			
			$result = $db->select('tb_type_of_purchasing','id_type_of_purchasing','type_of_purchasing','ASC');

			foreach ($result as $key => $r) {

				$gabung='account_'.$r['id_type_of_purchasing'];
				$hasil = mysqli_real_escape_string($db->query, $_POST[$gabung]);
				$db->update('tb_type_of_purchasing','id_account="'.$hasil.'"','id_type_of_purchasing="'.$r['id_type_of_purchasing'].'"');

			}
		}

		if($proses=='edit_fn_type_of_receipt'){
			
			$result = $db->select('tb_type_of_receipt','id_type_of_receipt','type_of_receipt','ASC');

			foreach ($result as $key => $r) {

				$gabung='account_'.$r['id_type_of_receipt'];
				$hasil = mysqli_real_escape_string($db->query, $_POST[$gabung]);
				$db->update('tb_type_of_receipt','id_account="'.$hasil.'"','id_type_of_receipt="'.$r['id_type_of_receipt'].'"');

			}
		}

		if($proses=='edit_fn_type_of_payment'){
			
			$result = $db->select('tb_type_of_payment','id_type_of_payment','type_of_payment','ASC');

			foreach ($result as $key => $r) {

				$gabung='account_'.$r['id_type_of_payment'];
				$hasil = mysqli_real_escape_string($db->query, $_POST[$gabung]);
				$db->update('tb_type_of_payment','id_account="'.$hasil.'"','id_type_of_payment="'.$r['id_type_of_payment'].'"');

			}
		}

		if($proses=='edit_wh_type_of_receipt'){
			
			$result = $db->select('tb_type_of_receipt_wh','id_type_of_receipt_wh','type_of_receipt_wh','ASC');

			foreach ($result as $key => $r) {

				$gabung='account_'.$r['id_type_of_receipt_wh'];
				$hasil = mysqli_real_escape_string($db->query, $_POST[$gabung]);
				$db->update('tb_type_of_receipt_wh','id_account="'.$hasil.'"','id_type_of_receipt_wh="'.$r['id_type_of_receipt_wh'].'"');

			}
		}

		if($proses=='edit_wh_type_of_out'){
			
			$result = $db->select('tb_type_of_out_wh','id_type_of_out_wh','type_of_out_wh','ASC');

			foreach ($result as $key => $r) {

				$gabung='account_'.$r['id_type_of_out_wh'];
				$hasil = mysqli_real_escape_string($db->query, $_POST[$gabung]);
				$db->update('tb_type_of_out_wh','id_account="'.$hasil.'"','id_type_of_out_wh="'.$r['id_type_of_out_wh'].'"');

			}
		}
	}

?>