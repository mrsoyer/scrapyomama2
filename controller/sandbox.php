<?php
//include ROOT.'/controller/Api.php';
require __DIR__ . '/../vendor/php-ovh/vendor/autoload.php';
use \Ovh\Api;

class Sandbox extends Controller
{


  public function index($e)
  {

  //  echo '
///////////////////////////////////////////////////////////////////////////////|
//                                           __________  __   __   __    __   ||
//  symheader.php                          / _________/ | |  / /  /  |  /  |  ||
//                                        / /_______    | | / /  /   | /   |  ||
//                                        \______   \   | |/ /  / /| |/ /| |  ||
//  Created: 2015/10/29 12:30:05         ________/  /   |   /  / / |   / | |  ||
//  Updated: 2015/10/29 21:45:22        /__________/    /  /  /_/  |__/  |_|  ||
//                                      ScrapYoMama    /__/    by barney.im   ||
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*

// API/V1 -> mongodb
// mail/smtp([to, from, smtp, user, pass, proxy, useragent, sujet, message, file]);
// mail/smtpOVH(to, from, sujet, message, file)
// mail/cleaner(to,from)
// mail/kitmail([nom, sujet, lienmessage])
// bot/
// ovh/
// crm/
// aff/
//  fb/
//  insta/
//  graph
//domaine1 ouvreur(20%) ||||||||||||||||||||||||||||||||||||||||||||||||||
//';



  }

    public function loadDom()
    {
      $dom='[{"domain":"domaine-name-09.ovh"},
      {"domain":"nouveaumessage05.ovh"},
      {"domain":"nouveaumessage31.ovh"},
      {"domain":"domaine-name-15.ovh"},
      {"domain":"leboncoup-01.ovh"},
      {"domain":"nouveaumessage20.ovh"},
      {"domain":"domaine-name-07.ovh"},
      {"domain":"nouveaumessage24.ovh"},
      {"domain":"rencontresplanscul.com"},
      {"domain":"cougarlocales.com"},
      {"domain":"nouveaumessage28.ovh"},
      {"domain":"nouveaumessage25.ovh"},
      {"domain":"nouveaumessage32.ovh"},
      {"domain":"nouveaumessage03.ovh"},
      {"domain":"leboncoup02.ovh"},
      {"domain":"nouveaumessage35.ovh"},
      {"domain":"leboncoup07.ovh"},
      {"domain":"leboncoup05.ovh"},
      {"domain":"domaine-name-10.ovh"},
      {"domain":"nouveaumessage39.ovh"},
      {"domain":"nouveaumessage21.ovh"},
      {"domain":"nouveaumessage07.ovh"},
      {"domain":"nouveaumessage22.ovh"},
      {"domain":"nouveaumessage19.ovh"},
      {"domain":"leboncoup03.ovh"},
      {"domain":"domaine-name-18.ovh"},
      {"domain":"nouveaumessage14.ovh"},
      {"domain":"domaine-name-05.ovh"},
      {"domain":"nouveaumessage30.ovh"},
      {"domain":"nouveaumessage33.ovh"},
      {"domain":"nouveaumessage37.ovh"},
      {"domain":"leboncoup06.ovh"},
      {"domain":"domaine-name-17.ovh"},
      {"domain":"nouveaumessage34.ovh"},
      {"domain":"nouveaumessage08.ovh"},
      {"domain":"nouveaumessage16.ovh"},
      {"domain":"domaine-name-11.ovh"},
      {"domain":"domaine-name-04.ovh"},
      {"domain":"cougarlocale.com"},
      {"domain":"leboncoup08.ovh"},
      {"domain":"leboncoup04.ovh"},
      {"domain":"domaine-name-13.ovh"},
      {"domain":"nouveaumessage18.ovh"},
      {"domain":"domaine-name-01.ovh"},
      {"domain":"lesboncoups.xyz"},
      {"domain":"leboncoup-aa.xyz"},
      {"domain":"nouveaumessage26.ovh"},
      {"domain":"nouveaumessage13.ovh"},
      {"domain":"nouveaumessage36.ovh"},
      {"domain":"domaine-name-12.ovh"},
      {"domain":"domaine-name-19.ovh"},
      {"domain":"nouveaumessage10.ovh"},
      {"domain":"domaine-name-16.ovh"},
      {"domain":"nouveaumessage38.ovh"},
      {"domain":"nouveaumessage09.ovh"},
      {"domain":"domaine-name-06.ovh"},
      {"domain":"cougar-locale.com"},
      {"domain":"nouveaumessage27.ovh"},
      {"domain":"rencontres-plans-cul.com"},
      {"domain":"domaine-name-08.ovh"},
      {"domain":"nouveaumessage06.ovh"},
      {"domain":"cougarslocale.com"},
      {"domain":"nouveaumessage15.ovh"},
      {"domain":"nouveaumessage04.ovh"},
      {"domain":"nouveaumessage29.ovh"},
      {"domain":"nouveaumessage02.ovh"},
      {"domain":"leboncoup-ab.xyz"},
      {"domain":"rencontreplans-cul.com"},
      {"domain":"nouveaumessage01.ovh"},
      {"domain":"nouveaumessage23.ovh"},
      {"domain":"nouveaumessage12.ovh"},
      {"domain":"nouveaumessage11.ovh"},
      {"domain":"domaine-name-14.ovh"},
      {"domain":"nouveaumessage17.ovh"},
      {"domain":"lesboncoups.biz"},
      {"domain":"leboncoup.ovh"},
      {"domain":"domaine-name-03.ovh"},
      {"domain":"report.paris"},
      {"domain":"nouveaumessage40.ovh"},
      {"domain":"rencontresplansculs.com"},
      {"domain":"domaine-name-20.ovh"},
      {"domain":"domaine-name-02.ovh"}]';

