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
    echo shell_exec('curl -n -X DELETE https://api.heroku.com/apps/scrapyomama/dynos \
  -H "Content-Type: application/json" \
  -H "Accept: application/vnd.heroku+json; version=3" \
  -H "Authorization: Bearer 79e5e2c6-dfff-4dc7-adb0-544791fd28a5"');
    print_r($_SERVER['SERVER_ADDR']);
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
    //  $this->loadModel('Campaign');
    //  $camp = $this->Campaign->selectcamp();
      //if(!isset($camp['_id']['$oid'])) die();
      /*if($camp['count']==0)
      {
        echo "---Load Campaing--- \n";
        $this->loadModel('People');
        $this->People->dellAllPeople();
        $this->insert($camp['limit']);
        $this->Campaign->updateCamp($camp['_id']['$oid'],1);
      }*/
      echo "---Start--- \n";
      $prox = $this->Proxy->selectProx();
    //  print_r($prox);
      echo "---RUN--- \n";
      $i = 0;
      $shoot= array();
      foreach($prox as $k=>$v)
      {
      if(!isset($v['smtp']))
        {

            /*
          $dom = $this->Dom->findOneDom();
          //print_r($dom);
          //die();
          $name = $ovh->t();

          try {
            print_r($ovh->createMail($dom['domain'],$name));
            $this->create([$name]);
            $cloud = $this->push([$name]);
            $rand = [1,2,3,4,5,6,7];
            shuffle($rand);
            $cloud['order'] = $rand[0].",".$rand[1].",".$rand[2].",".$rand[3].",".$rand[4].",".$rand[5].",".$rand[6].",";
            $cloud['useragent'] = $this->userAgent();
            if(isset($dom['account']) && $dom['cloudmailin'] != "")
              $this->Dom->addAccount($v['_id']['$oid'],$dom['_id']['$oid'],$name);
            else
              $this->Dom->addCAccount($v['_id']['$oid'],$dom['_id']['$oid'],$name);

            $this->Proxy->addAccount($v['_id']['$oid'],$name."@".$dom['domain'],$cloud);

          }catch (Exception $d) {
              print_r($d);
              $this->Dom->domError($dom['_id']['$oid']);
          }
          print_r($dom);
          print_r($v);
          */
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

    public function userAgent()
    {
      $u = '[{"id":"3","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident\/4.0; InfoPath.2; MSOffice 14)"}, {"id":"4","useragent":"Microsoft Office\/14.0 (Windows NT 5.1; Microsoft Outlook 14.0.4536; Pro; MSOffice 14)"}, {"id":"5","useragent":"Microsoft Office\/14.0 (Windows NT 6.1; Microsoft Outlook 14.0.5128; Pro)"}, {"id":"6","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident\/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; AskTB5.5; MSOffice 12)"}, {"id":"7","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; MSOffice 12)"}, {"id":"8","useragent":"Microsoft Office\/12.0 (Windows NT 6.1; Microsoft Office Outlook 12.0.6739; Pro)"}, {"id":"9","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident\/6.0; Microsoft Outlook 15.0.4420)"}, {"id":"10","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Win64; x64; Trident\/6.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; InfoPath.3; Tablet PC 2.0; Microsoft Outlook 15.0.4481; ms-office; MSOf"}, {"id":"11","useragent":"Microsoft Office\/16.0 (Microsoft Outlook Mail 16.0.6416; Pro)"}, {"id":"12","useragent":"Microsoft Office\/16.0 (Windows NT 10.0; Microsoft Outlook 16.0.6326; Pro)"}, {"id":"13","useragent":"Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 10.0; WOW64; Trident\/8.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; Microsoft Outlook 16.0.6366; ms-office; MSOffice 16)"}, {"id":"14","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.0.7) Gecko\/2009021910 Firefox\/3.0.7 (via ggpht.com)"}, {"id":"15","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.0.7) Gecko\/2009021910 Firefox\/3.0.7 (via ggpht.com GoogleImageProxy)"}, {"id":"16","useragent":"Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit\/536.26.14 (KHTML, like Gecko)"}, {"id":"17","useragent":"Mozilla\/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.14) Gecko\/20080505 Thunderbird\/2.0.0.14"}, {"id":"18","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.8.1.19) Gecko\/20081209 Thunderbird\/2.0.0.19"}, {"id":"19","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9pre) Gecko\/2008050715 Thunderbird\/3.0a1"}, {"id":"20","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 5.1; cs; rv:1.8.1.21) Gecko\/20090302 Lightning\/0.9 Thunderbird\/2.0.0.21"}, {"id":"21","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 5.1; cs; rv:1.9.1.8) Gecko\/20100227 Lightning\/1.0b1 Thunderbird\/3.0.3"}, {"id":"22","useragent":"Mozilla\/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.13) Gecko\/20101208 Lightning\/1.0b2 Thunderbird\/3.1.7"}, {"id":"23","useragent":"Mozilla\/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.8) Gecko\/20100802 Lightning\/1.0b2 Thunderbird\/3.1.2 ThunderBrowse\/3.3.2"}, {"id":"24","useragent":"Mozilla\/5.0 (Windows NT 6.1; rv:6.0) Gecko\/20110812 Thunderbird\/6.0"}, {"id":"25","useragent":"Mozilla\/5.0 (X11; Linux i686; rv:7.0.1) Gecko\/20110929 Thunderbird\/7.0.1"}, {"id":"26","useragent":"Mozilla\/5.0 (Windows NT 6.2; WOW64; rv:24.0) Gecko\/20100101 Thunderbird\/24.2.0"}, {"id":"27","useragent":"Mozilla\/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko\/20100101 Thunderbird\/38.2.0"}]';
      $u = json_decode($u,true);
      shuffle($u);
      $result = $u[0]['useragent'];
      //print_r($result);
      return($result);

    }

    public function create($e)
    {
        if(!isset($e[0]))
          $e[0] = time().'campaign';
        shell_exec('cd '.dirname(dirname(__FILE__)).'/campaign/ && git clone https://github.com/mrsoyer/campaign.git '.$e[0]);
    }


    public function insert($n)
    {
      $n = $n[0];
      $this->loadModel('People');
      $camp = $this->People->findAllPeople(500);
      if($n>0)
        $this->insert([$n-500]);
    }

    public function push($e)
    {
        $this->loadModel('Campaign');
        $time = time();
        if(!isset($e[0]))
          $e[0] = time().'campaign';
        $shell = shell_exec('cd '.dirname(dirname(__FILE__)).'/campaign/'.$e[0].' \
        && heroku create c'.$e[0].' \
        && git push heroku master \
        && heroku ps:scale web=1 \
        && heroku ps:resize web=standard-1x \
        && heroku addons:create cloudmailin:developer');

        $mail = explode("Your CloudMailin email address (",$shell);
        $mail = explode(") is ready to use.",$mail[1]);
        $mail = $mail[0];
        $link = 'c'.$e[0].'.herokuapp.com';
        if(isset($mail))
        {
          echo "email = ".$mail."\n";
          echo "link = ".$link."\n";
          $info['email'] = $mail;
          $info['link'] = $link;
          $info['count'] = 0;
          $info['create'] = $time;
          return($info);
        }
        else
        {
          echo "error";
        }

    }

    public function shootDom($e)
    {
      $ovh = $this->newsym("OvhApi");

      $time = $_SERVER['REQUEST_TIME'];
      $this->loadModel('Proxy');
      $this->loadModel('Campaign');

      //if(!isset($camp['_id']['$oid'])) die();
      $Proxy = $this->Proxy->domDetailUpdate($e[0]);

      $shoot = "ok";
      $i = 0;
      $j = 0;
      $k = 0;
      while($j<3 && $k<$e[1])
      {

            $people = $this->people();
            if(!isset($people['_id']['$oid'])) die();
            $shoot = $this->sendPeople($people,$Proxy);
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

    private function sendPeople($people,$Proxy)
    {
      $this->loadModel('People');
      $this->loadModel('Campaign');
      $p = $this->newsym("SBshoot");
      $camp = $p->parser();
    //  $this->loadModel('Logs');
      $shoot = $this->sendMail($Proxy,$people,$camp);
      $return = $this->preparReturn($Proxy,$people,$shoot);
      $return['insert'] = $_SERVER['REQUEST_TIME'];
      if($shoot == "ok")
        //$this->Campaign->updateCamp($camp['_id']['$oid'],1);
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
        'fromAddress' => $Proxy['smtp'],
      //  'fromAddress' => $Proxy['cloudmailin'],
      //  'fromAddress' => "nina.garcia42@yahoo.fr",
    //    'fromAddress' => substr($Proxy['_id']['$oid'], 0, 10)."@".substr($Proxy['_id']['$oid'], -10).".com",
        'toName' => $people['firstname'],
        'toAdress' => $people['email'],
      //  'toAdress' => "garciathomas@gmail.com",
        'proxy' => $Proxy['ip'],
      //  'proxy' => "",
        'fromName' => $camp['name'],
        'subject' => $camp['subject'],
        //  'subject' => "test",
        'textMessage' => $camp['subject'],
        'useragent' => $Proxy['useragent'],
        'order' => $Proxy['order'],
        'link' => $Proxy['link'],
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
      $mailHtml = $camp['html'];
      //print_r($mailHtml);
      $dest = $Prepar['link'];
      $arg = "".$camp['name']."/".$Prepar['domid'].'/'.$Prepar['peopleid'].'/';
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
