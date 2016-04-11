<?php
namespace Home;
class InfoController extends BaseController{
	public function index(){
		global $G,$lang;
		$member  = $this->t('member')->where(array('uid'=>$this->uid))->selectOne();
		$profile = $this->t('member_profile')->where(array('uid'=>$this->uid))->selectOne();
		include template('info');
	}
}