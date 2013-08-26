<?php 

class CategoryController{
	public function premium($app, $args){
		echo "premium section"; 
		if( isset($args['id']) ) echo "id is set: " . $args['id'];  
	}

	public function premium_args($app, $args){
		echo $args['id']; 
	}

}