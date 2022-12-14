<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['house_size_new']==1){
			if(!empty($_POST['code_house_size']) && !empty($_POST['house_size']) && !empty($_POST['amount'])){

				$code_house_size=mysqli_real_escape_string($db->query, $_POST['code_house_size']);
				$house_size=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['house_size']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$code_house_size=str_replace(" ", "", strtoupper($code_house_size));
				$house_size=strtoupper($house_size);

				$cek=$db->select('tb_house_size','code_house_size="'.$code_house_size.'"','id_house_size','DESC');

				$total_amount=$house_size*$amount;

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_house_size','code_house_size="'.$code_house_size.'",house_size="'.$house_size.'",amount_meter="'.$amount.'",amount="'.$total_amount.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_house_size));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['house_size_edit']==1){
			if(!empty($_POST['code_house_size']) && !empty($_POST['house_size']) && !empty($_POST['amount'])){

				$code_house_size=mysqli_real_escape_string($db->query, $_POST['code_house_size']);
				$house_size=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['house_size']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$code_house_size=str_replace(" ", "", strtoupper($code_house_size));
				$house_size=strtoupper($house_size);

				$cek=$db->select('tb_house_size','code_house_size="'.$code_house_size.'"','id_house_size','DESC');

				$total_amount=$house_size*$amount;
				
				if(mysqli_num_rows($cek)>0){

					$db->update('tb_house_size','house_size="'.$house_size.'",amount_meter="'.$amount.'",amount="'.$total_amount.'",note="'.$note.'"','code_house_size="'.$code_house_size.'"');

					echo str_replace("=", "", base64_encode($code_house_size));

				}else{

					echo "1";

				}

			}
		}
	}

?>