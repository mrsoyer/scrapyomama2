<?php
require 'ccproto_client.php';

$file = array_map('rtrim', file('credentials.txt'));

$lines = count($file);

if ($lines % 4 !== 0) {
    echo 'invalid credentilas file', PHP_EOL;
}

$num = $lines / 4;

$creds = array();

for ($i = 0; $i < $lines; $i += 4) {
    $creds[] = array(
        'host' => $file[$i],
        'port' => intval($file[$i + 1]),
        'username' => $file[$i + 2],
        'password' => $file[$i + 3],
    );
}

$pic_file_name = 'image.jpg';

$ccp = new ccproto();
$ccp->init();

$curr_creds = &$creds[rand(0, $num - 1)];

echo 'server: ', $curr_creds['host'], ':', $curr_creds['port'], PHP_EOL;

echo 'Logging in...';

if ($ccp->login($curr_creds['host'], $curr_creds['port'], $curr_creds['username'], $curr_creds['password']) < 0) {
    echo ' FAILED', PHP_EOL;
    return;
}
else {
    echo ' OK', PHP_EOL;
}

$system_load = 0;

if ($ccp->system_load($system_load) !== CC_ERR_OK) {
    echo 'system_load() FAILED', PHP_EOL;
    return;
}

echo 'System load = ', $system_load, ' perc', PHP_EOL;

$balance = 0;

if ($ccp->balance($balance) !== CC_ERR_OK) {
    echo 'balance() FAILED', PHP_EOL;
    return;
}

echo 'Balance = ', $balance, PHP_EOL;

$major_id	= 0;
$minor_id	= 0;

$pict = file_get_contents($pic_file_name);
$text = '';
echo 'sending a picture...';

$pict_to	= CC_PTO_DEFAULT;
$pict_type	= CC_PT_UNSPECIFIED;

$start = microtime(true);
$res = $ccp->picture2($pict, $pict_to, $pict_type, $text, $major_id, $minor_id);
$end = microtime(true);

switch($res) {
    // most common return codes
    case CC_ERR_OK:
        echo 'OK', PHP_EOL;
        echo 'got text for id=', $major_id, '/', $minor_id, ', type=', $pict_type, ', to=', $pict_to, ', text="', $text, '"';
        break;
    case CC_ERR_BALANCE:
        echo 'not enough funds to process a picture, balance is depleted';
        break;
    case CC_ERR_TIMEOUT:
        echo 'picture has been timed out on server (payment not taken)';
        break;
    case CC_ERR_OVERLOAD:
        echo 'temporarily server-side error: server\'s overloaded, wait a little before sending a new picture';
        break;

    // local errors
    case CC_ERR_STATUS:
        echo 'local error.';
        echo ' either ccproto_init() or ccproto_login() has not been successfully called prior to ccproto_picture()';
        echo ' need ccproto_init() and ccproto_login() to be called';
        break;

    // network errors
    case CC_ERR_NET_ERROR:
        echo 'network troubles, better to call ccproto_login() again';
        break;

    // server-side errors
    case CC_ERR_TEXT_SIZE:
        echo 'size of the text returned is too big';
        break;
    case CC_ERR_GENERAL:
        echo 'server-side error, better to call ccproto_login() again';
        break;
    case CC_ERR_UNKNOWN:
        echo 'unknown error, better to call ccproto_login() again';
        break;

    default:
        // any other known errors?
        break;
}

echo PHP_EOL;

echo 'time taken: ', number_format($end - $start, 3, '.', ''), ' seconds', PHP_EOL;

// process a picture and if it is badly recognized 
// call picture_bad2() to name it as error. 
// pictures named bad are not charged
//$ccp->picture_bad2($major_id, $minor_id);

$balance = 0;

if ($ccp->balance($balance) !== CC_ERR_OK) {
    echo 'balance() FAILED', PHP_EOL;
    return;
}

echo 'Balance = ', $balance, PHP_EOL;

$ccp->close();
/*
// also you can mark picture as bad after session is closed, but you need to be logged in again
$ccp->init();
echo 'Logging in...';

if ($ccp->login($host, $port, $username, $password) < 0) {
    echo ' FAILED', PHP_EOL;
    return;
}
else {
    echo ' OK', PHP_EOL;
}

echo 'Naming picture ', $major_id, '/', $minor_id, ' as bad', PHP_EOL;

$ccp->picture_bad2($major_id, $minor_id);
$ccp->close();
*/
?>
