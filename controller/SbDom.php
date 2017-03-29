<?php

class SbDom extends Controller
{
  public function atej($ee)
  {
    $this->loadModel('Domain');
    $this->Domain->atej();
  }
    public function sk($ee)
    {
      $sym = $this->newsym("Api");
      $async = $this->newsym("Async");
      $ovh = $this->newsym("OvhApi");
      $dom = $sym->V1([
        _coll => Domain,
        _q => [account => ['$exists' => false]],
        _sup => '&sk='.$ee[0].'&l=1'
      ]);
      if(count($dom) == 0)die();

      print_r($dom);
      $listmail = $async->sync([['OvhApi','listMail',$dom[0][domain],[],[_sync]]]);
      $listmail = $listmail[0]['request'];
      print_r($listmail);
      //$listmail = $ovh->listMail($dom[0][domain]);


      $i=0;
      foreach($listmail as $k=>$v)
      {
        if($i < 5)
        {
          try {
              print_r($ovh->tcheckAccount($dom[0][domain],$v));
              $upPass = $ovh->updatePassword($dom[0][domain],$v);
              $listmailadd[] = ['account' => $v."@".$dom[0][domain],'nb' => 0];
              $i++;
          } catch (Exception $e) {

          }

        }
      }
      print_r("\n delete : $i \n");


        $error = 0;
        while($i < 5 && $error < 5)
        {
          $name = $this->t();
          try {
            print_r($ovh->createMail($dom[0][domain],$name));
            //$listmailadd[] = $name."@".$dom[0][domain];
            $listmailadd[] = ['account' => $name."@".$dom[0][domain],'nb' => 0];
            $i++;

          }catch (Exception $e) {
              $error++;
          }
        }


      print_r("\n FileCreate : $i \n");

      if($i >= 5 )
      {
        $sym->V1([
          _coll => Domain,
          _p => ['$set' => [account => $listmailadd]],
          _id => $dom[0][_id]['$oid']
        ]);
        print("\n ---domsauv : ".$dom[0][_id]['$oid']." \n");
        $this->sk($ee);
      }
      else{
        print("\n ---doms error : ".$dom[0][_id]['$oid']." \n");
        $ee[0] = $ee[0]+1;
        $this->sk(($ee));
      }


      // on suprime les Mails
      // on cree 5 boite mail
      // on update sur mlab

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
