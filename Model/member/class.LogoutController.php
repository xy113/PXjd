<?php
namespace Member;
use Core\Controller;
class LogoutController extends Controller{	
	public function index(){
		cookie(null);
		$contiue = trim($_GET['continue']);
		$contiue = $contiue ? $contiue : '/?m=member&c=login';
		$this->redirect($contiue);
	}
}