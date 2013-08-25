<?php 


$config = parse_ini_file("../config/app.ini", true);

define('DB_HOST', $config['database']['db_host']);
define('DB_PORT', $config['database']['db_port']);
define('DB_NAME', $config['database']['db_name']);
define('DB_USER', $config['database']['db_user']);
define('DB_PASS', $config['database']['db_pass']);


require '../autoloader.php'; 
require '../router.php';  
