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
		$query = $collection->findOneAndUpdate(
			[
				'end' => ['$exists' => false],
			],
			[
				'$inc' => ['count' => 1]
			],
			[
        'sort' => ['create' => 1],
    	]
		);
		$result = json_decode(json_encode($query),true);
		if($result['count']>$result['limit'])
		{
			$q = new MongoDB\BSON\ObjectID($result['_id']['$oid']);
			$set['$set']['end'] = 1;
			$q = $collection->updateOne($q,$set);
		}
		return($result);
	}


}
