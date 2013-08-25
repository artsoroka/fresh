<?php 

class CategoryController{
	public function premium($app, $args){
		echo "premium section"; 
		if( $args['id'] ) echo $args['id'];
	}

	public function premium_args($app, $args){
		echo $args['id']; 
	}

}