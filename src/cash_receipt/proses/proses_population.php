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

		if($proses=='new' && $_SESSION['receipt_from_population']==1){
			if(!empty($_POST['amount']) && !empty($_POST['invoice']) && !empty($_POST['type_of_receipt']) && !empty($_SESSION['bank'])){

				$invoice=mysqli_real_escape_string($db->query, $_POST['invoice']);
				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$type_of_receipt=mysqli_real_escape_string($db->query, $_POST['type_of_receipt']);
				$tanggal_bank_masuk=mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
				$account_name=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_name']));
				$account_number=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$data_invoice = $db->select('tb_invoice','number_invoice="'.$invoice.'"','id_invoice','ASC');
				$di=mysqli_fetch_assoc($data_invoice);

				$data_warga = $db->select('tb_warga','id_warga="'.$di['id_warga'].'"','id_warga','ASC');
				$dp=mysqli_fetch_assoc($data_warga);

					if(!empty($tanggal_bank_masuk)){
						$tanggal_bank=substr($tanggal_bank_masuk, 0,2);
						$bulan_bank=substr($tanggal_bank_masuk, 3,2);
						$tahun_bank=substr($tanggal_bank_masuk, 6,4);
						$bank_date=$tahun_bank.'-'.$bulan_bank.'-'.$tanggal_bank;
					}else{
						$bank_date=$date_asli;
					}

					$amount=str_replace(".", "", $amount);
					$amount=str_replace(",", ".", $amount);

					$get_type_of_receipt = $db->select('tb_type_of_receipt','id_type_of_receipt="'.$type_of_receipt.'"','id_type_of_receipt','ASC');
					$gt=mysqli_fetch_assoc($get_type_of_receipt);

					$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
					$b=mysqli_fetch_assoc($bank);

					$cek=$db->select('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'" && tanggal LIKE "%'.$date.'%" && type="i"','urut','DESC');

					if(mysqli_num_rows($cek)>0){

						$bulan = $library_class->bulan();
						$tahun = $library_class->tahun();
						$potong = substr($tahun,2);

						$c=mysqli_fetch_assoc($cek);

						$tambah = $c['urut']+1;

						$number = 'R'.$b['code_bank_cash'].'/'.$bulan.'/'.$potong.'/'.$tambah;

						$urut = $tambah;

					}else{

						$bulan = $library_class->bulan();
						$tahun = $library_class->tahun();
						$potong = substr($tahun,2);

						$number = 'R'.$b['code_bank_cash'].'/'.$bulan.'/'.$potong.'/1';

						$urut = "1";

					}

					$bayar=$di['bayar']+$amount;

					if($di['amount']>=$bayar){

						if($di['amount']==$bayar || $bayar>$di['amount']){
							$status_pembayaran=',status_pembayaran="1"';
						}else{
							$status_pembayaran=',status_pembayaran="0"';
						}

						$db->insert('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'",number="'.$number.'",tanggal="'.$date_asli.'",tanggal_bank="'.$bank_date.'",type="i",id_type_of_receipt="'.$type_of_receipt.'",type_of_receipt="'.$gt['type_of_receipt'].'",dari="'.$dp['name'].'",account_name="'.$account_name.'",account_number="'.$account_number.'",amount="'.$amount.'",urut="'.$urut.'",note="'.$note.'",number_invoice="'.$di['number_invoice'].'",id_warga="'.$di['id_warga'].'",id_dues="'.$di['id_dues'].'",input_data="'.$_SESSION['id_employee'].'",status="1"');

						$db->update('tb_invoice','bayar="'.$bayar.'"'.$status_pembayaran,'number_invoice="'.$di['number_invoice'].'"');


						$priod=$db->select('tb_priod','id_bank_cash="'.$c['id_bank'].'" && priod="'.$date.'"','id_priod','DESC');
						$jum=mysqli_num_rows($priod);

						if($jum>0){

							$p=mysqli_fetch_assoc($priod);

							$nominal=$b['nominal']+$amount;

							$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

							$nominal_priod=$p['nominal']+$amount;

							$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

						}else{
						
							$nominal=$b['nominal']+$amount;

							$ambil_nilai=$db->select('tb_priod','id_priod','id_priod','DESC LIMIT 1');

							if(mysqli_num_rows($ambil_nilai)>0){
								$an=mysqli_fetch_assoc($ambil_nilai);
								$nominal_ambil=$amount+$an['nominal'];
							}else{
								$nominal_ambil=$amount;
							}


							$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

							$db->insert('tb_priod','nominal="'.$cnominal_ambil.'",priod="'.$date.'",id_bank_cash="'.$c['id_bank'].'"');

						}
	
						echo str_replace("=", "", base64_encode($number));

					}else{

						echo "1";

					}


				

			}
		}else if($proses=='cancel' && $_SESSION['cash_receipt_cancel']==1){
			$cek=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_receipt'].'" && status="1"','id_cash_receipt_payment','DESC');
			$jum=mysqli_num_rows($cek);

			$acak= str_replace("=", "", base64_encode($_SESSION['number_receipt']));

			$link="";
			if($jum>0){
				$c=mysqli_fetch_assoc($cek);

				if(!empty($c['number_invoice'])){

					$status_byr=$db->select('tb_invoice','number_invoice="'.$c['number_invoice'].'"','id_invoice','DESC');
					$byr=mysqli_fetch_assoc($status_byr);
					$total_byr=$byr['bayar']-$c['amount'];
					$db->update('tb_invoice','bayar="'.$total_byr.'",status_pembayaran="0"','number_invoice="'.$c['number_invoice'].'"');
					
				}

				$priod_date=substr($c['tanggal'], 0, -3); 

				$bank=$db->select('tb_bank_cash','id_bank_cash="'.$c['id_bank'].'"','id_bank_cash','DESC');
				$b=mysqli_fetch_assoc($bank);

				$nominal=$b['nominal']-$c['amount'];

				$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

				$priod=$db->select('tb_priod','id_bank_cash="'.$c['id_bank'].'" && priod="'.$priod_date.'"','id_priod','DESC');
				$p=mysqli_fetch_assoc($priod);

				$nominal_priod=$p['nominal']-$c['amount'];

				$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

				$db->update('tb_cash_receipt_payment','status="2"','number="'.$_SESSION['number_receipt'].'"');

				if(!empty($c['number_invoice'])){
					$link='view-invoice/'.$acak;
				}else if(!empty($c['priod'])){
					$link='view-ipl/'.$acak;
				}
			}
			
		}
	}

?>