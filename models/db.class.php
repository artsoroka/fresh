<?php 


class DB{

	public static  function connection(){
		$host = DB_HOST;
		$port = DB_PORT;
		$db = DB_NAME;
		$user = DB_USER;
		$password = DB_PASS; 
	
		try {
		
			$connection = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
				
			return $connection;
		
		} catch (Exception $e) {
		    echo 'Could not connect to the database: ',  $e->getMessage(), "\n";
			return false; 
		} 
	} 
	

	public static function test(){

		$conn = self::connection();

		if(!$conn) throw new Exception(" conn is false ", 1); 

			$query = $conn->prepare("SELECT * FROM items"); 
		
		try {
			$query->execute();
		} catch (Exception $e) {
			echo $e->getMessage(); 
		}


		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	}

}