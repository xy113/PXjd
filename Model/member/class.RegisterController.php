<?php
namespace Member;
use Core\Controller;
use Core\Member;
class RegisterController extends Controller{
	function __construct(){
		parent::__construct();
		if ($this->uid) $this->redirect('/?m=home');
	}
	
	public function index(){
		if ($this->checkFormSubmit()){
			$this->save();
		}else {
			global $G,$lang;
			$G['title'] = $lang['register'];
			include template('register');
		}
	}
	
	/**
	 * 保存注册信息
	 */
	function save(){
		$username = htmlspecialchars(trim($_GET['username_'.FORMHASH]));
		$password = trim($_GET['password_'.FORMHASH]);
		$email    = trim($_GET['email_'.FORMHASH]);
		$captchacode = trim($_GET['captchacode']);
		$this->checkCaptchacode($captchacode);
		
		if (strlen($username) < 2){
			$this->showError('username_verify_failed');
		}
		if ($this->_verify(array('username'=>$username))){
			$this->showError('username_exists');
		}
		if (empty($email) || !isemail($email)){
			$this->showError('email_verify_failed');
		}
		if ($this->_verify(array('email'=>$email))){
			$this->showError('email_exists');
		}
		if (empty($password) || strlen($password)<6){
			$this->showError('password_verify_failed');
		}
		$member = new Member();
		$returns = $member->register($username, $password, $email,$_GET['type']);
		if ($member->uid > 0){
			$this->showSuccess('register_succeed','/?m=home',array(),'',true);
		}
	}
	
	public function verifyusername(){
		$username = htmlspecialchars(trim($_GET['username']));
		$verify = $this->_verify(array('username'=>$username));
		if ($verify){
			$this->showAjaxError(-1, 'username_exists');
		}else {
			$this->showAjaxReturn('success');
		}
	}
	
	public function verifyemail(){
		$email = trim($_GET['email']);
		$verify = $this->_verify(array('email'=>$email));
		if ($verify){
			$this->showAjaxError(-1, 'email_exists');
		}else {
			$this->showAjaxReturn('success');
		}
	}
	
	private function _verify($condition){
		return $this->t('member')->where($condition)->count();
	}
}