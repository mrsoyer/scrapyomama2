<?php

class Kit extends Controller
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

    public function findKit($params)
    {
        $file = scandir(dirname(dirname(__FILE__))."/kit/");
        //print_r($file);
        foreach($file as $k=>$v)
        {
          $fileArray = explode(".",$v);
          if($fileArray[1] == 'json')
          {
            $listfile[] = $fileArray;
          }
        }


          $fileArray = $listfile[rand(0,count($listfile)-1)];

          $mailinfo = json_decode(file_get_contents(dirname(dirname(__FILE__))."/kit/".$fileArray[0].'.json'),'true');
        //  print_r($mailinfo);
          $mailHtml = file_get_contents(dirname(dirname(__FILE__))."/kit/".$fileArray[0].'.html');
          foreach($params as $key=>$value)
          {
            $mailHtml = str_replace("{{".$key."}}", $value,$mailHtml);
            $mailinfo['message'] = str_replace("{{".$key."}}", $value,$mailinfo['message']);
            $mailinfo['sujet'] = str_replace("{{".$key."}}", $value,$mailinfo['sujet']);
          }
          $dest = "http://sym-env.mp2mswstzy.us-east-1.elasticbeanstalk.com/";
          $arg = "".$fileArray[0]."/".$params['domid'].'/'.$params[peopleid].'/';
          $link = $dest."Track/link/".$arg;
          $mailHtml = str_replace("{{link}}", $link,$mailHtml);
          $mailHtml .="<img src=".$dest.'img/'.$arg." width='1px' height='1px'>";

          $message[name] = $mailinfo['name'];
          $message[subject] = $mailinfo['sujet'];
          $message[htmlMessage] = $mailHtml;
          $message[textMessage] = $mailinfo['message'];

          //print_r($message);
          return($message);


    }
}
