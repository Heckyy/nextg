<?php
	class library_class{

		function tanggal_real(){
			date_default_timezone_set("Asia/Jakarta");
			return date("ymd");
		}
		function tanggal(){
			date_default_timezone_set("Asia/Jakarta");
			return date("d");
		}
		function bulan(){
			date_default_timezone_set("Asia/Jakarta");
			return date("m");
		}
		function tahun(){
			date_default_timezone_set("Asia/Jakarta");
			return date("Y");
		}
		function jam(){
			date_default_timezone_set("Asia/Jakarta");
			return date("H:i");
		}


		function ceiling($number, $significance) {
			if ($significance != null) {
			    return (is_numeric($number) && is_numeric($significance) ) ? (ceil($number / $significance) * $significance) : $number;
			} else {
			    return $number;
			}
		}
	}
