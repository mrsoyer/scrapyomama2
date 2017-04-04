<?php

class Dom extends Model
{


	public function insertDom($v)
	{
		$collection = $this->db->Dom;
		$insertOneResult = $collection->insertOne([
		    'domain' => $v['domain'],
		    'nb' => $v['nb'],
				'create' => $v['nb'],
		    'status' => 1,
				'error' => 0,
				'lastinsert' => 0
		]);

		printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

		var_dump($insertOneResult->getInsertedId());

	}

	public function findOneDom()
	{
		$collection = $this->db->Dom;
    $query = $collection->findOne(
	    [
        'error' => ['$lt' => 5],
        'status' => 1,
				'create' => ['$gt' => 0]
      ],
			[
        'sort' => ['lastinsert' => 1]
			]
		);
   			$result = json_decode(json_encode($query),true);
		return($result);
	}

	public function addCAccount($proxId,$domId,$name)
	{
		$collection = $this->db->Dom;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($domId)],
			['$set' =>
				[
					'account' =>
					[
						[
							'name' => $name,
							'proxy' => $proxId
						]
					],
					'lastinsert' => $_SERVER['REQUEST_TIME']
				],
				'$inc' => [
					'create' => -1,
					]
			]
		);
	}

	public function addAccount($proxId,$domId,$name)
	{
		$collection = $this->db->Dom;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($domId)],
			['$addToSet' =>
				[
					'account' =>
					[
							'name' => $name,
							'proxy' => $proxId
					]
				],
				'$set' => [
					'lastinsert' => $_SERVER['REQUEST_TIME']
				],
				'$inc' => [
					'create' => -1,
					]
			]
		);
	}

	public function domError($domId)
	{
		$collection = $this->db->Dom;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($domId)],
			['$inc' => [
				'error' => 1,
				]
			]
		);
	}

	public function suppAccount($domain,$account)
	{
		/*$collection = $this->db->Dom;
		$query = $collection->updateOne(
			['domain' => $domain],
			['$pull' => [
				'account' => 1,
				]
			]
		);
		{ },
    { $pull: { fruits: { $in: [ "apples", "oranges" ] }, vegetables: "carrots" } },
    { multi: true }*/
	}
}
