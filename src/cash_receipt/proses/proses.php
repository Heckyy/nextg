<?php
session_start();
include_once "./../../../core/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!empty($_POST['proses']) && !empty($_SESSION['id_employee'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";
	$db = new db();
	$library_class = new library_class();

	$tanggal 	= $library_class->tanggal();
	$bulan 		= $library_class->bulan();
	$tahun 		= $library_class->tahun();

	$date		= $tahun . '-' . $bulan;
	$date_asli	= $tahun . '-' . $bulan . '-' . $tanggal;

	$proses = mysqli_real_escape_string($db->query, $_POST['proses']);

	if ($proses == 'new' && $_SESSION['cash_receipt_new'] == 1) {
		if (!empty($_POST['amount']) && !empty($_POST['type_of_receipt']) && !empty($_SESSION['bank'])) {

			$bank = mysqli_real_escape_string($db->query, $_SESSION['bank']);
			$type_of_receipt = mysqli_real_escape_string($db->query, $_POST['type_of_receipt']);
			$tanggal_input_data = mysqli_real_escape_string($db->query, $_POST['tanggal']);
			$tanggal_bank_masuk = mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
			$dari = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dari']));
			$account_name = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_name']));
			$account_number = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
			$amount = mysqli_real_escape_string($db->query, $_POST['amount']);
			$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

			if (!empty($tanggal_bank_masuk)) {
				$tanggal_bank = substr($tanggal_bank_masuk, 0, 2);
				$bulan_bank = substr($tanggal_bank_masuk, 3, 2);
				$tahun_bank = substr($tanggal_bank_masuk, 6, 4);
				$bank_date = $tahun_bank . '-' . $bulan_bank . '-' . $tanggal_bank;
			} else {
				$bank_date = $date_asli;
			}

			$tanggal_input = substr($tanggal_input_data, 0, 2);
			$bulan_input = substr($tanggal_input_data, 3, 2);
			$tahun_input = substr($tanggal_input_data, 6, 4);
			$input_date = $tahun_input . '-' . $bulan_input . '-' . $tanggal_input;
			$date_input = $tahun_input . '-' . $bulan_input;

			$amount = str_replace(".", "", $amount);
			$amount = str_replace(",", ".", $amount);

			$get_type_of_receipt = $db->select('tb_type_of_receipt', 'id_type_of_receipt="' . $type_of_receipt . '"', 'id_type_of_receipt', 'ASC');
			$gt = mysqli_fetch_assoc($get_type_of_receipt);

			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $_SESSION['bank'] . '"', 'bank_cash', 'ASC');
			$b = mysqli_fetch_assoc($bank);

			$cek = $db->select('tb_cash_receipt_payment', 'id_bank="' . $b['id_bank_cash'] . '" && tanggal LIKE "%' . $date_input . '%" && type="i"', 'urut', 'DESC');

			if (mysqli_num_rows($cek) > 0) {

				$bulan = $library_class->bulan();
				$tahun = $library_class->tahun();
				$potong = substr($tahun_input, 2);

				$c = mysqli_fetch_assoc($cek);

				$tambah = $c['urut'] + 1;

				$number = 'R' . $b['code_bank_cash'] . '/' . $bulan_input . '/' . $potong . '/' . $tambah;

				$urut = $tambah;
			} else {

				$bulan = $library_class->bulan();
				$tahun = $library_class->tahun();
				$potong = substr($tahun_input, 2);

				$number = 'R' . $b['code_bank_cash'] . '/' . $bulan_input . '/' . $potong . '/1';

				$urut = "1";
			}

			$db->insert('tb_cash_receipt_payment', 'id_bank="' . $b['id_bank_cash'] . '",number="' . $number . '",tanggal="' . $input_date . '",tanggal_bank="' . $bank_date . '",type="i",id_type_of_receipt="' . $type_of_receipt . '",type_of_receipt="' . $gt['type_of_receipt'] . '",dari="' . $dari . '",account_name="' . $account_name . '",account_number="' . $account_number . '",amount="' . $amount . '",urut="' . $urut . '",note="' . $note . '",input_data="' . $_SESSION['id_employee'] . '"');

			echo str_replace("=", "", base64_encode($number));
		}
	} else if ($proses == 'edit' && $_SESSION['cash_receipt_edit'] == 1) {
		if (!empty($_POST['amount']) && !empty($_POST['type_of_receipt']) && !empty($_SESSION['bank'])) {

			$number = mysqli_real_escape_string($db->query, $_POST['number']);
			$bank = mysqli_real_escape_string($db->query, $_SESSION['bank']);
			$tanggal_bank_masuk = mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
			$dari = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['dari']));
			$account_name = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_name']));
			$account_number = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['account_number']));
			$amount = mysqli_real_escape_string($db->query, $_POST['amount']);
			$note = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

			if (!empty($tanggal_bank_masuk)) {
				$tanggal_bank = substr($tanggal_bank_masuk, 0, 2);
				$bulan_bank = substr($tanggal_bank_masuk, 3, 2);
				$tahun_bank = substr($tanggal_bank_masuk, 6, 4);
				$bank_date = $tahun_bank . '-' . $bulan_bank . '-' . $tanggal_bank;
			} else {
				$bank_date = $date_asli;
			}

			$amount = str_replace(".", "", $amount);
			$amount = str_replace(",", ".", $amount);

			$cek = $db->select('tb_cash_receipt_payment', 'number="' . $number . '" && type="i" && status="0"', 'id_cash_receipt_payment', 'DESC');

			if (mysqli_num_rows($cek) > 0) {

				$db->update('tb_cash_receipt_payment', 'tanggal_bank="' . $bank_date . '",dari="' . $dari . '",account_name="' . $account_name . '",account_number="' . $account_number . '",amount="' . $amount . '",note="' . $note . '",update_data="' . $_SESSION['id_employee'] . '"', 'number="' . $number . '"');

				echo str_replace("=", "", base64_encode($number));
			} else {

				echo "1";
			}
		}
	} else if ($proses == 'cancel' && $_SESSION['cash_receipt_cancel'] == 1) {
		$cek = $db->select('tb_cash_receipt_payment', 'number="' . $_SESSION['number_receipt'] . '" && status="1"', 'id_cash_receipt_payment', 'DESC');
		$query_get_data_payment_detail = "SELECT * from tb_cash_receipt_payment_detail  where number='" . $_SESSION['number_receipt'] . "'";
		$cek_payment_detail = $db->selectAll($query_get_data_payment_detail);
		$nama_pemilik = "";
		$jum = mysqli_num_rows($cek_payment_detail);
		foreach ($cek_payment_detail as $data) {
			$priod = $data['priod'];
			$id_population = $data['id_population'];
			$query_get_bast = "SELECT * from tb_population where id_population='" . $id_population . "'";
			$result_get_bast = $db->selectAll($query_get_bast);
			foreach ($result_get_bast as $data_bast) {
				$bast =  $data_bast['code_population'];
				$query_get_data_tagihan = "SELECT * from tb_invoice_fix where nomor_bast = '" . $bast . "'";
				$result_get_data_tagihan = $db->selectAll($query_get_data_tagihan);
				foreach ($result_get_data_tagihan as $data_tagihan) {
					$db->update("tb_invoice_fix", "status='unpaid',nominal_bayar='0'", "nomor_bast='" . $bast . "'");
					$db->hapus("tb_cash_receipt_payment", "number='" . $_SESSION['number_receipt'] . "'");
					$db->hapus("tb_cash_receipt_payment_detail", "number='" . $_SESSION['number_receipt'] . "'");
				}
			}
		}

		foreach ($cek_payment_detail as $data) {
			$data['no_payment'];
			//$nama_pemilik .= $data_payment_detail['no_payment'];
		}
		$jum = mysqli_num_rows($cek);
		if ($jum > 0) {
			$c = mysqli_fetch_assoc($cek);
			if (!empty($c['number_invoice'])) {
				$status_byr = $db->select('tb_invoice', 'number_invoice="' . $c['number_invoice'] . '"', 'id_invoice', 'DESC');
				$byr = mysqli_fetch_assoc($status_byr);
				$total_byr = $byr['bayar'] - $c['amount'];
				$db->update('tb_invoice', 'bayar="' . $total_byr . '",status_pembayaran="0"', 'number_invoice="' . $c['number_invoice'] . '"');
			}
			$priod_date = substr($c['tanggal'], 0, -3);
			$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $c['id_bank'] . '"', 'id_bank_cash', 'DESC');
			$b = mysqli_fetch_assoc($bank);
			$nominal = $b['nominal'] - $c['amount'];
			$db->update('tb_bank_cash', 'nominal="' . $nominal . '"', 'id_bank_cash="' . $b['id_bank_cash'] . '"');
			$priod = $db->select('tb_priod', 'id_bank_cash="' . $c['id_bank'] . '" && priod="' . $priod_date . '"', 'id_priod', 'DESC');
			$p = mysqli_fetch_assoc($priod);
			$nominal_priod = $p['nominal'] - $c['amount'];

			$db->update('tb_priod', 'nominal="' . $nominal_priod . '"', 'id_priod="' . $p['id_priod'] . '"');
			$db->update('tb_cash_receipt_payment', 'status="2"', 'number="' . $_SESSION['number_receipt'] . '"');
		} else {
			$db->update('tb_cash_receipt_payment', 'status="2"', 'number="' . $_SESSION['number_receipt'] . '"');
		}
		echo str_replace("=", "", base64_encode($_SESSION['number_receipt']));
		// echo $nama_pemilik;
	} else if ($proses == 'process' && $_SESSION['cash_receipt_process'] == 1) {
		$note = htmlspecialchars($_POST['note']);
		$cek = $db->select('tb_cash_receipt_payment', 'number="' . $_SESSION['number_receipt'] . '" && status="0"', 'id_cash_receipt_payment', 'DESC');

		$c = mysqli_fetch_assoc($cek);

		$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $c['id_bank'] . '"', 'id_bank_cash', 'DESC');
		$b = mysqli_fetch_assoc($bank);

		$priod_date = substr($c['tanggal'], 0, -3);

		$priod = $db->select('tb_priod', 'id_bank_cash="' . $c['id_bank'] . '" && priod="' . $priod_date . '"', 'id_priod', 'DESC');
		$jum = mysqli_num_rows($priod);

		if (!empty($c['number_invoice'])) {
			$status_byr = $db->select('tb_invoice', 'number_invoice="' . $c['number_invoice'] . '"', 'id_invoice', 'DESC');
			$byr = mysqli_fetch_assoc($status_byr);
			if (!empty($byr['bayar'])) {

				$total_byr = $c['amount'] + $byr['bayar'];

				if ($total_byr >= $byr['amount']) {
					$db->update('tb_invoice', 'status_pembayaran="1",bayar="' . $total_byr . '"', 'number_invoice="' . $c['number_invoice'] . '"');
				} else {
					$db->update('tb_invoice', 'bayar="' . $total_byr . '"', 'number_invoice="' . $c['number_invoice'] . '"');
				}
			} else {

				if ($c['amount'] >= $byr['amount']) {
					$db->update('tb_invoice', 'status_pembayaran="1",bayar="' . $c['amount'] . '"', 'number_invoice="' . $c['number_invoice'] . '"');
				} else {
					$db->update('tb_invoice', 'bayar="' . $c['amount'] . '"', 'number_invoice="' . $c['number_invoice'] . '"');
				}
			}
		}

		if ($jum > 0) {

			$p = mysqli_fetch_assoc($priod);

			$nominal = $b['nominal'] + $c['amount'];

			$db->update('tb_bank_cash', 'nominal="' . $nominal . '"', 'id_bank_cash="' . $b['id_bank_cash'] . '"');

			$nominal_priod = $p['nominal'] + $c['amount'];

			$db->update('tb_priod', 'nominal="' . $nominal_priod . '"', 'id_priod="' . $p['id_priod'] . '"');

			$db->update('tb_cash_receipt_payment', 'status="3",approved="' . $_SESSION['code_employee'] . '"', 'number="' . $_SESSION['number_receipt'] . '"');
		} else {

			$nominal = $b['nominal'] + $c['amount'];

			$ambil_nilai = $db->select('tb_priod', 'id_bank_cash="' . $b['id_bank_cash'] . '"', 'id_priod', 'DESC LIMIT 1');

			if (mysqli_num_rows($ambil_nilai) > 0) {
				$an = mysqli_fetch_assoc($ambil_nilai);
				$nominal_ambil = $c['amount'] + $an['nominal'];
			} else {
				$nominal_ambil = $c['amount'];
			}

			$db->update('tb_bank_cash', 'nominal="' . $nominal . '"', 'id_bank_cash="' . $b['id_bank_cash'] . '"');

			$db->insert('tb_priod', 'nominal="' . $nominal_ambil . '",priod="' . $priod_date . '",id_bank_cash="' . $c['id_bank'] . '"');

			$db->update('tb_cash_receipt_payment', 'status="3",approved="' . $_SESSION['code_employee'] . '"', 'number="' . $_SESSION['number_receipt'] . '"');
		}

		$db->update("tb_cash_receipt_payment", "note='" . $note . "'", "number='" . $_SESSION['number_receipt'] . "'");

		echo str_replace("=", "", base64_encode($_SESSION['number_receipt']));
	} else if ($proses == 'diketahui' && $_SESSION['cash_receipt_diketahui'] == 1) {

		$db->update('tb_cash_receipt_payment', 'status="1",diketahui="' . $_SESSION['code_employee'] . '"', 'number="' . $_SESSION['number_receipt'] . '"');

		echo str_replace("=", "", base64_encode($_SESSION['number_receipt']));
	} else if ($proses == 'upload' && $_SESSION['cash_receipt_new'] == 1) {

		$tanggal = $_POST['tanggal'];
		$tanggal_bank = $_POST['tanggal_bank'];
		$explode_tanggal = explode('-', $tanggal);
		$bulan = $explode_tanggal[1];
		$tipe_ipl = $_POST['tipe_ipl'];
		if ($tipe_ipl == "bulanan") {
			// In this below is code for IPL BULANAN
			$tarik = $db->select('tb_ipl_upload', 'number_urut', 'number_urut', 'DESC');

			if (mysqli_num_rows($tarik) > 0) {
				$t = mysqli_fetch_assoc($tarik);
				$urut = $t['number_urut'] + 1;
			} else {
				$urut = 1;
			}

			$_SESSION['urut'] = $urut;

			$arr_file = explode('.', $_FILES['file_excel']['name']);
			$extension = end($arr_file);

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$total_kolom = count($sheetData['0']);
			if ($total_kolom < 24) {
				echo "<div class='alert alert-danger' role='alert'>
				 <b>Template Excel/CSV Berbeda!</b>
				</div>";
				die();
			} else {
				$no = 1;
				$html = '<div class="col-lg-12" id="process" align="right"><button class="btn btn-sm btn-success" id="process_upload" onclick="process_upload()">Proses</button> <button class="btn btn-sm btn-danger" id="cancel_upload" onclick="cancel_upload()">Batalkan</button></div><div class="scroll"><table class="table"><tr class="sticky-top"><td width="50px" align="center">No</td><td width="300px">Number Bast</td><td width="300px">Property,ID</td><td width="300px">Period Month</td><td width="300px">Year Period</td><td width="300px">Floor ID</td><td width="300px">Cluster</td><td width="300px">Store ID</td><td width="300px">Invoice No.</td><td width="300px">Customer</td><td width="300px">Total</td><td>IPL Price</td><td width="300px">Status</td><td width="300px">Paid Date</td><td width="300px">No. Payment</td><td width="300px">Total Unit</td><td width="300px">LT</td><td width="300px">Tarif IPL Makro</td><td width="300px">Total IPL Makro</td><td width="300px">IPL Pengelola</td></tr>';

				$total_semua = 0;


				for ($i = 1; $i < count($sheetData); $i++) {
					$number_bast     	= $sheetData[$i]['0'];
					$property    		= $sheetData[$i]['1'];
					$priod_mont    		= $sheetData[$i]['2'];
					$year_priod    		= $sheetData[$i]['3'];
					$floor_id    		= $sheetData[$i]['4'];
					$cluster    		= $sheetData[$i]['5'];
					$store_id    		= $sheetData[$i]['6'];
					$invoice_no    		= $sheetData[$i]['7'];
					$customer_name    	= $sheetData[$i]['8'];
					$total    			= str_replace(",", "", $sheetData[$i]['9']);
					$status    			= $sheetData[$i]['10'];
					$paid_date_asli		= str_replace("/", "-", $sheetData[$i]['11']);
					$no_paymnet    		= $sheetData[$i]['12'];
					$total_unit    		= $sheetData[$i]['13'];
					$luas_tanah    		= str_replace(",", "", $sheetData[$i]['14']);
					$tarif_ipl_makro    = str_replace(",", "", $sheetData[$i]['15']);
					$total_ipl_makro    = str_replace(",", "", $sheetData[$i]['16']);
					$ipl_pengelolah    	= str_replace(",", "", $sheetData[$i]['17']);
					$tanggal_bank = substr($paid_date_asli, 0, 2);
					$bulan_bank = substr($paid_date_asli, 3, 2);
					$tahun_bank = substr($paid_date_asli, 6, 4);
					$paid_date = $tahun_bank . '-' . $bulan_bank . '-' . $tanggal_bank;

					if ($priod_mont < 10) {
						$all_priod = $year_priod . '-0' . $priod_mont;
					} else {
						$all_priod = $year_priod . '-' . $priod_mont;
					}
					if ($property == 'RMH') {
						$property = "1";
					} else {
						$property = "2";
					}
					if (!empty($number_bast)) {
						$ubah_tarif_ipl_makro	= $sheetData[$i]['15'];
						$ubah_total_ipl_makro	= $sheetData[$i]['16'];
						$ubah_ipl_pengelolah	= $sheetData[$i]['17'];
						$cek_population = $db->select('tb_population', 'code_population="' . $number_bast . '"', 'id_population', 'DESC');
						$result_cek_population = mysqli_fetch_assoc($cek_population);
						$building_area = $result_cek_population['building_area'];
						$type_property = $result_cek_population['type_property'];
						$surface_area = $result_cek_population['surface_area'];
						$c = mysqli_fetch_assoc($db->select('tb_cluster', 'id_cluster="' . $result_cek_population['id_cluster'] . '"', 'id_cluster', 'DESC'));
						if ($type_property == 1) {
							$the_land_price = $c['the_land_price'] * $surface_area;
							$building_price = $c['building_price'] * $building_area;
							$macro_price = $c['macro_price'] * $surface_area;
							$grand_total_ipl = $the_land_price + $building_price - $macro_price;
						} else {
							$the_land_price = $c['the_land_price'] * $surface_area;
							$macro_price = $c['macro_price'] * $surface_area;
							$grand_total_ipl = $the_land_price - $macro_price;
						}
						if (mysqli_num_rows($cek_population) == 0) {
							$potong = substr($number_bast, -4);
							$ubah_nomor = str_replace("/", "", $potong);
							$db->insert('tb_population', 'code_population="' . $number_bast . '",name="' . $customer_name . '",house_number="' . $ubah_nomor . '",type_property="' . $property . '",cluster="' . $cluster . '",surface_area="' . $luas_tanah . '",cek="1"');
						}
						$invoice_no_db = "";

						$query_cek_ipl = "SELECT * from tb_cash_receipt_payment_detail";
						$tarik_data_ipl = $db->selectAll($query_cek_ipl);
						$result_tarik_data_ipl = mysqli_fetch_assoc($tarik_data_ipl);
						$jum_data_ipl = mysqli_num_rows($tarik_data_ipl);
						$all_priod_fix = '';
						$data = "";
						foreach ($tarik_data_ipl as $data_ipl) {
							if ($jum_data_ipl > 0) {

								if ($all_priod == $data_ipl['priod'] && $data_ipl['no_payment'] == $no_paymnet) {
									$data = "Data Sudah Ada!";
								} else {
									$data = "Data Belum Ada!";
								}
							}
						}

						if ($data == "Data Sudah Ada!") {
							$result_data = "<script>Swal.fire('', '$data', 'error');</script>";
							die($result_data);
						} else {
							$db->insert('tb_ipl_upload', 'number_urut="' . $urut . '",number_bast="' . $number_bast . '",property="' . $property . '",priod_mont="' . $priod_mont . '",year_priod="' . $year_priod . '",floor_id="' . $floor_id . '",cluster="' . $cluster . '",store_id="' . $store_id . '",invoice_no="' . $invoice_no . '",customer_name="' . $customer_name . '",total="' . $total . '",status="' . $status . '",paid_date="' . $paid_date . '",no_paymnet="' . $no_paymnet . '",total_unit="' . $total_unit . '",luas_tanah="' . $luas_tanah . '",tarif_ipl_makro="' . $tarif_ipl_makro . '",total_ipl_makro="' . $total_ipl_makro . '",ipl_pengelolah="' . $ipl_pengelolah . '"');
							$html = $html . '<tr><td align="center">' . $no . '.</td><td>' . $number_bast . '</td><td>' . $property . '</td><td>' . $priod_mont . '</td><td>' . $year_priod . '</td><td>' . $floor_id . '</td><td>' . $cluster . '</td><td>' . $store_id . '</td><td>' . $invoice_no . '</td><td>' . $customer_name . '</td><td>' . $total . '</td><td>' . $grand_total_ipl . '</td><td>' . $status . '</td><td>' . $paid_date_asli . '</td><td>' . $no_paymnet . '</td><td>' . $total_unit . '</td><td>' . $luas_tanah . '</td><td>' . $ubah_tarif_ipl_makro . '</td><td>' . $ubah_total_ipl_makro . '</td><td>' . $ubah_ipl_pengelolah . '</td></tr>';
							$no++;
							$result_data = "<script>Swal.fire('', '$no_paymnet', 'success');</script>";
						}
					}
				}
				$tarik_detail = $db->select('tb_ipl_upload', 'number_urut="' . $urut . '"', 'id_ipl_upload', 'ASC');
				foreach ($tarik_detail as $key => $td) {
					$total_semua = $total_semua + $td['ipl_pengelolah'];
				}
				$html = $html . '<tr><td align="center"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="5"><h3><b>Total IPL Pengelola :</b></h3></td><td colspan="2"><h3><b>' . number_format($total_semua, 2, ',', '.') . '</b></h3></td></tr</table></div>';
				echo $html;
			}
		} else {
			// In This Below is Code for IPL TAHUNAN
			$tarik = $db->select('tb_ipl_upload', 'number_urut', 'number_urut', 'DESC');

			if (mysqli_num_rows($tarik) > 0) {
				$t = mysqli_fetch_assoc($tarik);
				$urut = $t['number_urut'] + 1;
			} else {
				$urut = 1;
			}
			$arr_file = explode('.', $_FILES['file_excel']['name']);
			$extension = end($arr_file);

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$total_kolom = count($sheetData['0']);

			if ($total_kolom < 24) {
				echo "<div class='alert alert-danger' role='alert'>
				 <b>Template Excel/CSV Berbeda!</b>
				</div>";
				die();
			} else {
				$no = 1;
				$html = '<div class="col-lg-12" id="process" align="right"><button class="btn btn-sm btn-success" id="process_upload" onclick="process_upload()">Proses</button> <button class="btn btn-sm btn-danger" id="cancel_upload" onclick="cancel_upload()">Batalkan</button></div><div class="scroll"><table class="table"><tr class="sticky-top"><td width="50px" align="center">No</td><td width="300px">Number Bast</td><td width="300px">Property,ID</td><td width="300px">Period Month</td><td width="300px">Year Period</td><td width="300px">Floor ID</td><td width="300px">Cluster</td><td width="300px">Store ID</td><td width="300px">Invoice No.</td><td width="300px">Customer</td><td width="300px">Total</td><td>IPL Price</td><td width="300px">Status</td><td width="300px">Paid Date</td><td width="300px">No. Payment</td><td width="300px">Total Unit</td><td width="300px">LT</td><td width="300px">Tarif IPL Makro</td><td width="300px">Total IPL Makro</td><td width="300px">IPL Pengelola</td></tr>';

				$total_semua = 0;


				for ($i = 1; $i < count($sheetData); $i++) {
					$number_bast     	= $sheetData[$i]['0'];
					$property    		= $sheetData[$i]['1'];
					$priod_mont    		= $sheetData[$i]['2'];
					$year_priod    		= $sheetData[$i]['3'];
					$floor_id    		= $sheetData[$i]['4'];
					$cluster    		= $sheetData[$i]['5'];
					$store_id    		= $sheetData[$i]['6'];
					$invoice_no    		= $sheetData[$i]['7'];
					$customer_name    	= $sheetData[$i]['8'];
					$total    			= str_replace(",", "", $sheetData[$i]['9']);
					$status    			= $sheetData[$i]['10'];
					$paid_date_asli		= str_replace("/", "-", $sheetData[$i]['11']);
					$no_paymnet    		= $sheetData[$i]['12'];
					$total_unit    		= $sheetData[$i]['13'];
					$luas_tanah    		= str_replace(",", "", $sheetData[$i]['14']);
					$tarif_ipl_makro    = str_replace(",", "", $sheetData[$i]['15']);
					$total_ipl_makro    = str_replace(",", "", $sheetData[$i]['16']);
					$ipl_pengelolah    	= str_replace(",", "", $sheetData[$i]['17']);
					$tanggal_bank = substr($paid_date_asli, 0, 2);
					$bulan_bank = substr($paid_date_asli, 3, 2);
					$tahun_bank = substr($paid_date_asli, 6, 4);
					$paid_date = $tahun_bank . '-' . $bulan_bank . '-' . $tanggal_bank;

					if ($priod_mont < 10) {
						$all_priod = $year_priod . '-0' . $priod_mont;
					} else {
						$all_priod = $year_priod . '-' . $priod_mont;
					}
					if ($property == 'RMH') {
						$property = "1";
					} else {
						$property = "2";
					}
					if (!empty($number_bast)) {
						$ubah_tarif_ipl_makro	= $sheetData[$i]['15'];
						$ubah_total_ipl_makro	= $sheetData[$i]['16'];
						$ubah_ipl_pengelolah	= $sheetData[$i]['17'];
						$cek_population = $db->select('tb_population', 'code_population="' . $number_bast . '"', 'id_population', 'DESC');
						$result_cek_population = mysqli_fetch_assoc($cek_population);
						$building_area = $result_cek_population['building_area'];
						$type_property = $result_cek_population['type_property'];
						$surface_area = $result_cek_population['surface_area'];
						$c = mysqli_fetch_assoc($db->select('tb_cluster', 'id_cluster="' . $result_cek_population['id_cluster'] . '"', 'id_cluster', 'DESC'));
						if ($type_property == 1) {
							$the_land_price = $c['the_land_price'] * $surface_area;
							$building_price = $c['building_price'] * $building_area;
							$macro_price = $c['macro_price'] * $surface_area;
							$grand_total_ipl = $the_land_price + $building_price - $macro_price;
						} else {
							$the_land_price = $c['the_land_price'] * $surface_area;
							$macro_price = $c['macro_price'] * $surface_area;
							$grand_total_ipl = $the_land_price - $macro_price;
						}
						if (mysqli_num_rows($cek_population) == 0) {
							$potong = substr($number_bast, -4);
							$ubah_nomor = str_replace("/", "", $potong);
							$db->insert('tb_population', 'code_population="' . $number_bast . '",name="' . $customer_name . '",house_number="' . $ubah_nomor . '",type_property="' . $property . '",cluster="' . $cluster . '",surface_area="' . $luas_tanah . '",cek="1"');
						}
						$invoice_no_db = "";

						$query_cek_ipl = "SELECT * from tb_cash_receipt_payment_detail";
						$tarik_data_ipl = $db->selectAll($query_cek_ipl);
						$result_tarik_data_ipl = mysqli_fetch_assoc($tarik_data_ipl);
						$jum_data_ipl = mysqli_num_rows($tarik_data_ipl);
						$all_priod_fix = '';
						$data = "";
						foreach ($tarik_data_ipl as $data_ipl) {
							if ($jum_data_ipl > 0) {

								if ($all_priod == $data_ipl['priod'] && $data_ipl['no_payment'] == $no_paymnet) {
									$data = "Data Sudah Ada!";
								} else {
									$data = "Data Belum Ada!";
								}
							}
						}

						if ($data == "Data Sudah Ada!") {
							$result_data = "<script>Swal.fire('', '$data', 'error');</script>";
							die($result_data);
						} else {
							$db->insert('tb_ipl_upload', 'number_urut="' . $urut . '",number_bast="' . $number_bast . '",property="' . $property . '",priod_mont="' . $priod_mont . '",year_priod="' . $year_priod . '",floor_id="' . $floor_id . '",cluster="' . $cluster . '",store_id="' . $store_id . '",invoice_no="' . $invoice_no . '",customer_name="' . $customer_name . '",total="' . $total . '",status="' . $status . '",paid_date="' . $paid_date . '",no_paymnet="' . $no_paymnet . '",total_unit="' . $total_unit . '",luas_tanah="' . $luas_tanah . '",tarif_ipl_makro="' . $tarif_ipl_makro . '",total_ipl_makro="' . $total_ipl_makro . '",ipl_pengelolah="' . $ipl_pengelolah . '"');
							$html = $html . '<tr><td align="center">' . $no . '.</td><td>' . $number_bast . '</td><td>' . $property . '</td><td>' . $priod_mont . '</td><td>' . $year_priod . '</td><td>' . $floor_id . '</td><td>' . $cluster . '</td><td>' . $store_id . '</td><td>' . $invoice_no . '</td><td>' . $customer_name . '</td><td>' . $total . '</td><td>' . $grand_total_ipl . '</td><td>' . $status . '</td><td>' . $paid_date_asli . '</td><td>' . $no_paymnet . '</td><td>' . $total_unit . '</td><td>' . $luas_tanah . '</td><td>' . $ubah_tarif_ipl_makro . '</td><td>' . $ubah_total_ipl_makro . '</td><td>' . $ubah_ipl_pengelolah . '</td></tr>';
							$no++;
							$result_data = "<script>Swal.fire('', '$no_paymnet', 'success');</script>";
						}
					}
				}
				$tarik_detail = $db->select('tb_ipl_upload', 'number_urut="' . $urut . '"', 'id_ipl_upload', 'ASC');
				foreach ($tarik_detail as $key => $td) {
					$total_semua = $total_semua + $td['ipl_pengelolah'];
				}
				$html = $html . '<tr><td align="center"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="5"><h3><b>Total IPL Pengelola :</b></h3></td><td colspan="2"><h3><b>' . number_format($total_semua, 2, ',', '.') . '</b></h3></td></tr</table></div>';
				echo $html;
			}
		}
	} else if ($proses == 'cancel_upload' && $_SESSION['cash_receipt_new'] == 1) {
		$db->hapus('tb_ipl_upload', 'number_urut="' . $_SESSION['urut'] . '"');
		$db->hapus('tb_population', 'cek="1"');
	} else if ($proses == 'hapus_upload' && $_SESSION['cash_receipt_new'] == 1) {
		$db->hapus('tb_ipl_upload', 'number_urut="' . $_SESSION['urut'] . '"');
		$db->hapus('tb_population', 'cek="1"');
		echo $_POST['number'];
	} else if ($proses == 'process_upload' && $_SESSION['cash_receipt_new'] == 1) {
		$get_type_of_receipt = $db->select('tb_type_of_receipt', 'type_of_receipt LIKE "%IPL%"', 'id_type_of_receipt', 'ASC');
		$gt = mysqli_fetch_assoc($get_type_of_receipt);
		$bank = $db->select('tb_bank_cash', 'id_bank_cash="' . $_SESSION['bank'] . '"', 'bank_cash', 'ASC');
		$b = mysqli_fetch_assoc($bank);
		$cek = $db->select('tb_cash_receipt_payment', 'id_bank="' . $_SESSION['bank'] . '" && tanggal LIKE "%' . $date . '%" && type="i"', 'urut', 'DESC');
		if (mysqli_num_rows($cek) > 0) {
			$bulan = $library_class->bulan();
			$tahun = $library_class->tahun();
			$potong = substr($tahun, 2);
			$c = mysqli_fetch_assoc($cek);
			$tambah = $c['urut'] + 1;
			$number = 'R' . $b['code_bank_cash'] . '/' . $bulan . '/' . $potong . '/' . $tambah;
			$urut = $tambah;
		} else {
			$bulan = $library_class->bulan();
			$tahun = $library_class->tahun();
			$potong = substr($tahun, 2);
			$number = 'R' . $b['code_bank_cash'] . '/' . $bulan . '/' . $potong . '/1';
			$urut = "1";
		}
		$jum_amount = 0;
		$priod = "";
		$ipl = $db->select('tb_ipl_upload', 'number_urut="' . $_SESSION['urut'] . '"', 'id_ipl_upload', 'ASC');
		foreach ($ipl as $key => $i) {
			$cek_population_kosong = $db->select('tb_population', 'code_population="' . $i['number_bast'] . '" && cek="1"', 'id_population', 'DESC');
			if (mysqli_num_rows($cek_population_kosong) > 0) {
				$cpk = mysqli_fetch_assoc($cek_population_kosong);
				$harga_tanah = 0;
				$harga_bangun = 0;
				$proses_cek_cluster = $db->select('tb_cluster', 'id_cluster', 'id_cluster', 'ASC');
				foreach ($proses_cek_cluster as $key => $pcc) {
					$cek_population_data_masuk = $db->select('tb_population', 'code_population LIKE "%' . $pcc['code_cluster'] . '%" && id_population="' . $cpk['id_population'] . '"', 'id_population', 'DESC');
					if (mysqli_num_rows($cek_population_data_masuk) > 0) {
						$harga_tanah = $pcc['the_land_price'];
						$harga_bangun = $pcc['building_area'];
						$db->update('tb_population', 'id_cluster="' . $pcc['id_cluster'] . '",cluster="' . $pcc['cluster'] . '"', 'id_population="' . $cpk['id_population'] . '"');
					}
				}
				if ($property == 'RMH') {
					$hitung_awal = $i['total'] - $i['total_ipl_makro'];
					$hitung_kedua = $cpk['surface_area'] * $harga_tanah;
					$hitung_ketiga = $hitung_awal - $hitung_kedua;
					$hitung_akhir = $hitung_ketiga / $harga_bangun;
				} else {
					$hitung_akhir = 0;
				}
				$db->update('tb_population', 'building_area="' . $i['customer_name'] . '",cek="0",building_area="' . $hitung_akhir . '"', 'id_population="' . $cpk['id_population'] . '"');
			}
			$jum_chart = strlen($i['priod_mont']);
			if ($jum_chart == 1) {
				$priod = $i['year_priod'] . '-0' . $i['priod_mont'];
			} else {
				$priod = $i['year_priod'] . '-' . $i['priod_mont'];
			}
			if ($i['status'] == 'UNPAID' && empty($i['no_paymnet'])) {
				$db->insert('tb_unpaid', 'code_population="' . $i['number_bast'] . '",priod="' . $i['priod_mont'] . '",nominal="' . $i['ipl_pengelolah'] . '"');
			}
			// if (!empty($i['no_paymnet'])) {
			$amount = $i['ipl_pengelolah'];
			$jum_amount = $jum_amount + $amount;
			$cek_population = $db->select('tb_population', 'code_population="' . $i['number_bast'] . '"', 'id_population', 'DESC');
			$cp = mysqli_fetch_assoc($cek_population);
			$cek_cluster = $db->select('tb_cluster', 'id_cluster="' . $cp['id_cluster'] . '"', 'id_cluster', 'DESC');
			$cc = mysqli_fetch_assoc($cek_cluster);
			if (empty($cp['name'])) {
				$db->update('tb_population', 'name="' . $i['customer_name'] . '"', 'id_population="' . $cp['id_population'] . '"');
			}
			$db->insert('tb_cash_receipt_payment_detail', 'number="' . $number . '",id_population="' . $cp['id_population'] . '",date="' . $i['paid_date'] . '",price="' . $amount . '",no_payment="' . $i['no_paymnet'] . '",priod="' . $priod . '",priode_payment="1"');
			$cek_unpaid = $db->select('tb_unpaid', 'code_population="' . $i['number_bast'] . '" && priod="' . $i['priod_mont'] . '"', 'id_unpaid', 'DESC');
			$update_status_bayar = $db->update(
				'tb_invoice_fix',
				'status="paid",nominal_bayar="' . $i['ipl_pengelolah'] . '"',
				'nomor_bast="' . $i['number_bast'] . '" && tanggal_tgh LIKE "%' . $priod . '%"'
			);
			if (mysqli_num_rows($cek_unpaid) > 0) {
				$cu = mysqli_fetch_assoc($cek_unpaid);
				$db->hapus('tb_unpaid', 'id_unpaid=' . $cu['id_unpaid'] . '"');
			}
		}
		$tanggal_fix = $_POST['tanggal'];
		$tanggal_bank_fix = $_POST['tanggal_bank'];
		$tanggal_bank_proses = mysqli_real_escape_string($db->query, $_POST['tanggal_bank']);
		$tanggal_bank = substr($tanggal_bank_proses, 0, 2);
		$bulan_bank = substr($tanggal_bank_proses, 3, 2);
		$tahun_bank = substr($tanggal_bank_proses, 6, 4);
		$tanggal_bank_masuk_data = $tahun_bank . '-' . $bulan_bank . '-' . $tanggal_bank;
		$db->insert('tb_cash_receipt_payment', 'id_bank="' . $_SESSION['bank'] . '",number="' . $number . '",tanggal="' . $tanggal_fix . '",tanggal_bank="' . $tanggal_bank_fix . '",type="i",id_type_of_receipt="' . $gt['id_type_of_receipt'] . '",type_of_receipt="' . $gt['type_of_receipt'] . '",dari="IPL",amount="' . $jum_amount . '",urut="' . $urut . '",status="0",approved="0",input_data="' . $_SESSION['id_employee'] . '",priod="' . $priod . '"');
		echo str_replace("=", "", base64_encode($number));
	} else if ($proses == 'priode_bayar' && $_SESSION['cash_receipt_edit'] == 1) {
		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
		$val = mysqli_real_escape_string($db->query, $_POST['val']);
		$db->update('tb_cash_receipt_payment_detail', 'priode_payment="' . $val . '"', 'id_detail="' . $id . '"');
	} else if ($proses == 'discount' && $_SESSION['cash_receipt_edit'] == 1) {
		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
		$val = mysqli_real_escape_string($db->query, $_POST['val']);
		$val = str_replace(".", "", $val);
		$val = str_replace(",", ".", $val);
		$db->update('tb_cash_receipt_payment_detail', 'discount="' . $val . '"', 'id_detail="' . $id . '"');
	}
}
