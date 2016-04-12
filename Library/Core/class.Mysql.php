<?php
/**
 * ============================================================================
 * Copyright (c) 2015 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * $Date: 2015-08-17
 * $Id: class.Mysql.php
 */
namespace Core;
class Mysql{
	public $querynum = 0;
	public $tablepre = '';
	public $tablename = '';
	public $linkID;
	protected $sql = array(
			'field'=>'*',
			'where'=>'',
			'order'=>'',
			'group'=>'',
			'having'=>'',
			'limit'=>'',
			'page'=>'',
			'join'=>'',
			'union'=>''
	);
	private $config = array();
	function __construct($config = array()){
		$this->config = array(
				'type'  =>C('DB_TYPE'),
				'host'  =>C('DB_HOST'),
				'port'  =>C('DB_PORT'),
				'dbname'=>C('DB_NAME'),
				'user'  =>C('DB_USER'),
				'pwd'   =>C('DB_PWD'),
				'pconnect'=>C('DB_TYPE'),
				'charset' =>C('DB_CHARSET'),
				'tablepre'=>C('DB_PREFIX')
		);
		if (is_array($config)){
			$this->config = array_merge($this->config,$config);
		}
		$this->tablepre = $this->config['tablepre'];
		$this->connect();
	}
	public function connect() {
		if ($this->config['pconnect'] == 0){
			//非持久连接
			$this->linkID = mysql_connect($this->config['host'].':'.$this->config['port'], $this->config['user'], $this->config['pwd']);
		}else {
			//持久连接
			$this->linkID = mysql_pconnect($this->config['host'].':'.$this->config['port'], $this->config['user'], $this->config['pwd']);
		}
		if ($this->errorno() != 0){
			$this->halt("Connect(".$this->config['pconnect'].") to MySQL failed");
		}
		
		@mysql_query("SET character_set_connection=".$this->config['charset'].", character_set_results=".$this->config['charset'].", character_set_client=binary",$this->linkID);
		if($this->version() > '5.0'){
			@mysql_query("SET sql_mode=''",$this->linkID);
		}
		if (!@mysql_select_db($this->config['dbname'],$this->linkID)){
			$this->halt('Cannot use database('.$this->config['dbname'].')');
		}
	}
	public function close() {
		return @mysql_close($this->linkID);
	}
	public function select_db($dbname){
		if (!@mysql_select_db($dbname)){
			$this->halt('Cannot use database('.$this->config['dbname'].')');
		}
	}
	public function version(){
		return @mysql_get_server_info($this->linkID);
	}
	public function table($tableName){
		return $this->tablepre.$tableName;
	}
	
	//数据库查询
	public function query($SQL,$method=''){
		if($method=='U_B' && function_exists('mysql_unbuffered_query')){
			$query = mysql_unbuffered_query($SQL,$this->linkID);
		}else{
			$query = mysql_query($SQL,$this->linkID);
		}
		$this->querynum++;
		if(!$query && DEBUG){
			$this->halt('Query Error: ' . $SQL);
		}
		return $query;
	}
	
	public function getSQL(){
		$this->sql['field'] = $this->sql['field'] ? $this->sql['field'] : '*';
		$SQL = "SELECT ".$this->sql['field']." FROM ".$this->tablename;
		$SQL.= $this->sql['join'] ? ' '.$this->sql['join'] : '';
		$SQL.= $this->sql['union'] ? ' '.$this->sql['union'] : '';
		$SQL.= $this->sql['where'] ? ' '.$this->sql['where'] : '';
		$SQL.= $this->sql['group'] ? ' '.$this->sql['group'] : '';
		$SQL.= $this->sql['having'] ? ' '.$this->sql['having'] : '';
		$SQL.= $this->sql['order'] ? ' '.$this->sql['order'] : '';
		return $SQL;
	}
	
	public function select() {
		$SQL = $this->getSQL();
		$SQL.= $this->sql['limit'] ? ' '.$this->sql['limit'] : '';
		$query = $this->query($SQL);
		while ($data = $this->fetch_array($query)){
			$result[] = $data;
		}
		return $result;
	}
	
	public function selectOne(){
		$SQL = $this->getSQL();
		$SQL.= $this->sql['limit'] ? ' '.$this->sql['limit'] : " LIMIT 0,1";
		$query  = $this->query($SQL,'U_B');
		$result = $this->fetch_array($query, MYSQL_ASSOC);
		return $result;
	}
	
	public function find($limit=0,$num=0){
		$limit = intval($limit);
		$num   = intval($num);
		if ($num){
			return $this->limit($limit,$num)->select();
		}elseif ($limit==1 && $num==0){
			return $this->selectOne();
		}else {
			return $this->select();
		}
	}

	public function count($field=''){
		!$field && $field = '*';
		$this->sql['field'] = "COUNT($field) AS num";
		$row = $this->selectOne();
		return $row["num"];
	}
	public function insert($data,$return_insert_id=false,$replace=false){
		$sql = $this->implode_field_value($data);
		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$return = $this->query("$cmd ".$this->tablename." SET $sql");
		return $return_insert_id ? $this->insert_id() : $return;
	}
	
