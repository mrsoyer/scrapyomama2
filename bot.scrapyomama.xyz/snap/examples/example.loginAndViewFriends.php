<?php

use Snapchat\API\Response\Model\Friend;

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("fd0b334564dd031283e7b017cd85e5cf", "4b5bd5aece1896e08c52eb06dd90f7ab");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    //$casper->setProxy("191.96.243.48:80"); //Proxy for Casper API
    //$snapchat->setProxy("https://191.96.243.48:80"); //Proxy for Snapchat API
    $snapchat->login("mrsoyer", "84andoacj-S");
    print_r($snapchat);

    $friendsResponse = $snapchat->getCachedFriendsResponse();

    //Friends that you added
    $friends = $friendsResponse->getFriends();

    //Friends that added you.
    $friendRequests = $friendsResponse->getAddedFriends();

    foreach($friends as $friend){
        echo sprintf("You added %s to your friends list!\n", $friend->getName());
    }

    foreach($friendRequests as $friendRequest){

        $friendType = $friendRequest->getType();

        //Your Privacy settings are Friends Only
        if($friendType == Friend::TYPE_PENDING){
            echo sprintf("%s wants to add you as a friend!\n", $friendRequest->getName());
        }

        //Your Privacy settings are Everyone
        if($friendType == Friend::TYPE_FOLLOWING){
            echo sprintf("%s is following you, but you haven't added them back\n", $friendRequest->getName());
        }

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}