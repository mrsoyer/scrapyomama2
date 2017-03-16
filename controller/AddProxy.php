<?php

class AddProxy extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
      $sk = $e[0];
      $proxy= [
"165.231.168.25:80",
"107.174.251.205:80",
"138.128.224.107:80",
"104.223.29.155:80",
"154.16.45.181:80",
"170.130.162.118:80",
"172.245.91.100:80",
"143.202.155.34:80",
"109.230.220.7:80",
"104.223.31.32:80",
"155.94.166.131:80",
"151.237.177.133:80",
"155.94.166.189:80",
"109.230.220.187:80",
"158.222.9.36:80",

      ];
      $this->add($proxy,$sk);
    }

    public function add($e,$sk)
    {
        $this->loadModel('Domain');
        $dom = $this->Domain->selectDomProxy($sk);
        print_r($dom);
        $prox = $e[0];
        $shoot = "the HTTP proxy returned error 503 Service Unavailable";
        foreach($dom['account'] as $k=>$v)
        {
          if($shoot == "the HTTP proxy returned error 503 Service Unavailable")
          {
            $Prepar = [
              'domid' =>$dom['_id']['$oid'],
              'peopleid' =>"58bad411bd966f3300db1ab2",
              'fromAddress' => $dom['account'][$k],
              'toName' => "thomas",
              'toAdress' => "mrsoyer@me.com",
              'proxy' => $prox
            ];
            print_r($Prepar);
            $shoot = $this->smtpOvhInner($Prepar);
            print_r($shoot);
          }
          if($shoot != "ok")
            $error[] = $shoot;

        }
        if($shoot == "ok")
        {
          $this->Domain->updateProxyDomain($dom['_id']['$oid'],$prox);
          print_r("\n proxy add \n");
          $e = $this->reorganiseProx($e);
          $this->add($e,$sk);
        }
        else if(isset($error))
        {
          $er = 0;
          foreach($error as $k=>$v)
          {
            if($v == "the HTTP proxy returned error 503 Service Unavailable")
              $er++;
          }
          if($er == 5)
          {
            $e = $this->reorganiseProx($e);
            $this->add($e,$sk);
          }
          else {
            $this->add($e,($sk+1));
          }
        }



    }

    public function reorganiseProx($e)
    {
      foreach($e as $k=>$v)
      {
        if($k>0)
          $return[] = $v;
      }
      return $return;
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
}
