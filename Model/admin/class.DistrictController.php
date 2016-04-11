<?php
namespace Admin;
class DistrictController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$this->save();
		}else {
			global $G;
			$province = intval($_GET['province']);
			$city     = intval($_GET['city']);
			$county   = intval($_GET['county']);
			$districtlist = $provincelist = $citylist = $countylist = array();
			$provincelist = $this->t('district')->where(array('fid'=>0))->select();
			$districtlist = $provincelist;
			if($province){
				$citylist = $this->t('district')->where(array('fid'=>$province))->select();
				$districtlist = $citylist;
			}
			if($city){
				$countylist = $this->t('district')->where(array('fid'=>$city))->select();
				$districtlist = $countylist;
			}
			if($county){
				$districtlist = $this->t('district')->where(array('fid'=>$county))->select();
			}
			include template('district');
		}
	}
	
	private function save(){
		$delete = $_GET['delete'];
		$namearray = $_GET['name'];
		$newname   = $_GET['newname'];
		$newfid    = $_GET['newfid'];
		if (!empty($delete) && is_array($delete)){
			$deleteids = implode(',', $delete);
			$this->t('district')->where("id IN($deleteids)")->delete();
		}
		if($namearray && is_array($namearray)){
			foreach ($namearray as $id=>$name){
				if($name) $this->t('district')->where(array('id'=>$id))->update(array('name'=>$name));
			}
		}
		if($newname){
			foreach ($newname as $k=>$name){
				if($name) $this->t('district')->insert(array('name'=>$name,'fid'=>$newfid[$k]));
			}
		}
		$this->showSuccess('save_success');
	}
}