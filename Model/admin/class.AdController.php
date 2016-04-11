<?php
namespace Admin;
use Core\UploadImage;
class AdController extends BaseController{
	public function index(){}
	
	public function showlist(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('ad')->where("id IN($deleteids)")->delete();
			}
			$adlist = $_GET['adlist'];
			if (!empty($adlist) && is_array($adlist)){
				foreach ($adlist as $id=>$data){
					$data['displayorder'] = intval($data['displayorder']);
					$this->t('ad')->where(array('id'=>$id))->update($data);
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			global $G,$lang;
			$groupid   = intval($_GET['groupid']);
			$condition = $groupid ? array('groupid'=>$groupid) : '';
			$totalnum  = $this->t('ad')->where($condition)->count();
			$pagecount = $totalnum < 20 ? 1 : ceil($totalnum/20);
			$adlist = $this->t('ad')->where($condition)->page($G['page'],20)->order('id','DESC')->select();
			if ($adlist){
				$newlist = array();
				foreach ($adlist as $list){
					$list['pic'] = image($list['pic']);
					$newlist[$list['id']] = $list;
				}
				$adlist = $newlist;
				unset($newlist);
			}
			$grouplist = $this->getGroups();
			$pages = $this->showPages($G['page'], $pagecount, $totalnum);
			include template('ad_list');
		}
	}
	
	public function publish(){
		if ($this->checkFormSubmit()){
			$adnew = $_GET['adnew'];
			if (!empty($adnew) && is_array($adnew)){
				$upload = new UploadImage();
				if ($imagedata = $upload->saveImage()){
					$adnew['pic'] = $imagedata['attachment'];
				}
				$this->t('ad')->insert($adnew);
				$this->showSuccess('save_succeed');
			}else {
				$this->showError('undefined_action');
			}
		}else {
			global $G,$lang;
			$groupid = intval($_GET['groupid']);
			$grouplist = $this->getGroups();
			include template('ad_form');
		}
	}
	
	public function edit(){
		$id = intval($_GET['id']);
		if ($this->checkFormSubmit()){
			
			$adnew = $_GET['adnew'];
			if (!empty($adnew) && is_array($adnew)){
				$upload = new UploadImage();
				if ($imagedata = $upload->saveImage()){
					$adnew['pic'] = $imagedata['attachment'];
				}
				$this->t('ad')->where(array('id'=>$id))->update($adnew);
				$this->showSuccess('modi_succeed');
			}else {
				$this->showError('undefined_action');
			}	
		}else {
			global $G,$lang;
			$grouplist = $this->getGroups();
			$ad  = $this->t('ad')->where(array('id'=>$id))->selectOne();
			$pic = image($ad['pic']);
			$groupid = $ad['groupid'];
			include template('ad_form');
		}
	}
	
	public function grouplist(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				$this->t('ad_group')->where("groupid IN ($deleteids)")->delete();
				$this->t('ad')->where("groupid IN ($deleteids)")->delete();
			}
				
			$groupnew = $_GET['groupnew'];
			if (!empty($groupnew) && is_array($groupnew)){
				foreach ($groupnew as $groupid=>$group){
					$this->t('ad_group')->where(array('groupid'=>$groupid))->update($group);
				}
			}
				
			$newgroup = $_GET['newgroup'];
			if (!empty($newgroup) && is_array($newgroup)){
				foreach ($newgroup as $key=>$group){
					if ($group['groupname']) $this->t('ad_group')->insert($group);
				}
			}
				
			$this->showSuccess('update_succeed');
		}else {
			$grouplist = $this->getGroups();
			include template('ad_group');
		}
	}
	
	public function setimage(){
		$id = intval($_GET['id']);
		$upload = new UploadImage();
		if($image = $upload->saveImage()){
			$this->t('ad')->where(array('id'=>$id))->update(array('pic'=>$image['attachment']));
			$this->showAjaxReturn(array('pic'=>image($image['attachment'])));
		}else {
			$this->showAjaxError(-1,'upload failed('.$upload->error.')');
		}
	}
	
	private function getGroups(){
		$grouplist = $this->t('ad_group')->order('displayorder ASC,groupid ASC')->select();
		if ($grouplist){
			$newlist = array();
			foreach ($grouplist as $list){
				$newlist[$list['groupid']] = $list;
			}
			$grouplist = $newlist;
		}else {
			$grouplist = array();
		}
		return $grouplist;
	}
}