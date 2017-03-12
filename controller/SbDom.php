<?php

class SbDom extends Controller
{

    public function sk($e)
    {
      $sym = $this->newsym("Api");
      $ovh = $this->newsym("OvhApi");
      $dom = $sym->V1([
        _coll => Domain,
        _q => [account => ['$exists' => false]],
        _sup => '&sk='.$e[0].'&l=1'
      ]);
      if(count($dom) == 0)die();
      // on liste les mail du domaine
      //$dom[0] = $dom[1];
      print_r($dom);
      $listmail = $ovh->listMail($dom[0][domain]);
      print('ok');
      foreach($listmail as $k=>$v)
      {
        if($k < 10)
        {
          $ovh->deleteMail($dom[0][domain],$v);
          sleep(1);
        }
      }
      $listmail = $ovh->listMail($dom[0][domain]);

      $i = 0;
      while($i < 5)
      {
        $ovh->createMail($dom[0][domain],$this->t());
        sleep(1);
        $i++;
      }

      $listmail = $ovh->listMail($dom[0][domain]);
      foreach($listmail as $k=>$v)
      {
        $account[]=[mail => $v.'@'.$dom[0][domain]];
      }
      $sym->V1([
        _coll => Domain,
        _p => ['$set' => [account => $account]],
        _id => $dom[0][_id]['$oid']
      ]);
      // on suprime les Mails
      // on cree 5 boite mail
      // on update sur mlab
      $this->sk($e);
    }

    public function addPeople()
    {
      // select 1 dom account true People false
      $sym = $this->newsym("Api");
      $ovh = $this->newsym("OvhApi");
      $set = urlencode('{"_id": 1, "domain": 1}');
      $dom = $sym->V1([
        _coll => Domain,
        _q => [account => ['$exists' => true], people => ['$exists' => false]],
        _sup => '&l=1&f='.$set
      ]);
      // select 5000 People
      $set = urlencode('{"_id": 1, "email": 1, "note": 1}');
      $people = $sym->V1([
        _coll => People,
        _q => [domain => ['$exists' => false]],
        _sup => '&l=5000&f='.$set
      ]);

      $sym->V1([
        _coll => Domain,
        _p => ['$set' => [people => $people]],
        _id => $dom[0][_id]['$oid']
      ]);

      foreach($people as $k=>$v)
      {
        $sym->V1([
          _coll => People,
          _p => ['$set' => [domain => $dom]],
          _id => $v[_id]['$oid']
        ]);
      }


      // add dom in people
      // add people in dom
    }

    public function sayHello($params)
    {
        echo ("Les paramertres sont : ". $params[0]. " et ".$params[1]);
    }

    public function t()
    {
      $l = str_split("1234567890azertyuiopqsdfghjklmwxcvbn");
      shuffle($l);
      return $l[0].$l[1].$l[2].$l[3].$l[4]."-MailBox-".$l[5].$l[6].$l[7].$l[8].$l[9];
    }
}
