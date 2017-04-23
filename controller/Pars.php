<?php
use MimeMailParser\Parser;
use MimeMailParser\Attachment;
class Pars extends Controller
{
    public $name = 'cards';

    public function index($e)
    {

    }



    public function parse()
    {
      $file = scandir(dirname(dirname(__FILE__))."/test");

      shuffle($file);
      $mailParser = new ZBateson\MailMimeParser\MailMimeParser();

      $handle = fopen(dirname(dirname(__FILE__)).'/test/'.$file[0], 'r');
      $message = $mailParser->parse($handle);         // returns a ZBateson\MailMimeParser\Message
      fclose($handle);
      try {
        if($message->getHeader('from')->getPersonName() == "Superencontre")
        {
          return $this->parse();
          die();
        }
      }
      catch (Exception $e) {
        return $this->parse();
      }

      try {
        $name = $message->getHeader('from')->getPersonName();
      } catch (Exception $e) {
        return $this->parse();
      }

      $subject =  $message->getHeaderValue('subject');       // The email's subject
      $html =  $message->getHtmlContent();
      $dom = new DOMDocument('1.0', 'utf-8');
      $dom->loadHTML($html);
      $countdiv = count($dom->getElementsByTagName('div'));
      foreach($dom->getElementsByTagName('div') as $k=>$href)
      {
        if($k == 0)
            $href->parentNode->removeChild($href);
      }

      $html = $dom->saveHTML();

      $dom = new DOMDocument('1.0', 'utf-8');
      $dom->loadHTML($html);
      $countdiv = count($dom->getElementsByTagName('div'));
      foreach($dom->getElementsByTagName('div') as $k=>$href)
      {
        if($href->nodeValue == "Si vous souhaitez vous dÃ©sinscrire des mails de Superencontre, cliquez ici")
            $href->parentNode->removeChild($href);
      }
      $html = $dom->saveHTML();
      $html = str_replace("garciathomas", "", $html);
      $html = str_replace("THOMAS", "", $html);
      $html = str_replace("paris 11eme arrondissement", "", $html);
      $html = str_replace("garciathom.as@gmail.com", "", $html);
      $html = str_replace("gar.ciathom.as@gmail.com", "", $html);
      $subject = str_replace("garciathomas", "", $subject);
      $subject = str_replace("THOMAS", "", $subject);
      $subject = str_replace("paris 11eme arrondissement", "", $subject);



      $return['html'] = "<html>
      <head>
      <title>".$subject."</title>
      <link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
      </head>

      <head>
      <title>".$subject."</title>
      </head>";
      $return['html'] .= $html;
      $return['name'] = $name;
      $return['subject'] = $subject;
      return $return;

    }

    public function kit($people)
    {
        print_r($_SERVER);
        $r = rand(0,2);
        if($r == 0)
          $kit = $this->parse();
        else if($r == 1)
          $kit = $this->sendiblue();
        else if($r == 2)
          $kit = $this->sophie();
      //  else if($r == 3)
        //  $kit = $this->textimg();
        //else if($r == 4)
          //$kit = $this->kitfolder();
      //  else {
        //  $kit = $this->sophie();
        //}

        print_r("cccc");
        print_r($_SERVER['SERVER_NAME']);

          $dest = $people['link'];

        //$dest = $_SERVER['SERVER_NAME'];
        print_r("dddd");
        print_r($dest);
        $link = $dest."/Trck/link/".$people['people_id'];

        $kit['html'] = str_replace("{{pseudo}}", $pseudo[0], $kit['html']);
        $kit['html'] = str_replace("{{sujet}}", $t['sujet'], $kit['html']);
        $kit['html'] = str_replace("{{age}}", $pseudo[1], $kit['html']);
        $kit['html'] = str_replace("{{texte}}", substr($this->texte(), 0, rand(45,250)), $kit['html']);
        $kit['html'] = $this->spinhtml($kit['html']);
        $kit['html'] = $this->replace_a_href($kit['html'],$link);
        $kit['html'] = $this->replace_img_src($kit['html'],$dest);
        print_r($kit);
        return($kit);

    }

    public function kitfolder()
    {
      $file = scandir(dirname(dirname(__FILE__))."/kit");
      shuffle($file);
      $ok = 1;
      while($ok)
      {
        $pos = strpos($file[0], ".json");
        if ($pos !== false) {
          $ok = 0;
        } else {
            shuffle($file);
        }
      }
      $template = explode(".",$file[0]);
      $json = json_decode(file_get_contents(dirname(dirname(__FILE__))."/kit/".$template[0].".json"),true);
      $html = file_get_contents(dirname(dirname(__FILE__))."/kit/".$template[0].".html");


      $kit['html'] = $html;
      $kit['subject'] = $json['sujet'];
      $kit['name'] = $json['name'];
      return($kit);
    }
    public function sujet($pseudo)
    {

      $sujet1[] = "Fwd:";
      $sujet1[] = "Fwd : ";
      $sujet1[] = "Re:";
      $sujet1[] = "Re : ";
      $sujet1[] = "R: ";
      $sujet1[] = " ";
      $sujet1[] = "";
      $sujet2[] = "[".$pseudo."]";
      $sujet2[] = "[[".$pseudo."]]";
      $sujet2[] = "*".$pseudo."*";
      $sujet2[] = "**".$pseudo."**";
      $sujet2[] = "{".$pseudo."}";
      $sujet2[] = "".$pseudo."";
      $sujet2[] = "{}";
      $sujet2[] = "";
      $sujet3[] = "Nouveau message de";
      $sujet3[] = " message de";
      $sujet3[] = "Nouveau message :";
      shuffle($sujet2);
      $name[] = "Facebook";
      $name[] = "Facebook ".$sujet2[0];
      $name[] = $sujet2[0];
      $name[] = "Facebook ".$pseudo;
      $name[] = $sujet2[0]." Facebook ";
      shuffle($name);
      shuffle($sujet1);
      $sujet = $sujet1[0];
      shuffle($sujet2);
      $sujet .= $sujet2[0];
      shuffle($sujet3);
      $sujet .= $sujet3[0];
      shuffle($sujet2);
      $sujet .= $sujet2[0];

      $t['sujet'] = $sujet;
      $t['name'] = $name[0];
      return($t);
    }

    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function tinyurl($url)
    {
      //print_r("\n".'curl "http://tinyurl.com/api-create.php\?url='.$url."\n");
      $url = shell_exec('curl "http://tinyurl.com/api-create.php?url='.$url.'"');

      sleep(3);
      print_r($url);
      return($url);
    }

