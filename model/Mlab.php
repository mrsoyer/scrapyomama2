<?php

class Mlab extends Model
{

    public function MLab($e)
    {
    	return new MongoAPI("sandbox","qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8","People");
    }


    public function savePeople()
    {
        $mongo = $this->MLab($e);
		    return($mongo->insert($e->query));
    }

    public function get($e)
    {
    	$mongo = $this->MLab($e);
	    return $mongo->get($e[1]);
    }

    public function updatePeople($e)
    {
    	$mongo = $this->MLab();
	    return $mongo->updatebyid($put,$e[0]);
    }








}
