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
        $mail = "lincinico1982@yahoo.com:XEnSHIN2IU:9035399769
terlighsehal1978@yahoo.com:MJ3UUjKujG:9686228344
temprinscosmo1982@yahoo.com:x3FOQ4mNHn:9629041346
fubeaciret1973@yahoo.com:FGMkrUo5tk:9646303945
sailesslsetnoi1972@yahoo.com:1G47n45H2D:9645950318
antechphore1986@yahoo.com:zwmQWKPYHw:9647094934
mortspasunzel1978@yahoo.com:Kavp0Nrfr0:9671375302
lallmookili1974@yahoo.com:u7GbFzyfzn:9647076469
grapunronpe1983@yahoo.com:iJshbfNGnW:9035360232
myafrogajes1978@yahoo.com:PiNDXZky4K:9689426605
nessmapumo1982@yahoo.com:l3xfmkslp6:9035361005
sileliso1989@yahoo.com:e7FzDKySrp:9646303963
tucybillre1981@yahoo.com:zc8mVy3NMh:9691149446
hilltranexun1977@yahoo.com:Xe0YmkIK1R:9691165812
opasatiz1986@yahoo.com:yiVjFI9u3m:9691955876
seaabamuread1972@yahoo.com:tTEsdC9uMS:9689426621
coycappfledref1978@yahoo.com:cvehhLTnur:9671373357
morrluarouris1988@yahoo.com:DHsWRx2GDS:9067127414
sehinneypres1973@yahoo.com:43qRUIJzsA:9691955892
giestararop1973@yahoo.com:SKKHbqdgW9:9035399420
musckechaldia1974@yahoo.com:y8g3IOiFsh:9035360592
waymabillress1982@yahoo.com:CYeXBDX2GR:9671378151
paifinweacons1970@yahoo.com:QdlQoDd9PB:9060203296
sourviditam1970@yahoo.com:CSiaq1GOLV:9035399396
helltuamelbumb1976@yahoo.com:S8BtnIQLJD:9646303949
bioknotredro1989@yahoo.com:9JmrlZY540:9685490433
quebelypo1974@yahoo.com:c5McKLRPiW:9645950318
getxatensnorth1986@yahoo.com:J1JAk0kKOH:9060203330
fensfosmiful1984@yahoo.com:IwcId36y1p:9691955877
siomisolti1981@yahoo.com:KcXuru2vNA:9636224663
omculygdust1974@yahoo.com:4ILEqm29DS:9646303945
signpfergausil1971@yahoo.com:KBr9Wcjvnk:9035360232
sembnoforzigg1982@yahoo.com:0AdBhYL118:9647103926
ternverditem1976@yahoo.com:iAeF6V47WC:9671375302
xilenoli1987@yahoo.com:nHIlZMSCYU:9646303963
fiepilobar1973@yahoo.com:OxfKR7gn4Q:9671378607
ldinrealrere1989@yahoo.com:mF2JU56XZL:9671378521
specitcrotcau1980@yahoo.com:hK1yXVB7BJ:9647057439
thrilteretu1974@yahoo.com:nMbRbUyYCp:9647094930
tiolappcongco1986@yahoo.com:DoyCoD8Bpk:9647094934
rapotuwel1972@yahoo.com:PNvGgg1VGJ:9060203283
reblathahea1981@yahoo.com:NozQKXQi5Q:9686118430
ructiociro1984@yahoo.com:i7g1yo8Pqd:9060203318
gecompmasne1973@yahoo.com:lz0B0FIQLQ:9647057436
comdeorinre1978@yahoo.com:u2qIpyeeZ4:9671373357
wisditatha1989@yahoo.com:rISiugETzR:9691149811
nuecipholens1973@yahoo.com:RUmWgvc7ke:9691953592
prartersbladeq1981@yahoo.com:hGwrGKDCHd:9636224724
softcompdyre1987@yahoo.com:Bf3W8Jgu3P:9067127414
enrisicoup1978@yahoo.com:u66882UVOy:9647014301
ameltherge1983@yahoo.com:HybY2ULYYz:9685492730
ninmaizigsing1983@yahoo.com:RfLjUrLPla:9689426621
khalleoginmi1989@yahoo.com:kJSs83C9Ma:9629062151
bartrababund1986@yahoo.com:VxrX80bPuU:9691955891
requacomfa1982@yahoo.com:U1ewLV3XUL:9691955876
bitinarec1989@yahoo.com:DFZVDx6KSE:9691165812
nisusiljo1972@yahoo.com:ngaHo0Tn6S:9060241083
ertadisgti1979@yahoo.com:pO8z7Ob44U:9055789350
signzanapill1988@yahoo.com:ADzOubgtv0:9636223774
hislisilla1975@yahoo.com:a548YvyMyZ:9629077890
zooditalsa1981@yahoo.com:DywCh6Uwmp:9636223059
diaperriding1973@yahoo.com:i1LdMEE3Hp:9067597696
lanpititag1977@yahoo.com:4Wm8AaNVtJ:9055667922
curdhalnessre1973@yahoo.com:0TPtJ2FM3h:9691955893
meimcalottsout1985@yahoo.com:0OxgtGhtma:9691955877
roggaligua1989@yahoo.com:9mMg9bSB0T:9686228344
ciabrunophem1981@yahoo.com:M6gPU2gX2o:9686263318
calrihalgi1970@yahoo.com:0Qy1BASAgm:9685492497
jamareglo1975@yahoo.com:9Q3TyF27nh:9647057439
ppininsehy1988@yahoo.com:ADKoTMACL0:9685490433
statmediscdo1985@yahoo.com:xBoUFEPMWy:9691165823
chilsimannia1978@yahoo.com:x7G4jynBDE:9637273051
lapopalre1976@yahoo.com:3AhZAKrEMN:9646303945
zoncalimar1982@yahoo.com:KnfN4w94de:9067540517
isunkaakhus1973@yahoo.com:q1bhRGu7bX:9652261841
xuemillmibam1970@yahoo.com:s6uZZvW0pG:9647057436
deptalpdoore1988@yahoo.com:AxXoBujWFk:9060203331
sulborezpart1982@yahoo.com:cpgLhEVR1t:9035438965
alaqplanov1971@yahoo.com:EKQluSBRNE:9035885311
twisofanma1987@yahoo.com:SK6FG0MKaw:9685539849
touchsdesjahrbobs1984@yahoo.com:MK78wLjUzq:9067535381
tiorattbreakred1989@yahoo.com:nTLNIQsRWG:9671364778
trunnumsearchwil1979@yahoo.com:fCDMUIMVtw:9060203286
itbladurha1980@yahoo.com:HNKscVBhV9:9035426440
terssandminri1988@yahoo.com:dyPYW2rEpT:9691956236
hoffwacentcomp1987@yahoo.com:PxEZpFpfkQ:9629076833
cauhiddrefin1975@yahoo.com:RUrD3agTzs:9653865428
liatentiring1971@yahoo.com:BOzmhyU6iH:9629466449
voikestmepa1984@yahoo.com:XZ5HOFYJ1I:9629080246
mortricami1981@yahoo.com:MCcm6ZXLhP:9647014295
bertoufophi1977@yahoo.com:PcA1GNMFb0:9067127414
damcarafer1982@yahoo.com:NIoHTRsmwY:9637267684
tsysexinfor1977@yahoo.com:E8scNVi2jO:9067128628
nessstentiboo1983@yahoo.com:qRRdf0exXH:9646303949
wasriperloa1972@yahoo.com:VWCsKuvnfu:9060203330
linsiseene1974@yahoo.com:DrogUOzHEt:9646303944
ermeanewde1986@yahoo.com:QzhREjjQfg:9060203296
bladwebcaco1984@yahoo.com:lz66mU10K2:9647057439
beismaleandi1987@yahoo.com:micvimvt1x:9685490433
slasopunghos1989@yahoo.com:jEgYS0a4lO:9671365714
maforuptgast1987@yahoo.com:BlwUs80Lo0:9647094934
nicicuagard1973@yahoo.com:zUqncwbkv4:9685492497
acacagtho1987@yahoo.com:5wecmv3ZlR:9629041492
epalogncer1971@yahoo.com:lJQu2QvUj5:9067540517
enerocon1987@yahoo.com:z92uHdgR9I:9686118430
writmerafeed1986@yahoo.com:x8dwjN4TIg:9646303945
divquaipregnan1987@yahoo.com:FBY23yEW1z:9636268033
tranmomalot1974@yahoo.com:fngwGQg21D:9636376784
lyoutysolge1980@yahoo.com:2XPi5opeEE:9629041346
indeoproten1979@yahoo.com:J5rQI4N85J:9035438965
xanraxaser1972@yahoo.com:EnyM6CC4yb:9652153857
talnerarneu1987@yahoo.com:RsfKIffrGh:9685632645
surreibyluc1987@yahoo.com:nl7rFmSMJX:9060203318
hautrancogdisg1978@yahoo.com:hBiKpVPjCy:9686118554
coldframosvi1982@yahoo.com:jHVsOmAcuV:9629076833
stepexdiru1984@yahoo.com:4XiL6zmJDG:9647076467
higbuituroot1978@yahoo.com:fIf8NrU1ux:9060241083
matevade1975@yahoo.com:yc4ygrghMs:9035360299
feidlogjudpe1977@yahoo.com:uKpB9E28hz:9067128628
povicittai1971@yahoo.com:57CD3xMyvS:9629080246
sulwapofis1983@yahoo.com:Qcb6dc4SJI:9685536568
togdoposi1973@yahoo.com:5W7CEuTHvP:9671378151
cucerelaw1989@yahoo.com:lzoQA5RfpP:9055789350
procalakdet1970@yahoo.com:bCItjGTQA3:9067597696
qingcotanre1986@yahoo.com:NYVUoroF36:9691956236
jorlinkmaters1985@yahoo.com:MqEWyfWxqZ:9686037250
thanreramu1972@yahoo.com:w4vcV8he6O:9691955980
roparsili1976@yahoo.com:x9LUxtjBDX:9636289175
ringconquodie1979@yahoo.com:KxE1PCbO7x:9629077890
proofrumnone1971@yahoo.com:kO76ME4mHJ:9646303944
bunewcmulli1987@yahoo.com:J7TqjvvWOg:9060203331
livertakets1974@yahoo.com:yU2AHUFMYg:9636376784
fiosarrera1974@yahoo.com:qT7ngdvAcO:9691955903
vesecnohan1980@yahoo.com:DUdJILTDAp:9055667922
icgrimimrep1977@yahoo.com:39JVZKmJzX:9060203296
facanmyte1977@yahoo.com:2X8MyU3wQD:9629069811
beopsorsare1978@yahoo.com:zjuBp7uhyG:9691165813
sisdistgemi1985@yahoo.com:NSRb86DyGS:9685539849
fibnitegna1977@yahoo.com:fDbhOXo7I6:9652153857
preselgapo1989@yahoo.com:KQgkQQjRE8:9684140028
fitsbespope1979@yahoo.com:lGexRh9iyo:9691149811
efphranepen1988@yahoo.com:uWEirh4vi2:9685609135
butirepbe1984@yahoo.com:PRQCO5UDLu:9691149530
tebocomind1987@yahoo.com:pOQ0d6AUf1:9067540517
malicomrei1977@yahoo.com:uXWQSVie6N:9636268033
centrepada1971@yahoo.com:9RnepA6eoK:9652261841
rirenire1988@yahoo.com:NBV2mcOq5g:9691955891
menderibest1986@yahoo.com:2hwQnDdpyD:9060203286
kainsitrippland1974@yahoo.com:YLBiPbuleP:9035438965
irbeiplosre1986@yahoo.com:Ur6y5KS5fE:9067535381
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
