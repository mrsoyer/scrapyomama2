<?php

class Test extends Controller
{
    public $name = 'cards';

    public function index($e)
    {
    //  mail('garciathomas@gmail.com', 'Mon Sujet', "message");
    //phpinfo();
    echo file_get_contents("https://api.ipify.org?format=json");
    die();
      for ($i = 1; $i <= 5; ++$i) {
          $pid = pcntl_fork();

          if (!$pid) {
              sleep($i);
              print "In child $i\n";
              exit($i);
          }
      }

      while (pcntl_waitpid(0, $status) != -1) {
          $status = pcntl_wexitstatus($status);
          echo "Child $status completed\n";
      }
    }


}
