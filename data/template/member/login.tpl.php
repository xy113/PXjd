<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div id="member" class="area">
	<h3 class="title">登录<?php echo $G['setting']['sitename'];?></h3>
    <form method="post" id="loginForm" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    <div class="titleRow">账号</div>
    <div class="itemRow">
        <div class="input"><input type="text" class="textinput" id="login_account" name="account_<?php echo FORMHASH;?>" placeholder="用户名/邮箱/手机号"></div>
        <div class="tips error" id="tips_account">账号输入错误</div>
    </div>
    <div class="titleRow">密码</div>
    <div class="itemRow">
        <div class="input"><input type="password" class="textinput" id="login_password" name="password_<?php echo FORMHASH;?>" placeholder="请输入您的密码"></div>
        <div class="tips error" id="tips_password">密码输入错误</div>
    </div>
    <div class="titleRow">验证码</div>
    <div id="captcha"><img src="/?m=common&a=captcha" style="display:none;" id="codeimage" onclick="this.src='/?m=common&a=captcha&hash='+Math.random();"></div>
    <div class="itemRow">
        <div class="input"><input type="text" class="textinput" id="login_captchacode" name="captchacode" placeholder="请输入您的密码"></div>
        <div class="tips error" id="tips_captchacode">验证码输入错误</div>
    </div>
    <div class="blank"></div>
    <div class="itemRow">
        <button type="button" class="submitButton" id="btnlogin">登录</button>　
        <a href="/?m=member&c=resetpass">忘记密码?</a>　
        <a href="/?m=member&c=register">注册新账号</a>
    </div>
    </form>
</div>
<script type="text/javascript">
(function(){
	
$("#btnlogin").click(function(){
	var account     = $("#login_account").val();
	var password    = $("#login_password").val();
	var captchacode = $("#login_captchacode").val();
	if(account.length < 2){
		$("#tips_account").show();
		return false;
	}else{
		$("#tips_account").hide();
	}
	if(!DSXCMS.IsPassword(password)){
		$("#tips_password").show();
		return false;
	}else{
		$("#tips_password").hide();
	}
	if(captchacode.length != 4){
		$("#tips_captchacode").show();
		return false;
	}else{
		$("#tips_captchacode").hide();
	}
	$("#loginForm").submit();
});
$("#login_password").focus(function(){$(this).val('');});
$("#login_captchacode").focus(function(){$("#codeimage").show()});
})();
</script><?php include template('footer_common'); ?>