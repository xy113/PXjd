<?php
namespace Admin;
class PageController extends BaseController{
	public function index(){
		global $G, $lang;
		if ($this->checkFormSubmit()){
			//删除页面
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('page')->where("pageid IN($deleteids)")->delete();
			}
			//更新页面
			$neworder  = $_GET['neworder'];
			if ($neworder && is_array($neworder)){
				foreach ($neworder as $pageid=>$displayorder){
					$this->t('page')->where(array('pageid'=>$pageid))->update(array('displayorder'=>$displayorder));
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			$pagesize  = 20;
			$catid     = intval($_GET['catid']);
			$condition = $catid ? "catid='$catid'" : 'catid>0';
			$totalnum  = $this->t('page')->where($condition)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$pagelist  = $this->t('page')->where($condition)->page($G['page'],$pagesize)->select();
			$pages = $this->showPages($G['page'], $pagecount,$totalnum,"catid=$catid");
			$categorylist = $this->getCategoryList();
			include template('page_list');
		}
		
	}
	
	public function publish(){
		global $G, $lang;
		if ($this->checkFormSubmit()) {
			$newpage = $_GET['newpage'];
			$newpage['pubtime'] = TIMESTAMP;
			$this->t('page')->insert($newpage);
			$this->showSuccess('save_succeed');
		}else{
			$categorylist = $this->getCategoryList();
			$editorname = 'newpage[body]';
			include template('page_new');
		}
	}

	public function edit(){
		global $G, $lang;
		$pageid = intval($_GET['pageid']);
		if($this->checkFormSubmit()){
			$newpage = $_GET['newpage'];
			$newpage['modified'] = TIMESTAMP;
			$this->t('page')->where("pageid='$pageid'")->update($newpage);
			$this->showSuccess('modi_succeed');
		}else {
			$page = $this->t('page')->where("pageid='$pageid'")->selectOne();
			$categorylist = $this->getCategoryList();
			$editorname = 'newpage[body]';
			$editorcontent = $page['body'];
			include template('page_new');
		}
	}
	
	public function category(){
		global $G,$lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('page')->where("pageid IN($deleteids)")->delete();
			}
			
			$newclass  = $_GET['newclass'];
			if (!empty($newclass) && is_array($newclass)){
				foreach ($newclass['title'] as $key=>$title){
					$pagedata = array('title'=>$title,'displayorder'=>$newclass['displayorder'][$key],'type'=>'category');
					if($newclass['pageid'][$key]>0){
						if($title)$this->t('page')->where(array('pageid'=>$newclass['pageid'][$key]))->update($pagedata);
					}else {
						if($title)$this->t('page')->insert($pagedata);
					}
				}
			}
			$this->showSuccess('save_succeed');
		}else {
			$categorylist = $this->getCategoryList();
			include template('page_category');
		}
	}
	
	private function getCategoryList(){
		$categorylist = $this->t('page')->where(array('catid'=>0))->order('displayorder ASC,pageid ASC')->select();
		if ($categorylist){
			$newlist = array();
			foreach ($categorylist as $list){
				$newlist[$list['pageid']] = $list;
			}
			$categorylist = $newlist;
		}else {
			$categorylist = array();
		}
		return $categorylist;
	}
}