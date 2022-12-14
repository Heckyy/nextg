<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['cluster_new']==1){
			if(!empty($_POST['code_cluster']) && !empty($_POST['cluster'])){

				$code_cluster=mysqli_real_escape_string($db->query, $_POST['code_cluster']);
				$cluster=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cluster']));
				$the_land_price=mysqli_real_escape_string($db->query,$_POST['the_land_price']);
				$building_price=mysqli_real_escape_string($db->query,$_POST['building_price']);
				$macro_price=mysqli_real_escape_string($db->query,$_POST['macro_price']);
				$empty_land=mysqli_real_escape_string($db->query,$_POST['empty_land']);
				$address=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['address']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$the_land_price=str_replace(".", "", $the_land_price);
				$the_land_price=str_replace(",", ".", $the_land_price);

				$building_price=str_replace(".", "", $building_price);
				$building_price=str_replace(",", ".", $building_price);

				$macro_price=str_replace(".", "", $macro_price);
				$macro_price=str_replace(",", ".", $macro_price);

				$empty_land=str_replace(".", "", $empty_land);
				$empty_land=str_replace(",", ".", $empty_land);

				$code_cluster=str_replace(" ", "", strtoupper($code_cluster));
				$cluster=strtoupper($cluster);

				$cek=$db->select('tb_cluster','code_cluster="'.$code_cluster.'"','id_cluster','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_cluster','code_cluster="'.$code_cluster.'",cluster="'.$cluster.'",the_land_price="'.$the_land_price.'",building_price="'.$building_price.'",macro_price="'.$macro_price.'",empty_land="'.$empty_land.'",address="'.$address.'",note="'.$note.'"');

					echo str_replace("=", "", base64_encode($code_cluster));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['cluster_edit']==1){
			if(!empty($_POST['code_cluster']) && !empty($_POST['cluster'])){

				$code_cluster=mysqli_real_escape_string($db->query, $_POST['code_cluster']);
				$cluster=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cluster']));
				$the_land_price=mysqli_real_escape_string($db->query,$_POST['the_land_price']);
				$building_price=mysqli_real_escape_string($db->query,$_POST['building_price']);
				$macro_price=mysqli_real_escape_string($db->query,$_POST['macro_price']);
				$empty_land=mysqli_real_escape_string($db->query,$_POST['empty_land']);
				$address=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['address']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$the_land_price=str_replace(".", "", $the_land_price);
				$the_land_price=str_replace(",", ".", $the_land_price);

				$building_price=str_replace(".", "", $building_price);
				$building_price=str_replace(",", ".", $building_price);

				$macro_price=str_replace(".", "", $macro_price);
				$macro_price=str_replace(",", ".", $macro_price);

				$empty_land=str_replace(".", "", $empty_land);
				$empty_land=str_replace(",", ".", $empty_land);

				$code_cluster=str_replace(" ", "", strtoupper($code_cluster));
				$cluster=strtoupper($cluster);

				$cek=$db->select('tb_cluster','code_cluster="'.$code_cluster.'"','id_cluster','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_cluster','cluster="'.$cluster.'",the_land_price="'.$the_land_price.'",building_price="'.$building_price.'",macro_price="'.$macro_price.'",empty_land="'.$empty_land.'",address="'.$address.'",note="'.$note.'"','code_cluster="'.$code_cluster.'"');

					echo str_replace("=", "", base64_encode($code_cluster));

				}else{

					echo "1";

				}

			}
		}
	}

?>