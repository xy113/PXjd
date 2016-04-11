<?php
namespace Admin;
class LoginController extends BaseController{
	function __construct(){
		parent::__construct();
		if (cookie('adminlogined')){
			$this->redirect('/?m=admin');
		}
	}
	public function index(){
		$this->showlogin();	
	}
}