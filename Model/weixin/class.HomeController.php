<?php
namespace Weixin;
class HomeController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->checkLogined();
	}
	
	public function index(){
		global $G,$lang;
		$G['title'] = '个人中心';
		$signrecordlist = $this->getSignRecord();
		include template('home');
	}
	
	public function getSignRecord(){
		return $this->t('sign')->where(array('uid'=>$this->uid))->order('signid DESC')->select();
	}
}