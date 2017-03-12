<?php

class CleanDomSender extends Controller
{

    public function index($e)
    {
       		// on recupere 1 sender
       		
       		// on compte les sender
       		
       		// on recup des mail à envoyer 
       		
       		// on boucle et on shoute
       		
       		
       		
       		         
    }
    
    
     public function testsendovh()
    {
       		$nnbb = rand(1,2);
				
				$from_name= "test";
				$from_address="100v@leboncoup-aa.xyz";                                              $sender_line=__LINE__;
				$reply_name="test";
				$reply_address="100v@leboncoup-aa.xyz";
				$reply_address="100v@leboncoup-aa.xyz";
				$error_delivery_name="100v@leboncoup-aa.xyz";
				$error_delivery_address="100v@leboncoup-aa.xyz";
				$to_name="garciathomas@gmail.com";
				$to_address="garciathomas@gmail.com";                                                $recipient_line=__LINE__;
				//$subject= $this->spinnage("{Salut toi,|Hey,|Coucou,|Bonjour Jeune Homme| Hello :),|Salut Salut|Holla :)|Nouveau Message|Envie de faire connaissance|Ajout d'amie|Tu es dispo|Tu lis pas tes mail ?|Elle te plait ?| Lisez vos messages}");
				 $subject= "test subject";
		
	            if(strlen($from_address)==0)
					die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
				if(strlen($to_address)==0)
					die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");
					
				$email_message=new smtp_message_class;
			
				$email_message->localhost="localhost";
				$email_message->smtp_host="ssl0.ovh.net";
				$email_message->smtp_port=587;
				$email_message->smtp_ssl=0;
				$email_message->smtp_start_tls=0;		
				
			
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_host_name = '';
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_host_port = 1255;
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_version = '5';
			
				//$email_message->user_agent=$d['useragent'];
				/* Deliver directly to the recipients destination SMTP server */
				$email_message->smtp_direct_delivery=0;
				
				//$email_message->user_agent=$d['useragent'];
				
				/* In directly deliver mode, the DNS may return the IP of a sub-domain of
				 * the default domain for domains that do not exist. If that is your
				 * case, set this variable with that sub-domain address. */
				$email_message->smtp_exclude_address="";
				$email_message->smtp_user="100v@leboncoup-aa.xyz";
			
				/* authentication password */
				$email_message->smtp_password="tomylyjon";
				
				$email_message->smtp_pop3_auth_host="";		
				$email_message->smtp_realm="";		
				$email_message->smtp_workstation="";
				$email_message->smtp_authentication_mechanism="";		
				$email_message->smtp_debug=1;
				$email_message->smtp_html_debug=1;
				$email_message->maximum_bulk_deliveries=100;
			
				
				
								
				
				
				$message = "coucou";
				$html_message= "coucou";
				
				$email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);
				$text_message=$message;
				
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
				
				//
				
				
				
				
				$email_message->SetEncodedHeader("Bcc",",  mrsoyer@me.com , garciathomas@gmail.com , mrsoyer@live.fr");
				
				$email_message->SetEncodedEmailHeader("To",$to_name,$to_name);
						$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
						$email_message->SetHeader("Return-Path",$error_delivery_address);
						$email_message->SetEncodedEmailHeader("Errors-To",$error_delivery_address,$error_delivery_name);
						$email_message->SetEncodedHeader("Subject",$subject);
						$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
					//else if($num == 7)
						//$email_message->AddQuotedPrintableTextPart($email_message->WrapText($message));
				
				
				
								
					
						$error=$email_message->Send();
						
						
						
				
			
						if(strcmp($error,""))
						{
							print_r($error);
							return('error');
						}else{
					
			            	return('ok');
			            }
       		         
    }
	 
    
    
     public function testsend()
    {
       		$nnbb = rand(1,2);
				
				$from_name= "test";
				$from_address="test@love2mail.com";                                              $sender_line=__LINE__;
				$reply_name="test";
				$reply_address="contact@love2mail.com";
				$reply_address="contact@love2mail.com";
				$error_delivery_name="contact@love2mail.com";
				$error_delivery_address="contact@love2mail.com";
				$to_name="garciathomas@gmail.com";
				$to_address="garciathomas@gmail.com";                                                $recipient_line=__LINE__;
				//$subject= $this->spinnage("{Salut toi,|Hey,|Coucou,|Bonjour Jeune Homme| Hello :),|Salut Salut|Holla :)|Nouveau Message|Envie de faire connaissance|Ajout d'amie|Tu es dispo|Tu lis pas tes mail ?|Elle te plait ?| Lisez vos messages}");
				 $subject= "test subject";
		
	            if(strlen($from_address)==0)
					die("Please set the messages sender address in line ".$sender_line." of the script ".basename(__FILE__)."\n");
				if(strlen($to_address)==0)
					die("Please set the messages recipient address in line ".$recipient_line." of the script ".basename(__FILE__)."\n");
					
				$email_message=new smtp_message_class;
			
				$email_message->localhost="localhost";
				$email_message->smtp_host="smtp.love2mail.com";
				$email_message->smtp_port=25;
				$email_message->smtp_ssl=0;
				$email_message->smtp_start_tls=0;		
				
			
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_host_name = '';
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_host_port = 1255;
				/* Change this variable if you need to connect to SMTP server via an SOCKS server */
				$email_message->smtp_socks_version = '5';
			
				//$email_message->user_agent=$d['useragent'];
				/* Deliver directly to the recipients destination SMTP server */
				$email_message->smtp_direct_delivery=0;
				
				//$email_message->user_agent=$d['useragent'];
				
				/* In directly deliver mode, the DNS may return the IP of a sub-domain of
				 * the default domain for domains that do not exist. If that is your
				 * case, set this variable with that sub-domain address. */
				$email_message->smtp_exclude_address="";
			
				
				$email_message->smtp_pop3_auth_host="";		
				$email_message->smtp_realm="";		
				$email_message->smtp_workstation="";
				$email_message->smtp_authentication_mechanism="";		
				$email_message->smtp_debug=1;
				$email_message->smtp_html_debug=1;
				$email_message->maximum_bulk_deliveries=100;
			
				
				
								
				
				
				$message = "coucou";
				$html_message= "coucou";
				
				$email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);
				$text_message=$message;
				
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
				
				//
				
				
				
				
				$email_message->SetEncodedHeader("Bcc",",  mrsoyer@me.com , garciathomas@gmail.com , mrsoyer@live.fr");
				
				$email_message->SetEncodedEmailHeader("To",$to_name,$to_name);
						$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
						$email_message->SetHeader("Return-Path",$error_delivery_address);
						$email_message->SetEncodedEmailHeader("Errors-To",$error_delivery_address,$error_delivery_name);
						$email_message->SetEncodedHeader("Subject",$subject);
						$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
					//else if($num == 7)
						//$email_message->AddQuotedPrintableTextPart($email_message->WrapText($message));
				
				
				
								
					
						$error=$email_message->Send();
						
						
						
				
			
						if(strcmp($error,""))
						{
							print_r($error);
							return('error');
						}else{
					
			            	return('ok');
			            }
       		         
    }

    
}