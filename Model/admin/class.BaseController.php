<?php
namespace Admin;
use Core\Controller;
class BaseController extends Controller{
	function __construct(){
		global $G;
		parent::__construct();
		define('IN_ADMIN', true);
		define('THEME', 'default');
		/*
		if ($G['c'] == 'login'){
			$this->showlogin();
		}elseif ($G['c'] == 'logout'){
			$this->logout();
		}else {
			if (!cookie('adminlogined')){
				$this->showlogin();
			}else {
				cookie('adminlogined', 1 ,1200);
			}
		}
		*/
		if (!cookie('adminlogined')){
			$this->showlogin();
		}else {
			cookie('adminlogined', 1 ,1200);
		}
	}
	
	protected function showlogin(){
		if ($this->checkFormSubmit()){
			$username = htmlspecialchars($_GET['username']);
			$password = trim($_GET['password']);
			$userdata = M('member')->where(array('username'=>$username,'admincp'=>1))->find(1);
			if ($userdata && ($userdata['password'] == sha1(md5($password)))){
				if (!$this->uid){
					$member = new \Core\Member();
					$member->Login($username, $password);
				}
				cookie('adminlogined', 1 ,1200);
				$this->showAjaxReturn('login_succeed');
			}else {
				$this->showAjaxError(1, 'login_failed');
			}
		}else {
			global $G,$lang;
			$background = getBackground();
			include template('login');
			exit();
		}
	}
	
	protected function logout(){
		cookie('adminlogined',null);
		$this->redirect('/?m=admin&c=login');
	}
}