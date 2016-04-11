<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大师兄内容管理系统管理中心</title>
<style type="text/css">
body {padding:0; margin:0; font:12px Arial; background-color:#f0f0f0; background-size:100% 100%;}
a:link,a:active,a:visited{color:#333333; text-decoration:none;}
a:hover{color:#FF0000; text-decoration:underline;}
.login-wrap{background:#fff; border-radius:3px; margin:100px auto; width:400px; box-shadow:0 3px 5px #333;}
.login-wrap .title{font-size:20px; margin:0 0 10px 0; padding:20px 0; text-align:center; border-radius:5px 5px 0 0; border-bottom:1px #eee solid;}
.login-wrap .item{padding:15px 0; text-align:center;}
.login-wrap .input-text{font-size:14px; width:260px; font-weight:bold; padding:5px 0; border:1px #ccc solid; border-radius:3px; height:30px; text-align:center;}
.login-wrap .button{width:270px; height:40px; line-height:40px; margin-bottom:20px; cursor:pointer; font-size:16px; font-weight:bold; background:#C30; border-radius:3px; color:#fff; text-align:center; display:inline-block;}
.login-wrap .button:hover{background:#C03;}
.copyright,.copyright *,.copyright a{margin-top:100px; text-align:center; font:400 12px Arial; color:#fff;}
</style>
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<link rel="icon" href="/static/images/common/favicon.ico" />
</head>
<body style="background:url(<?php echo $background;?>);">
<div class="login-wrap">
	<form method="post" id="formlogin" action="/?m=admin&c=login">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
	<h1 class="title">大师兄CMS后台管理中心</h1>
    <div class="item"><input type="text" name="username" class="input-text" value="<?php echo $G['account']['username'];?>"></div>
    <div class="item"><input type="password" name="password" class="input-text" placeholder="密码"></div>
    <div class="item"><div class="button" tabindex="1" id="button-login">登录</div></div>
    </form>
</div>
<script type="text/javascript">
$("#button-login").click(function(){
	var form = $("#formlogin");
	var password = form.find("input[name=password]").val();
	if(password.length>5 && password.length<16){
		form.ajaxSubmit({
			dataType:'json',
			success:function(json){
				if(json.errno == 0){
					window.location.reload();
				}else{
					alert("密码错误");
				}
			}
		});
	}
});
</script>
<p class="copyright">&copy;2016 <a href="http://www.songdewei.com" target="_blank">贵州大师兄信息技术有限公司</a> 版权所有，并保留所有权利。</p>
</body>
</html>