<?php

class SBlink extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
      echo '
///////////////////////////////////////////////////////////////////////////////|
//                                           __________  __   __   __    __   ||
//  Cards.php                              / _________/ | |  / /  /  |  /  |  ||
//                                        / /_______    | | / /  /   | /   |  ||
//                                        \______   \   | |/ /  / /| |/ /| |  ||
//  Created: 2015/10/29 12:30:05         ________/  /   |   /  / / |   / | |  ||
//  Updated: 2015/10/29 21:45:22        /__________/    /  /  /_/  |__/  |_|  ||
//                                      ScrapYoMama    /__/    by barney.im   ||
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*
    ';

    $url = "https://static.xx.fbcdn.net/rsrc.php/v3/yk/r/_2faPUZhPI6.png";
    //echo  base64_encode($url);
    echo "\n";
    $encode =   rtrim(strtr(base64_encode($url), '+/', '-_'), '=');
    $decode = base64_decode(str_pad(strtr($encode, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    echo $encode;
    echo "\n";

    }

    public function sayHello($e)
    {
        echo ("Les paramertres sont : ". $params[0]. " et ".$params[1]);
    }
}
