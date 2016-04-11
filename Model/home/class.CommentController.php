<?php
namespace Home;
class CommentController extends BaseController{
	public function index(){
		global $G,$lang;
		$pagesize  = 10;
		$totalnum  = $this->t('comment')->where(array('uid'=>$this->uid))->count();
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$commentlist = $this->t('comment')->where(array('uid'=>$this->uid))->page($G['page'],$pagesize)->select();
		$pages = $this->showPages($G['page'], $pagecount, $totalnum);
		include template('comment');
	}
}