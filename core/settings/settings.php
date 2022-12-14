<?php
	class settings{
		
		function halaman($db,$e,$body,$library_class,$session,$all_file,$hal,$get,$view,$page){

			if(!empty($session)){


				$ubah="hal_".str_replace("-", "_", $hal);
				
				
				echo $all_file->menu($e,$db,$hal);
				echo $all_file->data_html_atas($body);
				echo $all_file->menu_top($e);
				echo $all_file->data_html_tengah();
				echo $all_file->$ubah($db,$e,$library_class,$get,$view,$page);
				echo $all_file->footer();
				echo $all_file->data_html_bawah();

			}else{

				echo $all_file->hal_login($e);

			}

		}

	}
?>