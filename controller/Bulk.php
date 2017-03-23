<?php

class Bulk extends Controller
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

// modif : if domaine et people nexiste pas selectione un domaine que l on update immediatement
//          on selectione une liste e1 de profil on update immediatement les nouveaux
//          on shoot si ok on update le profil on reprograme un envoie
//          si pas ok ou count 0 on update le dom on reprograme le dom

    ';
    }

    public function shoot($e)
    {
      if(!isset($e[0])) $e[0] = 1;
      if(!isset($e[1])) $e[1] = 5;
      if(!isset($e[2])) $e[2] = "";
      $async = $this->newsym('Async');
      $this->loadModel('Domain');
      echo "---Start--- \n";
      flush();
      $dom = $this->Domain->selectDom();
      echo "---RUN--- \n";
      $i = 0;
      $shoot= array();
      foreach($dom as $k=>$v)
      {

        $minutes = (6+(($v['note']*$v['note']*$v['note'])/2));
        $diff =   strtotime("-".$minutes." minutes", $_SERVER['REQUEST_TIME'])-$v['lastsend'];
        if($diff > 0 && $i < $e[0])
        {
          $shoot[]= ['Bulk','shootDom',[$v['_id']['$oid'],$e[1]],[],[$e[2]]];
          $i++;
        }
      }
      if(count($shoot) > 0)
      {
        print_r($shoot);
        $boom = $async->sync($shoot);
      }
    }

    public function shootDom($e)
    {
      $time = $_SERVER['REQUEST_TIME'];
      $this->loadModel('Domain');

      $Domain = $this->Domain->domDetailUpdate($e[0]);
      $allPeoples = $this->people($Domain,$e[1]);
      $peoples = $allPeoples['peoples'];
      $status = $allPeoples['status'];
      unset($allPeoples);
      unset($Domain['people']);
      $shoot = "ok";
      $i = 0;

      while($shoot = "ok" && $i < $e[1])
      {
          //select people
          $shoot = $this->sendPeople($v,$Domain);
          sleep(1);
          $i++;
          //on update people
      }

      if($shoot != "ok" && $i == 1)
      {
        $set['$set']['note'] = $Domain['note']+1;
        $this->Domain->updateEndDomain($Domain['_id']['$oid'],$set);

      }

    }

    private function people($Domain,$nb)
    {
      $this->loadModel('People');
      $peoples = array();
      $status = 'set';
      if(isset($Domain['people']))
      {
        $peoples_nb = $this->selectPeople($Domain['people'],$nb);
        $peoples = $peoples_nb['peoples'];
        $nb = $peoples_nb['nb'];
        unset($peoples_nb);
        $status = 'addToSet';
      }

      if($nb != 0)
      {
        $result = $this->People->findPeople($nb,$Domain);
        foreach($result as $k=>$v)
        {
          $nextSend = $this->nextSend($v['note']);
          $preparPeople = $v;
          $preparPeople['status'] = 'new';
          $preparPeople['nextSend'] = $nextSend;
          $peoples[] = $preparPeople;
          unset($preparPeople);
          unset($nextSend);
        }
      }
      $return['status'] = $status;
      $return['peoples'] = $peoples;
      return($return);
    }

    public function selectPeople($PeopleList,$nb)
    {
      $this->loadModel('People');
      $nextSend = $_SERVER['REQUEST_TIME'];
      $peoples = array();
      foreach($PeopleList as $k0 => $v0)
      {
        if($v0['nextSend'] < $nextSend && $nb != 0)
        {
          unset($v0['nextSend']);
          $preparPeople = $this->People->peopleDetail($v0['id']);
          $preparPeople['k'] = $k0;
          $preparPeople['nextSend'] = $this->nextSend($preparPeople['note']);
          $preparPeople['status'] = 'up';
          $peoples[] = $preparPeople;
          unset($preparPeople);
          $nb--;
        }

      }
      $return['peoples'] = $peoples;
      $return['nb'] = $nb;
      return($return);
    }

    private function sendPeople($people,$Domain)
    {
      $this->loadModel('People');
      //$this->loadModel('Logs');

      $shoot = $this->sendMail($Domain,$people);
      if($shoot == "ok")
        $this->updatePeople($people);

      $return = $this->preparReturn($Domain,$people,$shoot);
    //  print_r($return);
      $return['insert'] = $_SERVER['REQUEST_TIME'];
    //  $this->Logs->insert($return);
      print_r($return);
        return($shoot);

    }

    private function sendMail($Domain,$people)
    {
      $this->loadModel('Campaign');
      $camp = $this->Campaign->selectcamp();

      $Prepar = [
        'domid' =>$Domain['_id']['$oid'],
        'peopleid' =>$people['_id']['$oid'],
        'smtpUser' => $Domain['account'][rand(0,4)],
        'fromAddress' => $camp['email'],
        'toName' => $people['firstname'],
        'toAdress' => $people['email'],
        'proxy' => $Domain['proxy'],
        'fromName' => $camp['name'],
        'subject' => $camp['sujet'],
        'textMessage' => $camp['message'],
      ];
      $Prepar['htmlMessage'] = $this->preparHTML($Prepar,$camp);
      $Mails = $this->newsym('Mails');
      try {
          $shoot = $Mails->smtpOvhBulk($Prepar);
      } catch (Exception $e) {
          $shoot = "error";
      }

      return($shoot);
    }

    public function preparHTML($Prepar,$camp)
    {
      $mailHtml = $camp['kit'];

      $dest = $camp['link'];
      $arg = "".$camp['campName']."/".$Prepar['domid'].'/'.$Prepar['peopleid'].'/';
      $link = $dest."/Trck/link/".$arg;
      $mailHtml = str_replace("{{link}}", $link,$mailHtml);
      $mailHtml .="<img src=".$dest.'/Trck/img/'.$arg." width='1px' height='1px'>";
      return($mailHtml);
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

    private function updatePeople($people)
    {
      $this->loadModel('People');
      $note = $this->calculNote($people);
      $this->People->updatePeople($people['_id']['$oid'],$note);
    }

    private function calculNote($people)
    {
      if(!isset($people['BackNote']))
      {
        $note['BackNote'] = $people['note']-1;
        $note['note'] = $people['note'];
      }
      else{
        if($people['BackNote'] == 0)
        {
          $note['BackNote'] = $people['note']-1;
          $note['note'] = $people['note']-1;
        }
        else {
          $note['BackNote'] = $people['BackNote']-1;
          $note['note'] = $people['note'];
        }
      }
        return($note);
    }

    private function nextSend($note)
    {
        $day = 6-$note;
        return(strtotime("+".$day." day", $_SERVER['REQUEST_TIME']));
    }


    private function preparReturn($Domain,$people,$shoot)
    {
      $return['idDomain']=$Domain['_id']['$oid'];
      $return['idPeople']=$people['_id']['$oid'];
      $return['to']=$people['email'];
      $return['dom']=$Domain['domain'];
      $return['shoot']=$shoot;
      return($return);
    }

    private function deleteDomToPeople($idPeople)
    {
      $this->loadModel('People');
      $this->People->deleteDomToPeople($idPeople);
    }
    private function deletePeople($idPeople)
    {
      $this->loadModel('People');
      $this->People->deletePeople($idPeople);
    }

}
