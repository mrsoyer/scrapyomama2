<?php

class Run extends Controller
{
    public $name = 'cards';

    public function index()
    {
      echo "bim";
      $async = $this->newsym('Async');
      $shoot[]= ['Run','r',[""],[],['_back']];
      $boom = $async->sync($shoot);
      echo "bim";
    }
    public function r($e)
    {
      if(time() < 1492574400)die();
      $apps = json_decode(shell_exec('curl -n -X GET https://api.heroku.com/apps \
    -H "Content-Type: application/json" \
    -H "Accept: application/vnd.heroku+json; version=3" \
    -H "Authorization: Bearer 79e5e2c6-dfff-4dc7-adb0-544791fd28a5"'),true);

    foreach($apps as $k=>$v)
    {
      $findme   = 'sym';
      $pos = strpos($v['name'], $findme);
      if ($pos === false) {
      } else {
        echo shell_exec('curl -n -X DELETE https://api.heroku.com/apps/'.$v['name'].'/dynos \
      -H "Content-Type: application/json" \
      -H "Accept: application/vnd.heroku+json; version=3" \
      -H "Authorization: Bearer 79e5e2c6-dfff-4dc7-adb0-544791fd28a5"');
      sleep(3);
      echo shell_exec('curl  http://'.$v['name'].'.herokuapp.com/rotator/runs/_back ');
      }
    }

    }


}
