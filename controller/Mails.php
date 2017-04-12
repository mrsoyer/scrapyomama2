<?php
require dirname(dirname(__FILE__))."/phpclasses/smtpclass/email_message.php";
require dirname(dirname(__FILE__))."/phpclasses/smtpclass/smtp_message.php";
require dirname(dirname(__FILE__))."/phpclasses/smtpclass/smtp.php";
require dirname(dirname(__FILE__))."/phpclasses/sasl/sasl.php";
class Mails extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
      echo '👍
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
// mail/smtp();
// mail/smtpOVH()
// mail/cleaner(to,from)
// mail/kitmail([nom, sujet, lienmessage])
  //  ';


    }



    public function smtpOvh($e)
    {

      $kit = $this->newsym('Kit');
      $message = $kit->findKit($e);


    //  print_r($e);
      $shoot = $this->smtp([
        'fromName' => $message['name'],
        'fromAddress' => $e['fromAddress'],
        //'fromAddress' => "1eecc65d83709e04049e@cloudmailin.net",
        'toName' => $e['toName'],
        'toAdress' => $e['toAdress'],
      //  'toAdress' => "garciathomas@gmail.com",
        'subject' => $message['subject'],
        'htmlMessage' => $message['htmlMessage'],
        'textMessage' => $message['textMessage'],
        'proxy' => $e['proxy'],
        'smtpHost' => "ssl0.ovh.net",
        'smtpPort' => 587,
        'smtpUser' => $e['fromAddress'],
        'smtpPassword' => "tomylyjon"
      ]);
      //if(isset($put))

      //else
        return $shoot;
    }

    public function smtpOvhBulk($e)
    {




      //print_r($e);

      $shoot = $this->smtp([
        'fromName' => $e['fromName'],
        'fromAddress' => $e['fromAddress'],
        'toName' => $e['toName'],
        'toAdress' => $e['toAdress'],
    //    'toAdress' => "garciathomas@gmail.com",
        'subject' => $e['subject'],
        'htmlMessage' => $e['htmlMessage'],
        'textMessage' => $e['textMessage'],
        'proxy' => $e['proxy'],
        'smtpHost' => "ssl0.ovh.net",
        'smtpPort' => 587,
        'smtpUser' => $e['smtpUser'],
        'smtpPassword' => "tomylyjon",
        'useragent' => $e['useragent'],
        'order' => $e['order'],
      ]);

        return $shoot;
    }

    public function smtp($e)
    {
      //print_r($e);
      /*
      $this->smtp([
        fromName => "Sophie",
        fromAddress => "coucou@lkpg.fr",
        toName => "thomas",
        toAdress => "garciathomas@gmail.com",
        subject => "coucou",
        htmlMessage => "hey",
        textMessage => "hey",
        proxy => "109.73.79.145:80",
        smtpHost => "ssl0.ovh.net",
        smtpPort => 587,
        smtpUser => "coucou@lkpg.fr",
        smtpPassword => "tomylyjon",
        ssl => 0,
        tls => 0,
        useragent => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; InfoPath.2; MSOffice 14)",
        smtpDebug => 0,
        smtpHtmlDebug => 0
      ])
      */
     $e['useragent'] = $this->userAgent();
     $useragent = $e['useragent'];
     //print_r($useragent);
     $order = $e['order'];
     $from_name= $e['fromName'];
     $from_address=$e['fromAddress'];                                              $sender_line=__LINE__;
     $to_name=$e['toName'];
     $to_address=$e['toAdress'];                                                $recipient_line=__LINE__;
     $subject= 	$e['subject'];
     $html_message=$e['htmlMessage'];
     $text_message=$e['textMessage'];
     $proxy=$e['proxy']; //ifnotexist
     $smtp_host=$e['smtpHost'];
     $smtp_port=$e['smtpPort'];
     $smtp_user=$e['smtpUser'];
     $smtp_password=$e['smtpPassword'];
     if(!isset($e['ssl']))$ssl = 0; else $ssl=$e['ssl'];
     if(!isset($e['tls']))$tls = 0; else $tls=$e['tls'];
    // if(isset($e['useragent']))$useragent=$e['useragent'];
     if(!isset($e['smtpDebug']))$smtp_debug = 1; else $smtp_debug=$e['smtpDebug'];
     if(!isset($e['smtpHtmlDebug']))$smtp_html_debug = 1; else $smtp_html_debug=$e['smtpHtmlDebug'];

     $reply_name=$from_name;
     $r = explode("@",$from_address);

     //$reply_address="noreply@".$r[1];
     $reply_address=$from_address;
     $error_delivery_name=$from_name;
     $error_delivery_address=$from_address;
     $localhost = explode("@",$from_address);
     $localhost = $localhost[1];

     $to_address = str_replace(" ","",$to_address);

     if(strlen($from_address)==0)
       die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
     if(strlen($to_address)==0)
       die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

     $email_message=new smtp_message_class;

     if(isset($proxy))
     {
       $proxy=explode(":",$proxy);
       //print_r($proxy);
       $email_message->smtp_http_proxy_host_name=$proxy[0];
       $email_message->smtp_http_proxy_host_port=$proxy[1];
     }

     $email_message->localhost=$localhost;
     $email_message->smtp_host=$smtp_host;
     $email_message->smtp_port=$smtp_port;
     $email_message->smtp_ssl=$ssl;
     $email_message->smtp_start_tls=$tls;
     $email_message->user_agent=$useragent;
     $email_message->smtp_user=$smtp_user;
     $email_message->smtp_password=$smtp_password;
     $email_message->smtp_debug=$smtp_debug;
     $email_message->smtp_html_debug=$smtp_html_debug;
     $email_message->maximum_bulk_deliveries=100;
     /* Change this variable if you need to connect to SMTP server via an SOCKS server */
   //	$email_message->smtp_socks_host_name = '216.158.218.73';
   	/* Change this variable if you need to connect to SMTP server via an SOCKS server */
   //	$email_message->smtp_socks_host_port = 12216;
   	/* Change this variable if you need to connect to SMTP server via an SOCKS server */
   //	$email_message->smtp_socks_version = '';


     $email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);
     $email_message->CreateQuotedPrintableTextPart($email_message->WrapText($text_message),"",$text_part);

     $alternative_parts=array(
       $text_part,
       $html_part
     );
     $email_message->CreateAlternativeMultipart($alternative_parts,$alternative_part);

     $related_parts=array(
       $alternative_part,


     );
     $email_message->AddRelatedMultipart($related_parts);

     if(isset($order))
      $rand = explode(",",$order);
     else {
       $rand = [1,2,3,4,5,6,7];
       shuffle($rand);
     }




     foreach($rand as $key => $num)
     {
     //	if($num == 0 && $mailhtml['type'] == 0)
     //\\$email_message->AddFilePart($image_attachment);
       if($num == 1)
         $email_message->SetEncodedEmailHeader("To",$to_address,$to_name);
       else if($num == 2)
         $email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
       else if($num == 3)
         $email_message->SetHeader("Return-Path",$error_delivery_address);
       else if($num == 4)
         $email_message->SetEncodedEmailHeader("Errors-To",$error_delivery_address,$error_delivery_name);
       else if($num == 5)
         $email_message->SetEncodedHeader("Subject",$subject);
       else if($num == 6)
         $email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
       //else if($num == 7)
         //$email_message->AddQuotedPrintableTextPart($email_message->WrapText($message));
     }
    // print_r($email_message);
         $hb = $email_message->SendHB();

         $codemail = $this->createfile($hb,$e);
         $error = $this->send($codemail,$e);
         print_r($e['smtpUser']);
         if($error == "error")
         {
           return("error");
         }else{
           return('ok');
         }

    }

    public function send($codemail,$e)
    {
      //-A "'.$e['useragent'].'"
      $return = shell_exec('curl --header "host: webalchimiste.net" -A "Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; MSOffice 12)" --url "smtps://smtp.mail.yahoo.com:465" --mail-from "'.$e['smtpUser'].'" --mail-rcpt "'.$e['toAdress'].'" --user "'.$e['smtpUser'].':'.$e['smtpPassword'].'" --insecure --upload-file '.dirname(dirname(__FILE__)).'/mime/'.$codemail.'.txt --verbose 2>&1
  ');
      print_r($return);
      unlink(dirname(dirname(__FILE__)).'/mime/'.$codemail.'.txt');
      $findme   = 'to host smtp.mail.yahoo.com left intact';
      $pos = strpos($return, $findme);
      if ($pos === false) {
          return("error");
      } else {
          return("ok");
      }
    }
    public function createfile($hb,$e)
    {
      $codemail = explode("boundary=",$hb['header']['Content-Type']);
      $codemail = str_replace('"',"",$codemail[1]);
      $mime = "";
      /*foreach($hb['header'] as $k=>$v)
      {
        if( $k == "From"||  $k == "To" )
      //  $preparemime[] = $k.": ".$v."\n";
    }*/
      $preparemime[] = "Subject: hello \n";
      $preparemime[] = "From: \"jean\" <".$e['smtpUser']."> \n";
      $preparemime[] = "To: \"jean\" <".$e['toAdress']."> \n";
      /*//$preparemime[] = "X-Mailer: Benchmail Agent \r\n";
      $preparemime[] .= "Message-ID: <" . md5(uniqid(time())) . "@yahoo.com>\n";
      //$headers .= "Date: ".date("D, d M Y H:i:s") . " UT\n"; //a valid header for comparison
      $preparemime[] .= "Date: ".date("r")."\r\n"; // intentionally bogus email header
      $preparemime[] .= "X-Priority: 3\r\nX-MSMail-Priority: Normal\r\n";
      $preparemime[] .= "X-Mailer: PHP/".phpversion()."\r\n";
      $preparemime[] .= "\r\n";
      /*Return-Path: sicardnurni1980@yahoo.com
      Content-Type: multipart/related; boundary="aa749d600db29f5046faddf17590d5eb"
      Errors-To: Louane M <sicardnurni1980@yahoo.com>
      MIME-Version: 1.0
      From: Louane M <sicardnurni1980@yahoo.com>
      Subject: Tu es dispo ce vendedi soir
      To: =?utf-8?q?mrsoyer=40me.com?= <mrsoyer@me.com>
      Reply-To: Louane M <sicardnurni1980@yahoo.com>*/

      shuffle($preparemime);
      foreach($preparemime as $k=>$v)
        $mime .= $v;


      $mime .= "\n\n";
      $mime .= "yomen";
      $write = dirname(dirname(__FILE__)).'/mime/'.$codemail.'.txt';
      $fp = fopen($write."2", 'w');
      fwrite($fp, $mime);
      fclose($fp);
      rename($write."2", $write);
      return $codemail;
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
}
