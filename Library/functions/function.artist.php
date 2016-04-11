<?php
function artistlist($num=10,$limit=0,$type=0){
	$artistlist = M('artist')->where(array('type'=>$type))->limit($limit,$num)->select();
	if ($artistlist){
		$newlist = array();
		foreach ($artistlist as $list){
			$list['pic'] = $list['pic'] ? C('attachurl').$list['pic'] : '';
			$newlist[$list['aid']] = $list;
		}
		$artistlist = $newlist;
	}else {
		$artistlist = array();
	}
	return $artistlist;
}