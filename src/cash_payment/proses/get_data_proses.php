<?php
	session_start();

	if(!empty($_SESSION['id_employee']) && !empty($_POST['proses'])){
		include_once "./../../../core/file/function_proses.php";
		include_once "./../../../core/file/library.php";
		$db = new db();
		$library_class = new library_class();

		if($_POST['proses']=='tarik_data'){


			$perPage = 10;
			if (isset($_POST["page"])) { 
				$page  = $_POST["page"]; 
			} else { 
				$page=1; 
			};  
			$startFrom = ($page-1) * $perPage;  

			$e=mysqli_fetch_assoc($db->select('tb_settings','id_settings','id_settings','DESC'));

			$bank = $db->select('tb_bank_cash','id_bank_cash="'.$_SESSION['bank'].'"','bank_cash','ASC');
			$b=mysqli_fetch_assoc($bank);

			if(!empty($_POST['cari'])){
				$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			}else{
				$ubah_pencarian="";
			}

			if(!empty($_POST['bulan']) && !empty($_POST['tahun'])){
				$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
				$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);

				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}

				$priod=$select_tahun.'-'.$select_bulan;
			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;
				
			}



			$data = $db->selectpage('tb_cash_receipt_payment','number LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && id_bank="'.$b['id_bank_cash'].'" && type="o" || type_of_receipt  LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" && id_bank="'.$b['id_bank_cash'].'" && type="o"','id_cash_receipt_payment','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;

					if(!empty($v['tanggal_bank'])){
						$tanggal_bank=substr($v['tanggal_bank'], 8,2);
						$bulan_bank=substr($v['tanggal_bank'], 5,2);
						$tahun_bank=substr($v['tanggal_bank'], 0,4);
						$date_bank=$tanggal_bank."-".$bulan_bank."-".$tahun_bank;
					}else{
						$date_bank="";
					}

					if(!empty($v['number_purchasing'])){
						$target_folder="view-purchasing";
					}else{
						$target_folder="view";
					}


					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"folder":"'.$target_folder.'",';
					$rows.='"number":"'.$v["number"].'",';
					$rows.='"tanggal":"'.$date.'",';
					$rows.='"cluster":"'.$v['cluster'].'",';
					$rows.='"position":"'.$v['position'].'",';
					$rows.='"untuk":"'.$v["untuk"].'",';
					$rows.='"nama_akun":"'.$v["nama_akun"].'",';
					$rows.='"amount":"'.number_format($v["amount"],2,',','.').'",';
					$rows.='"status":"'.$v['status'].'"}'; 

					$no++;

					if($i<$jum){
						$rows .= ",";
						$i++;
					}
				}

				$rows = $rows.']';

				echo $rows;

			}
		}
		if($_POST['proses']=='detail_item'){
			$number=mysqli_real_escape_string($db->query, $_POST['number']);
			$number_decode=base64_decode($number);

			$total=0;
			$no=1;
			$html='<div class="box-detail"><div align="right"><button type="button" onclick="link_view(this);" class="btn btn-primary btn-sm btn-custom-show" data-id="'.$number.'" data-folder="view"><i class="bi bi-eye"></i></button> <button type="button" onclick="hide_detail();" class="btn btn-danger btn-sm btn-custom-show"><i class="bi bi-x-circle"></i></button></div><table class="table"><thead><tr><td width="30px" align="center">No.</td><td>Necessity</td><td width="80px" align="right">Amount</td></tr></thead><tbody>';
			$detail=$db->select('tb_cash_receipt_payment_detail','number="'.$number_decode.'"','id_detail','DESC','necessity,price');
			foreach ($detail as $key => $d) {

				$html=$html.'<tr><td align="center">'.$no.'</td><td>'.$d['necessity'].'</td><td align="right">'.number_format($d['price'],2,',','.').'</td></tr>';
				$total=$total+$d['price'];
				$no++;
			}

			$html=$html.'<tr><td colspan="2" align="right"><b>Total :</b></td><td align="right"><b>'.number_format($total,2,',','.').'</b></td></tr></tbody></table></div>';

			echo $html;
		}

	}
?>
