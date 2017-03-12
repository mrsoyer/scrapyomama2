<?php
/*
 * test_smtp_message.php
 *
 * @(#) $Header: /opt2/ena/metal/mimemessage/test_smtp_message.php,v 1.15 2011/03/09 07:48:52 mlemos Exp $
 *
 */
 function spinnage($text){
 
        if(!preg_match("/{/si", $text)) {
 
        return $text;
 
         }
                else {
        preg_match_all("/\{([^{}]*)\}/si", $text, $matches);
        $occur = count($matches[1]);
        for ($i=0; $i<$occur; $i++)
        {
                $word_spinning = explode("|",$matches[1][$i]);
                shuffle($word_spinning);
                $text = str_replace($matches[0][$i], $word_spinning[0], $text);
        }
return  spinnage($text);
        }
 
}

 $pseudo = $_REQUEST['pseudo'];
 $domaine = $_REQUEST['domaine'];
 $to = $_REQUEST['to'];
 $smtp = $_REQUEST['smtp'];
 $age = $_REQUEST['age'];
  $id = $_REQUEST['id'];
  $proxy = explode(":",$_REQUEST['proxy']);
  


	require("email_message.php");
	require("smtp_message.php");
	require("smtp.php");
	/* Uncomment when using SASL authentication mechanisms */
	

	require("sasl/sasl.php");
	/**/

	$from_name=$pseudo;
	$from_address=$smtp;                                              $sender_line=__LINE__;
	$reply_name=$from_name;
	$reply_address=$smtp;
	$reply_address=$smtp;
	$error_delivery_name=$pseudo;
	$error_delivery_address=$smtp;
	$to_name=explode("@",$to);
	$to_name=$to_name[0];
	$to_address=$to;                                                $recipient_line=__LINE__;
	$subject=spinnage("{Salut toi,|Hey,|Coucou,|Bonjour Jeune Homme| Hello :),|Salut Salut|Holla :)}");;
	//$message="Hello ".strtok($to_name," ").",\n\nThis message is just to let you know that your SMTP e-mail sending class is working as expected.\n\nThank you,\n$from_name";

	if(strlen($from_address)==0)
		die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
	if(strlen($to_address)==0)
		die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");

	$email_message=new smtp_message_class;

	/* This computer address */
	$email_message->localhost=$domaine;

	/* SMTP server address, probably your ISP address,
	 * or smtp.gmail.com for Gmail
	 * or smtp.live.com for Hotmail */
	$email_message->smtp_host="ssl0.ovh.net";

	/* SMTP server port, usually 25 but can be 465 for Gmail */
	$email_message->smtp_port=587;

	/* Use SSL to connect to the SMTP server. Gmail requires SSL */
	$email_message->smtp_ssl=0;

	/* Use TLS after connecting to the SMTP server. Hotmail requires TLS */
	$email_message->smtp_start_tls=0;

	/* Change this variable if you need to connect to SMTP server via an HTTP proxy */
	$email_message->smtp_http_proxy_host_name=$proxy[0];
	/* Change this variable if you need to connect to SMTP server via an HTTP proxy */
	$email_message->smtp_http_proxy_host_port=$proxy[1];

	/* Change this variable if you need to connect to SMTP server via an SOCKS server */
	$email_message->smtp_socks_host_name = '';
	/* Change this variable if you need to connect to SMTP server via an SOCKS server */
	$email_message->smtp_socks_host_port = 1080;
	/* Change this variable if you need to connect to SMTP server via an SOCKS server */
	$email_message->smtp_socks_version = '5';


	/* Deliver directly to the recipients destination SMTP server */
	$email_message->smtp_direct_delivery=0;

	/* In directly deliver mode, the DNS may return the IP of a sub-domain of
	 * the default domain for domains that do not exist. If that is your
	 * case, set this variable with that sub-domain address. */
	$email_message->smtp_exclude_address="";

	/* If you use the direct delivery mode and the GetMXRR is not functional,
	 * you need to use a replacement function. */
	/*
	$_NAMESERVERS=array();
	include("rrcompat.php");
	$email_message->smtp_getmxrr="_getmxrr";
	*/

	/* authentication user name */
	$email_message->smtp_user=$smtp;

	/* authentication password */
	$email_message->smtp_password="tomylyjon";

	/* if you need POP3 authetntication before SMTP delivery,
	 * specify the host name here. The smtp_user and smtp_password above
	 * should set to the POP3 user and password*/
	$email_message->smtp_pop3_auth_host="";

	/* authentication realm or Windows domain when using NTLM authentication */
	$email_message->smtp_realm="";

	/* authentication workstation name when using NTLM authentication */
	$email_message->smtp_workstation="";

	/* force the use of a specific authentication mechanism */
	$email_message->smtp_authentication_mechanism="";

	/* Output dialog with SMTP server */
	$email_message->smtp_debug=1;

	/* if smtp_debug is 1,
	 * set this to 1 to make the debug output appear in HTML */
	$email_message->smtp_html_debug=1;

	/* If you use the SetBulkMail function to send messages to many users,
	 * change this value if your SMTP server does not accept sending
	 * so many messages within the same SMTP connection */
	$email_message->maximum_bulk_deliveries=100;
	$email_message->SetEncodedEmailHeader("To",$to_address,$to_name);
	$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
	$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
	$email_message->SetHeader("Return-Path",$error_delivery_address);
	$email_message->SetEncodedEmailHeader("Errors-To",$error_delivery_address,$error_delivery_name);
	if(defined("PHP_OS")
	&& strcmp(substr(PHP_OS,0,3),"WIN"))
		$email_message->SetHeader("Return-Path",$error_delivery_address);

	$email_message->SetEncodedHeader("Subject",$subject);

