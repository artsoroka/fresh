<?php 

class Product{

  public function hey(){
    echo "hooooooooooooooooooyeah"; 
  }
  public function pass($f3, $params){
  	var_dump($f3->get('PARAMS.mykey'));
  }

  public function callmenow($args){
     echo "controller: " . $args;  
  }
  public function beforeRoute(){
     echo "before filter"; 
  }

}
