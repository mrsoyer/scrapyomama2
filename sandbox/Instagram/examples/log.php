<?php

$c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://instagram.com/accounts/login/?force_classic_login');
    curl_setopt($c, CURLOPT_REFERER, 'https://instagram.com/accounts/login/?force_classic_login');
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_COOKIEFILE, 'cookiess.txt');
    curl_setopt($c, CURLOPT_COOKIEJAR, 'cookiess.txt');
    $page = curl_exec($c);
    curl_close($c);

    preg_match_all('/<input type="hidden" name="csrfmiddlewaretoken" value="([A-z0-9]{32})"\/>/', $page, $token);

    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://instagram.com/accounts/login/?force_classic_login');
    curl_setopt($c, CURLOPT_REFERER, 'https://instagram.com/accounts/login/?force_classic_login');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, "csrfmiddlewaretoken=".$token[1][0]."&username=mrsoyer&password=84andoacj-T");
    curl_setopt($c, CURLOPT_COOKIEFILE, 'cookiess.txt');
    curl_setopt($c, CURLOPT_COOKIEJAR, 'cookiess.txt');
    $page = curl_exec($c);
    curl_close($c);
	echo $page;
	
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://instagram.com/ionagarcia/');
    curl_setopt($c, CURLOPT_REFERER, 'https://instagram.com/');
    curl_setopt($c, CURLOPT_HTTPHEADER, array(
        'Accept-Language: en-US,en;q=0.8',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36',
        'Accept: */*',
        'X-Requested-With: XMLHttpRequest',
        'Connection: keep-alive'
        ));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_COOKIEFILE, 'cookiess.txt');
    curl_setopt($c, CURLOPT_COOKIEJAR, 'cookiess.txt');
    $page = curl_exec($c);
    curl_close($c);

   // echo $page;

?>