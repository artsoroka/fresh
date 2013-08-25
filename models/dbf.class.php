<?php


class DBF{

	public static $_host = DB_HOST;  
	public static $_port = DB_PORT; 
	public static $_db = DB_NAME;    
	public static $_user = DB_USER; 
	public static $_password = DB_PASS;
		
	public static  function connection(){
		$host = &self::$_host;
		$port = &self::$_port;
		$db = &self::$_db;
		$user = &self::$_user;
		$password = &self::$_password;
	
		try {
		
			$connection = @new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
				
			return $connection;
		
		} catch (Exception $e) {
		    //echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
			return false; 
		} 
	} 
	

	public static function ls_oil_brands(){

		$conn = self::connection();

		if(!$conn){
			throw new Exception(" conn is false ", 1);
		}

			$query = $conn->prepare("SELECT * FROM category WHERE parent_id = 15 OR parent_id = 14"); 
		
		try {
			$query->execute();
		} catch (Exception $e) {
			echo $e->getMessage(); 
		}


		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	}

    public static function ls_oil_origin(){

		$conn = self::connection();

		if(!$conn){
			throw new Exception(" conn is false ", 1);
		}

			$query = $conn->prepare("SELECT * FROM category WHERE parent_id = 14");

		try {
			$query->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}


		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;

	}

    public static function ls_oil_not_origin(){

		$conn = self::connection();

		if(!$conn){
			throw new Exception(" conn is false ", 1);
		}

			$query = $conn->prepare("SELECT * FROM category WHERE parent_id = 15");

		try {
			$query->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}


		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;

	}



	public static function delete_entry($entry_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
				
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		
		$query = $conn->prepare("DELETE FROM product_tags WHERE uid = (SELECT uid FROM products WHERE id = :id)"); 
		$query->bindParam(':id', $entry_id, PDO::PARAM_STR);
		$query->execute();

		$query = $conn->prepare("DELETE FROM products WHERE id = :id"); 
		$query->bindParam(':id', $entry_id, PDO::PARAM_STR);
		$query->execute();

	}

	public static function get_product_info($product_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;

	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
		$query->bindParam(':product_id', $product_id, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result; 
	}

	public static function get_remote_image($url){

		try{
			
			$file_name = end(explode("/", $url)); 
			$file_extension = end(explode(".", $file_name));
			$filename = uniqid(); 
			$filename = $filename . "." . $file_extension; 
	  		//copy($url, 'upload/' . $filename);  
	 		$content = @file_get_contents($url);
	 		if($content){

		 		//Store in the filesystem.
				$fp = fopen("upload/images/" . $filename, "w");
				fwrite($fp, $content);
				fclose($fp);
				return $filename; 
	
	 		} else {
	 			return "null"; 
	 		}

		} catch (Exception $e) {
	    	return false; 
	    }

	}
/*
	public static function update_product($id, $articul, $vsid, $product_price){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
		
		$product_foto = self::get_remote_image($product_foto); 

		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("UPDATE products SET articul = :articul , vsid = :vsid , price = :price WHERE id = :id "); 
		
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->bindParam(':vsid', $vsid, PDO::PARAM_STR);
		$query->bindParam(':articul', $articul, PDO::PARAM_STR);
		$query->bindParam(':price', $product_price, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
	}
*/
	public static function bind_items($product_uid, $articul){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
		
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("SELECT * FROM products WHERE articul = :articul"); 
		
		$query->bindParam(':articul', $articul, PDO::PARAM_STR);
		
		$query->execute();
		
		$result = $query->fetch(PDO::FETCH_OBJ);
		
		if($result){
			$suid = $result->uid; 

			$query = $conn->prepare("INSERT INTO product_bindings (id, uid, suid) VALUES(null, :uid, :suid) "); 
			
			$query->bindParam(':uid', $product_uid, PDO::PARAM_STR);
			$query->bindParam(':suid', $suid, PDO::PARAM_STR);
			
			$query->execute();
			
			$result = $query->fetch(PDO::FETCH_OBJ);

			return $result; 
		} else {
			return false; 
		}

	}

	public static function ls_product_bindings($product_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
		
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		//$query = $conn->prepare("SELECT * FROM product_bindings WHERE uid OR suid = (SELECT uid FROM products WHERE id = :product_id)"); 
		//$query = $conn->prepare("SELECT pb.id, pb.uid, pb.suid FROM product_bindings as pb 
		//	JOIN products as p1 on (pb.uid = p1.uid) WHERE pb.uid = (SELECT uid FROM products WHERE id = :product_id) 
		//	OR pb.suid = (SELECT uid FROM products WHERE id = :product_id)"); 

		$query = $conn->prepare("SELECT pb.id, pb.uid, pb.suid, p.id as p_id, p.uid as p_uid, p.articul as p_articul, p.price as p_price,
			p1.id as p1_id, p1.uid as p1_uid, p1.articul as p1_articul, p1.price as p1_price    
			FROM product_bindings as pb 
			JOIN products as p on (pb.uid = p.uid) 
			JOIN products as p1 on (pb.suid = p1.uid) WHERE pb.uid = (SELECT uid FROM products WHERE id = :product_id) 
			OR pb.suid = (SELECT uid FROM products WHERE id = :product_id)"); 

		$query->bindParam(':product_id', $product_id, PDO::PARAM_STR);
		
		$query->execute();
		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $result; 
	}

	public static function remove_binding($binding_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
		
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("DELETE FROM product_bindings WHERE id = :binding_id"); 
		
		$query->bindParam(':binding_id', $binding_id, PDO::PARAM_STR);
		
		$query->execute();
		
		$result = $query->fetch(PDO::FETCH_OBJ);
		

	} 

	public static function add_product_color($product_uid, $product_color){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("INSERT INTO product_colors (id, uid, color) VALUES(null, :product_uid, :product_color)"); 
		
		$query->bindParam(':product_uid', $product_uid, PDO::PARAM_STR);
		$query->bindParam(':product_color', $product_color, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
	


	}

	public static function ls_product_colors($product_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("SELECT * FROM product_colors WHERE uid = (SELECT uid FROM products WHERE id = :product_id)"); 
		
		$query->bindParam(':product_id', $product_id, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	}

	public static function remove_color($color_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("DELETE FROM product_colors WHERE id = :color_id"); 
		
		$query->bindParam(':color_id', $color_id, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	} 


	public static function add_product_size($product_uid, $product_size){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("INSERT INTO product_sizes (id, uid, size) VALUES(null, :product_uid, :product_size)"); 
		
		$query->bindParam(':product_uid', $product_uid, PDO::PARAM_STR);
		$query->bindParam(':product_size', $product_size, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);

	}



	public static function ls_product_sizes($product_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("SELECT * FROM product_sizes WHERE uid = (SELECT uid FROM products WHERE id = :product_id)"); 
		
		$query->bindParam(':product_id', $product_id, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	}


	public static function remove_size($size_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("DELETE FROM product_sizes WHERE id = :size_id"); 
		
		$query->bindParam(':size_id', $size_id, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	} 




	public static function ls_category($category_id){
		$host = self::$_host;
		$port = self::$_port;
		$db = self::$_db;
		$user = self::$_user;
		$password = self::$_password;
	
		$conn = new PDO("mysql:host=$host;port=$port;dbname=$db",$user,$password);
		$query = $conn->prepare("SELECT * FROM products WHERE category = :category_id"); 
		
		$query->bindParam(':category_id', $category_id, PDO::PARAM_STR);
		
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result; 

	} 





}
?>
