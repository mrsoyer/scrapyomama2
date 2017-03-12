<?php
//include ROOT.'/controller/Api.php';


class Y extends Controller
{


  public function index($e)
  {
    $sym =  $this->newsym('Api');

    $symheader = str_split('
///////////////////////////////////////////////////////////////////////////////|
//       __________  __   __   __    __                                       ||
//     / _________/ | |  / /  /  |  /  |
//    / /_______    | | / /  /   | /   |
//    \______   \   | |/ /  / /| |/ /| |
//   ________/  /   |   /  / / |   / | |
/   /__________/    /  /  /_/  |__/  |_|
//  ScrapYoMama    /__/    by barney.im
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*
');
  $symman = "
  // API/V1 -> mongodb
  // mail/smtp([to, from, smtp, user, pass, proxy, useragent, sujet, message, file]);
  // mail/smtpOVH(to, from, sujet, message, file)
  // mail/cleaner(to,from)
  // mail/kitmail([nom, sujet, lienmessage])
  // bot/
  // ovh/
  // crm/
  // aff/
  //  fb/
  //  insta/
  //  graph
  //domaine1 ouvreur(20%) ||||||||||||||||||||||||||||||||||||||||||||||||||
  //";
  foreach ($symheader as $key => $value) {
    print_r($value);
    usleep(1000);# code...
  }

  print_r($symman);
  $async = $this->newsym('Async');
  $reponse = $async->sync(json_decode(file_get_contents(dirname(dirname(__FILE__))."/json/sym.json"),true));



  }

  public function m($sym){
    $async = $this->newsym('Async');
    $dir = dirname(dirname(__FILE__));

    if($sym[2] == "code")
    {
      header('Content-Type: application/json');
      $jsonFile = json_encode(json_decode(file_get_contents($dir ."/json/".$sym[0]."/".$sym[1].".json"),true),JSON_PRETTY_PRINT);
      print_r($jsonFile);
    }
    else if($sym[2] == "print")
    {
      $jsonFile = file_get_contents($dir ."/json/".$sym[0]."/".$sym[1].".json");

          print_r(json_encode(json_decode($jsonFile,true),JSON_PRETTY_PRINT));
    }

    else if($sym[2] == "query")
    {
      
    $jsonFile = file_get_contents($dir ."/json/".$sym[0]."/".$sym[1].".json");
    print_r("\n".json_encode($async->sync(json_decode($jsonFile,true)),JSON_PRETTY_PRINT));
    }
    else if(!isset($sym[1]))
    {
        $jsonIndex = file_get_contents($dir ."/json/".$sym[0]."/sym.json");
        $reponse = $async->sync(json_decode($jsonIndex,JSON_PRETTY_PRINT));
    }
    else
    {
      $jsonFile = file_get_contents($dir ."/json/".$sym[0]."/".$sym[1].".json");
      $reponse = $async->sync(json_decode($jsonFile,JSON_PRETTY_PRINT));
    }

  }

}
