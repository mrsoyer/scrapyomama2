<?php

class Freenoms extends Model
{
	public $table = 'cards';
    public $debug = true;

		public function addDom($v)
		{
			print_r($v);
			$collection = $this->db->freenom;
			$insertOneResult = $collection->insertOne([
			    'dom' => $v,
			    'insert' => time(),
			    'status' => 0

			]);

			printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

			var_dump($insertOneResult->getInsertedId());
		}

		public function findOneDom()
		{
				$collection = $this->db->freenom;

					$f = ['insert' => ['$lt' => strtotime("-1 hour",time())]];
					$query = $collection->findOneAndDelete($f);
					$result = json_decode(json_encode($query),true);
					$result = $result['dom'];

					return($result);
		}
}
