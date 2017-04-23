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
        $mail = "abkifete1988@yahoo.com:5l5gAehXuo:9032978577
mostegevmi1981@yahoo.com:Ma22HOt3lE:9035260511
buydanfeifrac1987@yahoo.com:FLE8mcMNZ6:9689871088
plesiphunga1973@yahoo.com:NCX3ZQjkW2:9691123657
genasurgoe1984@yahoo.com:DoAyEi3IFw:9032940886
tkonarrumte1987@yahoo.com:8OyjrAy3fc:9647098396
keymopefan1977@yahoo.com:MmjqItQLav:9645887290
ineramnur1978@yahoo.com:8jYAg55ucW:9055338115
malptabruiser1973@yahoo.com:cUu75dwJra:9637553902
consbledorac1989@yahoo.com:OEluDM1BNI:9647071195
sporunesuav1975@yahoo.com:4qiytFsmOE:9645839673
setmorenhi1975@yahoo.com:weCAYXTPC0:9060219078
wellbreathchita1974@yahoo.com:GwAFeAOTJF:9645870164
thergillgana1985@yahoo.com:6FxygdoFdr:9055013067
acaxperna1988@yahoo.com:4y4I8sy0Oq:9035260511
coavechasfu1974@yahoo.com:XobFR0FNJU:9685056050
lormapylo1975@yahoo.com:BvKEAvXbLb:9060219020
ploreschevo1987@yahoo.com:WsL4T9Qt6W:9060219027
troculkhaman1989@yahoo.com:KEu8GA5IwA:9060219062
burrocolle1970@yahoo.com:om0eIf81Y3:9055865477
thewathance1976@yahoo.com:Egu3zjYtaC:9691123776
backpedafpha1970@yahoo.com:oQBymS05jB:9691123747
anbeluly1989@yahoo.com:DIZizXcfwM:9691960890
enibdepub1975@yahoo.com:lZpSewwWqb:9646304424
clasalunstav1985@yahoo.com:nHsOy4BrGB:9691967635
prophebimmat1972@yahoo.com:XjsN3wnber:9637553902
fullcrandisho1972@yahoo.com:s1NLRaTpV4:9689879513
elorosav1974@yahoo.com:UMiIp8kwF2:9032868112
fistgendsingca1973@yahoo.com:ak624c4CoE:9691123610
quiciakhorin1982@yahoo.com:I2sauanVce:9652005939
kodechutzdi1989@yahoo.com:fsYB4CPgqX:9055865477
cahachecom1981@yahoo.com:sau0GcBKC7:9691123680
sorofardi1977@yahoo.com:4FyLnEQ97e:9646304424
clamipherex1989@yahoo.com:1Gs1u8WYxm:9691142081
overvenbest1974@yahoo.com:odJaUc1jC5:9691967635
prestotento1989@yahoo.com:PEyyr9ttBA:9055013067
scumnigvagi1971@yahoo.com:0gRnPUm1iM:9689879513
morrenatkmys1983@yahoo.com:qVYVtjg5ZJ:9689887954
neumasthatsherd1984@yahoo.com:YyZie0j5OO:9647070942
giugaberro1979@yahoo.com:oGaiWMj0P7:9055865263
haylonggrasha1987@yahoo.com:Usupd4jvXg:9691123787
tiosacolme1970@yahoo.com:yN3JRNEu1y:9647096985
olatbehi1978@yahoo.com:5l0NAaAREJ:9689870849
ealgiaconcprod1983@yahoo.com:4utA4h9HNA:9653284461
ramasphacom1977@yahoo.com:jUEssdSWdB:9647116239
consdisvafo1989@yahoo.com:se5l6uIBjD:9645885642
weiworlisig1971@yahoo.com:CXy5Njcn9t:9687358943
freephdenseta1975@yahoo.com:ABJaqa7fg3:9657089234
palmflooratsa1987@yahoo.com:Tmi6Eusiy7:9645839673
ythmimenna1971@yahoo.com:gGBrp4V5OC:9035169794
castmanoro1974@yahoo.com:ILy5D87J5h:9096439099
mipubenet1980@yahoo.com:Xu2ZY6OPE8:9647096985
bourffirmroughre1974@yahoo.com:Y4HUrCOiIa:9691123787
rattlakasi1987@yahoo.com:Z5mKvD7Yrp:9645887279
bullbalkaja1976@yahoo.com:nCt7VtCzjq:9645885642
esracgage1989@yahoo.com:K0p9WVvFwF:9691124071
letredersxa1974@yahoo.com:0HXMmMfrWE:9096536939
amofpive1988@yahoo.com:TBd9nqWBE6:9647070825
cremeninap1980@yahoo.com:R1yYwmOJaU:9647070538
lesupptubuzz1984@yahoo.com:1OJfrom9zm:9657088962
kekareti1981@yahoo.com:YNAeQvoXb4:9645888526
statipisnas1971@yahoo.com:me8OBxc8ai:9647116086
pubmitara1985@yahoo.com:r1H8li0EEo:9646310150
gaivipersirf1989@yahoo.com:FP1Io5ct9q:9647096985
chapcoupela1972@yahoo.com:LcLz8Hb36e:9691123554
substechcodu1970@yahoo.com:bT6Iaa5QUP:9691123776
mapavera1989@yahoo.com:iwmW5L5Xll:9691175619
pincasoval1977@yahoo.com:DAIOlO3hAw:9647115957
crecparade1987@yahoo.com:JV3LvO9Ihi:9647071089
erunateab1985@yahoo.com:w4812bD2rh:9646310156
hahehare1979@yahoo.com:kul467INDP:9645839907
sairollgeli1988@yahoo.com:b9OK7lwEUy:9652005939
linrocame1970@yahoo.com:cLTsKy1oMS:9645840281
giecidemen1978@yahoo.com:s3HWOeZnaE:9652006052
spicirtalbarf1982@yahoo.com:KrJkiG075r:9689883062
sewarmninkpers1978@yahoo.com:9bvAbENmBB:9647116086
paibargconsber1973@yahoo.com:u5ecApxQde:9691075821
schafthecherwebs1983@yahoo.com:hUr147ZML8:9657088959
mibudsrutre1973@yahoo.com:MRvAGzcEnU:9629989162
tontiaberro1973@yahoo.com:Yzq8uNJUgs:9035425192
didufodic1981@yahoo.com:XilsEVGa0l:9035369497
ininanchris1981@yahoo.com:vsrdpxoW0h:9035406406
filapurma1978@yahoo.com:eTfY59HWSO:9032973468
flexupsides1979@yahoo.com:eSinYIDr0P:9672771604
netitgresfigh1989@yahoo.com:qLZc7pn2q4:9060219033
ispelpufor1977@yahoo.com:JI6bZBxKRe:9060219017
meddotuame1970@yahoo.com:lddqsccIVp:9629411946
larespires1974@yahoo.com:c6hnyTcehb:9032977839
niekentide1971@yahoo.com:D6vKJhs82P:9685056021
nedupihec1974@yahoo.com:5l9Irz8Xd5:9035624214
conpahudisp1981@yahoo.com:rT2nctakwJ:9686735863
sighkingfirpa1980@yahoo.com:SC61s96iuD:9672628453
denisivi1975@yahoo.com:XUYEkOc3gg:9035162630
cialibigra1985@yahoo.com:pPVeEjT2c9:9035362832
ryamalmosis1983@yahoo.com:bHfUzZ4AeZ:9691960344
laypanramort1986@yahoo.com:kHWvsfQhg3:9032840315
liabertali1972@yahoo.com:O7NvrLDUhw:9686484018
grosorcache1987@yahoo.com:WJBU4pXuQz:9035064063
mayparnakow1979@yahoo.com:4HgUnU1hIf:9672621223
hehotudoo1975@yahoo.com:ha8Bmog8Tq:9691967643
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
