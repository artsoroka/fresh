<?php 

class SiteController {
	public function mainpage($app, $args){
		echo "index page"; 
		//print_r(DB::test()); 
	}

	public function category($app, $args){
		echo $args['category']; 
	}

}