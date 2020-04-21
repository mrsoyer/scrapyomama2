<?php

class Async extends Controller
{


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
[
  [SBasync, sayHello, $e],
  [Api, V1, [People]],
  [Api, V1, [Domain]],
  [SBasync =>
    [
      [test1,$sym],
      [test2,[coucou]
    ]
  ]
  ],
]

feature
  execution de plusieur function de la meme class en syncrone
    [function,[[class,valeur],[class,valeur]]]

    ';
    }

    public function sync($sym)
    {
      //print_r($sym);
      $reponse = $this->shema($sym);
      //print_r($reponse);
      return($this->reader($reponse));
        //coucou
      //
    }

    private function shema($sym)
    {
      $reponse = "";
      foreach($sym as $k=>$v)
        if(count($v) > 1)
        {
          if(isset($v[4]))
          {
            $option = array();
            foreach($v[4] as $k1=>$v1)
            {
              if($v1 == '_sync')$option['_sync'] = true;
              if($v1 == '_print')$option['_print'] = true;
              if($v1 == '_back')$option['_back'] = true;
              if($v1 == '_async')$option['_async'] = true;
            }
          }
          if(isset($option['_sync']))
          {
            $reponse[$k]['code']=$this->prepar($v[0],$v[1],$v[2],'_sync');
            if(isset($option['_print']))$reponse[$k]['_print'] = true;
            if(isset($v[3]))$reponse[$k]['query']=$v[3];
          }
          else if(isset($option['_back']))
          {
            $this->prepar($v[0],$v[1],$v[2],'_back');
            print_r($reponse);
            $reponse[$k]['back']=true;
          }
          else if(isset($option['_async'])){
            $reponse[$k]['code']=$this->prepar($v[0],$v[1],$v[2],'_async');
            if(isset($option['_print']))$reponse[$k]['_print'] = true;
            if(isset($v[3]))$reponse[$k]['query']=$v[3];

          }else{
            $reponse[$k]['request'] = $this->runClassSync($v[0],$v[1],$v[2]);
            if(isset($option['_print'])) print_r($reponse[$k]['request']);
            if(isset($v[3]) || $reponse[$k]['_request'][0]['_query'])                     /////////////////////////
            {
              $q1 = array(); $q2 = array();

              if(isset($reponse[$k]['request']['_query']))$q1[] = $reponse[$k]['request']['_query'];//  a veririfier ////////
              if(isset($v[3]))$q2[] = $v[3];
             $qu = array_merge($q1,$q2);
             //print_r($q1);
             foreach($qu as $kt=>$vt)
             {
               $qu[$kt][2]['_request'] = $reponse[$k]['request'];
             }

              $reponse[$k]['query'] = $this->sync($qu);
            }
          }


        }
        //else
        //  foreach($v as $kc=>$vc)
        //    foreach($vc as $kcc=>$vcc)
        //      $reponse[$k][0][$kcc]['code']=$this->prepar($kc,$vcc[0],$vcc[1]);

      return($reponse);
    }

    private function prepar($controller,$class,$var,$back)
    {

        $code = $this->code(30);
        $this->writeRequest($var,$code);
        $this->execute($controller,$class,$code,$back);
        return($code);




    }

    private function code($nb)
    {
      $alphanum = str_split("azertyuiopqsdfghjklmwxcvbn1234567890");
      $code= "";
      while($nb)
      {
        shuffle($alphanum);
        $code .= $alphanum[0];
        $nb--;
      }
      return($code);
    }

    private function writeRequest($var,$code)
    {
      $json = json_encode($var,JSON_PRETTY_PRINT);
      $fp = fopen(dirname(dirname(__FILE__)).'/tmp/q-'.$code.'.txt', 'w');
      fwrite($fp, $json);
      fclose($fp);
    }

    private function execute($controller,$class,$code,$back)
    {


        $func = 'php '.dirname(dirname(__FILE__)).'/webroot/index.php Async reponse '.$controller.' '.$class.' '.$code;
        if($back=="_sync")$func .= " ";
        if($back=="_async")$func .= " > /dev/null &";
        if($back=="_back")$func .= " back > /dev/null &";
        exec($func);
    }

    public function reponse($sym)
    {
      //$controller,$class,$code
        //execute tache + retour reponse
        $func = 'php '.dirname(dirname(__FILE__)).'/webroot/index.php Async runClass '.$sym[0].' '.$sym[1].' '.$sym[2];
        $write = dirname(dirname(__FILE__)).'/tmp/r-'.$sym[2].'.txt';
        //exec('var=$('.$func.') && echo $var > '.$write);
        $json = shell_exec($func);
        if(!isset($sym[3]))
        {
          $fp = fopen($write."2", 'w');
          fwrite($fp, $json);
          fclose($fp);
          rename($write."2", $write);
        }
    }

    public function runClass($sym)
    {
      header('Content-Type: application/json');
      //$controller,$class,$code
      $class = $sym[1];
      $request = file_get_contents(dirname(dirname(__FILE__)).'/tmp/q-'.$sym[2].'.txt');
      unlink(dirname(dirname(__FILE__)).'/tmp/q-'.$sym[2].'.txt');
      $request = json_decode($request,true);
      $sym= $this->newsym($sym[0]);
      $reponse = $sym->$class($request);
      print_r(json_encode($reponse,JSON_PRETTY_PRINT));

    }
    private function runClassSync($controller,$class,$var)
    {

      $sym= $this->newsym($controller);
      $reponse = $sym->$class($var);
      return($reponse);

    }

    private function reader($reponse)
    {
      $tcheck = 1;
      while ($tcheck)
      {
        $tcheck = 0;
        if(isset($reponse))
        {
          foreach($reponse as $k=>$v)
          {
              if(isset($v['code']))
              {
                $tcheck = 1;
                $reponse[$k] = $this->readerVerif($v);
              }
          }
        }
      }
      ///
      return($reponse);
    }

    private function readerVerif($v)
    {
      if(file_exists(dirname(dirname(__FILE__)).'/tmp/r-'.$v['code'].'.txt'))
      {
      //  sleep(1);
        //print_r($v);
        $p = file_get_contents(dirname(dirname(__FILE__)).'/tmp/r-'.$v['code'].'.txt');
        unlink(dirname(dirname(__FILE__)).'/tmp/r-'.$v['code'].'.txt');
        $v['request'] = json_decode($p,true);
        unset($v['code']);
        if(isset($v['_print']))
        {
          print_r($v['request']);
          unset($v['_print']);
          flush();
          //ob_flush();
        }
        if(isset($v['query']) || $v['request']['_query'])                     /////////////////////////
        {

          $q1 = array(); $q2 = array();
          if(isset($v['request']['_query']))$q1[] = $v['request']['_query'];//  a veririfier ////////
          if(isset($v['query']))$q2[] = $v['query'];
         $qu = array_merge($q1,$q2);
         foreach($qu as $kt=>$vt)
         {
           $qu[$kt][2]['_request'] = $v['request'];
         }
          $v['query'] = $this->sync($qu);////
        }                                                                       //////////////////////////
      }
      return($v);
    }

    /*



    if(isset($v[3]) || $reponse[$k]['_request'][0]['_query'])                     /////////////////////////
    {
      $q1 = array(); $q2 = array();

      if(isset($reponse[$k]['request']['_query']))$q1[] = $reponse[$k]['request']['_query'];//  a veririfier ////////
      if(isset($v[3]))$q2[] = $v[3];
     $qu = array_merge($q1,$q2);
     //print_r($q1);
     foreach($qu as $kt=>$vt)
     {
       $qu[$kt][2]['_request'] = $reponse[$k]['request'];
     }

      $reponse[$k][query] = $this->sync($qu);
    }
    */



}
