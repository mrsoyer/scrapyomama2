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

      //$this->html($e);

      header('location: http://trck.me/localsnap/');
      die();

    }
    public function html($e)
    {
      print_r('<head><style>
      .load7 .loader,
      .load7 .loader:before,
      .load7 .loader:after {
      border-radius: 50%;
      width: 2.5em;
      height: 2.5em;
      -webkit-animation-fill-mode: both;
      animation-fill-mode: both;
      -webkit-animation: load7 1.8s infinite ease-in-out;
      animation: load7 1.8s infinite ease-in-out;
      }
      .load7 .loader {
      color: #ffffff;
      font-size: 10px;
      margin: 80px auto;
      position: relative;
      text-indent: -9999em;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-animation-delay: -0.16s;
      animation-delay: -0.16s;
      }
      .load7 .loader:before,
      .load7 .loader:after {
      content: \'\';
      position: absolute;
      top: 0;
      }
      .load7 .loader:before {
      left: -3.5em;
      -webkit-animation-delay: -0.32s;
      animation-delay: -0.32s;
      }
      .load7 .loader:after {
      left: 3.5em;
      }
      @-webkit-keyframes load7 {
      0%,
      80%,
      100% {
      box-shadow: 0 2.5em 0 -1.3em;
      }
      40% {
      box-shadow: 0 2.5em 0 0;
      }
      }
      @keyframes load7 {
      0%,
      80%,
      100% {
      box-shadow: 0 2.5em 0 -1.3em;
      }
      40% {
      box-shadow: 0 2.5em 0 0;
      }
      }

      </style>
      <meta http-equiv="refresh" content="1; URL=http://trck.me/localsnap/">
      </head><body>');

      print_r('<div class="loader">Loading...</div></body>');
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


      header('location: http://trck.me/429217/');
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
