<?php

class AsyncM extends Controller
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

feature securise data with mongo
    ';
    }

    public function sync($sym)
    {
      //print_r($sym);
      $reponse = $this->shema($sym);
      return($this->reader($reponse));
      //
    }


    private function prepar($controller,$class,$var)
    {
        $code = $this->writeRequest($var);
        $this->execute($controller,$class,$code);
        return($code);

    }

    private function writeRequest($var)
    {
      $sym = $this->newsym('Api');
      $code = $sym->V1([_coll=>tmp,_p=>[query => $var]]);
      return($code[_id]['$oid']);
    }

    private function shema($sym)
    {
      foreach($sym as $k=>$v)
        if(count($v) > 1)
        {
          $reponse[$k]['code']=$this->prepar($v[0],$v[1],$v[2]);
          if(isset($v[3]))$reponse[$k]['query']=$v[3];
        }
        else
          foreach($v as $kc=>$vc)
            foreach($vc as $kcc=>$vcc)
              $reponse[$k][0][$kcc]['code']=$this->prepar($kc,$vcc[0],$vcc[1]);

      return($reponse);
    }

    private function reader($reponse)
    {
      $tcheck = 1;
      while ($tcheck)
      {
        $tcheck = 0;
        foreach($reponse as $k=>$v)
        {
            if(isset($v['code']))
            {
              $tcheck = 1;
              $reponse[$k] = $this->readerVerif($v);
            }
            if(!isset($v['code']) && !isset($v['request']))
            {
              foreach($v as $kc=>$vc)
              {
                   foreach($vc as $kcc=>$vcc)
                   {
                       if(isset($vcc['code']))
                       {
                         $tcheck = 1;
                         $reponse[$k][0][$kcc] = $this->readerVerif($vcc);
                       }
                   }
              }
            }
        }
      }
      return($reponse);
    }

    private function readerVerif($v)
    {
      $s = $this->newsym('Api');
      $verif = $s->V1([_coll=>tmp ,_id=>$v['code']]);
      //print_r($verif);
      if(isset($verif['request']))
      {
        $s->V1([_coll=>tmp,_d => 1 ,_id=>$v['code']]);
        $v['request'] = $verif['request'];
        unset($v['code']);
        print_r($v['request']);
        if(isset($v['query']))
        {
          $v['query'][2]['_request'] = $v['request'];
          $v['query'] = $this->sync([$v['query']]);
        }
      }
      return($v);
    }

    private function execute($controller,$class,$code)
    {
        //execute PREPAR en tache de fond
        $func = 'php '.dirname(dirname(__FILE__)).'/webroot/index.php AsyncM reponse '.$controller.' '.$class.' '.$code;
        exec($func.' > /dev/null &');
    }

    public function reponse($sym)
    {
        $func = 'php '.dirname(dirname(__FILE__)).'/webroot/index.php AsyncM runClass '.$sym[0].' '.$sym[1].' '.$sym[2];
        $json = shell_exec($func);

        $var = json_decode($json,true);
        $s = $this->newsym('Api');
        $s->V1([_coll=>tmp ,_id=>$sym[2],_p=>['$set' => [request => $var]]]);


    }

    public function runClass($sym)
    {
      header('Content-Type: application/json');
      //$controller,$class,$code
      $class = $sym[1];
      $s = $this->newsym('Api');
      $tmp = $s->V1([_coll=>tmp ,_id=>$sym[2]]);
      $request = $tmp['query'];
      $sy= $this->newsym($sym[0]);
      $reponse = $sy->$class($request);
      print_r(json_encode($reponse,JSON_PRETTY_PRINT));

    }

}
