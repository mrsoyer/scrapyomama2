<?php

class SBasync extends Controller
{

  public function index()
  {
  print_r("ok");

  
      $async = $this->newsym('Async');
print_r("ok");
        $reponse =   $async->sync([

              [SBasync, wait, [5],[],[_print,_async]],
              [SBasync, wait, [1],[],[_print,_async]],
              [SBasync, wait, [5],[],[_print,_async]]

          ]);


print_r("ok");

          //print_r($reponse);
        /*$reponse = $async->sync(
          [
            [SBasync, wait, [10]],
            [SBasync, wait, [5]],
            [SBasync, wait, [20]]
          ]);*/
      //  print_r($reponse);
    }

    public function sayHello()
    {
      $func = 'php '.dirname(dirname(__FILE__)).'/webroot/index.php  SBasync wait 2';
      $write = dirname(dirname(__FILE__)).'/tmp/r-test.txt';
      //exec('var=$('.$func.') && echo $var > '.$write);
      $json = exec($func);
      echo "<br> -- exec:".$json."</br>";

      $json = shell_exec($func);
      echo "<br> -- shell_exec:".$json."</br>";

      $fp = fopen($write, 'w');
      fwrite($fp, $json);
      fclose($fp);
      echo "<br> -- writetest:".$write."</br>";

      $fgc = file_get_contents($write);

      echo "<br> -- filegetcontent:".$fgc."</br>";
      exec($func.' > /dev/null &');
    }

    public function ok($e)
    {
      return "ok";
    }

    public function ul()
    {
      unlink(dirname(dirname(__FILE__)).'/tmp/r-test.txt');
    }
    public function wait($i)
    {


        sleep($i[0]);




      return($i);
    }
}
