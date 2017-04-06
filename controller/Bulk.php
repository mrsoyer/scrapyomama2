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
    public function run($e)
    {
      $async = $this->newsym('Async');
      $shoot[]= ['Bulk','shoot',[$e],[],['_blank']];
      $boom = $async->sync($shoot);

    }
    public function shoot($e)
    {
      if(!isset($e[0])) $e[0] = 1;
      if(!isset($e[1])) $e[1] = 5;
      if(!isset($e[2])) $e[2] = "";
      $async = $this->newsym('Async');
      $this->loadModel('Proxy');
      $this->loadModel('Dom');
      $ovh = $this->newsym("OvhApi");
      $this->loadModel('Campaign');
      $camp = $this->Campaign->selectcamp();
      if(!isset($camp['_id']['$oid'])) die();
      if($camp['count']==0)
      {
        echo "---Load Campaing--- \n";
        $this->loadModel('People');
        $this->People->dellAllPeople();
        $this->insert($camp['limit']);
        $this->Campaign->updateCamp($camp['_id']['$oid'],1);
      }
      echo "---Start--- \n";
      $prox = $this->Proxy->selectProx();
      echo "---RUN--- \n";
      $i = 0;
      $shoot= array();
      foreach($prox as $k=>$v)
      {
        if(!isset($v['smtp']))
        {

          $dom = $this->Dom->findOneDom();

          $name = $ovh->t();
          try {
            print_r($ovh->createMail($dom['domain'],$name));
            if(isset($dom['account']))
              $this->Dom->addAccount($v['_id']['$oid'],$dom['_id']['$oid'],$name);
            else
              $this->Dom->addCAccount($v['_id']['$oid'],$dom['_id']['$oid'],$name);

            $this->Proxy->addAccount($v['_id']['$oid'],$name."@".$dom['domain']);

          }catch (Exception $e) {
              $this->Dom->domError($dom['_id']['$oid']);
          }
          print_r($dom);
          print_r($v);
        }
        else if($v['error'] == 5)
        {
          // on kill le proxy et on sup le mail
          $this->Proxy->killProx($v['_id']['$oid']);
          if(isset($v['smtp']))
          {
            $acc = explode("@",$v['smtp']);

            try {
              $ovh->updatePassword($acc[1],$acc[0]);
            //  $this->Dom->suppAccount($acc); //create
            }catch (Exception $e){}
          }

        }
        else if ($i < $e[0])
        {
          $shoot[]= ['Bulk','shootDom',[$v['_id']['$oid'],$e[1]],[],[$e[2]]];
          $i++;
        }
      }

      if(count($shoot) > 0)
      {
        print_r($shoot);
        //die();
        $boom = $async->sync($shoot);
      }

    }

    public function insert($n)
    {
      $n = $n[0];
      $this->loadModel('People');
      $camp = $this->People->findAllPeople(500);
      if($n>0)
        $this->insert([$n-500]);
    }
    public function shootDom($e)
    {
      $ovh = $this->newsym("OvhApi");
      $time = $_SERVER['REQUEST_TIME'];
      $this->loadModel('Proxy');
      $this->loadModel('Campaign');
      $camp = $this->Campaign->selectcamp();
      if(!isset($camp['_id']['$oid'])) die();
      $Proxy = $this->Proxy->domDetailUpdate($e[0]);
      $shoot = "ok";
      $i = 0;
      $j = 0;
      $k = 0;
      while($j<3 && $k<$e[1])
      {

            $people = $this->people();
            if(!isset($people['_id']['$oid'])) die();
            $shoot = $this->sendPeople($people,$Proxy,$camp);
            sleep(1);
            if($shoot != "ok")
              $j++;
            else
              $j=0;
          $k++;

          //$this->Proxy->domUpdate($e[0]);
      }

      if($j == 3)
      {
        //$this->Proxy->proxError($Proxy['_id']['$oid'],$Proxy['note']+1);//create
        //$this->Campaign->errorCamp($camp['_id']['$oid']);
        $acc = explode("@",$Proxy['smtp']);
        try {
          $ovh->updatePassword($acc[1],$acc[0]);
        }catch (Exception $w){}


      }

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

    private function sendPeople($people,$Proxy,$camp)
    {
      $this->loadModel('People');
      $this->loadModel('Campaign');
    //  $this->loadModel('Logs');
      $shoot = $this->sendMail($Proxy,$people,$camp);
      $return = $this->preparReturn($Proxy,$people,$shoot);
      $return['insert'] = $_SERVER['REQUEST_TIME'];
      if($shoot == "ok")
        $this->Campaign->updateCamp($camp['_id']['$oid'],1);
    //  $this->Logs->insert($return);
      print_r($return);
      return($shoot);
    }

    private function sendMail($Proxy,$people,$camp)
    {
      //$Proxy['smtp'] = "coucou@lkpg.fr";

      $Prepar = [
        'domid' =>$Proxy['_id']['$oid'],
        'peopleid' =>$people['_id']['$oid'],
        'smtpUser' => $Proxy['smtp'],
      //  'fromAddress' => $camp['email'],
        'fromAddress' => $Proxy['smtp'],
      //  'fromAddress' => "nina.garcia42@yahoo.fr",
      //  'fromAddress' => substr($camp['_id']['$oid'], 0, 10)."@".substr($camp['_id']['$oid'], -10).".com",
        'toName' => $people['firstname'],
        'toAdress' => $people['email'],
      //  'toAdress' => "mrsoyer@live.fr",
        'proxy' => $Proxy['ip'],
      //  'proxy' => "",
        'fromName' => $camp['name'],
        'subject' => $camp['sujet'],
        //  'subject' => "test",
        'textMessage' => $camp['message'],
      //'textMessage' => "test",
      ];
      $Prepar['htmlMessage'] = $this->preparHTML($Prepar,$camp);
      //$Prepar['htmlMessage'] = "test";
      $Mails = $this->newsym('Mails');
      //print_r($Prepar);
      try {
          $shoot = $Mails->smtpOvhBulk($Prepar);
      } catch (Exception $e) {
          $shoot = "error";
      }

      return($shoot);
    }

    public function accountSMTP($Domain,$type)
    {
      if($type == 1)
        return($Domain['account'][rand(0,count($Domain['account'])-1)]['account']);
      else {
        return(rand(0,count($Domain['account'])-1));
      }
    }

    public function preparHTML($Prepar,$camp)
    {
      $mailHtml = $camp['kit'];
      //print_r($mailHtml);
      $dest = $camp['link'];
      $arg = "".$camp['campName']."/".$Prepar['domid'].'/'.$Prepar['peopleid'].'/';
      $link = "https://".$dest."/Trck/link/".$arg;
      $mailHtml = $this->replace_a_href($mailHtml,$link);
      $mailHtml = $this->replace_img_src($mailHtml,$dest);
      $mailHtml .="<img src='https://".$dest.'/Trck/img/'.$arg."' width='1px' height='1px'>";
      //$mailHtml = str_replace(array("\n","\r","\t"),'',$mailHtml);
      return($mailHtml);
    }

    public  function replace_img_src($img_tag,$dest) {
        $doc = new DOMDocument();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $old_src = $tag->getAttribute('src');
            $old_src = $this->base64url_encode($old_src);
            $new_src_url = "https://".$dest."/Trck/imgSrc/".$old_src;
            $new_src_url= $this->tinyurl($new_src_url);
            $tag->setAttribute('src', $new_src_url);
        }
        return $doc->saveHTML();
    }

    public  function replace_a_href($html,$link) {
        $link = $this->tinyurl($link);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('a');
        foreach ($tags as $tag) {
            $tag->setAttribute('href', $link);
        }
        return $doc->saveHTML();
    }

    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function tinyurl($url)
    {
      return file_get_contents('http://tinyurl.com/api-create.php?url='.$url);
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


    private function preparReturn($Proxy,$people,$shoot)
    {
      $return['idDomain']=$Proxy['_id']['$oid'];
      $return['idPeople']=$people['_id']['$oid'];
      $return['to']=$people['email'];
      $return['smtp']=$Proxy['smtp'];
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
