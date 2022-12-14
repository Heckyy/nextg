<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['employee_new']==1){
			if(!empty($_POST['code_employee']) && !empty($_POST['name'])){

				$code_employee=mysqli_real_escape_string($db->query, $_POST['code_employee']);
				$name=mysqli_real_escape_string($db->query, $_POST['name']);
				$unit=mysqli_real_escape_string($db->query, $_POST['unit']);
				$position=mysqli_real_escape_string($db->query, $_POST['position']);
				$sex=mysqli_real_escape_string($db->query, $_POST['sex']);
				$religion=mysqli_real_escape_string($db->query, $_POST['religion']);
				$place_of_birth=mysqli_real_escape_string($db->query, $_POST['place_of_birth']);
				$date_of_birth=mysqli_real_escape_string($db->query, $_POST['date_of_birth']);
				$id_card=mysqli_real_escape_string($db->query, $_POST['id_card']);
				$address=mysqli_real_escape_string($db->query, $_POST['address']);
				$city=mysqli_real_escape_string($db->query, $_POST['city']);
				$postal_code=mysqli_real_escape_string($db->query, $_POST['postal_code']);
				$telp=mysqli_real_escape_string($db->query, $_POST['telp']);
				$hp=mysqli_real_escape_string($db->query, $_POST['hp']);
				$note=mysqli_real_escape_string($db->query, $_POST['note']);

				$tanggal=substr($date_of_birth, 0,2);
				$bulan=substr($date_of_birth, 3,2);
				$tahun=substr($date_of_birth, 6,4);
				$date_of_birth=$tahun.'-'.$bulan.'-'.$tanggal;

				$code_employee=str_replace(" ", "", strtoupper($code_employee));

				$u=mysqli_fetch_assoc($db->select('tb_unit','id_unit="'.$unit.'"','id_unit','DESC'));
				$p=mysqli_fetch_assoc($db->select('tb_position','id_position="'.$position.'"','id_position','DESC'));

				$cek=$db->select('tb_employee','code_employee="'.$code_employee.'"','id_employee','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_employee','code_employee="'.$code_employee.'",name="'.$name.'",id_unit="'.$unit.'",unit="'.$u['unit'].'",id_position="'.$position.'",position="'.$p['position'].'",sex="'.$sex.'",religion="'.$religion.'",place_of_birth="'.$place_of_birth.'",date_of_birth="'.$date_of_birth.'",id_card="'.$id_card.'",address="'.$address.'",city="'.$city.'",postal_code="'.$postal_code.'",telp="'.$telp.'",hp="'.$hp.'",note="'.$note.'"');

					$db->insert('tb_access','code_employee="'.$code_employee.'"');
					
					echo str_replace("=", "", base64_encode($code_employee));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['employee_edit']==1){
			if(!empty($_POST['code_employee']) && !empty($_POST['name'])){

				$code_employee=mysqli_real_escape_string($db->query, $_POST['code_employee']);
				$name=mysqli_real_escape_string($db->query, $_POST['name']);
				$unit=mysqli_real_escape_string($db->query, $_POST['unit']);
				$position=mysqli_real_escape_string($db->query, $_POST['position']);
				$sex=mysqli_real_escape_string($db->query, $_POST['sex']);
				$religion=mysqli_real_escape_string($db->query, $_POST['religion']);
				$place_of_birth=mysqli_real_escape_string($db->query, $_POST['place_of_birth']);
				$date_of_birth=mysqli_real_escape_string($db->query, $_POST['date_of_birth']);
				$id_card=mysqli_real_escape_string($db->query, $_POST['id_card']);
				$address=mysqli_real_escape_string($db->query, $_POST['address']);
				$city=mysqli_real_escape_string($db->query, $_POST['city']);
				$postal_code=mysqli_real_escape_string($db->query, $_POST['postal_code']);
				$telp=mysqli_real_escape_string($db->query, $_POST['telp']);
				$hp=mysqli_real_escape_string($db->query, $_POST['hp']);
				$note=mysqli_real_escape_string($db->query, $_POST['note']);

				$tanggal=substr($date_of_birth, 0,2);
				$bulan=substr($date_of_birth, 3,2);
				$tahun=substr($date_of_birth, 6,4);
				$date_of_birth=$tahun.'-'.$bulan.'-'.$tanggal;

				$code_employee=str_replace(" ", "", strtoupper($code_employee));

				$cek=$db->select('tb_employee','code_employee="'.$code_employee.'"','id_employee','DESC');

				$u=mysqli_fetch_assoc($db->select('tb_unit','id_unit="'.$unit.'"','id_unit','DESC'));
				$p=mysqli_fetch_assoc($db->select('tb_position','id_position="'.$position.'"','id_position','DESC'));

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_employee','name="'.$name.'",id_unit="'.$unit.'",unit="'.$u['unit'].'",id_position="'.$position.'",position="'.$p['position'].'",sex="'.$sex.'",religion="'.$religion.'",place_of_birth="'.$place_of_birth.'",date_of_birth="'.$date_of_birth.'",id_card="'.$id_card.'",address="'.$address.'",city="'.$city.'",postal_code="'.$postal_code.'",telp="'.$telp.'",hp="'.$hp.'",note="'.$note.'"','code_employee="'.$code_employee.'"');

					$d=mysqli_fetch_assoc($db->select('tb_employee','code_employee="'.$code_employee.'"','id_employee','DESC'));

					$db->update('tb_coordinator','coordinator="'.$name.'"','id_employee="'.$d['id_employee'].'"');

					echo str_replace("=", "", base64_encode($code_employee));

				}else{

					echo "1";

				}

			}
		}else if($proses=='access' && $_SESSION['employee_access']==1){
			$code_employee=mysqli_real_escape_string($db->query, $_SESSION['access_code_employee']);
			$access_akun=mysqli_real_escape_string($db->query, base64_decode($_POST['access_akun']));
			$ubah=str_replace('\"', '"', $access_akun);
			$ubah_data_finish=str_replace('\"','"', $ubah);

			$cek_data=$db->select('tb_access','code_employee="'.$code_employee.'"','id_access','DESC');
			$jum=mysqli_num_rows($cek_data);

			if($jum>0){

				$db->update('tb_access',$ubah_data_finish,'code_employee="'.$code_employee.'"');

			}else{

				$db->insert('tb_access',$ubah_data_finish.',code_employee="'.$code_employee.'"');

			}	
		}
	}

?>