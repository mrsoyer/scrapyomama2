<?php

class Logs extends Model
{


	public function insert($e)
	{
		$collection = $this->db->Logs;
    $collection->insertOne($e);
		$collection->deleteMany(['insert' =>  [$lt => strtotime("-1 day")]]);
	}

	public function domDetail($_id)
	{
		$collection = $this->db->Domain;
		$query = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_id)]);
		$result = json_decode(json_encode($query),true);
		return($result);
	}

	public function updateDomain($idDomain,$set,$query)
	{

		$collection = $this->db->Domain;
		$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
    $q = $collection->updateOne($query,$set);
	}
}
