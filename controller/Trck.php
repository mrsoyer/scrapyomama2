<?php

class Trck extends Controller
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


    public function link($e)
    {
      $this->loadModel('People');
      try {
        $people = $this->People->peopleDetail($e[0]);
        if($people['BackNote']<5)
          $this->People->updatePeopleNote($e[0],5);
      } catch (Exception $e) {

      }



      header('location: http://ads.adextrem.com/delivery/directlink.php?slot=403');
      die();

    }

    public function img($e)
    {
      $this->loadModel('People');
      try {
        $people = $this->People->peopleDetail($e[0]);
          if(($people['BackNote']<4 && $people['note']<=4) || $people['note']<4 )
            $this->People->updatePeopleNote($e[0],4);
      } catch (Exception $e) {

      }


      header('location: http://click.sitemail.vivastreet.com:80/q/fdHY2z_A6TNisgiYvK0SvA~~/AAAAAQA~/RgRay9pNPkEIAKxuqhKsOcVXCnZpdmFzdHJlZXRYBAAAAABIEkZSX2Fub255bW91c19lbWFpbEIKAAJNVelY8DO8bFIXZ2FyLmNpYXRob21hc0BnbWFpbC5jb20JUQQAAAAARxh7ImJpbmRpbmciOiJ2aXZhc3RyZWV0In0T');
      die();
    }

    public function imgSrc($e)
    {
        $remoteImage = base64_decode(str_pad(strtr($e[0], '-_', '+/'), strlen($e[0]) % 4, '=', STR_PAD_RIGHT));
        $imginfo = getimagesize($remoteImage);
        header("Content-type: {$imginfo['mime']}");
        readfile($remoteImage);
    }

    public function kit($e)
    {
        echo file_get_contents(dirname(dirname(__FILE__)).'/kit.html');
    }

    public function info($e)
    {
      print_r(json_decode(file_get_contents(dirname(dirname(__FILE__)).'/info.json'),'true'));
    }

    public function infoDB($e)
    {
      //infodb
    }

    public function unsuscribe($e)
    {
      // replace
      echo file_get_contents(dirname(dirname(__FILE__)).'template/unsuscribe.html');
    }

    public function unsuscribeOk($e)
    {
      //sauvdb
      echo file_get_contents(dirname(dirname(__FILE__)).'template/unsuscribeOk.html');
    }

    private function sym($e)
    {
      $url = 'https://scrapyomama.herokuapp.com/'.$e[0].'/'.$e[1];
      foreach($e[2] as $k=>$v)
      {
        $url .= '/'.$v;
      }
      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);


      $res = curl_exec($curl);
      curl_close($curl);

    }


}
