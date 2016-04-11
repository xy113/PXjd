<?php
namespace Core;
class Model{
	protected $db;
	protected $tablename;
	function __construct($name=''){
		static $db;
		if (!is_object($db)) $db = new Mysql();
		if ($name){
			$this->tablename = $name;
		}else {
			$this->tablename = MODEL_NAME;
		}
		$this->db = $db->t($this->tablename);
	}
	
	public function select() {
		return $this->db->select();
	}
	
	public function selectOne(){
		return $this->db->selectOne();
	}
	
	public function find($limit=0,$num=0){
		return $this->db->find($limit, $num);
	}
	
	public function count($field=''){
		return $this->db->count($field);
	}
	public function insert($data,$return_insert_id=false,$replace=false){
		return $this->db->insert($data,$return_insert_id,$replace);
	}
	
	public function insertAll($array,$replace=false,$return_ids=false){
		return $this->db->insertAll($array,$replace,$return_ids);
	}
	
	public function update($data, $unbuffered = false, $low_priority = false) {
		return $this->db->update($data, $unbuffered, $low_priority);
	}
	
	public function updateAll($array, $unbuffered = false, $low_priority = false){
		return $this->db->updateAll($array, $unbuffered, $low_priority);
	}
	
	public function delete(){
		return $this->db->delete();
	}
	
	public function field($args = '*'){
		return $this->db->field($args);
	}
	
	public function where($args,$glue = 'AND'){
		return $this->db->where($args, $glue);
	}
	
	public function order($field,$sort = 'ASC'){
		if (func_num_args() == 1){
			return $this->db->order($field);
		}else {
			return $this->db->order($field,$sort);
		}
	}
	
	public function limit($start,$num=0){
		return $this->db->limit($start,$num);
	}
	
	public function page($page,$rows=10){
		return $this->db->page($page, $rows);
	}
	
	public function group($field){
		return $this->db->group($field);
	}
	
	public function having($having){
		return $this->db->having($having);
	}
	
	public function join($join,$type='LEFT'){
		return $this->db->join($join,$type);
	}
	public function union($table,$all=FALSE){
		return $this->db->union($table,$all);
	}
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
	
	public function __call($name,$args){
		exit('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
		//throw new  \Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}
}