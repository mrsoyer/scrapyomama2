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

// modif : lorsque lon a shoute on modifie la note sur people et on update nextSend le people sur dom
//         on ne recherche plus par dom mais par nextSend
// on va modifier class track
// pour add people on rajoute une regle pour ne pas ajouter le meme
    ';
    }

    public function shootM($params)
    {
      if(!isset($params[1])) $params[1] = "";
      $async = $this->newsym('Async');
      $this->loadModel('Domain');
      echo "---Start--- \n";
      flush();
      $dom = $this->Domain->selectDom();
      echo "---RUN--- \n";
      $i = 0;
      foreach($dom as $k=>$v)
      {
        $minutes = (5+(($v['note']*$v['note']*$v['note'])/2));
        $diff =   strtotime("-".$minutes." minutes", time())-$v['lastsend'];
        if($diff > 0 && $i < $params[0])
        {
          $shoot[]= [Shoot,shootDom,[$v[_id]['$oid']],[],[$params[1]]];
          $i++;
        }
      }
      $boom = $async->sync($shoot);
    }

    public function shootDom($idDom)
    {
      $time = time();
      $this->loadModel('Domain');

      $Domain = $this->Domain->domDetail($idDom[0]);
      $people = $this->people($Domain);
      $shoot = $this->sendMail($Domain,$people);
      if($shoot == "ok")
        $note = $this->updatePeople($people,$Domain);

      if(!isset($note))
        $note[note] = $people['note'];

      $nextSend = $this->nextSend($note[note]);
      $this->updateDomain($nextSend,$people,$Domain);
      $return = $this->preparReturn($Domain,$people,$shoot);
      print_r($return);
      if($shoot == "ok")
      {
        sleep(30-(time()-$time));
        $this->shootDom($idDom);
      }
    }

    private function people($Domain)
    {
      $this->loadModel('People');
      $people = array();
      if(isset($Domain[people]))
      {
        $people = $this->selectPeople($Domain[people]);
        $status = 'update';
      }

      if(count($people) == 0)
      {
        $people = $this->People->findPeople();
        if(isset($Domain[people]))
          $status = 'add';
        else
          $status = 'new';
      }
      if(count($people) != 0)
        $people['status'] = $status;

      return($people);
    }

    public function selectPeople($PeopleList)
    {
      $this->loadModel('People');
      $nextSend = time();
      foreach($PeopleList as $k0 => $v0)
      {
          if($v0[nextSend] > $nextSend)
          {
            $nextSend = $v0[nextSend];
            $people = $v0;
          }

      }
      $people['id'] = '58bad34fc2ef162f4b4b4d24';
      if(isset($people))
        $people = $this->People->peopleDetail($people['id']);
      else
        $people = array();

      return($people);
    }

    private function sendMail($Domain,$people)
    {
      $Prepar = [
        domid =>$Domain[_id]['$oid'],
        peopleid =>$people[_id],
        fromAddress => $Domain[account][rand(0,count($Domain[account])-1)][mail],
        toName => $people[firstname],
        toAdress => $people[email],
        proxy => $Domain[proxy]
      ];
      //print_r($Prepar);
      $shoot = $this->smtpOvhInner($Prepar);
      return($shoot);
    }

    public function smtpOvhInner($eo)
    {
      $url = 'http://ns3022893.ip-149-202-196.eu/Mails/smtpOvh/';
      $fields = json_encode($eo);
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, "json=".$fields);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $results = curl_exec($ch);
      curl_close($ch);
      return($results);
    }

    private function updatePeople($people,$Domain)
    {
      $this->loadModel('People');

      $note = $this->calculNote($people);

      $DomExport[id] = $Domain[_id]['$oid'];
      $DomExport[domain] = $Domain[domain];

      $this->People->updatePeople($people,$note,$DomExport);

      return($note);
    }

    private function calculNote($people)
    {
      if(!isset($people['BackNote']))
      {
        $note[backnote] = $people['note']-1;
        $note[note] = $people['note'];
      }
      else{
        if($people['BackNote'] == 0)
        {
          $note[backnote] = $people['note']-1;
          $note[note] = $people['note']-1;
        }
        else {
          $note[backnote] = $people['BackNote']-1;
          $note[note] = $people['note'];
        }
      }
        return($note);
    }

    private function nextSend($note)
    {
        $day = 6-$note;
        return(strtotime("+".$day." day", time()));
    }


    private function preparReturn($Domain,$people,$shoot)
    {
      $return[idDomain]=$Domain[_id]['$oid'];
      $return[idPeople]=$people[_id]['$oid'];
      $return[to]=$people[email];
      $return[dom]=$Domain[domain];
      $return[shoot]=$shoot;
      return($return);
    }

    private function updateDomain($nextSend,$people,$Domain,$shoot)
    {
      $this->loadModel('Domain');

      $peopleExport[id] = $people[_id]['$oid'];
      $peopleExport[email] = $people[email];
      $peopleExport[nextSend] = $nextSend;

      $query = array();
      if($shoot == "ok")
        $set['$set'][note] = 0;
      else
        $set['$set'][note] = $Domain[note]+1;

      $set['$set'][lastsend] = time();

      if($people['status'] == 'new')
        $set['$set'][people] = [$peopleExport];
      else if($people['status'] == 'add')
        $set['$addToSet'][people] = $peopleExport;
      else {
        $query['people.id'] = $people[_id]['$oid'];
        $set['$set']['people.$.nextSend'] = $nextSend;
      }

      $this->Domain->updateDomain($Domain['_id']['$oid'],$set,$query);
    }

}
