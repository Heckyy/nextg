<?php
		include_once "core/file/function_proses.php";

		$db = new db();

						$cluster_db=$db->select('tb_cluster','id_cluster','id_cluster','ASC');
							foreach ($cluster_db as $key => $c) {
								$ubah_cluster="/".$c['code_cluster']."/";

								$population=$db->select('tb_population','code_population LIKE "%'.$ubah_cluster.'%"','id_population','ASC');
									while($p=mysqli_fetch_assoc($population)){
									
									$db->update('tb_population','id_cluster="'.$c['id_cluster'].'",cluster="'.$c['cluster'].'"','id_population="'.$p['id_population'].'"');
								}
							}
?>