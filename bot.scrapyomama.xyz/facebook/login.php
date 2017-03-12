<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
session_start();
if(!$_SESSION['user']->id){


            
// added in v4.0.0
require '../graph/src/Facebook/autoload.php';
            $fb = new Facebook\Facebook([
  'app_id' => '1783208071933065', // Replace {app-id} with your app id
  'app_secret' => '8ceb57874ac9db6ee57ec0f79d8765ea',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = array(
    'email',
    'user_location',
    'user_birthday'
); // Optional permissions

$loginUrl = $helper->getLoginUrl(Router::url('/fb_calback'), $permissions);
echo "test";


echo '<a href="' . htmlspecialchars($loginUrl) . '"><img src="images/fb_login.png"></a>';}?>
