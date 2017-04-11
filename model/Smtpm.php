<?php

class Smtpm extends Model
{
	public $table = 'cards';
    public $debug = true;

	public function addMail($v)
	{
		print_r($v);
		$collection = $this->db->Smtp;
		$insertOneResult = $collection->insertOne([
		    'mail' => $v[0],
		    'pass' => $v[1],
		    'status' => 1

		]);

		printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

		var_dump($insertOneResult->getInsertedId());
	}

	public function findSmtp()
	{
			$collection = $this->db->Smtp;
				$query = $collection->findOneAndUpdate(
					[
						'status' => 1,
					],
					[
						'$set'=> [
							'status'=> 0
						]
					]
				);
				$result = json_decode(json_encode($query),true);


			return($result);
	}
}
