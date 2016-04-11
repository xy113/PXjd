<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $G['title'];?> - <?php echo $G['setting']['sitename'];?></title>
<meta name="keywords" content="<?php echo $G['keywords'];?>">
<meta name="description" content="<?php echo $G['description'];?>">
<link rel="icon" href="/static/images/common/favicon.ico">
<link rel="stylesheet" type="text/css" href="/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/static/css/style.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
<script src="/static/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</head>
<body>
<div class="area banner">
  <embed width="980" height="180" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="/static/swf/top.swf">
</div><?php $navlist=cache('nav'); ?><div class="area nav-hd">
    <ul class="mainNav">
        <li><a href="/">首页</a></li>
        <?php if(is_array($navlist['top'])) { foreach($navlist['top'] as $list) { ?>        <li><a href="<?php echo $list['url'];?>"><?php echo $list['title'];?></a></li>
        <?php } } ?>    </ul>
</div>
<div class="area subnav">
    <div class="right">
        <?php if($G['islogined']) { ?>
        <div class="menu"><a href="/?m=home"><?php echo $G['username'];?></a></div>
        <?php if($G['account']['admincp']) { ?><div class="menu"><a href="/?m=admin&c=login">后台管理</a></div><?php } ?>
        <div class="menu"><a href="/?m=member&c=logout">安全退出</a></div>
        <?php } else { ?>
        <div class="menu"><a href="/?m=member&c=login">登录</a></div>
        <div class="menu"><a href="/?m=member&c=register">注册</a></div>
        <?php } ?>
    </div>
    <!--<a href="javascript:;"><i class="icon">&#xf00a2;</i>手机版</a>-->
    <div id="thetimer"></div>
</div>
<script>setInterval("document.getElementById('thetimer').innerHTML='今天是：'+new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);</script>