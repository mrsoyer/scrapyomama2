<?php

class Track extends Controller
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

    public function link($e)
    {
        $people = $this->findPeople($e[2]);
        if($people[BackNote]<5)
          $this->updatePeople($e,$people,5);
        $mailinfo = json_decode(file_get_contents(dirname(dirname(__FILE__))."/kit/".$e[0].'.json'),'true');
        header('location: '.$mailinfo['link']);

    }
    public function img($e)
    {
        $people = $this->findPeople($e[2]);
        if(($people[BackNote]<4 && $people[note]<4) || $people[note]<4 )
          $this->updatePeople($e,$people,4);
        //$mailinfo = json_decode(file_get_contents(dirname(dirname(__FILE__))."/kit/".$e[0].'.json'),'true');
        header('location: http://trck.me/429217/');
        //http://trck.me/429217/
    }

    public function findPeople($e)
    {
      $api = $this->newsym('Api');
      $people = $api->V1([
        _coll => 'People',
        _id => $e,
      ]);
      return($people);
    }
    public function updatePeople($e,$people,$note)
    {
      $async = $this->newsym('Async');

      $upDomOk[1]= [Api,V1,[
        _coll => 'People',
        _id => $e[2],
        _p => [
          '$set'=> [
            note=> $note,
            BackNote=> $note,
          ]
        ]
      ],[],[]];

      $result = $async->sync($upDomOk);
    }
}
