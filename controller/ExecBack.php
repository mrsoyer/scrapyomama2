<?php

class ExecBack extends Controller
{

    public function b($e)
    {
    	$query = "";
    	foreach($e as $k => $v)
    	{
	    	$query .= " ".$v;
    	}
    	echo exec("php index.php ExecBack exeb".$query." > /dev/null 2>&1 &");//
    	 //php index.php Profilinfo index 18 
    	
    }    
    
    
    public function exeb($e)
    {
    	$query = "";
    	foreach($e as $k => $v)
    	{
	    	$query .= " ".$v;
    	}
    	
	    $result = exec("php index.php".$query);
    }
}