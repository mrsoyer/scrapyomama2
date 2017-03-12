<?php

include __DIR__.'/../vendor/autoload.php';
require '../src/Instagram.php';

/////// CONFIG ///////
$username = 'mrsoyer';
$password = '84andoacj-T';
$debug = false;

$photo = 'photo.jpg';     // path to the photo
$caption = 'photo.jpg';     // caption
//////////////////////

$i = new \InstagramAPI\Instagram($username, $password, $debug);

try {
    $i->login();
} catch (Exception $e) {
    $e->getMessage();
    exit();
}

try {
   // $i->uploadPhoto($photo, $caption);
    $i->getUserFollowers("ionagarcia", $maxid = null);
    print_r($i);
} catch (Exception $e) {
    echo $e->getMessage();
}
