<?php

class People extends Model
{

	public function updatePeople($idPeople,$note)
	{
		$collection = $this->db->People;
		$updateResult = $collection->updateOne(
		    ['_id' => new MongoDB\BSON\ObjectID($idPeople)],
				[
					'$set'=> [
						'note'=> $note['note'],
						'BackNote'=> $note['BackNote'],
						'lastsend'=> $_SERVER['REQUEST_TIME']
					],
					'$inc' => ['count' => 1]
				]
		);
	}

	public function deleteDomToPeople($idPeople)
	{
		$collection = $this->db->People;
		$updateResult = $collection->updateOne(
		    ['_id' => new MongoDB\BSON\ObjectID($idPeople)],
				[
					'$unset'=> [
						'domain'=> "",
					]
				]
		);
	}

	public function count()
	{
		$collection = $this->db->People;
    $query = $collection->find(['lastsend' => ['$gt' => strtotime("-5 hours",$_SERVER['REQUEST_TIME'])]]);
		foreach ($query as $document) {
   			$result[] = $document;
		}
	//	$result = json_decode(json_encode($query),true);
		$count = count($result);
		return($count);
	}

	public function findPeople($nb,$Domain)
	{
			$collection = $this->db->People;

			$DomExport['id'] = $Domain['_id']['$oid'];
      $DomExport['domain'] = $Domain['domain'];
			unset($Domain);
			while($nb != 0)
			{
				$query = $collection->findOneAndUpdate(
					[
						'domain' => ['$exists' => false],
						'note' => ['$gt' => 0]
					],
					[
						'$set'=> [
							'domain'=> $DomExport
						]
					]
				);
				$result[] = json_decode(json_encode($query),true);
				$nb--;
			}
			return($result);
	}

	public function peopleDetail($_id)
	{
		$collection = $this->db->People;
		$query = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_id)]);
		$result = json_decode(json_encode($query),true);
		return($result);
	}

	public function peopleDetailNote($id)
	{
		$collection = $this->db->People;
		$query = $collection->findOne(
			['_id' => new MongoDB\BSON\ObjectID($id)],
			['projection' =>
				['note' => 1]
			]
		);
		$result = json_decode(json_encode($query),true);
		return($result['note']);
	}

}
