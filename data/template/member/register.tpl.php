<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div id="member">
	<h3 class="title">注册<?php echo $G['setting']['sitename'];?></h3>
    <form method="post" id="registerForm" autocomplete="off">
   <input type="hidden" name="formsubmit" value="yes">
   <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
   <div class="titleRow">用户名</div>
    <div class="itemRow">
        <div class="input"><input type="text" class="textinput" id="register_username" name="username_<?php echo FORMHASH;?>" placeholder="请输入用户名:"></div>
         <div class="tips" id="tips_username" text="可输入中文,英文字母,数字和下划线，至少2个字"></div>
    </div>
    <div class="titleRow">邮箱</div>
    <div class="itemRow">
         <div class="input"><input type="text" class="textinput" id="register_email" maxlength="50" name="email_<?php echo FORMHASH;?>" placeholder="请输入邮箱:"></div>
         <div class="tips" id="tips_email" text="请输入你的邮箱，推荐使用163邮箱"></div>
    </div>
    <div class="titleRow">密码</div>
    <div class="itemRow">
        <div class="input"><input type="password" class="textinput" id="register_password" name="password_<?php echo FORMHASH;?>" placeholder="请输入密码:"></div>
        <div class="tips" id="tips_password" text="可使用字母、数字和符号，6-20位之间"></div>
    </div>
    <div class="titleRow">验证码</div>
    <div id="captcha"><img src="/?m=common&a=captcha" style="display:none;" id="codeimage" onclick="this.src='/?m=common&a=captcha&hash='+Math.random();"></div>
    <div class="itemRow">
        <div class="input"><input type="text" class="textinput" id="register_captchacode" name="captchacode" placeholder="请输入验证码:"></div>
        <div class="tips" id="tips_captchacode" text="验证码"></div>
    </div>
    <div class="blank"></div>
    <div class="itemRow">
        <button type="button" class="submitButton" id="submitButton">立即注册</button>　
        <a href="/?m=member&c=login">已有账号点此登录</a>
    </div>
    </form>
</div>
<script type="text/javascript">
(function(){
	$(".itemRow").each(function(index, element) {
        $(element).find(".textinput").bind('focus',function(){
			var tips = $(element).find(".tips");
			tips.text(tips.attr('text')).removeClass('error').show();
		}).bind('blur',function(){
			$(element).find(".tips").hide();
		});
    });
	$("#submitButton").click(function(){
		var username    = $("#register_username").val();
		var email       = $("#register_email").val();
		var password    = $("#register_password").val();
		var captchacode = $("#register_captchacode").val();
		var checksubmit = true;
		if(username.length<2 || !(/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/i).test(username)){
			$("#tips_username").addClass('error').text("<?php echo $lang['username_verify_failed'];?>").show();
			checksubmit = false;
		}else {
			if(verifyusername(username)){
				$("#tips_username").addClass('error').text("<?php echo $lang['username_exists'];?>").show();
				checksubmit = false;
			}else {
				$("#tips_username").removeClass('error').hide();
			}
		}
		if(!email || !DSXCMS.IsEmail(email)){
			$("#tips_email").addClass('error').text("<?php echo $lang['email_verify_failed'];?>").show();
			checksubmit = false;
		}else {
			if(verifyemail(email)){
				checksubmit = false;
				$("#tips_email").addClass('error').text("<?php echo $lang['email_exists'];?>").show();
			}else {
				$("#tips_email").removeClass('error').hide();
			}
		}
		if(!DSXCMS.IsPassword(password)){
			$("#tips_password").addClass('error').text("<?php echo $lang['password_verfy_failed'];?>").show();
			checksubmit = false;
		}else {
			$("#tips_password").removeClass('error').hide();
		}
		if(captchacode.length != 4){
			$("#tips_captchacode").addClass('error').text("<?php echo $lang['captchacode_verify_failed'];?>").show();
			checksubmit = false;
		}else {
			$("#tips_captchacode").removeClass('error').hide();
		}
		if(checksubmit){
			$("#registerForm").submit();
		}else{
			return false;
		}
	});
	$("#register_captchacode").focus(function(){$("#codeimage").show();});
})();
function verifyusername(username){
	var verify;
	$.ajax({
		url:'/?m=member&c=register&a=verifyusername&username='+username,
		async:false,
		success: function(response){
			verify = parseInt(response);
		}
	});
	return verify;
}

function verifyemail(email){
	var verify;
	$.ajax({
		url:'/?m=member&c=register&a=verifyemail&email='+email,
		async:false,
		success: function(response){
			verify = parseInt(response);
		}
	});
	return verify;
}
</script><?php include template('footer_common'); ?>