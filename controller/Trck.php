<?php

class Trck extends Controller
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

        //$people = $this->findPeople($e[2]);
        $this->loadModel('People');
        $people = $this->People->peopleDetail($e[2]);
        if($people['BackNote']<5)
          $this->People->updatePeopleNote($e[2],5);

    }
    public function img($e)
    {
      $this->loadModel('People');
      $people = $this->People->peopleDetail($e[2]);
        if(($people['BackNote']<4 && $people['note']<=4) || $people['note']<4 )
          $this->People->updatePeopleNote($e[2],4);


    }


}
