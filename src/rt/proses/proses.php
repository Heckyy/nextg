<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['rt_new']==1){
			if(!empty($_POST['code_rt']) && !empty($_POST['rt'])){


				$code_rt=mysqli_real_escape_string($db->query, $_POST['code_rt']);
				$rt=mysqli_real_escape_string($db->query, $_POST['rt']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$ketua_rt=mysqli_real_escape_string($db->query, $_POST['ketua_rt']);
				$address=mysqli_real_escape_string($db->query, $_POST['address']);

				$wakil_rt=mysqli_real_escape_string($db->query, $_POST['wakil_rt']);
				$address_wakil=mysqli_real_escape_string($db->query, $_POST['address_wakil']);

				$note=mysqli_real_escape_string($db->query, $_POST['note']);

				$code_rt=str_replace(" ", "", strtoupper($code_rt));
				$rt=strtoupper($rt);

				$ambil_cluster=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$c=mysqli_fetch_assoc($ambil_cluster);

				$cek=$db->select('tb_rt','code_rt="'.$code_rt.'"','id_rt','DESC');


				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_rt','code_rt="'.$code_rt.'",number="'.$rt.'",id_cluster="'.$cluster.'",cluster="'.$c['cluster'].'",name_rt="'.$ketua_rt.'",address="'.$address.'",name_representative="'.$wakil_rt.'",address_representative="'.$address_wakil.'",note="'.$note.'"');

					$cek=$db->select('tb_rt','code_rt="'.$code_rt.'"','id_rt','DESC');

					$r=mysqli_fetch_assoc($cek);

					$db->update('tb_population','id_rt="'.$r['id_rt'].'",number_rt="'.$rt.'"','id_cluster="'.$cluster.'"');

					echo str_replace("=", "", base64_encode($code_rt));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['rt_edit']==1){
			if(!empty($_POST['code_rt']) && !empty($_POST['rt'])){


				$code_rt=mysqli_real_escape_string($db->query, $_POST['code_rt']);
				$rt=mysqli_real_escape_string($db->query, $_POST['rt']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$ketua_rt=mysqli_real_escape_string($db->query, $_POST['ketua_rt']);
				$address=mysqli_real_escape_string($db->query, $_POST['address']);

				$wakil_rt=mysqli_real_escape_string($db->query, $_POST['wakil_rt']);
				$address_wakil=mysqli_real_escape_string($db->query, $_POST['address_wakil']);

				$note=mysqli_real_escape_string($db->query, $_POST['note']);

				$code_rt=str_replace(" ", "", strtoupper($code_rt));
				$rt=strtoupper($rt);

				$ambil_cluster=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				foreach ($ambil_cluster as $key => $c)

				$cek=$db->select('tb_rt','code_rt="'.$code_rt.'"','id_rt','DESC');

				if(mysqli_num_rows($cek)==1){
					$r=mysqli_fetch_assoc($cek);

					$db->update('tb_population','id_rt="'.$r['id_rt'].'",number_rt="'.$rt.'"','id_cluster="'.$cluster.'"');

					$db->update('tb_rt','number="'.$rt.'",id_cluster="'.$cluster.'",cluster="'.$c['cluster'].'",name_rt="'.$ketua_rt.'",address="'.$address.'",name_representative="'.$wakil_rt.'",address_representative="'.$address_wakil.'",note="'.$note.'"','code_rt="'.$code_rt.'"');

					echo str_replace("=", "", base64_encode($code_rt));

				}else{

					echo "1";

				}

			}
		}
	}

?>