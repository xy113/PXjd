<?php
namespace Member;
use Core\Controller;
use Core\Member;
class LoginController extends Controller{
	public function __construct(){
		parent::__construct();
		if ($this->uid) $this->redirect('/?');
	}
	
	public function index(){
		if ($this->checkFormSubmit()){
			$this->chklogin();
		}else {
			global $G,$lang;
			$G['title'] = $lang['login'];
			include template('login','member');
		}
	}
	
	/**
	 * 登录验证
	 */
	private function chklogin(){
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
		$member = new Member();
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
	}
}