<?php
//header('Content-Type: application/json');
require ROOT.'/vendor/mongo-api-php/mongoapi.class.php';
class Api extends Controller
{
	public function index()
	{
		echo '
///////////////////////////////////////////////////////////////////////////////|
//                                           __________  __   __   __    __   ||
//  symheader.php                          / _________/ | |  / /  /  |  /  |  ||
//                                        / /_______    | | / /  /   | /   |  ||
//                                        \______   \   | |/ /  / /| |/ /| |  ||
//  Created: 2015/10/29 12:30:05         ________/  /   |   /  / / |   / | |  ||
//  Updated: 2015/10/29 21:45:22        /__________/    /  /  /_/  |__/  |_|  ||
//                                      ScrapYoMama    /__/    by barney.im   ||
//____________________________________________________________________________||
//-----------------------------------------------------------------------------*
// all result collection /<coll>
// result by id /<coll>/<id>
// insert /<coll> + var(p)
// update by id /<coll>/<id> + var(p)
// update by query /<coll>/ + var(q) + var(p)  optinal : var(a) affich result
// delete by id /<coll>/<id> + var(d)
// delete by query /<coll>/ + var(q) + var(d)

--------------var()--------------
Q: query
		usage:
			get: /-q=<json>/   |OR|  /-q/var1=val1/var2=val2/
			argv: -q=<json>   |OR|  -q	var1=val1	var2=val2
			var $e["_q"] = array()

P: post
		usage:
		  post: $_POST = <json>
			get: /-p=<json>/   |OR|  /-p/var1=val1/var2=val2/
			argv: -p=<json>   |OR|  -p	var1=val1	var2=val2
			var $e["_p"] = array()

SB: sandbox mode
		usage:
			get: -sb
			argv: -sb
			var $e["_db"] = "sandbox"

A: affich
	only for DELETE & UPDATE by default number of delete/update
	get: -a
	argv: -a
	var $e["_a"] = 1

D: delete
		get: -d
		argv: -d
		var $e["_d"] = 1

feature:
	ps= insert multiple by get or argv
	c=true - return the result count for this query
	f=<set of fields> - specify the set of fields to include or exclude in each
			document (1 - include; 0 - exclude)
	fo=true - return a single document from the result set (same as findOne()
			using the mongo shell
	s=<sort order> - specify the order in which to sort each specified field
			(1- ascending; -1 - descending)
	sk=<num results to skip> - specify the number of results to skip in the
					result set; useful for paging
	l=<limit> - specify the limit for the number of results (default is 1000)
		';
	}
	public function V1($e)
	{
		$e = $this->tcheckRequest($e);
		$json = $this->dir($e);
		//if(isset($e['_print']))
			//	print_r($json);
	//	else
			//print_r(json_encode($json,JSON_PRETTY_PRINT));*/

		return $json;
	}

//--------------connect mlab -----------------//
	public function MLab($e)
	{
		return new MongoAPI($e['_db'],"qBDvuOxxv4Q9KJYiZ7vEQbDqYPuEWPW8",$e['_coll']);
	}

//--------------end mlab -----------------//
//--------------construct request -----------------//

	public function dir($e)
	{

			if(isset($e['_q']) && isset($e['_p']))
			{
				if(isset($e['_a']))
					$result = $this->updateOneByOne($e);
				else
					$result = $this->update($e);
			}
			else if(isset($e['_id']) && isset($e['_p']))
				$result = $this->updatebyid($e);
			else if(isset($e['_q'])  && isset($e['_d']))
			{
				if(isset($e['_a']))
					$result = $this->deleteOneByOne($e);
				else
					$result = $this->delete($e);
			}
			else if(isset($e['_id']) && isset($e['_d']))
				$result = $this->deletebyid($e);
			else if(isset($e['_p']))
				$result = $this->insert($e);
			else if(isset($e['_ps']))
				$result = $this->insertMultiple($e);
			else if(isset($e['_q']))
				$result = $this->find($e);
			else if(isset($e['_id']))
				$result = $this->get($e);
			else
				$result = $this->get($e);

			return($result);
	}
	public function tcheckRequest($e)
	{
			$e = $this->tcheckdb($e);
			$e = $this->tcheckVar($e, "d");
			$e = $this->tcheckVar($e, "a");
			$e = $this->tcheckVar($e, "print");
			$e = $this->tcheckColl($e);
			$e = $this->tcheckGet($e,"q");
			if($put = file_get_contents("php://input"))
	    			$e['_p'] = json_decode($put);
			else
				$e = $this->tcheckGet($e,"p");

			$e = $this->tcheckGetMulti($e,"ps");
			if(!isset($e['_q']) && isset($e[0]))
			{
				$e['_id'] = $e[0];
				unset($e[0]);
			}
			return($e);

	}

	public function tcheckdb($e)
	{
		if(!isset($e['_db']))
			$e['_db'] = "sym";

		$i = 0;
		foreach($e as $k => $v)
		{
			if($v == "-sb")
			{
				$e['_db'] = "sandbox";
				unset($e[$k]);
			}
			else {
				if(is_int($k))
				{
					$e[$i]=$v;
					if($i<$k)
						unset($e[$k]);
					$i++;
				}
			}
		}
		return ($e);
	}

	public function tcheckVar($e,$v)
	{


		$i = 0;
		foreach($e as $k => $va)
		{
			if($va == "-".$v)
			{
				$e['_'.$v] = 1;
				unset($e[$k]);
			}
			else {
				if(is_int($k))
				{
					$e[$i]=$va;
					if($i<$k)
						unset($e[$k]);
					$i++;
				}
			}
		}
		return ($e);
	}

	public function tcheckColl($e)
	{
		$i = 0;
		if(!isset($e['_coll']))
		{
			foreach($e as $k => $v)
			{
				if($k == "0")
				{
					$e["_coll"] = $v;
					unset($e[$k]);
				}
				else {
					if(is_int($k))
					{
						$e[$i]=$v;
						if($i<$k)
							unset($e[$k]);
						$i++;
					}
				}
			}
		}


		return $e;
	}

	public function tcheckGet($e,$g)
	{
		if(!isset($e['_'.$g]))
		{
			foreach($e as $k => $v)
			{
				if($v == "-".$g)
				{
					$e = $this->createGet($e,$k,$g);
				}
				if(is_string($v) && strpos($v, "-".$g."=") !== false)
				{
					$va = explode("-".$g."=", $v);
					$e["_".$g] = json_decode($va[1]);
					unset($e[$k]);
				}
			}
		}
		return ($e);
	}

	public function tcheckGetMulti($e,$g)
	{
		if(!isset($e['_'.$g]))
		{
			foreach($e as $k => $v)
			{
				if($v == "-".$g)
				{
					$e = $this->createGet($e,$k,$g);
				}
				if(is_string($v) && strpos($v, "-".$g."=") !== false)
				{
					$va = explode("-".$g."=", $v);
					$e["_".$g] = json_decode($va[1]);
					unset($e[$k]);
				}
			}
		}
		return ($e);
	}

	public function createGet($e,$i,$g)
	{
		$const = 1;
		$q = new \stdClass;
		foreach($e as $k => $v)
		{
			if($k >= $i)
			{
				if($v == "-".$g)
					unset($e[$k]);
				else if($const == 1)
				{
					if(strpos($v, "-") !== false && is_int($k))
					{
						$const = 0;
						$e[$i]=$v;
						if($i<$k)
							unset($e[$k]);
						$i++;
					}
					else if(strpos($k, "_") === false)
					{
						$va = explode("=", $v);
						$q->$va[0] = $va[1];
						unset($e[$k]);
					}
				}
				else {
					if(is_int($k))
					{
						$e[$i]=$v;
						if($i<$k)
							unset($e[$k]);
						$i++;
					}
				}
			}
		}
		$e['_'.$g] = $q;
		return $e;
	}

	//--------------end construct request -----------------//
	//--------------call mlab -----------------//
	public function get($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->get($e["_id"],$e["_sup"]);
	}

	public function find($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->find($e["_q"],$e["_sup"]);
	}

	public function insert($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->insert($e["_p"],$e["_sup"]);
	}

	public function insertMultiple($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->insertMultiple($e["_ps"],$e["_sup"]);
	}

	public function updatebyid($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->updatebyid($e["_p"],$e["_id"],$e["_sup"]);
	}

	public function updateOneByOne($e)
	{
			$mongo = $this->MLab($e);
			$find = $mongo->find($e["_q"]);
			foreach ($find as $key => $value) {
				$result[] = $mongo->updatebyid($e["_p"],$value["_id"]['$oid'],$e["_sup"]);
			}
			return $result;
	}

	public function update($e)
	{
			$mongo = $this->MLab($e);
			return $mongo->update($e["_q"],$e["_p"],$e["_sup"]);
	}

	public function deletebyid($e)
	{
		$mongo = $this->MLab($e);
		return $mongo->delete($e['_id'],$e["_sup"]);
	}

	public function delete($e)
	{
			$mongo = $this->MLab($e);
			return $mongo->deleteFind($e["_q"]);
	}

	public function deleteOneByOne($e)
	{
			$mongo = $this->MLab($e);
			$find = $mongo->find($e["_q"]);
			foreach ($find as $key => $value) {
				$result[] = $mongo->delete($value["_id"]['$oid']);
			}
			return $result;
	}

	//--------------end call mlab -----------------//




}
