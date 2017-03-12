<?php

include("mongo-api-php/mongoapi.class.php");

$db = "sym";
$col = "test";
$apiKey = "qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8";


$mongo =new MongoAPI("sym","qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8","test");
		$query=NULL;	
		
		$vars=array(
        'x' => '55'
    );	

 print_r($mongo->insert($vars));
 
  print_r($mongo->get());
