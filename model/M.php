<?php

class M extends Model
{


	public function hello()
	{
		$collection = $this->db->bop;
		$collection->insertOne(['name' => 'Bob', 'state' => 'ny']);
    $collection->insertOne(['name' => 'Alice', 'state' => 'ny']);
    $updateResult = $collection->findOneAndUpdate(
	    ['name' => 'Bob'],
	    ['$set' => ['state' => 'nyy']],
	    ['upsert' => true]
		);
		return($updateResult);
	}
}
