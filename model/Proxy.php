<?php

class Proxy extends Model
{
    public $table = 'proxys';

    
    public function getDownProxys()
    {
        $proxys = $this->query("SELECT * FROM `proxys` WHERE `expire` >= CURDATE() ORDER BY rand() LIMIT 1");

        return ($proxys);
    }

       
}
