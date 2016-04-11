<?php
namespace Home;
class PhotoController extends BaseController{
	public function index(){
		global $G,$lang;
		$pagesize  = 20;
		$totalnum  = $this->t('photo')->where(array('uid'=>$this->uid))->count();
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$piclist = $this->t('photo')->where(array('uid'=>$this->uid))->order('photoid','DESC')->page($G['page'],$pagesize)->select();
		$pages = $this->showPages($G['page'], $pagecount, $totalnum);
		$attachurl = $G['config']['output']['attachurl'];
		include template('photo');
	}
}