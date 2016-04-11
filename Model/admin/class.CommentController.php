<?php
namespace Admin;
class CommentController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('comment')->where("commid IN($deleteids)")->delete();
			}
			
			$this->showSuccess('delete_succeed');
		}else {
			global $G, $lang;
			$pagesize = 30;
			$totalnum    = $this->t('comment')->count();
			$pagecount   = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$commentlist = $this->t('comment')->page($G['page'],$pagesize)->select();
			$this->showPages($G['page'], $pagecount, $totalnum);
			include template('comment');
		}
	}
	
	public function delete(){
		$delete = $_GET['delete'];
		$commentids = implode(',', $delete);
		$this->t('comment')->where("commid IN($commentids)")->delete();
		$this->showSuccess('delete_succeed');
	}
}