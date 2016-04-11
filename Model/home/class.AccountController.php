<?php
namespace Home;
class AccountController extends BaseController{
	public function init(){
		$this->display();
	}
	public function display(){
		global $G,$lang;
		include template('account');
	}
}