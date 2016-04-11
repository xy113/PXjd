<?php
namespace Weixin;
class MemberController extends BaseController{
	public function login(){
		if ($this->uid && $this->username){
			$this->redirect('/?m=weixin&c=home');
		}
		if ($this->checkFormSubmit()){
			$account  = htmlspecialchars(trim($_GET['account_'.FORMHASH]));
			$password = trim($_GET['password_'.FORMHASH]);
			$captchacode = strtolower(trim($_GET['captchacode']));
			$this->checkCaptchacode($captchacode);
			
			if (strlen($account) < 2){
				$this->showError('username_verify_failed');
			}
			if (strlen($password) < 6){
				$this->showError('password_verify_failed');
			}
			$member = new \Core\Member();
			if (isemail($account)){
				$returns = $member->Login($account, $password,'email');
			}elseif (ismobile($account)){
				$returns = $member->Login($account, $password,'mobile');
			}else  {
				$returns = $member->Login($account, $password);
			}
			if ($member->uid > 0){
				$continue = $_GET['continue'];
				$this->showSuccess('login_succeed',$continue,array(),'',true);
			}else {
				$this->showError('login_verify_failed');
			}
		}else {
			$this->showLogin();
		}
	}
	
	public function register(){
		if ($this->checkFormSubmit()){
			$username = htmlspecialchars(trim($_GET['username_'.FORMHASH]));
			$password = trim($_GET['password_'.FORMHASH]);
			$mobile   = trim($_GET['mobile_'.FORMHASH]);
			$captchacode = trim($_GET['captchacode']);
			$this->checkCaptchacode($captchacode);
			
			if (strlen($username) < 2){
				$this->showError('username_verify_failed');
			}
			if ($this->_verify(array('username'=>$username))){
				$this->showError('username_exists');
			}
			if (empty($mobile) || !ismobile($mobile)){
				$this->showError('mobile_verify_failed');
			}
			if ($this->_verify(array('mobile'=>$mobile))){
				$this->showError('mobile_exists');
			}
			if (empty($password) || strlen($password)<6){
				$this->showError('password_verify_failed');
			}
			$member = new \Core\Member();
			$returns = $member->register($username, $password, $mobile,$mobile);
			if ($member->uid > 0){
				$this->showSuccess('register_succeed','/?m=weixin&c=home',array(),'',true);
			}
		}else {
			global $G,$lang;
			$G['title'] = $lang['register'];
			include template('register');
		}
	}
	
	public function logout(){
		cookie(null);
		$this->redirect('/?m=weixin&c=member&a=login');
	}
	
	private function _verify($condition){
		return $this->t('member')->where($condition)->count();
	}
}