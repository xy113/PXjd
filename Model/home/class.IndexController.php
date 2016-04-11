<?php
namespace Home;
class IndexController extends BaseController{
	public function index(){
		global $G,$lang;
		$template = 'info';
		include template('index');
	}
}