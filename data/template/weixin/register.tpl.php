<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="member">
	<h1>注册盘县禁毒会员系统</h1>
    <form method="post" id="memberForm" action="/?m=weixin&c=member&a=register">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <input type="hidden" name="continue" value="<?php echo $continue;?>">
    <div class="item"><input type="text" id="username" name="username_<?php echo FORMHASH;?>" class="input-text" placeholder="用户名"></div>
	<div class="item"><input type="text" id="mobile" name="mobile_<?php echo FORMHASH;?>" class="input-text" placeholder="手机号"></div>
    <div class="item"><input type="password" id="password" name="password_<?php echo FORMHASH;?>" class="input-text" placeholder="密码"></div>
    <div class="item"><input type="text" id="captchacode" name="captchacode" class="input-text captcha" placeholder="验证码">
    <img src="/?m=common&a=captcha" height="40" onclick="this.src='/?m=common&a=captcha&hash='+Math.random();"></div>
    <div class="item"><button class="login-button" type="submit">提交</button></div>
    </form>
</div>
<script type="text/javascript">
$("#memberForm").submit(function(){
	if(!$("#username").val()){
		alert('请输入用户名');
		return false;
	}
	if(!$("#mobile").val()){
		alert('请输入手机号');
		return false;
	}
	
	if(!$("#password").val()){
		alert('请输入密码');
		return false;
	}
	
	if(!$("#captchacode").val()){
		alert('请输入验证码');
		return false;
	}
	return true;
});
</script><?php include template('weixin_footer'); ?>