/*
 *  An HTML message that requires any dependent files to be sent,
 *  like image files, style sheet files, HTML frame files, etc..,
 *  needs to be composed as a multipart/related message part.
 *  Different parts need to be created before they can be added
 *  later to the message.
 *
 *  Parts can be created from files that can be opened and read.
 *  The data content type needs to be specified. The can try to guess
 *  the content type automatically from the file name.
 */

	$html_message="hello comment vas tu, moi c'est aurelie... bisous  ";
	$email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);

/*
 *  It is strongly recommended that when you send HTML messages,
 *  also provide an alternative text version of HTML page,
 *  even if it is just to say that the message is in HTML,
 *  because more and more people tend to delete HTML only
 *  messages assuming that HTML messages are spam.
 */
	$text_message="hello comment vas tu, moi c'est aurelie... bisous ";
	$email_message->CreateQuotedPrintableTextPart($email_message->WrapText($text_message),"",$text_part);

/*
 *  Multiple alternative parts are gathered in multipart/alternative parts.
 *  It is important that the fanciest part, in this case the HTML part,
 *  is specified as the last part because that is the way that HTML capable
 *  mail programs will show that part and not the text version part.
 */
	$alternative_parts=array(
		$text_part,
		$html_part
	);
	$email_message->CreateAlternativeMultipart($alternative_parts,$alternative_part);

/*
 *  All related parts are gathered in a single multipart/related part.
 */
	$related_parts=array(
		$alternative_part,
		
		
	);
	$email_message->AddRelatedMultipart($related_parts);

/*
 *  One or more additional parts may be added as attachments.
 *  In this case a file part is added from data provided directly from this script.
 */
	

/*
 *  The message is now ready to be assembled and sent.
 *  Notice that most of the functions used before this point may fail due to
 *  programming errors in your script. You may safely ignore any errors until
 *  the message is sent to not bloat your scripts with too much error checking.
 */
	$error=$email_message->Send();
	if(strcmp($error,""))
		echo "Error: $error\n";
	else
		echo "ok";
?>