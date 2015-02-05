<?php

	
class SQLi {
	
	private $sql;
	private $res;
	
	public function __construct($h, $u, $p, $db) {
		$this -> sql = new mysqli($h, $u, $p, $db);
		
		// controle si erreurs
		if(mysqli_connect_error()) {
			die('Erreur de connexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
	}
	
	public function query($q) {
		if($this -> res = $this -> sql -> query($q)) {
			return $this -> res;
		} else {
			return $this -> parsErrors();
		}
	}
	
	public function queryFetch($q) {
		$this -> query($q);
		return $this -> res -> fetch_row();
	}
	
	private function parsErrors() {
		echo '<strong>MySQLi Error (' . $this -> sql -> errno . ') : </strong>' . $this -> sql -> error . '<br/><br/>';
		return false;
	}
	
	public function insert_id() {
		return $this -> sql -> insert_id;
	}
	
	public function fetch_row() {
		return $this -> res -> fetch_row();
	}
	
	public function num_rows() {
		return $this -> res -> num_rows;
	}
	
	public function num_rows_q($q) {
		$this -> query($q);
		return $this -> res -> num_rows;
	}
	
	public function escape($str) {
		return $this -> sql -> real_escape_string($str);
	}
	
	public function rClose() {
		$this -> res -> close();
	}
	
	public function __destruct() {
		$this -> sql -> close();
	}
}
?>