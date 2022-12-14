<?php
	session_start();
	include_once "./../../../core/vendor/autoload.php";
                     
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Csv;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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

		if($proses=='new' && $_SESSION['cash_receipt_new']==1){
			if(!empty($_POST['amount']) && !empty($_POST['type_of_receipt']) && !empty($_SESSION['bank'])){

				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$type_of_receipt=mysqli_real_escape_string($db->query, $_POST['type_of_receipt']);
				$tanggal_bank_masuk=mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
				$dari=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dari']));
				$account_name=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_name']));
				$account_number=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

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

					$db->insert('tb_cash_receipt_payment','id_bank="'.$b['id_bank_cash'].'",number="'.$number.'",tanggal="'.$date_asli.'",tanggal_bank="'.$bank_date.'",type="i",id_type_of_receipt="'.$type_of_receipt.'",type_of_receipt="'.$gt['type_of_receipt'].'",dari="'.$dari.'",account_name="'.$account_name.'",account_number="'.$account_number.'",amount="'.$amount.'",urut="'.$urut.'",note="'.$note.'",input_data="'.$_SESSION['id_employee'].'"');

					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='edit' && $_SESSION['cash_receipt_edit']==1){
			if(!empty($_POST['amount']) && !empty($_POST['type_of_receipt']) && !empty($_SESSION['bank'])){

				$number=mysqli_real_escape_string($db->query, $_POST['number']);
				$bank=mysqli_real_escape_string($db->query, $_SESSION['bank']);
				$tanggal_bank_masuk=mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
				$dari=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dari']));
				$account_name=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_name']));
				$account_number=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

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

				$cek=$db->select('tb_cash_receipt_payment','number="'.$number.'" && type="i" && status="0"','id_cash_receipt_payment','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_cash_receipt_payment','tanggal_bank="'.$bank_date.'",dari="'.$dari.'",account_name="'.$account_name.'",account_number="'.$account_number.'",amount="'.$amount.'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','number="'.$number.'"');

					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}

			}
		}else if($proses=='cancel' && $_SESSION['cash_receipt_cancel']==1){
			$cek=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_receipt'].'" && status="1"','id_cash_receipt_payment','DESC');
			$jum=mysqli_num_rows($cek);
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

			}else{

				$db->update('tb_cash_receipt_payment','status="2"','number="'.$_SESSION['number_receipt'].'"');

			}
			echo str_replace("=", "", base64_encode($_SESSION['number_receipt']));
			
		}else if($proses=='process' && $_SESSION['cash_receipt_process']==1){

			$cek=$db->select('tb_cash_receipt_payment','number="'.$_SESSION['number_receipt'].'" && status="0"','id_cash_receipt_payment','DESC');

			$c=mysqli_fetch_assoc($cek);

			$bank=$db->select('tb_bank_cash','id_bank_cash="'.$c['id_bank'].'"','id_bank_cash','DESC');
			$b=mysqli_fetch_assoc($bank);

			$priod_date=substr($c['tanggal'], 0, -3); 

			$priod=$db->select('tb_priod','id_bank_cash="'.$c['id_bank'].'" && priod="'.$priod_date.'"','id_priod','DESC');
			$jum=mysqli_num_rows($priod);

			if(!empty($c['number_invoice'])){
				$status_byr=$db->select('tb_invoice','number_invoice="'.$c['number_invoice'].'"','id_invoice','DESC');

				$byr=mysqli_fetch_assoc($status_byr);
				if(!empty($byr['bayar'])){

					$total_byr=$c['amount']+$byr['bayar'];

					if($total_byr>=$byr['amount']){
						$db->update('tb_invoice','status_pembayaran="1",bayar="'.$total_byr.'"','number_invoice="'.$c['number_invoice'].'"');					
					}else{
						$db->update('tb_invoice','bayar="'.$total_byr.'"','number_invoice="'.$c['number_invoice'].'"');					
					}

				}else{

					if($c['amount']>=$byr['amount']){
						$db->update('tb_invoice','status_pembayaran="1",bayar="'.$c['amount'].'"','number_invoice="'.$c['number_invoice'].'"');
					}else{
						$db->update('tb_invoice','bayar="'.$c['amount'].'"','number_invoice="'.$c['number_invoice'].'"');
					}					

				}


			}

			if($jum>0){

				$p=mysqli_fetch_assoc($priod);

				$nominal=$b['nominal']+$c['amount'];

				$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

				$nominal_priod=$p['nominal']+$c['amount'];

				$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

				$db->update('tb_cash_receipt_payment','status="1",approved="'.$_SESSION['code_employee'].'"','number="'.$_SESSION['number_receipt'].'"');

			}else{
			
				$nominal=$b['nominal']+$c['amount'];

				$ambil_nilai=$db->select('tb_priod','id_bank_cash="'.$b['id_bank_cash'].'"','id_priod','DESC LIMIT 1');

				if(mysqli_num_rows($ambil_nilai)>0){
					$an=mysqli_fetch_assoc($ambil_nilai);
					$nominal_ambil=$c['amount']+$an['nominal'];
				}else{
					$nominal_ambil=$c['amount'];
				}

				$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$b['id_bank_cash'].'"');

				$db->insert('tb_priod','nominal="'.$nominal_ambil.'",priod="'.$priod_date.'",id_bank_cash="'.$c['id_bank'].'"');

				$db->update('tb_cash_receipt_payment','status="1",approved="'.$_SESSION['code_employee'].'"','number="'.$_SESSION['number_receipt'].'"');

			}

				echo str_replace("=", "", base64_encode($_SESSION['number_receipt']));

		}else if($proses=='upload' && $_SESSION['cash_receipt_new']==1){

			$tarik=$db->select('tb_ipl_upload','number_urut','number_urut','DESC');
			        	
			if(mysqli_num_rows($tarik)>0){
				$t=mysqli_fetch_assoc($tarik);
				$urut=$t['number_urut']+1;
			}else{
				$urut=1;
			}

			$_SESSION['urut']=$urut;

			$arr_file = explode('.', $_FILES['file_excel']['name']);
			$extension = end($arr_file);
					 
			if('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			}else{
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
					 
			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$jum_sheet = $spreadsheet->getSheetCount();
			

			$no=1;
			$html='<div class="col-lg-12" id="process" align="right"><button class="btn btn-sm btn-success" onclick="process_upload()">Proses</button> <button class="btn btn-sm btn-danger" id="cancel_upload" onclick="cancel_upload()">Batalkan</button></div><div class="scroll"><table class="table"><tr><td width="50px" align="center">No</td><td width="300px">Number Bast</td><td width="300px">Property,ID</td><td width="300px">Cluster</td><td width="300px">Kode Cluster</td><td width="300px">Nomor Rumah</td><td width="300px">Nama Pemilik</td><td width="300px">Total Invoice</td><td width="300px">Surface Area</td><td width="300px">IPL Tanah</td><td width="300px">Lebar Bangunan</td><td width="300px">UPL Bangunan</td><td width="300px">Total IPL Micro</td><td width="300px">Total IPL Macro</td><td width="300px">Due Date</td></tr>';

			for($r=0; $r<$jum_sheet; $r++){

				$total_semua=0;
				$sheetData = $spreadsheet->getSheet($r)->toArray();
				for($i = 6; $i < count($sheetData);$i++){
					

						$number_bast     	= $sheetData[$i]['0'];
						$property    		= $sheetData[$i]['1'];
						$cluster    		= $sheetData[$i]['2'];
						$code_cluster		= str_replace(" ", "", $sheetData[$i]['3']);
						$number    			= $sheetData[$i]['4'];
						$name    			= $sheetData[$i]['5'];
						$total_pembayaran	= str_replace(",", "", $sheetData[$i]['6']);
						$luas_tanah    		= str_replace(",", "", $sheetData[$i]['7']);
						$ipl_tanah	    	= str_replace(",", "", $sheetData[$i]['8']);
						$luas_bangunan		= str_replace(",", "", $sheetData[$i]['9']);
						$ipl_bangunan		= str_replace(",", "", $sheetData[$i]['10']);
						$micro				= str_replace(",", "", $sheetData[$i]['11']);
						$macro	    		= str_replace(",", "", $sheetData[$i]['12']);
						$due_date	   		= str_replace("-", "/", $sheetData[$i]['13']);


					if(!empty($number_bast)){
						$luas_bangunan		= str_replace(",", "", $sheetData[$i]['9']);

						            

						$db->insert('tb_ipl_upload','number_urut="'.$urut.'",number_bast="'.$number_bast.'",property="'.$property.'",cluster="'.$cluster.'",code_cluster="'.$code_cluster.'",number="'.$number.'",name="'.$name.'",total_pembayaran="'.$total_pembayaran.'",luas_tanah="'.$luas_tanah.'",ipl_tanah="'.$ipl_tanah.'",luas_bangunan="'.$luas_bangunan.'",ipl_bangunan="'.$ipl_bangunan.'",micro="'.$micro.'",macro="'.$macro.'",due_date="'.$due_date.'"');

						            $html=$html.'<tr><td align="center">'.$no.'.</td><td>'.$number_bast.'</td><td>'.$property.'</td><td>'.$cluster.'</td><td>'.$code_cluster.'</td><td>'.$number.'</td><td>'.$name.'</td><td>'.$total_pembayaran.'</td><td>'.$luas_tanah.'</td><td>'.$ipl_tanah.'</td><td>'.$luas_bangunan.'</td><td>'.$ipl_bangunan.'</td><td>'.$micro.'</td><td>'.$macro.'</td><td>'.$due_date.'</td></tr>';

						$total_semua=0;
						$no++;

					}

				}
			}

			$html=$html.'<tr><td align="center"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'.$total_semua.'</td><td></td></tr</table></div>';

			echo $html;

		}else if($proses=='cancel_upload' && $_SESSION['cash_receipt_new']==1){

			$db->hapus('tb_ipl_upload','number_urut="'.$_SESSION['urut'].'"');

		}else if($proses=='process_upload' && $_SESSION['cash_receipt_new']==1){

			$get_type_of_receipt = $db->select('tb_type_of_receipt','type_of_receipt LIKE "%IPL%"','id_type_of_receipt','ASC');
			$gt=mysqli_fetch_assoc($get_type_of_receipt);

			$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
			$b=mysqli_fetch_assoc($bank);

			$cek=$db->select('tb_cash_receipt_payment','id_bank="'.$_SESSION['bank'].'" && tanggal LIKE "%'.$date.'%" && type="i"','urut','DESC');

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

			$jum_amount=0;
			$priod="";
			$ipl=$db->select('tb_ipl_upload','number_urut="'.$_SESSION['urut'].'"','id_ipl_upload','ASC');

			foreach ($ipl as $key => $i) {

				$jum_chart=strlen($i['priod_mont']);

				if($jum_chart==1){
					$priod=$i['year_priod'].'-0'.$i['priod_mont'];
				}else{
					$priod=$i['year_priod'].'-'.$i['priod_mont'];
				}


				if($i['status']=='UNPAID' && empty($i['no_paymnet'])){

					$db->insert('tb_unpaid','code_population="'.$i['number_bast'].'",priod="'.$priod.'",nominal="'.$i['total_ipl_makro'].'"');

				}

				if(!empty($i['no_paymnet'])){
					
					$amount=$i['total_ipl_makro'];

					$jum_amount=$jum_amount+$amount;

					$cek_popupation=$db->select('tb_population','code_population="'.$i['number_bast'].'"','id_population','DESC');
					$cp=mysqli_fetch_assoc($cek_popupation);

					$db->insert('tb_cash_receipt_payment_detail','number="'.$number.'",id_population="'.$cp['id_population'].'",date="'.$i['paid_date'].'",price="'.$amount.'",no_payment="'.$i['no_paymnet'].'"');

					$cek_unpaid=$db->select('tb_unpaid','code_population="'.$i['number_bast'].'" && priod="'.$priod.'"','id_unpaid','DESC');

					if(mysqli_num_rows($cek_unpaid)>0){
						$cu=mysqli_fetch_assoc($cek_unpaid);
						$db->hapus('tb_unpaid','id_unpaid='.$cu['id_unpaid'].'"');
					}

					$priod_date=$date; 
					$priod_db=$db->select('tb_priod','id_bank_cash="'.$_SESSION['bank'].'" && priod="'.$priod_date.'"','id_priod','DESC');
					$jum=mysqli_num_rows($priod_db);

					$bank_amount = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
					$ba=mysqli_fetch_assoc($bank_amount);

					if($jum>0){

						$p=mysqli_fetch_assoc($priod_db);

						$nominal=$ba['nominal']+$amount;

						$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$_SESSION['bank'].'"');

						$nominal_priod=$p['nominal']+$amount;

						$db->update('tb_priod','nominal="'.$nominal_priod.'"','id_priod="'.$p['id_priod'].'"');

					}else{
					
						$nominal=$ba['nominal']+$amount;

						$ambil_nilai=$db->select('tb_priod','id_bank_cash="'.$_SESSION['bank'].'"','id_priod','DESC LIMIT 1');

						if(mysqli_num_rows($ambil_nilai)>0){
							$an=mysqli_fetch_assoc($ambil_nilai);
							$nominal_ambil=$amount+$an['nominal'];
						}else{
							$nominal_ambil=$amount;
						}

						$db->update('tb_bank_cash','nominal="'.$nominal.'"','id_bank_cash="'.$_SESSION['bank'].'"');

						$db->insert('tb_priod','nominal="'.$nominal_ambil.'",priod="'.$priod_date.'",id_bank_cash="'.$_SESSION['bank'].'"');

					}
				}
			}


			$tanggal_bank_proses=mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);

			$tanggal_bank=substr($tanggal_bank_proses, 0,2);
			$bulan_bank=substr($tanggal_bank_proses, 3,2);
			$tahun_bank=substr($tanggal_bank_proses, 6,4);
			$tanggal_bank_masuk_data=$tahun_bank.'-'.$bulan_bank.'-'.$tanggal_bank;

			$db->insert('tb_cash_receipt_payment','id_bank="'.$_SESSION['bank'].'",number="'.$number.'",tanggal="'.$date_asli.'",tanggal_bank="'.$tanggal_bank_masuk_data.'",type="i",id_type_of_receipt="'.$gt['id_type_of_receipt'].'",type_of_receipt="'.$gt['type_of_receipt'].'",dari="IPL",amount="'.$jum_amount.'",urut="'.$urut.'",status="1",approved="1",input_data="'.$_SESSION['id_employee'].'",priod="'.$priod.'"');

			echo $tanggal_bank_masuk_data;

		}
	}

?>