<?php
namespace Home;
use Core\Controller;
class BaseController extends Controller{
	function __construct(){
		parent::__construct();
		if (!$this->uid){
			$this->redirect('/?m=member&c=login');
		}
	}
}