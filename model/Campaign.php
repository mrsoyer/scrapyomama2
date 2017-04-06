<?php

class Campaign extends Model
{

	public function newCamp($info)
	{
		$collection = $this->db->Campaign;
		$insertOneResult = $collection->insertOne($info);

		printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

		var_dump($insertOneResult->getInsertedId());
	}

	public function selectcamp()
	{
		$collection = $this->db->Campaign;
		$query = $collection->findOne(
			[
				'end' => ['$exists' => false]
				//'error' => ['$lt' => 10]
			],
			[
        'sort' => ['create' => 1],
    	]
		);
		$result = json_decode(json_encode($query),true);
		if($result['count']>$result['limit'])
		{
			$q['_id'] = new MongoDB\BSON\ObjectID($result['_id']['$oid']);
			$set['$set']['end'] = 1;
			$q = $collection->updateOne($q,$set);
		}
		return($result);
	}

	public function updateCamp($idCamp,$nb)
	{
		$collection = $this->db->Campaign;

			$q['_id'] = new MongoDB\BSON\ObjectID($idCamp);
			$set['$inc']['count'] = $nb;
			$q = $collection->updateOne($q,$set);

	}
	public function errorCamp($idCamp)
	{
		$collection = $this->db->Campaign;

			$q['_id'] = new MongoDB\BSON\ObjectID($idCamp);
			$set['$inc']['error'] = 1;
			$q = $collection->updateOne($q,$set);

	}


}
