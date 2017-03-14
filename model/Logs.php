<?php

class Logs extends Model
{


	public function insert($e)
	{
		$collection = $this->db->Logs;
    $collection->insertOne($e);
		$collection->deleteMany(['insert' =>  ['$lt' => strtotime("-1 day")]]);
	}

	public function log()
	{
		$collection = $this->db->Logs;
		$cursor = $collection->find(
		    [],
		    [
		        'limit' => 1000,
		        'sort' => ['insert' => -1],
		    ]
		);

		foreach ($cursor as $document) {
			 $document = json_decode(json_encode($document),true);
			 $result[$document['_id']['$oid']] = $document;
			}
			return($result);
		}
}
