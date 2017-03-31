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

// do to
// selection de people > rechercher last send et next send sur a 1 journee
// order by note asc nextsend asc
// update immediatement lastsend if shoot ok update nextsend plus note

// selection domaine

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

        $minutes = (60+(($v['note']*$v['note']*$v['note'])/2));
        $diff =   strtotime("-".$minutes." minutes", $_SERVER['REQUEST_TIME'])-$v['lastsend'];
        if($diff > 0 && $i < $e[0])
        {
          $shoot[]= ['Bulk','shootDom',[$v['_id']['$oid'],$e[1]],[],[$e[2]]];
          $i++;
        }
      }

      $nbinsert = count($shoot)*$e[1];


      if(count($shoot) > 0)
      {
        print_r($shoot);
        $boom = $async->sync($shoot);
      }

    }

    public function insert()
    {
      $this->loadModel('People');
      $camp = $this->People->findAllPeople(500);
      $this->insert();
    }
    public function shootDom($e)
    {
      $time = $_SERVER['REQUEST_TIME'];
      $this->loadModel('Domain');
      $this->loadModel('Campaign');
      $camp = $this->Campaign->selectcamp();
      if(!isset($camp['_id']['$oid'])) die();
      $Domain = $this->Domain->domDetailUpdate($e[0]);
      unset($Domain['people']);
      $shoot = "ok";
      $i = 0;
      $j = 0;
      while($i < $e[1])
      {

          if($shoot == "ok")
          {
            $people = $this->people();
            $shoot = $this->sendPeople($people,$Domain,$camp);
            sleep(1);
            $j++;
          }
          else
            $shoot = "error";
          $i++;
      }

      if($shoot != "ok" && $j < 3)
      {
        $ka = $this->accountSMTP($Domain,0);
        $set['$set']['note'] = $Domain['note']+1;
        $set['$inc']['account.'.$ka.'.nb'] = 2000;
        $this->Domain->updateEndDomain($Domain['_id']['$oid'],$set);

      }
      else{
        $ka = $this->accountSMTP($Domain,0);
        $set['$inc']['account.'.$ka.'.nb'] = $j;
        $this->Domain->updateEndDomain($Domain['_id']['$oid'],$set);
      }
      $this->shoot([2,$e[1],'_blank']);
    }

    private function people()
    {
      $this->loadModel('People');

      $people = $this->People->findOnePeople();
      if(isset($people['_id']['$oid']))
      {
        $nextSend = $this->nextSend($people['note']);
        $note = $this->calculNote($people);
        $people['nextSend'] = $nextSend;
        $people['note'] = $note['note'];
        $people['BackNote'] = $note['BackNote'];
        $this->People->updateOnePeople($people);
      }

      return($people);
    }

    private function sendPeople($people,$Domain,$camp)
    {
      $this->loadModel('People');
      $this->loadModel('Campaign');
    //  $this->loadModel('Logs');
      $shoot = $this->sendMail($Domain,$people,$camp);
      $return = $this->preparReturn($Domain,$people,$shoot);
      $return['insert'] = $_SERVER['REQUEST_TIME'];
      if($shoot == "ok")
        $this->Campaign->updateCamp($camp['_id']['$oid'],1);
    //  $this->Logs->insert($return);
      print_r($return);
      return($shoot);
    }

    private function sendMail($Domain,$people,$camp)
    {

      $smtp = $this->accountSMTP($Domain,1);
      $Prepar = [
        'domid' =>$Domain['_id']['$oid'],
        'peopleid' =>$people['_id']['$oid'],
        'smtpUser' => $smtp,
        'fromAddress' => $camp['email'],
      //  'fromAddress' => $smtp,
      //  'fromAddress' => "nina.garcia42@yahoo.fr",
      //  'fromAddress' => substr($Domain['_id']['$oid'], 0, 10)."@".substr($Domain['_id']['$oid'], -10).".com",
        'toName' => $people['firstname'],
        'toAdress' => $people['email'],
      //  'toAdress' => "mrsoyer@live.fr",
        'proxy' => $Domain['proxy'],
      //  'proxy' => "",
        'fromName' => $camp['name'],
        'subject' => $camp['sujet'],
        'textMessage' => $camp['message'],
      ];
      $Prepar['htmlMessage'] = $this->preparHTML($Prepar,$camp);
      $Mails = $this->newsym('Mails');
      print_r($Prepar);
      try {
          $shoot = $Mails->smtpOvhBulk($Prepar);
      } catch (Exception $e) {
          $shoot = "error";
      }

      return($shoot);
    }

    public function accountSMTP($Domain,$type)
    {
      foreach($Domain['account'] as $k=>$v)
      {
        if($v['nb'] < 2000)
        {
          if($type == 1)
            return($v['account']);
          else
            return($k);
          die();
        }
      }
    }

    public function preparHTML($Prepar,$camp)
    {
      $mailHtml = $camp['kit'];
      //print_r($mailHtml);
      $dest = $camp['link'];
      $arg = "".$camp['campName']."/".$Prepar['domid'].'/'.$Prepar['peopleid'].'/';
      $link = "https://".$dest."/Trck/link/".$arg;
      $mailHtml = str_replace("{{link}}", $link,$mailHtml);
      $mailHtml = str_replace("<!DOCTYPE html>","",$mailHtml);
      $mailHtml .="<img src='https://".$dest.'/Trck/img/'.$arg."' width='1px' height='1px'>";
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
