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
						BackNote=> $note['BackNote'],
						lastsend=> time()
					],
					'$inc' => [count => 1]
				]
		);
	}

	public function count()
	{
		$collection = $this->db->People;
    $query = $collection->find(['lastsend' => ['$gt' => strtotime("-1 day")]]);
		foreach ($query as $document) {
   			$result[] = $document;
		}
	//	$result = json_decode(json_encode($query),true);
		$count = count($result);
		return($count);
	}

	public function findPeople($sleep,$Domain)
	{
		$collection = $this->db->People;
			$query = $collection->find([domain => ['$exists' => false], 'note' => ['$gt' => 0]],['limit' => $sleep]);
			foreach ($query as $document) {
	   			$result = $document;
			}
			$result = json_decode(json_encode($result),true);

			$DomExport[id] = $Domain[_id]['$oid'];
      $DomExport[domain] = $Domain[domain];
			$updateResult = $collection->updateOne(
			    ['_id' => new MongoDB\BSON\ObjectID($result[_id]['$oid'])],
					[
						'$set'=> [
							domain=> $DomExport
						]
					]
			);
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
