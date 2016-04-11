<?php
/**
 * 显示登录界面
 */
function member_show_login(){
	global $G,$lang;
	$G['title'] = $lang['login'];
	include template('login','member');
	exit();
}

/**
 * 显示AJAX登录界面
 */
function member_show_ajax_login(){
	global $G,$lang;
	$G['title'] = $lang['login'];
	include template('ajaxlogin','member');
	exit();
}

/**
 * 显示微信版登录界面
 */
function member_show_weixin_login(){
	global $G,$lang;
	$G['title'] = $lang['login'];
	include template('login','weixin');
	exit();
}

/**
 * 显示注册页面
 */
function member_show_register(){
	global $G,$lang;
	$G['title'] = $lang['register'];
	include template('register','member');
	exit();
}

/**
 * 显示AJAX注册页面
 */
function member_show_ajax_register(){
	global $G,$lang;
	$G['title'] = $lang['register'];
	include template('ajaxregister','member');
	exit();
}

/**
 * 显示微信版注册页面
 */
function member_show_weixin_register(){
	global $G,$lang;
	$G['title'] = $lang['register'];
	include template('register','weixin');
	exit();
}

/**
 * 获取会员总数
 * @param number $gid
 */
function member_get_number($gid=0){
	$where = $gid ? array('gid'=>$gid) : '';
	return M('member')->where($where)->count();
}

/**
 * 获取最新注册会员
 * @param int $gid
 * @param number $num
 * @param number $limit
 */
function member_get_new($gid,$num=50,$limit=0){
	$where = $gid ? array('gid'=>$gid) : '';
	$memberlist = M('member')->where($where)->select();
	if ($memberlist){
		return $memberlist;
	}else {
		return array();
	}
}

/**
 * 获取附近用户列表
 * @param float $lng
 * @param float $lat
 * @param number $gid
 * @param number $num
 * @param number $limit
 */
function member_get_local($lng, $lat, $gid=0, $num=50, $limit=0){
	
}

/**
 * 获取单用户统计数据
 * @param int $uid
 */
function member_get_count($uid){
	return M('member_count')->where(array('uid'=>$uid))->selectOne();
}

/**
 * 更新用户统计数据
 * @param int $uid
 * @param array $data
 */
function member_update_count($uid,$data){
	if (isset($data['uid'])){
		$data['uid'] = $uid;
	}
	return M('member_count')->where(array('uid'=>$uid))->update($data);
}

/**
 * 获取用户基本资料
 * @param int $uid
 */
function member_get_profile($uid){
	return M('member_profile')->where(array('uid'=>$uid))->selectOne();
}

/**
 * 更新用户个人资料
 * @param int $uid
 * @param array $data
 */
function member_update_profile($uid,$data){
	if (isset($data['uid'])){
		$data['uid'] = $uid;
	}
	return M('member_profile')->where(array('uid'=>$uid))->update($data);
}

/**
 * 获取用户状态信息
 * @param int $uid
 */
function member_get_status($uid){
	return M('member')->where(array('uid'=>$uid))->selectOne();
}

/**
 * 更新用户状态信息
 * @param int $uid
 * @param array $data
 */
function member_update_status($uid,$data){
	if (isset($data['uid'])){
		$data['uid'] = $uid;
	}
	return M('member_status')->where(array('uid'=>$uid))->update($data);
}

/**
 * 获取用户积分
 * @param int $uid
 */
function member_get_score($uid){
	$score = M('member_score')->where(array('uid'=>$uid))->selectOne();
	if (!$score){
		M('member_score')->insert(array('uid'=>$uid,'score'=>0));
		return member_get_score($uid);
	}else {
		return $score;
	}
}

/**
 * 更新用户积分
 * @param int $uid
 * @param array $data
 */
function member_update_score($uid,$data){
	if (isset($data['uid'])){
		$data['uid'] = $uid;
	}
	return M('member_score')->where(array('uid'=>$uid))->update($data);
}