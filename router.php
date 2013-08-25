<?php 

$app = require('lib/base.php');

/*
	Main page route controllers 	
*/


  $m = new Yes(true);

  // Set start
  $m->setStart();

  // Set memory usage before loop
  $m->setMemoryUsage('Before Loop');




$app->route('GET /', 'SiteController->mainpage');

$app->route('GET /@category', 'SiteController->category');


$app->route('GET /view', function($app){
	$app->set('xvar', 'something'); 
	echo \Template::instance()->render('../views/test.html'); 

	//	$fw=Base::instance();
	//	echo $fw->get('TEMP');


});

$app->route('GET /memory', function($app) use($m){

	$db = DB::test(); 
	$dbf = new DBF;

	$x = $dbf::ls_oil_brands(); 
	$arr = array();

	for ($i=0; $i <100 ; $i++) { 
		$arr[$i] = md5(sha1(md5(uniqid()))); 
	}

	print_r($arr); 

	  // Set memory usage after loop
  $m->setMemoryUsage('After Loop');

  // Set end
  $m->setEnd();

  // Print memory usage statistics
  $m->printMemoryUsageInformation();


  // Print memory usage statistics
  $m->printMemoryUsageInformation();
 



});



 



/*





$app->route('GET /obj', 'Product->hey'); 
$app->route('GET /',
    function() {
	echo 'heyyou'; //$app->get('PARAMS.mykey');
    }
);


$app->route('GET /obj/@mykey', 'Product->pass'); 

$app->route('GET /brew',
    function($app) {
    	echo "dir"; 
    }
);


$app->route('GET /err',
    function($app) {
    	$app->set('xval', 'testing'); 
    	echo View::instance()->render('../test.html'); 
    	//$app->error(404); 
    }
);

$app->route('GET /brew/@count',
    function($app) {
    	$param = $app->get('PARAMS.count'); 
	$planb = isset($_GET['hey']) ? $_GET['hey'] : false;
	$planb = isset($planb) ? $planb : false;   
	$product = new Product;
	if( $planb ) $product->callmenow($planb);
        //echo $app->get('PARAMS.count').' bottles of beer on the wall.';
    }
);


$app->set('ONERROR',

	function($app) {

		switch ($app->get('ERROR.code')) {
			case 404: echo "404"; 

					
				break;
			
			default: 
				
				break;
		}
	}
);

*/


$app->run();