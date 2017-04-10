<?php
use MimeMailParser\Parser;
use MimeMailParser\Attachment;
class SBshoot extends Controller
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

    public function test()
    {
        print_r($this->parser());
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
        echo"ok2";
        echo $shoot->smtp([
          fromName => $kit['name'],
          fromAddress => "dienirapmord1986@yahoo.com",
          toName => "thomas",
          toAdress => "garciathomas@gmail.com",
          subject => $e[0].$kit['subject'],
          htmlMessage => $kit['html'],
          textMessage => $kit['subject'],
          proxy => "",
          smtpHost => "smtp.mail.yahoo.com",
          smtpPort => 465,
          smtpUser => "dienirapmord1986@yahoo.com",
          smtpPassword => "RewAE6GpeM",
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
