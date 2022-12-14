<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['contractor_new']==1){
			if(!empty($_POST['code_contractor']) && !empty($_POST['contractor'])){

				$code_contractor=mysqli_real_escape_string($db->query, $_POST['code_contractor']);
				$contractor=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['contractor']));
				$type_of_work=mysqli_real_escape_string($db->query, $_POST['type_of_work']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_contractor=str_replace(" ", "", strtoupper($code_contractor));
				$contractor=strtoupper($contractor);

				$cek=$db->select('tb_contractor','code_contractor="'.$code_contractor.'"','id_contractor','DESC');
				$tarik_type_of_work=$db->select('tb_type_of_work','id_type_of_work="'.$type_of_work.'"','id_type_of_work','DESC');

				if(mysqli_num_rows($cek)==0){

					$t=mysqli_fetch_assoc($tarik_type_of_work);

					$db->insert('tb_contractor','code_contractor="'.$code_contractor.'",contractor="'.$contractor.'",id_type_of_work="'.$type_of_work.'",type_of_work="'.$t['type_of_work'].'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_contractor));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['contractor_edit']==1){
			if(!empty($_POST['code_contractor']) && !empty($_POST['contractor'])){

				$code_contractor=mysqli_real_escape_string($db->query, $_POST['code_contractor']);
				$contractor=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['contractor']));
				$type_of_work=mysqli_real_escape_string($db->query, $_POST['type_of_work']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_contractor=str_replace(" ", "", strtoupper($code_contractor));
				$contractor=strtoupper($contractor);

				$cek=$db->select('tb_contractor','code_contractor="'.$code_contractor.'"','id_contractor','DESC');
				$tarik_type_of_work=$db->select('tb_type_of_work','id_type_of_work="'.$type_of_work.'"','id_type_of_work','DESC');

				if(mysqli_num_rows($cek)>0){

					$t=mysqli_fetch_assoc($tarik_type_of_work);

					$db->update('tb_contractor','contractor="'.$contractor.'",id_type_of_work="'.$type_of_work.'",type_of_work="'.$t['type_of_work'].'",note="'.$note.'"','code_contractor="'.$code_contractor.'"');

					echo str_replace("=", "", base64_encode($code_contractor));

				}else{

					echo "1";

				}

			}
		}
	}

?>