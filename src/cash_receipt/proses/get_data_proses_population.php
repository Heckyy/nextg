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

			$bank = $db->select('tb_bank_cash','id_bank_cash','bank_cash','ASC');
			$b=mysqli_fetch_assoc($bank);


			if(!empty($_POST['cari'])){
				$ubah_pencarian=mysqli_real_escape_string($db->query, str_replace('and_symbol', '&', $_POST['cari']));
			}else{
				$ubah_pencarian="";
			}

			if(!!empty($_POST['dues_type'])){
				$select_dues_type=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				$select_dues_type_pilih=mysqli_real_escape_string($db->query, $_POST['dues_type']);
				
			}else{

				if(!empty($_SESSION['dues_type'])){
					$select_dues_type=$_SESSION['dues_type'];
				}else{
					$select_dues_type="all";
				}
			}

				if($select_dues_type=='all'){
					$select_dues_type_query='';
					$select_dues_type_pilih='all';
				}else{
					$select_dues_type_pilih=$select_dues_type;
					$select_dues_type_query=' && tb_invoice.id_dues="'.$select_dues_type.'"';
				}


			$data = $db->selectpage('tb_invoice INNER JOIN tb_warga ON tb_invoice.id_warga=tb_warga.id_warga INNER JOIN tb_dues ON tb_invoice.id_dues=tb_dues.id_dues','tb_invoice.number_invoice LIKE "%'.$ubah_pencarian.'%" && tb_invoice.status="1" && tb_invoice.status_pembayaran="0" && tb_warga.type="0"'.$select_dues_type_query.' || tb_warga.name LIKE "%'.$ubah_pencarian.'%" && tb_invoice.status="1" && tb_invoice.status_pembayaran="0" && tb_warga.type="0"'.$select_dues_type_query,'tb_invoice.id_invoice','DESC',$startFrom,$perPage);

			$no=$startFrom+1;


			if(mysqli_num_rows($data) > 0 ){
				$jum=mysqli_num_rows($data);
				$i=1;
				$rows = '[';

				foreach ($data as $key => $v) {

					$cluster=$db->select('tb_cluster INNER JOIN tb_rt ON tb_cluster.id_cluster=tb_rt.id_cluster','tb_rt.id_rt="'.$v['id_rt'].'"','tb_cluster.id_cluster','DESC');
					$c=mysqli_fetch_assoc($cluster);

					$ubah=str_replace("=", "", base64_encode($v['number_invoice']));

					$tanggal=substr($v['tanggal'], 8,2);
					$bulan=substr($v['tanggal'], 5,2);
					$tahun=substr($v['tanggal'], 0,4);
					$date=$tanggal."-".$bulan."-".$tahun;

					$tagihan = $v['amount']-$v['bayar'];

					$rows.='{"no":"'.$no.'",';
					$rows.='"target":"'.$ubah.'",';
					$rows.='"number":"'.$v["number_invoice"].'",';
					$rows.='"tanggal":"'.$date.'",';
					$rows.='"amount":"'.number_format($tagihan,2,',','.').'",';
					$rows.='"name":"'.$v["name"].'",';
					$rows.='"cluster":"'.$c["cluster"].'",';
					$rows.='"rt":"'.$c["number"].'",';
					$rows.='"dues_type":"'.$v["dues_type"].'"}';

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

	}
?>
