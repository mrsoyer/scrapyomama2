<?php

$url = 'https://api.ipify.org?format=json';
$timeout = 10;

$proxy_host = '109.73.79.145:80'; // host:port
$proxy_ident = ''; // username:password

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

if (preg_match('`^https://`i', $url))
{
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
}

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Activation de l'utilisation d'un serveur proxy
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);

// Définition de l'adresse du proxy
curl_setopt($ch, CURLOPT_PROXY, $proxy_host);

// Définition des identifiants si le proxy requiert une identification
if ($proxy_ident)
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_ident);

$page_content = curl_exec($ch);

curl_close($ch);


echo $page_content;
?>