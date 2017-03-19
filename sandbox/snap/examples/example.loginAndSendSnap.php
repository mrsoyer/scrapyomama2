<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("fd0b334564dd031283e7b017cd85e5cf", "4b5bd5aece1896e08c52eb06dd90f7ab");

$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("mrsoyer", "84andoacj-S");

    //Upload Photo to Snapchat
    $uploadPayload = $snapchat->uploadVideo("2.mp4");
	print_r($uploadPayload);
    //Send Snap
  //  $snapchat->sendMedia($uploadPayload, 10, array("seb.sikorski"),true);

    //Send Snap (and set as Story)
    //$snapchat->sendMedia($uploadPayload, 10, array("recipient"), true);

    //Set Story only
    print_r($snapchat->sendMedia($uploadPayload, 10, array(), true));

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}