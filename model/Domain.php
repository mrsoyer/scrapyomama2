<?php

class Domain extends Model
{


	public function selectDom()
	{
		$collection = $this->db->Domain;
    $query = $collection->find(
	    ['account' => ['$exists' => true],'proxy' => ['$exists' => true]],
			['projection' =>
				[
					'_id' => 1,
					'note' => 1,
					'lastsend' => 1
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

	public function selectDomProxy($sk)
	{
		$collection = $this->db->Domain;
    $query = $collection->find(
	    ['account' => ['$exists' => true],'proxy' => ['$exists' => false]],
			[
				'limit' => $sk
			]
		);
		foreach ($query as $document) {
   			$result = $document;
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

	public function updateDomain($idDomain)
	{
		$set['$set']['note'] = 0;
		$set['$set']['lastsend'] = $_SERVER['REQUEST_TIME'];
		$collection = $this->db->Domain;
		$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
    $q = $collection->updateOne($query,$set);
	}



	public function updateEndDomain($idDomain,$set)
	{
		$collection = $this->db->Domain;
		$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
    $q = $collection->updateOne($query,$set);
	}

	public function updateProxyDomain($idDomain,$proxy)
	{
		$set['$set']['proxy'] = $proxy;
		$collection = $this->db->Domain;
		$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
    $q = $collection->updateOne($query,$set);
	}

	public function atej()
	{
		$collection = $this->db->Domain;
    $query = $collection->find(
	    ['account' => ['$exists' => true]]
		);

		foreach ($query as $document) {
			$newaccount = array();
				$d = json_decode(json_encode($document),true);
   			$account=$d['account'];
				foreach($account as $k=>$v)
				{
					$mystring = $v;
					$findme   = $d['domain'];
					$pos = strpos($mystring, $findme);

					// Notez notre utilisation de ===.  == ne fonctionnerait pas comme attendu
					// car la position de 'a' est la 0-ième (premier) caractère.
					if ($pos === false) {

					} else {
					    	$newaccount[] = $v;
					}


				}
				$this->atej2($d,$newaccount);
		}

	}

	public function atej2($d,$newaccount)
	{
		$collection = $this->db->Domain;
		$query['_id'] = new MongoDB\BSON\ObjectID($d['_id']['$oid']);
		$set['$set']['account'] = $newaccount;
		$q = $collection->updateOne($query,$set);
	}
}
