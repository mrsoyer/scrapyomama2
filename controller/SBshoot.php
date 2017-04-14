<?php
use MimeMailParser\Parser;
use MimeMailParser\Attachment;
class SBshoot extends Controller
{
    public $name = 'cards';

    public function index($e)
    {

    $app = shell_exec("heroku apps");
    $app = explode("\n",$app);
    print_r($app);
    foreach($app as $k=>$v)
    {

      if($v != "scrapyomama")
      {
        echo shell_exec('heroku apps:destroy --app '.$v.' --confirm '.$v);
      }
    }

    }

    public function insertm()
    {
      print_r($_SERVER['CLOUDMAILIN_FORWARD_ADDRESS']);
    }

    public function createapp()
    {
      $i = 99;
      while($i)
      {
      //  shell_exec("heroku apps:fork sym".$i." --from scrapyomama && heroku ps:scale --app sym".$i." web=1:Standard-1X");

        shell_exec("heroku ps:scale --app sym".$i." web=1:Standard-1X");
        $i--;
      }
    }
    public function test()
    {
    print_r(shell_exec('curl --header "X-MyHeaders: 4123" -A "Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident\/4.0; InfoPath.2; MSOffice 14)" --url "smtps://ssl0.ovh.net:465" --mail-from "036tr-mailbox-szv9e@mailbox678678.ovh" --mail-rcpt "mrsoyer@me.com" --user "036tr-mailbox-szv9e@mailbox678678.ovh:tomylyjon" --insecure --upload-file mail.txt --verbose
'));
    }

    public function openSMTP($e) {
       $y = explode(":",$e[0]);
        $this->curl_handle = curl_init("smtp://ssl0.ovh.net:587");
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        //if ($debug == 1) {
          //  $this->dbg = fopen("debug.txt", "w");
            curl_setopt($this->curl_handle, CURLOPT_VERBOSE, TRUE);
            //curl_setopt($this->curl_handle, CURLOPT_STDERR, $this->dbg);
            //$this->debug = 1;
          //  fwrite($this->dbg, "Opening debug file from openSMTP\n");
      //  }
      //$ch = curl_init();

    		curl_setopt($this->curl_handle, CURLOPT_MAIL_FROM, "<".$y[0].">");
    		curl_setopt($this->curl_handle, CURLOPT_MAIL_RCPT, array("<".$e[1].">"));
    		curl_setopt($this->curl_handle, CURLOPT_USERNAME, $y[0]);
    		curl_setopt($this->curl_handle, CURLOPT_PASSWORD, $y[1]);
        //curl_setopt($this->curl_handle, CURLOPT_URL, "smtp://ssl0.ovh.net:587");
      //  curl_setopt($this->curl_handle, CURLOPT_SSL_VERIFYPEER, true);
      //  curl_setopt($this->curl_handle, CURLOPT_SSL_VERIFYHOST, true);
      //  curl_setopt($this->curl_handle, CURLOPT_CAINFO,"cacert.pem");
        //curl_setopt($this->curl_handle, CURLOPT_CAPATH,"./");

        curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, "");
        curl_setopt($this->curl_handle, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($this->curl_handle, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($this->curl_handle, CURLOPT_TIMEOUT, 30); //timeout in seconds
      //  curl_setopt($this->curl_handle, CURLOPT_PROXY, "138.128.225.220:80");
      //  curl_setopt($this->curl_handle, CURLOPT_PROXYUSERPWD, "mrsoyer:tomylyjon");
        $headers = [
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'Host: www.example.com',
            'Referer: http://www.example.com/index.php', //Your referrer address
            'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            'X-MicrosoftAjax: Delta=true'
        ];
        curl_setopt($this->curl_handle,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        //curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, $headers);
      //  $out = "AUTH LOGIN\r\n";
        //$out .= base64_encode($y[0]) . "\r\n";
        //$out .= base64_encode($y[1]) . "\r\n";
        //$out .= "MAIL FROM: <".$y[0].">\r\n";
      //  $out .= "RCPT TO: <".$e[1].">\r\n";
        //$out .= "DATA\r\n";
        $out = "To: ".$e[1]."\r\n";
        $out .="From: ".$y[0]."\r\n";
        $out .="Subject:  yes\r\n\r\n";
        $out .="yes\r\n";
        $out .=".\r\n";
        //$out .="QUIT\r\n";
        curl_setopt($ch, CURLOPT_READFUNCTION, $out . "\r\n");
        curl_setopt($this->curl_handle, CURLOPT_CUSTOMREQUEST, $out . "\r\n");
        print_r(curl_exec($this->curl_handle));

        $error_no = curl_errno($this->curl_handle);
        if ($error_no != 0) {
            return 'Problem opening connection.  CURL Error: ' . $error_no;
        }
        else {
        return('ok');
        }
    }
/*
<?php

$url = 'http://www.oseox.fr';
$timeout = 10;

$proxy_host = 'my-proxy.com:80'; // host:port
$proxy_ident = ''; // username:password

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

if (preg_match('`^https://`i', $url))
{
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
}

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Activation de l'utilisation d'un serveur proxy
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);

// Définition de l'adresse du proxy
curl_setopt($ch, CURLOPT_PROXY, $proxy_host);

// Définition des identifiants si le proxy requiert une identification
if ($proxy_ident)
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_ident);

$page_content = curl_exec($ch);

curl_close($ch);


echo $page_content;
?>
*/
    public function header()
    {
      print_r($_SERVER);
    }
    public function parser()
    {
      $file = scandir(dirname(dirname(__FILE__))."/test");
      //print_r($file);

      shuffle($file);
      $mailParser = new ZBateson\MailMimeParser\MailMimeParser();

      $handle = fopen(dirname(dirname(__FILE__)).'/test/'.$file[0], 'r');
      $message = $mailParser->parse($handle);         // returns a ZBateson\MailMimeParser\Message
      fclose($handle);
      try {
        if($message->getHeader('from')->getPersonName() == "Superencontre")
        {
          return $this->parser();
          die();
        }
      }
      catch (Exception $e) {
        return $this->parser();
      }


    //  echo $message->getHeaderValue('from');          // user@example.com
      try {
        $name = $message->getHeader('from')->getPersonName();
      } catch (Exception $e) {
        return $this->parser();
      }

                            // Person Name
      $subject =  $message->getHeaderValue('subject');       // The email's subject
      //echo $message->getTextContent();                // or getHtmlContent
      //echo "\n";
      $html =  $message->getHtmlContent();
      $dom = new DOMDocument('1.0', 'utf-8');
      $dom->loadHTML($html);
      $countdiv = count($dom->getElementsByTagName('div'));
      foreach($dom->getElementsByTagName('div') as $k=>$href)
      {
        if($k == 0)
            $href->parentNode->removeChild($href);
      }


      $html = $dom->saveHTML();

      $dom = new DOMDocument('1.0', 'utf-8');
      $dom->loadHTML($html);
      $countdiv = count($dom->getElementsByTagName('div'));
      foreach($dom->getElementsByTagName('div') as $k=>$href)
      {
        if($href->nodeValue == "Si vous souhaitez vous dÃ©sinscrire des mails de Superencontre, cliquez ici")
            $href->parentNode->removeChild($href);
      }
      $html = $dom->saveHTML();
      $html = str_replace("garciathomas", "", $html);
      $html = str_replace("THOMAS", "", $html);
      $subject = str_replace("garciathomas", "", $subject);
      $subject = str_replace("THOMAS", "", $subject);
      $return['name'] = $name;
      $return['subject'] = $subject;
      $return['html'] = "<html>
      <head>
      <title>".$subject."</title>
      <link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
      </head>

      <head>
      <title>".$subject."</title>
      </head>";
      $return['html'] .= $html;
      return $return;

    }

    public function shoot($e)
    {
      echo"ok1";

        $kit = $this->parser();
        $dest = "cepswumailbox6y8t9.herokuapp.com";
        $link = "https://".$dest."/Trck/link/";
echo"ok2";
        $kit['html'] = $this->replace_a_href($kit['html'],$link);
        $kit['html'] = $this->replace_img_src($kit['html'],$dest);
        $shoot = $this->newsym('Mails');
        $ya = explode(":",$e[1]);
        if($e[0] == 200)
          $kit['html'] = "";
        echo"ok2";
        $bulk = $shoot->smtp([
          fromName => $kit['name'],
          fromAddress => $ya[0],
          toName => "thomas",
          toAdress => "mrsoyer@me.com",
          subject => $e[0].$kit['subject'],
          htmlMessage => $kit['html'],
          textMessage => $kit['subject'],
          proxy => "",
          smtpHost => "smtp.mail.yahoo.com",
          smtpPort => 465,
          smtpUser => $ya[0],
          smtpPassword => $ya[1],
          ssl => 1,
          tls => 0,
          useragent => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; InfoPath.2; MSOffice 14)",
          smtpDebug => 1,
          smtpHtmlDebug => 1
        ]);
        echo"ok3";

        if($e[0]>0)
        {
          echo "\n n: ".$e[0]."\n";
          //sleep(1);
          $e[0]--;
          //$this->shoot($e);
          $async = $this->newsym('Async');
          $s[]= ['SBshoot','shoot',$e,[],['_back']];
          $boom = $async->sync($s);
        }

    }
    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function tinyurl($url)
    {
      return file_get_contents('http://tinyurl.com/api-create.php?url='.$url);
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

    public function html()
    {
      return "<html>
      <head>
      <title>Caroline a visité votre profil !</title>
      <link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
      </head>
      <body>
      <table border=0 cellspacing=0 cellpadding=0 width=\"100%\" class=\"header-part1\"><tr><td><b>Sujet : </b>Caroline a visité votre profil !</td></tr><tr><td><b>De : </b>Caroline &lt;nina.garcia42@yahoo.fr&gt;</td></tr><tr><td><b>Date : </b>31/03/2017 10:29</td></tr></table><table border=0 cellspacing=0 cellpadding=0 width=\"100%\" class=\"header-part2\"><tr><td><b>Pour : </b>mrsoyer@me.com</td></tr></table><br>
      <html>
      <head>
      <title>Caroline a visité votre profil !</title>
      </head>
      <body>
      <body style=\"margin:0; padding:0;\"><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 450px\">
      	<tbody>
      		<tr>
      			<td bgcolor=\"#A0A0A0\" colspan=\"2\" style=\"text-align: center;\">
      				<span style=\"color: #ffffff;\"><strong><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuwd8r6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">NOUVELLE VISITE</span></a></strong></span></td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#F5F5F5\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"font-family: verdana, geneva; font-size: medium;\">Elle a visit&eacute; votre profil.<br />
      				Profitez de cette occasion&nbsp;pour lui &eacute;crire un message&nbsp;</span><br />
      				<br />
      				<a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesux5or6b7d.html\"><span style=\"font-family: verdana, geneva; font-size: x-large;\"><img src=\"http://img.srensbp.com/ac9wuwd8r6b7e.jpg\" style=\"width: 180px; height: 180px;\" /></span></a><br />
      				<br />
      				<span style=\"font-size:20px;\"><span style=\"font-family: verdana, geneva; color: rgb(51, 51, 51);\"><span style=\"color: #ff0000;\">Caroline</span>&nbsp;- 37 ans</span></span><br />
      				&nbsp;</td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#404040\" style=\"text-align: center;\">
      				<br />
      				<span style=\"color: #ffffff;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuxy4r6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">LUI ECRIRE</span></a></span><br />
      				&nbsp;</td>
      			<td bgcolor=\"#6666FF\" style=\"text-align: center;\">
      				<span style=\"color: #ffffff;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuyqkr6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">SON PROFIL</span></a></span></td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#F5F5F5\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"font-family: verdana, geneva; font-size: x-large;\">Vous avez <span style=\"color:#ff0000;\">19</span>&nbsp;nouvelles visites !</span><br />
      				&nbsp;</td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#A0A0A0\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"color: #ffffff; font-size: large;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuzj0r6b7d.html\" style=\"text-decoration: none;\"><span style=\"color: #ffffff;\"><strong><span style=\"font-family: verdana, geneva;\">VOIR L&#39;ACTUALITE DE MON PROFIL</span></strong></span></a></span><br />
      				&nbsp;</td>
      		</tr>
      	</tbody>
      </table>
      <br />


      </body>
      </html>
      <img src='https://c1490873022thetest.herokuapp.com/Trck/img/thetest/58de102ca678742fd56adf24/58bad87ec2ef162f4b4bf415/' width='1px' height='1px'>
      </body>
      </html>
";
    }
}
