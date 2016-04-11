<?php
namespace Home;
class PasswordController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$password     = trim($_GET['password']);
			$newpassword  = trim($_GET['newpassword']);
			$newpassword2 = trim($_GET['newpassword2']);
			if ($password && ($newpassword == $newpassword2)){
				$check = $this->t('member')->where(array('uid'=>$this->uid,'password'=>sha1(md5($password))))->count();
				if ($check == 0){
					$this->showError('old_password_error');
				}else {
					$this->t('member')->where(array('uid'=>$this->uid))->update(array('password'=>sha1(md5($newpassword))));
					$this->showSuccess('modi_succeed');
				}
			}else {
				$this->showError('new_password_error');
			}
		}else {
			global $G,$lang;
			include template('password');
		}
	}
}