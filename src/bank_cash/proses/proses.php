<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['bank_cash_new']==1){
			if(!empty($_POST['code_bank_cash']) && !empty($_POST['bank_cash'])){

				$code_bank_cash=mysqli_real_escape_string($db->query, $_POST['code_bank_cash']);
				$bank_cash=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['bank_cash']));
				$account_number=mysqli_real_escape_string($db->query, $_POST['account_number']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
				$access=mysqli_real_escape_string($db->query, $_POST['access']);

				$code_bank_cash=str_replace(" ", "", strtoupper($code_bank_cash));
				$bank_cash=strtoupper($bank_cash);

				$cek=$db->select('tb_bank_cash','code_bank_cash="'.$code_bank_cash.'"','id_bank_cash','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_bank_cash','code_bank_cash="'.$code_bank_cash.'",bank_cash="'.$bank_cash.'",nominal="0",account_number="'.$account_number.'",note="'.$note.'"');

					$cek=$db->select('tb_bank_cash','code_bank_cash="'.$code_bank_cash.'"','id_bank_cash','DESC');
					$bc=mysqli_fetch_assoc($cek);

					$db->insert('tb_access_bank','id_bank_cash="'.$bc['id_bank_cash'].'",id_employee="'.$access.'"');

					echo str_replace("=", "", base64_encode($code_bank_cash));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['bank_cash_edit']==1){
			if(!empty($_POST['code_bank_cash']) && !empty($_POST['bank_cash'])){

				$code_bank_cash=mysqli_real_escape_string($db->query, $_POST['code_bank_cash']);
				$bank_cash=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['bank_cash']));
				$account_number=mysqli_real_escape_string($db->query, $_POST['account_number']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
				$access=mysqli_real_escape_string($db->query, $_POST['access']);

				$code_bank_cash=str_replace(" ", "", strtoupper($code_bank_cash));
				$bank_cash=strtoupper($bank_cash);

				$cek=$db->select('tb_bank_cash','code_bank_cash="'.$code_bank_cash.'"','id_bank_cash','DESC');

				if(mysqli_num_rows($cek)>0){

					$bc=mysqli_fetch_assoc($cek);

					$db->update('tb_bank_cash','bank_cash="'.$bank_cash.'",account_number="'.$account_number.'",note="'.$note.'"','code_bank_cash="'.$code_bank_cash.'"');

					$db->insert('tb_access_bank','id_bank_cash="'.$bc['id_bank_cash'].'",id_employee="'.$access.'"');

					echo str_replace("=", "", base64_encode($code_bank_cash));

				}else{

					echo "1";

				}

			}
		}else if($proses=='hapus' && $_SESSION['bank_cash_edit']==1){

			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

			$cek=$db->select('tb_access_bank','id_access_bank="'.$id.'"','id_access_bank','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$d=mysqli_fetch_assoc($cek);
				
				$cek=$db->select('tb_bank_cash','id_bank_cash="'.$d['id_bank_cash'].'"','id_bank_cash','DESC');
				$c=mysqli_fetch_assoc($cek);

				$db->hapus('tb_access_bank','id_access_bank="'.$id.'"');
				
				echo str_replace("=", "", base64_encode($c['code_bank_cash']));
			}

		}
	}

?>