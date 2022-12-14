<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		include_once "./../../../core/file/library.php";
		$db = new db();
		$library_class = new library_class();

		$tanggal 	= $library_class->tanggal();
		$bulan 		= $library_class->bulan();
		$tahun 		= $library_class->tahun();

		$date		= $tahun.'-'.$bulan;
		$date_asli	= $tahun.'-'.$bulan.'-'.$tanggal;

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['maintenance_new']==1){
			if(!empty($_POST['qty']) && !empty($_POST['item'])){

				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$employee=mysqli_real_escape_string($db->query, $_POST['employee']);
				$item=mysqli_real_escape_string($db->query, $_POST['item']);
				$qty=mysqli_real_escape_string($db->query, $_POST['qty']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
				$keterangan=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['keterangan']));

				$cek=$db->select('tb_request','type_of_request="2" && tanggal LIKE "%'.$date.'%"','urut','DESC');

				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');

				$e=mysqli_fetch_assoc($db->select('tb_employee','id_employee="'.$employee.'"','id_employee','DESC'));

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);

				if(mysqli_num_rows($cek)>0){

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'RM/'.$bulan.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$number = 'RM/'.$bulan.'/'.$potong.'/1';

					$urut = "1";

				}

					$data_item=$db->select('tb_item','id_item="'.$item.'"','item','ASC');
					$i=mysqli_fetch_assoc($data_item);

					$db->insert('tb_request','number_request="'.$number.'",tanggal="'.$date_asli.'",id_cluster="'.$cluster.'",id_position="'.$divisi.'",code_cluster="'.$cq['code_cluster'].'",cluster="'.$cq['cluster'].'",position="'.$pq['position'].'",id_employee="'.$employee.'",employee="'.$e['name'].'",urut="'.$urut.'",note="'.$note.'",type_of_request="2",input_data="'.$_SESSION['id_employee'].'"');

					$db->insert('tb_request_detail','number_request="'.$number.'",id_item="'.$item.'",item="'.$i['item'].'",qty="'.$qty.'",note="'.$keterangan.'"');

					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='edit' && $_SESSION['maintenance_edit']==1){
			if(!empty($_POST['number']) && !empty($_POST['qty']) && !empty($_POST['item'])){

				$number=mysqli_real_escape_string($db->query, $_POST['number']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$employee=mysqli_real_escape_string($db->query, $_POST['employee']);
				$item=mysqli_real_escape_string($db->query, $_POST['item']);
				$qty=mysqli_real_escape_string($db->query, $_POST['qty']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
				$keterangan=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['keterangan']));

				$cek=$db->select('tb_request','number_request="'.$number.'"','id_request','DESC');

				$detail=$db->select('tb_request_detail','number_request="'.$number.'" && id_item="'.$item.'"','id_request_detail','DESC');

				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');
				
				$e=mysqli_fetch_assoc($db->select('tb_employee','id_employee="'.$employee.'"','id_employee','DESC'));

				$data_item=$db->select('tb_item','id_item="'.$item.'"','item','ASC');
				$i=mysqli_fetch_assoc($data_item);

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);

				$total="0";
				if(mysqli_num_rows($cek)>0){

					if(mysqli_num_rows($detail)>0){
						$d=mysqli_fetch_assoc($detail);
						$db->update('tb_request_detail','qty="'.$qty.'",note="'.$keterangan.'"','id_request_detail="'.$d['id_request_detail'].'"');
					}else{
						$db->insert('tb_request_detail','number_request="'.$number.'",id_item="'.$item.'",item="'.$i['item'].'",qty="'.$qty.'",note="'.$keterangan.'"');
					}

					$db->update('tb_request','id_cluster="'.$cluster.'",id_position="'.$divisi.'",code_cluster="'.$cq['code_cluster'].'",cluster="'.$cq['cluster'].'",position="'.$pq['position'].'",id_employee="'.$employee.'",employee="'.$e['name'].'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','number_request="'.$number.'"');


					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}

			}
		}else if($proses=='cancel' && !empty($_SESSION['number_request']) && $_SESSION['maintenance_cancel']==1){
			$cek=$db->select('tb_request','number_request="'.$_SESSION['number_request'].'"','id_request','DESC');
			$jum=mysqli_num_rows($cek);

			if($jum>0){
				$c=mysqli_fetch_assoc($cek);

				$cek_purchasing=$db->select('tb_purchasing','number_request="'.$_SESSION['number_request'].'"','id_purchasing','DESC');
				$jum_pembayaran=mysqli_num_rows($cek_purchasing);
				
				if($jum_pembayaran==0){

					$db->update('tb_request','status="2"','number_request="'.$_SESSION['number_request'].'"');

				}else{

					$cb=mysqli_fetch_assoc($cek_purchasing);
					if($cb['status']==2){

						$db->update('tb_request','status="2"','number_request="'.$_SESSION['number_request'].'"');

					}

				}

			}

				echo str_replace("=", "", base64_encode($_SESSION['number_request']));
			
		}else if($proses=='process' && !empty($_SESSION['number_request']) && $_SESSION['maintenance_process']==1){

			$cek=$db->select('tb_request','number_request="'.$_SESSION['number_request'].'" && status="0"','id_request','DESC');
			$jum=mysqli_num_rows($cek);

			if($jum>0){

				$db->update('tb_request','status="3"','number_request="'.$_SESSION['number_request'].'"');

				

			}

				echo str_replace("=", "", base64_encode($_SESSION['number_request']));

		}else if($proses=='diketahui' && !empty($_SESSION['number_request']) && $_SESSION['maintenance_process']==1){

			$cek=$db->select('tb_request','number_request="'.$_SESSION['number_request'].'" && status="3"','id_request','DESC');
			$jum=mysqli_num_rows($cek);

			if($jum>0){

				$db->update('tb_request','status="1"','number_request="'.$_SESSION['number_request'].'"');

				

			}

				echo str_replace("=", "", base64_encode($_SESSION['number_request']));

		}else if($proses=='hapus' && $_SESSION['maintenance_edit']==1){

			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

			$cek=$db->select('tb_request_detail','id_request_detail="'.$id.'"','id_request_detail','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$d=mysqli_fetch_assoc($cek);

				$hasil=$db->select('tb_request','number_request="'.$d['number_request'].'" && status="0"','id_request','DESC');
				$jum_hasil=mysqli_num_rows($hasil);
				if($jum_hasil>0){
					$db->hapus('tb_request_detail','id_request_detail="'.$id.'"');
				}
				echo str_replace("=", "", base64_encode($d['number_request']));
			}

		}else if($proses=='item'){
				echo '<option value="">Select</option>';
			$item=$db->select('tb_item','type_of_item="3"','item','ASC');
			foreach ($item as $key => $i) {
				echo '<option value="'.$i['id_item'].'">'.$i['item'].'</option>';
			}
		}else if($proses=='tambah_item'){
			$barang=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['barang']));
			$type_of_item=mysqli_real_escape_string($db->query, $_POST['type_of_item']);
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

			$db->insert('tb_item','code_item="'.$code_item.'",item="'.$barang.'",type_of_item="'.$type_of_item.'",urut="'.$urut.'"');

		}
	}

?>