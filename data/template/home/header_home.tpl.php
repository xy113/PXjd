<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php if($G['title']) { ?><?php echo $G['title'];?> - <?php } ?>个人中心 - <?php echo $G['setting']['sitename'];?></title>
<meta name="keywords" content="<?php echo $G['setting']['keywords'];?>">
<meta name="description" content="<?php echo $G['setting']['description'];?>">
<link rel="icon" href="/static/images/common/favicon.ico">
<link rel="stylesheet" type="text/css" href="/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/static/css/home.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
<script src="/static/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</head>
<body id="homebody">
<div class="home-header">
	<div class="area header">
    	<div class="topnav">
        	 <div class="menu"><a href="/">首页</a></div>
            <?php if($G['islogined']) { ?>
            <div class="menu"><a href="/?m=home"><?php echo $G['username'];?></a></div>
            <div class="menu"><a href="/?m=member&c=logout">安全退出</a></div>
            <?php } else { ?>
            <div class="menu"><a href="/?m=member&c=login">登录</a></div>
            <div class="menu"><a href="/?m=member&c=register">注册</a></div>
            <?php } ?>
            <div class="menu"><a href="/?c=home&a=favorite" target="_blank">我的收藏</a></div>
        </div>
    	<h1 class="bigtitle">个人管理中心</h1>
    </div>
</div>
<div class="area" id="home"><?php include template('leftnav'); ?>