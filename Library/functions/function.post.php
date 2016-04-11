<?php
function articlelist($params=array()){
	global $G;
	$where = array();
	$where['status'] = 0;
	if ($params['catid']){
		$where['catid'] = array('IN',$params['catid']);
	}
	if ($params['isimage']){
		$where['pic'] = array('>','');
	}
	if ($params['type']){
		$where['type'] = $params['type'];
	}
	$limit = $params['limit'] ? intval($params['limit']) : 0;
	$num = $params['num'] ? intval($params['num']) : 10;
	$orderby = $params['orderby'] ? $params['orderby'] : 'id';
	$sort = $params['sort'] ? 'ASC' : 'DESC';
	$articlelist = M('post_title')->where($where)->order($orderby,$sort)->limit($limit,$num)->select();
	if ($articlelist){
		$newsarticlelist = array();
		$orderno = 0;
		foreach ($articlelist as $article){
			$orderno++;
			$article['orderno']  = $orderno;
			$article['pic']      = image($article['pic']);
			$article['dateline'] = $article['pubtime'];
			$article['pubtime']  = @date($G['setting']['dateformat'],$article['pubtime']);
			$article['modified'] = @date($G['setting']['dateformat'],$article['modified']);
			$newsarticlelist[$article['id']] = $article;
		}
	}
	return $newsarticlelist;
}

function getArticle($id){
	$article = M('post_title')->where(array('id'=>$id))->selectOne();
	if ($article){
		$content = M('post_content')->where(array('aid'=>$aid))->selectOne();
		$article['content'] = $content['content'];
	}else {
		$article = array();
	}
	return $article;
}