<?php
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'scrapyomama');    // DB username
define('DB_PASSWORD', 'Fistinierdu13');    // DB password
define('DB_DATABASE', 'scrapyomama');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");
?>