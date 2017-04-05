<?php

class Proxy extends Model
{
  public function insertProx($v)
  {
    $collection = $this->db->Proxy;
    $insertOneResult = $collection->insertOne([
        'ip' => $v['ip'],
        'end' => $v['end'],
        'create' => 0,
        'status' => 1,
        'error' => 0,
        'lastsend' => 0
    ]);

    printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

    var_dump($insertOneResult->getInsertedId());

  }

  public function selectProx()
	{
		$collection = $this->db->Proxy;
    $result = array();
    $query = $collection->find(
	    [
        'lastsend' =>['$lt' => strtotime("-1 hours",$_SERVER['REQUEST_TIME'])] ,
        'error' => ['$lt' => 5],
        'end' => ['$gt' => $_SERVER['REQUEST_TIME']],
        'status' => 1
      ],
			[
        'sort' => ['lastsend' => -1]
			]
		);
		foreach ($query as $document) {
   			$result[] = json_decode(json_encode($document),true);
		}
		return($result);
	}

  public function addAccount($proxId,$smtp)
	{
		$collection = $this->db->Proxy;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($proxId)],
			['$set' => [
				'smtp' => $smtp,
        'lastsend' => $_SERVER['REQUEST_TIME']
				]
			]
		);
	}

  public function killProx($proxId)
	{
		$collection = $this->db->Proxy;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($proxId)],
			['$set' => [
				'status' => 0
				]
			]
		);
	}

  public function domDetailUpdate($idDomain)
	{
			$set['$set']['error'] = 0;
			$set['$set']['lastsend'] = $_SERVER['REQUEST_TIME'];
			$collection = $this->db->Proxy;
			$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
	    $q = $collection->findOneAndUpdate($query,$set);
			$result = json_decode(json_encode($q),true);
			return($result);
	}

  public function domUpdate($idDomain)
	{

			$set['$set']['lastsend'] = $_SERVER['REQUEST_TIME'];
			$collection = $this->db->Proxy;
			$query['_id'] = new MongoDB\BSON\ObjectID($idDomain);
	    $q = $collection->findOneAndUpdate($query,$set);
			$result = json_decode(json_encode($q),true);
			return($result);
	}

  public function proxError($proxId,$note)
	{
		$collection = $this->db->Proxy;
		$query = $collection->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($proxId)],
			['$set' => [
				'error' => $note
				]
			]
		);
	}

}