	public function insertAll($array,$replace=false,$return_ids=false){
		if(!empty($array) && is_array($array)){
			$ids = array();
			foreach ($array as $data){
				$ids[] = $this->insert($data,true,$replace);
			}
			return $return_ids ? $ids : true;
		}else {
			return false;
		}
	}
	
	public function insert_id() {
		return mysql_insert_id($this->linkID);
	}
	
	public function update($data, $unbuffered = false, $low_priority = false) {
		$sql = $this->implode_field_value($data);
		$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
		$res = $this->query("$cmd {$this->tablename} SET $sql ".$this->sql['where'],$unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}
	
	public function updateAll($array, $unbuffered = false, $low_priority = false){
		foreach ($array as $data){
			$this->update($data,$unbuffered,$low_priority);
		}
		return $this->affected_rows();
	}
	
	public function delete(){
		$this->query("DELETE FROM ".$this->tablename." ".$this->sql['where']);
		return $this->affected_rows();
	}
	
	public function fetch_array($query) {
		return mysql_fetch_array($query,MYSQL_ASSOC);
	}
	
	public function fetch_row($query){
		return mysql_fetch_row($query);
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->linkID);
	}
	
	public function num_rows($query) {
		$rows = mysql_num_rows($query);
		return $rows;
	}
	
	public function free_result($query) {
		return mysql_free_result($query);
	}
	
	public function result($result, $row, $field=null){
		return mysql_result($result, $row, $field);
	}
	public function fetch_field($query, $field_offset = null){
		return mysql_fetch_field($query,$field_offset);
	}
	public function show_tables($dbname=''){
		$tables = array();
		$dbname = $dbname ? $dbname : $this->config['dbname'];
		$query = $this->query("SHOW TABLES FROM ".$dbname);
		while ($row = $this->fetch_row($query)){
			$tables[] = $row[0];
		}
		return $tables;
	}
	public function show_table_status($dbname=''){
		$status = array();
		$dbname = $dbname ? $dbname : $this->config['dbname'];
		$query = $this->query("SHOW TABLE STATUS FROM ".$dbname);
		while ($table = $this->fetch_array($query)){
			$status[] = $table;
		}
		return $status;
	}
	public function show_create_table($table){
		$query = $this->query("SHOW CREATE TABLE ".$this->table($table));
		$row = $this->fetch_row($query);
		return $row[1];
	}
	public function  show_table_fields($table){
		$fields = array();
		$query = $this->query("SHOW FIELDS FROM ".$this->table($table));
		while ($row = $this->fetch_array($query)){
			$fields[] = $row;
		}
		return $fields;
	}
	public function implode_field_value($array, $glue = ',') {
		if (is_array($array)){
			$sql = $comma = '';
			foreach ($array as $k => $v) {
				$sql .= $comma."`$k`='$v'";
				$comma = $glue;
			}
			return $sql;
		}else {
			return $array;
		}
	}
	
