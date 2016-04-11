<?php
namespace Member;
use Core\Controller;
class IndexController extends Controller{
	public function index(){
		$this->redirect('/?m=member&c=login');
	}
}