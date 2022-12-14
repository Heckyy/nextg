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

		if($proses=='new' && $_SESSION['invoice_new']==1){
			if(!empty($_POST['amount']) && !empty($_POST['dues_type'])){

				$dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				$warga=mysqli_real_escape_string($db->query, $_POST['warga']);
				$till_date=mysqli_real_escape_string($db->query, $_POST['till_date']);
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$tanggal_sampai=substr($till_date, 0,2);
				$bulan_sampai=substr($till_date, 3,2);
				$tahun_sampai=substr($till_date, 6,4);
				$till_date=$tahun_sampai.'-'.$bulan_sampai.'-'.$tanggal_sampai;

				$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
				$gt=mysqli_fetch_assoc($tb_dues);

				$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$number = 'INV/'.$bulan.'/'.$potong.'/1';

					$urut = "1";

				}

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

					$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$warga.'",amount="'.$amount.'",till_date="'.$till_date.'",bayar="0",note="'.$note.'",urut="'.$urut.'",input_data="'.$_SESSION['id_employee'].'"');

					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='new_all' && $_SESSION['invoice_new']==1){
			if(!empty($_POST['amount']) && !empty($_POST['dues_type'])){

				$dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$till_date=mysqli_real_escape_string($db->query, $_POST['till_date']);
				$rt=mysqli_real_escape_string($db->query, $_POST['rt']);
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$tanggal_sampai=substr($till_date, 0,2);
				$bulan_sampai=substr($till_date, 3,2);
				$tahun_sampai=substr($till_date, 6,4);
				$till_date=$tahun_sampai.'-'.$bulan_sampai.'-'.$tanggal_sampai;

				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$_SESSION['dues_type'] = $dues_type;

				$acak_gabung = mt_rand(0, 1000000000000);

				$cek_acak=$db->select('tb_invoice','acak="'.$acak_gabung.'"','id_invoice','DESC');

				if(mysqli_num_rows($cek_acak)>0){
					$acak_gabung = mt_rand(0, 1000000000000);
					$cek_acak_2=$db->select('tb_invoice','acak="'.$acak_gabung.'"','id_invoice','DESC');

					if(mysqli_num_rows($cek_acak_2)>0){
						$acak_gabung = mt_rand(0, 10000000000000);
					}

				}

				$acak_link=str_replace("=", "", base64_encode($acak_gabung));

				if($cluster=='all'){

					if($rt=='all'){

						$warga_data=$db->select('tb_warga','type="0" && status="0" || type="2" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}


								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');
						}

					}else{

						$warga_data=$db->select('tb_warga','id_rt="'.$rt.'" && status="0" || id_rt="'.$rt.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}
				}else{

					if($rt=='all'){

						$warga_data=$db->select('tb_warga','id_cluster="'.$cluster.'" && status="0" || id_cluster="'.$cluster.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}else{


						$warga_data=$db->select('tb_warga','id_cluster="'.$cluster.'" && id_rt="'.$rt.'" && status="0" || id_cluster="'.$cluster.'" && id_rt="'.$rt.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}

				}

				echo $acak_link;
				
			}

		}else if($proses=='new_dues' && $_SESSION['invoice_new']==1){
			if(!empty($_POST['dues_type'])){

				$dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);
				$till_date=mysqli_real_escape_string($db->query, $_POST['till_date']);
				$rt=mysqli_real_escape_string($db->query, $_POST['rt']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$tanggal_sampai=substr($till_date, 0,2);
				$bulan_sampai=substr($till_date, 3,2);
				$tahun_sampai=substr($till_date, 6,4);
				$till_date=$tahun_sampai.'-'.$bulan_sampai.'-'.$tanggal_sampai;

				$_SESSION['dues_type'] = $dues_type;

				$acak_gabung = mt_rand(0, 1000000000000);

				$cek_acak=$db->select('tb_invoice','acak="'.$acak_gabung.'"','id_invoice','DESC');

				if(mysqli_num_rows($cek_acak)>0){
					$acak_gabung = mt_rand(0, 1000000000000);
					$cek_acak_2=$db->select('tb_invoice','acak="'.$acak_gabung.'"','id_invoice','DESC');

					if(mysqli_num_rows($cek_acak_2)>0){
						$acak_gabung = mt_rand(0, 10000000000000);
					}
					
				}

				$acak_link=str_replace("=", "", base64_encode($acak_gabung));

				if($cluster=='all'){

					if($rt=='all'){

						$warga_data=$db->select('tb_warga','type="0" && status="0" || type="2" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$house_size=$db->select('tb_house_size','id_house_size="'.$p['id_house_size'].'"','id_house_size','DESC');
							$hs=mysqli_fetch_assoc($house_size);
							$amount=$hs['amount'];

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}


								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}else{


						$warga_data=$db->select('tb_warga','id_rt="'.$rt.'" && status="0" || id_rt="'.$rt.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$house_size=$db->select('tb_house_size','id_house_size="'.$p['id_house_size'].'"','id_house_size','DESC');
							$hs=mysqli_fetch_assoc($house_size);
							$amount=$hs['amount'];

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}
				}else{

					if($rt=='all'){

						$warga_data=$db->select('tb_warga','id_cluster="'.$cluster.'" && status="0" || id_cluster="'.$cluster.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$house_size=$db->select('tb_house_size','id_house_size="'.$p['id_house_size'].'"','id_house_size','DESC');
							$hs=mysqli_fetch_assoc($house_size);
							$amount=$hs['amount'];

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}else{


						$warga_data=$db->select('tb_warga','id_cluster="'.$cluster.'" && id_rt="'.$rt.'" && status="0" || id_cluster="'.$cluster.'" && id_rt="'.$rt.'" && status="0"','id_warga','ASC');

						foreach ($warga_data as $key => $p) {

							$house_size=$db->select('tb_house_size','id_house_size="'.$p['id_house_size'].'"','id_house_size','DESC');
							$hs=mysqli_fetch_assoc($house_size);
							$amount=$hs['amount'];

							$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
							$gt=mysqli_fetch_assoc($tb_dues);

							$cek=$db->select('tb_invoice','tanggal LIKE "%'.$date.'%"','urut','DESC');

							if(mysqli_num_rows($cek)>0){

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$c=mysqli_fetch_assoc($cek);

								$tambah = $c['urut']+1;

								$number = 'INV/'.$bulan.'/'.$potong.'/'.$tambah;

								$urut = $tambah;

							}else{

								$bulan = $library_class->bulan();
								$tahun = $library_class->tahun();
								$potong = substr($tahun,2);

								$number = 'INV/'.$bulan.'/'.$potong.'/1';

								$urut = "1";

							}

								$db->insert('tb_invoice','number_invoice="'.$number.'",tanggal="'.$date_asli.'",id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$p['id_warga'].'",amount="'.$amount.'",bayar="0",note="'.$note.'",urut="'.$urut.'",status="1",input_data="'.$_SESSION['id_employee'].'",acak="'.$acak_gabung.'",till_date="'.$till_date.'"');

						}

					}
				}

				echo $acak_link;
				
			}
			
		}else if($proses=='edit' && $_SESSION['invoice_edit']==1){
			if(!empty($_POST['amount']) && !empty($_POST['number'])){

				$number=mysqli_real_escape_string($db->query, $_POST['number']);
				$dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				$till_date=mysqli_real_escape_string($db->query, $_POST['till_date']);
				$warga=mysqli_real_escape_string($db->query, $_POST['warga']);
				$amount=mysqli_real_escape_string($db->query, $_POST['amount']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$tanggal_sampai=substr($till_date, 0,2);
				$bulan_sampai=substr($till_date, 3,2);
				$tahun_sampai=substr($till_date, 6,4);
				$till_date=$tahun_sampai.'-'.$bulan_sampai.'-'.$tanggal_sampai;
				
				$amount=str_replace(".", "", $amount);
				$amount=str_replace(",", ".", $amount);

				$tb_dues = $db->select('tb_dues','id_dues="'.$dues_type.'"','id_dues','ASC');
				$gt=mysqli_fetch_assoc($tb_dues);

				$cek=$db->select('tb_invoice','number_invoice="'.$number.'" && status="0"','id_invoice','DESC');

				if(mysqli_num_rows($cek)>0){

					$db->update('tb_invoice','id_dues="'.$dues_type.'",dues_type="'.$gt['dues_type'].'",id_warga="'.$warga.'",amount="'.$amount.'",bayar="0",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'",till_date="'.$till_date.'"','number_invoice="'.$number.'"');

					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}

			}
		}else if($proses=='rt'){

			if(!empty($_POST['cluster'])){

				$html='<option value="all">All</option>';

				$cluster=mysqli_real_escape_string($db->query, $_POST['cluster']);

				if($cluster=='all'){

					$rt=$db->select('tb_rt','id_rt','number','ASC');

					foreach ($rt as $key => $r) {
						$html.='<option value="'.$r['id_rt'].'">'.$r['number'].'</option>';
					}

				}else{

					$rt=$db->select('tb_rt','id_cluster="'.$cluster.'"','number','ASC');

					foreach ($rt as $key => $r) {
						$html.='<option value="'.$r['id_rt'].'">'.$r['number'].'</option>';
					}

				}

				echo $html;

			}


		}else if($proses=='cancel' && $_SESSION['invoice_cancel']==1){
			$db->update('tb_invoice','status="2"','number_invoice="'.$_SESSION['number_invoice'].'"');
			echo str_replace("=", "", base64_encode($_SESSION['number_invoice']));
		}else if($proses=='process'){
			$db->update('tb_invoice','status="1",approved="'.$_SESSION['code_employee'].'"','number_invoice="'.$_SESSION['number_invoice'].'"');
			echo str_replace("=", "", base64_encode($_SESSION['number_invoice']));
		}
	}

?>