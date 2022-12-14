<?php
session_start();
if (!empty($_POST['proses']) && !empty($_SESSION['id_employee'])) {
	include_once "./../../../core/file/function_proses.php";
	$db = new db();

	$proses = mysqli_real_escape_string($db->query, $_POST['proses']);

	if ($proses == 'new' && $_SESSION['population_new'] == 1) {

		$code 		= mysqli_real_escape_string($db->query, $_POST['code']);
		$name 		= mysqli_real_escape_string($db->query, $_POST['name']);
		$kk 		= mysqli_real_escape_string($db->query, $_POST['kk']);
		$ktp 		= mysqli_real_escape_string($db->query, $_POST['ktp']);
		$type_property 		= mysqli_real_escape_string($db->query, $_POST['type_property']);

		$cluster 		= mysqli_real_escape_string($db->query, $_POST['cluster']);
		$surface_area 		= mysqli_real_escape_string($db->query, $_POST['surface_area']);
		$building_area 		= mysqli_real_escape_string($db->query, $_POST['building_area']);
		$rt 		= mysqli_real_escape_string($db->query, $_POST['rt']);
		$number 	= mysqli_real_escape_string($db->query, str_replace(" ", "", $_POST['number']));

		$address 	= mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['address']));
		$telp 		= mysqli_real_escape_string($db->query, $_POST['telp']);
		$hp 		= mysqli_real_escape_string($db->query, $_POST['hp']);

		$note       = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));

		$status       = mysqli_real_escape_string($db->query, $_POST['status']);


		if ($surface_area == 0 || empty($surface_area)) {
			$surface_area = 0;
		}

		if ($building_area == 0 || empty($building_area)) {
			$building_area = 0;
		}

		$surface_area = str_replace(".", "", $surface_area);
		$surface_area = str_replace(",", ".", $surface_area);
		$building_area = str_replace(".", "", $building_area);
		$building_area = str_replace(",", ".", $building_area);


		$cek = $db->select('tb_population', 'code_population="' . $code . '" && status="0"', 'id_population', 'DESC');
		$cek_cluster = $db->select('tb_cluster', 'id_cluster="' . $cluster . '"', 'id_cluster', 'DESC');

		$cek_rt = $db->select('tb_rt', 'id_rt="' . $rt . '"', 'id_rt', 'DESC');

		if (mysqli_num_rows($cek_rt) > 0) {
			$crt = mysqli_fetch_assoc($cek_rt);
			$data_rt = $crt['number'];
		} else {
			$data_rt = '0';
		}

		if (mysqli_num_rows($cek) == 0) {

			$cb = mysqli_fetch_assoc($cek_cluster);


			$db->insert('tb_population', 'code_population="' . $code . '",name="' . $name . '",kk="' . $kk . '",ktp="' . $ktp . '",type_property="' . $type_property . '",id_cluster="' . $cluster . '",cluster="' . $cb['cluster'] . '",id_rt="' . $rt . '",number_rt="' . $data_rt . '",house_number="' . $number . '",address="' . $address . '",telp="' . $telp . '",hp="' . $hp . '",status="' . $status . '",surface_area="' . $surface_area . '",building_area="' . $building_area . '",note="' . $note . '",input_data="' . $_SESSION['id_employee'] . '"');

			echo str_replace("=", "", base64_encode($code));
		} else {
			echo "1";
		}
	} else if ($proses == 'cari_rt') {
		$id = mysqli_real_escape_string($db->query, $_POST['id']);
		$cluster = $db->select('tb_cluster', 'id_cluster="' . $id . '"', 'id_cluster', 'ASC');
		foreach ($cluster as $key => $b) {
			$i = 1;
			$rows = '[';

			$rt = $db->select('tb_rt', 'id_cluster="' . $b['id_cluster'] . '"', 'id_rt', 'ASC');
			$jum = mysqli_num_rows($rt);
			if ($jum > 0) {
				foreach ($rt as $key => $r) {
					$rows .= '{"id_rt":"' . $r['id_rt'] . '",';
					$rows .= '"number":"' . $r["number"] . '"}';

					if ($i < $jum) {
						$rows .= ",";
						$i++;
					}
				}
			}
		}
		$rows = $rows . ']';
		echo $rows;
	} else if ($proses == 'edit' && $_SESSION['population_edit'] == 1) {
		// Declare Variabel
		$id 		= mysqli_real_escape_string($db->query, $_POST['code_population_real']);
		$code 		= mysqli_real_escape_string($db->query, $_POST['code']);
		$name 		= mysqli_real_escape_string($db->query, $_POST['name']);
		$kk 		= mysqli_real_escape_string($db->query, $_POST['kk']);
		$ktp 		= mysqli_real_escape_string($db->query, $_POST['ktp']);
		$type_property 		= mysqli_real_escape_string($db->query, $_POST['type_property']);
		$cluster 		= mysqli_real_escape_string($db->query, $_POST['cluster']);
		$surface_area 		= mysqli_real_escape_string($db->query, $_POST['surface_area']);
		$building_area 		= mysqli_real_escape_string($db->query, $_POST['building_area']);
		$rt 		= mysqli_real_escape_string($db->query, $_POST['rt']);
		$number 	= mysqli_real_escape_string($db->query, str_replace(" ", "", $_POST['number']));
		$address 	= mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['address']));
		$telp 		= mysqli_real_escape_string($db->query, $_POST['telp']);
		$hp 		= mysqli_real_escape_string($db->query, $_POST['hp']);
		$note       = mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['note']));
		$status       = mysqli_real_escape_string($db->query, $_POST['status']);

		if ($surface_area == 0 || empty($surface_area)) {
			$surface_area = 0;
		}

		if ($building_area == 0 || empty($building_area)) {
			$building_area = 0;
		}

		$surface_area = str_replace(".", "", $surface_area);
		$surface_area = str_replace(",", ".", $surface_area);
		$building_area = str_replace(".", "", $building_area);
		$building_area = str_replace(",", ".", $building_area);


		$cek = $db->select('tb_population', 'id_population="' . $id . '"', 'id_population', 'DESC');
		$cek_cluster = $db->select('tb_cluster', 'id_cluster="' . $cluster . '"', 'id_cluster', 'DESC');

		$cek_rt = $db->select('tb_rt', 'id_rt="' . $rt . '"', 'id_rt', 'DESC');
		$crt = mysqli_fetch_assoc($cek_rt);

		if (mysqli_num_rows($cek_rt) > 0) {
			$data_rt = $crt['number'];
		} else {
			$data_rt = '0';
		}

		if (mysqli_num_rows($cek) > 0) {

			$c = mysqli_fetch_assoc($cek);
			$cb = mysqli_fetch_assoc($cek_cluster);


			$cek2 = $db->select('tb_population', 'code_population="' . $code . '" && id_population=!"' . $c['id_population'] . '" && status="0"', 'id_population', 'DESC');

			if (mysqli_num_rows($cek2) == 0) {
				$db->update('tb_population', 'code_population="' . $code . '",name="' . $name . '",kk="' . $kk . '",ktp="' . $ktp . '",type_property="' . $type_property . '",id_cluster="' . $cluster . '",cluster="' . $cb['cluster'] . '",id_rt="' . $rt . '",number_rt="' . $data_rt . '",house_number="' . $number . '",address="' . $address . '",telp="' . $telp . '",hp="' . $hp . '",status="' . $status . '",surface_area="' . $surface_area . '",building_area="' . $building_area . '",note="' . $note . '",update_data="' . $_SESSION['id_employee'] . '"', 'id_population="' . $c['id_population'] . '"');

				echo str_replace("=", "", base64_encode($code));
			} else {
				echo "1";
			}
		} else {
			echo "1";
		}
	} else if ($proses == 'rt') {
		$id = mysqli_real_escape_string($db->query, $_POST['id']);
		$head = $db->select('tb_population', 'id_population="' . $id . '"', 'id_population', 'ASC');
		$h = mysqli_fetch_assoc($head);

		$rt = $db->select('tb_rt', 'id_rt="' . $h['id_rt'] . '"', 'id_rt', 'ASC');
		$rthtml = '';
		$b = mysqli_fetch_assoc($rt);
		echo '<option value="' . $b['id_rt'] . '">' . $b['number'] . '</option>';
	} else if ($proses == 'delete' && $_SESSION['population_delete'] == 1) {
		$id = mysqli_real_escape_string($db->query, base64_decode($_POST['id']));
		$head = $db->select('tb_population', 'id_population="' . $id . '"', 'id_population', 'ASC');
		if (mysqli_num_rows($head) > 0) {
			$h = mysqli_fetch_assoc($head);
			$ubah = 'hapus-' . $h['code_population'] . '-' . rand();
			$db->update('tb_population', 'status="3",code_population="' . $ubah . '",update_data="' . $_SESSION['id_employee'] . '"', 'id_population="' . $h['id_population'] . '"');
		}
	} else if ($proses == 'hitung') {
		$cluster = mysqli_real_escape_string($db->query, $_POST['cluster']);
		$type_property = mysqli_real_escape_string($db->query, $_POST['type_property']);
		$surface_area = mysqli_real_escape_string($db->query, $_POST['surface_area']);
		$building_area = mysqli_real_escape_string($db->query, $_POST['building_area']);

		if ($surface_area == 0 || empty($surface_area)) {
			$surface_area = 0;
		}

		if ($building_area == 0 || empty($building_area)) {
			$building_area = 0;
		}

		$surface_area = str_replace(".", "", $surface_area);
		$surface_area = str_replace(",", ".", $surface_area);
		$building_area = str_replace(".", "", $building_area);
		$building_area = str_replace(",", ".", $building_area);

		$cluster = $db->select('tb_cluster', 'id_cluster="' . $cluster . '"', 'id_cluster', 'ASC');
		$c = mysqli_fetch_assoc($cluster);

		if ($type_property == 1) {

			$the_land_price = $c['the_land_price'] * $surface_area;
			$building_price = $c['building_price'] * $building_area;
			$macro_price = $c['macro_price'] * $surface_area;

			$total_hasil = $the_land_price + $building_price - $macro_price;

?>
			<div class="table-responsive">
				<table class="table" width="100%" style="border: thin solid #EEE;">
					<thead>
						<tr style="background-color: #f6f6f6;">
							<td align="center">The Land Price</td>
							<td align="center" width="5px"></td>
							<td align="center">Surface Area</td>
							<td align="center" width="5px"></td>
							<td align="center">Building Price</td>
							<td align="center" width="5px"></td>
							<td align="center">Building Area</td>
							<td align="center" width="5px"></td>
							<td align="center">Macro Price</td>
							<td align="center" width="5px"></td>
							<td align="center">Surface Area</td>
							<td align="center" width="5px"></td>
							<td align="center">Total</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($c['the_land_price'], 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> x </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($surface_area, 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center">+</td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($c['building_price'], 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> x </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($building_area, 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> - </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($c['macro_price'], 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> x </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($surface_area, 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> = </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($total_hasil, 2, ',', '.'); ?>
							</td>
						</tr>
						<tr>
							<td style="background-color: #FFFFFF;" colspan="3" align="center">
								<b>Rp.<?php echo number_format($the_land_price, 2, ',', '.'); ?></b>
							</td>
							<td style="background-color: #FFFFFF;" align="center">
								+
							</td>
							<td style="background-color: #FFFFFF;" colspan="3" align="center">
								<b>Rp.<?php echo number_format($building_price, 2, ',', '.'); ?></b>
							</td>
							<td style="background-color: #FFFFFF;">
								-
							</td>
							<td style="background-color: #FFFFFF;" colspan="3" align="center">
								<b>Rp.<?php echo number_format($macro_price, 2, ',', '.'); ?></b>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> = </td>
							<td style="background-color: #FFFFFF;" align="center">
								<b>Rp.<?php echo number_format($total_hasil, 2, ',', '.'); ?></b>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php
		} else {

			$the_land_price = $c['empty_land'] * $surface_area;
			$macro_price = $c['macro_price'] * $surface_area;
			$total_hasil = $the_land_price - $macro_price;
		?>
			<div class="table-responsive">
				<table class="table" width="100%" style="border: thin solid #EEE;">
					<thead>
						<tr style="background-color: #f6f6f6;">
							<td align="center">The Land Price</td>
							<td align="center" width="5px"></td>
							<td align="center">Surface Area</td>
							<td align="center" width="5px"></td>
							<td align="center">Macro Price</td>
							<td align="center" width="5px"></td>
							<td align="center">Surface Area</td>
							<td align="center" width="5px"></td>
							<td align="center">Total</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($c['empty_land'], 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> x </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($surface_area, 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> - </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($c['macro_price'], 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> x </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($surface_area, 2, ',', '.'); ?>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> = </td>
							<td style="background-color: #FFFFFF;" align="center">
								<?php echo number_format($total_hasil, 2, ',', '.'); ?>
							</td>
						</tr>
						<tr>
							<td style="background-color: #FFFFFF;" colspan="3" align="center">
								<b>Rp.<?php echo number_format($the_land_price, 2, ',', '.'); ?></b>
							</td>
							<td style="background-color: #FFFFFF;">
								-
							</td>
							<td style="background-color: #FFFFFF;" colspan="3" align="center">
								<b>Rp.<?php echo number_format($macro_price, 2, ',', '.'); ?></b>
							</td>
							<td style="background-color: #FFFFFF;" align="center"> = </td>
							<td style="background-color: #FFFFFF;" align="center">
								<b>Rp.<?php echo number_format($total_hasil, 2, ',', '.'); ?></b>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
<?php
		}
	} else if ($proses == 'code_population') {

		$cluster = mysqli_real_escape_string($db->query, $_POST['cluster']);
		$number = mysqli_real_escape_string($db->query, $_POST['number']);

		$cek_cluster = $db->select('tb_cluster', 'id_cluster="' . $cluster . '"', 'id_cluster', 'DESC');

		if (mysqli_num_rows($cek_cluster) > 0) {
			$c = mysqli_fetch_assoc($cek_cluster);
			$code = 'BGM/BAST/' . $c['code_cluster'] . '/' . $number;
			echo $code;
		}
	}
}
?>