<?php
session_start();
// added in v4.0.0
require FB.'/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => 'app id',
  'app_secret' => 'app secret',
  'default_graph_version' => 'v2.8',
]);


$helper = $fb->getRedirectLoginHelper();



//$_SESSION['FBRLH_state']=$_GET['state'];

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
	
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);
$getUserId = $tokenMetadata->getUserId();
//echo $getUserId;
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,first_name,last_name,email,picture', $accessToken->getValue());
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$users = $response->getGraphUser();




// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('448501908589003'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
if(!empty( $users['email'])){
	/* $users résultat retourner par facebook */		
	$user = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $user->execute([$users['email']]);
       $user=$episodes->fetch();
				/*
				recherche si l'utilisateur existe */
				if(empty($user->email)){
				/*si l'utilisateur existe c'est une inscription */
				$data1=new stdClass;//creation d'un objet pour stoquer les donner
 			$data1->login=$users['first_name'];
			$data1->password=sha1($users['first_name']);//criptage de mot de passe
	         $data1->email=$users['email'];
	         $data1->nom=$users['first_name'];
	         $data1->prenom=$users['last_name'];
			 $data1->role='user';
	        $data1->image='https://graph.facebook.com/'.$getUserId.'/picture?width=140&height=110';/*strectutre de facebook photo de profil chez graph.facebook*/
	$user= $pdo->prepare("INSERT INTO users (login, password, email, nom, prenom,role,image) VALUES (:login, :password, :email,:nom,:prenom,:image,:role)");
    $req->execute($data1);
	$user = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $user->execute([$users['email']]);
       $user=$episodes->fetch();
     $_SESSION['user']=$user;
}else{
	$_SESSION['user']=$user;

}
	if($_SESSION['user']->id){
			if($_SESSION['user']->role == 'admin'){
				
				header('Location: administration.php');
			}else{
			if($_SESSION['user']->role == 'user'){
				header('Location: "user.php?id={$_SESSION['user']->id}"'); 
				
			}
		}}
	}
	else{header('Location:login.php');}