<?php
namespace Post;
class ListController extends BaseController{
	public function index(){
		global $G,$lang;
		$pagesize = 10;
		$catid = intval($_GET['catid']);
		$where = $catid ? array('catid'=>$catid) : '';
		$totalnum = M('post_title')->where($where)->count();
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$articlelist = M('post_title')->where($where)->page($G['page'],$pagesize)->order('id DESC')->select();
		if (is_array($articlelist) && !empty($articlelist)){
			$newarticlelist = array();
			$orderno = 0;
			foreach ($articlelist as  $list){
				$orderno++;
				$list['orderno']  = $list['orderno'];
				$list['pic']      = $list['pic'] ? image($list['pic']) : '';
				$list['pubtime']  = @date($G['setting']['dateformat'],$list['pubtime']);
				$list['modified'] = @date($G['setting']['dateformat'],$list['modified']);
				$newarticlelist[$list['id']] = $list;
			}
			$articlelist = $newarticlelist;
			unset($newarticlelist);
		}else {
			$articlelist = array();
		}
		$pages = $this->showPages($G['page'], $pagecount, $totalnum,"catid=$catid");
		$catobj = new \Core\Category();
		$catobj->dataList = cache('category_article');
		$catobj->catid = $catid;
		$category = $catobj->getData();
		$categorylist = $catobj->dataList;
		$G['title'] = $category['cname'];
		if ($category['template']){
			include template($category['template']);
		}else {
			include template('list');
		}
	}
}