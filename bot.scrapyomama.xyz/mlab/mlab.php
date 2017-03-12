<?php
$post = "";




$x=array(
        'x' => '3'
    );
    $data=json_encode($x);
    //echo $data;

    $opts = array('http' =>
        array(
            'method'  => 'PUT',
            'header'  => 'Content-type: application/json',
            'content' => $data
        )
    );

    $context  = stream_context_create($opts);

    $result = file_get_contents('https://api.mlab.com/api/1/databases/sym/collections/test?apiKey=qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8', false, $context);

    echo $result;
    
    echo "\n\n---\n\n";


$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, 'https://api.mlab.com/api/1/databases/sym/collections/test?f=&l=1000&apiKey=qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8');
//curl_setopt($ch,CURLOPT_POST, 1);
//curl_setopt($ch,CURLOPT_POSTFIELDS, $opts);

//execute post
$result = curl_exec($ch);

echo $result;
//close connection
curl_close($ch);