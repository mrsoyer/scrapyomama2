<?php

class Domain extends Model
{


	public function selectDom()
	{
		$collection = $this->db->Domain;
    $query = $collection->find(
	    [account => ['$exists' => true]],
			[projection =>
				[
					"_id" => 1,
					"note" => 1,
					lastsend => 1
				],
				'limit' => 100
			]
		);
		foreach ($query as $document) {
   			$result[] = $document;
		}
		$result = json_decode(json_encode($result),true);
		return($result);
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