	/**
	 * 设置当前数据表
	 * @param string $tableName
	 */
	public function t($tableName){
		foreach ($this->sql as $key=>$value){
			$this->sql[$key] = '';
		}
		$this->tablename = '';
		if (is_array($tableName)){
			foreach ($tableName as $key=>$value){
				if (is_numeric($key)){
					if (is_array($value)){
						foreach ($value as $k=>$v){
							$this->tablename.= $this->table($k).' AS '.$v.',';
						}
					}else {
						$this->tablename = $this->table($value).',';
					}
				}else {
					$this->tablename.= $this->table($key).' AS '.$value.',';
				}
			}
			$this->tablename = trim($this->tablename, ',');
		}else {
			$this->tablename = $this->table($tableName);
		}
		return $this;
	}
	public function field($args = '*'){
		if (is_array($args)){
			$this->sql['field'] = implode($args, ',');
		}else {
			$this->sql['field'] = $args;
		}
		!$this->sql['field'] && $this->sql['feild'] = '*';
		return $this;
	}
	public function where($args,$glue = 'AND'){
		$wherestr = '';
		$glue = strtoupper($glue);
		$glue = in_array($glue, array('AND','OR','XOR')) ? ' '.$glue.' ' : ' AND ';
		if (is_string($args)){
			$wherestr = $args;
		}elseif (is_array($args) && !empty($args)){
			foreach ($args as $key=>$value){
				if (is_numeric($key)){
					$wherestr.= $glue.$value;
				}else {
					$key = '`'.$key.'`';					
					if (is_array($value)){
						$arr = $value;
						$separate = $value[0];
						if (!in_array($separate, array('=','>','<','>=','<=','<>','LIKE','IN','NOT IN'))){
							$separate = '=';
						}
						if (strtoupper($separate) == 'LIKE'){
							$wherestr.= $glue.$key." LIKE '%".$value[1]."%'";
						}elseif (strtoupper($separate) == 'LEFTLIKE'){
							$wherestr.= $glue.$key." LIKE '".$value[1]."%'";
						}elseif (strtoupper($separate) == 'RIGHTLIKE'){
							$wherestr.= $glue.$key." LIKE '%".$value[1]."'";
						}elseif (strtoupper($separate) == 'IN' || strtoupper($separate) == 'NOT IN'){
							$wherestr.= $glue.$key.' '.strtoupper($separate)."($value[1])";
						}else {
							$value[1] = "'$value[1]'";
							$wherestr.= $glue.$key.$separate.$value[1];
						}
					}else {
						$wherestr.= $glue.$key."='".$value."'";
					}
				}
			}
			$wherestr = $wherestr? substr($wherestr, strlen($glue)) : '';
		}
		$this->sql['where'] = $wherestr ? "WHERE ".$wherestr : "";
		return $this;
	}
	public function order($field,$sort = 'ASC'){
		$sql = '';
		if (func_num_args() == 1){
			$order = array();
			if ($field && is_array($field)){
				foreach ($field as $key=>$value){
					if (strpos($value, ',')){
						$val = explode(',', $value);
						$val[1] = in_array($val[1], array('ASC','DESC')) ? $val[1] : 'ASC';
						$order[] = "$val[0] $val[1]";
					}else {
						$value = in_array($value, array('ASC','DESC')) ? $value : 'ASC';
						$order[] = "$key $value";
					}
				}
				$this->sql['order'] = implode(',', $order);
			}else {
				$this->sql['order'] = $field;
			}
		}else {
			$sort = strtoupper($sort);
			$sort = in_array($sort, array('ASC','DESC')) ? $sort : 'ASC';
			$this->sql['order'] = " $field $sort";
		}
		$this->sql['order'] = $this->sql['order'] ? "ORDER BY ".$this->sql['order'] : "";
		return $this;
	}
	public function limit($start,$num=0){
		if (func_num_args() == 1){
			if ($start && is_array($start)){
				$this->sql['limit'] = "$start[0],$start[1]";
			}else {
				$start = intval($start);
				$this->sql['limit'] = "0,$start";
			}
		}else {
			$start = intval($start);
			$num = intval($num);
			$this->sql['limit'] = "$start,$num";
		}
		
		$this->sql['limit'] = $this->sql['limit'] ? "LIMIT ".$this->sql['limit'] : '';
		return $this;
	}
	public function page($page,$rows=10){
		$page = intval($page);
		$rows = intval($rows);
		$page = max(array($page,1));
		$rows = abs($rows);
		$start = ($page-1)*$rows;
		$this->limit($start,$rows);
		return $this;
	}
	public function group($field){
		$this->sql['group'] = $field ? 'GROUP BY '.$field : '';
		return $this;
	}
	public function having($having){
		$this->sql['having'] = $having ? "HAVING ".$having : "";
		return $this;
	}
	
	/**
	 * join 操作
	 * @param string $table
	 * @param string $type
	 * @param string $on
	 */
	public function join($table,$type='LEFT', $on=''){
		$joinstr = '';
		if (func_num_args() == 1){
			$jointype = 'LEFT JOIN';
		}else {
			$type = strtoupper($type);
			$type = in_array($type, array('LEFT','RIGHT','INNER')) ? $type :'';
			$jointype = $type ? $type.' JOIN' : 'JOIN';
		}
		
		if (is_array($table)){
			foreach ($table as $key=>$value){
				if (!is_numeric($key)) {
					$joinstr = ' '.$jointype.' '.$this->table($key). ' AS '.$value;
				}
			}
		}else {
			$joinstr.= ' '.$jointype.' '.$this->table($table);
		}

		$joinstr.= $on ? ' ON '.$on : '';
		$this->sql['join'].= $joinstr;
		return $this;
	}
	public function union($table,$all=FALSE){
		$separate = $all ? 'UNION ALL ' : 'UNION ';
		$this->sql['union'].= $separate."SELECT ".$this->sql['field']." FROM ".$this->table($table);
		return $this;
	}
	public function error(){
		return $this->linkID ? mysql_error($this->linkID) : mysql_error();
	}
	public function errorno(){
		return $this->linkID ? mysql_errno($this->linkID) : mysql_errno();
	}
	public function halt($msg='') {
		$sqlerror = $this->error();
		$sqlerrno = $this->errorno();
		echo"<html><head><title>SQL Error</title><style type='text/css'>A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}td {COLOR: #000000; font-size:12px;}</style><body>\n\n";
		echo"<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>$msg";
		echo"<br><br><b>The URL Is</b>:<br>http://$_SERVER[HTTP_HOST]";
		echo"<br><br><b>MySQL Server Error</b>:<br>$sqlerror($sqlerrno)";
		echo"</td></tr></table></body></html>";
		exit;
	}
}