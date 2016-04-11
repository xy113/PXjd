<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('weixin_header'); ?><div id="member">
	<h1>登录盘县禁毒会员系统</h1>
    <form method="post" id="memberForm" action="/?m=weixin&c=member&a=login">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <input type="hidden" name="continue" value="<?php echo $continue;?>">
	<div class="item"><input type="text" id="account" name="account_<?php echo FORMHASH;?>" class="input-text" placeholder="用户名/手机号/邮箱"></div>
    <div class="item"><input type="password" id="password" name="password_<?php echo FORMHASH;?>" class="input-text" placeholder="密码"></div>
    <div class="item"><input type="text" id="captchacode" name="captchacode" class="input-text captcha" placeholder="验证码">
    <img src="/?m=common&a=captcha" height="40" onclick="this.src='/?m=common&a=captcha&hash='+Math.random();"></div>
    <div class="item"><button class="login-button" type="submit">登录</button></div>
    <div class="item" style="margin-top:30px; text-align:center;"><a href="/?m=weixin&c=member&a=register" style="font-size:16px; color:#39C;">注册新账号</a></div>
    </form>
</div>
<script type="text/javascript">
$("#memberForm").submit(function(){
	if(!$("#account").val()){
		alert('请输入账号');
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