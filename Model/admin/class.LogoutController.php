<?php
namespace Admin;
use Admin\BaseController;
class LogoutController extends BaseController{
	public function index(){
		$this->logout();
	}
}