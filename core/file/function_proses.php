<?php
class db
{

	var $mysqli_host     = "localhost";
	var $mysqli_database = "nextg_rw";
	var $mysqli_user     = "root";
	var $mysqli_password = "";
	var $mysqli_host_app     = "localhost";
	var $mysqli_database_app = "nextg_mobileapp";
	var $mysqli_user_app     = "root";
	var $mysqli_password_app = "";


	var $query = "";
	var $query_app = "";
	function __construct()
	{
		$this->query = mysqli_connect($this->mysqli_host, $this->mysqli_user, $this->mysqli_password, $this->mysqli_database);
		// $this->query_app = mysqli_connect($this->mysqli_host_app, $this->mysqli_user_app, $this->mysqli_password_app, $this->mysqli_database_app);
	}

	function select($table, ?string $where, $by, $aksi, $kolom = '*')
	{
		$query = mysqli_query($this->query, "SELECT $kolom FROM $table where $where order by $by $aksi");
		return $query;
	}
	function selectAll($query)
	{
		$query = mysqli_query($this->query, $query);
		return $query;
	}

	function selectDo($data)
	{
		$query = mysqli_query($this->query, $data);
		return $query;
	}


	function select_app($table, $where, $by, $aksi, $kolom = '*')
	{
		$query_app = mysqli_query($this->query_app, "SELECT $kolom FROM $table where $where order by $by $aksi");
		return $query_app;
	}

	function selectpage($table, $where, $by, $aksi, $awal, $akhir, $kolom = '*')
	{
		$query = mysqli_query($this->query, "SELECT $kolom FROM $table where $where order by $by $aksi LIMIT {$awal} , {$akhir}");
		return $query;
	}

	function selectpage_app($table, $where, $by, $aksi, $awal, $akhir, $kolom = '*')
	{
		$query_app = mysqli_query($this->query_app, "SELECT $kolom FROM $table where $where order by $by $aksi LIMIT {$awal} , {$akhir}");
		return $query_app;
	}

	function insert($table, $set)
	{
		$query = mysqli_query($this->query, "INSERT INTO $table SET $set");
		return $query;
	}

	function update($table, $set, $where)
	{
		$query = mysqli_query($this->query, "UPDATE $table SET $set WHERE $where");
		return $query;
	}

	function hapus($table, $where)
	{
		$query = mysqli_query($this->query, "DELETE FROM $table WHERE $where");
		return $query;
	}
}
