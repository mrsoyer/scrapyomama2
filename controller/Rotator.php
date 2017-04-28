<?php

class Rotator extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
      $async = $this->newsym('Async');
      $i = 10;
      echo "bim";
      while($i)
      {
        $boom = $async->sync([['Rotator','runs',["_back"],[],["_back"]]]);
        sleep(1);
        $i--;
      }
      echo "bim";
    }
    public function runs($sym)
    {
      print_r($sym);
      echo "ok";
      $this->loadModel('Smtpm');
       $mail = $this->newsym('Mails');
      $freenom = $this->newsym('Freenom');

      echo "ok";
      //$this->rotateIp($sym);
      echo "ok";
      //$freenom->createdom(["http://fbflirt.com/Trck/c/".md5(uniqid(time()))."/Trck/link/1"]);
      $sym['link'] = "mailbox239879.ovh/Trck/c/".md5(uniqid(time()));
      //$sym['link'] = $this->tinyurl($sym['link']);
      $sym['freenoms'] = "mailbox239879.ovh/Trck/c/".md5(uniqid(time()))."/Trck/link/1";
      if($sym['freenoms'] == "error") die();
      $sym["_back"] = "";

      if(isset($sym[1]))
        $sym['sender'] = $sym[1];
      //$smtp = $this->Smtpm->findSmtp();
      print_r($smtp);
      //if(!isset($smtp['_id']['$oid'])) die();

      $sym[0]=$sym[0];
      $sym[1]=$smtp['mail'].":".$smtp['pass'];
      //$sym[2] = "sicardnurni1980@yahoo.com:vZvqWgrjbe";
      $sym['useragent'] = $mail->userAgent();
      $sym['proxy'] = $this->proxy();

      //$sym['link'] = $_SERVER['SERVER_NAME'];

      $sym['e']=0;
      $this->shoot($sym);
    }

    public function tinyurl($url)
    {
      //print_r("\n".'curl "http://tinyurl.com/api-create.php\?url='.$url."\n");
      $url = shell_exec('curl "http://tinyurl.com/api-create.php?url=http://'.$url.'"');

      sleep(3);
      print_r($url);
      return($url);
    }

    public function shoot($sym)
    {
       $async = $this->newsym('Async');
       if(isset($sym[2]))
         $sym['sender'] = $sym[2];

        //$smtp = $this->thissmtp($sym);
        $smtp['mail'] = $_SERVER['HTTP_HOST']."@".$_SERVER['SPARKPOST_SANDBOX_DOMAIN'];
        $people = $this->people();
        $people['link'] = $sym['link'];
        $people['freenoms'] = $sym['freenoms'];
        //print_r($people);
        if(!isset($people['_id']['$oid'])) die();
        $shoot = $this->sendPeople($people,$sym);
        //sleep(rand(0,3));
        print_r($shoot);
        if($shoot != "ok")
        {
          $sym['e']++;
          $this->peopleKo($people);
        }
        else
          $sym['e']=0;

        $sym[0]--;
        if($sym[0]>0 && $sym['e'] < 3)
          $boom = $async->sync([['Rotator','shoot',$sym,[],["_back"]]]);
    }

    public function rotateIp($sym)
    {
      shell_exec('curl -n -X DELETE https://api.heroku.com/apps/'.$sym[0].'/dynos \
    -H "Content-Type: application/json" \
    -H "Accept: application/vnd.heroku+json; version=3" \
    -H "Authorization: Bearer 79e5e2c6-dfff-4dc7-adb0-544791fd28a5"');
      print_r($_SERVER['SERVER_ADDR']);
    }

    public function thissmtp($sym)
    {
      $ya = explode(":",$sym[1]);
        $return['smtp'] = $ya[0];
        $return['pass'] = $ya[1];
      return $return;
    }

    private function people()
    {
      $this->loadModel('People');

      $people = $this->People->findOnePeople();
      if(isset($people['_id']['$oid']))
      {
        $nextSend = $this->nextSend($people['note']);
        $note = $this->calculNote($people);
        $pe = $people;
        $pe['nextSend'] = $nextSend;
        $people['nextSend'] = $nextSend;
        $pe['note'] = $note['note'];
        $pe['BackNote'] = $note['BackNote'];
        $this->People->updateOnePeople($pe);
      }

      return($people);
    }

    private function peopleKo($people)
    {
        $this->loadModel('People');
        $this->People->updateOnePeople($people);
    }

    private function sendPeople($people,$sym)
    {
      $shoot = $this->newsym('Mails');
      $ya = explode(":",$sym[1]);
      try {
        $kit = $this->kitCompose($people,$sym);
      } catch (Exception $e) {
        $kit = $this->kitCompose($people,$sym);
      }



      if(isset($sym['sender']))
       $people['email'] = $sym['sender'];
       if(isset($_SERVER['CLOUDMAILIN_FORWARD_ADDRESS']))
        $fromadress = $_SERVER['CLOUDMAILIN_FORWARD_ADDRESS'];
      else
        $fromadress = $ya[0];

      $bulk = $shoot->smtp([
        'fromName' => $kit['name'],
        'fromAddress' => $_SERVER['CLOUDMAILIN_PASSWORD']."@mailbox239879.ovh",
        'toName' => $people['email'],
        'toAdress' => $people['email'],
      //  'toAdress' => $people['email'],
        'subject' => $kit['subject'],
        'htmlMessage' =>$kit['html'],
        'textMessage' => $kit['subject'],
        'proxy' => $sym['proxy'],
        'smtpHost' => "smtp.mail.yahoo.com",
        'smtpPort' => 465,
        'smtpUser' => $ya[0],
        'smtpPassword' => $ya[1],
        'ssl' => 1,
        'tls' => 0,
        'smtpDebug' => 0,
        'smtpHtmlDebug' => 0,
        'useragent' => $sym['useragent']
      ]);

      return $bulk;
    }

    private function kitCompose($people,$sym)
    {
      $parser = $this->newsym('Pars');
      $kit = $parser->kit($people);
      return($kit);
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

    private function proxy()
    {
      $list['prox'] = "192.240.245.232:80:mrsoyer:tomylyjon
192.240.245.190:80:mrsoyer:tomylyjon
23.232.254.238:80:mrsoyer:tomylyjon
45.45.157.194:80:mrsoyer:tomylyjon
82.211.57.151:80:mrsoyer:tomylyjon
93.127.134.15:80:mrsoyer:tomylyjon
62.210.14.96:80:mrsoyer:tomylyjon
82.211.58.83:80:mrsoyer:tomylyjon
165.231.84.32:80:mrsoyer:tomylyjon
165.231.84.82:80:mrsoyer:tomylyjon
89.35.105.85:80:mrsoyer:tomylyjon
93.127.134.72:80:mrsoyer:tomylyjon
93.127.138.194:80:mrsoyer:tomylyjon
192.240.245.227:80:mrsoyer:tomylyjon
77.81.95.134:80:mrsoyer:tomylyjon
192.230.61.210:80:mrsoyer:tomylyjon
196.196.50.177:80:mrsoyer:tomylyjon
91.108.176.68:80:mrsoyer:tomylyjon
23.232.139.165:80:mrsoyer:tomylyjon
45.45.157.47:80:mrsoyer:tomylyjon
37.72.191.120:80:mrsoyer:tomylyjon
5.34.242.65:80:mrsoyer:tomylyjon
23.232.254.190:80:mrsoyer:tomylyjon
92.114.6.55:80:mrsoyer:tomylyjon
82.211.58.70:80:mrsoyer:tomylyjon
163.172.247.143:80:mrsoyer:tomylyjon
165.231.84.65:80:mrsoyer:tomylyjon
62.4.24.124:80:mrsoyer:tomylyjon
185.107.24.122:80:mrsoyer:tomylyjon
45.45.157.9:80:mrsoyer:tomylyjon
93.127.134.37:80:mrsoyer:tomylyjon
104.160.19.242:80:mrsoyer:tomylyjon
107.190.163.223:80:mrsoyer:tomylyjon
89.43.115.67:80:mrsoyer:tomylyjon
46.29.249.195:80:mrsoyer:tomylyjon
104.160.19.217:80:mrsoyer:tomylyjon
77.81.95.147:80:mrsoyer:tomylyjon
62.4.24.98:80:mrsoyer:tomylyjon
212.129.9.210:80:mrsoyer:tomylyjon
163.172.247.191:80:mrsoyer:tomylyjon
31.14.250.50:80:mrsoyer:tomylyjon
5.255.75.26:80:mrsoyer:tomylyjon
23.232.139.204:80:mrsoyer:tomylyjon
178.216.50.8:80:mrsoyer:tomylyjon
212.129.5.239:80:mrsoyer:tomylyjon
165.231.84.31:80:mrsoyer:tomylyjon
45.45.157.50:80:mrsoyer:tomylyjon
31.14.250.48:80:mrsoyer:tomylyjon
37.72.191.183:80:mrsoyer:tomylyjon
89.43.115.59:80:mrsoyer:tomylyjon
191.101.73.151:80:mrsoyer:tomylyjon
163.172.247.161:80:mrsoyer:tomylyjon
82.211.58.80:80:mrsoyer:tomylyjon
181.214.208.12:80:mrsoyer:tomylyjon
212.129.23.36:80:mrsoyer:tomylyjon
107.190.163.242:80:mrsoyer:tomylyjon
196.196.50.225:80:mrsoyer:tomylyjon
191.101.75.237:80:mrsoyer:tomylyjon
165.231.84.179:80:mrsoyer:tomylyjon
89.35.105.6:80:mrsoyer:tomylyjon
191.101.73.220:80:mrsoyer:tomylyjon
46.29.249.205:80:mrsoyer:tomylyjon
188.215.23.209:80:mrsoyer:tomylyjon
46.29.249.182:80:mrsoyer:tomylyjon
45.45.157.54:80:mrsoyer:tomylyjon
163.172.247.171:80:mrsoyer:tomylyjon
104.160.19.163:80:mrsoyer:tomylyjon
89.35.105.22:80:mrsoyer:tomylyjon
163.172.247.169:80:mrsoyer:tomylyjon
37.72.191.194:80:mrsoyer:tomylyjon
89.35.105.196:80:mrsoyer:tomylyjon
192.230.61.156:80:mrsoyer:tomylyjon
37.72.191.122:80:mrsoyer:tomylyjon
89.35.105.247:80:mrsoyer:tomylyjon
93.127.138.248:80:mrsoyer:tomylyjon
45.45.157.198:80:mrsoyer:tomylyjon
212.83.135.49:80:mrsoyer:tomylyjon
212.129.11.180:80:mrsoyer:tomylyjon
5.34.242.35:80:mrsoyer:tomylyjon
163.172.247.189:80:mrsoyer:tomylyjon
31.14.250.23:80:mrsoyer:tomylyjon
165.231.84.232:80:mrsoyer:tomylyjon
107.190.163.49:80:mrsoyer:tomylyjon
181.214.208.49:80:mrsoyer:tomylyjon
77.81.95.211:80:mrsoyer:tomylyjon
23.232.254.235:80:mrsoyer:tomylyjon
107.190.163.16:80:mrsoyer:tomylyjon
5.34.242.64:80:mrsoyer:tomylyjon
5.34.242.133:80:mrsoyer:tomylyjon
82.211.58.55:80:mrsoyer:tomylyjon
191.101.73.150:80:mrsoyer:tomylyjon
37.72.191.181:80:mrsoyer:tomylyjon
62.4.24.118:80:mrsoyer:tomylyjon
31.14.250.51:80:mrsoyer:tomylyjon
82.211.58.20:80:mrsoyer:tomylyjon
46.29.249.188:80:mrsoyer:tomylyjon
93.127.138.221:80:mrsoyer:tomylyjon
62.210.9.34:80:mrsoyer:tomylyjon
5.34.242.238:80:mrsoyer:tomylyjon
89.35.105.188:80:mrsoyer:tomylyjon
191.101.73.194:80:mrsoyer:tomylyjon
163.172.247.166:80:mrsoyer:tomylyjon
195.154.19.208:80:mrsoyer:tomylyjon
196.196.50.248:80:mrsoyer:tomylyjon
107.190.163.217:80:mrsoyer:tomylyjon
92.114.6.26:80:mrsoyer:tomylyjon
104.160.19.186:80:mrsoyer:tomylyjon
192.240.245.240:80:mrsoyer:tomylyjon
195.154.19.203:80:mrsoyer:tomylyjon
23.232.139.174:80:mrsoyer:tomylyjon
23.232.139.214:80:mrsoyer:tomylyjon
89.35.105.43:80:mrsoyer:tomylyjon
77.81.95.157:80:mrsoyer:tomylyjon
5.255.75.109:80:mrsoyer:tomylyjon
107.190.163.38:80:mrsoyer:tomylyjon
104.160.19.250:80:mrsoyer:tomylyjon
107.190.163.60:80:mrsoyer:tomylyjon
23.232.139.212:80:mrsoyer:tomylyjon
196.196.50.247:80:mrsoyer:tomylyjon
185.107.24.59:80:mrsoyer:tomylyjon
104.160.19.200:80:mrsoyer:tomylyjon
181.214.208.54:80:mrsoyer:tomylyjon
62.210.6.249:80:mrsoyer:tomylyjon
89.43.115.55:80:mrsoyer:tomylyjon
5.255.75.98:80:mrsoyer:tomylyjon
82.211.57.166:80:mrsoyer:tomylyjon
181.214.209.124:80:mrsoyer:tomylyjon
82.211.58.24:80:mrsoyer:tomylyjon
181.214.209.74:80:mrsoyer:tomylyjon
5.34.242.22:80:mrsoyer:tomylyjon
196.196.50.143:80:mrsoyer:tomylyjon
87.239.249.128:80:mrsoyer:tomylyjon
5.34.243.32:80:mrsoyer:tomylyjon
23.232.254.224:80:mrsoyer:tomylyjon
191.101.73.183:80:mrsoyer:tomylyjon
196.196.50.249:80:mrsoyer:tomylyjon
188.215.23.191:80:mrsoyer:tomylyjon
176.61.140.201:80:mrsoyer:tomylyjon
92.114.6.100:80:mrsoyer:tomylyjon
5.34.242.97:80:mrsoyer:tomylyjon
5.34.242.23:80:mrsoyer:tomylyjon
104.160.19.226:80:mrsoyer:tomylyjon
185.107.24.71:80:mrsoyer:tomylyjon
212.129.5.233:80:mrsoyer:tomylyjon
45.45.157.220:80:mrsoyer:tomylyjon
188.215.23.204:80:mrsoyer:tomylyjon
5.255.75.110:80:mrsoyer:tomylyjon
192.230.61.200:80:mrsoyer:tomylyjon
93.127.138.184:80:mrsoyer:tomylyjon
181.214.208.85:80:mrsoyer:tomylyjon
91.108.176.213:80:mrsoyer:tomylyjon
191.101.73.208:80:mrsoyer:tomylyjon
46.29.249.189:80:mrsoyer:tomylyjon
82.211.57.235:80:mrsoyer:tomylyjon
196.196.50.90:80:mrsoyer:tomylyjon
45.45.157.238:80:mrsoyer:tomylyjon
5.255.75.114:80:mrsoyer:tomylyjon
5.157.0.48:80:mrsoyer:tomylyjon
192.230.61.197:80:mrsoyer:tomylyjon
37.72.191.126:80:mrsoyer:tomylyjon
163.172.247.137:80:mrsoyer:tomylyjon
31.14.250.58:80:mrsoyer:tomylyjon
196.196.50.59:80:mrsoyer:tomylyjon
104.160.19.32:80:mrsoyer:tomylyjon
195.154.23.110:80:mrsoyer:tomylyjon
91.108.176.216:80:mrsoyer:tomylyjon
165.231.84.43:80:mrsoyer:tomylyjon
31.14.250.25:80:mrsoyer:tomylyjon
192.230.61.136:80:mrsoyer:tomylyjon
45.45.157.100:80:mrsoyer:tomylyjon
104.160.19.219:80:mrsoyer:tomylyjon
165.231.84.30:80:mrsoyer:tomylyjon
165.231.84.185:80:mrsoyer:tomylyjon
181.214.208.29:80:mrsoyer:tomylyjon
89.35.105.74:80:mrsoyer:tomylyjon
188.215.23.187:80:mrsoyer:tomylyjon
93.127.134.14:80:mrsoyer:tomylyjon
89.43.115.81:80:mrsoyer:tomylyjon
5.34.243.36:80:mrsoyer:tomylyjon
62.4.24.115:80:mrsoyer:tomylyjon
181.214.208.83:80:mrsoyer:tomylyjon
92.114.6.35:80:mrsoyer:tomylyjon
107.190.163.55:80:mrsoyer:tomylyjon
107.190.163.27:80:mrsoyer:tomylyjon
176.61.140.184:80:mrsoyer:tomylyjon
191.101.75.199:80:mrsoyer:tomylyjon
89.43.115.29:80:mrsoyer:tomylyjon
77.81.95.209:80:mrsoyer:tomylyjon
5.255.75.42:80:mrsoyer:tomylyjon
191.101.73.211:80:mrsoyer:tomylyjon
163.172.247.174:80:mrsoyer:tomylyjon
195.154.19.221:80:mrsoyer:tomylyjon
89.35.105.79:80:mrsoyer:tomylyjon
181.214.209.80:80:mrsoyer:tomylyjon
178.216.51.35:80:mrsoyer:tomylyjon
212.129.18.194:80:mrsoyer:tomylyjon
62.210.254.212:80:mrsoyer:tomylyjon
196.196.50.136:80:mrsoyer:tomylyjon
62.4.24.121:80:mrsoyer:tomylyjon
93.127.138.213:80:mrsoyer:tomylyjon
";
$list['prox'] = explode(":mrsoyer:tomylyjon
",$list['prox']);
unset($list['prox'][count($list['prox'])-1]);
shuffle($list['prox']);
  return($list['prox'][0]);
    }
}
