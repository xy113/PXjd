<?php
namespace Weixin;
use Core\UploadImage;
class SignController extends BaseController{
	public function __construct(){
		parent::__construct();
		$this->checkLogined();
	}
	
	public function index(){
		//$this->checkSigned();
		if ($this->checkFormSubmit()){
			$longitude = $_GET['longitude'];
			$latitude  = $_GET['latitude'];
			$location  = $_GET['location'];
			$remark    = $_GET['remark'];
			$signdata = array(
					'uid'=>$this->uid,
					'username'=>$this->username,
					'longitude'=>$longitude,
					'latitude'=>$latitude,
					'location'=>$location,
					'dateline'=>time(),
					'userip'=>getIp(),
					'remark'=>$remark
			);
			$upload = new UploadImage();
			if ($filedata = $upload->saveImage()){
				$signdata['pic'] = $filedata['attachment'];
			}
			$this->t('sign')->insert($signdata);
			L('sign_succeed','签到成功');
			$this->showSuccess('sign_succeed','/?m=weixin&c=home');
		}else {
			global $G,$lang;
			
			$signtime = @date('Y-m-d H:i:s',time());
			$json = file_get_contents('http://api.map.baidu.com/location/ip?ak=SWEeKmLWiGERXvCtxoOMdW56&coor=bd09ll&ip='.getIp());
			$array = json_decode($json,true);
			$signlocation = $array['content']['address'];
			$latitude  = $array['content']['point']['x'];
			$longitude = $array['content']['point']['y'];
			unset($json,$array);
			$G['title'] = '签到';
			include template('sign');
		}
	}
	
	public function viewrecord(){
		$signlist = $this->t('sign')->where(array('uid'=>$this->uid))->order('signid DESC')->select();
		$G['title'] = '签到记录';
		include template('sign_record');
	}
	
	public function getlocation(){
		$longitude = $_GET['longitude'];
		$latitude  = $_GET['latitude'];
		$location = $latitude.','.$longitude;
		$json = file_get_contents('http://api.map.baidu.com/cloudrgc/v1?ak=5EFnFovwRTE1uffvxOn8Y2S2&geotable_id=7906881&location='.$location);
		$array = json_decode($json,true);
		$this->showAjaxReturn(array('location'=>$array['formatted_address']));
		//$this->showAjaxReturn($array);
	}
	
	private function checkSigned(){
		$sign = $this->t('sign')->where(array('uid'=>$this->uid))->order('signid DESC')->selectOne();
		if ($sign){
			if (@date('Ymd',$sign['dateline']) == @date('Ymd',time())){
				$this->showSuccess('today_has_signed','' ,array(
						array(
								'url'=>'/?m=weixin&c=sign&a=viewrecord',
								'text'=>'view_sign_record'
						)
				));
				return false;
			}else {
				return true;
			}
		}else {
			return true;
		}
	}
}