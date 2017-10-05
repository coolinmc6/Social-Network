<?php 

class DB {

	private static function connect() {
		$opt = array(
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		$pdo = new PDO('mysql:host=localhost;dbname=Social_Network;charset=utf8', 'root', 'root', $opt);
		// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	public static function query($query, $params = array()) {
		$statement = self::connect()->prepare($query);
		$statement->execute($params);

		if(explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			// print_r($data);
			return $data;	
		}
		
	}
}



 ?>