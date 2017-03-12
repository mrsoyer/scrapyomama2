<?php

$tweet = file_get_contents("html.txt");
//echo $tweet;



preg_match_all('/@(\w{1,15})\b/', $tweet, $retweets);

$i=0;

$value = array_unique($retweets[1]);
//print_r($value);

 
foreach($value as $values)
{
	
		//$b = file_get_contents("https://www.instagram.com/".$values."/");
		
		$url = "https://www.instagram.com/".$values."/";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_PROXY, "37.48.118.90:13082"); 
		$b = curl_exec($curl);
		curl_close($curl);
		
		
		$b = explode('"followed_by": {"count":', $b);
		$b = explode('},', $b[1]);
		echo $values ." : ".$b[0];
		
		if($b[0] > 5000){
			echo " OK ";
			
			
			$contenu = $values."\r\n";
			
			 
			// on ouvre le fichier en écriture avec l'option a
			// il place aussi le pointeur en fin de fichier (il tentera de créer aussi le fichier si non existant)
			$h = fopen("user.txt", "a");
			fwrite($h, $contenu);
			fclose($h);

		}else{
			echo " PAS OK ";
		}
		echo " \n ";
		
		
	//sleep(1);
	$i++;
}