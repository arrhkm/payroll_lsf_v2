<?php 
class Database {
	public static $connection;
	public static $server;
	public static $database;
	public static $user;
	public static $password;
	public static $result;
	
	function Database($server, $database, $user, $password) {
			$this->server = $server;
			$this->database = $database;
			$this->user = $user;
			$this->password = $password;		
		}
		
	public function open() {
			$this->connection = mysql_connect($this->server, $this->user, $this->password)
			or die ("Connection failed");
			mysql_select_db($this->database, $this->connection)
		}
	
	public function exec_query($query) {
		 $this->result = mysql_query($query)
		 if(!$this->result) {
				die("Querying Failed: " . mysql_error());		 	
		 	}
		 	return $this->result;
		}
		
	public function row_count($this->result) {
			return mysql_num_rows($this->result)		
		}
	
	public function column_count($this->result) {
			return mysql_num_fields($this->result)		
		}
		
	public close() {
			mysql_close($this->connection);		
		}	
	}
?>