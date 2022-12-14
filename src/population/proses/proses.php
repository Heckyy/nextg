<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['population_new']==1){

	    	$first_name 		= mysqli_real_escape_string($db->query, $_POST['first_name']);
	    	$last_name 		= mysqli_real_escape_string($db->query, $_POST['last_name']);
	    	$kk 		= mysqli_real_escape_string($db->query, $_POST['kk']);
	    	$ktp 		= mysqli_real_escape_string($db->query, $_POST['ktp']);

	    	$name=$first_name.' '.$last_name;

	    	$cluster 		= mysqli_real_escape_string($db->query, $_POST['cluster']);

	    	$telp 		= mysqli_real_escape_string($db->query, $_POST['telp']);
	    	$hp 		= mysqli_real_escape_string($db->query, $_POST['hp']);

	    	$note       = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

	    	$status       = mysqli_real_escape_string($db->query, $_POST['status']);
	    	

	    	$population=$db->select('tb_population','id_population="'.$cluster.'" && status="0"','id_population','DESC');
	    	$p=mysqli_fetch_assoc($population);

			$warga=$db->select('tb_warga ','id_warga','urut','ASC');

			if(mysqli_num_rows($warga)){
				$w=mysqli_fetch_assoc($warga);
				$urut=$w['urut']+1;
				$code=$w['urut']+1;
				$jum=strlen($code);

				if($jum=1){
					$code='0000'.$code;
				}else if($jum=2){
					$code='000'.$code;
				}else if($jum=3){
					$code='00'.$code;
				}else if($jum=4){
					$code='0'.$code;
				}else{
					$code=$code;
				}
			}else{
				$code='00001';
				$urut=1;
			}

			$code='POP-'.$code;


			$db->insert('tb_warga','code_warga="'.$code.'",name="'.$name.'",first_name="'.$first_name.'",last_name="'.$last_name.'",kk="'.$kk.'",ktp="'.$ktp.'",id_population="'.$p['id_population'].'",id_cluster="'.$p['id_cluster'].'",cluster="'.$p['cluster'].'",id_rt="'.$p['id_rt'].'",number_rt="'.$p['number_rt'].'",house_number="'.$p['house_number'].'",address="'.$p['address'].'",telp="'.$telp.'",hp="'.$hp.'",status="'.$status.'",note="'.$note.'",urut="'.$urut.'",input_data="'.$_SESSION['id_employee'].'"');

			echo str_replace("=", "", base64_encode($code));

		}else if($proses=='edit' && $_SESSION['population_edit']==1){

	    	$code 		= mysqli_real_escape_string($db->query, $_POST['code']);
	    	$first_name 		= mysqli_real_escape_string($db->query, $_POST['first_name']);
	    	$last_name 		= mysqli_real_escape_string($db->query, $_POST['last_name']);
	    	$kk 		= mysqli_real_escape_string($db->query, $_POST['kk']);
	    	$ktp 		= mysqli_real_escape_string($db->query, $_POST['ktp']);

	    	$name=$first_name.' '.$last_name;

	    	$cluster 		= mysqli_real_escape_string($db->query, $_POST['cluster']);

	    	$telp 		= mysqli_real_escape_string($db->query, $_POST['telp']);
	    	$hp 		= mysqli_real_escape_string($db->query, $_POST['hp']);

	    	$note       = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

	    	$status       = mysqli_real_escape_string($db->query, $_POST['status']);



	    	$cek=$db->select('tb_warga','code_warga="'.$code.'"','id_warga','DESC');

			$population=$db->select('tb_population','id_population="'.$cluster.'" && status="0"','id_population','DESC');
	    	$p=mysqli_fetch_assoc($population);

	    	if(mysqli_num_rows($cek)>0){

				$db->update('tb_warga','name="'.$name.'",first_name="'.$first_name.'",last_name="'.$last_name.'",kk="'.$kk.'",ktp="'.$ktp.'",id_population="'.$p['id_population'].'",id_cluster="'.$p['id_cluster'].'",cluster="'.$p['cluster'].'",id_rt="'.$p['id_rt'].'",number_rt="'.$p['number_rt'].'",house_number="'.$p['house_number'].'",address="'.$p['address'].'",telp="'.$telp.'",hp="'.$hp.'",status="'.$status.'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','code_warga="'.$code.'"');

				echo str_replace("=", "", base64_encode($code));

	    	}else{
	    		echo "1";
	    	}

		}else if($proses=='rt'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$population = $db->select('tb_population','id_population="'.$id.'"','id_population','ASC');
			$h=mysqli_fetch_assoc($population);

			echo $h['number_rt'];

		}else if($proses=='house_number'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$population = $db->select('tb_population','id_population="'.$id.'"','id_population','ASC');
			$h=mysqli_fetch_assoc($population);

			echo $h['house_number'];

		}else if($proses=='address'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$population = $db->select('tb_population','id_population="'.$id.'"','id_population','ASC');
			$h=mysqli_fetch_assoc($population);

			echo $h['address'];

		}else if($proses=='delete' && $_SESSION['population_delete']==1){
			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
			$head = $db->select('tb_warga','id_warga="'.$id.'"','id_warga','ASC');
			if(mysqli_num_rows($head)>0){
				$h=mysqli_fetch_assoc($head);
				$ubah='hapus-'.$h['code_warga'].'-'.rand();
				$db->update('tb_warga','status="3",code_warga="'.$ubah.'",update_data="'.$_SESSION['id_employee'].'"','id_warga="'.$h['id_warga'].'"');
			}
		}

	}
?>
