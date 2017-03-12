<?php
ini_set('memory_limit','-1');
set_time_limit(0);
// Afficher les erreurs à l'écran
//xdebug_disable();
// Afficher les erreurs et les avertissements
//error_reporting(E_ALL);
//ini_set ( "log_errors", 1 );
//ini_set ( "error_log", "/logs/error.log" );
ini_set ( "display_errors", 0 );
//error_reporting(0);
define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('CORE', ROOT.DS.'core');
define('CONFIG', ROOT.DS.'config');
define('SYM', '$this');
date_default_timezone_set('Europe/Paris');

require(ROOT.DS.'vendor'.DS.'autoload.php');
require(CORE.DS.'includes.php');

///////////////////////////////////////////
// create an http router to avoid that...
if (isset($_POST['token']) && isset($_POST['fb_account_id']))
{

    $token = $_POST['token'];
    $fb_account_id = $_POST['fb_account_id'];

    if (!empty($token) && !empty($fb_account_id))
    {
        $c = Controller::loadController('Bots');
        $c->loadModel('FbAccount');
        $c->FbAccount->updateById($fb_account_id, array(
            'token' => $token
        ));
    }
}

else if (isset($_GET['url']))
{
    $r = new Router($_GET['url']);
    $r->executeHttpAction();
}

else if (isset($argc) && isset($argv))
{
    $r = new ShellRouter($argc, $argv);
    $r->executeAction();
}

?>
