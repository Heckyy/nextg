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

		if($proses=='new' && $_SESSION['cash_payment_new']==1){
			if(!empty($_POST['amount']) && !empty($_POST['type_of_payment']) && !empty($_SESSION['bank'])){

				$tanggal_input_data=mysqli_real_escape_string($db->query, $_POST['tanggal']);
				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$type_of_payment=mysqli_real_escape_string($db->query, $_POST['type_of_payment']);
				$untuk=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['untuk']));
				$necessity=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['necessity']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$bank_date=$date_asli;
			
				$tanggal_input=substr($tanggal_input_data, 0,2);
				$bulan_input=substr($tanggal_input_data, 3,2);
				$tahun_input=substr($tanggal_input_data, 6,4);
				$input_date=$tahun_input.'-'.$bulan_input.'-'.$tanggal_input;
				$date_input=$tahun_input.'-'.$bulan_input;

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);


				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);


				$get_type_of_payment = $db->select('tb_type_of_payment','id_type_of_payment="'.$type_of_payment.'"','id_type_of_payment','ASC');
				$gt=mysqli_fetch_assoc($get_type_of_payment);

				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$cek=$db->select('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'" && tanggal LIKE "%'.$date_input.'%" && type="o"','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun_input,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun_input,2);

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/1';

					$urut = "1";

				}

					$db->insert('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'",number="'.$number.'",tanggal="'.$input_date.'",tanggal_bank="'.$input_date.'",id_cluster="'.$cluster.'",cluster="'.$cq['cluster'].'",code_cluster="'.$cq['code_cluster'].'",id_position="'.$divisi.'",position="'.$pq['position'].'",type="o",id_type_of_payment="'.$type_of_payment.'",type_of_payment="'.$gt['type_of_payment'].'",untuk="'.$untuk.'",amount="'.$amount.'",urut="'.$urut.'",note="'.$note.'",input_data="'.$_SESSION['id_employee'].'"');

					$db->insert('tb_cash_receipt_payment_detail','number="'.$number.'",necessity="'.$necessity.'",price="'.$amount.'"');

					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='new_payroll' && $_SESSION['payroll']==1){
			if(!empty($_POST['amount']) && !empty($_POST['type_of_payment']) && !empty($_POST['untuk']) && !empty($_SESSION['bank'])){

				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$type_of_payment=mysqli_real_escape_string($db->query, $_POST['type_of_payment']);
				$untuk=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['untuk']));
				$necessity=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['necessity']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$bank_date=$date_asli;

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$get_type_of_payment = $db->select('tb_type_of_payment','id_type_of_payment="'.$type_of_payment.'"','id_type_of_payment','ASC');
				$gt=mysqli_fetch_assoc($get_type_of_payment);

				$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
				$b=mysqli_fetch_assoc($bank);

				$cek=$db->select('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'" && tanggal LIKE "%'.$date.'%" && type="o"','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$number = 'P'.$b['code_bank_cash'].'/'.$bulan.'/'.$potong.'/1';

					$urut = "1";

				}

					$db->insert('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'",number="'.$number.'",tanggal="'.$date_asli.'",tanggal_bank="'.$bank_date.'",id_cluster="'.$cluster.'",id_position="'.$divisi.'",type="o",id_type_of_payment="'.$type_of_payment.'",type_of_payment="'.$gt['type_of_payment'].'",untuk="'.$untuk.'",amount="'.$amount.'",urut="'.$urut.'",note="'.$note.'",input_data="'.$_SESSION['id_employee'].'",type_transaction="1"');

					$db->insert('tb_cash_receipt_payment_detail','number="'.$number.'",necessity="'.$necessity.'",price="'.$amount.'"');

					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='edit' && $_SESSION['cash_payment_edit']==1){
			if(!empty($_POST['amount']) && !empty($_POST['type_of_payment']) && !empty($_SESSION['bank'])){

				$number=mysqli_real_escape_string($db->query, $_POST['number']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$divisi=mysqli_real_escape_string($db->query, $_POST['divisi']);
				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$type_of_payment=mysqli_real_escape_string($db->query, $_POST['type_of_payment']);
				$untuk=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['untuk']));
				$necessity=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['necessity']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$bank_date=$date_asli;

				$potong_awal=substr($cluster, 0,2);
				$potong_kedua=substr($cluster, 2);

				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);
				
				$get_type_of_payment = $db->select('tb_type_of_payment','id_type_of_payment="'.$type_of_payment.'"','id_type_of_payment','ASC');
				$gt=mysqli_fetch_assoc($get_type_of_payment);

				
				$cek=$db->select('tb_cash_receipt_payment','number="'.$number.'" && type="o" && status="0"','id_cash_receipt_payment','DESC');

				if(mysqli_num_rows($cek)>0){

					$tcrp=mysqli_fetch_assoc($cek);

					$total=$tcrp['amount']+$amount;

					$db->insert('tb_cash_receipt_payment_detail','number="'.$number.'",necessity="'.$necessity.'",price="'.$amount.'"');

					$db->update('tb_cash_receipt_payment','tanggal_bank="'.$bank_date.'",id_type_of_payment="'.$type_of_payment.'",type_of_payment="'.$gt['type_of_payment'].'",untuk="'.$untuk.'",amount="'.$total.'",id_cluster="'.$cluster.'",cluster="'.$cq['cluster'].'",code_cluster="'.$cq['code_cluster'].'",id_position="'.$divisi.'",position="'.$pq['position'].'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','number="'.$number.'"');

					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}

			}
		}else if($proses=='cancel' && $_SESSION['cash_payment_cancel']==1){
			$cek=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_payment'].'" && status="1"','id_cash_receipt_payment','DESC');
			$jum=mysqli_num_rows($cek);
			
			if($jum>0){
				$c=mysqli_fetch_assoc($cek);

				$priod_date=substr($c['tanggal'], 0, -3); 

				$bank=$db->select('tb_bank_cash','id_bank_cash="'.$c['id_bank'].'"','id_bank_cash','DESC');
				$b=mysqli_fetch_assoc($bank);

				$nominal=$b['nominal']+$c['amount'];

				$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

				$priod=$db->select('tb_priod','id_bank_cash="'.$c['id_bank'].'" && priod="'.$priod_date.'"','id_priod','DESC');
				$p=mysqli_fetch_assoc($priod);

				$nominal_priod=$p['nominal']+$c['amount'];

				$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

				$db->update('tb_cash_receipt_payment','status="2"','number="'.$_SESSION['number_payment'].'"');

				if(!empty($c['number_purchasing'])){

					$puchasing = $db->select('tb_purchasing','number_purchasing="'.$c['number_purchasing'].'"','id_purchasing','ASC');
					$v=mysqli_fetch_assoc($puchasing);

					$bayar=$v['bayar']-$c['amount'];


					$db->update('tb_purchasing','bayar="'.$bayar.'",status_pembayaran="0"','number_purchasing="'.$v['number_purchasing'].'"');

				}

			}else{

				$cek_payment=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_payment'].'"','id_cash_receipt_payment','DESC');
				$np=mysqli_fetch_assoc($cek_payment);

				$db->update('tb_purchasing','status_pembayaran="0"','number_purchasing="'.$np['number_purchasing'].'"');

				$db->update('tb_cash_receipt_payment','status="2"','number="'.$_SESSION['number_payment'].'"');

			}
			echo str_replace("=", "", base64_encode($_SESSION['number_payment']));
			
		}else if($proses=='process' && $_SESSION['cash_payment_process']==1){

			$cek=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_payment'].'" && status="0"','id_cash_receipt_payment','DESC');

			$c=mysqli_fetch_assoc($cek);

			$bank=$db->select('tb_bank_cash','id_bank_cash="'.$c['id_bank'].'"','id_bank_cash','DESC');
			$b=mysqli_fetch_assoc($bank);

			$priod_date=substr($c['tanggal'], 0, -3); 

			$priod=$db->select('tb_priod','id_bank_cash="'.$c['id_bank'].'" && priod="'.$priod_date.'"','id_priod','DESC');
			$jum=mysqli_num_rows($priod);

			if($jum>0){

				$p=mysqli_fetch_assoc($priod);

				$nominal=$b['nominal']-$c['amount'];

				$db->update('tb_bank_cash','amount="'.$nominal.'"','id_bank_cash="'.$c['id_bank'].'"');

				$nominal_priod=$p['nominal']-$c['amount'];

				$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

				$db->update('tb_cash_receipt_payment','status="3",approved="'.$_SESSION['code_employee'].'"','number="'.$_SESSION['number_payment'].'"');

			}else{
			
				$nominal=$b['nominal']-$c['amount'];

				$ambil_nilai=$db->select('tb_priod','id_bank_cash="'.$b['id_bank_cash'].'"','id_priod','DESC LIMIT 1');

				if(mysqli_num_rows($ambil_nilai)>0){
					$an=mysqli_fetch_assoc($ambil_nilai);
					$nominal_ambil=$an['nominal']-$c['amount'];
				}else{
					$nominal_ambil='-'.$c['amount'];
				}

				$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

				$db->insert('tb_priod','nominal="'.$nominal_ambil.'",priod="'.$priod_date.'",id_bank_cash="'.$c['id_bank'].'"');

				$db->update('tb_cash_receipt_payment','status="3",approved="'.$_SESSION['code_employee'].'"','number="'.$_SESSION['number_payment'].'"');

			}



			if(!empty($c['number_purchasing'])){

				$puchasing = $db->select('tb_purchasing','number_purchasing="'.$c['number_purchasing'].'"','id_purchasing','ASC');
				$v=mysqli_fetch_assoc($puchasing);

				$bayar=$v['bayar']+$c['amount'];

				if($v['total']>=$bayar){

					if($v['total']==$bayar || $bayar>$v['total']){
						$status_pembayaran=',status_pembayaran="1"';
					}else{
						$status_pembayaran=',status_pembayaran="0"';
					}

					$db->update('tb_purchasing','bayar="'.$bayar.'"'.$status_pembayaran,'number_purchasing="'.$v['number_purchasing'].'"');

				}
			}

				echo str_replace("=", "", base64_encode($_SESSION['number_payment']));

		}else if($proses=='diketahui' && $_SESSION['cash_receipt_diketahui']==1){

			$db->update('tb_cash_receipt_payment','status="1",diketahui="'.$_SESSION['code_employee'].'"','number="'.$_SESSION['number_payment'].'"');

			echo str_replace("=", "", base64_encode($_SESSION['number_payment']));

		}else if($proses=='hapus' && $_SESSION['cash_payment_edit']==1){

			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

			$cek=$db->select('tb_cash_receipt_payment_detail','id_detail="'.$id.'"','id_detail','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$d=mysqli_fetch_assoc($cek);

				$hasil=$db->select('tb_cash_receipt_payment','number="'.$d['number'].'" && status="0"','id_cash_receipt_payment','DESC');
				$jum_hasil=mysqli_num_rows($hasil);
				if($jum_hasil>0){
					$h=mysqli_fetch_assoc($hasil);
					$hitung=$h['amount']-$d['price'];
					$db->update('tb_cash_receipt_payment','amount="'.$hitung.'"','number="'.$h['number'].'"');
					$db->hapus('tb_cash_receipt_payment_detail','id_detail="'.$id.'"');
				}
				echo str_replace("=", "", base64_encode($d['number']));
			}

		}
	}
