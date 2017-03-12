<?php
/*
 * test_html_mail_message.php
 *
 * @(#) $Header: /opt2/ena/metal/mimemessage/test_html_mail_message.php,v 1.15 2012/09/15 09:15:48 mlemos Exp $
 *
 */

	require("email_message.php");


/*
 *  Trying to guess your e-mail address.
 *  It is better that you change this line to your address explicitly.
 *  $from_address="me@mydomain.com";
 *  $from_name="My Name";
 */
	$from_address="Maryline@bienvenue-mailing-01.ovh";
	$from_name="Maryline";

	$reply_name=$from_name;
	$reply_address="webmin@bienvenue-mailing-01.ovh";
	$reply_address="webmin@bienvenue-mailing-01.ovh";
	$error_delivery_name=$from_name;
	$error_delivery_address="webmin@bienvenue-mailing-01.ovh";

/*
 *  Change these lines or else you will be mailing the class author.
 */
	$to_name="garciathomas";
	$to_address="tafoud@hotmail.fr";

	$subject="Tu acceptes notre rendez-vous  ?";
	$email_message=new email_message_class;
	$email_message->SetEncodedEmailHeader("To",$to_address,$to_name);
	$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
	$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
	$email_message->SetHeader("Sender",$from_address);
	$email_message->localhost="bienvenue-mailing-01.ovh";
/*
 *  Set the Return-Path header to define the envelope sender address to which bounced messages are delivered.
 *  If you are using Windows, you need to use the smtp_message_class to set the return-path address.
 */
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
	
 
	$html_message="<html>
<head>
<title>Tu acceptes notre rendez-vous à paris 11eme arrondissement ?</title>
<link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
</head>
<body>

<body style=\"margin:0; padding:0;\"><p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">Vous venez de recevoir 1 nouveau message:</span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">*****</span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">De :&nbsp;<a href=\"http://r.maxibonplan.com/5ex6mxehcvh8r6b7d.html\">Maryline</a></span><br />
	Le : 12/01/2017</p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">Objet : R<span style=\"color: rgb(34, 34, 34); font-family: Arial, Verdana, sans-serif;\">ejoins moi quand t&#39;es en ligne, je serai connect&eacute;e...</span></span></p>
<p align=\"left\" style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">*****</span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">Hello,</span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\"><span style=\"color: rgb(34, 34, 34); font-family: Arial, Verdana, sans-serif;\">Je suis une femme de nature calme, gentille, int&egrave;gre et respectueuse. Je n&#39;aime pas le mensonge et la perte de temps. Je ne cherche pas le plaisir d&#39;une nuit, mais une relation durable.<br />
	Je voudrais continuer &agrave; mettre des couleurs ds la vie avec un homme tol&eacute;rant, tendre avec de l&#39;humour. J&#39;aime bien partager en profondeur ce qui fait l&#39;essentiel de la vie.<br />
	Pleine de myst&egrave;res, je souhaite aller &agrave; ta rencontre avec ce que tu es. Partager les loisirs est un bon moyen pour faire connaissance.<br />
	Si tu es pret pour cette aventure, n&#39;h&eacute;site pas &agrave; me contacter&nbsp;</span>dans un premier temps (...)&nbsp;<a href=\"http://r.maxibonplan.com/5ex6mxehcw9or6b7d.html\">Lire la suite du message</a></span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\">*****</span><br />
	<br />
	<a href=\"http://r.maxibonplan.com/5ex6mxehcx24r6b7d.html\"><img src=\"http://img.maxibonplan.com/ac9lcvh8r6b7e.jpg\" style=\"color: rgb(55, 55, 55); font-family: Arial, Helvetica, sans-serif; font-weight: bold; height: 267px; width: 200px;\" /></a></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<span style=\"font-size:12px;\"><a href=\"http://r.maxibonplan.com/5ex6mxehcxukr6b7d.html\">Se connecter</a></span></p>
<p style=\"color: rgb(0, 0, 0); font-family: Tahoma, Verdana, Arial;\">
	<a href=\"http://r.maxibonplan.com/5ex6mxehcyn0r6b7d.html\">Voir son profil</a></p>
</body>


</body>
</html>


";
	$email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);

/*
 *  It is strongly recommended that when you send HTML messages,
 *  also provide an alternative text version of HTML page,
 *  even if it is just to say that the message is in HTML,
 *  because more and more people tend to delete HTML only
 *  messages assuming that HTML messages are spam.
 */
	$text_message="This is an HTML message. Please use an HTML capable mail program to read this message.";
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
		$alternative_part
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
		echo "Message sent to $to_name\n";
?>