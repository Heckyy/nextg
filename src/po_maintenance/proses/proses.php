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

		if($proses=='new' && $_SESSION['po_maintenance_new']==1){
			if(!empty($_POST['supplier'])){

				$supplier=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['supplier']));
				$id_request=mysqli_real_escape_string($db->query,$_POST['permintaan']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

				$cek=$db->select('tb_purchasing','type_of_purchase="2" && tanggal LIKE "%'.$date.'%"','urut','DESC');

				if(mysqli_num_rows($cek)>0){

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$c=mysqli_fetch_assoc($cek);

					$tambah = $c['urut']+1;

					$number = 'MP/'.$bulan.'/'.$potong.'/'.$tambah;

					$urut = $tambah;

				}else{

					$bulan = $library_class->bulan();
					$tahun = $library_class->tahun();
					$potong = substr($tahun,2);

					$number = 'MP/'.$bulan.'/'.$potong.'/1';

					$urut = "1";

				}

					
				$permintaan=$db->select('tb_request','id_request="'.$id_request.'"','id_request','ASC');
				$p=mysqli_fetch_assoc($permintaan);

				$total=0;
				$permintaan_detail=$db->select('tb_request_detail','number_request="'.$p['number_request'].'"','id_request_detail','ASC');
				while($pd=mysqli_fetch_assoc($permintaan_detail)){

					$acak=str_replace("=", "", base64_encode($pd['id_request_detail']));

					if(!empty($_POST['qty'.$acak]) && !empty($_POST['amount'.$acak])){
						$qty=mysqli_real_escape_string($db->query, $_POST['qty'.$acak]);
						$amount=mysqli_real_escape_string($db->query, $_POST['amount'.$acak]);			
						$amount=str_replace(".", "", $amount);

						if(!empty($qty) && !empty($amount)){

							$total=$total+($amount*$qty);

							$data_item=$db->select('tb_item','id_item="'.$pd['id_item'].'"','item','ASC');
							$i=mysqli_fetch_assoc($data_item);

							$db->insert('tb_purchasing_detail','number_purchasing="'.$number.'",id_item="'.$i['id_item'].'",item="'.$i['item'].'",qty="'.$qty.'",amount="'.$amount.'"');

						}
					}

				}

					$db->insert('tb_purchasing','number_purchasing="'.$number.'",tanggal="'.$date_asli.'",supplier="'.$supplier.'",number_request="'.$p['number_request'].'",id_cluster="'.$p['id_cluster'].'",id_position="'.$p['id_position'].'",id_population="'.$p['id_employee'].'",cluster="'.$p['cluster'].'",position="'.$p['position'].'",type_of_purchase="2",note="'.$note.'",total="'.$total.'",urut="'.$urut.'",bayar="0",input_data="'.$_SESSION['id_employee'].'"');


					echo str_replace("=", "", base64_encode($number));

				

			}
		}else if($proses=='edit' && $_SESSION['po_maintenance_edit']==1){
			if(!empty($_POST['number'])){

				$number=mysqli_real_escape_string($db->query, $_POST['number']);
				$note=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));	

				$purchasing=$db->select('tb_purchasing','number_purchasing="'.$number.'"','id_purchasing','DESC');

				if(mysqli_num_rows($purchasing)>0){

					$p=mysqli_fetch_assoc($purchasing);


					$total=0;
					$permintaan_detail=$db->select('tb_request_detail','number_request="'.$p['number_request'].'"','id_request_detail','ASC');
					while($pd=mysqli_fetch_assoc($permintaan_detail)){

						$purchasing_detail=$db->select('tb_purchasing_detail','number_purchasing="'.$p['number_purchasing'].'" && id_item="'.$pd['id_item'].'"','id_purchasing_detail','ASC');

						$acak=str_replace("=", "", base64_encode($pd['id_request_detail']));

						if(!empty($_POST['qty'.$acak]) && !empty($_POST['amount'.$acak])){
							$qty=mysqli_real_escape_string($db->query, $_POST['qty'.$acak]);
							$amount=mysqli_real_escape_string($db->query, $_POST['amount'.$acak]);			
							$amount=str_replace(".", "", $amount);

							if(!empty($qty) && !empty($amount)){

								$total=$total+($amount*$qty);

								$data_item=$db->select('tb_item','id_item="'.$pd['id_item'].'"','item','ASC');
								$i=mysqli_fetch_assoc($data_item);

								if(mysqli_num_rows($purchasing_detail)>0){

									$db->update('tb_purchasing_detail','qty="'.$qty.'",amount="'.$amount.'"','number_purchasing="'.$number.'" && id_item="'.$i['id_item'].'"');

								}else{

									$db->insert('tb_purchasing_detail','number_purchasing="'.$number.'",id_item="'.$i['id_item'].'",item="'.$i['item'].'",qty="'.$qty.'",amount="'.$amount.'"');
								}

							}
						}
					}




					$db->update('tb_purchasing','total="'.$total.'",note="'.$note.'",update_data="'.$_SESSION['id_employee'].'"','number_purchasing="'.$number.'"');


					echo str_replace("=", "", base64_encode($number));

				}else{

					echo "1";

				}

			}
		}else if($proses=='cancel' && !empty($_SESSION['number_purchasing']) && $_SESSION['po_maintenance_cancel']==1){
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
			
		}else if($proses=='process' && !empty($_SESSION['number_purchasing']) && $_SESSION['po_maintenance_process']==1){

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

		}else if($proses=='hapus' && $_SESSION['po_maintenance_edit']==1){

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

		}else if($proses=='permintaan_cluster'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$cek=$db->select('tb_request','id_request="'.$id.'"','id_request','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$r=mysqli_fetch_assoc($cek);
				echo '<option value="">Select</option>';
				echo '<option value="'.$r['id_cluster'].'" selected>'.$r['code_cluster'].' - '.$r['cluster'].'</option>';
			}else{
				echo '<option value="">Select</option>';
			}
		}else if($proses=='permintaan_divisi'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$cek=$db->select('tb_request','id_request="'.$id.'"','id_request','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$r=mysqli_fetch_assoc($cek);
				echo '<option value="">Select</option>';
				echo '<option value="'.$r['id_position'].'" selected>'.$r['position'].'</option>';
			}else{
				echo '<option value="">Select</option>';
			}
		}else if($proses=='permintaan_pengurus'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$cek=$db->select('tb_request','id_request="'.$id.'"','id_request','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$r=mysqli_fetch_assoc($cek);
				echo '<option value="">Select</option>';
				$e=mysqli_fetch_assoc($db->select('tb_employee','id_employee="'.$r['id_employee'].'"','id_employee','DESC'));
				echo '<option value="'.$r['id_employee'].'" selected>'.$e['name'].'</option>';
			}else{
				echo '<option value="">Select</option>';
			}
		}else if($proses=='permintaan_item'){
			$id=mysqli_real_escape_string($db->query, $_POST['id']);
			$cek=$db->select('tb_request','type_of_request="2" && id_request="'.$id.'"','id_request','DESC');
			$c=mysqli_fetch_assoc($cek);

			$detail=$db->select('tb_request_detail','number_request="'.$c['number_request'].'"','id_request_detail','DESC');

			$jum=mysqli_num_rows($cek);
			if($jum>0){
				$no=1;
				while($d=mysqli_fetch_assoc($detail)){
					$acak=str_replace("=", "", base64_encode($d['id_request_detail']));

					$po=$db->select('tb_purchasing INNER JOIN tb_purchasing_detail ON tb_purchasing.number_purchasing=tb_purchasing_detail.number_purchasing','number_request="'.$c['number_request'].'" && tb_purchasing_detail.id_item="'.$d['id_item'].'" && tb_purchasing.type_of_purchase="2" && tb_purchasing.status<2','tb_purchasing_detail.id_purchasing_detail','DESC');
					$jum_po=mysqli_num_rows($po);
					if($jum_po==0){
?>

						<tr>
							<td align="center">
								<?php echo $no; ?>
							</td>
							<td>
								<?php echo $d['item']; ?>
							</td>
							<td>
								<script type="text/javascript">
									var amount<?php echo $acak; ?> = document.getElementById("amount<?php echo $acak; ?>"); 

								    amount<?php echo $acak; ?>.addEventListener("keyup", function(e) { 
								        amount<?php echo $acak; ?>.value = convertRupiah(this.value); 
								    }); 

								    amount<?php echo $acak; ?>.addEventListener('keydown', function(event) { 
								        return isNumberKey(event); 
								    });
								</script>
								<input type="text" name="amount<?php echo $acak; ?>" id="amount<?php echo $acak; ?>" class="form-control" style="width:150px;" onchange="hitung('<?php echo $acak; ?>')">
							</td>
							<td><?php echo $d['qty']; ?></td>
							<td>
								<input type="number" min="0" name="qty<?php echo $acak; ?>" id="qty<?php echo $acak; ?>" class="form-control" style="width:150px;" value="<?php echo $d['qty']; ?>" onchange="hitung('<?php echo $acak; ?>')">
							</td>
							<td>
								<input type="text" name="total<?php echo $acak; ?>" id="total<?php echo $acak; ?>" class="form-control" style="width:150px;" disabled="disabled">
							</td>
						</tr>
<?php
						$no++;
					}
				}

			}else{

				echo '<tr><td colspan="6">Data not found!</td></tr>';

			}
		}else if($proses=='hitung'){
			$a=mysqli_real_escape_string($db->query, $_POST['a']);
			$b=mysqli_real_escape_string($db->query, $_POST['b']);

			if($a>0){
				$a=str_replace(".", "", $a);
				$a=str_replace(",", ".", $a);
			}else{
				$a=0;
			}

			if($b>0){
				$b=str_replace(".", "", $b);
				$b=str_replace(",", ".", $b);
			}else{
				$b=0;
			}

			$c=$a*$b;

			echo number_format($c,2,',','.');
		}
	}

?>