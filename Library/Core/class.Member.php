<?php
namespace Core;
class Member{
	public $uid;
	public $username;
	public $email;
	public $mobile;
	public $group   = array();
	public $account = array();
	public $count   = array();
	public $status  = array();
	public $profile = array();
	
	public function Login($username,$password,$field='username'){
		$returns = array(
				'uid'=>'-1',
				'username'=>'',
				'email'=>'',
				'mobile'=>'',
				'userip'=>''
		);
		$field = in_array($field, array('uid','username','mobile')) ? $field : 'username';
		$data  = M('member')->where(array($field=>$username))->find(1);
		if (!$data){
			return $returns;
		}else  {
			if ($data['random']){
				$password = md5(md5($password).$data['random']);
			}else {
				$password = sha1(md5($password));
			}
			if ($data['password'] != $password){
				return $returns;
			}else  {
				$this->uid = $data['uid'];
				$this->username = $data['username'];
				$this->email    = $data['email'];
				$this->mobile   = $data['mobile'];
				$returns = array(
						'uid'=>$data['uid'],
						'username'=>$data['username'],
						'email'=>$data['email'],
						'mobile'=>$data['mobile'],
						'userip'=>$_SERVER['REMOTE_ADDR']
				);
				unset($data['password']);
				cookie('member_account', serialize($data));
				$this->account = $data;
	
				$this->profile = $this->getProfile();
				cookie('member_profile', serialize($this->profile));
	
				$this->status = $this->getStatus();
				cookie('member_status', serialize($this->status));
	
				$this->count = $this->getCount();
				cookie('member_count', serialize($this->count));
	
				$this->group = $this->getGroup();
				cookie('member_group', serialize($this->group));
			}
		}
		return $returns;
	}
	
	public function register($username,$password,$field,$type='email'){
		$returns = array(
				'uid'=>'-1',
				'username'=>'',
				'email'=>'',
				'mobile'=>'',
				'userip'=>''
		);
	
		if (!isset($username) || empty($username) || strlen($username)<2 || !isset($password) || empty($password) || strlen($password)<6){
			return $returns;
		}
		if ($type == 'email' && !isemail($field)){
			return $returns;
		}
		if ($type == 'mobile' && !ismobile($field)){
			return $returns;
		}
		$this->group = M('member_group')->where("type='member' AND creditslower>=0")->order('creditslower','ASC')->find(1);
		cookie('member_group', serialize($this->group));
	
		$type   = $type == 'mobile' ? $type : 'email';
		$email  = $type == 'email'  ? $field : '';
		$mobile = $type == 'mobile' ? $field : '';
		$account = array(
				'username'=>$username,
				'password'=>sha1(md5($password)),
				'email'=>$email,
				'mobile'=>$mobile,
				'gid'=>$this->group['gid'],
				'status'=>0,
				'newpm'=>0,
				'emailstatus'=>0,
				'avatarstatus'=>0,
				'regdate'=>TIMESTAMP
		);
		$this->uid = M('member')->insert($account, true);
		$this->username = $username;
		$this->email = $email;
		$this->mobile = $mobile;
		$returns = array(
				'uid'=>$this->uid,
				'username'=>$this->username,
				'email'=>$this->email,
				'mobile'=>$this->mobile,
				'userip'=>$_SERVER['REMOTE_ADDR']
		);
		$account['uid'] = $this->uid;
		$this->account = $account;
		cookie('member_account', serialize($account));
	
		$this->status = $this->getStatus();
		cookie('member_status', serialize($this->status));
	
		$this->count = $this->getCount();
		cookie('member_count', serialize($this->count));
	
		$this->profile = $this->getProfile();
		cookie('member_profile', serialize($this->profile));
		return $returns;
	}
	
	public function getGroup(){
		if ($this->uid){
			$account = $this->getAccount();
			$group = M('member_group')->where(array('gid'=>$account['gid']))->find(1);
			$this->group = $group;
			return $group;
		}else {
			return false;
		}
	}
	
	public function getAccount() {
		if ($this->uid){
			$account = M('member')->where(array('uid'=>$this->uid))->find(1);
			if ($account){
				unset($account['password']);
				$this->account = $account;
				return $account;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	
	public function getCount() {
		if ($this->uid){
			$count = M('member_count')->where(array('uid'=>$this->uid))->find(1);
			if (!$count){
				M('member_count')->insert(array('uid'=>$this->uid));
				$this->count = $this->getCount();
				$count = $this->getCount();
			}
			$this->count = $count;
			return $count;
		}else {
			return false;
		}
	}
	
	public function getProfile(){
		if ($this->uid){
			$profile = M('member_profile')->where(array('uid'=>$this->uid))->find(1);
			if (!$profile){
				M('member_profile')->insert(array('uid'=>$this->uid));
				$profile = $this->getProfile();
			}
			$this->profile = $profile;
			return $profile;
		}else {
			return false;
		}
	}
	
	public function getStatus(){
		if ($this->uid){
			$status = M('member_status')->where(array('uid'=>$this->uid))->find(1);
			if (!$status){
				M('member_status')->insert(array('uid'=>$this->uid));
				$status = $this->getStatus();
			}
			$this->status = $status;
			return $status;
		}else {
			return false;
		}
	}
}