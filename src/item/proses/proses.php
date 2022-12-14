<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		$db = new db();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['item_new']==1){
			if(!empty($_POST['item'])){


				$cek=$db->select('tb_item','id_item','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$jum=strlen($tambah);

					for($i=$jum; $i<3; $i++){
						$tambah='0'.$tambah;
					}

					$code_item = 'I'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$code_item = 'I001';

					$urut = "1";

				}


				$item=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['item']));
				$type_of_item=mysqli_real_escape_string($db->query, $_POST['type_of_item']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_item=str_replace(" ", "", strtoupper($code_item));
				$item=strtoupper($item);



					$db->insert('tb_item','code_item="'.$code_item.'",item="'.$item.'",type_of_item="'.$type_of_item.'",note="'.$note.'",urut="'.$urut.'"');

					echo str_replace("=", "", base64_encode($code_item));


			}
		}else if($proses=='edit' && $_SESSION['item_edit']==1){
			if(!empty($_POST['code_item']) && !empty($_POST['item'])){

				$code_item=mysqli_real_escape_string($db->query, $_POST['code_item']);
				$item=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['item']));
				$type_of_item=mysqli_real_escape_string($db->query, $_POST['type_of_item']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$code_item=str_replace(" ", "", strtoupper($code_item));
				$item=strtoupper($item);

				$cek=$db->select('tb_item','code_item="'.$code_item.'"','id_item','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_item','item="'.$item.'",type_of_item="'.$type_of_item.'",note="'.$note.'"','code_item="'.$code_item.'"');

					echo str_replace("=", "", base64_encode($code_item));

				}else{

					echo "1";

				}

			}
		}
	}

?>