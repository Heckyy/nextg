<?php
	session_start();
	if(!empty($_POST['proses']) && !empty($_SESSION['id_employee'])){
		include_once "./../../../core/file/function_proses.php";
		include_once "./../../../core/file/library.php";
		$db = new db();
		$library_class = new library_class();

		$proses=mysqli_real_escape_string($db->query, $_POST['proses']);

		if($proses=='new' && $_SESSION['purchasing_new']==1){
			if(!empty($_POST['supplier'])){

		     	$tanggal_input_data = mysqli_real_escape_string($db->query, $_POST['tanggal']);
				$supplier			= mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['supplier']));
		     	$type_of_purchase 	= mysqli_real_escape_string($db->query, $_POST['type_of_purchase']);
		     	$divisi        		= mysqli_real_escape_string($db->query, $_POST['divisi']);
		     	$cluster        	= mysqli_real_escape_string($db->query, $_POST['cluster']);
		     	$employee        	= mysqli_real_escape_string($db->query, $_POST['employee']);
				$note				= mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
		     	$item        		= mysqli_real_escape_string($db->query, $_POST['item']);
		     	$qty        		= mysqli_real_escape_string($db->query, $_POST['qty']);
		     	$unit        		= mysqli_real_escape_string($db->query, $_POST['unit']);
		     	$amount        		= mysqli_real_escape_string($db->query, $_POST['amount']);

				$qty=str_replace(".", "", $qty);
		     	$qty=str_replace(",", ".", $qty);

		     	$amount=str_replace(".", "", $amount);
		     	$amount=str_replace(",", ".", $amount);

				$tanggal_input=substr($tanggal_input_data, 0,2);
				$bulan_input=substr($tanggal_input_data, 3,2);
				$tahun_input=substr($tanggal_input_data, 6,4);
				$input_date=$tahun_input.'-'.$bulan_input.'-'.$tanggal_input;
				$date_input=$tahun_input.'-'.$bulan_input;


				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);

				$cek=$db->select('tb_purchasing','tanggal LIKE "%'.$date_input.'%"','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$potong = substr($tahun_input,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'PO/'.$bulan_input.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$potong = substr($tahun_input,2);

					$number = 'PO/'.$bulan_input.'/'.$potong.'/1';

					$urut = "1";

				}

					$data_item=$db->select('tb_item','id_item="'.$item.'"','item','ASC');
					$i=mysqli_fetch_assoc($data_item);


					$db->insert('tb_purchasing_detail','number_purchasing="'.$number.'",id_item="'.$i['id_item'].'",item="'.$i['item'].'",qty="'.$qty.'",unit="'.$unit.'",amount="'.$amount.'"');


					if($type_of_purchase==1){
						$type_of_purchase_text='PURCHASE';
					}else{
						$type_of_purchase_text='SERVICE';
					}

					$db->insert('tb_purchasing','number_purchasing="'.$number.'",tanggal="'.$input_date.'",type_of_purchase="'.$type_of_purchase.'",type_of_purchase_text="'.$type_of_purchase_text.'",supplier="'.$supplier.'",id_cluster="'.$cq['id_cluster'].'",id_position="'.$pq['id_position'].'",id_population="'.$employee.'",cluster="'.$cq['cluster'].'",code_cluster="'.$cq['code_cluster'].'",position="'.$pq['position'].'",note="'.$note.'",total="'.$amount.'",urut="'.$urut.'",bayar="0",input_data="'.$_SESSION['id_employee'].'"');

					echo str_replace("=", "", base64_encode($number));


			}
		}else if($proses=='edit' && $_SESSION['purchasing_edit']==1){
			if(!empty($_POST['number'])){

				$number 			= mysqli_real_escape_string($db->query, $_POST['number']);
		     	$divisi        		= mysqli_real_escape_string($db->query, $_POST['divisi']);
		     	$cluster        	= mysqli_real_escape_string($db->query, $_POST['cluster']);
		     	$employee        	= mysqli_real_escape_string($db->query, $_POST['employee']);
				$note				= mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
		     	$item        		= mysqli_real_escape_string($db->query, $_POST['item']);
		     	$qty        		= mysqli_real_escape_string($db->query, $_POST['qty']);
		     	$unit        		= mysqli_real_escape_string($db->query, $_POST['unit']);
		     	$amount        		= mysqli_real_escape_string($db->query, $_POST['amount']);

		     	$qty=str_replace(".", "", $qty);
		     	$qty=str_replace(",", ".", $qty);
		     	
		     	$amount=str_replace(".", "", $amount);
		     	$amount=str_replace(",", ".", $amount);

				$cluster_query=$db->select('tb_cluster','id_cluster="'.$cluster.'"','id_cluster','DESC');
				$position_query=$db->select('tb_position','id_position="'.$divisi.'"','id_position','DESC');

				$cq=mysqli_fetch_assoc($cluster_query);
				$pq=mysqli_fetch_assoc($position_query);

				$purchasing=$db->select('tb_purchasing','number_purchasing="'.$number.'"','id_purchasing','DESC');

				if(mysqli_num_rows($purchasing)>0){

					$p=mysqli_fetch_assoc($purchasing);

						$purchasing_detail=$db->select('tb_purchasing_detail','number_purchasing="'.$p['number_purchasing'].'" && id_item="'.$item.'"','id_purchasing_detail','ASC');

						$data_item=$db->select('tb_item','id_item="'.$item.'"','item','ASC');
						$i=mysqli_fetch_assoc($data_item);

						if(mysqli_num_rows($purchasing_detail)>0){

							$db->update('tb_purchasing_detail','qty="'.$qty.'",unit="'.$unit.'",amount="'.$amount.'"','number_purchasing="'.$number.'" && id_item="'.$i['id_item'].'"');

						}else{

							$db->insert('tb_purchasing_detail','number_purchasing="'.$number.'",id_item="'.$i['id_item'].'",item="'.$i['item'].'",qty="'.$qty.'",unit="'.$unit.'",amount="'.$amount.'"');
						}

				}

				$total=0;
				$purchasing_detail_total=$db->select('tb_purchasing_detail','number_purchasing="'.$number.'"','id_purchasing_detail','ASC');
				while($pdt=mysqli_fetch_assoc($purchasing_detail_total)){
					$kali=$pdt['qty']*$pdt['amount'];
					$total=$total+$kali;
				}




					$db->update('tb_purchasing','id_cluster="'.$cq['id_cluster'].'",id_position="'.$pq['id_position'].'",id_population="'.$employee.'",cluster="'.$cq['cluster'].'",code_cluster="'.$cq['code_cluster'].'",position="'.$pq['position'].'",note="'.$note.'",total="'.$total.'",update_data="'.$_SESSION['id_employee'].'"','number_purchasing="'.$number.'"');


					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}
		}else if($proses=='cancel' && !empty($_SESSION['number_purchasing']) && $_SESSION['purchasing_cancel']==1){
			$cek=$db->select('tb_purchasing','number_purchasing="'.$_SESSION['number_purchasing'].'"','id_purchasing','DESC');
			$jum=mysqli_num_rows($cek);

			if($jum>0){
				$c=mysqli_fetch_assoc($cek);

				$cek_pembayaran=$db->select('tb_cash_receipt_payment','number_purchasing="'.$_SESSION['number_purchasing'].'"','id_cash_receipt_payment','DESC');
				$jum_pembayaran=mysqli_num_rows($cek_pembayaran);
				
				if($jum_pembayaran==0){

					$db->update('tb_purchasing','status="2"','number_purchasing="'.$_SESSION['number_purchasing'].'"');
					$db->update('tb_request','status_purchasing="0"','number_request="'.$c['number_request'].'"');

				}else{

					$cb=mysqli_fetch_assoc($cek_pembayaran);
					if($cb['status']==2){

						$db->update('tb_request','status_purchasing="0"','number_request="'.$c['number_request'].'"');
						$db->update('tb_purchasing','status="2"','number_purchasing="'.$_SESSION['number_purchasing'].'"');

					}

				}

			}

				echo str_replace("=", "", base64_encode($_SESSION['number_purchasing']));
			
		}else if($proses=='process' && !empty($_SESSION['number_purchasing']) && $_SESSION['purchasing_process']==1){

			$cek=$db->select('tb_purchasing','number_purchasing="'.$_SESSION['number_purchasing'].'" && status="0"','id_purchasing','DESC');
			$jum=mysqli_num_rows($cek);
			$p=mysqli_fetch_assoc($cek);

			$total="0";

			$cek_detail=$db->select('tb_purchasing_detail','number_purchasing="'.$_SESSION['number_purchasing'].'"','id_purchasing_detail','ASC');

			foreach ($cek_detail as $key => $cd) {
							
				$total=$total+($cd['qty']*$cd['amount']);

			}

			if($jum>0){


				$jumlah_po_detail=0;

				$cek_request_po=$db->select('tb_purchasing','number_request="'.$p['number_request'].'" && status="1"','id_purchasing','DESC');
				while ($cr=mysqli_fetch_assoc($cek_request_po)) {
					$cek_po_detail=$db->select('tb_purchasing_detail','number_purchasing="'.$cr['number_purchasing'].'"','id_purchasing_detail','DESC');
					$jumlah_po_detail=$jumlah_po_detail+mysqli_num_rows($cek_po_detail);
				}

				$cek_po_detail=$db->select('tb_purchasing_detail','number_purchasing="'.$_SESSION['number_purchasing'].'"','id_purchasing_detail','DESC');
					$jumlah_po_detail=$jumlah_po_detail+mysqli_num_rows($cek_po_detail);

				$cek_request=$db->select('tb_request_detail','number_request="'.$p['number_request'].'"','id_request_detail','DESC');
				$jumlah_request_detail=mysqli_num_rows($cek_request);

				if($jumlah_po_detail==$jumlah_request_detail){
					$db->update('tb_request','status_purchasing="1"','number_request="'.$p['number_request'].'"');
				}

				$db->update('tb_purchasing','total="'.$total.'",status="1"','number_purchasing="'.$_SESSION['number_purchasing'].'"');

			}
				echo str_replace("=", "", base64_encode($_SESSION['number_purchasing']));

		}else if($proses=='hapus' && $_SESSION['purchasing_edit']==1){

			$id=mysqli_real_escape_string($db->query, base64_decode($_POST['id']));

			$cek=$db->select('tb_purchasing_detail','id_purchasing_detail="'.$id.'"','id_purchasing_detail','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$d=mysqli_fetch_assoc($cek);

				$hasil=$db->select('tb_purchasing','number_purchasing="'.$d['number_purchasing'].'" && status="0"','id_purchasing','DESC');
				$jum_hasil=mysqli_num_rows($hasil);
				if($jum_hasil>0){
					$db->hapus('tb_purchasing_detail','id_purchasing_detail="'.$id.'"');
				}
				echo str_replace("=", "", base64_encode($d['number_purchasing']));
			}

		}else if($proses=='item'){
			$type_of_purchase=mysqli_real_escape_string($db->query, $_POST['type_of_purchase']);

			if($type_of_purchase==2){
				$type_of_purchase='type_of_item="3"';
			}else{
				$type_of_purchase='type_of_item!="3"';
			}

			$item=$db->select('tb_item',$type_of_purchase,'id_item','DESC');
			$jum_item=mysqli_num_rows($item);

				echo '<option value="">Select</option>';

			foreach ($item as $key => $i) {
				echo '<option value="'.$i['id_item'].'">'.$i['item'].'</option>';
			}
			if($jum_item==0){
				echo '<option value="">Select</option>';
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