    public  function replace_img_src($img_tag,$dest) {
        $doc = new DOMDocument();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $old_src = $tag->getAttribute('src');
            $old_src = $this->base64url_encode($old_src);
            $new_src_url = $dest."/Trck/imgSrc/".$old_src;
            $findme   = 'scrapyomama';
            $pos = strpos($dest, $findme);
          //  if ($pos === false) {
            //} else {
              //$new_src_url= $this->tinyurl($new_src_url);
          //  }

            $tag->setAttribute('src', $new_src_url);
        }
        return $doc->saveHTML();
    }

    public  function spinhtml($img_tag) {
        $doc = new DOMDocument();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('td');
        foreach ($tags as $tag) {
            $rand=rand(0,3);
            if($rand == 0)
            $tag->setAttribute('class', md5(uniqid(time())));
            else if($rand == 1)
            $tag->setAttribute('id', md5(uniqid(time())));
        }
        $img_tag = $doc->saveHTML();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('tr');
        foreach ($tags as $tag) {
            $rand=rand(0,3);
            if($rand == 0)
            $tag->setAttribute('class', md5(uniqid(time())));
            else if($rand == 1)
            $tag->setAttribute('id', md5(uniqid(time())));
        }
        $img_tag = $doc->saveHTML();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('div');
        foreach ($tags as $tag) {
            $rand=rand(0,3);
            if($rand == 0)
            $tag->setAttribute('class', md5(uniqid(time())));
            else if($rand == 1)
            $tag->setAttribute('id', md5(uniqid(time())));
        }
        $img_tag = $doc->saveHTML();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('span');
        foreach ($tags as $tag) {
            $rand=rand(0,3);
            if($rand == 0)
            $tag->setAttribute('class', md5(uniqid(time())));
            else if($rand == 1)
            $tag->setAttribute('id', md5(uniqid(time())));
        }
        $img_tag = $doc->saveHTML();


        $nb = rand(0,10);

        while($nb)
        {
          $nb--;
          $doc->loadHTML($img_tag);
          $tags = $doc->getElementsByTagName('body');
          foreach ($tags as $tag) {
            $rand=rand(0,3);
            if($rand == 0)
              $bar = $doc->createElement("div");
            if($rand == 1)
              $bar = $doc->createElement("span");
            if($rand == 2)
              $bar = $doc->createElement("p");
            if($rand == 3)
              $bar = $doc->createElement("div");
            $tag->appendChild($bar);
            $rand=rand(0,3);
            if($rand == 0)
            $bar->setAttribute('class', md5(uniqid(time())));
            else if($rand == 1)
            $bar->setAttribute('id', md5(uniqid(time())));
          }
          $img_tag = $doc->saveHTML();
        }



    echo $doc->saveXML();
        return $img_tag;
    }

    public  function replace_a_href($html,$link) {
        $findme   = 'scrapyomama';
        //$pos = strpos($link, $findme);
        //if ($pos === false) {
        //} else {

          //$link = $this->tinyurl($link);

        //}
        print_r($link);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('a');
        foreach ($tags as $tag) {
            $tag->setAttribute('href', $link);
        }
        return $doc->saveHTML();
    }

    public function pseudo()
    {
      $file = scandir(dirname(dirname(__FILE__))."/faketac");
      shuffle($file);
      $ok = 1;
      while($ok)
      {
        $pos = strpos($file[0], ".jpg");
        if ($pos !== false) {
          $ok = 0;
        } else {
            shuffle($file);
        }
      }

      $pseudo = explode("-",$file[0]);
      return($pseudo);
    }

    public function sophie()
    {
      $pseudo = $this->pseudo();
      $t = $this->sujet($pseudo[0]);

      $html ="<html>
<head>
<title>".$t['sujet']."</title>
<link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>
<body>
<div ><br>
  <div ><br>
    <br>
    <u></u>
    <div style=\"margin:0;padding:0\" dir=\"ltr\">
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"40\"  style=\"border-collapse:collapse;width:98%\">
        <tbody>
          <tr>
            <td  style=\"font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif;font-size:12px\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse;width:620px\">
                <tbody>
                  <tr>
                    <td style=\"font-size:13px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif;padding:10px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none;color:#000000\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse\">
                        <tbody>
                          <tr>
                            <td style=\"font-size:13px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif;color:#000000;width:620px\"><div style=\"width:100%;color:#666666;padding:0 0 7px 0;border-bottom:#e9e9e9 1px solid\">Conversation de ".$pseudo[0]."</div></td>
                          </tr>
                          <tr>
                            <td style=\"font-size:13px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif;color:#000000;width:620px\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse\">
                                <tbody>
                                  <tr>
                                    <td valign=\"top\" style=\"padding:3px 5px 5px 0px;width:57px\"><a href=\"https://www.facebook.com/miraklogan91\" style=\"color:#3b5998;text-decoration:none\" target=\"_blank\"><img src=\"http://scrapyomama.herokuapp.com/faketac/".$pseudo[0]."-".$pseudo[1]."-sexy.jpg\" alt=\"".$pseudo[0]."\" height=\"50\" width=\"50\" style=\"border:0\"></a></td>
                                    <td align=\"left\" valign=\"top\" style=\"padding:5px 5px 5px 0\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse\">
                                        <tbody>
                                          <tr>
                                            <td style=\"font-weight:bold;color:#000000;font-size:13px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif\"><a href=\"https://www.facebook.com/miraklogan91\" style=\"color:#3b5998;text-decoration:none\" target=\"_blank\">".$pseudo[0]."</a></td>
                                            <td style=\"text-align:right;font-size:11px;color:#999999;padding-right:5px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif\">19 avril</td>
                                          </tr>
                                          <tr>
                                            <td colspan=\"2\" style=\"padding-top:5px;color:#000000;font-size:13px;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif\"><span style=\"color:#333333\">".substr($this->texte(), 0, rand(45,250))." <a href=\"https://www.facebook.com/miraklogan91\" style=\"color:#3b5998;text-decoration:none\" target=\"_blank\">... lire la suite</a></span></td>
                                          </tr>

                                        </tbody>
                                      </table></td>
                                  </tr>
                                  <tr>
                                    <td colspan=\"2\" style=\"font-size:12px;padding:10px 0 0;border-top:#e9e9e9 1px solid;font-family:&#39;lucida grande&#39;,tahoma,verdana,arial,sans-serif\"><a href=\"https://www.facebook.com/n/?Coralie267%2Funanswered_messages%2F&amp;medium=email&amp;mid=54d2a5463ff4aG5af56d01acaeG0G0&amp;bcode=1.1492220315.AbkZRs0dLyrAenr6&amp;n_m=.rdtrdt%40gmail.com\" style=\"color:#3b5998;text-decoration:none\" target=\"_blank\">Afficher la conversation </a></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>

              </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <br>
</div>
</body>
</html>
";



        $kit['html'] = $html;
        $kit['name'] = $t['name'];
        $kit['subject'] = $t['sujet'];
        return($kit);
    }

    public function html()
    {
      return "<html>
      <head>
      <title>Caroline a visité votre profil !</title>
      <link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
      </head>
      <body>
      <table border=0 cellspacing=0 cellpadding=0 width=\"100%\" class=\"header-part1\"><tr><td><b>Sujet : </b>Caroline a visité votre profil !</td></tr><tr><td><b>De : </b>Caroline &lt;&gt;</td></tr><tr><td><b>Date : </b>31/03/2017 10:29</td></tr></table><table border=0 cellspacing=0 cellpadding=0 width=\"100%\" class=\"header-part2\"><tr><td><b>Pour : </b>mrsoyer@me.com</td></tr></table><br>
      <html>
      <head>
      <title>Caroline a visité votre profil !</title>
      </head>
      <body>
      <body style=\"margin:0; padding:0;\"><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 450px\">
      	<tbody>
      		<tr>
      			<td bgcolor=\"#A0A0A0\" colspan=\"2\" style=\"text-align: center;\">
      				<span style=\"color: #ffffff;\"><strong><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuwd8r6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">NOUVELLE VISITE</span></a></strong></span></td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#F5F5F5\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"font-family: verdana, geneva; font-size: medium;\">Elle a visit&eacute; votre profil.<br />
      				Profitez de cette occasion&nbsp;pour lui &eacute;crire un message&nbsp;</span><br />
      				<br />
      				<a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesux5or6b7d.html\"><span style=\"font-family: verdana, geneva; font-size: x-large;\"><img src=\"http://img.srensbp.com/ac9wuwd8r6b7e.jpg\" style=\"width: 180px; height: 180px;\" /></span></a><br />
      				<br />
      				<span style=\"font-size:20px;\"><span style=\"font-family: verdana, geneva; color: rgb(51, 51, 51);\"><span style=\"color: #ff0000;\">Caroline</span>&nbsp;- 37 ans</span></span><br />
      				&nbsp;</td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#404040\" style=\"text-align: center;\">
      				<br />
      				<span style=\"color: #ffffff;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuxy4r6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">LUI ECRIRE</span></a></span><br />
      				&nbsp;</td>
      			<td bgcolor=\"#6666FF\" style=\"text-align: center;\">
      				<span style=\"color: #ffffff;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuyqkr6b7d.html\" style=\"text-decoration: none;\"><span style=\"font-family: verdana, geneva; font-size: x-large; color: #ffffff;\">SON PROFIL</span></a></span></td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#F5F5F5\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"font-family: verdana, geneva; font-size: x-large;\">Vous avez <span style=\"color:#ff0000;\">19</span>&nbsp;nouvelles visites !</span><br />
      				&nbsp;</td>
      		</tr>
      		<tr>
      			<td bgcolor=\"#A0A0A0\" colspan=\"2\" style=\"text-align: center;\">
      				<br />
      				<span style=\"color: #ffffff; font-size: large;\"><a href=\"https://tinyurl.com/mxvk7gf#5ex6mxesuzj0r6b7d.html\" style=\"text-decoration: none;\"><span style=\"color: #ffffff;\"><strong><span style=\"font-family: verdana, geneva;\">VOIR L&#39;ACTUALITE DE MON PROFIL</span></strong></span></a></span><br />
      				&nbsp;</td>
      		</tr>
      	</tbody>
      </table>
      <br />


      </body>
      </html>
      <img src='https://c1490873022thetest.herokuapp.com/Trck/img/thetest/58de102ca678742fd56adf24/58bad87ec2ef162f4b4bf415/' width='1px' height='1px'>
      </body>
      </html>
";
    }
    public function textimg()
    {
      $pseudo = $this->pseudo();
      $sujet = array("coucou","salut toi","mais ou est tu ? ","tu as disparu :)","hey","hello","Ciao","beauty :)",":)",";)","yop","hi","baby","repond moi !","jte kif","yes we can !","avis de recherche","repond moi !","love","kiss","flirt","moack",);
      $emoji = array("❤️","💋","😀","😃","😇","😍","😘","😈","😺","👻","💋","👄","👙","🍊","🍑","💌","✉️","❤️","💛","💚","💙","💜","🖤","💔","❣️","💕","💞","💓","💗","💖","💘","💝","💟");
      shuffle($sujet);
      shuffle($emoji);
      $emoji = $emoji[0];
      $sujet = $sujet[0];
      $rand= rand(0,3);
      if($rand == 0)
        $s = $emoji." ".$sujet;
      else if($rand == 1)
        $s = $sujet;
      else if($rand == 2)
        $s = $emoji;
      else if($rand == 3)
        $s = $sujet." ".$emoji;
      else if($rand == 4)
        $s = $this->objects();
      else if($rand == 5)
        $s = $emoji." ".$this->objects();
      else if($rand == 6)
        $s = $this->objects()." ".$emoji;




      $html = str_replace("\n","<br/>",$this->texte());

      $kit['html'] = "<html>
<head>
<title>".$s."</title>
<link rel=\"important stylesheet\" href=\"chrome://messagebody/skin/messageBody.css\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>
<body><a href='http://google.com'>";
      $kit['html'] .= $html;
      $kit['html'] .= "</a><br><br>".$pseudo[0]."<br><br><a href='http://google.com'><img src=\"http://scrapyomama.herokuapp.com/faketac/".$pseudo[0]."-".$pseudo[1]."-sexy.jpg\" alt=\"".$pseudo[0]."\"/></a></body>";


      $kit['subject'] = $s;
      $kit['name'] = $pseudo[0];
      return($kit);


    }

    public function spin()
  	{
  		$intro = $this->spinnage("{Salut toi,|Hey,|Coucou,|Bonjour Jeune Homme| Hello :),|Salut Salut|Holla :)}");

  		$message1 = array("{{Je voulais|J’aimerai|Je souhaiterai|Je veux|Je souhaite} me {présenter|décrire} car ça peut {potentiellement|peu être|eventuellement} {coller|aller|marcher|le faire} entre {nous|toi et moi}.|Ça peut {potentiellement|peu être|eventuellement}  {coller|aller|marcher|le faire} entre {nous|toi et moi} donc je {te répond|me présente}.|Je suis {content|ravie} que tu  {me réponde|m’envoie un message|me laisse un mail}, car l’on peu  {potentiellement|peu être|eventuellement} s’entendre|{Je voulais|J’aimerai|Je souhaiterai|Je veux|Je souhaite} me {présenter|décrire}… tu est {potentiellement|peu être|eventuellement} un {super potentiel|bon coup|etalon} ;).}","{Mon {pseudo|surnom} c'est  [[PSEUDO]], j'ai [[AGE]] ans et je suis {célibataire|libre|seule}. |Je suis {célibataire|libre|seule} et l’on m’appelle [[PSEUDO]] , j'ai [[AGE]] ans.|Je {préfère|souhaite} te {donner|filler} mon  {pseudo|surnom} {pour l’instant|pour le moment} «[[PSEUDO]]» , j'ai [[AGE]] ans et je suis depuis peux {célibataire|libre|seule}.}","{{Je n'ai plus envie de|je ne souhaite plus|Je ne veux plus}  {me prendre la tête|m’embêter|m’entêter} avec les {mecs|garçons|gas} dans une {relation|aventure|relation} {sérieuse|engagé|longue} c'est pourquoi j'ai laissé {cette annonce|ce post|ce message} et {te répond|te fait un retour|renvoie un message|te fait un retour mail|te r’envoie un mail}… |Si je {t’ai répondu|t’ai r’envoyé un mail|te laisse un message} c’est que{je n'ai plus envie de|je ne souhaite plus|je ne veux plus} {me prendre la tête|m’embêter|m’entêter} avec les {mecs|garçons|gas} et {je n'ai plus envie de|je ne souhaite plus|Je ne veux plus} {de relation|d'aventure|de relation} {sérieuse|engagé|longue}.|J’espere que tu ne cherche pas {de relation|d'aventure|de relation} {sérieuse|engagé|longue} car {je n'ai plus envie de|je ne souhaite plus|Je ne veux plus} {me prendre la tête|m’embêter|m’entêter} et c’est pour ca que je {te répond|te fait un retour|renvoie un message|te fait un retour mail|te r’envoie un mail}.}");

  		$message2 = array("{{On ne se connaît pas encore|On ne c’est jamais vu} mais je {souhaiterais|aimerais} {approfondir avec toi.|te découvrir.} |{J’aimerai|Je souhaiterai} {en savoir plus sur toi|te découvrir} même {si on ne ce connais pas encore|si on ne c’est jamais vu}.|{On ne c’est jamais vu|on ne ce conais pas} et {j’aimerai|je souhaiterai}  {apprendre a te connaître|enaprendre plus sur toi}}","{{J'ai vraiment envie de|Je souhaite|J’aimerai vraiment}  {me lâcher|m’éclater|me défouler} et {de trouver|d’avoir} un {mec|garçon|ga} qui me fera enfin {prendre du plaisir|m’épanouir|prendre mon pied|jouir}. |{Serai tu|Pence tu pouvoir} me faire  {prendre du plaisir|m’épanouir|prendre mon pied|jouir}? {J’adorerai|j’aimerai vraiment} en tout cas {j'ai vraiment envie de|je souhaite|j’aimerai vraiment}  {me lâcher|m’éclater|me défouler}|{je cherche|j’aimerai trouver} un  {mec|garçon|ga} qui me ferra {prendre du plaisir|m’épanouir|prendre mon pied|jouir} et avec qui je pourrais {me lâcher|m’éclater|me défouler}.}","{{Je cherche|J’aimerai trouver} {un plan cul|un plan Q|une sexfriend} {d'un ou plusieurs soir|régulier ou pas}, tout dépend {de l’alchimie| si ça colle entre nous} lol. {Qu'en dis tu|Qu’en pence tu} ? Je te propose qu'on {en discute|chat|en parle} …|{J’aimerai|Je souhaiterai|Je veux|Je souhaite} {discuter|chater|parler} avec toi,  {qu'en dis tu|qu’en pence tu}? {Je cherche|J’aimerai trouver} {un plan|un plan |une rencontre} {d'un ou plusieurs soir|régulier ou pas}. Voyons { l’alchimie entre nous| si ça colle entre nous}…|{J’aimerai|Je souhaiterai|Je veux|Je souhaite}{un plan cul|un plan Q|une sexfriend} {d'un ou plusieurs soir|régulier ou pas}  {si une alchimie ce créer entre nous| si ça colle entre nous}.  {Qu'en dis tu|Qu’en pence tu} ? {on en discute|on chat|on en parle} …}");


  		shuffle($message1);
  		shuffle($message2);

  		$texte[0] = $this->spinnage("{Salut toi,|Hey,|Coucou,|Bonjour Jeune Homme| Hello :),|Salut Salut|Holla :)}");

  		$texte[0] .= "\n \n ".$this->spinnage($message1[0]." ".$message1[1]." ".$message1[2]."..");
  		$texte[0] .= "\n \n ".$this->spinnage($message2[0]." ".$message2[1]." ".$message2[2]."..");

  		$texte[0] .= "\n \n ".$this->spinnage("{J'adore m'exiber, si tu ve voir sur ce site ;) |Si tu ve me voir , j'aime montrer mon corp |J'adorerai que tu vienne me mater si ça te dis :) |Si ca te dis de parler ;) allez vien me voir | Si tu ve me mater je suis souvent connecter sur ce site ;) : }");

  		$texte[0] .= "\n \n ".$this->spinnage("{Mes photos en pj ;)|Mes tof ci joins |Je t'ai mis des photo de moi ;)}");

  		$texte[0] .= "\n \n ".$this->spinnage("{kiss|Bisous|xxx}
  ");

  		$parti1 = array();
  $parti2 = array();
  $parti3 = array();
  $parti4 = array();
  $parti5 = array();
  $o = 0;

  		if (($handle = fopen(dirname(dirname(__FILE__)).'/config/kit2.csv', "r")) !== FALSE) {


  		    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {

  		    $parti1[] = $data[0];
  			$parti2[] = $data[1];
  			$parti3[] = $data[2];
  			$parti4[] = $data[3];
  			$parti5[] = $data[4];

  		        }
  		    fclose($handle);

  		    shuffle($parti1);
  			shuffle($parti2);
  			shuffle($parti3);
  			shuffle($parti4);
  			shuffle($parti5);


  			$texte[1] = $parti1[0]."\n \n".$parti2[0]."\n \n".$parti3[0]."\n \n".$parti4[0]."\n \n".$parti5[0]."\n \n";

  			shuffle($texte);

  			//print_r($texte[0]);
  			return $texte[0];

  		}
    }

    public function texte()
    {
      $message[]= "En faisant un peu de nettoyage de mes messages, j'ai vu le tien et là je me suis dit, mais alors celui-là , il n'a pas honte lui, aucune réponse au mien. Pourtant, je croyais que je te plaisais et que nous irions au moins prendre un verre, histoire de mieux connaitre, on habite pas loin l'un de l'autre, alors sois pas timide et invite moi un de ces jours, tu seras surpris, je mettrais une robe à faire craquer même le plus dur des hommes.
      J'attends ta réponse, fonce mon nounours, je suis impatiente de te rencontrer et de lire dans tes yeux combien je te plais, et ainsi notre aventure folle commencera, vite je finis ce message et je reste devant l'écran à attendre ta réponse.
      En attendant de te les donner en vrai, je laisse ici des gros bisous et des câlins pour toi.

      Je t'embrasse très fort";

      $message[]= "Salut ça va ?
      Voilà j'ai longtemps hésité à te contacter... Mais j'ai décidé de prendre mon courage à deux mains et de t'avouer que je t'apprécie beaucoup. Cela fait un moment que je t'ai remarqué et je dois avouer que tu me plais autant physiquement que mentalement et j'aimerais bien qu'on sort tous les deux pour faire plus connaissance... Après j'ai remarqué aussi que t'étais souvent entouré de filles donc je sais pas si tu cherches une relation d'un soir ou durable mais je suis prête à tenter ma chance parce que tu me plais beaucoup.

      Voilà j'espère que tu me recontacteras vite j'ai vraiment envie d'en connaitre plus sur toi et voir si on peut commencer une histoire tous les deux.
      Bisous et à bientôt j'espère !";
      $message[]= "Salut,

      Cela fait longtemps que nous n’avons pas échangé de messages. Quoi de neuf depuis tout ce temps ? J’espère que tu vas bien et que tu te souviens encore de moi. J’étais partie chez mes parents à la campagne durant un mois et je n’ai plus eu le temps de t’écrire. J’aimais bien nos longues discussions d’avant et j’aimerais reprendre si tu as encore envie.

      D’ailleurs, je trouve que l’on s’entend très bien tous les deux. On a les mêmes centres d’intérêt, les mêmes opinions et j’avoue que ton physique ne m’est pas indifférente. On pourrait découler vers une relation plus intime si tu le sens bien aussi.

      Quoi qu’il en soit, je reste disponible pour nos échanges de mail, étant donné que je serais en ville désormais, et pour une longue durée.

      A bientôt et gros bisous. ";


      $message[]= "Hello bel homme,

      On se croise tous les jours et malgré cela, j'ai la très nette impression que tu ne me voies pas. Il me semblait pourtant que nous avions quelque chose à faire ensemble !
      Tu es peut-être pris par ailleurs et déjà engagé avec quelqu'un d'autre auquel cas, je laisse tomber ce qui aurait pu devenir une belle histoire.

      Si, en revanche, tu penses comme moi que nous pourrions aller plus loin que le simple échange de deux ou trois regards quotidiens, n'hésite pas à m'aborder franchement, je n'attends que çà !
      L'amie que nous avons en commun et qui m'a donné ton adresse e-mail a bien senti que nous étions sans doute fait pour nous rencontrer.

      Je ne t'embête pas plus longtemps mais si tu es dans le même état d'esprit que moi, réponds à cet e-mail !

      Bisous et, j'en suis sûre, à très bientôt.";
      $message[]= "Salut mon chou

      Je suis retombée sur ton mail, alors je n’ai pas résisté à t’en envoyer en retour. Je dois t’avouer que j’aurais bien voulu que ce soit toi qui le fasses en premier.
      Ça faisait tellement longtemps, tu es toujours occupé ?
      Je serais toujours là, au cas où tu voudrais me répondre.
      Je t’embrasse.";

      $message[]= "Bonjour le bel homme

      Tu ne m’as pas donné de tes nouvelles depuis combien déjà, trois semaines ?
      Et moi qui ai toujours espéré que tu n’hésiteras pas à me contacter, mais comme je peux le voir, tu es un vraiment imprévisible. J’aime bien ce côté de toi.
      J’attends toujours à ce que tu m’envoies des mails, et je l’espère très bientôt.
      Bisous.

      Salut, je tiens vraiment à ce que tu saches que l’envie de t’envoyer un mail m’a toujours dévoré. Je n’osais pas te le dire avant, je suis timide, j’ai succombé à ton charme.
      Alors, j’espère recevoir de tes nouvelles bientôt.
      Bisous.";

      $message[]= "Salut,
      J'espère que tu vas bien depuis le temps et que tout ce passe bien dans ta petite vie, je viens de voir ton message désolé, je voulais savoir si tu avais un peu le temps à me consacrer j'ai besoin de parler à quelqu'un et je pense que tu es la personne idéal pour ça... Je te trouve mignon et super beau, j'ai vraiment envi de créer une relation durable avec toi, je suis attachantes de la conversation donc dès que tu reçois se message n'hésite surtout pas. Une fois avoir fait connaissance ensemble on pourrait aller boire un verre ensemble si ca te dit ?
      Tu ne seras pas déçu ca c'est une certitude, je peux en être sûre...
      J'attend ta réponse avec impatience et surtout avec envie...
      J’espère que tu n'en voudras pas à notre ami commun de m'avoir transmis ton mail. Ça fait longtemps que je voulais t'aborder afin que l'on puisse discuter. J'ai très fortement l'impression qu'il y a une attraction mutuelle entre nous et je serai vraiment déçue si je me trompais. Comme on dit qui tente rien n'a rien alors il me paraissait évident qu'il fallait que je franchisse le pas et que je sois la première à rompre la glace. J'imagine que tu as certainement deviné qui je suis, est ce que je me trompe? Quoi qu'il en soit, j'ai fait le premier pas en te contactant et maintenant la balle est dans ton camps pour me répondre. J’attends de tes nouvelles, et selon tes sentiments à mon égard, j'ose également espérer que nous puissions nous rencontrer juste toi et moi dans un futur très proche.
      Bisous et à bientôt... ";
      $message[]= "Bonjour,

      Ne sois surtout pas surpris par mon mail. Je ne suis pas du genre à faire le premier pas mais je dois avouer que je n’ai trouvé aucun autre moyen de t’approcher.

      Depuis notre dernière rencontre je n’ai pas cessé de penser à toi. Ton sourire est resté gravé dans ma mémoire et ta voix raisonne encore dans ma tête.

      Je ne sais pas pour qu’elle genre de fille tu vas me prendre mais je fais confiance au destin qui m’a fait croisé ton beau visage déjà une fois.

      J’aimerais beaucoup te revoir autour d’un café pour papauté un peu question de mieux te connaitre. Si tu es d’accord bien sur, enfin si tu es disponible et si le cœur t’en dit .

      Fais moi le plaisir de  ne pas laisser mon mail sans réponse, je suis prête à toute les éventualités .

      Merci et peut être à très bientôt.";

      $message[]= "Si je t'envoie un mail aujourd'hui, c'est que j'estime que c'est la meilleure manière de te prouver que j'essaye d'abord un contact classique permettant de mieux faire connaissance. En fonction de nos affinités que j'espère nombreuses, il sera envisageable de franchir le pas du virtuel au réel. Qu'en penses tu ? En espérant que ce mail te fasse réfléchir je t'embrasse d'ores et déjà.
      Salut
      Je sais que tu ne me connais pas encore, pourtant on se croise toujours sur un site de rencontre. Alors, je voulais t’envoyer cet email pour te dire que tu me plais beaucoup plus que tu ne le crois.
      J’espère que tu prendras en considération mes sincères sentiments et que tu me réponds vite. Je croise les doigts. ;-)
      À très bientôt";

      $message[]= "Hi
      Dieu merci, j’ai enfin retrouvé ton mail ! Je n’arrêtai pas de penser à toi depuis qu’on s’est rencontré sur le site de rencontre. Alors voilà, je… quand je pense à toi, je ne suis plus la même. Tu me rends folle.
      Si tu as un truc à me dire, surtout n’hésite pas.
      Bisous";

      $message[]= "Coucou
      J’hésitais un peu avant de t’envoyer ce mail, mais j’ai pris mon courage entre les mains et… me voilà hihihi.
      Je voudrais papoter un peu avec toi. Alors si tu as un temps libre, je suis là.
      Je t’embrasse";

      $message[]= "Salut
      Je ne sais pas si tu te souviens de moi. On était assis à côté dans le cours de sociologie. On pourrais se voir demain vers 14h si tu veux?
      Bisous";

      $message[]= "Salut
      J'ai adoré ce petit moment que nous avons passé ensemble hier. On pourrait se voir ce soir si tu es dispo.
      Bisous";

      $message[]= "Coucou
      Je serai près de chez toi demain soir. J'ai un rendez vous. Je peux passer chez toi si tu veux et surtout si tu peux.
      Bisous";

      $message[]= "Salut
      Nous devons nous voir pour le cadeau de Katy. On pourrait noir en verre ce soir si tu veux.

      Bisous";
      $message[]= "Bonjour!

      Je ne sais pas si te souviens encore de moi, la femme que tu as lancée un regard surprenant tout près de ma maison. Depuis, je n'arrête plus de pensé à ce beau regard, qui m'a vraiment touché l'intérieur. Je sais que ce n'est pas très agréable de le dire comme ça, mais je veux bien le dire en face si t'en a envie.

      C'était difficile de trouver ton Mail, mais une amie à moi te connait, elle m'a donné ton contact(entre amie). Merci à Elle.

      Je souhaiterai  croiser une deuxième fois ton beau regard, avec ton rire attirant. Je n'attends plus que ta réponse à présent et je t'avoue que j'ai vraiment hâte de te revoir, d'entendre ta voix et te dire en face ce que mon cœur ressent.

      Tu sais quoi? Le soleil ne brille plus comme avant depuis que t'es apparu dans ma vie.

      Bisou";
      $message[]= "Je n'ai cessé de penser à toit durant toute la nuit et j'ai senti que si je terminais cette journée sans t'écrire, mes journées ne seraient plus jamais pareilles. Je continue toujours de voir cette image de toi entrant dans ce restaurant et de nous en train de s'échanger nos contacts. En attente de te lire et pourquoi pas d'envisager une sortie.
      Je n'aurai jamais pensé que je serai la première à faire le premier pas, tellement tu hantes mes nuits et mes jours. J'espère juste que tu ne le prendras pas mal, mais ton adresse mail est le seul moyen de te contacter que j'ai à ma disposition. Je sais que tu es un homme très occupé et j'espère que tu trouveras un peu de temps libre pour lire mon message et me répondre ou me contacter, car je meurs d'envie de te revoir et de suivre le son de ta voix.
      Coucou ! Je viens de lire ton email à l’instant même, je dois t’avouer que je ne m’attendais pas à ce que tu me répondes. Tu as toujours envie de moi j’espère ?
      Bisous !";

      $message[]= "Salut ! Ça fait un moment que j’ai essayé de te joindre, c’est que je me sens un peu seule tu sais. Et moi je te manque ?
      Bises";

      $message[]= "Salut, Ça fait un bail, qu’est-ce que tu deviens ? J’ai repensé à ton dernier email et j’aimerai qu’on passe à la vitesse supérieure, si tu vois ce que je veux dire.
      ;) XOXO";

      $message[]= "Coucou toi !
      Je viens de voir ton email, j’ai cru que tu m’avais oublié. J’ai une de ces envies-là, pas toi ? Je suis du genre un peu direct, j’espère que ça ne te gêne pas trop.
      Bisous !";

      $message[]= "Bonjour, je dois t’avouer que j’ai un peu hésité à te recontacter, c’est que je ne voulais pas que tu me prennes pour une fille facile. Mais bon voilà, je vais me lancer, je n’ai pas cessé de repenser à ton mail, je peux toujours tenter ma chance j’espère.
      Gros bisou";
      $message[]= "Salut,

      Ça fait un bail que j’attends que tu me contactes mais j’ai l’impression que je vais encore poiroter un moment. Alors, j’ai décidé de te faire un petit coucou parce-que j’ai réussi à trouver  ton mail. Surpris ? Pas tant que ça je suppose car crois-moi tu me connais bien. Si l’envie te prend, rappelle-moi !!!!!
      ";

      $message[]= "Salut,

      On s'est croisé à une fête il y a quelques semaines. J'espère que tu te souviens de moi. Ma copine m'a donné ton adresse mail... parce qu'elle sait que tu me plais. Je suis célibataire et toi ? Contacte-moi... célibataire ou pas, j'aimerais beaucoup te revoir.
      J'espère que tout va bien pour toi et que j'aurai vite de tes nouvelles. Écris-moi vite !

      Je t'embrasse.";
      $message[]= "Coucou toi !

      Je suis désolée d'avoir mis autant de temps pour t'écrire, mais je ne suis pas vraiment fan des relations épistolaires à vrai dire... alors voilà, j'aimerais vraiment que nous puissions nous voir, pourquoi pas autour d'un verre ?
      Pour tout t'avouer, je trouve que le temps s'est écoulé beaucoup trop vite la dernière fois que nous avons discuté, et je pense que nous avons beaucoup de points communs, certaines choses me plaisent vraiment chez toi...

      Peut-être à bientôt? Tu as maintenant les cartes en main, je t'embrasse !
      Depuis notre conversation, j'avoue avoir souvent pensé à toi... J'ai aimé notre échange, sa profondeur mais aussi ton humour complètement dévastateur. J'ai espéré que tu me relances mais peut-être ne veux-tu pas donner de suite à ce dialogue pourtant prometteur ? Si tel est le cas, saches que je n'en serai absolument pas vexée... Déçue, oui mais vexée, non...! A très vite peut-être de te lire...


      Il y a très longtemps que je n'ai pas eu de tes nouvelles et cela me manque. Tu es si particulier, non seulement parce que tu es doté d'une belle intelligence mais surtout parce que tu es pourvu d'une immense sensibilité. C'est tellement rare et tellement magnifique que je ne peux m'empêcher de le souligner. A l'heure où tous les gens se renferment et vivent dans leur bulle, toi, tu rayonnes... Et tout cela me touche. A très bientôt peut-être...

      ";

      $message[]= "Coucou,
      En fait, je te croisé tous les jours en allant au travail et tu m'as tout de suite plu.
      Je suis trop timide pour t'aborder dans la rue mais j'ai réussi à retrouver ton mail.
      Ça te dirait qu'on se fasse un petit truc ensemble histoire de mieux se connaître ? N'hésite surtout pas à me répondre.
      Bon, je te dis à une prochaine fois alors.
      Bisous.";
      $message[]= "Bonjour, je n'ai pas pu résister à l'envie de t'écrire qui me démangeait tout le corps. En effet, cela fait plusieurs jours que ton visage est enregistré dans mon cerveau comme un enregistreur. Je sais que ce que je dis paraît insensé, mais c'est ce qui se passe en moi lorsque je pense à toi ou lorsque je croise ton joli visage. J'espère juste que tu prendras du temps pour me lire et pourquoi pas me répondre.
      Comment puis-je rester de marbre devant une telle beauté qui est tienne ? En effet, j'ai longtemps attendu le moment pour te dire ce que j'ai sur le coeur, mais je me suis toujours retenue en pensant que tu finiras un jour par faire le premier pas. C'est la principale raison pour laquelle j'ai décidé de t'envoyer un mail plutôt que de te faire face. J'espère que tu auras au moins la diligence de me répondre.
      ";
      $message[]= "Bonjour,
      Je te contacte aujourd'hui car je n'en peux plus d'attendre.
      J'ai vraiment flashé sur toi et je veux apprendre à mieux te connaître.
      Es-tu d'accord pour un rendez-vous dans un restaurant très prochainement ?
      Merci de me répondre vite, j'ai vraiment envie d'être à tes côtés.
      En attendant, Gros Bisous
      ";
      $message[]= "Hello,
      Tu te souviens de moi ?
      La brune à la robe rouge à qui tu as offert un café lundi dernier !
      Depuis je ne cesse de penser à toi et j'ai vraiment hâte de te rencontrer à nouveau.
      Réponds-moi vite qu'on se fixe un rendez-vous.
      Bisous bien tendres
      ";
      $message[]= "Salut Beau Gosse,
      Depuis que j'ai dansé avec toi, mon cœur est tout perturbé
      et tu es en permanence dans mes pensées.
      J'ai envie de te revoir pour être à nouveau dans tes bras.
      Je suis en congés actuellement alors profitons-en...
      Appelle-moi vite, je sais que tu as mon numéro.
      Bisous
      ";
      $message[]= "Je n'aurai jamais cru que je ferai le premier pas, tellement tu hantes mes nuits et mes jours. Si l'on m'avait dit que je tomberais follement amoureuse de quelqu'un comme ça un jour, jamais je ne l'aurais cru. Je me retrouve en train de t'envoyer un mail pour te faire part de mes sentiments. Qui l'aurait cru ? Je sais que tu es très occupé et j'espère que tu pourras trouver un peu de temps, ne serait-ce que pour me lire et pourquoi pas me donner une réponse favorable et pourquoi pas l'occasion de te le dire en face autour d'un rendez-vous.
      Je sais que cela semble un peu bizarre, le fait que je sois en train de faire, mais que peut la raison face à l'amour ? Rien je suppose ! C'est d'ailleurs ce qui explique le pourquoi je suis en train de t'écrire ce mail, espérant que tu trouves du temps pour le lire.
      ";


      $message[]= "Salut,


      Le temps a passé, mais je me souviens encore de nos échanges, et je prends la liberté de te recontacter. J'espère que tu ne m'en voudras pas... et que tu consultes toujours tes mails !

      J'aimerais que tu me répondes, que nous allions plus loin ensemble... N'hésite pas à m'envoyer un petit mail, à me faire un petit coucou, à me donner signe de vie !


      A bientôt j'espère.


      Bisous.

      ";


      $message[]= "Bonjour,

      Ça fait un bail que tu ne m’a pas écrit des mails, je pense toujours à toi tout le temps !
      Qu’est que tu fais en ce moment ? Pourquoi as-tu l’air si occupé ? J’ai envie de te rencontré
      Réponds-moi vite s’il te plait !

      Bisou
      ";
      $message[]= "Bonjour mon chou,

      Tu te souviens de moi !? On s’est déjà vu maintes fois, pourtant tu ne m’as jamais remarqué. Tu habites tout près de chez moi.
      Si tu as envie de me parler, n’hésitez pas à m’écrire des messages !
      Bisous
      ";
      $message[]= "Salut, on ne s’est jamais rencontrés, mais je te croise assez souvent sur le site de rencontre. J’ai longuement hésité de t’écrire en premier, mais bon, l’envie m’a surpassé.

      Et aujourd’hui, je me suis décidé de t’écrire un mail pour t’informer que j’éprouve quelques choses pour toi. J’aimerais vraiment te rencontrer. Merci de me répondre

      Bisou
      ";
      $message[]= "Coucou
      Je sais que c'est un peu stupide de t'écrire, mais il m'est facile de communiquer par mail que face à face Lol.
      Je suis la fille d’à côté celle qui travaille en face de ton bureau, cela fait déjà plus d’un mois qu'on se jette des regards sans rien nous dire à part salut.
      Voilà pourquoi aujourd’hui, j'ai décidé de briser la glace et de t'écrire parce que je pense qu'au fond, on pourra faire mieux que ça, d'autant plus que j'ai vraiment envie de te connaître ! Pas toi ?
      Si cela te tente après le boulot, on peut se voir histoire de bavarder un peu à toi le choix si on se voit dans un restaurant ou ailleurs seulement, je te préviens, je suis du genre un peu timide.
      Je te laisse réfléchir à ça et j'espère une réponse de ta part...
      Bref, bon courage pour ta journée de travail !
      Bise.
      ";

      shuffle($message);
      $r=rand(0,1);
      $texte[0] = $this->spin();
      $texte[1] = $message[0];
      return($texte[$r]);
    }

    public function objects()
        {
    	    $message[] = "J’ai enfin retrouver ton mail!!";

    		$message[] = "Tu comptes vraiment pas me répondre?";
    	$message[] = "Bonjour voisin...";
    	$message[] = "Salut toi, je t’ai enfin retrouvée…";
    	$message[] = "Ca te dérange les filles comme moi?";
    	$message[] = "Tu attends quoi pour me répondre?";
    	$message[] = "Te souviens-tu de moi?";
    	$message[] = "J’espère que tu n’en voudras pas à celui qui m’a donné ton mail…";
    	$message[] = "J’ai enfin fini par te trouver!!";
    	$message[] = "Tu n’es plus sur les sites de rencontres?";
    	$message = "";
    	$message[] = "Salut beaugosse tu es là?";
    	$message[] = "C’est pas bien de faire attendre les femmes!";
    	$message[] = "Jamais tu te décides à répondre toi?";
    	$message[] = "Je dois faire quoi pour que tu me calcules?";
    	$message[] = "Tu ne veux plus répondre?";


    	shuffle($message);
    	return ($message[0]);
    	    }

    public function spinnage($text){

          if(!preg_match("/{/si", $text)) {

          return $text;

           }
                  else {
          preg_match_all("/\{([^{}]*)\}/si", $text, $matches);
          $occur = count($matches[1]);
          for ($i=0; $i<$occur; $i++)
          {
                  $word_spinning = explode("|",$matches[1][$i]);
                  shuffle($word_spinning);
                  $text = str_replace($matches[0][$i], $word_spinning[0], $text);
          }
  		return  $this->spinnage($text);
  		}
      }

    public function sendiblue()
    {
      $rand = array(292,291,290,288,287,286,285,284,283,282,281,280,279,278,277,276,275,274,272,273,271,270,269,268,267,266,265,264,263,262,261,260,259,258,257,256,255,254,253,252,251,250,249,248,247,246,245,244,243,241,240,239,238,237,236,235,234,233,232,231,230,242,197,229,228,227,224,225,223,222,221,220,219,217,216,210,209,198,191,185,163,148,142,140,137,133,130,129,125,122,120,119,117,45,141,89,86,66,78,74,75);
      shuffle($rand);
      $kit = json_decode(shell_exec("curl -H 'api-key:ph1Tx72LKAHfmV6E' -X GET 'https://api.sendinblue.com/v2.0/campaign/".$rand[0]."/detailsv2'"),true);
      $return['html'] = $kit['data'][0]['html_content'];
      $return['subject'] = $kit['data'][0]['subject'];
      $return['name'] = $kit['data'][0]['from_name'];
      print_r($return);
      return($return);

    }
}
