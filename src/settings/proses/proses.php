<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='edit' && $_SESSION['settings']==1){

			$title_print=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['title_print']));
			$title_print2=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['title_print2']));
			$address=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['address']));
			$payment_method=addslashes($_POST['payment_method']);

			$db->update('tb_settings','title_print="'.$title_print.'",title_print2="'.$title_print2.'",alamat="'.$address.'",cara_pembayaran="'.$payment_method.'"','id_settings');

		}
	}
?>