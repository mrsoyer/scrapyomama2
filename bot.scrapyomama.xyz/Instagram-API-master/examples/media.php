<?php

include __DIR__.'/../vendor/autoload.php';
require '../src/Instagram.php';

/////// CONFIG ///////
$username = 'mrsoyer';
$password = '84andoacj-T';
$debug = false;
//////////////////////

// THIS IS AN EXAMPLE OF HOW TO USE NEXT_MAX_ID TO PAGINATE
// IN THIS EXAMPLE, WE ARE RETRIEVING SELF FOLLOWERS
// BUT THE PROCESS IS SIMILAR IN OTHER REQUESTS

$i = new \InstagramAPI\Instagram($username, $password, $debug);

try {
    $i->login();
} catch (Exception $e) {
    echo 'something went wrong '.$e->getMessage()."\n";
    exit(0);
}
try {
    
    $id = $i->getUsernameId('foreverhilaryy');
    
    print_r($id);
    
    print_r($i->getUserFeed($id, 1, 1000000));


    } catch (Exception $e) {
    echo $e->getMessage();
}
