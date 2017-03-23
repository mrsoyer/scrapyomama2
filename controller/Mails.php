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


      print_r($e);
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




      print_r($e);

      $shoot = $this->smtp([
        'fromName' => $e['fromName'],
        'fromAddress' => $e['fromAddress'],
        'toName' => $e['toName'],
      //  'toAdress' => $e['toAdress'],
        'toAdress' => "garciathomas@gmail.com",
        'subject' => $e['subject'],
        'htmlMessage' => $e['htmlMessage'],
        'textMessage' => $e['textMessage'],
        'proxy' => $e['proxy'],
        'smtpHost' => "ssl0.ovh.net",
        'smtpPort' => 587,
        'smtpUser' => $e['smtpUser'],
        'smtpPassword' => "tomylyjon"
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
     $ssl=$e['ssl'];//ifnotexist
     $tls=$e['tls'];//ifnotexist
     $useragent=$e['useragent'];//ifnotexist
     $smtp_debug=$e['smtpDebug'];//ifnotexist
     $smtp_html_debug=$e['smtpHtmlDebug'];//ifnotexist

     $reply_name=$from_name;
     $reply_address=$from_address;
     $error_delivery_name=$from_name;
     $error_delivery_address=$from_address;
     $localhost = explode("@",$from_address);
     $localhost = $localhost[1];

     $to_address = str_replace(" ","",$to_address);
     if(!isset($ssl))$ssl = 0;
     if(!isset($tls))$tls = 0;
     if(!isset($useragent))$useragent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; InfoPath.2; MSOffice 14)";
     if(!isset($smtp_debug))$smtp_debug = 0;
     if(!isset($smtp_html_debug))$smtp_html_debug = 0;

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

     $rand = [1,2,3,4,5,6,7];
     shuffle($rand);




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
         $error=$email_message->Send();
         if(strcmp($error,""))
         {
           return($error);
         }else{
           return('ok');
         }

    }
}
