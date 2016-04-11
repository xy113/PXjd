<?php
namespace Admin;
class PosttagController extends BaseController{
	public function index(){
		global $G, $lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			$this->showSuccess('save_succeed');
		}else {
			$pagesize  = 20;
			$totalnum  = $this->m('post_tag')->count();
			$pageCount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$taglist = $this->m('post_tag')->page($G['page'],$pagesize)->select();
			$pages = $this->showPages($G['page'], $pageCount, $totalnum);
			include template('posttag');
		}
	}
}