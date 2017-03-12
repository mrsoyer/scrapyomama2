<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("fd0b334564dd031283e7b017cd85e5cf", "4b5bd5aece1896e08c52eb06dd90f7ab");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("mrsoyer", "84andoacj-S");

    //Get Stories from Login Response
    $storiesResponse = $login->getStoriesResponse();

    //Iterate My Stories
    foreach($storiesResponse->getMyStories() as $myStory){

        //The Story object
        $story = $myStory->getStory();

        //Details about who viewed your Story
        $storyNotes = $myStory->getStoryNotes();

        //View and Screenshot counts
        $storyExtras = $myStory->getStoryExtras();

        foreach($storyNotes as $storyNote){

            //When the Story was viewed
            $timestamp = $storyNote->getTimestamp();

            //Username that viewed the story
            $viewer = $storyNote->getViewer();

            //Did the user screenshot your story?
            $screenshot = $storyNote->isScreenshotted();

            //todo: do something with the above info

        }

        //How many times the story has been screenshot
        $screenshotCount = $storyExtras->getScreenshotCount();

        //How many times the story has been viewed.
        $viewCount = $storyExtras->getViewCount();

        //Where to Save the Story
        $filename = sprintf("download/stories/%s.%s", $story->getId(), $story->getFileExtension());

        //Download the Story
        $mediapath = $snapchat->downloadStory($story, $filename);

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}