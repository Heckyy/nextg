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

		if($proses=='new' && $_SESSION['payment_for_purchasing']==1){
			if(!empty($_POST['purchasing']) && !empty($_POST['amount']) && !empty($_POST['type_of_payment']) && !empty($_SESSION['bank'])){

				$purchasing=mysqli_real_escape_string($db->query, $_POST['purchasing']);
				$tanggal_input_data=mysqli_real_escape_string($db->query, $_POST['tanggal']);
				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$type_of_payment=mysqli_real_escape_string($db->query, $_POST['type_of_payment']);
		    	$jenis_pembayaran=mysqli_real_escape_string($db->query, $_POST['jenis_pembayaran']);
				$bank_tf=mysqli_real_escape_string($db->query, $_POST['bank_tf']);
		    	$nomor_rek=mysqli_real_escape_string($db->query, $_POST['nomor_rek']);
		    	$nama_akun=mysqli_real_escape_string($db->query, $_POST['nama_akun']);
		    	$tanggal_bank=mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
				$untuk=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['untuk']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$puchasing = $db->select('tb_purchasing','number_purchasing="'.$purchasing.'"','id_purchasing','ASC');
				$v=mysqli_fetch_assoc($puchasing);

				$tanggal_input=substr($tanggal_input_data, 0,2);
				$bulan_input=substr($tanggal_input_data, 3,2);
				$tahun_input=substr($tanggal_input_data, 6,4);
				$input_date=$tahun_input.'-'.$bulan_input.'-'.$tanggal_input;
				$date_input=$tahun_input.'-'.$bulan_input;

				if(empty($tanggal_bank)){
					$tanggal_bank=$input_date;
				}else{
					$tanggal_bank_tf=substr($tanggal_bank, 0,2);
					$bulan_bank_tf=substr($tanggal_bank, 3,2);
					$tahun_bank_tf=substr($tanggal_bank, 6,4);
					$tanggal_bank=$tahun_bank_tf.'-'.$bulan_bank_tf.'-'.$tanggal_bank_tf;
				}




				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$get_type_of_payment = $db->select('tb_type_of_payment','id_type_of_payment="'.$type_of_payment.'"','id_type_of_payment','ASC');
				$gt=mysqli_fetch_assoc($get_type_of_payment);

				$tarik_bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','id_bank_cash','ASC');
				$b=mysqli_fetch_assoc($tarik_bank);

				$data_cluster = $db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','ASC');
				$dc=mysqli_fetch_assoc($data_cluster);

				$data_position = $db->select('tb_position','id_position="'.$divisi.'"','id_position','ASC');
				$dp=mysqli_fetch_assoc($data_position);

				$cek=$db->select('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'" && tanggal LIKE "%'.$date_input.'%" && type="o"','urut','DESC');

				if(mysqli_num_rows($cek)>0){


					$potong = substr($tahun_input,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{


					$potong = substr($tahun_input,2);

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/1';

					$urut = "1";

				}

				$bayar=$v['bayar']+$amount;

					if($v['total']>=$bayar){

						$db->insert('tb_cash_receipt_payment','number_purchasing="'.$v['number_purchasing'].'",id_bank="'.$b['id_bank_cash'].'",number="'.$number.'",tanggal="'.$input_date.'",tanggal_bank="'.$tanggal_bank.'",type="o",id_type_of_payment="'.$type_of_payment.'",id_cluster="'.$cluster.'",cluster="'.$dc['cluster'].'",id_position="'.$divisi.'",position="'.$dp['position'].'",type_of_payment="'.$gt['type_of_payment'].'",untuk="'.$untuk.'",amount="'.$amount.'",urut="'.$urut.'",note="'.$note.'",jenis_pembayaran="'.$jenis_pembayaran.'",bank_tf="'.$bank_tf.'",nomor_rek="'.$nomor_rek.'",nama_akun="'.$nama_akun.'",input_data="'.$_SESSION['id_employee'].'"');

						$db->update('tb_purchasing','status_pembayaran="1"','number_purchasing="'.$v['number_purchasing'].'"');

						echo str_replace("=", "", base64_encode($number));
					}

			}
		}
	}
?>				
