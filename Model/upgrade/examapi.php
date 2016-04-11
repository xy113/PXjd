<?php
define('CURSCRIPT','examapi');
require_once 'include/common.inc.php';
$ac = 'member';
if ($ac == 'member'){
	$pagesize = 50;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_members where uid>35345 ORDER BY uid ASC LIMIT $start_limit,$pagesize");
	$memberlist = array();
	while ($data = $db->fetch_array($query)){
		$memberlist[] = convertArray($data);
	}
	echo json_encode($memberlist);
	exit();
}
if ($ac == 'options'){
	$pagesize = 100;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_exam_options ORDER BY optionid ASC LIMIT $start_limit,$pagesize");
	$datalist = array();
	while ($data = $db->fetch_array($query)){
		$datalist[] = convertArray($data);
	}
	echo json_encode($datalist);
	exit();
}

if ($ac == 'questions'){
	$pagesize = 100;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_exam_questions ORDER BY id ASC");
	$datalist = array();
	while ($data = $db->fetch_array($query)){
		$datalist[] = convertArray($data);
	}
	echo json_encode($datalist);
	exit();
}

if ($ac == 'userquestions'){
	$pagesize = 100;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_member_question ORDER BY id ASC LIMIT $start_limit,$pagesize");
	$datalist = array();
	while ($data = $db->fetch_array($query)){
		$datalist[] = convertArray($data);
	}
	echo json_encode($datalist);
	exit();
}

if ($ac == 'userresult'){
	$pagesize = 100;
	$page = max(array(1,intval($_GET['page'])));
	$start_limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT * FROM sdw_member_result ORDER BY id ASC LIMIT $start_limit,$pagesize");
	$datalist = array();
	while ($data = $db->fetch_array($query)){
		$datalist[] = convertArray($data);
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