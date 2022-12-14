<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='edit' && $_SESSION['rw_edit']==1){

	    	$ketua_rw=mysqli_real_escape_string($db->query, $_POST['ketua_rw']);
	    	$address=mysqli_real_escape_string($db->query, $_POST['address']);
	    	$wakil_rw=mysqli_real_escape_string($db->query, $_POST['wakil_rw']);
	    	$address_representative=mysqli_real_escape_string($db->query, $_POST['address_representative']);
	    	$finance_monitoring=mysqli_real_escape_string($db->query, $_POST['finance_monitoring']);
	    	$address_finance_monitoring=mysqli_real_escape_string($db->query, $_POST['address_finance_monitoring']);
	    	$treasurer=mysqli_real_escape_string($db->query, $_POST['treasurer']);
	    	$address_treasurer=mysqli_real_escape_string($db->query, $_POST['address_treasurer']);
	    	$estate_manager=mysqli_real_escape_string($db->query, $_POST['estate_manager']);
	    	$address_estate_manager=mysqli_real_escape_string($db->query, $_POST['address_estate_manager']);
	    	$purchasing=mysqli_real_escape_string($db->query, $_POST['purchasing']);
	    	$address_purchasing=mysqli_real_escape_string($db->query, $_POST['address_purchasing']);
	    	$admin=mysqli_real_escape_string($db->query, $_POST['admin']);
	    	$address_admin=mysqli_real_escape_string($db->query, $_POST['address_admin']);


			$db->update('tb_rw','ketua_rw="'.$ketua_rw.'",address="'.$address.'",wakil_rw="'.$wakil_rw.'",address_representative="'.$address_representative.'",finance_monitoring="'.$finance_monitoring.'",address_finance_monitoring="'.$address_finance_monitoring.'",treasurer="'.$treasurer.'",address_treasurer="'.$address_treasurer.'",estate_manager="'.$estate_manager.'",address_estate_manager="'.$address_estate_manager.'",purchasing="'.$purchasing.'",address_purchasing="'.$address_purchasing.'",admin="'.$admin.'",address_admin="'.$address_admin.'"','id_rw="1"');


		}
	}

?>