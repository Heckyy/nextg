<?php
		include_once "core/file/function_proses.php";

		$db = new db();

						$ipl_data=$db->select('tb_ipl_upload','id_ipl_upload','id_ipl_upload','ASC');
						while($id=mysqli_fetch_assoc($ipl_data)){

							if($id['property']=='RMH'){
								$property=1;
							}else{
								$property=2;
							}            

							$store_id=substr($id['store_id'],-3);


							$db->insert('tb_population','code_population="'.$id['number_bast'].'",name="'.$id['customer_name'].'",house_number="'.$store_id.'",surface_area="'.$id['luas_tanah'].'",building_area="'.$hitung2.'",type_property="'.$property.'"');

						}




						$cluster_db=$db->select('tb_cluster','id_cluster','id_cluster','ASC');
							foreach ($cluster_db as $key => $c) {
								$ubah_cluster="/".$c['code_cluster']."/";

								$population=$db->select('tb_population','code_population LIKE "%'.$ubah_cluster.'%"','id_population','ASC');
									while($p=mysqli_fetch_assoc($population)){
									
									$db->update('tb_population','id_cluster="'.$c['id_cluster'].'",cluster="'.$c['cluster'].'"','id_population="'.$p['id_population'].'"');
								}
							}


							
				?>