<?php
	error_reporting(0);
	session_start();

	if(!empty($_SESSION['id_employee']) && !empty($_POST['proses'])){
		include_once "./../../../core/file/function_proses.php";
		include_once "./../../../core/file/library.php";
		$db = new db();
		$library_class = new library_class();


		if($_POST['proses']=='tarik_data'){

			$e=mysqli_fetch_assoc($db->select('tb_settings','id_settings','id_settings','DESC'));


			$bank = $db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
			$b=mysqli_fetch_assoc($bank);

			if(!empty($_POST['cari'])){
				$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			}else{
				$ubah_pencarian="";
			}

			if(!empty($_POST['bulan']) && !empty($_POST['tahun']) && !empty($_POST['bank'])){
				$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
				$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);
				$select_bank=mysqli_real_escape_string($db->query, $_POST['bank']);

				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}

				$priod=$select_tahun.'-'.$select_bulan;

			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;
				
				if(!empty($_SESSION['bank'])){
					$select_bank=$_SESSION['bank'];
				}else{
					$select_bank=$b['id_bank_cash'];
				}
			}

			if($select_bank=='all'){
				$data_bank='';
				$data_bank_priod='';
			}else{
				$data_bank='id_bank="'.$select_bank.'" &&';
				$data_bank_priod='id_bank_cash="'.$select_bank.'" && ';
			}

			$data = $db->select('tb_cash_receipt_payment',$data_bank.' tanggal LIKE "%'.$priod.'%" && number LIKE "%'.$ubah_pencarian.'%" && status="1" || '.$data_bank.' tanggal LIKE "%'.$priod.'%" && dari LIKE "%'.$ubah_pencarian.'%" && status="1" || '.$data_bank.' tanggal LIKE "%'.$priod.'%" && type_of_payment LIKE "%'.$ubah_pencarian.'%" && status="1"','id_cash_receipt_payment','ASC');

			$no=1;
			$i=1;

			$kurang_priod = date('Y-m', strtotime('-1 month', strtotime( $priod )));



				$priod_data=$db->select('tb_priod',$data_bank_priod.'priod<"'.$priod.'"','id_priod','DESC');
				$jum_data_awal=mysqli_num_rows($priod_data);

			
			

				$total=0;
				$receipt_asli=0;
				$payment_asli=0;

				$rows = '[';

				if($jum_data_awal>0){

					$pd=mysqli_fetch_assoc($priod_data);

					$receipt_asli=$receipt_asli+$pd['nominal'];
					$receipt='Rp.'.number_format($pd['nominal'],2,',','.');
					$total=$total+$pd['nominal'];

					$rows.='{"no":"1",';
					$rows.='"number":" ",';
					$rows.='"type_of_transaction":" ",';
					$rows.='"dari_untuk":" Beging Balance",';
					$rows.='"bank_cash":"",';
					$rows.='"receipt":"'.$receipt.'",';
					$rows.='"receipt_asli":"Rp.'.number_format($receipt_asli,2,',','.').'",';
					$rows.='"payment":" ",';
					$rows.='"payment_asli":" ",';
					$rows.='"total":"Rp.'.number_format($total,2,',','.').'"}';
					$no++;

				}

			if(mysqli_num_rows($data) > 0 ){

				if($jum_data_awal>0){
					$rows.=",";
				}
			
				$jum=mysqli_num_rows($data);


				foreach ($data as $key => $v) {

					$bank_data = $db->select('tb_bank_cash','id_bank_cash="'.$v['id_bank'].'"','bank_cash','ASC');
					$bd=mysqli_fetch_assoc($bank_data);

					if(!empty($v['type_of_receipt'])){
						$type_of_transaction=$v['type_of_receipt'];
						$dari_untuk=$v['dari'];
						$receipt='Rp.'.number_format($v['amount'],2,',','.');
						$receipt_asli=$receipt_asli+$v['amount'];
						$payment='';
						$payment_asli=$payment_asli+0;
						$total=$total+$v['amount'];
					}else{
						$type_of_transaction=$v['type_of_payment'];
						$dari_untuk=$v['untuk'];
						$receipt='';
						$receipt_asli=$receipt_asli+0;
						$payment='Rp.'.number_format($v['amount'],2,',','.');
						$payment_asli=$payment_asli+$v['amount'];
						$total=$total-$v['amount'];
					}


						$rows.='{"no":"'.$no.'",';
						$rows.='"number":"'.$v["number"].'",';
						$rows.='"type_of_transaction":"'.$type_of_transaction.'",';
						$rows.='"dari_untuk":"'.$dari_untuk.'",';
						$rows.='"bank_cash":"'.$bd['bank_cash'].'",';
						$rows.='"receipt":"'.$receipt.'",';
						$rows.='"receipt_asli":"Rp.'.number_format($receipt_asli,2,',','.').'",';
						$rows.='"payment":"'.$payment.'",';
						$rows.='"payment_asli":"Rp.'.number_format($payment_asli,2,',','.').'",';
						$rows.='"total":"Rp.'.number_format($total,2,',','.').'"}';

						$no++;

						if($i<$jum){
							$rows .= ",";
							$i++;
						}
				}

				$rows = $rows.']';

				echo $rows;

			}else{

				if($jum_data_awal>0){
					$rows = $rows.']';

					echo $rows;
				}else{
					echo "0";
				}

			}

		}
	}
?>
