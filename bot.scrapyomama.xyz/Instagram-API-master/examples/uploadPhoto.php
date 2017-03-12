<?php

include __DIR__.'/../vendor/autoload.php';
require '../src/Instagram.php';

$username = 'mrsoyer';
$password = '84andoacj-T';
$debug = true;

$photo = '/var/www/vhosts/scrapyomama.xyz/bot.scrapyomama.xyz/Instagram-API-master/examples/pic/16508827_573495029526880_477314233720001466_n.jpg';     // path to the photo
$caption = '16508827_573495029526880_477314233720001466_n.jpg';     // caption
$i = new \InstagramAPI\Instagram($debug);

$i->setUser($username, $password);

try {
    $i->login();
} catch (Exception $e) {
    $e->getMessage();
    exit();
}

try {
    $i->uploadPhoto($photo, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}