      $prox='["109.73.79.145:80",
"185.107.24.155:80",
"109.73.79.185:80",
"188.214.15.200:80",
"199.195.157.228:80",
"107.172.56.238:80",
"196.196.220.171:80",
"199.195.157.120:80",
"165.231.83.204:80",
"206.214.84.114:80",
"204.44.112.214:80",
"184.175.244.165:80",
"204.44.112.247:80",
"184.175.244.92:80",
"155.94.194.124:80",
"204.44.114.113:80",
"184.175.244.99:80",
"209.164.98.152:80",
"204.44.114.10:80",
"213.184.105.152:80",
"213.184.105.173:80",
"184.175.244.136:80",
"198.23.223.210:80",
"206.214.84.122:80",
"184.175.244.142:80",
"191.101.113.202:80",
"155.94.195.20:80",
"196.196.220.45:80",
"196.196.220.104:80",
"198.23.223.243:80",
"206.214.92.26:80",
"107.175.79.253:80",
"109.73.79.251:80",
"188.214.54.223:80",
"173.254.240.77:80",
"109.73.79.170:80",
"213.184.105.171:80",
"196.196.220.231:80",
"199.195.157.140:80",
"191.101.114.250:80",
"184.175.244.144:80",
"109.73.79.243:80",
"196.196.220.87:80",
"185.107.24.135:80",
"196.196.220.199:80",
"216.158.206.159:80",
"155.94.195.53:80",
"191.101.114.173:80",
"104.168.100.203:80",
"107.175.152.210:80",
"107.175.79.209:80",
"213.184.113.120:80",
"109.73.79.201:80",
"213.184.113.126:80",
"206.214.84.110:80",
"191.101.113.136:80",
"196.196.220.197:80",
"213.184.113.80:80",
"155.94.195.6:80",
"107.172.56.245:80",
"196.196.220.209:80",
"216.158.206.204:80",
"185.107.24.229:80",
"213.184.113.100:80",
"178.216.52.171:80",
"204.44.114.24:80",
"204.44.114.42:80",
"109.73.79.166:80",
"184.175.244.122:80",
"107.175.152.233:80",
"192.227.182.145:80",
"199.195.157.150:80",
"188.214.54.234:80",
"198.23.223.131:80",
"206.214.92.23:80",
"204.44.114.111:80",
"199.195.157.93:80",
"109.73.79.232:80",
"216.158.206.139:80",
"172.245.195.205:80",
"188.214.50.188:80",
"206.214.84.108:80",
"191.101.113.224:80",
"216.158.206.10:80",
"172.245.195.250:80",
"185.107.24.161:80",
"172.245.174.100:80",
"191.101.113.166:80",
"107.175.79.216:80",
"165.231.83.150:80",
"191.101.114.227:80",
"178.216.52.66:80",
"196.196.220.217:80",
"216.158.206.175:80",
"191.101.114.222:80",
"188.214.50.146:80",
"191.101.113.206:80",
"191.101.113.160:80",
"213.184.105.172:80",
"196.196.220.138:80"
]';

      $dom = json_decode($dom,true);
      $prox = json_decode($prox,true);

      foreach($dom as $k=>$v)
      {
        $dom[$k]['proxy'] = $prox[$k];
      }

      $sym = $this->newsym("Api");
      $sym->V1([
        _coll => Domain,
        _p => $dom
      ]);
    }

    public function testM()
    {
      $sym = $this->newsym("Api");
      $sym->V1([
        _coll => Domain,
        _q => [account => ['$exists' => false]],
        _sup => '&l=1'
      ]);
    }
    public function ovhapi()
    {


    //  $test = new \Ovh\Api;
      $ovh = new Api( 'XSc2komxbPmfxwnA',  // Application Key
                      'OYLZHUDupWjs8UTYPirTOD1sDXNngzh7',  // Application Secret
                      'ovh-eu',      // Endpoint of API OVH Europe (List of available endpoints)
                      'cCevV45rLVXqhtcsxOespgsvlUy7Uya2'); // Consumer Key

      $result = $ovh->get('/email/domain');

      print_r( $result );
    }

    public function transfert()
    {
      $data = json_decode(file_get_contents("http://scrapyomama.xyz/Transfertdb"));
      $data = json_decode(json_encode($data), True);
      //$data = (object)$data;
      print_r($data);
      //die();
      $sym =  $this->loadController('Api');
      $sym->V1([
        _coll => People,
        _p => $data,
      ]);

      $this->transfert();
    }

    public function colorjson($json)
    {
      print_r ("
      <html><head>
      <style>
      pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
      .string { color: green; }
      .number { color: darkorange; }
      .boolean { color: blue; }
      .null { color: magenta; }
      .key { color: red; }
      </style>
      <link rel=\"alternate stylesheet\" type=\"text/css\" href=\"resource://gre-resources/plaintext.css\" title=\"Retour à la ligne automatique\"></head><body>
      <script>
      function output(inp) {
          document.body.appendChild(document.createElement('pre')).innerHTML = inp;
      }

      function syntaxHighlight(json) {
          json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
          return json.replace(/(\"(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\\"])*\"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
              var cls = 'number';
              if (/^\"/.test(match)) {
                  if (/:$/.test(match)) {
                      cls = 'key';
                  } else {
                      cls = 'string';
                  }
              } else if (/true|false/.test(match)) {
                  cls = 'boolean';
              } else if (/null/.test(match)) {
                  cls = 'null';
              }
              return '<span class=\"' + cls + '\">' + match + '</span>';
          });
      }

      var obj = ".$json.";
      var str = JSON.stringify(obj, undefined, 4);


      output(syntaxHighlight(str));

      </script>
      </body></html>
      ");
    }

}
