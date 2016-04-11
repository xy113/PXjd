<?php
namespace Home;
class ProfileController extends BaseController{
	public function index(){
		if ($this->checkFormSubmit()){
			$this->save();
		}else {
			global $G,$lang;
			$account = $this->t('member')->where(array('uid'=>$this->uid))->selectOne();
			$profile = $this->t('member_profile')->where(array('uid'=>$this->uid))->selectOne();
			include template('profile');
		}
	}
	public function save(){
		$accountnew = $_GET['accountnew'];
		$profilenew = $_GET['profilenew'];
		if (isemail($accountnew['email']) || ismobile($accountnew['mobile'])){
			$this->t('member')->where(array('uid'=>$this->uid))->update($accountnew);
		}
		$profilenew['locked'] = 1;
		$profilenew['modified'] = time();
		$this->t('member_profile')->where(array('uid'=>$this->uid))->update($profilenew);
		$this->showSuccess('modi_succeed');
	}
}