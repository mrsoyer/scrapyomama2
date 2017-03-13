<?php

class People extends Model
{

	public function updatePeople($people,$note,$Domain)
	{
		$collection = $this->db->People;
		$updateResult = $collection->updateOne(
		    ['_id' => new MongoDB\BSON\ObjectID($people[_id]['$oid'])],
				[
					'$set'=> [
						note=> $note['note'],
						BackNote=> $note['backnote'],
						lastsend=> time(),
						domain=> $Domain
					],
					'$inc' => [count => 1]
				]
		);
	}

	public function findPeople()
	{
		$collection = $this->db->People;
			$query = $collection->find([domain => ['$exists' => false], 'note' => ['$gt' => 0]],['limit' => 1000]);
			foreach ($query as $document) {
	   			$result[] = $document;
			}
			$result = json_decode(json_encode($result),true);
			$result= $result[rand(0,count($result))];
			return($result);
	}

	public function peopleDetail($_id)
	{
		$collection = $this->db->People;
		$query = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_id)]);
		$result = json_decode(json_encode($query),true);
		return($result);
	}

}
