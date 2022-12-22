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

			if(!empty($_POST['cari'])){
				$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			}else{
				$ubah_pencarian="";
			}

			if(!empty($_POST['bulan']) && !empty($_POST['tahun'])){
				$select_tahun=mysqli_real_escape_string($db->query, $_POST['tahun']);
				$select_bulan=mysqli_real_escape_string($db->query, $_POST['bulan']);

				if($select_bulan>12){
					$priod=$select_tahun;
				}
				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}
				if($select_bulan<13){
					$priod=$select_tahun.'-'.$select_bulan;
				}
				
				
			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;

			}



			$data = $db->selectpage('tb_inv_purchasing','number_inv_purchasing LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || supplier LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" ','id_inv_purchasing','DESC',$startFrom,$perPage);
			// var_dump($data);

			// Backup Query
			// $data = $db->selectpage('tb_inv_purchasing','number_inv_purchasing LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || supplier LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || position LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || code_cluster LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || employee LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%"','id_request','DESC',$startFrom,$perPage);

			$no=$startFrom+1;



			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number_inv_purchasing']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;
					$note="";
					$total = "Rp " . number_format($v['total'],2,',','.');
					if($v['note']==Null){
						$note = "-";
					}else{
						$note = $v['note'];
					}

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"number":"'.$v["number_inv_purchasing"].'",';
					$rows.='"tanggal":"'.$v['tanggal'].'",';
					$rows.='"supplier":"'.$v["supplier"].'",';
					$rows.='"total":"'.$total.'",';
					 $rows.='"note":"'.$note.'",';
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

			$no=1;
			$html='<div class="box-detail"><div align="right"><button type="button" onclick="link_view(this);" class="btn btn-primary btn-sm btn-custom-show" data-id="'.$number.'"><i class="bi bi-eye"></i></button> <button type="button" onclick="hide_detail();" class="btn btn-danger btn-sm btn-custom-show"><i class="bi bi-x-circle"></i></button></div><table class="table"><thead><tr><td width="30px" align="center">No.</td><td>Item</td><td width="80px" align="center">Qty</td></tr></thead><tbody>';
			$detail=$db->select('tb_request_detail INNER JOIN tb_item ON tb_request_detail.id_item=tb_item.id_item','tb_request_detail.number_request="'.$number_decode.'"','tb_request_detail.id_request_detail','DESC','tb_request_detail.id_request_detail,tb_request_detail.qty,tb_request_detail.unit,tb_request_detail.note,tb_item.item');
			foreach ($detail as $key => $d) {

				$html=$html.'<tr><td align="center">'.$no.'</td><td>'.$d['item'].'</td><td align="center">'.$d['qty'].' '.$d['unit'].'</td></tr>';
				$no++;
			}

			$html=$html.'</tbody></table></div>';

			echo $html;
		}
		

	}
