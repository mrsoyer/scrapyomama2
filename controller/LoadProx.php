<?php

class LoadProx extends Controller
{
    public $name = 'cards';

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
    ';
    }

    public function insertProx()
    {
        $this->loadModel('Proxy');
        $list = $this->proxList();
        foreach($list['prox'] as $k=>$v)
        {
          $p['ip'] = $v;
          $p['end'] = $list['end'];
          //print_r($p); die();
          $this->Proxy->insertProx($p);
        }

    }


    public function deleteMail()
    {
      $ovh = $this->newsym("OvhApi");
      $async = $this->newsym("Async");
      $listDom = $async->sync([['OvhApi','listDom',"",[],[_sync]]]);
      $listDom = $listDom[0]['request'];
      shuffle($listDom);
      foreach($listDom as $k=>$v)
      {

        try {
          $domInfo = $async->sync([['OvhApi','domInfo',$v,[],[_sync]]]);
        } catch (Exception $e) {
          sleep(10);
            $this->deleteMail();
            return;
        }
        $domInfo = $domInfo[0]['request'];

        if($domInfo['status'] == "ok" && $domInfo['offer'] != "redirect")
        {

          try {
            $listmail = $async->sync([['OvhApi','listMail',$v,[],[_sync]]]);
          } catch (Exception $e) {
            sleep(10);
              $this->deleteMail();
              return;
          }
          $listmail = $listmail[0]['request'];
          shuffle($listmail);
          $i = 0;
          foreach($listmail as $k1=>$v1)
          {

              try {
                $ovh->deleteMail($v,$v1);

              } catch (Exception $e) {
                try {
                  $ovh->updatePassword($v,$v1);
                  $i++;
                } catch (Exception $e) {
                  sleep(10);
                  $this->deleteMail();
                  return;
                }

              }
          }
          if($i>=5)
          {
            sleep(60);
            $this->deleteMail();
            return;
          }
        }
      }
    }

    public function loadDom($e)
    {
      $this->loadModel('Dom');
      $async = $this->newsym("Async");
      $listDom = $async->sync([['OvhApi','listDom',"",[],[_sync]]]);
      $listDom = $listDom[0]['request'];
      shuffle($listDom);
      foreach($listDom as $k=>$v)
      {

        $domInfo = $async->sync([['OvhApi','domInfo',$v,[],[_sync]]]);
        $domInfo = $domInfo[0]['request'];
        print_r($domInfo);

        if($domInfo['status'] == "ok" && $domInfo['offer'] != "redirect")
        {
          if($domInfo['offer'] == "MXPLAN 005")
            $nb = 5;
          else if($domInfo['offer'] == "MXPLAN 025")
            $nb = 25;
          else if($domInfo['offer'] == "MXPLAN 100")
            $nb = 100;
          else if($domInfo['offer'] == "MXPLAN full")
            $nb = 1000;

          $listdom[] = [
            "domain" => $v,
            "nb" => $nb
          ];
        }
      }

      print_r($listdom);
      //die();
      foreach($listdom as $k=>$v)
      {
        $this->Dom->insertDom($v);
      }
    }

    public function proxList()
    {
      $list['end'] = 1492120800;
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
  return($list);
    }
}
