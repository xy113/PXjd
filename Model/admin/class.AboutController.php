<?php
namespace Admin;
class AboutController extends BaseController{
	public function index(){
		global $G,$lang;
		$posts[1] = $this->t('post_title')->field('id,title,pubtime')->where('status=0')->order('id DESC')->limit(0,5)->select();
		$posts[2] = $this->t('post_title')->field('id,title,pubtime')->where('status=1')->order('id DESC')->limit(0,5)->select();
		include template('about');
	}
}