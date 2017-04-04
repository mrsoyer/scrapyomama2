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
      foreach($listDom as $k=>$v)
      {

        $domInfo = $async->sync([['OvhApi','domInfo',$v,[],[_sync]]]);
        $domInfo = $domInfo[0]['request'];

        if($domInfo['status'] == "ok" && $domInfo['offer'] != "redirect")
        {
          if($domInfo['offer'] == "MXPLAN 005")
            $nb = 5;
          else
            $nb = 1000;

          $listdom[] = [
            "domain" => $v,
            "nb" => $nb
          ];
        }
      }

      print_r($listdom);
      foreach($listdom as $k=>$v)
      {
        $this->Dom->insertDom($v);
      }
    }

    public function proxList()
    {
      $list['end'] = 1492120800;
      $list['prox'] = "143.202.155.121:80:mrsoyer:tomylyjon
138.128.224.6:80:mrsoyer:tomylyjon
170.130.162.57:80:mrsoyer:tomylyjon
176.61.140.67:80:mrsoyer:tomylyjon
107.174.249.154:80:mrsoyer:tomylyjon
109.230.220.176:80:mrsoyer:tomylyjon
104.223.31.28:80:mrsoyer:tomylyjon
154.16.55.154:80:mrsoyer:tomylyjon
138.128.225.222:80:mrsoyer:tomylyjon
173.254.235.216:80:mrsoyer:tomylyjon
104.223.31.38:80:mrsoyer:tomylyjon
162.212.175.96:80:mrsoyer:tomylyjon
158.222.9.198:80:mrsoyer:tomylyjon
138.128.225.220:80:mrsoyer:tomylyjon
109.230.220.196:80:mrsoyer:tomylyjon
158.222.9.148:80:mrsoyer:tomylyjon
109.230.220.206:80:mrsoyer:tomylyjon
170.130.162.90:80:mrsoyer:tomylyjon
104.223.31.4:80:mrsoyer:tomylyjon
198.46.213.32:80:mrsoyer:tomylyjon
138.128.225.228:80:mrsoyer:tomylyjon
154.16.55.138:80:mrsoyer:tomylyjon
104.223.29.219:80:mrsoyer:tomylyjon
109.230.220.254:80:mrsoyer:tomylyjon
162.212.175.113:80:mrsoyer:tomylyjon
107.174.251.231:80:mrsoyer:tomylyjon
143.202.155.48:80:mrsoyer:tomylyjon
165.231.168.178:80:mrsoyer:tomylyjon
107.174.251.141:80:mrsoyer:tomylyjon
158.222.9.241:80:mrsoyer:tomylyjon
162.212.175.126:80:mrsoyer:tomylyjon
159.203.44.59:80:mrsoyer:tomylyjon
104.223.29.154:80:mrsoyer:tomylyjon
155.94.166.237:80:mrsoyer:tomylyjon
176.61.140.78:80:mrsoyer:tomylyjon
138.128.224.108:80:mrsoyer:tomylyjon
165.231.168.64:80:mrsoyer:tomylyjon
198.46.212.134:80:mrsoyer:tomylyjon
198.46.213.41:80:mrsoyer:tomylyjon
107.174.249.177:80:mrsoyer:tomylyjon
155.94.166.149:80:mrsoyer:tomylyjon
151.237.177.202:80:mrsoyer:tomylyjon
155.94.166.47:80:mrsoyer:tomylyjon
109.230.220.201:80:mrsoyer:tomylyjon
158.222.9.88:80:mrsoyer:tomylyjon
151.237.177.185:80:mrsoyer:tomylyjon
109.230.220.28:80:mrsoyer:tomylyjon
168.235.80.222:80:mrsoyer:tomylyjon
107.174.251.240:80:mrsoyer:tomylyjon
198.46.212.139:80:mrsoyer:tomylyjon
165.231.168.46:80:mrsoyer:tomylyjon
158.222.9.200:80:mrsoyer:tomylyjon
165.231.168.233:80:mrsoyer:tomylyjon
154.16.47.153:80:mrsoyer:tomylyjon
107.174.249.132:80:mrsoyer:tomylyjon
154.16.53.187:80:mrsoyer:tomylyjon
198.46.213.115:80:mrsoyer:tomylyjon
155.94.166.156:80:mrsoyer:tomylyjon
178.216.48.108:80:mrsoyer:tomylyjon
107.174.249.134:80:mrsoyer:tomylyjon
170.130.179.18:80:mrsoyer:tomylyjon
138.128.225.197:80:mrsoyer:tomylyjon
158.222.9.105:80:mrsoyer:tomylyjon
158.222.9.167:80:mrsoyer:tomylyjon
130.185.152.111:80:mrsoyer:tomylyjon
154.16.55.149:80:mrsoyer:tomylyjon
178.216.48.156:80:mrsoyer:tomylyjon
167.88.120.128:80:mrsoyer:tomylyjon
151.237.177.179:80:mrsoyer:tomylyjon
143.202.155.58:80:mrsoyer:tomylyjon
158.222.9.85:80:mrsoyer:tomylyjon
176.61.140.96:80:mrsoyer:tomylyjon
154.16.69.152:80:mrsoyer:tomylyjon
130.185.152.107:80:mrsoyer:tomylyjon
170.130.162.113:80:mrsoyer:tomylyjon
198.46.213.98:80:mrsoyer:tomylyjon
155.94.166.129:80:mrsoyer:tomylyjon
151.237.177.72:80:mrsoyer:tomylyjon
165.231.168.209:80:mrsoyer:tomylyjon
176.61.140.152:80:mrsoyer:tomylyjon
173.254.235.211:80:mrsoyer:tomylyjon
138.128.224.16:80:mrsoyer:tomylyjon
155.94.166.154:80:mrsoyer:tomylyjon
143.202.155.85:80:mrsoyer:tomylyjon
155.94.166.143:80:mrsoyer:tomylyjon
165.231.168.25:80:mrsoyer:tomylyjon
107.174.251.205:80:mrsoyer:tomylyjon
138.128.224.107:80:mrsoyer:tomylyjon
104.223.29.155:80:mrsoyer:tomylyjon
154.16.45.181:80:mrsoyer:tomylyjon
170.130.162.118:80:mrsoyer:tomylyjon
172.245.91.100:80:mrsoyer:tomylyjon
143.202.155.34:80:mrsoyer:tomylyjon
109.230.220.7:80:mrsoyer:tomylyjon
104.223.31.32:80:mrsoyer:tomylyjon
155.94.166.131:80:mrsoyer:tomylyjon
151.237.177.133:80:mrsoyer:tomylyjon
155.94.166.189:80:mrsoyer:tomylyjon
109.230.220.187:80:mrsoyer:tomylyjon
158.222.9.36:80:mrsoyer:tomylyjon
";
$list['prox'] = explode(":mrsoyer:tomylyjon
",$list['prox']);
unset($list['prox'][count($list['prox'])-1]);
  return($list);
    }
}
