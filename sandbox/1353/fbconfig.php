<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
require 'functions.php'; 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret




FacebookSession::setDefaultApplication( '1783208071933065','8ceb57874ac9db6ee57ec0f79d8765ea' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://bot.scrapyomama.xyz/1353/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  
 $taggable = (new FacebookRequest( $session, 'GET', '/me/taggable_friends' ))->execute()->getGraphObject()->asArray();
// output response
echo '<pre>' . print_r( $taggable, 1 ) . '</pre>';
// output total friends
echo count( $taggable['data'] );
	die();
	
  /*$request = new FacebookRequest( $session, 'GET', '/me?fields=name,email'); 
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	    
	   
	
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
    
    echo $fbid.",".$fbfullname.",".$femail;*/
    die();
    checkuser($fbid,$fbfullname,$femail);
  header("Location: index.php");
} else {
  $loginUrl = $helper->getLoginUrl(array('scope' => 'email,ads_read,user_friends,ads_management'));
  
 header("Location: ".$loginUrl);
}
?>