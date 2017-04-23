<?php
  require( 'vendor/sendinblue/sendinblue-api-bundle/Wrapper/Mailin.php');
class Sendiblue extends Controller
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

    public function test($e)
    {

      # Instantiate the client\
      $mailin = new Mailin("https://api.sendinblue.com/v2.0","ph1Tx72LKAHfmV6E");

      $data = array( "id"=>292 );

      var_dump($mailin->get_campaign_v2($data));
    }
}
