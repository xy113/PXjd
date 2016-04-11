<?php
namespace Common;
use Core\Controller;
class DistrictController extends Controller{
	public function index(){}
	
	public function fetchdistrict() {
		$fid = intval($_GET['fid']);
		$datatype = isset($_GET['datatype']) ? trim($_GET['datatype']) : 'json';
		$districtlist = $this->t('district')->where(array('fid'=>$fid))->order("displayorder ASC,id ASC")->select();
		if ($datatype == 'json'){
			$this->showAjaxReturn($districtlist);
		}else {
			return $districtlist;
		}
	}
	
	public function showlist(){
		$fid = intval($_GET['fid']);
		$datatype = isset($_GET['datatype']) ? trim($_GET['datatype']) : 'json';
		$districtlist = $this->t('district')->where(array('fid'=>$fid))->order("displayorder ASC,id ASC")->select();
		if ($datatype == 'json'){
			$this->showAjaxReturn($districtlist);
		}else {
			return $districtlist;
		}
	}
	
	public function showoptions(){
		$fid = intval($_GET['fid']);
		$selected = $_GET['selected'];
		$options = '';
		$districtlist = $this->t('district')->where(array('fid'=>$fid))->order("displayorder ASC,id ASC")->select();
		if ($districtlist){
			foreach ($districtlist as $list){
				$options.= '<option value="'.$list['id'].'"'.(($list['id'] == $selected || $list['name'] == $selected) ? ' selected="selected"' : '').'>'.$list['name'].'</option>'."\n";
			}
		}
		echo $options;
	}
}