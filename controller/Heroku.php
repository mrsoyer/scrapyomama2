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

    public function fork($e)
    {
        shell_exec("heroku apps:fork ".$e[0]." --from symsym ");
    }

    public function delete($e)
    {

    $app = shell_exec("heroku apps");
    $app = explode("\n",$app);
    print_r($app);
    foreach($app as $k=>$v)
    {

      if($v != "symsym")
      {
        echo shell_exec('heroku apps:destroy --app '.$v.' --confirm '.$v);
      }
    }

    }

    public function update($e)
    {

      $app = shell_exec("heroku apps");
      $app = explode("\n",$app);
      print_r($app);
      foreach($app as $k=>$v)
      {

        if($v != "symsym")
        {
          echo shell_exec('curl -X POST -H "Accept: application/vnd.heroku+json; version=3" -n \
-H "Content-Type: application/json" \
-d \'{"slug": "f9de9574-01be-4339-ac29-0dfb34bb2caa"}\' \
https://api.heroku.com/apps/'.$v.'/releases');
        }
      }

    }
}
