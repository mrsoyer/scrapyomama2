<?php

class Rotator extends Controller
{
    public $name = 'cards';

    public function index($e)
    {

    }

    public function shoot($sym)
    {
       $async = $this->newsym('Async');
        print_r($this->rotateIp($sym));
        $smtp = $this->thissmtp($sym);
        $people = $this->people();
        if(!isset($people['_id']['$oid'])) die();
        $shoot = $this->sendPeople($people,$sym);
        if($shoot != "ok")
        {
          $sym['e']++;
          $this->peopleKo($people);
        }
        else
          $sym['e']=0;

        $sym[1]--;
        if($sym[1]>0 && $sym['e'] < 3)
          $boom = $async->sync([['SBshoot','shoot',$e,[],['_back']]]);
    }

    public function rotateIp($sym)
    {
      shell_exec('curl -n -X DELETE https://api.heroku.com/apps/'.$sym[0].'/dynos \
    -H "Content-Type: application/json" \
    -H "Accept: application/vnd.heroku+json; version=3" \
    -H "Authorization: Bearer 79e5e2c6-dfff-4dc7-adb0-544791fd28a5"');
      return($_SERVER['SERVER_ADDR']);
    }

    public function thissmtp($sym)
    {
      $ya = explode(":",$sym[2]);
        $return['smtp'] = $ya[0];
        $return['pass'] = $ya[1];
      return $return;
    }

    private function people()
    {
      $this->loadModel('People');

      $people = $this->People->findOnePeople();
      if(isset($people['_id']['$oid']))
      {
        $nextSend = $this->nextSend($people['note']);
        $note = $this->calculNote($people);
        $pe = $people;
        $pe['nextSend'] = $nextSend;
        $people['nextSend'] = $nextSend;
        $pe['note'] = $note['note'];
        $pe['BackNote'] = $note['BackNote'];
        $this->People->updateOnePeople($pe);
      }

      return($people);
    }

    private function peopleKo($people)
    {
        $this->loadModel('People');
        $this->People->updateOnePeople($people);
    }

    private function sendPeople($people,$sym)
    {
      $shoot = $this->newsym('Mails');
      $ya = explode(":",$sym[2]);
      $kit = $this->kitCompose($sym);

      $bulk = $shoot->smtp([
        'fromName' => $kit['name'],
        'fromAddress' => $ya[0],
        'toName' => "",
      //  'toAdress' => "mrsoyer@me.com",
        'toAdress' => $people['email'],
        'subject' => $e[0].$kit['subject'],
        'htmlMessage' => $kit['html'],
        'textMessage' => $kit['subject'],
        'proxy' => "",
        'smtpHost' => "smtp.mail.yahoo.com",
        'smtpPort' => 465,
        'smtpUser' => $ya[0],
        'smtpPassword' => $ya[1],
        'ssl' => 1,
        'tls' => 0,
        'smtpDebug' => 1,
        'smtpHtmlDebug' => 1
      ]);

      return $bulk;
    }

    private function kitCompose($sym)
    {
      $parser = $this->newsym('Parser');
      $kit = $parser->kit($sym[0]);
      return($kit);
    }
}
