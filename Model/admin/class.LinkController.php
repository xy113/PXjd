<?php
namespace Admin;
class LinkController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$this->delete();
			$this->save();
			
		}else {
			global $G,$lang;
			$linklist = $this->t('link')->where('classid>0')->select();
			$linkclasses = $this->t('link')->where('classid=0')->select();
			include template('link');
		}
	}
	
	public function delete(){
		$deleteids = $_GET['delete'];
		$deleteids = $deleteids ? implode(',', $deleteids) : 0;
		$this->t('link')->where("linkid IN($deleteids)")->delete();
	}
	
	private function save(){
		$newclass = $_GET['newclass'];
		$newlink  = $_GET['newlink'];
		if(is_array($newclass)){
			foreach ($newclass['linkid'] as $k=>$linkid){
				if($linkid>0){
					if (!empty($newclass['title'][$k])) {
						$data = array(
								'title'=>$newclass['title'][$k],
								'displayorder'=>intval($newclass['displayorder'][$k])
						);
						$this->t('link')->where(array('linkid'=>$linkid))->update($data);
					}
				}else {
					if(!empty($newclass['title'][$k])){
						$this->t('link')->insert(array(
								'title'=>$newclass['title'][$k],
								'displayorder'=>$newclass['displayorder'][$k]
						));
					}
				}
			}
		}
		if(is_array($newlink)){
			foreach ($newlink['linkid'] as $k=>$linkid){
				$data = array(
						'classid'=>intval($newlink['classid'][$k]),
						'title'=>$newlink['title'][$k],
						'url'=>$newlink['url'][$k],
						'pic'=>$newlink['pic'][$k],
						'displayorder'=>$newlink['displayorder'][$k]
				);
				if($linkid>0){
					if($newlink['title'][$k] && $newlink['url'][$k]){
						$this->t('link')->where(array('linkid'=>$linkid))->update($data);
					}
				}else {
					if($newlink['title'][$k] && $newlink['url'][$k]){
						$this->t('link')->insert($data);
					}
				}
			}
		}
		$this->updatecache();
		$this->showSuccess('save_succeed');
	}
	
	private function updatecache(){
		$links = $this->t('link')->order('displayorder ASC,linkid ASC')->select();
		cache('link',$links);
	}
}