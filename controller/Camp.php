<?php

class Camp extends Controller
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

    public function create($e)
    {
        if(!isset($e[0]))
          $e[0] = time().'campaign';
        shell_exec('cd '.dirname(dirname(__FILE__)).'/campaign/ && git clone https://github.com/mrsoyer/campaign.git '.$e[0]);
    }

    public function push($e)
    {
        $this->loadModel('Campaign');
        $time = time();
        if(!isset($e[0]))
          $e[0] = time().'campaign';
        $shell = shell_exec('cd '.dirname(dirname(__FILE__)).'/campaign/'.$e[0].' \
        && heroku create c'.$time.$e[0].' \
        && git push heroku master \
        && heroku ps:scale web=1 \
        && heroku ps:resize web=standard-1x \
        && heroku addons:create cloudmailin:developer');

        $mail = explode("Your CloudMailin email address (",$shell);
        $mail = explode(") is ready to use.",$mail[1]);
        $mail = $mail[0];
        $link = 'c'.$time.$e[0].'.herokuapp.com';
        if(isset($mail))
        {
          echo "email = ".$mail."\n";
          echo "link = ".$link."\n";
          $info = json_decode(file_get_contents(dirname(dirname(__FILE__))."/campaign/".$e[0].'/info.json'),'true');
          $info['email'] = $mail;
          $info['campName'] = $e[0];
          $info['timeName'] = $time.$e[0];
          $info['link'] = $link;
          $info['count'] = 0;
          $info['create'] = $time;
          $info['kit'] = file_get_contents(dirname(dirname(__FILE__))."/campaign/".$e[0].'/kit.html');
          $this->Campaign->newCamp($info);
        }
        else
        {
          echo "error";
        }

    }
}
