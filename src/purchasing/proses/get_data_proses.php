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

				if($select_bulan<10){
					$select_bulan="0".$select_bulan;
				}

				$priod=$select_tahun.'-'.$select_bulan;
			}else{
				$select_tahun=$library_class->tahun();
				$select_bulan=$library_class->bulan();	
				$priod=$select_tahun.'-'.$select_bulan;

			}



			$data = $db->selectpage('tb_purchasing','number_purchasing LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || note LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || supplier LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || cluster LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || code_cluster LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || note LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%" || type_of_purchase_text LIKE "%'.$ubah_pencarian.'%" && tanggal LIKE "%'.$priod.'%"','id_purchasing','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$ubah=str_replace("=", "", base64_encode($v['number_purchasing']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;

					if($v['type_of_purchase']==1){
						$type_of_purchase='PURCHASE';
					}else{
						$type_of_purchase='SERVICE';
					}

					if(!empty($v["total"])){
						$total=$v["total"];
					}else{
						$total=0;
					}

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"number":"'.$v["number_purchasing"].'",';
					$rows.='"supplier":"'.$v["supplier"].'",';
					$rows.='"type_of_purchase":"'.$type_of_purchase.'",';
					$rows.='"number_request":"'.$v["number_request"].'",';
					$rows.='"cluster":"'.$v["cluster"].'",';
					$rows.='"position":"'.$v["position"].'",';
					$rows.='"tanggal":"'.$date.'",';
					$rows.='"total":"'.number_format($total,2,',','.').'",';
					$rows.='"note":"'.$v["note"].'",';
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
			$total_semua=0;
			$html='<div class="box-detail"><div align="right"><button type="button" onclick="link_view(this);" class="btn btn-primary btn-sm btn-custom-show" data-id="'.$number.'"><i class="bi bi-eye"></i></button> <button type="button" onclick="hide_detail();" class="btn btn-danger btn-sm btn-custom-show"><i class="bi bi-x-circle"></i></button></div><table class="table"><thead><tr><td width="30px" align="center">No.</td><td>Item</td><td width="80px" align="center">Qty</td><td align="right">Price</td><td align="right">Total</td></tr></thead><tbody>';

			$detail=$db->select('tb_purchasing_detail INNER JOIN tb_item ON tb_purchasing_detail.id_item=tb_item.id_item','tb_purchasing_detail.number_purchasing="'.$number_decode.'"','tb_purchasing_detail.id_purchasing_detail','DESC','tb_purchasing_detail.id_purchasing_detail,tb_purchasing_detail.qty,tb_purchasing_detail.amount,tb_item.item');
			foreach ($detail as $key => $d) {
				$total=$d['qty']*$d['amount'];
				$total_semua=$total_semua+$total;
				$html=$html.'<tr><td align="center">'.$no.'</td><td>'.$d['item'].'</td><td align="center">'.$d['qty'].' '.$d['unit'].'</td><td align="right">'.number_format($d['amount'],2,',','.').'</td><td align="right">'.number_format($total,2,',','.').'</td></tr>';
				$no++;
			}

			$html=$html.'<tr><td colspan="4" align="right"><b>Total :</b></td><td align="right"><b>'.number_format($total,2,',','.').'</b></td></tr></tbody></table></div>';

			echo $html;
		}
		

	}
?>
