<?php
define('CURSCRIPT', 'upgrade');
require_once dirname(__FILE__).'/include/common.inc.php';
$ac = 'image';
if ($ac == 'category'){
	$categorylist = array();
	$query = $db->query("SELECT * FROM sdw_article_cat");
	while ($data = $db->fetch_array($query)){
		if ($data){
			$categorylist[] = convertArray($data);
		}
	}
	echo json_encode($categorylist);
	exit();
}

if ($ac == 'article'){
	$pagesize = 50;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_articles ORDER BY id ASC LIMIT $start_limit,$pagesize");
	$articlelist = array();
	while ($data = $db->fetch_array($query)){
		if ($data){
			$articlelist[$data['id']] = convertArray($data);
		}
	}
	//print_r($articlelist);
	//echo json_encode($_GET);
	echo json_encode($articlelist);
	exit();
}

if ($ac == 'video'){
	$videolist = array();
	$query = $db->query("SELECT * FROM sdw_video ORDER BY id ASC");
	while ($data = $db->fetch_array($query)){
		if ($data){
			$videolist[$data['id']] = convertArray($data);
		}
	}
	//print_r($articlelist);
	//echo json_encode($_GET);
	echo json_encode($videolist);
	exit();
}

if ($ac == 'image'){
	$filelist = array();
	$query = $db->query("SELECT * FROM sdw_image_files");
	while ($data = $db->fetch_array($query)){
		$filelist[$data['gid']][] = $data;
	}
	
	$datalist = array();
	$query = $db->query("SELECT * FROM sdw_image ORDER BY id ASC");
	while ($data = $db->fetch_array($query)){
		if ($data){
			$data['files'] = $filelist[$data['id']];
			$datalist[$data['id']] = convertArray($data);
		}
	}
	echo json_encode($datalist);
	exit();
}

function convertArray($array){
	if (!is_array($array)){
		return mb_convert_encoding($array, 'UTF8','GBK');
	}else {
		$newarray = array();
		foreach ($array as $key=>$value){
			if (is_array($value)){
				$value = convertArray($value);
			}else {
				$value = mb_convert_encoding($value, 'UTF8','GBK');
			}
			$newarray[$key] = $value;
		}
		return $newarray;
	}
}