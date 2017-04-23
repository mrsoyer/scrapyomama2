<?php

class Addmail extends Controller
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

    public function addovh()
    {
      $ovh = $this->newsym("OvhApi");
      $this->loadModel('Smtpm');
      $i = 1000;
      while($i)
      {
        $name = $this->t();
        try {
          print_r($ovh->createMail("mailin7856.ovh",$name));
          //$listmailadd[] = $name."@".$dom[0][domain];
        //  $this->Smtpm->addMail([$name."@43hjhj-mailbox.ovh","tomylyjon"]);
          $i++;

        }catch (Exception $e) {
            $error++;
        }
        $i--;
      }

    }

    public function addovhm()
    {
      $ovh = $this->newsym("OvhApi");
      $this->loadModel('Smtpm');
      $i = 1000;
      $list = $ovh->listMail("mailin7853.ovh");
      foreach($list as $k=>$name)
      {
        //$name = $this->t();
        try {
          //print_r($ovh->createMail("mailbox678678.ovh",$name));
          //$listmailadd[] = $name."@".$dom[0][domain];
          $this->Smtpm->addMail([$name."@mailin7853.ovh","tomylyjon"]);
          $i++;

        }catch (Exception $e) {
            $error++;
        }
        $i--;
      }

    }

    public function t()
    {
      $l = str_split("1234567890azertyuiopqsdfghjklmwxcvbn");
      shuffle($l);
      return $l[0].$l[1].$l[2].$l[3].$l[4]."-MailBox-".$l[5].$l[6].$l[7].$l[8].$l[9];
    }

    public function mailList($e)
    {
        $mail = "safogistdel1971@yahoo.com:8MpYx8Wpoa:9636274847
tilepyra1988@yahoo.com:aOdeT3aHZV:9067977429
tiwolfcitnuss1985@yahoo.com:plxlCjuJbc:9636350341
caldievanti1986@yahoo.com:IHCeOij9pd:9636369546
roisympthephi1988@yahoo.com:Oj2GWQOikb:9067977375
reamevalbio1983@yahoo.com:ZoSmxrEQcC:9652261044
rowesgelib1978@yahoo.com:SwANnCVSvW:9688826325
hoddruforde1989@yahoo.com:XWJZ8Wz7vL:9067964768
esulenstib1988@yahoo.com:KEZu8Dd5BK:9636374973
ocamfeebi1976@yahoo.com:2hAQPvIaiV:9652112068
piorimsizi1972@yahoo.com:EdyqgMJIIU:9636371799
bursiebarre1972@yahoo.com:S3fle11Ut6:9652136082
penmotame1973@yahoo.com:8RFwtm2DZv:9067978601
catchfivika1981@yahoo.com:2svjJ9PVto:9652258986
saitolapa1981@yahoo.com:5g0dShCwun:9652141538
newcipada1985@yahoo.com:VFIA5reaFZ:9636347591
niemumany1978@yahoo.com:4BLoD4X0Fw:9636344498
evopahup1983@yahoo.com:vxwea0ehHy:9636371542
sackforlaco1976@yahoo.com:bv6fS7pC8C:9067963154
weidjerarloo1978@yahoo.com:ZGPvJYwjQL:9067979523
stochlampfoli1984@yahoo.com:UOjecYSgEn:9636261810
stilastuterr1971@yahoo.com:ng9VuTH9Cv:9652259781
mailerittre1974@yahoo.com:2KLqgff3J3:9067963674
dimgacance1984@yahoo.com:7Yq2jAzxL2:9067975693
rihenthamatt1970@yahoo.com:1HgGBEQl5s:9067964599
chadagene1980@yahoo.com:B884Y9PCba:9067973795
emquancalea1979@yahoo.com:AwNxTkPS7z:9636374968
backretourbadd1981@yahoo.com:Tbhfiuo7JL:9652135280
rifeparro1970@yahoo.com:DPJX3zERzY:9652152307
comtorrtaja1971@yahoo.com:hGf3JyksxK:9652142804
mufffercaba1989@yahoo.com:YdWJo5CDY7:9652137807
saispotemir1973@yahoo.com:SgggHSxBEi:9652254909
welmoreki1981@yahoo.com:KAZhBudJye:9652133634
apcyhafa1976@yahoo.com:UXF40Ugs0D:9636271885
telingmulpe1972@yahoo.com:VBSbUamh89:9636343420
chantsdirsylo1972@yahoo.com:0OYen4rb7e:9636359093
cawiformu1980@yahoo.com:FV3dup3Pob:9067970898
stocanimon1970@yahoo.com:FUbgzb9gl7:9636356547
rionairiada1972@yahoo.com:vJuEXxzswd:9636282317
sicklorepan1988@yahoo.com:2WkOteMpjf:9636359707
clearopagnu1986@yahoo.com:zWEFRsXrfn:9652256075
marratangter1971@yahoo.com:xCV54xVvol:9067978158
ciopristherwho1987@yahoo.com:trFpt45zLH:9067962988
bullverswasccom1972@yahoo.com:abf7hvFhqq:9636295781
lefchamistai1973@yahoo.com:toxzKMbIKI:9652110307
diowhunperfge1986@yahoo.com:Ecdi4xmC0u:9636313088
frosextragar1978@yahoo.com:NBweOzLxOh:9636274847
suimanrowind1971@yahoo.com:U0t7KORptM:9636375795
dychartcola1981@yahoo.com:hpi8awCHk7:9652131049
parjostsosymp1979@yahoo.com:xNbItjWTDG:9067976401
kanncuvegkohl1975@yahoo.com:uYY3xGYNV6:9067977375
sipesosland1975@yahoo.com:FKxw2Z46U3:9636310618
growactonse1981@yahoo.com:pRhuSdtc2c:9636374973
olunadar1972@yahoo.com:MFdx2PaE8Z:9636261810
punklicata1980@yahoo.com:QlwD7kJvY8:9652258986
uneratel1974@yahoo.com:0qgATTbbrb:9652141538
walolower1976@yahoo.com:8KZ87UWMva:9067966170
leithumbcadla1988@yahoo.com:9Ct6458ga8:9652112875
findticatse1985@yahoo.com:7OBH0mnYGx:9067978575
ipunidin1984@yahoo.com:5uWro3NCUe:9636347591
dumpfarclilo1975@yahoo.com:LwMa1bmNDF:9636356811
ciofiresing1987@yahoo.com:mpBWoOSgFw:9652113460
mauladerda1989@yahoo.com:Pz4Moa3nKP:9067967095
reinegmago1973@yahoo.com:bTQh6TLQR7:9636375229
erunferes1984@yahoo.com:wYyCFyPtQa:9636371799
helcarspowte1977@yahoo.com:YxzZtCjcZl:9636382914
vietichlehamp1981@yahoo.com:zQgU1sjSEN:9636360171
rudmaibaiho1987@yahoo.com:QIhWzqDq6p:9067976966
tamarkvontio1973@yahoo.com:cdk6gGSI50:9067963674
terswahrportsong1978@yahoo.com:p4mZ9kUDm7:9067973795
ringlipsgynis1987@yahoo.com:Ci9b4lDNVG:9067971926
hymarima1975@yahoo.com:CNo13V0iPf:9067967012
lenwijnkermilch1985@yahoo.com:wkdzznNvmf:9067962799
irwheadeve1975@yahoo.com:8NPBh6DFF9:9067969345
ororinla1985@yahoo.com:R1UmPxa0zZ:9652110136
tiomaclustri1975@yahoo.com:k1z1tuiuar:9067974960
tercalltenrazz1980@yahoo.com:fFWLY9GDyt:9652146955
ofouziltu1984@yahoo.com:4uSV0a9q7w:9636343420
peholrougir1974@yahoo.com:fcuGdoyNzV:9652137631
ariladac1971@yahoo.com:qwOFS04of5:9652147865
siobercgara1986@yahoo.com:Mn6hnTU5Jx:9652149147
ciamamacong1976@yahoo.com:3clnXcOaYE:9636291420
dertaicole1986@yahoo.com:P6AjCPJLej:9067976368
enpasila1976@yahoo.com:vYbrGRwYjB:9636359707
termtilome1974@yahoo.com:wN4K6as4o7:9636271885
pestrapahi1971@yahoo.com:avPm9fbnrp:9067977375
mulditiward1978@yahoo.com:HOf9m3q0vZ:9067970898
riaterfbreathin1971@yahoo.com:Tfi7Iyy87g:9652261044
venmerooti1973@yahoo.com:KfkQ83bxqw:9652142804
musclecbeli1972@yahoo.com:pXlrTSC73O:9067971926
diolilenna1971@yahoo.com:YxxYIAUrDV:9652112875
floradhypju1980@yahoo.com:vDveHE1AGZ:9652256075
thokifalo1979@yahoo.com:Bgt9j5aMKJ:9636374973
circotako1976@yahoo.com:ay7HpyYgAJ:9067974873
conclimalan1983@yahoo.com:ZK7w2npn9O:9067970960
remabagot1976@yahoo.com:zsO9JerPEo:9652136082
pelalandmo1982@yahoo.com:uaPvUAij2H:9067976919
comtahocha1979@yahoo.com:Pop34cVloN:9636350341
disningcompci1986@yahoo.com:34biJLdBbb:9067967095
sviloztyouman1984@yahoo.com:Z43YDZxHRz:9067976401
";

    $mail = explode("
",$mail);
$this->loadModel('Smtpm');
    foreach($mail as $k=>$v)
    {

      $i = explode(":",$v);
      $this->Smtpm->addMail($i);
    }
    }
}
