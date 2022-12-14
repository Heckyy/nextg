<?php
			$tanggal_bank_proses="1-mar-2022";

			$tanggal_bank_prosess=substr($tanggal_bank_proses, 0,1);
			$bulan_bank=substr($tanggal_bank_proses, 2,3);
			$tahun_bank=substr($tanggal_bank_proses, 6,4);
			$tanggal_bank_masuk_data=$tahun_bank.'-'.$bulan_bank.'-0'.$tanggal_bank_prosess;

			$jum_kar=strlen($tanggal_bank_prosess);

			if($jum_kar<2){
				$jum_kar='0'.$tanggal_bank_prosess;
			}
			echo $jum_kar;
			?>
