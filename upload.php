<?php
		include_once "core/file/function_proses.php";

		include_once "core/vendor/autoload.php";
	                     
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\Reader\Csv;
		use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

		$db = new db();

		if(!empty($_POST['proses'])){
			$arr_file = explode('.', $_FILES['file_excel']['name']);
			$extension = end($arr_file);
					 
			if('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			}else{
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
					 
			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();

			for($i = 6; $i < count($sheetData);$i++){
				

					$tanggal    = $sheetData[$i]['1'];
					$position     = $sheetData[$i]['2'];
					$request    = $sheetData[$i]['3'];
					$item    	= $sheetData[$i]['4'];
					$spek		= $sheetData[$i]['5'];
					$jumlah		= $sheetData[$i]['6'];
					$satuan		= $sheetData[$i]['7'];
					$harga		= $sheetData[$i]['8'];
					$total		= $sheetData[$i]['9'];
					$suplier	= $sheetData[$i]['10'];
					$pembeli	= $sheetData[$i]['11'];
					$lokasi		= $sheetData[$i]['12'];

					$tanggal_proses=substr($tanggal, 0,1);
					$bulan_proses=substr($tanggal, 2,3);
					$tahun_proses=substr($tanggal, 6,4);

					if($bulan_proses=='Jan'){
						$bulan_proses="01";
					}else if($bulan_proses=='Feb'){
						$bulan_proses="02";
					}else if($bulan_proses=='Mar'){
						$bulan_proses="03";
					}else if($bulan_proses=='Apr'){
						$bulan_proses="04";
					}else if($bulan_proses=='May'){
						$bulan_proses="05";
					}else if($bulan_proses=='Jun'){
						$bulan_proses="06";
					}


					$jum_kar=strlen($tanggal_proses);

					if($jum_kar<2){
						$tanggal_proses='0'.$tanggal_proses;
					}

					$date_input=$tahun_proses."-".$bulan_proses;

					$date_proses=$tahun_proses.'-'.$bulan_proses.'-'.$tanggal_proses;


					$cek_item=$db->select('tb_item','item="'.$item.'"','urut','DESC');

					if(mysqli_num_rows($cek_item)==0){

						$cek_item=$db->select('tb_item','id_item','urut','DESC');

						if(mysqli_num_rows($cek_item)>0){

							$c=mysqli_fetch_assoc($cek_item);

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
			
						$db->insert('tb_item','code_item="'.$code_item.'",item="'.$item.'",type_of_item="1",urut="'.$urut.'"');

					}

					$tarik_item=$db->select('tb_item','item="'.$item.'"','urut','DESC');
					$i=mysqli_fetch_assoc($tarik_item);







					$cek=$db->select('tb_cash_receipt_payment','id_bank="3" && tanggal LIKE "%'.$date_input.'%" && type="o"','urut','DESC');

					if(mysqli_num_rows($cek)>0){

						$bulan = $library_class->bulan();
						$tahun = $library_class->tahun();
						$potong = substr($tahun_input,2);

						$c=mysqli_fetch_assoc($cek);

						$tambah = $c['urut']+1;

						$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/'.$tambah;

						$urut = $tambah;

					}else{

						$bulan = $library_class->bulan();
						$tahun = $library_class->tahun();
						$potong = substr($tahun_input,2);

						$number = 'P'.$b['code_bank_cash'].'/'.$bulan_input.'/'.$potong.'/1';

						$urut = "1";

					}








					$db->insert('tb_purchasing','number_purchasing="'.$number.'",tanggal="'.$date_asli.'",type_of_purchase="'.$p['type_of_request'].'",type_of_purchase_text="'.$type_of_purchase_text.'",supplier="'.$supplier.'",number_request="'.$p['number_request'].'",id_cluster="'.$p['id_cluster'].'",id_position="'.$p['id_position'].'",id_population="'.$p['id_employee'].'",cluster="'.$p['cluster'].'",code_cluster="'.$p['code_cluster'].'",position="'.$p['position'].'",note="'.$note.'",total="'.$total.'",urut="'.$urut.'",bayar="0",input_data="'.$_SESSION['id_employee'].'"');






			}
		}			
?>
				 	<form method="POST" id="upload" enctype="multipart/form-data">
						<div class="space_line row">
							<div class="col-sm-6 col-lg-6">
								<table class="table">
									<tr class="bg-white">
										<td colspan="2">Unggah (Excel . xlsx)</td>
									</tr>
									<tr class="bg-white">
										<td>
											<input type="type" name="proses" value="proses">
	 										<input type="file" name="file_excel" id="file_excel" class="form-control square bg-white" required="required">
										</td>
										<td>
											<button type="submit" id="btn" class="btn btn-success">
												Unggah
											</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</form>