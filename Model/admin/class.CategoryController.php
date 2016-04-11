<?php
namespace Admin;
class CategoryController extends BaseController{
	private $type;
	function __construct(){
		parent::__construct();
		$this->type = trim($_GET['type']);
	}
	
	public function index(){
		$this->showlist();
	}
	
	public function showlist(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = $delete;
				$category = new \Core\Category();
				$category->dataList = $this->getCategoryList();
				foreach ($delete as $catid){
					$deleteids = array_merge($deleteids,$category->getAllChildids($catid));
				}
				$deleteids = implode(',', $deleteids);
				$this->t('category')->where("catid IN($deleteids)")->delete();
			}
			
			$categorylist = $_GET['categorylist'];
			if ($categorylist && is_array($categorylist)){
				foreach ($categorylist as $catid=>$category){
					$this->t('category')->where(array('catid'=>$catid))->update($category);
				}
			}
			
			$newcategory = $_GET['newcategory'];
			if ($newcategory && is_array($newcategory)){
				foreach ($newcategory['cname'] as $key=>$cname){
					if ($cname){
						$data = array(
								'fid'=>$newcategory['fid'][$key],
								'type'=>$this->type,
								'cname'=>$cname,
								'displayorder'=>intval($newcategory['displayorder'][$key]),
								//'template'=>$newcategory['template']['key']
						);
						$this->t('category')->insert($data);
					}
				}
			}
			$this->updateCache();
			$this->showSuccess('save_succeed');
		}else {
			global $G,$lang;
			$fid = intval($_GET['fid']);
			$categorylist = $this->getCategoryList();
			include template('category');
		}
	}
	
	public function edit(){
		$catid = intval($_GET['catid']);
		if ($this->checkFormSubmit()){
			$category = $_GET['category'];
			if ($category['cname'] && $this->type && $catid){
				$this->t('category')->where(array('catid'=>$catid))->update($category);
				$this->updateCache();
			}
		}else {
			global $G,$lang;
			$category = $this->t('category')->where(array('catid'=>$catid))->selectOne();
			$categorylist = $this->getCategoryList();
			include template('category');
		}
	}
	
	private function getCategoryList(){
		$categorylist = $this->t('category')->where(array('type'=>$this->type))->select();
		if($categorylist){
			$newlist = array();
			foreach ($categorylist as $list){
				$list['image'] = image($list['image']);
				$newlist[$list['catid']] = $list;
			}
			$categorylist = $newlist;
		}else {
			$categorylist = array();
		}
		return $categorylist;
	}
	
	private function updateCache(){
		$categorylist = $this->getCategoryList();
		return cache('category_'.$this->type,$categorylist);
	}
}