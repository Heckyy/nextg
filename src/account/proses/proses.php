<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['account_new']==1){
			if(!empty($_POST['account_number']) && !empty($_POST['account'])){

				$type_of_account=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_account']));
				$sub_account_from=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['sub_account_from']));
				$sub_account_from_2=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['sub_account_from_2']));
				$account_number=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
				$account=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account']));
				$position=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['position']));
				$type_of_report=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_report']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$account=strtoupper($account);

				$cek=$db->select('tb_account','account_no="'.$account_number.'"','id_account','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->insert('tb_account','id_type_of_account="'.$type_of_account.'",id_sub_account="'.$sub_account_from.'",id_sub_account_2="'.$sub_account_from_2.'",account_no="'.$account_number.'",account="'.$account.'",position="'.$position.'",type_of_report="'.$type_of_report.'",note="'.$note.'",input_data="'.$_SESSION['id_employee'].'"');

					$cek_account=$db->select('tb_account','id_account','id_account','DESC');
					$co=mysqli_fetch_assoc($cek_account);
					echo str_replace("=", "", base64_encode($co['id_account']));

				}else{

					echo "1";

				}

			}
		}else if($proses=='edit' && $_SESSION['account_edit']==1){
			if(!empty($_POST['account_number']) && !empty($_POST['account'])){

				$type_of_account=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_account']));
				$sub_account_from=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['sub_account_from']));
				$sub_account_from_2=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['sub_account_from_2']));
				$account_number=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
				$account=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account']));
				$position=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['position']));
				$type_of_report=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['type_of_report']));
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$account=strtoupper($account);

				$cek=$db->select('tb_account','account_no="'.$account_number.'" && id_account!="'.$_SESSION['id_account'].'"','id_account','DESC');

				if(mysqli_num_rows($cek)==0){

					$db->update('tb_account','id_type_of_account="'.$type_of_account.'",id_sub_account="'.$sub_account_from.'",id_sub_account_2="'.$sub_account_from_2.'",account_no="'.$account_number.'",account="'.$account.'",position="'.$position.'",type_of_report="'.$type_of_report.'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','id_account="'.$_SESSION['id_account'].'"');

					echo str_replace("=", "", base64_encode($_SESSION['id_account']));

				}else{

					echo "1";

				}

			}
		}else if($proses=='sub' && $_SESSION['account_new']==1){
			$type_of_account=mysqli_real_escape_string($db->query, $_POST['type_of_account']);
			$account=$db->select('tb_account','id_type_of_account="'.$type_of_account.'" && id_sub_account="0"','account','ASC');
			
			echo '<option value="">Select</option>';

			if(!empty(mysqli_num_rows($account))){
				foreach ($account as $key => $a){
?>
					<option value="<?php echo $a['id_account']; ?>"><?php echo $a['account']; ?></option>
<?php
				}
			}

		}else if($proses=='sub_2' && $_SESSION['account_new']==1){
			$id_sub=mysqli_real_escape_string($db->query, $_POST['sub']);
			$account=$db->select('tb_account','id_sub_account="'.$id_sub.'" && id_sub_account_2="0"','account','ASC');
			
			echo '<option value="">Select</option>';

			if(!empty(mysqli_num_rows($account))){
				foreach ($account as $key => $a){
?>
					<option value="<?php echo $a['id_account']; ?>"><?php echo $a['account']; ?></option>
<?php
				}
			}

		}else if($proses=='type_of_report' && $_SESSION['account_new']==1){
			$type_of_account=mysqli_real_escape_string($db->query, $_POST['type_of_account']);
			$account=$db->select('tb_type_of_account INNER JOIN tb_group_account ON tb_type_of_account.id_group_account=tb_group_account.id_group_account','tb_type_of_account.id_type_of_account="'.$type_of_account.'"','tb_type_of_account.id_type_of_account','ASC','tb_type_of_account.id_type_of_account,tb_group_account.type_of_report');
			foreach ($account as $key => $a) {
				echo $a['type_of_report'];
			}

		}else if($proses=='ambil_nomor'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$account=$db->select('tb_account','id_account="'.$id.'"','id_account','DESC');
			foreach ($account as $key => $a) {

				$sub_account=$db->select('tb_account','id_sub_account="'.$a['id_account'].'"','id_account','DESC');
				$jum=mysqli_num_rows($sub_account);

				if($jum>0){
					$tambah=$jum+1;
					if($tambah<=9){
						$jum='0'.$tambah;
					}else{
						$jum=$jum+1;
					}

					echo $a['account_no'].'.'.$jum;
				}else{
					echo $a['account_no'].'.01';
				}

			}

		}else if($proses=='ambil_nomor_lagi'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$account=$db->select('tb_account','id_account="'.$id.'"','id_account','DESC');
			foreach ($account as $key => $a) {

				$sub_account=$db->select('tb_account','id_sub_account_2="'.$id.'"','id_account','DESC');
				$jum=mysqli_num_rows($sub_account);

				if($jum>0){
					$tambah=$jum+1;
					if($tambah<=9){
						$jum='0'.$tambah;
					}else{
						$jum=$jum+1;
					}

					echo $a['account_no'].'.'.$jum;
				}else{
					echo $a['account_no'].'.01';
				}

			}

		}
	}

?>