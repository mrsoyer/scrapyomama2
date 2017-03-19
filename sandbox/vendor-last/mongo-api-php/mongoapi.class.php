<?php
class MongoAPI{
	private $db;
	private $col;
	private $apiKey;
	private $schema;

	public function __construct($db,$apiKey,$col=''){
		$this->db = $db;
		$this->col = $col;
		$this->apiKey = $apiKey;
	}

	public function __destruct(){

	}

	public function drop(){

	}

	public function collection($col){
		$this->col = $col;
		return $this;
	}

	public function __get($col){
		$col = strtolower( $col );
		return $this->collection($col);
	}

	public function setSchema($schema){
		$this->schema = $schema;
	}

	public function get($key='',$sup=''){
		if( !empty($key) ){
			$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/'.$key.'?apiKey='.$this->apiKey.$sup;
		}else{
			$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.$sup;
		}
		$ret = $this->get_query($url);
		return json_decode( $ret,true );
	}

	public function find( $query ,$sup=''){
		return $this->query( $query ,$sup);
	}

	public function query( $query ,$sup=''){
		$q = json_encode( $query );
		$q = urlencode( $q );
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.'&q='.$q.$sup;
		$ret = $this->get_query($url);
		return json_decode( $ret,true );
	}

	public function insert($vars,$sup=''){
		if( isset($this->schema) ){
			$row = array();
			foreach( $this->schema as $k=>$type ){
				if( isset($vars[$k]) ){
					$row[$k] = $vars[$k];
				}else{
					$row[$k] = '';
				}
			}
		}else{
			$row = $vars;
		}
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.$sup;
		$row = json_encode( $row );
		$ret = $this->post_query($url,$row);
		$ret = json_decode( $ret,true );
		$id = $ret['_id']['$oid'];
		return $ret;
	}

	public function insertMultiple($vars,$sup=''){
		if( isset($this->schema) ){
			$row = array();
			foreach( $this->schema as $k=>$type ){
				if( isset($vars[$k]) ){
					$row[$k] = $vars[$k];
				}else{
					$row[$k] = '';
				}
			}
		}else{
			$row = $vars;
		}
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.$sup;
		$row = json_encode( (object)$row );
		$ret = $this->post_query($url,$row);
		$ret = json_decode( $ret,true );
		$id = $ret['_id']['$oid'];
		return $id;
	}

	public function update_($where,$vars){
		$res = $this->find( $where );
		$ret = false;
		if( count($res) ){
			foreach($res as $row){
				$key = $row['_id']['$oid'];
				$ret = $this->update($vars,$key);
			}
		}
		return $ret;
	}


	public function update($where,$vars,$sup=''){
		return $this->queryupdate($where,$vars);
	}

	public function queryupdate($query,$vars,$sup=''){
		if( isset($this->schema) ){
			$row = array();
			foreach( $this->schema as $k=>$type ){
				if( isset($vars[$k]) ){
					$row[$k] = $vars[$k];
				}else{
					$row[$k] = '';
				}
			}
		}else{
			$row = $vars;
		}
		$q = json_encode( $query );
		$q = urlencode( $q );
		$r['$set'] = $row;
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.'&m=true&q='.$q.''.$sup;
		$row = json_encode( $r);
		$ret = $this->put_query($url,$row);
		$ret = json_decode( $ret,true );
		return $ret;
	}



	public function updatebyid($vars,$key,$sup=''){
		if( isset($this->schema) ){
			$row = array();
			foreach( $this->schema as $k=>$type ){
				if( isset($vars[$k]) ){
					$row[$k] = $vars[$k];
				}else{
					$row[$k] = '';
				}
			}
		}else{
			$row = $vars;
		}
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/'.$key.'?apiKey='.$this->apiKey.$sup;
		$row = json_encode( $row );
		$ret = $this->put_query($url,$row);
		$ret = json_decode( $ret,true );
		return $ret;
	}

	public function delete($key,$sup=''){
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/'.$key.'?apiKey='.$this->apiKey.$sup;
		$ret = $this->del_query($url);
		return json_decode( $ret,true );
	}

	public function deleteFind($query,$sup=''){
		$q = json_encode( $query );
		$q = urlencode( $q );
		$url = 'https://api.mongolab.com/api/1/databases/'.$this->db.'/collections/'.$this->col.'/?apiKey='.$this->apiKey.'&m=true&q='.$q.''.$sup;
		$row = "[]";
		$ret = $this->put_query($url,$row);
		$ret = json_decode( $ret,true );
		return $ret;
	}

	/*	private functions for calling the API.. Change these at your own risk	*/

	private function get_query($url){
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private function del_query($url){
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private function put_query($url,$args){
		$ch = curl_init($url);
		$timeout=5;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private function post_query($url,$args){
		$ch = curl_init($url);
		$timeout=5;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
