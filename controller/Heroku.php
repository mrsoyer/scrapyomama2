
<?php

class Heroku extends Controller
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
    }

    public function curl($params)
    {
        echo ("Les paramertres sont : ". $params[0]. " et ".$params[1]);
    }

    public function curlMongo($params)
    {
        echo ("Les paramertres sont : ". $params[0]. " et ".$params[1]);
    }

    public function mongo($params)
    {
        $sym = $this->newsym("Api");
        print_r('ok');
        $dom = $sym->V1([
          _coll => Domain,
          _q => [account => ['$exists' => false]],
          _sup => '&sk=0&l=1'
        ]);
        print_r($dom);
        print_r('ok');
    }

    public function async($params)
    {
      $async = $this->newsym('Async');
        $reponse =
          $async->sync([

              [SBasync, wait, [1],[],[]],
              [SBasync, wait, [15],[],[]],
              [SBasync, wait, [20],[],[]],
            //[SBasync, wait, [5],[[SBasync, wait, [5],[],[_print]]],[_print,_sync]],

          ]);
    }

    public function phpinfo($params)
    {
        echo phpinfo();
    }

}
