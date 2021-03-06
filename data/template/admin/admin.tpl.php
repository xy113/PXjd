<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大师兄CMS后台管理中心</title>
<link href="/static/images/common/favicon.ico" rel="icon" />
<link rel="stylesheet" type="text/css" href="/static/css/admincp.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
</head>

<body style="overflow:hidden;">
<div class="header">
    <div class="item account" id="account">
        <a href="/?m=admin" class="menuitem">您好,<?php echo $G['account']['username'];?> <img src="/?m=member&c=avatar&size=small&uid=<?php echo $G['uid'];?>" border="0" /></a>
        <ul class="profile">
            <li>
            	<div class="atvar"><a href="/?m=home"><img src="/?m=member&c=avatar&size=big&uid=<?php echo $G['uid'];?>" /></a></div>
                <div class="actions">
                	<p><?php echo $G['account']['username'];?></p>
                <p><a href="/?m=home#profile" target="_blank">编辑个人资料</a></p>
                <p><a href="/?m=admin&c=logout" target="_top">退出登录</a></p>
                </div>
            </li>
		</ul>
	</div>
    <div class="item" id="home">
        <a href="/?m=admin" class="menuitem"><i class="icon">&#xf012b;</i>HOME</a>
        <ul class="submenu">
            <li><a href="/" target="_blank">站点首页</a></li>
            <li><a href="#">关于我们</a></li>
            <li><a href="#">技术支持</a></li>
            <li><a href="#">开发文档</a></li>
        </ul>
    </div>
    <div class="item"  id="addnew">
        <a href="javascript:;" class="menuitem"><i class="icon">&#xf0175;</i>新建</a>
        <ul class="submenu">
            <li><a href="/?m=admin&c=post&a=publish" target="main">文章</a></li>
            <li><a href="/?m=admin&c=page&a=publish" target="main">页面</a></li>
            <li><a href="/?m=admin&c=link" target="main">链接</a></li>
        </ul>
    </div>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintab">
  <tr>
    <td id="leftmenu">
    	<h3><a href="javascript:;"><i class="icon">&#xf013e;</i>系统设置</a></h3>
       <ul>
          <li><a rel="item" href="/?m=admin&c=setting&a=basic" target="main">基本设置</a></li>
          <li><a rel="item" href="/?m=admin&c=setting&a=optimiz" target="main">优化设置</a></li>
          <li><a rel="item" href="/?m=admin&c=setting&a=register" target="main">注册设置</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf012d;</i>用户管理</a></h3>
      <ul>
          <li><a rel="item" href="/?m=admin&c=member" target="main">所有会员</a></li>
          <li><a rel="item" href="/?m=admin&c=usergroup" target="main">分组管理</a></li>
          <li><a rel="item" href="/?m=admin&c=usertag" target="main">标签管理</a></li>
          <li><a rel="item" href="/?m=admin&c=sign" target="main">签到记录</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf003f;</i>APP设置</a></h3>
      <ul>
          <li><a rel="item" href="/?m=admin&c=ad&a=grouplist" target="main">广告分组</a></li>
          <li><a rel="item" href="/?m=admin&c=ad&a=showlist" target="main">广告管理</a></li>
          <li><a rel="item" href="/?m=admin&c=usertag" target="main">标签管理</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf00b9;</i>界面管理</a></h3>
      <ul>
          <li><a rel="item" href="/?m=admin&c=nav" target="main">导航设置</a></li>
          <li><a rel="item" href="/?m=admin&c=ad&a=showlist" target="main">广告管理</a></li>
          <li><a rel="item" href="/?m=admin&c=usertag" target="main">标签管理</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf0130;</i>信息管理</a></h3>
      <ul>
      	   <li><a rel="item" href="/?m=admin&c=post&a=publish&type=article" target="main">发布文章</a></li>
          <li><a rel="item" href="/?m=admin&c=post&a=publish&type=video" target="main">发布视频</a></li>
          <li><a rel="item" href="/?m=admin&c=post&a=publish&type=image" target="main">发布图片</a></li>
          <li><a rel="item" href="/?m=admin&c=post&a=showlist" target="main">信息列表</a></li>
          <li><a rel="item" href="/?m=admin&c=post&a=showlist&status=-1" target="main">待审文章</a></li>
          <li><a rel="item" href="/?m=admin&c=category&type=article" target="main">分类管理</a></li>
          <li><a rel="item" href="/?m=admin&c=comment" target="main">评论管理</a></li>
          <li><a rel="item" href="/?m=admin&c=posttag" target="main">标签管理</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf01ec;</i>考试系统</a></h3>
      <ul>
          <li><a rel="item" href="/?m=admin&c=exam&a=setting" target="main">参数设置</a></li>
          <li><a rel="item" href="/?m=admin&c=exam&a=paper" target="main">试卷设置</a></li>
          <li><a rel="item" href="/?m=admin&c=exam&a=examinee" target="main">考生列表</a></li>
          <li><a rel="item" href="/?m=admin&c=research&a=paper" target="main">调查问卷</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf01ba;</i>页面管理</a></h3>
      <ul>
          <li><a rel="item" href="/?m=admin&c=page" target="main">所有页面</a></li>
          <li><a rel="item" href="/?m=admin&c=page&a=publish" target="main">新建页面</a></li>
          <li><a rel="item" href="/?m=admin&c=page&a=category" target="main">页面分类</a></li>
      </ul>
      <h3><a href="javascript:;"><i class="icon">&#xf0034;</i>其他</a></h3>
      <ul>
      	   <li><a rel="item" href="/?m=admin&c=photo" target="main">照片管理</a></li>
          <li><a rel="item" href="/?m=admin&c=attach" target="main">附件管理</a></li>
          <li><a rel="item" href="/?m=admin&c=district" target="main">地区管理</a></li>
          <li><a rel="item" href="/?m=admin&c=link" target="main">友情链接</a></li>
      </ul>
	</td>
    <td class="mainframe" id="mainframe" valign="top"><iframe name="main" id="iframe" frameborder="0" style="height:100%; width:100%;" src="/?m=admin&c=about"></iframe></td>
  </tr>
</table>
<script type="text/javascript">
$("#mainframe").height($(document).height()-30);
$("#iframe").height($(document).height()-30);
$(".item").mouseenter(function(){$(this).addClass("cur").find("ul").show();}).mouseleave(function(){$(this).removeClass("cur").find("ul").hide();});
$("#leftmenu h3").click(function(){
	var ul = $(this).siblings("ul")[$(this).index("h3")];
	if($(ul).is(":visible")){
		$(ul).slideUp('fast');
	}else {
		$(ul).slideDown('fast');
	}
});
$("a[rel=item]").click(function(){
	$("a[rel=item]").removeClass('on');
	$(this).addClass('on');
});
</script>
</body>
</html>