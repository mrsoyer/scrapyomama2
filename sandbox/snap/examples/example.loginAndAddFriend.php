<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("fd0b334564dd031283e7b017cd85e5cf", "4b5bd5aece1896e08c52eb06dd90f7ab");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
        $login = $snapchat->login("mrsoyer", "84andoacj-S");


    //Add Friend
    $snapchat->addFriend("kevinpiac");
   echo  $snapchat->findCachedFriend("kevinpiac");
  

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}