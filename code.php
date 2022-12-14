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

			for($i = 1; $i < count($sheetData);$i++){
				

					$code     	= $sheetData[$i]['0'];
					$cluster    = $sheetData[$i]['5'];
					$nama    	= $sheetData[$i]['8'];


						$cluster=$db->select('tb_population','cluster="'.$cluster.'" && name="'.$nama.'"','id_population','DESC');
						if(mysqli_num_rows($cluster)>0){

							$c=mysqli_fetch_assoc($cluster);

							$db->update('tb_population','code_population="'.$code.'"','id_population="'.$c['id_population'].'"');

						}

						echo $nama.'<br>';
					
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