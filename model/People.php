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

	public function updateOnePeople($people)
	{
		$collection = $this->db->People;
		$updateResult = $collection->updateOne(
		    ['_id' => new MongoDB\BSON\ObjectID($people['_id']['$oid'])],
				[
					'$set'=> [
						'note'=> $people['note'],
						'BackNote'=> $people['BackNote'],
						'nextSend'=> $people['nextSend']
					],
					'$inc' => ['count' => 1]
				]
		);
	}

	public function updatePeopleNote($idPeople,$note)
	{
		$collection = $this->db->People;
		$updateResult = $collection->updateOne(
		    ['_id' => new MongoDB\BSON\ObjectID($idPeople)],
				[
					'$set'=> [
						'note'=> $note,
						'BackNote'=> $note
					]
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

	public function deletePeople($idPeople)
	{
		$collection = $this->db->People;
		$updateResult = $collection->deleteOne(
		    ['_id' => new MongoDB\BSON\ObjectID($idPeople)]
		);
	}

	public function count()
	{
		$collection = $this->db->People;
    $query = $collection->find(['lastsend' => ['$gt' => strtotime("-24 hours",$_SERVER['REQUEST_TIME'])]]);
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
	public function findAllPeople($nbinsert)
	{
			$collection = $this->db->People;



				$query = $collection->find(
					[
						'$or' => [
							[
								'lastsend' => [ '$exists' => false]
							],
							[
								'lastsend' => ['$lt' => strtotime("-1 day",$_SERVER['REQUEST_TIME'])],
								'nextsend' => [ '$exists' => false]
							],
							[
								'lastsend' => ['$lt' => strtotime("-1 day",$_SERVER['REQUEST_TIME'])],
								'nextsend' => ['$lt' => strtotime("-1 day",$_SERVER['REQUEST_TIME'])]
							]
						]

					],
					[
						'limit' => $nbinsert,
						'sort' => ['note' => -1, 'nextsend' => 1]
					]
				);

				foreach ($query as $document) {
		   			$result = json_decode(json_encode($document),true);
						if(isset($result['_id']['$oid']))
						{
							$or[]['_id'] = new MongoDB\BSON\ObjectID($result['_id']['$oid']);
							$result['id'] = $result['_id']['$oid'];
							unset($result['_id']);
							$insert[] = $result;
						}
				}

				if(count($or)>0)
				{
					$updateResult = $collection->updateMany(
							['$or' => $or],
							[
								'$set'=> [
									'lastsend'=> $_SERVER['REQUEST_TIME']
								]
							]
					);
					unset($collection);
					$collection2 = $this->db->PeopleShoot;
					$insertManyResult = $collection2->insertMany($insert);
				}



	}

	public function findOnePeople()
	{
			$collection = $this->db->PeopleShoot;



				$query = $collection->findOneAndDelete([]);
				$result = json_decode(json_encode($query),true);
				$result['_id']['$oid'] = $result['id'];
				unset($result['id']);

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
