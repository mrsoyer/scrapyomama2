<?php

class Shoot extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
      echo '
///////////////////////////////////////////////////////////////////////////////|
//                                           __________  __   __   __    __   ||
//  Shoot.php                              / _________/ | |  / /  /  |  /  |  ||
//                                        / /_______    | | / /  /   | /   |  ||
//                                        \______   \   | |/ /  / /| |/ /| |  ||
//  Created: 2017/02/29 12:30:05         ________/  /   |   /  / / |   / | |  ||
//  Updated: 2017/02/29 21:45:22        /__________/    /  /  /_/  |__/  |_|  ||
//                                      ScrapYoMama    /__/    by barney.im   ||
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*

// different si people n existe pas    $addToSet si existe     $Set existe pas
    ';
    }

    public function shootM($params)
    {

      $async = $this->newsym('Async');
      echo "1";
      $s = urlencode('{"lastsend": -1}');
      $f= urlencode('{"_id": 1, "note": 1, "lastsend": 1}');


      echo "---Start---";
      flush();
      ob_flush();
      $dom = $async->sync(
      [
        [Api, V1,
          [
            _coll => 'Domain',
          //  _q => [account => ['$exists' => true],people => ['$exists' => false]],
            _q => [account => ['$exists' => true]],
            //_id => '58bb1761bd966f3300e02142',
            _sup => '&f='.$f

          ],[],[]

        ]

      ]);
      echo "---RUN---";
      $dom  = $dom[0][request];
      //print_r($dom);
      $i = 0;
      foreach($dom as $k=>$v)
      {
        $minutes = (0+(($v['note']*$v['note']*$v['note'])/2));
        //$minutes = 1;
        $diff =   strtotime("-".$minutes." minutes", time())-$v['lastsend'];
        if($diff > 0 && $i < $params[1])
        {
          $idDom = array_column($v, '_id');
          $shoot[]= [Shoot,preparDom,[$v],[],[_print,$params[0]]];
          $i++;
        }
      }

      //print_r($shoot);
      //$shoot[]= [Shoot,preparDom,[$dom],[]];
      $boom = $async->sync($shoot);
      print_r($boom);
    }

    public function preparDom($Domain)
    {
      $start = time();
      $async = $this->newsym('Async');
      if(isset($Domain[_request]))
        $Domain=$Domain[_request];
      else
        $Domain=$Domain[0];



        $dom = $async->sync(
        [
          [Api, V1,
            [
              _coll => 'Domain',

              _id => $Domain[_id]['$oid'],


            ],[],[]

          ]

        ]);

        //print_r($dom);
        $Domain  = $dom[0][request];



      $DomExport[_id] = $Domain[_id];
      $DomExport[domain] = $Domain[domain];
      if(isset($Domain[people]))
      {
          $people = $this->selectPeople($Domain[people]);
          //$people=[];
          if(count($people) == 0)
            $people = $this->addPeople($DomExport,'exist');
      }
      else
        $people = $this->addPeople($DomExport,'create');


      $people[v]['dom'][_id] = $DomExport[_id];

      //print_r($message);

      //$people[v][email] = "mrsoyer@me.com";
      $Mails = $this->newsym('Mails');
      $Prepar = [
        domid =>$DomExport[_id]['$oid'],
        peopleid =>$people[v][_id]['$oid'],
        fromAddress => $Domain[account][rand(0,count($Domain[account])-1)][mail],
        toName => $people[v][firstname],
        toAdress => $people[v][email],
        proxy => $Domain[proxy]
      ];
      //print_r($Prepar);
      $shoot = $this->smtpOvhInner($Prepar);
      //print_r($shoot);
      $returnShoot['prepar'] = $Prepar;
      $returnShoot['shoot'] = $shoot;
      if($shoot == "ok")
      {
        if(!isset($people[v]['BackNote']))
        {
          $backnote = $people[v]['note']-1;
          $note = $people[v]['note'];
        }
        else{
          if($people[v]['BackNote'] == 0)
          {
            $backnote = $people[v]['note']-1;
            $note = $people[v]['note']-1;
          }
          else {
            $backnote = $people[v]['BackNote']-1;
            $note = $people[v]['note'];
          }
        }
        //$f= urlencode('{"_id": 1, "note": 1, "lastsend": 1}');
        $upDomOk[0]= [Api,V1,[
          _coll => 'Domain',
          _id => $Domain[_id]['$oid'],
          _p => [
            '$set'=> [
              note=> 0,
              lastsend=> time(),
              'people.'.$people[k].'.note'=> $note,
              'people.'.$people[k].'.BackNote'=> $backnote,
              'people.'.$people[k].'.lastsend'=> time()
            ]
          ]
        ],[],[]];
        $upDomOk[1]= [Api,V1,[
          _coll => 'People',
          _id => $people[v][_id]['$oid'],
          _p => [
            '$set'=> [
              note=> $note,
              BackNote=> $backnote,
              lastsend=> time()
            ],
            '$inc' => [count => 1]

          ]
        ],[],[]];
        $thetime = time()-$start;
      //  if($thetime < 60)
          //sleep(60-$thetime);


        //[Shoot,preparDom,[$v],[],[_print,_async]]

      }else {
        $upDomOk[]= [Api,V1,[
          _coll => 'Domain',
          _id => $Domain[_id]['$oid'],
          _p => [
            '$set'=> [
              note=> $Domain[note]+1,
              lastsend=> time(),
              'people.'.$people[k].'.lastsend'=> time()
            ]
          ]
        ],[],[]];
        $upDomOk[1]= [Api,V1,[
          _coll => 'People',
          _id => $people[v][_id]['$oid'],
          _p => [
            '$set'=> [
              lastsend=> time()
            ]
          ]
        ],[],[]];

      }
      $result = $async->sync($upDomOk);
      $return['_shoot'] = $returnShoot;
      if($shoot == "ok")
      {
        //$return['_query'] = [Shoot,preparDom,[],[],[_print,_async]];
      }
      $return[_id] = $result[0][request][_id];
      $return[note] = $result[0][request][note];
      $return[lastsend] = $result[0][request][lastsend];
      return($return);


      //on up le domaine avec erreur à +1, on modifie la date d'envoie
    }

    public function smtpOvhInner($eo)
    {

      $url = 'http://ns3022893.ip-149-202-196.eu/Mails/smtpOvh/';
      $fields = json_encode($eo);


      $ch = curl_init();

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, "json=".$fields);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute post
      $results = curl_exec($ch);
      //print_r($results);
      //close connection
      curl_close($ch);

      return($results);
    }
    public function selectPeople($PeopleList)
    {
      $lastdiff = 0;
      foreach($PeopleList as $k0 => $v0)
      {

          if(!isset($v0['lastsend'])) {
            $people['v'] = $v0;
            $people['k'] = $k0;
          }
          else
          {
            $temps = 6-$v0['note'];
            $diff =   time()-strtotime("+".intval($temps)." day", $v0['lastsend']);
            if($diff > 0 && $diff > $lastdiff)
            {
              $lastdiff = $diff;
              $people['v'] = $v0;
              $people['k'] = $k0;
            }
          }
      }


      return($people);
    }
    public function addPeople($Domain,$status)
    {
      $people[v] = $this->findPeople();
      $people[v] = $people[v][0];
      if(isset($people))
      {
        $peopleExport[_id] = $people[v][_id];
        $peopleExport[email] = $people[v][email];
        $peopleExport[note] = $people[v][note];
        $this->addDomToPeople($Domain,$people[v][_id]['$oid']);
        $people[k] = $this->addPeopleToDom($peopleExport,$Domain[_id]['$oid'],$status);
      }

      return($people);
    }

    public function findPeople()
    {
      $api = $this->newsym('Api');
      $people = $api->V1([
        _coll => 'People',
        _q => [domain => ['$exists' => false], 'note' => ['$gt' => 0]],
        _sup => '&l=1'
      ]);
      return($people);
    }

    public function addDomToPeople($Domain,$idPeople)
    {
      $api = $this->newsym('Api');
      $e= $api->V1([
        _coll => 'People',
        _id => $idPeople,
        _p => [
          '$set'=> [
            domain=> [$Domain]
            ]
          ]
      ]);
    }

    public function addPeopleToDom($People,$idDomain,$status)
    {
      if($status == 'create')
      {
        $p = [
          '$set'=> [
            people => [$People]
            ]
          ];
      } else {
        $p = [
          '$addToSet'=> [
            people => $People
            ]
          ];
      }
      $api = $this->newsym('Api');
      $e = $api->V1([
        _coll => 'Domain',
        _id => $idDomain,
        _p => $p
      ]);
      return(count($e[people])-1);
    }
}


/*




$api->V1([
  _coll => 'People',
  _id => $people[0][_id]['$oid'],
  _p => [
    '$set'=> [
      domain => [
        [
          _id => [
            '$oid' => $e
            ]
          ]
        ]
      ]
    ]
]);

$api->V1([
  _coll => 'Domain',
  _id => $e,
  _p => [
    '$set'=> [
      people => [
        [
          _id => [
            '$oid' => $people[0][_id]['$oid']
            ]
          ]
        ]
      ]
    ]
]);


*/
