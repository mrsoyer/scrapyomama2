<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("fd0b334564dd031283e7b017cd85e5cf", "4b5bd5aece1896e08c52eb06dd90f7ab");

$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("mrsoyer", "84andoacj-S");

    //Find friends by Numbers and Names
    $findFriends = $snapchat->findFriends( array(
        "sethie.oconner" => "sethie.oconner",
        "apricard_pie" => "apricard_pie",
        "nvl716" => "nvl716",
    ));

    $results = $findFriends->getResults();
	print_r($results);
	
    foreach($results as $result){
        echo sprintf("Found Friend: Username=%s Display=%s", $result->getName(), $result->getDisplay()) . "\n";
        
    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
    echo "ok";
    
}