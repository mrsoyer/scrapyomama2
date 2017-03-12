<?php
//include ROOT.'/controller/Api.php';


class SYM extends Controller
{


  public function index($e)
  {
    $sym =  $this->newsym('Api');

    $symheader = str_split('
///////////////////////////////////////////////////////////////////////////////|
//       __________  __   __   __    __                                       ||
//     / _________/ | |  / /  /  |  /  |
//    / /_______    | | / /  /   | /   |
//    \______   \   | |/ /  / /| |/ /| |
//   ________/  /   |   /  / / |   / | |
/   /__________/    /  /  /_/  |__/  |_|
//  ScrapYoMama    /__/    by barney.im
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*
');
  $symman = "
  // API/V1 -> mongodb
  // mail/smtp([to, from, smtp, user, pass, proxy, useragent, sujet, message, file]);
  // mail/smtpOVH(to, from, sujet, message, file)
  // mail/cleaner(to,from)
  // mail/kitmail([nom, sujet, lienmessage])
  // bot/
  // ovh/
  // crm/
  // aff/
  //  fb/
  //  insta/
  //  graph
  //domaine1 ouvreur(20%) ||||||||||||||||||||||||||||||||||||||||||||||||||
  //";
  foreach ($symheader as $key => $value) {
    print_r($value);
    usleep(1000);# code...
  }

  print_r($symman);
  $async = $this->newsym('Async');
  $reponse = $async->sync(json_decode(file_get_contents(dirname(dirname(__FILE__))."/json/sym.json"),true));



  }

    public function sayHello($params)
    {
        echo ("Les paramertres sont : ". $params[0]. " et ".$params[1]);
    }

    public function colorjson($json)
    {
      print_r ("
      <html><head>
      <style>
      pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
      .string { color: green; }
      .number { color: darkorange; }
      .boolean { color: blue; }
      .null { color: magenta; }
      .key { color: red; }
      </style>
      <link rel=\"alternate stylesheet\" type=\"text/css\" href=\"resource://gre-resources/plaintext.css\" title=\"Retour à la ligne automatique\"></head><body>
      <script>
      function output(inp) {
          document.body.appendChild(document.createElement('pre')).innerHTML = inp;
      }

      function syntaxHighlight(json) {
          json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
          return json.replace(/(\"(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\\"])*\"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
              var cls = 'number';
              if (/^\"/.test(match)) {
                  if (/:$/.test(match)) {
                      cls = 'key';
                  } else {
                      cls = 'string';
                  }
              } else if (/true|false/.test(match)) {
                  cls = 'boolean';
              } else if (/null/.test(match)) {
                  cls = 'null';
              }
              return '<span class=\"' + cls + '\">' + match + '</span>';
          });
      }

      var obj = ".$json.";
      var str = JSON.stringify(obj, undefined, 4);


      output(syntaxHighlight(str));

      </script>
      </body></html>
      ");
    }

}
