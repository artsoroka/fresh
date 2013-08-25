<?php 

function bootstrap_models($class) {

    $path = '../models/' . strtolower($class) . '.class.php'; 

   	if( file_exists($path) ) include $path;


}

function bootstrap_controllers($class) {
    
    $path = '../controllers/' . strtolower($class) . '.php'; 

    if( file_exists($path) ) include $path; 
    
}



spl_autoload_register('bootstrap_models');
spl_autoload_register('bootstrap_controllers');
