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
		$proses= $_POST['proses'];
		$grand_total=0;
		
		
		
		
		
		

		
	

		if($proses =="tarik_po" ){
			
			$sp=$_POST['supplier'];
			$cek=$db->select('tb_item_receipt_out','from_for="'.$sp.'"','id_item_receipt_out','DESC');
			$jum=mysqli_num_rows($cek);
			if($jum>0){
				echo '<option value="">Select</option>';
				while($row = mysqli_fetch_assoc($cek)){
					
					echo '<option value="'.$row['number_item_receipt_out'].'">'.$row['number_item_receipt_out']." [". $row['number_purchasing']."]" . " [". $row['tanggal']."]".'</option>';
				}
				// echo '<option value="">Select</option>';
				// echo '<option value="'.$r['number_purchasing'].'" selected>'.$r['number_purchasing'].'</option>';
			}else{
				echo '<option value="">Select</option>';
			}
	
		}

		if($proses == "tarik_do" ){
				$bmb=$_POST['bmb'];
				// $query = "SELECT ir.item, ir.qty, ir.number_item_receipt_out, pd.amount FROM tb_item_receipt_out_detail AS ir INNER JOIN tb_purchasing_detail AS pd ON pd.id_item = ir.id_item WHERE ir.number_item_receipt_out = '" . $bmb . "'";
				$query = "SELECT ir.number_item_receipt_out, ir.item, ir.qty, pd.amount,pd.id_purchasing_detail FROM tb_item_receipt_out_detail AS IR LEFT JOIN tb_purchasing_detail AS pd ON pd.number_purchasing = ir.number_purchasing AND ir.qty = pd.qty AND ir.item = pd.item WHERE ir.number_item_receipt_out ='" . $bmb . "' ";
				// $cekPo = $db->select('tb_item_receipt');
				// $cek=$db->select('tb_item_receipt_out_detail',"tb_item_receipt_out_detail.number_item_receipt_out = " . "'" . $bmb . "'",'id_item_receipt_out_detail','ASC');

				$cek= $db->selectDo($query);
				$jum = mysqli_num_rows($cek);
				$result=mysqli_fetch_assoc($cek);
				$no = 1;
				$grand_total2 = 0;
			
				
				
				


				foreach($cek as $key=> $row){ $total = $row['qty'] * $row['amount'];  ?>
					<tr>
						
						<td><?php echo $no; ?></td>
						<td><?php echo $row['item']; ?></td>
						<td><?php echo $row['qty']; ?></td>
						<td><?php echo number_format($row['amount'],2,',','.'); ?></td>
						<td><?php echo number_format($total ,2,',','.') ?></td>
						<td></td>
						<?php    
								// $GLOBALS["grand_total2"]  += $total;
								global $grand_total;
								$grand_total += $total;
								
								
						
						?>
						

						
						
						
					</tr>

					






					<?php
					$no++;

				} ?>
				<tr ><td colspan="6"><b>Grand Total : <?php  echo number_format($grand_total ,2,',','.') ?></b></td></tr>
				
			
			<?php
			 
			
			

		} global $grand_total;
			$grand_total += $grand_total;
		

		if($proses == "new"){
			if(!empty($_POST['supplier']) && !empty($_POST['delivery_order'])){
				$tanggal=$_POST['tanggal'];
				$number=$_POST['number_inv_purchasing'];
				$supplier=$_POST['supplier'];
				$delivery_order=$_POST['delivery_order'];
				$invoice=$_POST['invoice'];
				$note=$_POST['note'];
				$bmb=$_POST['bmb'];
				$status = 0;
				$query = "SELECT ir.number_item_receipt_out, ir.item, ir.qty, pd.amount,pd.id_purchasing_detail FROM tb_item_receipt_out_detail AS IR LEFT JOIN tb_purchasing_detail AS pd ON pd.number_purchasing = ir.number_purchasing AND ir.qty = pd.qty AND ir.item = pd.item WHERE ir.number_item_receipt_out ='" . $bmb . "' ";
				
				$cek1= $db->selectDo($query);
				$hasil = mysqli_fetch_assoc($cek1);
				$no = 1;
				$grand_total2 = 0;
				foreach($cek1 as $key=> $row){
					$total = $row['qty'] * $row['amount'];
					$grand_total2+= $total;
				
				}
				$explode_date =explode('-',$tanggal); 
				$bulan_potong=$explode_date[0] .'-'. $explode_date[1];
				$cek=$db->select('tb_inv_purchasing','tanggal LIKE "%'.$bulan_potong.'%"','urut','DESC');
				if(mysqli_num_rows($cek)>0)
				{
					$c=mysqli_fetch_assoc($cek);
					$tambah = $c['urut']+1;
					$urut = $tambah;
				}else{
					$urut = "1";
				}
				$db->insert('tb_inv_purchasing','number_inv_purchasing="'.$number.'",number_item_receipt_out="'.$delivery_order.'",tanggal="'.$tanggal.'",urut="'.$urut.'",supplier="'.$supplier.'",status="'.$status.'",total="'.$grand_total2.'",note="'.$note.'"');
				echo $grand_total2;
				
				
				
				
			}
			
		}






	}

	?>

