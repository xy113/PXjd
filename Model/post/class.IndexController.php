<?php
namespace Post;
class IndexController extends BaseController{
	public function index(){
		global $G,$lang;
		$G['title'] = $lang['home'];
		include template('index');
	}
	
	public function sign(){
		if (!$this->uid || !$this->checkSigned()){
			$this->showAjaxError(-1);
		}else {
			$longitude = $_GET['longitude'];
			$latitude  = $_GET['latitude'];
			if ($longitude && $latitude){
				$signdata = array(
						'uid'=>$this->uid,
						'username'=>$this->username,
						'longitude'=>$longitude,
						'latitude'=>$latitude,
						'location'=>$this->getlocation(),
						'dateline'=>time(),
						'userip'=>getIp()
				);
			}else {
				$json = file_get_contents('http://api.map.baidu.com/location/ip?ak=SWEeKmLWiGERXvCtxoOMdW56&coor=bd09ll&ip='.getIp());
				$array = json_decode($json,true);
				$signdata = array(
						'uid'=>$this->uid,
						'username'=>$this->username,
						'longitude'=>$array['content']['point']['x'],
						'latitude'=>$array['content']['point']['y'],
						'location'=>$array['content']['address'],
						'dateline'=>time(),
						'userip'=>getIp()
				);
			}
			$this->t('sign')->insert($signdata);
			$this->showAjaxReturn(array('time'=>date('Y-m-d H:i',time()),'location'=>$signdata['location']));
		}
	}
	
	public function getlocation(){
		$longitude = $_GET['longitude'];
		$latitude  = $_GET['latitude'];
		$location = $latitude.','.$longitude;
		$json = file_get_contents('http://api.map.baidu.com/cloudrgc/v1?ak=5EFnFovwRTE1uffvxOn8Y2S2&geotable_id=7906881&location='.$location);
		$array = json_decode($json,true);
		return $array['formatted_address'];
	}
	
	private function checkSigned(){
		$sign = $this->t('sign')->where(array('uid'=>$this->uid))->order('signid DESC')->selectOne();
		if ($sign){
			if (@date('Ymd',$sign['dateline']) == @date('Ymd',time())){
				return false;
			}else {
				return true;
			}
		}else {
			return true;
		}
	}
}