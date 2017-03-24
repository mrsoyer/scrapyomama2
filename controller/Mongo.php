<?php

class Mongo extends Controller
{

    public function index($e)
    {
    	    $login_email = 'taxibamb@gmail.com';
			$login_pass = 'password';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.facebook.com/login.php');
			curl_setopt($ch, CURLOPT_POSTFIELDS,'email='.urlencode($login_email).'&pass='.urlencode($login_pass).'&login=Login');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'http://zproxy.luminati.io:22225');
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'lum-customer-barney-zone-gen:9c4144973bf3 ');
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; fr-FR; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
			curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			$page = curl_exec($ch) or die(curl_error($ch));



			echo $page;
    }

    public function query($e)
    {
      $this->loadModel($e[0]);

      print_r($this->$e[0]->$e[1]());
    }

}
