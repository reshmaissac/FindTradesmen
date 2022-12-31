<?php
class DBConnection {

	protected $dbCon;
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_HOST = "localhost";
	const DB_NAME = "c2023237_db1";
	
	// Create connection
	protected function getConnection() {
		echo "getCon called!!!!!!!!!!!!!";
		$dbCon = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
		
		// Check connection
		if ($dbCon->connect_error) {
			echo "CON FAILED !";
			die("Connection failed: " . $dbCon->connect_error);
		}
		
		$dbCon -> set_charset("utf8");
		return $dbCon;
	} 
}
?>

