<?php

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

    public function shoot($e)
    {
        $shoot = $this->newsym('Mails');
        echo $shoot->smtp([
          fromName => "Sophie",
          fromAddress => "lairganmate1977@yahoo.com",
          toName => "thomas",
          toAdress => "garciathomas@gmail.com",
          subject => "coucou",
          htmlMessage => "hey <a href='https://c1490873022thetest.herokuapp.com/Trck/link/thetest/58de102ca678742fd56adf24/58bad87ec2ef162f4b4bf415/#5ex6mxesux5or6b7d.html'>link</a>",
          textMessage => "hey",
          proxy => "",
          smtpHost => "smtp.mail.yahoo.com",
          smtpPort => 465,
          smtpUser => "lairganmate1977@yahoo.com",
          smtpPassword => "4Oom2BWPAy",
          ssl => 1,
          tls => 0,
          useragent => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; InfoPath.2; MSOffice 14)",
          smtpDebug => 1,
          smtpHtmlDebug => 1
        ]);
        if($e[0]>0)
        {
        //  sleep(1);
          $e[0]--;
          //$this->shoot($e);
        }

    }
}
